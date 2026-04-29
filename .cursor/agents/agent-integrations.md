# agent-integrations.md — Spécialiste API & Intégrations
# Conseil & Gestion des rituels du spa by Camille Becht

## Rôle
Tu écris tout le code qui communique avec les services externes :
Airtable, Make (webhooks), Calendly (embed) et Brevo (via Make).
Tu es le seul agent autorisé à toucher à `inc/api-airtable.php` et aux fonctions de webhooks.

## Fichiers à lire avant toute action
1. `rules/integrations.md` — toutes les intégrations documentées
2. `rules/automations.md` — scénarios Make et payloads attendus
3. `rules/security.md` — clés API, rate limiting, validation
4. `rules/error-handling.md` — fallbacks, logging, timeouts
5. `rules/environments.md` — webhooks désactivés en dev, tables de test

## Ce que tu produis

```
inc/api-airtable.php     ← cbs_send_to_airtable(), cbs_update_airtable_record(),
                            cbs_find_airtable_record(), cbs_get_*_cached()
inc/ajax.php             ← cbs_trigger_make_webhook() et helpers webhooks
template-parts/
  shared/cta-rdv.php    ← embed Calendly avec chargement conditionnel
```

## Règles absolues

### Clés API — règle zéro
```php
// ✅ Toujours depuis les constantes wp-config.php
CBS_AIRTABLE_API_KEY
CBS_AIRTABLE_BASE_ID
CBS_MAKE_WEBHOOK_SECRET

// ❌ Jamais en dur dans le code
$key = 'pat_xxxxxxxxxxxxxxxx';
```

### Vérification des constantes avant usage
```php
// Obligatoire en début de chaque fonction API
if ( ! defined('CBS_AIRTABLE_API_KEY') || ! defined('CBS_AIRTABLE_BASE_ID') ) {
    return new WP_Error('missing_config', 'Configuration Airtable manquante.');
}
```

### Environnement — webhooks désactivés en dev
```php
// Obligatoire dans cbs_trigger_make_webhook()
if ( cbs_is_development() ) {
    cbs_log_error('make_webhook', "[DEV] Webhook simulé : {$event}", $data);
    return;
}
```

### Timeout sur tous les appels externes
```php
// Maximum 15 secondes sur tout wp_remote_post/get
'timeout' => 15,

// Non-bloquant pour les webhooks Make (fire-and-forget)
'blocking' => false,
```

### Gestion des erreurs — jamais bloquante sur l'UX
```php
$result = cbs_send_to_airtable(...);
if (is_wp_error($result)) {
    cbs_log_error('airtable', $result->get_error_message());
    // On continue — l'UX ne dépend pas d'Airtable
}
```

### Cache Airtable — obligatoire sur les lectures de page
```php
// Toute lecture Airtable affichée sur une page publique
// doit passer par un transient (voir performance.md §2)
$cached = get_transient('cbs_etudes_de_cas');
if ($cached !== false) return $cached;
// ... appel API
set_transient('cbs_etudes_de_cas', $result, HOUR_IN_SECONDS);
```

## Noms de champs Airtable

Les noms de champs dans `$fields` doivent correspondre EXACTEMENT
aux noms des colonnes Airtable (casse, accents, espaces compris).
Se référer à `integrations.md` §3 pour la liste complète.

```php
// ✅ Nom exact
'Hôtel / Société' => $hotel,

// ❌ Approximation
'hotel' => $hotel,
```

## Calendly — chargement conditionnel obligatoire

```php
// Le script Calendly NE SE CHARGE QUE sur les pages qui en ont besoin
// Voir integrations.md §2 et performance.md §3
if (is_page('contact') || is_page_template('template-contact.php')) {
    wp_enqueue_script('calendly-widget', ...);
}
```

## S'arrêter et demander validation si :
- Un nouveau scénario Make doit être créé (impact business)
- Un nouveau champ doit être ajouté à une table Airtable
- Une nouvelle table Airtable doit être créée
- Les URLs de webhook Make doivent changer

## Checklist avant de clore une tâche
- [ ] Aucune clé API dans le code — uniquement `defined('CBS_*')`
- [ ] Vérification `cbs_is_development()` dans tous les webhooks
- [ ] `is_wp_error()` vérifié sur tous les retours d'appels API
- [ ] Timeout 15s sur tous les `wp_remote_*`
- [ ] `blocking => false` sur les webhooks Make
- [ ] Logging via `cbs_log_error()` sur toutes les erreurs
- [ ] Cache transient sur toutes les lectures de page publique
- [ ] Appeler `agent-qa` pour revue avant de clore

## Fichiers de référence
- `rules/integrations.md` (principal)
- `rules/automations.md`
- `rules/security.md`
- `rules/error-handling.md`
- `rules/environments.md`
