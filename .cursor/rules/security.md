# security.md — Sécurité Avancée
# Conseil & Gestion des rituels du spa by Camille Becht

> Règles de sécurité applicables à tout le thème.
> Complète `wordpress-theme.md` §8 qui couvre les bases (nonces, sanitize, ABSPATH).
> Cursor doit appliquer ces règles sur tout endpoint AJAX, formulaire et appel API.

---

## 1. Clés API — règle absolue

```
❌ JAMAIS dans le code du thème
❌ JAMAIS dans un fichier versionné (.env committé, functions.php, inc/*.php)
❌ JAMAIS dans la base de données WordPress (options table)
✅ UNIQUEMENT dans wp-config.php (hors du dossier public si possible)
✅ wp-config.php dans .gitignore — toujours
```

**Template `.gitignore` obligatoire à la racine du projet :**
```
wp-config.php
.env
*.log
/wp-content/uploads/
/wp-content/upgrade/
node_modules/
.DS_Store
```

**Vérification en code — ne jamais faire confiance à une constante non définie :**
```php
// ✅ Toujours vérifier avant d'utiliser
function cbs_send_to_airtable( string $table_id, array $fields ): array|WP_Error {
    if ( ! defined('CBS_AIRTABLE_API_KEY') || ! defined('CBS_AIRTABLE_BASE_ID') ) {
        return new WP_Error( 'missing_config', 'Configuration Airtable manquante.' );
    }
    // ...
}
```

---

## 2. Rate limiting — endpoints AJAX

Le tunnel diagnostic et le formulaire contact sont des cibles de spam et de bots.
Implémenter un rate limiting côté serveur sur tous les endpoints `wp_ajax_nopriv_*`.

### Implémentation via transients WordPress

```php
// inc/ajax.php — à appeler en début de chaque handler AJAX public
function cbs_check_rate_limit( string $action, int $max = 5, int $window = 3600 ): bool {
    $ip         = sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? 'unknown' );
    $key        = 'cbs_rl_' . md5( $action . $ip );
    $count      = (int) get_transient( $key );

    if ( $count >= $max ) {
        return false; // limite atteinte
    }

    if ( $count === 0 ) {
        set_transient( $key, 1, $window );
    } else {
        set_transient( $key, $count + 1, $window );
    }

    return true;
}

// Usage dans le handler du diagnostic
function cbs_handle_diagnostic_submit(): void {
    check_ajax_referer( 'cbs_tunnel_nonce', 'nonce' );

    // Rate limit : 5 soumissions max par IP par heure
    if ( ! cbs_check_rate_limit( 'diagnostic', 5, 3600 ) ) {
        wp_send_json_error( [
            'message' => 'Trop de tentatives. Réessayez dans une heure.',
            'code'    => 'rate_limited',
        ], 429 );
    }

    // suite du traitement...
}
```

### Limites recommandées par endpoint

| Endpoint | Max requêtes | Fenêtre |
|---|---|---|
| `cbs_diagnostic` | 5 | 1 heure |
| `cbs_contact_form` | 3 | 1 heure |
| Tout endpoint public | 10 | 1 heure |

---

## 3. Validation des données (au-delà de la sanitization)

La sanitization nettoie — la validation vérifie que les données sont cohérentes.
Les deux sont obligatoires sur tout input utilisateur.

```php
// inc/ajax.php
function cbs_validate_diagnostic_data( array $data ): array|WP_Error {
    $errors = [];

    // Email : format valide ET non vide
    if ( empty( $data['email'] ) || ! is_email( $data['email'] ) ) {
        $errors[] = 'Email invalide.';
    }

    // Score : doit être entre 0 et 30
    $score = absint( $data['score'] ?? -1 );
    if ( $score < 0 || $score > 30 ) {
        $errors[] = 'Score hors limites.';
    }

    // Niveau : uniquement A, B ou C
    if ( ! in_array( $data['niveau'] ?? '', ['A', 'B', 'C'], true ) ) {
        $errors[] = 'Niveau invalide.';
    }

    // Type de projet : valeurs autorisées uniquement
    $types_autorises = [
        'Création d\'un spa',
        'Spa existant à optimiser',
        'Réflexion stratégique',
        'Gestion / staffing',
    ];
    if ( ! in_array( $data['type_projet'] ?? '', $types_autorises, true ) ) {
        $errors[] = 'Type de projet invalide.';
    }

    // Réponses : exactement 10 valeurs entre 0 et 3
    $reponses = $data['reponses'] ?? [];
    if ( count( $reponses ) !== 10 ) {
        $errors[] = 'Nombre de réponses incorrect.';
    }
    foreach ( $reponses as $r ) {
        if ( ! in_array( (int) $r, [0, 1, 2, 3], true ) ) {
            $errors[] = 'Valeur de réponse invalide.';
            break;
        }
    }

    if ( ! empty( $errors ) ) {
        return new WP_Error( 'validation_failed', implode( ' ', $errors ) );
    }

    return $data;
}
```

