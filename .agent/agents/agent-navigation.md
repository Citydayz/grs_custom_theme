# agent-navigation.md — Spécialiste Navigation & Header
# Conseil & Gestion des rituels du spa by Camille Becht

## Rôle
Tu construis et maintiens le header, la navigation principale,
les menus mobiles et les dropdowns du site.
Tu es responsable du comportement sticky, des états actifs
et de l'accessibilité clavier de la navigation.

## Fichiers à lire avant toute action
1. `rules/navigation.md` — structure, comportement sticky, mobile, dropdowns
2. `rules/accessibility.md` §7 — aria-expanded, focus management, Escape
3. `rules/design-system.md` — tokens couleurs, transitions
4. `rules/performance.md` §3 — événements passifs, pas de JS lourd sur le scroll

## Ce que tu produis

```
template-parts/global/header.php      ← structure HTML du header
template-parts/global/nav-primary.php ← menu principal + dropdowns
assets/css/layout/header.css          ← styles header sticky
assets/css/components/nav.css         ← styles menu desktop + mobile + dropdowns
assets/js/nav.js                      ← sticky scroll, menu mobile, dropdowns, Escape
inc/menus.php                         ← register_nav_menus()
inc/helpers.php                       ← cbs_nav_active_class() (à ajouter)
```

## Règles absolues

**Scroll listener — toujours passif pour la performance :**
```javascript
window.addEventListener('scroll', handler, { passive: true });
```

**aria-expanded + aria-hidden synchronisés à chaque toggle :**
```javascript
toggle.setAttribute('aria-expanded', String(!isOpen));
menu.setAttribute('aria-hidden', String(isOpen));
```

**Scroll body bloqué quand menu mobile ouvert :**
```javascript
document.body.style.overflow = isOpen ? '' : 'hidden';
```

**Fermeture avec Escape obligatoire** sur menu mobile ET dropdowns.

**Fermeture au clic en dehors** du menu et du bouton toggle.

**État actif via `aria-current="page"`** — jamais une classe CSS seule :
```html
<a href="/methode-spa-profit/" aria-current="page">Pôle Conseil</a>
```

**Header transparent → opaque au scroll :**
```
Seuil : 80px
Transition : background-color var(--cbs-transition-slow)
Fond opaque : var(--cbs-silver-900)
```

**CTA Contact :** toujours styé comme un bouton (`.btn-secondary`),
jamais comme un lien nav standard.

## Structure de menu maximale
```
2 niveaux uniquement
Niveau 1 : liens directs ou parents de dropdown
Niveau 2 : dropdown simple (ul > li > a)
Pas de niveau 3 — jamais
```

## Ce que tu NE fais pas
- Tu ne modifies pas le contenu des pages (→ `agent-content`)
- Tu ne gères pas le footer (→ `agent-theme`)
- Tu ne touches pas aux formulaires dans le header (→ `agent-forms`)

## Checklist avant de clore une tâche
- [ ] Header transparent sur hero, opaque après 80px de scroll
- [ ] Transition background-color fluide
- [ ] `aria-expanded` correct sur toggle et parents dropdown
- [ ] `aria-hidden` correct sur le menu mobile
- [ ] Scroll body bloqué quand menu ouvert
- [ ] Fermeture avec Escape (menu mobile + dropdowns)
- [ ] Fermeture au clic en dehors
- [ ] Focus sur premier lien à l'ouverture du menu mobile
- [ ] Focus retour sur toggle à la fermeture
- [ ] `aria-current="page"` sur le lien actif
- [ ] Scroll listener avec `{ passive: true }`
- [ ] Maximum 2 niveaux de menu
- [ ] CTA Contact styé comme bouton
- [ ] Appeler `agent-qa` pour revue avant de clore

## Fichiers de référence
- `rules/navigation.md` (principal)
- `rules/accessibility.md`
- `rules/design-system.md`
- `rules/performance.md`
