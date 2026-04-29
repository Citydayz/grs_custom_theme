# environments.md — Gestion des Environnements
# Conseil & Gestion des rituels du spa by Camille Becht

> Ce fichier définit les règles de séparation entre les environnements
> dev, staging et production. Cursor doit s'y référer pour tout travail
> impliquant des URLs, des clés API ou des webhooks externes.

---

## 1. Les trois environnements

| Environnement | Usage | Webhooks Make | Airtable | Emails |
|---|---|---|---|---|
| **dev** (local) | Développement actif | ❌ Désactivés | Table de test | ❌ Désactivés |
| **staging** | Recette avant mise en prod | ⚠️ Scénarios de test | Table de test | Redirigés vers Camille |
| **production** | Site live | ✅ Actifs | Tables réelles | ✅ Actifs |

---

## 2. Détection de l'environnement

```php
// wp-config.php — définir l'environnement courant
define( 'CBS_ENV', 'development' ); // 'development' | 'staging' | 'production'
```

```php
// inc/helpers.php — fonction utilitaire
function cbs_is_production(): bool {
    return defined('CBS_ENV') && CBS_ENV === 'production';
}

function cbs_is_development(): bool {
    return ! defined('CBS_ENV') || CBS_ENV === 'development';
}
```

---

## 3. Désactivation des webhooks en dehors de la prod

```php
// inc/ajax.php
function cbs_trigger_make_webhook( string $event, array $data ): void {

    // ❌ Ne jamais envoyer vers Make en dev — pollue Airtable et consomme des opérations
    if ( cbs_is_development() ) {
        cbs_log_error( 'make_webhook', "[DEV] Webhook simulé : {$event}", $data );
        return;
    }

    $webhook_url = defined( 'CBS_MAKE_WEBHOOK_' . strtoupper( $event ) )
        ? constant( 'CBS_MAKE_WEBHOOK_' . strtoupper( $event ) )
        : null;

    if ( ! $webhook_url ) {
        cbs_log_error( 'make_webhook', "URL manquante pour l'événement : {$event}" );
        return;
    }

    wp_remote_post( $webhook_url, [
        'headers'  => [ 'Content-Type' => 'application/json' ],
        'body'     => wp_json_encode( $data ),
        'timeout'  => 10,
        'blocking' => false,
    ]);
}
```

---

## 4. Configuration wp-config.php par environnement

### Développement local

```php
// wp-config.php — LOCAL
define( 'CBS_ENV', 'development' );

// Debug actif
define( 'WP_DEBUG',         true );
define( 'WP_DEBUG_LOG',     true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'SCRIPT_DEBUG',     true );

// Airtable — table de test
define( 'CBS_AIRTABLE_API_KEY',           'pat_TEST_xxxx' );
define( 'CBS_AIRTABLE_BASE_ID',           'appTEST_xxxx' );
define( 'CBS_AIRTABLE_TABLE_DIAGNOSTICS', 'tblTEST_xxxx' );

// Make webhooks — vides en dev (désactivés par cbs_is_development())
define( 'CBS_MAKE_WEBHOOK_DIAGNOSTIC_COMPLETED', '' );
define( 'CBS_MAKE_WEBHOOK_CONTACT_FORM',         '' );

// Calendly — URL de test ou vide
define( 'CBS_CALENDLY_URL', 'https://calendly.com/[slug-test]' );
```

### Staging

```php
// wp-config.php — STAGING
define( 'CBS_ENV', 'staging' );

// Debug minimal
define( 'WP_DEBUG',         true  );
define( 'WP_DEBUG_LOG',     true  );
define( 'WP_DEBUG_DISPLAY', false ); // pas affiché aux testeurs
define( 'SCRIPT_DEBUG',     false );

// Airtable — base de staging (séparée de la prod)
define( 'CBS_AIRTABLE_API_KEY',           'pat_STAGING_xxxx' );
define( 'CBS_AIRTABLE_BASE_ID',           'appSTAGING_xxxx' );
define( 'CBS_AIRTABLE_TABLE_DIAGNOSTICS', 'tblSTAGING_xxxx' );

// Make webhooks — scénarios de test (pas les scénarios prod)
define( 'CBS_MAKE_WEBHOOK_DIAGNOSTIC_COMPLETED', 'https://hook.make.com/staging_xxx' );
define( 'CBS_MAKE_WEBHOOK_CONTACT_FORM',         'https://hook.make.com/staging_xxx' );
```

