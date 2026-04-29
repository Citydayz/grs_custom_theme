# performance.md — Performance & Cache
# Conseil & Gestion des rituels du spa by Camille Becht

> Règles de performance applicables à tout le thème.
> Complète `wordpress-theme.md` §9 (règles de base).
> Cible : Lighthouse mobile ≥ 90 sur toutes les pages.

---

## 1. Cibles de performance

| Métrique | Cible | Critique si |
|---|---|---|
| Lighthouse Performance (mobile) | ≥ 90 | < 70 |
| LCP — Largest Contentful Paint | < 2.5s | > 4s |
| CLS — Cumulative Layout Shift | < 0.1 | > 0.25 |
| INP — Interaction to Next Paint | < 200ms | > 500ms |
| TTFB — Time to First Byte | < 600ms | > 1800ms |
| Poids total de la page | < 1MB | > 3MB |

---

## 2. Cache des appels API externes (Transients)

Les appels à Airtable ne doivent **jamais** se faire en temps réel sur le rendu d'une page.
Utiliser les transients WordPress comme couche de cache.

```php
// inc/api-airtable.php

/**
 * Récupère les études de cas depuis Airtable avec cache 1h.
 * Utilisé sur la page /references/ si les données viennent d'Airtable.
 *
 * @return array  Liste des enregistrements
 */
function cbs_get_etudes_de_cas_cached(): array {
    $cache_key = 'cbs_etudes_de_cas';
    $cached    = get_transient( $cache_key );

    if ( $cached !== false ) {
        return $cached; // retourne le cache sans appel API
    }

    // Appel API uniquement si le cache est expiré
    $result = cbs_fetch_airtable_records( CBS_AIRTABLE_TABLE_ETUDES );

    if ( ! is_wp_error( $result ) ) {
        set_transient( $cache_key, $result, HOUR_IN_SECONDS ); // cache 1h
    }

    return is_wp_error( $result ) ? [] : $result;
}

/**
 * Invalide le cache Airtable manuellement (ex: après mise à jour).
 * Appeler depuis le back-office ou via un hook.
 */
function cbs_flush_airtable_cache(): void {
    delete_transient( 'cbs_etudes_de_cas' );
    delete_transient( 'cbs_produits_pro' );
}
```

### Durées de cache recommandées

| Données | Durée | Constante WP |
|---|---|---|
| Études de cas | 1 heure | `HOUR_IN_SECONDS` |
| Produits boutique | 1 heure | `HOUR_IN_SECONDS` |
| Stats / chiffres clés | 24 heures | `DAY_IN_SECONDS` |
| Configuration Make | Pas de cache | — (constantes wp-config) |

---

## 3. Chargement conditionnel des scripts

Charger chaque script JS uniquement sur les pages qui en ont besoin.

```php
// inc/enqueue.php
function cbs_enqueue_assets(): void {

    // CSS principal — toutes les pages
    wp_enqueue_style( 'cbs-main', CBS_URI . '/assets/css/main.css', [], CBS_VERSION );

    // Nav — toutes les pages
    wp_enqueue_script( 'cbs-nav', CBS_URI . '/assets/js/nav.js', [], CBS_VERSION, true );

    // Animations scroll — toutes les pages sauf admin
    wp_enqueue_script( 'cbs-animations', CBS_URI . '/assets/js/animations.js', [], CBS_VERSION, true );

    // Tunnel diagnostic — uniquement sur /diagnostic/
    if ( is_page_template( 'template-diagnostic.php' ) ) {
        wp_enqueue_script( 'cbs-tunnel', CBS_URI . '/assets/js/tunnel.js', [], CBS_VERSION, true );
        wp_localize_script( 'cbs-tunnel', 'cbsAjax', [
            'url'   => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'cbs_tunnel_nonce' ),
        ]);
    }

    // Calendly — uniquement sur /contact/ et pages avec CTA RDV
    if ( is_page('contact') || is_page_template('template-contact.php') ) {
        wp_enqueue_script(
            'calendly-widget',
            'https://assets.calendly.com/assets/external/widget.js',
            [], null, true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'cbs_enqueue_assets' );
```

---

## 4. Images — règles strictes

```php
// Dans tous les templates — pattern obligatoire
?>
<img
    src="<?php echo esc_url( $image_url ); ?>"
    alt="<?php echo esc_attr( $image_alt ); ?>"
    width="<?php echo esc_attr( $image_width ); ?>"
    height="<?php echo esc_attr( $image_height ); ?>"
    loading="<?php echo $is_hero ? 'eager' : 'lazy'; ?>"
    decoding="async"
>
```

