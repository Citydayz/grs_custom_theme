# wordpress-theme.md — Thème Custom WordPress
# Conseil & Gestion des rituels du spa by Camille Becht

> Ce fichier définit la structure, les conventions et les règles de développement
> du thème WordPress custom. Cursor doit s'y référer pour toute tâche PHP/CSS/JS.

---

## 1. Principes fondamentaux

- **Zéro page builder** : pas d'Elementor, Divi, WPBakery, Bricks ou équivalent
- **Zéro thème parent** : thème standalone, aucune dépendance à un thème tiers
- **Zéro jQuery custom** : WordPress charge jQuery si nécessaire, on ne l'appelle pas manuellement
- **CSS natif uniquement** : variables CSS (`--cbs-*`), pas de Sass, pas de Tailwind
- **JS minimal** : vanilla JS ES6+, modules si nécessaire, pas de frameworks front
- **Performance first** : Lighthouse mobile ≥ 90 en cible

---

## 2. Structure des fichiers du thème

```
/wp-content/themes/cbs-theme/
├── style.css                    ← En-tête du thème (métadonnées WP uniquement)
├── functions.php                ← Point d'entrée principal — inclut les fichiers /inc/
├── index.php                    ← Fallback obligatoire WordPress
├── front-page.php               ← Page d'accueil
├── page.php                     ← Template page générique
├── single.php                   ← Template article/CPT générique
├── archive.php                  ← Template archive générique
├── 404.php                      ← Page erreur
├── search.php                   ← Résultats de recherche
├── header.php                   ← Racine : get_header() — délègue à template-parts/global/header.php
├── footer.php                   ← Racine : get_footer() — délègue à template-parts/global/footer.php
│
├── template-parts/              ← Blocs réutilisables (inclus via get_template_part)
│   ├── global/
│   │   ├── header.php
│   │   ├── footer.php
│   │   ├── nav-primary.php
│   │   └── cta-bandeau.php
│   ├── home/
│   │   ├── hero.php
│   │   ├── segmentation-profils.php
│   │   ├── poles-overview.php
│   │   └── preuves-sociales.php
│   ├── offres/
│   │   ├── card-offre.php
│   │   └── methode-niveaux.php
│   ├── diagnostic/
│   │   ├── tunnel-step.php
│   │   └── tunnel-resultat.php
│   └── shared/
│       ├── temoignage.php
│       ├── etude-de-cas-card.php
│       └── cta-rdv.php
│
├── page-templates/              ← Templates de page assignables dans WP Admin
│   ├── template-diagnostic.php
│   ├── template-contact.php
│   └── template-boutique.php
│
├── single-etude-de-cas.php      ← Template CPT Étude de cas
├── archive-etude-de-cas.php     ← Archive CPT Étude de cas
├── single-produit-pro.php       ← Template CPT Boutique pros
│
├── inc/                         ← Fichiers PHP inclus dans functions.php
│   ├── setup.php                ← Supports thème (thumbnails, menus, html5…)
│   ├── enqueue.php              ← Enqueue scripts & styles
│   ├── cpt.php                  ← Déclaration des Custom Post Types
│   ├── taxonomies.php           ← Déclaration des taxonomies custom
│   ├── acf-fields.php           ← Enregistrement des groupes ACF (si JSON désactivé)
│   ├── menus.php                ← Emplacements menus + require du walker
│   ├── class-cbs-nav-walker.php ← Walker `wp_nav_menu` (structure navigation.md §4)
│   ├── widgets.php              ← Zones de widgets si nécessaire
│   ├── shortcodes.php           ← Shortcodes custom
│   ├── ajax.php                 ← Handlers AJAX (tunnel diagnostic, formulaires)
│   ├── api-airtable.php         ← Fonctions d'envoi vers Airtable API
│   └── helpers.php              ← Fonctions utilitaires partagées
│
├── assets/
│   ├── css/
│   │   ├── base/
│   │   │   ├── reset.css        ← Reset / normalize minimal
│   │   │   ├── tokens.css       ← Variables CSS globales (couleurs, typos, espacements)
│   │   │   └── typography.css   ← Styles typographiques de base
│   │   ├── components/
│   │   │   ├── buttons.css
│   │   │   ├── cards.css
│   │   │   ├── forms.css
│   │   │   ├── nav.css
│   │   │   ├── hero.css
│   │   │   └── tunnel.css
│   │   ├── layout/
│   │   │   ├── grid.css
│   │   │   ├── header.css
│   │   │   └── footer.css
│   │   └── main.css             ← Importe tous les fichiers CSS via @import
│   │
│   ├── js/
│   │   ├── nav.js               ← Menu mobile, sticky header
│   │   ├── tunnel.js            ← Logique front du tunnel de diagnostic (multi-steps)
│   │   ├── animations.js        ← Scroll animations légères (Intersection Observer)
│   │   └── calendly.js          ← Initialisation widget Calendly
│   │
│   └── images/
│       ├── icons/               ← SVG inline ou sprites
│       └── placeholders/        ← Images de dev (remplacées en prod)
│
└── languages/
    └── cbs-theme.pot            ← Fichier de traduction (français par défaut)
```

