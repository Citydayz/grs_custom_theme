# seo.md — Conventions SEO
# Conseil & Gestion des rituels du spa by Camille Becht

> Ce fichier définit toutes les conventions SEO du site :
> structure des URLs, balises meta, données structurées, performances
> et bonnes pratiques à respecter dans chaque template.
> Cursor doit s'y référer pour tout travail sur les templates PHP et le contenu.
>
> Plugin SEO utilisé : Rank Math (ou Yoast SEO — à confirmer)

---

## 1. Stratégie SEO globale

### Positionnement cible

Le site cible deux intentions de recherche distinctes :

**Intention 1 — Conseil / Création (France entière)**
Prospects qui cherchent un expert pour créer ou optimiser un spa hôtelier.

Requêtes cibles principales :
- "consultant spa hôtelier"
- "créer un spa hôtel 4 étoiles"
- "conception spa hôtelier rentable"
- "audit spa hôtel"
- "expert spa hôtelier France"
- "erreurs conception spa hôtel"

**Intention 2 — Gestion / Staffing (Alsace)**
Prospects qui cherchent un gestionnaire de spa ou des praticiens.

Requêtes cibles principales :
- "gestion externalisée spa hôtel Alsace"
- "gestionnaire spa hôtelier Strasbourg"
- "massages en chambre hôtel Alsace"
- "praticiens spa freelance Alsace"
- "staffing spa hôtel Strasbourg"

### Positionnement de la marque
- Terme de marque : "Camille Becht spa"
- Terme de méthode : "Méthode Spa Profit"
- À positionner sur : toutes les pages offres + page d'accueil

---

## 2. Structure des URLs

### Règles générales
- Tout en minuscules
- Tirets `-` uniquement (pas d'underscore, pas d'espace)
- Pas de stop words inutiles ("le", "de", "un"…) sauf si nécessaires à la lisibilité
- Pas de date dans les URLs (sauf blog si créé)
- URLs courtes et descriptives

### URLs de toutes les pages

```
/                                   → Accueil
/methode-spa-profit/                → Hub Pôle Conseil
/methode-spa-profit/diagnostic-strategique/
/methode-spa-profit/conception-securisation/
/methode-spa-profit/mise-en-performance/
/gestion-spa-hotelier/              → Hub Pôle Gestion
/gestion-spa-hotelier/partielle/
/gestion-spa-hotelier/complete/
/staffing-spa/                      → Staffing & Renfort
/massages-en-chambre-hotel/         → Massages en chambre
/references/                        → Archive études de cas
/references/[slug-etude-de-cas]/    → Single étude de cas
/qui-sommes-nous/                   → À propos
/diagnostic-spa/                    → Tunnel de qualification
/boutique-pros/                     → Boutique professionnelle
/boutique-pros/[slug-produit]/      → Single produit
/contact/                           → Contact + Calendly
```

> **Note importante :** les slugs `/gestion-spa-hotelier/` et `/massages-en-chambre-hotel/`
> sont plus riches en mots-clés que les slugs du cahier des charges initial.
> À valider avant de déployer — les changer après indexation coûte cher.

### Configuration WordPress (`inc/cpt.php`)
```php
// CPT étude-de-cas → /references/[slug]/
register_post_type( 'etude-de-cas', [
    'rewrite' => [ 'slug' => 'references', 'with_front' => false ],
]);

// CPT produit-pro → /boutique-pros/[slug]/
register_post_type( 'produit-pro', [
    'rewrite' => [ 'slug' => 'boutique-pros', 'with_front' => false ],
]);
```

---

## 3. Balises meta — page par page

### Format général
```
Title    : [Mot-clé principal] — [Différenciateur] | Camille Becht
           Max 60 caractères espaces compris
Meta desc: [Bénéfice principal]. [Preuve ou différenciateur]. [CTA implicite].
           Max 155 caractères espaces compris
```

### Balises par page

**Accueil**
```
Title    : Consultant Spa Hôtelier — Création & Gestion | Camille Becht
Meta desc: J'accompagne les hôtels 4★ et 5★ dans la création et la gestion
           de spas rentables. Expertise terrain, méthode éprouvée. France entière.
```

**Méthode Spa Profit™**
```
Title    : Méthode Spa Profit™ — Créer un Spa Hôtelier Rentable | Camille Becht
Meta desc: La méthode en 3 niveaux pour concevoir un spa hôtelier rentable et
           parfaitement exploitable. Évitez les erreurs coûteuses dès la conception.
```

