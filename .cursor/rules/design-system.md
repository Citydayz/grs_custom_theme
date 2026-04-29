# design-system.md — Design System
# Conseil & Gestion des rituels du spa by Camille Becht

> Ce fichier définit tous les tokens de design du thème.
> Cursor doit utiliser UNIQUEMENT ces variables — jamais de valeurs en dur dans le CSS.
> Fichier de référence : `assets/css/base/tokens.css`

---

## 1. Philosophie visuelle

**Positionnement :** Cabinet de conseil hôtelier haut de gamme. Luxe sobre, pas ostentatoire.
**Registre :** Silver & Or — minéral, froid, précieux. Contraste avec des touches chaudes (or/champagne).
**Référence DA :** `academie-rituels-spa.fr` — même rigueur structurelle, palette entièrement différente.

**Deux ambiances selon le pôle :**
- **Pôle Conseil** : visuels techniques, plans, bureau d'étude — tons silver froids, graphique
- **Pôle Gestion** : visuels humains, soins, management — tons silver chauds, photographique

---

## 2. Palette de couleurs

### Couleurs primaires — Silver

```css
--cbs-silver-50:  #F8F9FA;   /* Fond page, sections alternées */
--cbs-silver-100: #F1F3F5;   /* Fond cards, inputs */
--cbs-silver-200: #DEE2E6;   /* Bordures légères */
--cbs-silver-300: #CED4DA;   /* Bordures, séparateurs */
--cbs-silver-400: #ADB5BD;   /* Texte désactivé, placeholders */
--cbs-silver-500: #868E96;   /* Texte secondaire, captions */
--cbs-silver-600: #495057;   /* Texte corps principal */
--cbs-silver-700: #343A40;   /* Titres secondaires */
--cbs-silver-800: #212529;   /* Titres principaux */
--cbs-silver-900: #0D1117;   /* Noir profond, hero text */
```

### Couleurs d'accent — Or / Champagne

```css
--cbs-gold-light:   #F5E6C8;   /* Fond highlight subtil */
--cbs-gold:         #C9A84C;   /* Accent principal — CTA, soulignements, icônes */
--cbs-gold-dark:    #A07830;   /* Hover sur éléments gold */
--cbs-gold-muted:   #E8D5A3;   /* Séparateurs dorés, ornements */
```

### Blanc & Noir purs

```css
--cbs-white:  #FFFFFF;
--cbs-black:  #0A0A0A;
```

### Couleurs sémantiques

```css
--cbs-success:  #2D6A4F;   /* Confirmation, succès formulaire */
--cbs-error:    #C0392B;   /* Erreur formulaire */
--cbs-warning:  #D4A017;   /* Alerte, attention */
--cbs-info:     #4A6FA5;   /* Info neutre */
```

### Couleurs par pôle

```css
/* Pôle Conseil & Création */
--cbs-pole-conseil-bg:     var(--cbs-silver-900);
--cbs-pole-conseil-accent: var(--cbs-gold);
--cbs-pole-conseil-text:   var(--cbs-white);

/* Pôle Gestion & Staffing */
--cbs-pole-gestion-bg:     var(--cbs-silver-50);
--cbs-pole-gestion-accent: var(--cbs-gold-dark);
--cbs-pole-gestion-text:   var(--cbs-silver-800);
```

---

## 3. Typographie

### Familles de polices

```css
--cbs-font-serif:      'Cormorant Garamond', Georgia, serif;
--cbs-font-sans:       'Montserrat', system-ui, sans-serif;
--cbs-font-mono:       'Courier New', monospace; /* usage rare */
```

**Règle d'usage :**
- `--cbs-font-serif` → Tous les titres (H1 à H3), citations, signatures
- `--cbs-font-sans` → Corps de texte, navigation, boutons, labels, légendes

### Chargement des polices (auto-hébergé)

Les polices sont auto-hébergées dans `/assets/fonts/` — pas de Google Fonts en prod.

```css
/* assets/css/base/typography.css — chemins relatifs : ../../fonts/ → assets/fonts/ */
@font-face {
    font-family: 'Cormorant Garamond';
    src: url('../../fonts/CormorantGaramond-Regular.woff2') format('woff2');
    font-weight: 400;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Cormorant Garamond';
    src: url('../../fonts/CormorantGaramond-Italic.woff2') format('woff2');
    font-weight: 400;
    font-style: italic;
    font-display: swap;
}
@font-face {
    font-family: 'Cormorant Garamond';
    src: url('../../fonts/CormorantGaramond-SemiBold.woff2') format('woff2');
    font-weight: 600;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Montserrat';
    src: url('../../fonts/Montserrat-Regular.woff2') format('woff2');
    font-weight: 400;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Montserrat';
    src: url('../../fonts/Montserrat-Medium.woff2') format('woff2');
    font-weight: 500;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Montserrat';
    src: url('../../fonts/Montserrat-SemiBold.woff2') format('woff2');
    font-weight: 600;
    font-style: normal;
    font-display: swap;
}
```

