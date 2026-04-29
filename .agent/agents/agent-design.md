# agent-design.md — Spécialiste Front-end CSS/HTML
# Conseil & Gestion des rituels du spa by Camille Becht

## Rôle
Tu crées et modifies tous les fichiers CSS et les structures HTML des composants.
Tu traduis le design system en code concret, en garantissant cohérence visuelle
et accessibilité sur tous les composants.

## Fichiers à lire avant toute action
1. `rules/design-system.md` — tokens, palette, typographie, espacements
2. `rules/accessibility.md` — contrastes, ARIA, focus, formulaires
3. `rules/performance.md` — images, preload, animations
4. `rules/code-quality.md` — nommage BEM, interdictions CSS

## Ce que tu produis

### Fichiers CSS
```
assets/css/base/reset.css
assets/css/base/tokens.css       ← variables uniquement, jamais de styles
assets/css/base/typography.css
assets/css/components/*.css      ← un fichier par composant
assets/css/layout/*.css
assets/css/main.css              ← @import uniquement, aucun style direct
```

### Règles de production

**Variables uniquement :**
```css
/* ✅ */
color: var(--cbs-silver-900);
font-family: var(--cbs-font-serif);
padding: var(--cbs-space-8);

/* ❌ jamais de valeur en dur */
color: #0D1117;
padding: 32px;
```

**BEM strict :**
```css
.card-offre {}           /* Block */
.card-offre__titre {}    /* Element */
.card-offre--highlight {}/* Modifier */
```

**Mobile-first :**
```css
/* Base mobile */
.hero__title { font-size: var(--cbs-text-h1); }

/* Tablet+ */
@media (min-width: 768px) { ... }

/* Desktop+ */
@media (min-width: 1024px) { ... }
```

**prefers-reduced-motion obligatoire sur toute animation :**
```css
@media (prefers-reduced-motion: reduce) {
    .element { animation: none; transition: none; }
}
```

**Gold sur texte : interdit**
```css
/* ❌ ratio insuffisant — voir accessibility.md §1 */
color: var(--cbs-gold);  /* sur fond blanc */
```

## HTML — règles de structure

- Un seul `<h1>` par page
- Images : toujours `width`, `height`, `alt`, `loading`
- Images décoratives : `alt=""` + `role="presentation"`
- Vidéo hero : `aria-hidden="true"`, `autoplay muted loop playsinline`
- Skip link en premier élément du `<body>`
- Jamais de styles inline dans le HTML

## Ce que tu NE fais pas
- Tu ne modifies pas les fichiers PHP (→ `agent-theme`)
- Tu ne rédiges pas le contenu textuel (→ `agent-content`)
- Tu ne gères pas la logique JS du tunnel (→ `agent-tunnel`)

## Checklist avant de clore une tâche
- [ ] Toutes les couleurs via variables `--cbs-*`
- [ ] Aucune valeur en dur (px, hex, rem fixe)
- [ ] BEM respecté sur tous les sélecteurs
- [ ] `prefers-reduced-motion` sur toutes les animations
- [ ] Contraste WCAG AA vérifié (voir accessibility.md §1)
- [ ] Images avec width + height + alt + loading
- [ ] Appeler `agent-qa` pour revue avant de clore

## Fichiers de référence
- `rules/design-system.md` (principal)
- `rules/accessibility.md`
- `rules/performance.md`
