# error-handling.md — Gestion des Erreurs & Fallbacks API
# Conseil & Gestion des rituels du spa by Camille Becht

> Règles de gestion des erreurs pour tous les appels API externes
> (Airtable, Make, Brevo, Calendly) et les interactions utilisateur.
> Cursor doit appliquer ces patterns sur tout code qui touche à un service externe.

---

## 1. Principe fondamental

```
Règle d'or : une API externe peut toujours échouer.
             Le site doit continuer à fonctionner même si Airtable,
             Make ou Brevo ne répondent pas.

L'utilisateur ne doit JAMAIS voir :
  - Un message d'erreur technique brut
  - Un écran blanc
  - Une stack trace PHP
  - Une clé API ou une URL de webhook
```

---

## 2. Pattern standard — appel API externe

```php
// Pattern à appliquer sur TOUS les appels à cbs_send_to_airtable(),
// cbs_trigger_make_webhook(), et toute fonction externe.

function cbs_handle_diagnostic_submit(): void {
    check_ajax_referer( 'cbs_tunnel_nonce', 'nonce' );

    // 1. Valider et préparer les données
    $payload = cbs_validate_diagnostic_data( $_POST );
    if ( is_wp_error( $payload ) ) {
        wp_send_json_error([
            'message' => 'Données invalides. Veuillez réessayer.',
            'code'    => 'validation_failed',
        ], 400 );
    }

    // 2. Appel Airtable — non bloquant sur l'UX
    $airtable_result = cbs_send_to_airtable(
        CBS_AIRTABLE_TABLE_DIAGNOSTICS,
        $payload
    );

    if ( is_wp_error( $airtable_result ) ) {
        // Logger l'erreur sans bloquer l'utilisateur
        cbs_log_error( 'airtable', $airtable_result->get_error_message(), $payload );
        // On continue — l'UX ne doit pas dépendre d'Airtable
    }

    // 3. Webhook Make — non bloquant
    cbs_trigger_make_webhook( 'diagnostic_completed', $payload );
    // Pas de vérification d'erreur ici — wp_remote_post est non-bloquant

    // 4. Réponse utilisateur — toujours positive si les données sont valides
    wp_send_json_success([
        'score'  => $payload['Score'],
        'niveau' => $payload['Niveau'],
    ]);
}
```

---

## 3. Logging — fonction centralisée

```php
// inc/helpers.php

/**
 * Logger une erreur de manière structurée.
 * En prod : écrit dans wp-content/debug.log (si WP_DEBUG_LOG = true)
 * En dev  : écrit dans wp-content/debug.log ET affiche si WP_DEBUG = true
 *
 * @param string $context  Contexte de l'erreur ('airtable', 'make', 'calendly'...)
 * @param string $message  Message d'erreur
 * @param array  $data     Données contextuelles (sanitisées — jamais de clé API)
 */
function cbs_log_error( string $context, string $message, array $data = [] ): void {
    // Supprimer les données sensibles avant de logger
    $safe_data = array_diff_key( $data, array_flip([
        'email',      // optionnel selon RGPD
        'telephone',
        'api_key',
        'webhook_url',
    ]));

    $log_entry = sprintf(
        '[CBS][%s][%s] %s | Data: %s',
        strtoupper( $context ),
        current_time( 'Y-m-d H:i:s' ),
        $message,
        wp_json_encode( $safe_data )
    );

    error_log( $log_entry );
}
```

---

## 4. Fallbacks par service

### Airtable indisponible

```php
// Si Airtable échoue → logger + continuer
// En dernier recours : sauvegarder localement dans un post WordPress custom
// (optionnel — à implémenter si la perte de leads est inacceptable)

function cbs_fallback_save_lead( array $data ): void {
    wp_insert_post([
        'post_type'   => 'cbs-lead-fallback', // CPT non public
        'post_title'  => $data['Email'] ?? 'Lead sans email',
        'post_status' => 'private',
        'meta_input'  => [
            '_cbs_lead_data' => wp_json_encode( $data ),
            '_cbs_lead_date' => current_time( 'Y-m-d H:i:s' ),
        ],
    ]);
}
```

### Make webhook indisponible