**Niveau 1 — Diagnostic stratégique**
```
Title    : Diagnostic Stratégique Spa Hôtelier | Camille Becht
Meta desc: Analysez le potentiel de votre spa, identifiez les risques et définissez
           votre stratégie. Mission 1 à 3 mois. Hôtels 4★ et 5★.
```

**Niveau 2 — Conception & sécurisation**
```
Title    : Conception Spa Hôtelier — Évitez les Erreurs Coûteuses | Camille Becht
Meta desc: Accompagnement complet pour concevoir un spa hôtelier rentable. Plans,
           équipements, coordination architecte, prévisionnel. France entière.
```

**Niveau 3 — Mise en performance**
```
Title    : Optimisation & Performance Spa Hôtelier | Camille Becht
Meta desc: Transformez votre spa en centre de profit. Branding, soin signature,
           organisation des équipes, formation. Hôtels 4★ et 5★.
```

**Gestion externalisée (hub)**
```
Title    : Gestion Externalisée Spa Hôtelier Alsace | Camille Becht
Meta desc: Déléguez la gestion de votre spa à un expert. Pilotage partiel ou
           complet, praticiens qualifiés, suivi de performance. Alsace.
```

**Gestion partielle**
```
Title    : Gestion Spa Hôtelier Partielle — Modèle Mixte Alsace | Camille Becht
Meta desc: Bénéficiez d'une expertise spa externalisée tout en conservant
           votre exploitation interne. Modèle commission. Alsace.
```

**Gestion complète**
```
Title    : Gestion Complète Spa Hôtelier Alsace — Tranquillité Totale | Camille Becht
Meta desc: Déléguez l'intégralité de la gestion de votre spa à une experte.
           Pilotage, équipes, CA, qualité. Forfait + commission. Alsace.
```

**Staffing**
```
Title    : Staffing Spa Hôtelier & Renfort d'Équipe Alsace | Camille Becht
Meta desc: Praticiens spa qualifiés disponibles à la demande. Conformité légale,
           suivi qualité, flexibilité totale. Alsace.
```

**Massages en chambre**
```
Title    : Massages en Chambre Hôtel Alsace — Service Clés en Main | Camille Becht
Meta desc: Proposez des massages haut de gamme sans spa dédié. Praticiens
           certifiés, planification fluide, image premium. Alsace.
```

**Références**
```
Title    : Références — Projets Spa Hôteliers Accompagnés | Camille Becht
Meta desc: Découvrez les missions de conseil et de gestion menées auprès
           d'hôtels 4★ et 5★. Création, optimisation, staffing.
```

**Diagnostic interactif**
```
Title    : Diagnostic Spa Hôtelier Gratuit — Évaluez votre Spa en 3 min | Camille Becht
Meta desc: Testez en 3 minutes si votre spa est conçu pour être rentable.
           10 questions, résultat immédiat, recommandations personnalisées.
```

**Qui sommes-nous**
```
Title    : Camille Becht — Experte Spa Hôtelier 4★ et 5★ | À propos
Meta desc: 13 ans d'expertise en spa hôtelier haut de gamme. Création, gestion,
           formation. Partenaire de +10 hôtels 4★ et 5★ en France.
```

**Contact**
```
Title    : Contact & Prise de RDV — Projet Spa Hôtelier | Camille Becht
Meta desc: Discutons de votre projet spa. Premier échange gratuit de 30 minutes.
           Réservez directement en ligne.
```

---

## 4. Balises H1/H2/H3 — règles

- **Un seul H1 par page**, toujours au-dessus de la ligne de flottaison
- Le H1 doit contenir le mot-clé principal de la page
- Les H2 structurent les grandes sections — doivent inclure des variations sémantiques
- Les H3 sont pour les sous-sections et les listes de bénéfices
- Jamais de H balise utilisée pour le style (utiliser CSS à la place)

### Exemple — page Conception & sécurisation
```
H1 : Conception & sécurisation de votre projet spa hôtelier
H2 : Pourquoi les erreurs de conception coûtent si cher
H2 : Mon rôle dans votre projet spa
H2 : Les 4 phases de la mission
  H3 : Phase 1 — Diagnostic stratégique
  H3 : Phase 2 — Conception fonctionnelle
  H3 : Phase 3 — Coordination avec la maîtrise d'œuvre
  H3 : Phase 4 — Préparation à l'exploitation
H2 : Ce que vous obtenez à la fin
H2 : Parlons de votre projet
```

---

## 5. Données structurées (Schema.org)

À implémenter via JSON-LD dans le `<head>` de chaque page concernée.

### Schema global — Organisation (`front-page.php` + `functions.php`)