### Échelle typographique

```css
/* Titres — Cormorant Garamond */
--cbs-text-display:   clamp(3rem, 6vw, 5.5rem);    /* Hero, titre page */
--cbs-text-h1:        clamp(2.25rem, 4vw, 3.75rem); /* H1 sections */
--cbs-text-h2:        clamp(1.75rem, 3vw, 2.75rem); /* H2 sous-sections */
--cbs-text-h3:        clamp(1.375rem, 2vw, 1.875rem); /* H3 cards, blocs */
--cbs-text-h4:        clamp(1.125rem, 1.5vw, 1.375rem); /* H4 */

/* Corps — Montserrat */
--cbs-text-lead:      clamp(1.0625rem, 1.5vw, 1.25rem); /* Chapeau, intro */
--cbs-text-body:      1rem;                              /* Corps standard */
--cbs-text-small:     0.875rem;                          /* Légendes, labels */
--cbs-text-xs:        0.75rem;                           /* Mentions, tags */

/* Line heights */
--cbs-leading-tight:  1.15;   /* Titres display */
--cbs-leading-snug:   1.3;    /* Titres H1-H2 */
--cbs-leading-normal: 1.5;    /* H3-H4 */
--cbs-leading-relaxed: 1.7;   /* Corps de texte */

/* Letter spacing */
--cbs-tracking-tight:  -0.02em;  /* Titres display */
--cbs-tracking-normal:  0em;
--cbs-tracking-wide:    0.08em;  /* Surtitre, labels uppercase */
--cbs-tracking-wider:   0.15em;  /* Tags, badges uppercase */
```

### Règles typographiques

- Les surtitres (type "Pôle Conseil", "Méthode") : `Montserrat`, uppercase, `--cbs-tracking-wide`, `--cbs-text-xs` ou `--cbs-text-small`, couleur `--cbs-gold`
- Les titres principaux : `Cormorant Garamond`, weight 400 ou 600, italique possible pour les accroches
- Les corps de texte : `Montserrat` 400, jamais en dessous de 1rem
- Les boutons : `Montserrat` 600, uppercase, `--cbs-tracking-wide`

---

## 4. Espacements

```css
/* Échelle d'espacement — base 4px */
--cbs-space-1:   0.25rem;   /*  4px */
--cbs-space-2:   0.5rem;    /*  8px */
--cbs-space-3:   0.75rem;   /* 12px */
--cbs-space-4:   1rem;      /* 16px */
--cbs-space-5:   1.25rem;   /* 20px */
--cbs-space-6:   1.5rem;    /* 24px */
--cbs-space-8:   2rem;      /* 32px */
--cbs-space-10:  2.5rem;    /* 40px */
--cbs-space-12:  3rem;      /* 48px */
--cbs-space-16:  4rem;      /* 64px */
--cbs-space-20:  5rem;      /* 80px */
--cbs-space-24:  6rem;      /* 96px */
--cbs-space-32:  8rem;      /* 128px */

/* Padding de section — généreux, luxe */
--cbs-section-py:     clamp(4rem, 8vw, 8rem);
--cbs-section-px:     clamp(1.5rem, 5vw, 4rem);

/* Container */
--cbs-container-max:  1280px;
--cbs-container-wide: 1440px;  /* Hero, plein écran */
```

---

## 5. Grille & Layout

```css
/* Grille principale */
--cbs-grid-cols:    12;
--cbs-grid-gap:     clamp(1rem, 2.5vw, 2rem);

/* Breakpoints */
--cbs-bp-sm:   640px;
--cbs-bp-md:   768px;
--cbs-bp-lg:   1024px;
--cbs-bp-xl:   1280px;
--cbs-bp-2xl:  1536px;
```

```css
/* Classe container standard */
.cbs-container {
    width: 100%;
    max-width: var(--cbs-container-max);
    margin-inline: auto;
    padding-inline: var(--cbs-section-px);
}

/* Grille CSS native */
.cbs-grid {
    display: grid;
    grid-template-columns: repeat(var(--cbs-grid-cols), 1fr);
    gap: var(--cbs-grid-gap);
}
```

---

## 6. Effets & Surfaces