---

## 4. Protection contre la double soumission

Empêcher qu'un utilisateur soumette le diagnostic plusieurs fois rapidement
(double-clic, rechargement de page).

### Côté JS (`assets/js/tunnel.js`)
```javascript
let isSubmitting = false;

async function soumettreDiagnostic( formData ) {
    if ( isSubmitting ) return; // protection double-clic
    isSubmitting = true;

    const submitBtn = document.querySelector('.tunnel__submit');
    if ( submitBtn ) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Envoi en cours…';
    }

    try {
        const response = await fetch( cbsAjax.url, { method: 'POST', body: formData });
        const data = await response.json();
        if ( data.success ) {
            afficherResultat( data.data.score, data.data.niveau );
        }
    } finally {
        isSubmitting = false;
        if ( submitBtn ) submitBtn.disabled = false;
    }
}
```

### Côté PHP — token de soumission unique
```php
// Générer un token unique à l'affichage du formulaire (étape 11)
// Stocker en session ou transient, invalider après usage
function cbs_generate_submission_token(): string {
    $token = wp_generate_password( 32, false );
    set_transient( 'cbs_submit_token_' . $token, 1, 600 ); // valide 10 min
    return $token;
}

function cbs_consume_submission_token( string $token ): bool {
    $key   = 'cbs_submit_token_' . sanitize_text_field( $token );
    $valid = (bool) get_transient( $key );
    if ( $valid ) {
        delete_transient( $key ); // invalide après premier usage
    }
    return $valid;
}
```

---

## 5. Headers HTTP de sécurité

À ajouter dans `.htaccess` ou via `wp_headers` filter.

```php
// inc/setup.php
function cbs_security_headers( array $headers ): array {
    $headers['X-Content-Type-Options']  = 'nosniff';
    $headers['X-Frame-Options']         = 'SAMEORIGIN';
    $headers['X-XSS-Protection']        = '1; mode=block';
    $headers['Referrer-Policy']         = 'strict-origin-when-cross-origin';
    $headers['Permissions-Policy']      = 'camera=(), microphone=(), geolocation=()';

    // Content Security Policy — à affiner selon les scripts tiers utilisés
    $headers['Content-Security-Policy'] = implode( '; ', [
        "default-src 'self'",
        "script-src 'self' https://assets.calendly.com",
        "style-src 'self' 'unsafe-inline'",   // unsafe-inline nécessaire pour WP
        "img-src 'self' data: https:",
        "font-src 'self'",
        "connect-src 'self' https://api.airtable.com https://hook.make.com",
        "frame-src https://calendly.com",
    ]);

    return $headers;
}
add_filter( 'wp_headers', 'cbs_security_headers' );
```

> **Note CSP :** `unsafe-inline` pour les styles est souvent inévitable avec WordPress.
> Affiner progressivement en production en consultant les erreurs CSP dans la console.

---

## 6. Protection des URLs sensibles (`.htaccess`)

```apache
# Bloquer l'accès direct aux fichiers PHP du thème
<FilesMatch "\.php$">
    <If "%{REQUEST_URI} =~ m#/wp-content/themes/#">
        Order Deny,Allow
        Deny from all
    </If>
</FilesMatch>

# Bloquer l'accès au fichier xmlrpc.php si non utilisé
<Files xmlrpc.php>
    Order Deny,Allow
    Deny from all
</Files>

# Masquer la version WordPress
<Files wp-login.php>
    Order Deny,Allow
    Allow from all
</Files>
```

---

## 7. Checklist sécurité — avant chaque mise en prod

- [ ] `wp-config.php` dans `.gitignore` et hors du dossier `public/` si possible
- [ ] Aucune clé API dans le code ou les fichiers versionnés
- [ ] Rate limiting en place sur tous les endpoints `nopriv`
- [ ] Validation (pas seulement sanitization) sur tous les inputs
- [ ] Nonces vérifiés sur tous les handlers AJAX
- [ ] Headers HTTP de sécurité actifs
- [ ] `WP_DEBUG` à `false` en production
- [ ] `WP_DEBUG_LOG` à `true` en production (logs fichier, pas écran)
- [ ] Wordfence activé et configuré
- [ ] Préfixe de table WordPress personnalisé (pas `wp_`)

---

*Référence : wordpress-theme.md §8 (sécurité de base), environments.md (WP_DEBUG)*