```php
// inc/helpers.php
function cbs_schema_organization(): string {
    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'ProfessionalService',
        'name'     => 'Conseil & Gestion des rituels du spa by Camille Becht',
        'url'      => home_url(),
        'logo'     => CBS_URI . '/assets/images/logo.svg',
        'description' => 'Conseil, création et gestion de spas hôteliers 4★ et 5★.',
        'areaServed'  => [
            ['@type' => 'Country', 'name' => 'France'],       // Pôle Conseil
            ['@type' => 'AdministrativeArea', 'name' => 'Alsace'], // Pôle Gestion
        ],
        'founder' => [
            '@type' => 'Person',
            'name'  => 'Camille Becht',
        ],
        'sameAs' => [
            'https://www.linkedin.com/in/[profil-camille]',
            // autres réseaux si pertinent
        ],
    ];
    return '<script type="application/ld+json">'
         . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
         . '</script>';
}
add_action( 'wp_head', 'cbs_schema_organization' );
```

### Schema — Service (pages offres)

```php
// À injecter dans le <head> des pages /methode-spa-profit/ et sous-pages
$schema_service = [
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => 'Méthode Spa Profit™ — Conseil en création de spa hôtelier',
    'provider'    => [ '@type' => 'Person', 'name' => 'Camille Becht' ],
    'areaServed'  => [ '@type' => 'Country', 'name' => 'France' ],
    'description' => 'Accompagnement complet pour la création et l\'optimisation
                      de spas hôteliers 4★ et 5★.',
    'url'         => home_url( '/methode-spa-profit/' ),
];
```

### Schema — FAQPage (page diagnostic + pages offres)

Exemple pour la page `/diagnostic-spa/` :
```php
$schema_faq = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => [
        [
            '@type'          => 'Question',
            'name'           => 'Pourquoi mon spa ne remplit pas ses cabines ?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => 'Les causes les plus fréquentes sont une offre mal adaptée
                            à la clientèle, un parcours client peu fluide ou une
                            organisation des plannings sous-optimale.',
            ],
        ],
        [
            '@type'          => 'Question',
            'name'           => 'Comment améliorer la rentabilité d\'un spa hôtelier ?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => 'L\'amélioration de la rentabilité passe par un audit
                            stratégique, l\'optimisation de l\'offre de soins et
                            une organisation efficace des équipes.',
            ],
        ],
        [
            '@type'          => 'Question',
            'name'           => 'Faut-il repenser l\'offre ou l\'organisation du spa ?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => 'Cela dépend du diagnostic. Dans la plupart des cas,
                            les deux dimensions sont liées et nécessitent une
                            analyse globale avant toute décision.',
            ],
        ],
    ],
];
```

### Schema — BreadcrumbList (toutes les pages)

```php
// Généré automatiquement dans inc/helpers.php
// Exemple pour /methode-spa-profit/conception-securisation/
$schema_breadcrumb = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        [ '@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil',
          'item'  => home_url('/') ],
        [ '@type' => 'ListItem', 'position' => 2, 'name' => 'Méthode Spa Profit™',
          'item'  => home_url('/methode-spa-profit/') ],
        [ '@type' => 'ListItem', 'position' => 3, 'name' => 'Conception & sécurisation',
          'item'  => home_url('/methode-spa-profit/conception-securisation/') ],
    ],
];
```

---

## 6. Balises Open Graph & Twitter Card

À implémenter dans `<head>` via le plugin SEO (Rank Math / Yoast) ou manuellement.

```php
// inc/helpers.php — fallback si plugin SEO absent
function cbs_open_graph_tags(): void {
    global $post;
    $title       = wp_get_document_title();
    $description = get_the_excerpt() ?: get_bloginfo('description');
    $image       = has_post_thumbnail()
                 ? get_the_post_thumbnail_url( null, 'large' )
                 : CBS_URI . '/assets/images/og-default.jpg';
    $url         = get_permalink() ?: home_url('/');

    echo '<meta property="og:type"        content="website">' . "\n";
    echo '<meta property="og:title"       content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:image"       content="' . esc_url($image) . '">' . "\n";
    echo '<meta property="og:url"         content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:locale"      content="fr_FR">' . "\n";
    echo '<meta name="twitter:card"       content="summary_large_image">' . "\n";
}
add_action( 'wp_head', 'cbs_open_graph_tags' );
```

**Image OG par défaut :** `/assets/images/og-default.jpg`
- Format : 1200 × 630 px
- Contenu : logo CBS + accroche + fond silver/gold
- À créer dans la charte graphique

---

## 7. Performance SEO (Core Web Vitals)

### LCP — Largest Contentful Paint (cible : < 2.5s)