```css
/* Ombres */
--cbs-shadow-sm:   0 1px 3px rgba(0,0,0,0.08);
--cbs-shadow-md:   0 4px 16px rgba(0,0,0,0.10);
--cbs-shadow-lg:   0 12px 40px rgba(0,0,0,0.14);
--cbs-shadow-gold: 0 4px 24px rgba(201,168,76,0.18); /* Hover cards accent */

/* Bordures */
--cbs-radius-sm:   4px;
--cbs-radius-md:   8px;
--cbs-radius-lg:   16px;
--cbs-radius-full: 9999px;  /* Badges, pills */

/* Séparateur doré */
--cbs-divider-gold: 1px solid var(--cbs-gold-muted);

/* Overlay hero (fond vidéo) */
--cbs-overlay-dark:   rgba(13, 17, 23, 0.55);
--cbs-overlay-silver: rgba(13, 17, 23, 0.35);
```

---

## 7. Boutons

```css
/* Bouton primaire — fond sombre, texte blanc */
.btn-primary {
    font-family: var(--cbs-font-sans);
    font-weight: 600;
    font-size: var(--cbs-text-small);
    letter-spacing: var(--cbs-tracking-wide);
    text-transform: uppercase;
    color: var(--cbs-white);
    background-color: var(--cbs-silver-900);
    border: 1px solid var(--cbs-silver-900);
    padding: var(--cbs-space-4) var(--cbs-space-8);
    border-radius: var(--cbs-radius-sm);
    transition: background-color 0.2s ease, border-color 0.2s ease;
}
.btn-primary:hover {
    background-color: var(--cbs-silver-700);
    border-color: var(--cbs-silver-700);
}

/* Bouton secondaire — contour gold */
.btn-secondary {
    font-family: var(--cbs-font-sans);
    font-weight: 600;
    font-size: var(--cbs-text-small);
    letter-spacing: var(--cbs-tracking-wide);
    text-transform: uppercase;
    color: var(--cbs-gold);
    background-color: transparent;
    border: 1px solid var(--cbs-gold);
    padding: var(--cbs-space-4) var(--cbs-space-8);
    border-radius: var(--cbs-radius-sm);
    transition: background-color 0.2s ease, color 0.2s ease;
}
.btn-secondary:hover {
    background-color: var(--cbs-gold);
    color: var(--cbs-white);
}

/* Bouton ghost — sur fonds sombres */
.btn-ghost {
    font-family: var(--cbs-font-sans);
    font-weight: 500;
    font-size: var(--cbs-text-small);
    letter-spacing: var(--cbs-tracking-wide);
    text-transform: uppercase;
    color: var(--cbs-white);
    background-color: transparent;
    border: 1px solid rgba(255,255,255,0.4);
    padding: var(--cbs-space-4) var(--cbs-space-8);
    border-radius: var(--cbs-radius-sm);
    transition: border-color 0.2s ease, background-color 0.2s ease;
}
.btn-ghost:hover {
    border-color: var(--cbs-white);
    background-color: rgba(255,255,255,0.08);
}
```

---

## 8. Animations & Transitions

```css
/* Transitions standard */
--cbs-transition-fast:   0.15s ease;
--cbs-transition-base:   0.25s ease;
--cbs-transition-slow:   0.4s ease;
--cbs-transition-reveal: 0.6s cubic-bezier(0.16, 1, 0.3, 1); /* Entrées scroll */
```

**Règles d'animation :**
- Pas de bibliothèque d'animation externe (pas de GSAP, AOS, Animate.css)
- Entrées au scroll via `Intersection Observer` natif + classe CSS `.is-visible`
- Durée max d'une animation décorative : 0.6s
- `prefers-reduced-motion` obligatoire :

```css
@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
        animation-duration: 0.01ms !important;
        transition-duration: 0.01ms !important;
    }
}
```

---

## 9. Tokens compilés — fichier `tokens.css`

> Ce fichier est importé en premier dans `main.css`.
> Il contient TOUTES les variables listées ci-dessus, sans styles appliqués.

