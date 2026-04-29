# integrations.md — Intégrations Externes
# Conseil & Gestion des rituels du spa by Camille Becht

> Ce fichier documente toutes les intégrations externes du site :
> Calendly, Airtable API, Brevo, Make webhooks et Telegram.
> Cursor doit s'y référer pour tout travail sur `inc/api-airtable.php`,
> `inc/ajax.php` et les templates qui embarquent des widgets tiers.
>
> Toutes les clés API et URLs de webhooks sont dans `wp-config.php` — jamais dans le thème.

---

## 1. Vue d'ensemble des intégrations

| Service | Usage | Direction | Fichier concerné |
|---|---|---|---|
| Calendly | Prise de RDV (embed iframe) | Tiers → visiteur | `template-contact.php`, `shared/cta-rdv.php` |
| Airtable | CRM leads, praticiens, missions | Site → Airtable | `inc/api-airtable.php` |
| Make | Orchestration des automations | Site → Make → tiers | `inc/ajax.php` |
| Brevo | Emails transactionnels | Make → Brevo → email | _(géré dans Make)_ |
| Telegram | Notifications internes | Make → Telegram | _(géré dans Make)_ |

---

## 2. Calendly

### Usage
- Page `/contact/` : widget de prise de RDV principal (iframe pleine largeur)
- Composant `shared/cta-rdv.php` : widget inline léger sur pages offres
- Popup optionnelle sur résultat du diagnostic (niveau B et C)

### Intégration iframe (méthode recommandée)

```php
// template-parts/shared/cta-rdv.php
<?php
$calendly_url = defined('CBS_CALENDLY_URL') ? CBS_CALENDLY_URL : '';
if ( ! $calendly_url ) return;
?>
<div class="calendly-wrapper">
    <div class="calendly-inline-widget"
         data-url="<?php echo esc_url( $calendly_url ); ?>?hide_gdpr_banner=1&primary_color=c9a84c"
         style="min-width:320px; height:700px;">
    </div>
</div>
```

### Chargement conditionnel du script Calendly

```php
// inc/enqueue.php
// Le script Calendly ne se charge QUE sur les pages qui en ont besoin
function cbs_enqueue_calendly(): void {
    if ( is_page('contact') || is_page_template('template-contact.php') ) {
        wp_enqueue_script(
            'calendly-widget',
            'https://assets.calendly.com/assets/external/widget.js',
            [],
            null,
            true // footer
        );
    }
}
add_action( 'wp_enqueue_scripts', 'cbs_enqueue_calendly' );
```

> **Pourquoi conditionnel ?** Le script Calendly est lourd (~200kb).
> Le charger sur toutes les pages dégrade le score Lighthouse.

### Constante wp-config.php

```php
define( 'CBS_CALENDLY_URL', 'https://calendly.com/[slug-camille]/echange-decouverte' );
```

### Webhook Calendly → Make

Calendly envoie un webhook à Make à chaque RDV pris.
Configuration dans Calendly : **Integrations → Webhooks → Add new webhook**.

```
URL      : https://hook.make.com/[id_scenario_s4]
Events   : invitee.created, invitee.canceled
Signing  : activer + stocker la clé dans wp-config.php si vérification côté Make
```

> La vérification de signature est gérée dans Make (pas dans le thème).
> Voir `automations.md` §6 (Scénario S4) pour le traitement du webhook.

---

## 3. Airtable API

### Configuration

```php
// wp-config.php
define( 'CBS_AIRTABLE_API_KEY',  'pat_xxxxxxxxxxxx' ); // Personal Access Token
define( 'CBS_AIRTABLE_BASE_ID',  'appXXXXXXXXXXXXXX' );
```