```php
// Hero image : preload obligatoire dans <head>
// inc/enqueue.php
function cbs_preload_hero(): void {
    if ( is_front_page() ) {
        echo '<link rel="preload" as="image"
              href="' . esc_url( CBS_URI . '/assets/images/hero-home.webp' ) . '"
              fetchpriority="high">' . "\n";
    }
}
add_action( 'wp_head', 'cbs_preload_hero', 1 );
```

```html
<!-- Dans template-parts/home/hero.php -->
<img src="..." alt="Spa hôtelier haut de gamme"
     fetchpriority="high"
     loading="eager"
     decoding="async"
     width="1440" height="810">
```

### CLS — Cumulative Layout Shift (cible : < 0.1)
- Toujours spécifier `width` et `height` sur toutes les balises `<img>`
- Réserver l'espace des polices avec `font-display: swap` (déjà dans `tokens.css`)
- Pas d'injection de contenu au-dessus du fold après chargement

### INP — Interaction to Next Paint (cible : < 200ms)
- Pas d'événement JS lourd sur le fil principal
- Tunnel diagnostic : réponses enregistrées localement, soumission AJAX non bloquante
- Éviter les scripts tiers synchrones (Calendly chargé en defer conditionnel)

---

## 8. Sitemap & fichiers techniques

### sitemap.xml
Généré automatiquement par Rank Math ou Yoast.
URL : `/sitemap.xml` ou `/sitemap_index.xml`

Pages à **inclure** :
- Toutes les pages du site
- Archive et singles CPT `etude-de-cas`
- Archive et singles CPT `produit-pro`

Pages à **exclure** (via plugin ou `robots.txt`) :
- `/wp-admin/`
- `/wp-login.php`
- Pages de politique de confidentialité, mentions légales (optionnel)
- Résultats du diagnostic (pages dynamiques sans contenu statique)

### robots.txt

```
User-agent: *
Disallow: /wp-admin/
Disallow: /wp-login.php
Disallow: /diagnostic/?*     # Évite l'indexation des états du tunnel
Allow: /wp-admin/admin-ajax.php

Sitemap: https://[domaine-site]/sitemap_index.xml
```

### Fichier `.htaccess` — redirections à prévoir

```apache
# Redirection www → sans www (ou inverse, à choisir)
RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]
RewriteRule ^ https://%1%{REQUEST_URI} [R=301,L]

# HTTPS forcé
RewriteCond %{HTTPS} off
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
```

---

## 9. Maillage interne — règles

- Chaque page offre doit pointer vers `/contact/` et `/diagnostic-spa/`
- La page d'accueil doit pointer vers les deux pôles principaux
- Chaque étude de cas doit pointer vers l'offre correspondante
- Le diagnostic doit pointer vers les pages résultats pertinentes (selon niveau)
- Pas plus de 3 niveaux de profondeur depuis l'accueil

### Liens contextuels recommandés

| Page source | Liens à inclure |
|---|---|
| Accueil | → /methode-spa-profit/, → /gestion-spa-hotelier/, → /diagnostic-spa/, → /references/ |
| Méthode Spa Profit™ | → /methode-spa-profit/diagnostic-strategique/, → /conception-securisation/, → /mise-en-performance/, → /contact/ |
| Gestion hub | → /partielle/, → /complete/, → /staffing-spa/, → /massages-en-chambre-hotel/ |
| Études de cas | → offre liée, → /contact/, → /diagnostic-spa/ |
| Diagnostic résultat | → offre recommandée, → /references/ |

---

## 10. Checklist SEO avant mise en ligne

**Technique**
- [ ] HTTPS actif + redirection HTTP → HTTPS
- [ ] Redirection www configurée
- [ ] sitemap.xml soumis dans Google Search Console
- [ ] robots.txt vérifié
- [ ] Aucune page utile en `noindex`
- [ ] Score Lighthouse mobile ≥ 90

**On-page**
- [ ] Title unique sur chaque page (≤ 60 caractères)
- [ ] Meta description unique sur chaque page (≤ 155 caractères)
- [ ] Un seul H1 par page contenant le mot-clé principal
- [ ] Attributs `alt` sur toutes les images (descriptif + mot-clé si pertinent)
- [ ] Balises `width` et `height` sur toutes les `<img>`
- [ ] Schema Organization en place sur toutes les pages

**Contenu**
- [ ] Mots-clés cibles intégrés naturellement dans les titres et corps de texte
- [ ] Champs sémantiques couverts (variantes, synonymes)
- [ ] Maillage interne vérifié
- [ ] Open Graph configuré + image OG par défaut créée

---

*Référence : agents.md §4 (Conventions globales), content-structure.md §11 (mots-clés)*
*Fichier suivant : integrations.md*