```css
/* assets/css/base/tokens.css */
:root {

    /* === COULEURS === */
    /* Silver */
    --cbs-silver-50:  #F8F9FA;
    --cbs-silver-100: #F1F3F5;
    --cbs-silver-200: #DEE2E6;
    --cbs-silver-300: #CED4DA;
    --cbs-silver-400: #ADB5BD;
    --cbs-silver-500: #868E96;
    --cbs-silver-600: #495057;
    --cbs-silver-700: #343A40;
    --cbs-silver-800: #212529;
    --cbs-silver-900: #0D1117;

    /* Or */
    --cbs-gold-light: #F5E6C8;
    --cbs-gold:       #C9A84C;
    --cbs-gold-dark:  #A07830;
    --cbs-gold-muted: #E8D5A3;

    /* Neutres */
    --cbs-white: #FFFFFF;
    --cbs-black: #0A0A0A;

    /* Sémantiques */
    --cbs-success: #2D6A4F;
    --cbs-error:   #C0392B;
    --cbs-warning: #D4A017;
    --cbs-info:    #4A6FA5;

    /* Pôles */
    --cbs-pole-conseil-bg:     var(--cbs-silver-900);
    --cbs-pole-conseil-accent: var(--cbs-gold);
    --cbs-pole-conseil-text:   var(--cbs-white);
    --cbs-pole-gestion-bg:     var(--cbs-silver-50);
    --cbs-pole-gestion-accent: var(--cbs-gold-dark);
    --cbs-pole-gestion-text:   var(--cbs-silver-800);

    /* === TYPOGRAPHIE === */
    --cbs-font-serif:  'Cormorant Garamond', Georgia, serif;
    --cbs-font-sans:   'Montserrat', system-ui, sans-serif;

    --cbs-text-display:  clamp(3rem, 6vw, 5.5rem);
    --cbs-text-h1:       clamp(2.25rem, 4vw, 3.75rem);
    --cbs-text-h2:       clamp(1.75rem, 3vw, 2.75rem);
    --cbs-text-h3:       clamp(1.375rem, 2vw, 1.875rem);
    --cbs-text-h4:       clamp(1.125rem, 1.5vw, 1.375rem);
    --cbs-text-lead:     clamp(1.0625rem, 1.5vw, 1.25rem);
    --cbs-text-body:     1rem;
    --cbs-text-small:    0.875rem;
    --cbs-text-xs:       0.75rem;

    --cbs-leading-tight:   1.15;
    --cbs-leading-snug:    1.3;
    --cbs-leading-normal:  1.5;
    --cbs-leading-relaxed: 1.7;

    --cbs-tracking-tight:  -0.02em;
    --cbs-tracking-normal:  0em;
    --cbs-tracking-wide:    0.08em;
    --cbs-tracking-wider:   0.15em;

    /* === ESPACEMENTS === */
    --cbs-space-1:  0.25rem;
    --cbs-space-2:  0.5rem;
    --cbs-space-3:  0.75rem;
    --cbs-space-4:  1rem;
    --cbs-space-5:  1.25rem;
    --cbs-space-6:  1.5rem;
    --cbs-space-8:  2rem;
    --cbs-space-10: 2.5rem;
    --cbs-space-12: 3rem;
    --cbs-space-16: 4rem;
    --cbs-space-20: 5rem;
    --cbs-space-24: 6rem;
    --cbs-space-32: 8rem;

    --cbs-section-py:      clamp(4rem, 8vw, 8rem);
    --cbs-section-px:      clamp(1.5rem, 5vw, 4rem);
    --cbs-container-max:   1280px;
    --cbs-container-wide:  1440px;

    /* === LAYOUT === */
    --cbs-grid-cols: 12;
    --cbs-grid-gap:  clamp(1rem, 2.5vw, 2rem);

    /* === EFFETS === */
    --cbs-shadow-sm:   0 1px 3px rgba(0,0,0,0.08);
    --cbs-shadow-md:   0 4px 16px rgba(0,0,0,0.10);
    --cbs-shadow-lg:   0 12px 40px rgba(0,0,0,0.14);
    --cbs-shadow-gold: 0 4px 24px rgba(201,168,76,0.18);

    --cbs-radius-sm:   4px;
    --cbs-radius-md:   8px;
    --cbs-radius-lg:   16px;
    --cbs-radius-full: 9999px;

    --cbs-divider-gold:   1px solid var(--cbs-gold-muted);
    --cbs-overlay-dark:   rgba(13,17,23,0.55);
    --cbs-overlay-silver: rgba(13,17,23,0.35);

    /* === TRANSITIONS === */
    --cbs-transition-fast:   0.15s ease;
    --cbs-transition-base:   0.25s ease;
    --cbs-transition-slow:   0.4s ease;
    --cbs-transition-reveal: 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
```

---

## 10. À compléter quand la charte est finalisée

- [ ] Logo SVG (chemin : `/assets/images/logo.svg` + version claire `/logo-white.svg`)
- [ ] Favicon (`.ico` + `.png` 192px + `.png` 512px)
- [ ] Validation des codes hexa gold avec Camille
- [ ] Choix des grammages Cormorant Garamond utilisés (400 / 400i / 600 / 700 ?)
- [ ] Validation de l'échelle typographique sur mobile

---

*Référence : agents.md §9 (Direction artistique), wordpress-theme.md §7 (Nommage CSS)*
*Fichier suivant à consulter : content-structure.md, wordpress-theme.md*