> Utiliser un **Personal Access Token** Airtable (pas l'ancienne API Key dépréciée).
> Scopes nécessaires : `data.records:read`, `data.records:write`.
> Créer le token sur : https://airtable.com/create/tokens

### Tables et IDs

Les IDs de tables sont récupérés depuis l'URL Airtable (`tblXXXXXXXXXXXXXX`).

```php
// wp-config.php
define( 'CBS_AIRTABLE_TABLE_DIAGNOSTICS', 'tblXXXXXXXXXXXXXX' );
define( 'CBS_AIRTABLE_TABLE_MISSIONS',    'tblXXXXXXXXXXXXXX' );
define( 'CBS_AIRTABLE_TABLE_PRATICIENS',  'tblXXXXXXXXXXXXXX' );
```

### Fichier `inc/api-airtable.php`

```php
<?php
/**
 * CBS — Airtable API
 * Fonctions d'envoi et de lecture vers Airtable.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Envoie un enregistrement dans une table Airtable.
 *
 * @param string $table_id  ID de la table (ex: CBS_AIRTABLE_TABLE_DIAGNOSTICS)
 * @param array  $fields    Champs à enregistrer (noms exacts des colonnes Airtable)
 * @return array|WP_Error   Réponse Airtable décodée ou WP_Error
 */
function cbs_send_to_airtable( string $table_id, array $fields ) {
    if ( ! defined('CBS_AIRTABLE_API_KEY') || ! defined('CBS_AIRTABLE_BASE_ID') ) {
        return new WP_Error( 'missing_config', 'Airtable non configuré.' );
    }

    $url  = 'https://api.airtable.com/v0/' . CBS_AIRTABLE_BASE_ID . '/' . $table_id;
    $body = wp_json_encode( [ 'fields' => $fields ] );

    $response = wp_remote_post( $url, [
        'headers' => [
            'Authorization' => 'Bearer ' . CBS_AIRTABLE_API_KEY,
            'Content-Type'  => 'application/json',
        ],
        'body'    => $body,
        'timeout' => 15,
    ]);

    if ( is_wp_error( $response ) ) {
        return $response;
    }

    $code = wp_remote_retrieve_response_code( $response );
    $data = json_decode( wp_remote_retrieve_body( $response ), true );

    if ( $code !== 200 ) {
        return new WP_Error(
            'airtable_error',
            $data['error']['message'] ?? 'Erreur Airtable inconnue.',
            [ 'status' => $code ]
        );
    }

    return $data;
}

/**
 * Met à jour un enregistrement existant dans Airtable.
 *
 * @param string $table_id    ID de la table
 * @param string $record_id   ID de l'enregistrement (recXXXXXXXXXXXXXX)
 * @param array  $fields      Champs à mettre à jour
 * @return array|WP_Error
 */
function cbs_update_airtable_record( string $table_id, string $record_id, array $fields ) {
    if ( ! defined('CBS_AIRTABLE_API_KEY') || ! defined('CBS_AIRTABLE_BASE_ID') ) {
        return new WP_Error( 'missing_config', 'Airtable non configuré.' );
    }

    $url  = 'https://api.airtable.com/v0/' . CBS_AIRTABLE_BASE_ID
          . '/' . $table_id . '/' . $record_id;

    $response = wp_remote_request( $url, [
        'method'  => 'PATCH',
        'headers' => [
            'Authorization' => 'Bearer ' . CBS_AIRTABLE_API_KEY,
            'Content-Type'  => 'application/json',
        ],
        'body'    => wp_json_encode( [ 'fields' => $fields ] ),
        'timeout' => 15,
    ]);

    if ( is_wp_error( $response ) ) {
        return $response;
    }

    return json_decode( wp_remote_retrieve_body( $response ), true );
}

/**
 * Recherche un enregistrement par valeur de champ.
 *
 * @param string $table_id    ID de la table
 * @param string $field_name  Nom du champ (ex: "Email")
 * @param string $value       Valeur recherchée
 * @return array|null         Premier enregistrement trouvé ou null
 */
function cbs_find_airtable_record( string $table_id, string $field_name, string $value ): ?array {
    if ( ! defined('CBS_AIRTABLE_API_KEY') || ! defined('CBS_AIRTABLE_BASE_ID') ) {
        return null;
    }

    $formula = urlencode( "{$field_name}='" . addslashes( $value ) . "'" );
    $url     = 'https://api.airtable.com/v0/' . CBS_AIRTABLE_BASE_ID
             . '/' . $table_id . '?filterByFormula=' . $formula . '&maxRecords=1';

    $response = wp_remote_get( $url, [
        'headers' => [
            'Authorization' => 'Bearer ' . CBS_AIRTABLE_API_KEY,
        ],
        'timeout' => 15,
    ]);

    if ( is_wp_error( $response ) ) {
        return null;
    }

    $data    = json_decode( wp_remote_retrieve_body( $response ), true );
    $records = $data['records'] ?? [];

    return ! empty( $records ) ? $records[0] : null;
}
```

### Utilisation dans `inc/ajax.php`

```php
// Exemple — soumission du diagnostic
$result = cbs_send_to_airtable(
    CBS_AIRTABLE_TABLE_DIAGNOSTICS,
    [
        'Prénom'           => $prenom,
        'Nom'              => $nom,
        'Hôtel / Société'  => $hotel,
        'Email'            => $email,
        'Téléphone'        => $telephone,
        'Type de projet'   => $type_projet,
        'Score'            => $score,
        'Niveau'           => $niveau,
        'Réponses'         => implode( ',', $reponses ),
        'Date'             => current_time( 'Y-m-d H:i:s' ),
        'Statut lead'      => 'Nouveau',
        'RDV pris'         => false,
        'Source'           => 'Diagnostic site',
    ]
);

if ( is_wp_error( $result ) ) {
    // Logger l'erreur sans bloquer l'UX
    error_log( 'Airtable error: ' . $result->get_error_message() );
}
```

> **Important :** les noms des champs dans `$fields` doivent correspondre
> EXACTEMENT aux noms des colonnes dans Airtable (casse et accents compris).

---

## 4. Make — Webhooks sortants

### Fonction d'envoi (`inc/ajax.php`)

Déjà documentée dans `automations.md` §2. Rappel de la configuration :

```php
// wp-config.php — une constante par scénario Make
define( 'CBS_MAKE_WEBHOOK_DIAGNOSTIC_COMPLETED', 'https://hook.make.com/xxx' );
define( 'CBS_MAKE_WEBHOOK_CONTACT_FORM',         'https://hook.make.com/xxx' );
```

### Sécurisation des webhooks Make

Make peut vérifier que les requêtes viennent bien du site (optionnel mais recommandé).

```php
// wp-config.php
define( 'CBS_MAKE_WEBHOOK_SECRET', 'votre_secret_partage_ici' );

// inc/ajax.php — ajout du header de signature
function cbs_trigger_make_webhook( string $event, array $data ): void {
    $webhook_url = defined( 'CBS_MAKE_WEBHOOK_' . strtoupper( $event ) )
        ? constant( 'CBS_MAKE_WEBHOOK_' . strtoupper( $event ) )
        : null;

    if ( ! $webhook_url ) return;

    $payload   = wp_json_encode( array_merge( $data, [
        'event'     => $event,
        'timestamp' => current_time( 'c' ),
    ]));
    $signature = hash_hmac( 'sha256', $payload, CBS_MAKE_WEBHOOK_SECRET );

    wp_remote_post( $webhook_url, [
        'headers' => [
            'Content-Type'       => 'application/json',
            'X-CBS-Signature'    => $signature,
        ],
        'body'    => $payload,
        'timeout' => 10,
        'blocking'=> false,
    ]);
}
```

---

## 5. Brevo (emails transactionnels)

### Usage
Brevo est appelé depuis Make — pas directement depuis le thème WordPress.
Le thème déclenche Make via webhook → Make appelle l'API Brevo.

### Configuration Make → Brevo
Dans Make, module **Brevo** :
```
Connection : [clé API Brevo dans Make]
Action     : Send a transactional email
```

### Templates Brevo à créer

| ID template | Nom | Scénario |
|---|---|---|
| `tpl_lead_magnet_a` | Lead Magnet Niveau A | S3 |
| `tpl_lead_magnet_b` | Lead Magnet Niveau B | S3 |
| `tpl_lead_magnet_c` | Lead Magnet Niveau C | S3 |
| `tpl_relance_a` | Relance H+24 Niveau A | S2 |
| `tpl_relance_b` | Relance H+24 Niveau B | S2 |
| `tpl_relance_c` | Relance H+24 Niveau C | S2 |
| `tpl_notif_interne` | Notification interne diagnostic | S1 |
| `tpl_notif_rdv` | Notification interne RDV Calendly | S4 |
| `tpl_satisfaction_30j` | Questionnaire satisfaction | S5 |
| `tpl_avis_google` | Demande d'avis Google | S6 |

### Expéditeur à configurer dans Brevo
```
Nom      : Camille Becht — Conseil Spa
Email    : camille@[domaine-site].fr
Réponse  : camille@[domaine].fr
```

> Le domaine d'envoi doit être vérifié dans Brevo (DNS SPF + DKIM).
> À faire avant le premier envoi en production.

---

## 6. Telegram — Notifications internes

### Usage
Notifications rapides à Camille pour chaque événement clé.
Géré entièrement dans Make — pas d'appel Telegram depuis le thème.

### Mise en place du bot
1. Créer le bot via `@BotFather` sur Telegram
2. Nommer le bot : `CBS_Notifications_Bot` (ou nom au choix)
3. Récupérer le **token** du bot
4. Démarrer une conversation avec le bot → récupérer le **Chat ID**
5. Dans Make : module **Telegram Bot → Send a message**

```
Token   : [token BotFather]
Chat ID : [chat ID de Camille]
```

### Format des messages (rappel depuis `automations.md`)
```
Nouveau diagnostic   : 🏨 [prenom nom] — [hotel] · Score [x]/30 · Niveau [X]
RDV planifié         : 📅 [name] · [start_time]
Relance envoyée      : 📨 [prenom nom] — [hotel] · Score [x]/30
Alerte conformité    : ⚠️ [prenom_nom] · [type_document] · Expire le [date]
```

---

## 7. WP Mail SMTP — Emails WordPress

### Usage
WordPress envoie des emails natifs (notifications admin, formulaire contact).
Ces emails passent par Brevo via WP Mail SMTP pour éviter les spams.

### Configuration plugin WP Mail SMTP
```
Mailer       : Brevo (Sendinblue)
API Key      : [clé API Brevo]
From Email   : notifications@[domaine-site].fr
From Name    : Conseil Spa by Camille Becht
```

> **Attention :** utiliser une adresse `notifications@` différente de l'adresse
> principale de Camille pour éviter les confusions dans les boîtes de réception.

---

## 8. Récapitulatif des constantes wp-config.php

```php
// ============================================================
// CBS — Intégrations externes
// NE JAMAIS committer ce fichier ou exposer ces valeurs
// ============================================================

// Airtable
define( 'CBS_AIRTABLE_API_KEY',              'pat_xxxxxxxxxxxxxxxxxxxx' );
define( 'CBS_AIRTABLE_BASE_ID',              'appXXXXXXXXXXXXXX' );
define( 'CBS_AIRTABLE_TABLE_DIAGNOSTICS',    'tblXXXXXXXXXXXXXX' );
define( 'CBS_AIRTABLE_TABLE_MISSIONS',       'tblXXXXXXXXXXXXXX' );
define( 'CBS_AIRTABLE_TABLE_PRATICIENS',     'tblXXXXXXXXXXXXXX' );

// Calendly
define( 'CBS_CALENDLY_URL',
    'https://calendly.com/[slug-camille]/echange-decouverte' );

// Make webhooks
define( 'CBS_MAKE_WEBHOOK_DIAGNOSTIC_COMPLETED',
    'https://hook.make.com/xxxxxxxxxxxxxxxxxxxx' );
define( 'CBS_MAKE_WEBHOOK_CONTACT_FORM',
    'https://hook.make.com/xxxxxxxxxxxxxxxxxxxx' );
define( 'CBS_MAKE_WEBHOOK_SECRET',           'votre_secret_partage' );
```

---

## 9. Checklist de mise en place

**Airtable**
- [ ] Créer les 3 tables avec les champs documentés (`automations.md` §10)
- [ ] Générer un Personal Access Token avec les bons scopes
- [ ] Récupérer les IDs de base et de tables
- [ ] Renseigner les constantes dans `wp-config.php`
- [ ] Tester `cbs_send_to_airtable()` en staging

**Calendly**
- [ ] Créer le type d'événement "Échange découverte 30min"
- [ ] Récupérer l'URL de planification
- [ ] Configurer le webhook Calendly → Make
- [ ] Tester l'embed iframe sur `/contact/`
- [ ] Vérifier le chargement conditionnel du script

**Make**
- [ ] Créer les 7 scénarios (voir `automations.md`)
- [ ] Récupérer les URLs webhook de chaque scénario
- [ ] Renseigner les URLs dans `wp-config.php`
- [ ] Tester chaque scénario avec des données réelles en staging

**Brevo**
- [ ] Vérifier le domaine d'envoi (SPF + DKIM)
- [ ] Créer les 10 templates email listés au §5
- [ ] Configurer WP Mail SMTP
- [ ] Envoyer un email test

**Telegram**
- [ ] Créer le bot via BotFather
- [ ] Récupérer token + Chat ID
- [ ] Configurer le module Make → Telegram
- [ ] Tester une notification

---

*Référence : automations.md (scénarios complets), diagnostic-tunnel.md §8 (AJAX handler)*