**Règles :**
- Format : **WebP uniquement** en production
- `loading="lazy"` sur toutes les images sauf le hero (LCP)
- `loading="eager"` + `fetchpriority="high"` sur l'image hero
- `width` et `height` toujours spécifiés (évite le CLS)
- `decoding="async"` systématique
- Taille max d'une image : 200kb (après compression WebP)
- Jamais d'image redimensionnée en CSS uniquement — toujours servir la bonne taille

### Tailles d'images à configurer (`inc/setup.php`)

```php
function cbs_setup_image_sizes(): void {
    add_image_size( 'cbs-hero',      1440, 810,  true ); // Hero plein écran
    add_image_size( 'cbs-card',      768,  512,  true ); // Cards études de cas
    add_image_size( 'cbs-thumbnail', 400,  300,  true ); // Miniatures
    add_image_size( 'cbs-og',        1200, 630,  true ); // Open Graph
}
add_action( 'after_setup_theme', 'cbs_setup_image_sizes' );
```

---

## 5. Preload des ressources critiques

```php
// inc/enqueue.php
function cbs_preload_critical_assets(): void {

    // Police Cormorant Garamond — bloquante pour le rendu des titres
    echo '<link rel="preload" href="' . esc_url( CBS_URI . '/assets/fonts/CormorantGaramond-Regular.woff2' ) . '"
               as="font" type="font/woff2" crossorigin>' . "\n";

    // Police Montserrat — bloquante pour le corps
    echo '<link rel="preload" href="' . esc_url( CBS_URI . '/assets/fonts/Montserrat-Regular.woff2' ) . '"
               as="font" type="font/woff2" crossorigin>' . "\n";

    // Hero image — uniquement sur l'accueil
    if ( is_front_page() ) {
        echo '<link rel="preload" href="' . esc_url( CBS_URI . '/assets/images/hero-home.webp' ) . '"
                   as="image" fetchpriority="high">' . "\n";
    }
}
add_action( 'wp_head', 'cbs_preload_critical_assets', 1 );
```

---

## 6. CSS — éviter le render-blocking

```php
// main.css est chargé normalement (render-blocking acceptable pour le CSS critique)
// Les CSS non-critiques (ex: animations) peuvent être chargés en différé

// Option : inline le CSS critique dans <head> pour les pages clés
function cbs_inline_critical_css(): void {
    if ( is_front_page() ) {
        $critical_css = file_get_contents( CBS_DIR . '/assets/css/critical/home.css' );
        if ( $critical_css ) {
            echo '<style id="cbs-critical">' . $critical_css . '</style>' . "\n";
        }
    }
}
add_action( 'wp_head', 'cbs_inline_critical_css', 5 );
```

> Le CSS critique est extrait manuellement une fois le design finalisé.
> Outils : Critical CSS Generator ou PurgeCSS.

---

## 7. Requêtes WordPress — règles

```php
// ❌ Jamais de WP_Query dans une boucle
foreach ( $posts as $post ) {
    $related = new WP_Query([...]); // N+1 requêtes
}

// ✅ Une seule requête, tous les posts d'un coup
$etudes = new WP_Query([
    'post_type'      => 'etude-de-cas',
    'posts_per_page' => 6,
    'no_found_rows'  => true, // désactive le COUNT SQL si pas de pagination
]);

// ✅ Pas de found_rows si pas de pagination
// ✅ Limiter les champs retournés si seuls les IDs sont nécessaires
$ids_only = new WP_Query([
    'fields'         => 'ids',
    'no_found_rows'  => true,
]);
```

---

## 8. Checklist performance — avant mise en ligne

- [ ] Lighthouse mobile ≥ 90 sur accueil, page offre et diagnostic
- [ ] Toutes les images en WebP avec width + height définis
- [ ] Hero image avec `loading="eager"` et preload dans `<head>`
- [ ] Scripts Calendly et tunnel chargés conditionnellement
- [ ] Polices preloadées dans `<head>`
- [ ] Cache serveur activé en production (WP Super Cache ou équivalent)
- [ ] Aucun appel API Airtable dans le rendu de page (transients en place)
- [ ] `no_found_rows => true` sur toutes les WP_Query sans pagination

---

*Référence : wordpress-theme.md §9 (performance de base), seo.md §7 (Core Web Vitals)*
