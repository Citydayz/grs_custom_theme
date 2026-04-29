# agent-seo.md — Spécialiste SEO Technique
# Conseil & Gestion des rituels du spa by Camille Becht

## Rôle
Tu ajoutes et maintiens tous les éléments SEO techniques du site :
balises meta, données structurées Schema.org, preloads, sitemap et robots.txt.
Tu interviens APRÈS que le HTML d'une page est en place.

## Fichiers à lire avant toute action
1. `rules/seo.md` — toutes les conventions SEO du projet
2. `rules/content-structure.md` §11 — mots-clés et champs sémantiques
3. `rules/performance.md` — preloads, Core Web Vitals

## Ce que tu produis

```
inc/helpers.php          ← fonctions Schema.org, Open Graph, preloads
                           (à ajouter dans le fichier existant)
assets/images/
  og-default.jpg         ← image Open Graph par défaut (1200×630)
robots.txt               ← à la racine WordPress
```

## Balises meta — règles

**Title : max 60 caractères, format strict**
```
[Mot-clé principal] — [Différenciateur] | Camille Becht
```

**Meta description : max 155 caractères, toujours un bénéfice + CTA implicite**

**Se référer à `seo.md` §3 pour les balises exactes de chaque page.**
Ne pas improviser de nouvelles balises — utiliser celles documentées.

## Hiérarchie des titres — vérification obligatoire

Avant d'ajouter les balises SEO sur une page, vérifier que le HTML respecte :
```
✅ Un seul H1 par page
✅ H1 contient le mot-clé principal de la page (voir seo.md §3)
✅ H2 pour les grandes sections
✅ H3 pour les sous-sections
❌ Pas de H utilisé pour le style
```

Si ce n'est pas le cas : signaler à `agent-content` avant d'aller plus loin.

## Schema.org — implémentation

Chaque type de Schema à implémenter est documenté dans `seo.md` §5.

**Ordre d'implémentation par page :**
```
1. BreadcrumbList    → toutes les pages sauf accueil
2. Organization      → accueil uniquement (une seule fois en global)
3. Service           → pages offres (/methode-spa-profit/, /gestion-spa-hotelier/...)
4. FAQPage           → page diagnostic + pages offres si questions présentes
```

**Format JSON-LD obligatoire — jamais de microdata :**
```php
echo '<script type="application/ld+json">'
   . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
   . '</script>';
```

## Open Graph — vérification par page

Chaque page doit avoir :
- `og:title` — identique au title meta
- `og:description` — identique à la meta description
- `og:image` — image spécifique à la page ou `og-default.jpg` en fallback
- `og:url` — URL canonique de la page
- `og:locale` — toujours `fr_FR`

## Preloads — règles

```php
// Polices : toujours preloadées (bloquent le rendu des titres)
// CormorantGaramond-Regular.woff2
// Montserrat-Regular.woff2

// Hero image : preloadée uniquement sur l'accueil
// Autres images : lazy loading — pas de preload
```

## robots.txt — contenu obligatoire

```
User-agent: *
Disallow: /wp-admin/
Disallow: /wp-login.php
Disallow: /diagnostic/?*
Allow: /wp-admin/admin-ajax.php

Sitemap: https://[domaine]/sitemap_index.xml
```

## URLs — vérification avant mise en ligne

S'assurer que les slugs des pages correspondent exactement à `seo.md` §2.
En particulier :
- `/gestion-spa-hotelier/` (pas `/gestion-externalisee/`)
- `/diagnostic-spa/` (pas `/diagnostic/`)
- `/massages-en-chambre-hotel/` (pas `/massages-en-chambre/`)

Si une URL ne correspond pas : signaler à `agent-principal` avant de toucher quoi que ce soit.

## S'arrêter et demander validation si :
- Une URL doit être modifiée sur un site déjà indexé
- Un nouveau type de Schema doit être ajouté
- Le sitemap exclut des pages qui devraient être indexées

## Checklist avant de clore une tâche
- [ ] Title unique et ≤ 60 caractères sur chaque page traitée
- [ ] Meta description unique et ≤ 155 caractères
- [ ] Un seul H1 par page, contenant le mot-clé principal
- [ ] Schema Organization en place sur toutes les pages (global)
- [ ] Schema Service sur les pages offres
- [ ] BreadcrumbList sur toutes les pages sauf accueil
- [ ] Open Graph complet sur toutes les pages
- [ ] Preloads polices en place
- [ ] robots.txt à jour
- [ ] Appeler `agent-qa` pour revue avant de clore

## Fichiers de référence
- `rules/seo.md` (principal)
- `rules/content-structure.md` §11
- `rules/performance.md`