---

## 3. functions.php — structure obligatoire

```php
<?php
/**
 * CBS Theme — functions.php
 * Point d'entrée. N'écrit aucune logique ici, tout est dans /inc/
 */

defined( 'ABSPATH' ) || exit;

// Constantes du thème
define( 'CBS_VERSION', '1.0.0' );
define( 'CBS_DIR', get_template_directory() );
define( 'CBS_URI', get_template_directory_uri() );

// Inclusions
require_once CBS_DIR . '/inc/setup.php';
require_once CBS_DIR . '/inc/enqueue.php';
require_once CBS_DIR . '/inc/cpt.php';
require_once CBS_DIR . '/inc/taxonomies.php';
require_once CBS_DIR . '/inc/menus.php';
require_once CBS_DIR . '/inc/widgets.php';
require_once CBS_DIR . '/inc/acf-fields.php';
require_once CBS_DIR . '/inc/ajax.php';
require_once CBS_DIR . '/inc/api-airtable.php';
require_once CBS_DIR . '/inc/shortcodes.php';
require_once CBS_DIR . '/inc/helpers.php';
```

---

## 4. Enqueue — conventions

```php
// inc/enqueue.php
function cbs_enqueue_assets() {
    // CSS principal (concaténé en prod)
    wp_enqueue_style(
        'cbs-main',
        CBS_URI . '/assets/css/main.css',
        [],
        CBS_VERSION
    );

    // JS — chargés en footer, defer si possible
    wp_enqueue_script(
        'cbs-nav',
        CBS_URI . '/assets/js/nav.js',
        [],
        CBS_VERSION,
        true // footer
    );

    // Localisation AJAX pour le tunnel
    wp_localize_script( 'cbs-tunnel', 'cbsAjax', [
        'url'   => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'cbs_tunnel_nonce' ),
    ]);
}
add_action( 'wp_enqueue_scripts', 'cbs_enqueue_assets' );
```

**Règles enqueue :**
- Toujours versionner avec `CBS_VERSION`
- JS toujours en footer (`true` en 5e argument)
- Jamais de CDN externe sauf Calendly (chargé conditionnellement)
- Police Google Fonts : auto-hébergée via `@font-face` dans `tokens.css`

---

## 5. Custom Post Types

### `etude-de-cas`

```php
// inc/cpt.php
function cbs_register_cpt_etude_de_cas() {
    register_post_type( 'etude-de-cas', [
        'label'         => 'Études de cas',
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'references' ],
        'supports'      => [ 'title', 'thumbnail', 'excerpt' ],
        'menu_icon'     => 'dashicons-portfolio',
        'show_in_rest'  => false, // pas de Gutenberg
    ]);
}
add_action( 'init', 'cbs_register_cpt_etude_de_cas' );
```

### `produit-pro`

```php
function cbs_register_cpt_produit_pro() {
    register_post_type( 'produit-pro', [
        'label'         => 'Boutique pros',
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'boutique-pros' ],
        'supports'      => [ 'title', 'thumbnail', 'editor' ],
        'menu_icon'     => 'dashicons-cart',
        'show_in_rest'  => false,
    ]);
}
add_action( 'init', 'cbs_register_cpt_produit_pro' );
```

**Règles CPT :**
- `show_in_rest => false` : Gutenberg désactivé sur les CPT, édition via ACF
- Slugs toujours en français
- Préfixe `cbs_` sur toutes les fonctions

---

## 6. ACF — conventions