### Production

```php
// wp-config.php — PRODUCTION
define( 'CBS_ENV', 'production' );

// Debug désactivé
define( 'WP_DEBUG',         false );
define( 'WP_DEBUG_LOG',     true  ); // logs fichier uniquement
define( 'WP_DEBUG_DISPLAY', false );
define( 'SCRIPT_DEBUG',     false );

// Airtable — tables réelles
define( 'CBS_AIRTABLE_API_KEY',           'pat_PROD_xxxx' );
define( 'CBS_AIRTABLE_BASE_ID',           'appPROD_xxxx' );
define( 'CBS_AIRTABLE_TABLE_DIAGNOSTICS', 'tblPROD_xxxx' );
define( 'CBS_AIRTABLE_TABLE_MISSIONS',    'tblPROD_xxxx' );
define( 'CBS_AIRTABLE_TABLE_PRATICIENS',  'tblPROD_xxxx' );

// Make webhooks — scénarios réels
define( 'CBS_MAKE_WEBHOOK_DIAGNOSTIC_COMPLETED', 'https://hook.make.com/prod_xxx' );
define( 'CBS_MAKE_WEBHOOK_CONTACT_FORM',         'https://hook.make.com/prod_xxx' );
define( 'CBS_MAKE_WEBHOOK_SECRET',               'secret_prod_fort' );

// Calendly
define( 'CBS_CALENDLY_URL', 'https://calendly.com/[slug-camille]/echange-decouverte' );
```

---

## 5. Règles de déploiement

```
dev → staging  : copie du code uniquement — pas de la base de données
staging → prod : copie du code uniquement — JAMAIS la base de données de staging en prod
```

### Checklist avant chaque déploiement staging → prod

- [ ] `CBS_ENV` = `'production'` dans `wp-config.php`
- [ ] `WP_DEBUG_DISPLAY` = `false`
- [ ] Clés Airtable prod en place (pas les clés staging)
- [ ] URLs Make prod en place (pas les scénarios de test)
- [ ] `.gitignore` vérifié — `wp-config.php` absent du dépôt
- [ ] Cache WordPress vidé après déploiement
- [ ] Test rapide du tunnel diagnostic en prod (avec email de test)
- [ ] Vérification des notifications Telegram et email

---

## 6. Versionning Git — branches

```
main        → code de production — déploiement direct sur le serveur prod
staging     → branche de recette — déployée sur le serveur staging
develop     → branche de travail quotidien
feature/*   → fonctionnalités en cours (ex: feature/tunnel-diagnostic)
fix/*       → corrections de bugs
```

**Flux :**
```
feature/* → develop → staging (recette) → main (prod)
```

**Règles :**
- Jamais de push direct sur `main`
- Toujours tester sur `staging` avant de merger sur `main`
- Chaque merge sur `main` = tag de version (`v1.0.0`, `v1.1.0`…)

---

## 7. Fichiers à ne jamais committer

```gitignore
# wp-config.php — contient toutes les clés
wp-config.php

# Logs
*.log
wp-content/debug.log

# Uploads utilisateur
wp-content/uploads/

# Dossiers WordPress core (ne pas versionner WP lui-même)
wp-admin/
wp-includes/

# Dépendances
node_modules/
vendor/

# OS
.DS_Store
Thumbs.db

# IDE
.idea/
.vscode/
*.sublime-project
```

> **Seul le thème custom est versionné :**
> `/wp-content/themes/cbs-theme/` — et rien d'autre.

---

*Référence : security.md §1 (clés API), error-handling.md §6 (WP_DEBUG)*