```php
// wp_remote_post en mode non-bloquant (blocking: false)
// ne retourne pas d'erreur vérifiable — c'est voulu.
// Make doit être configuré pour réessayer (retry) en cas d'échec.
// Dans Make : activer "Scheduling" + "Incomplete executions" sur chaque scénario.
```

### Calendly widget non chargé

```html
<!-- template-parts/shared/cta-rdv.php -->
<!-- Fallback si Calendly ne charge pas -->
<div class="calendly-wrapper">
    <div class="calendly-inline-widget" data-url="<?php echo esc_url( $calendly_url ); ?>">
    </div>
    <noscript>
        <p class="calendly-fallback">
            Pour prendre rendez-vous, contactez directement Camille :
            <a href="mailto:camille@[domaine].fr">camille@[domaine].fr</a>
        </p>
    </noscript>
</div>
```

---

## 5. Messages d'erreur utilisateur

```
Règle : messages courts, humains, actionnables.
        Jamais de jargon technique, jamais de code d'erreur brut.
```

```php
// inc/helpers.php — messages d'erreur standardisés
function cbs_get_user_error_message( string $code ): string {
    $messages = [
        'rate_limited'      => 'Trop de tentatives. Réessayez dans une heure.',
        'validation_failed' => 'Certaines informations semblent incorrectes. Vérifiez et réessayez.',
        'server_error'      => 'Une erreur est survenue. Si le problème persiste, contactez-nous directement.',
        'network_error'     => 'Problème de connexion. Vérifiez votre réseau et réessayez.',
        'timeout'           => 'La requête a pris trop de temps. Réessayez dans quelques instants.',
    ];

    return $messages[ $code ] ?? $messages['server_error'];
}
```

```javascript
// assets/js/tunnel.js — gestion des erreurs côté client
async function soumettreDiagnostic( formData ) {
    try {
        const response = await fetch( cbsAjax.url, {
            method: 'POST',
            body: formData,
            signal: AbortSignal.timeout( 15000 ) // timeout 15s
        });

        if ( ! response.ok ) {
            throw new Error( `HTTP ${response.status}` );
        }

        const data = await response.json();

        if ( data.success ) {
            afficherResultat( data.data.score, data.data.niveau );
        } else {
            afficherErreur( data.data?.message || 'Une erreur est survenue.' );
        }

    } catch ( error ) {
        if ( error.name === 'TimeoutError' ) {
            afficherErreur( 'La requête a pris trop de temps. Réessayez.' );
        } else if ( ! navigator.onLine ) {
            afficherErreur( 'Vérifiez votre connexion internet.' );
        } else {
            afficherErreur( 'Une erreur est survenue. Réessayez dans quelques instants.' );
        }
        // Logger côté client pour debug (pas en prod)
        if ( window.cbsDebug ) console.error( '[CBS Tunnel]', error );
    }
}
```

---

## 6. WP_DEBUG — configuration par environnement

```php
// wp-config.php — PRODUCTION
define( 'WP_DEBUG',         false );
define( 'WP_DEBUG_LOG',     true  ); // logs dans wp-content/debug.log
define( 'WP_DEBUG_DISPLAY', false ); // jamais affiché à l'écran
define( 'SCRIPT_DEBUG',     false );

// wp-config.php — DÉVELOPPEMENT
define( 'WP_DEBUG',         true  );
define( 'WP_DEBUG_LOG',     true  );
define( 'WP_DEBUG_DISPLAY', true  );
define( 'SCRIPT_DEBUG',     true  );
```

> Le fichier `wp-content/debug.log` doit être dans `.gitignore`.

---

## 7. Checklist gestion des erreurs

- [ ] Tous les appels `wp_remote_post/get` vérifiés avec `is_wp_error()`
- [ ] Toutes les erreurs loggées via `cbs_log_error()` — jamais avec `var_dump()`
- [ ] Aucun message d'erreur technique exposé à l'utilisateur
- [ ] Fallback en place si Airtable ne répond pas
- [ ] Timeout configuré sur tous les appels API externes (max 15s)
- [ ] `WP_DEBUG_DISPLAY` à `false` en production
- [ ] Retry configuré dans Make pour les scénarios critiques (S1, S3, S4)

---

*Référence : security.md §2 (rate limiting), automations.md §2 (webhooks)*