- Utiliser **ACF JSON** : activer la sauvegarde dans `/acf-json/` à la racine du thème
- Groupes de champs nommés : `CBS — [Nom du CPT ou de la page]`
- Chaque champ prefixé `cbs_` (ex. : `cbs_problematique`, `cbs_resultat_chiffre`)
- Pas de `the_field()` dans les templates — toujours `get_field()` assigné à une variable

```php
// Bon usage dans un template
$problematique = get_field( 'cbs_problematique' );
if ( $problematique ) {
    echo '<p class="etude__problematique">' . esc_html( $problematique ) . '</p>';
}
```

---

## 7. Nommage CSS — BEM

```css
/* Block */
.hero {}

/* Element */
.hero__title {}
.hero__cta {}

/* Modifier */
.hero--conseil {}
.hero--gestion {}

/* Avec préfixe composant */
.card-offre {}
.card-offre__titre {}
.card-offre__tag {}
.card-offre--highlight {}
```

**Règles CSS :**
- Jamais de `!important` sauf reset
- Jamais de styles inline dans le PHP
- Toutes les couleurs, tailles, espacements via variables `--cbs-*`
- Media queries : mobile-first, breakpoints dans `tokens.css`

---

## 8. Sécurité — checklist obligatoire

- [ ] `defined( 'ABSPATH' ) || exit;` en tête de chaque fichier PHP
- [ ] Toutes les sorties HTML passées par `esc_html()`, `esc_url()`, `esc_attr()` selon le contexte
- [ ] Formulaires : nonce WordPress vérifié côté serveur
- [ ] AJAX : vérification nonce + `check_ajax_referer()` avant tout traitement
- [ ] Clés API (Airtable, Brevo, Calendly) : dans `wp-config.php` uniquement, jamais dans le thème
- [ ] Pas de `$_GET` / `$_POST` utilisés directement — toujours sanitizés

```php
// Pattern AJAX sécurisé
add_action( 'wp_ajax_nopriv_cbs_diagnostic', 'cbs_handle_diagnostic' );
add_action( 'wp_ajax_cbs_diagnostic', 'cbs_handle_diagnostic' );

function cbs_handle_diagnostic() {
    check_ajax_referer( 'cbs_tunnel_nonce', 'nonce' );
    $data = array_map( 'sanitize_text_field', $_POST['reponses'] ?? [] );
    // traitement...
    wp_send_json_success( $response );
}
```

---

## 9. Performance — règles

- Images : format **WebP** uniquement en production, `loading="lazy"` systématique sauf hero
- Hero image/vidéo : `loading="eager"`, `fetchpriority="high"` sur l'image de fallback
- Pas de plugin de cache en dev, WP Super Cache ou équivalent en prod
- `wp_footer()` et `wp_head()` obligatoires dans les templates
- Pas de `@import` CSS dans les feuilles de style enqueuées (seulement dans `main.css`)

---

## 10. Template hierarchy — règles de priorité

WordPress cherche les templates dans cet ordre pour chaque type de contenu.
Cursor doit créer le fichier le plus spécifique nécessaire, pas le plus générique.

| Contenu | Template à utiliser |
|---|---|
| Page d'accueil | `front-page.php` |
| Page standard | `page.php` |
| Page avec template assigné | `page-templates/template-[slug].php` |
| CPT étude-de-cas (single) | `single-etude-de-cas.php` |
| CPT étude-de-cas (archive) | `archive-etude-de-cas.php` |
| CPT produit-pro (single) | `single-produit-pro.php` |
| 404 | `404.php` |

---

## 11. Plugins autorisés

| Plugin | Usage | Obligatoire |
|---|---|---|
| Advanced Custom Fields (ACF) | Champs custom sur CPT et pages | ✅ Oui |
| ACF Pro | Champs répéteurs, flex content | ✅ Oui |
| Yoast SEO ou Rank Math | SEO on-page | ✅ Oui |
| WP Mail SMTP | Relay mail via Brevo/Mailjet | ✅ Oui |
| Wordfence | Sécurité | ✅ Oui (prod) |

**Plugins interdits :**
- WooCommerce (boutique = CPT custom)
- Contact Form 7 (formulaires = custom via AJAX)
- Tout plugin de page builder
- Tout plugin de slider (carousels = custom JS)

---

*Référence : agents.md §2 (Stack), §4 (Conventions globales)*
*Fichier suivant à consulter selon la tâche : design-system.md, diagnostic-tunnel.md*
