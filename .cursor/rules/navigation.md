# navigation.md — Navigation & Menus
# Conseil & Gestion des rituels du spa by Camille Becht

> Ce fichier documente le comportement et la structure de la navigation.
> Cursor doit s'y référer pour tout travail sur le header, le menu mobile
> et les états actifs des liens.

---

## 1. Structure de la navigation

### Menu principal — deux niveaux maximum

```
Accueil
Pôle Conseil ↓
  → La Méthode Spa Profit™
  → Diagnostic stratégique
  → Conception & sécurisation
  → Mise en performance
Pôle Gestion ↓
  → Gestion externalisée
  → Staffing & Renfort
  → Massages en chambre
Références
Diagnostic
Contact        ← CTA visuel distinct (bouton, pas lien)
```

**Règles :**
- Maximum 2 niveaux de profondeur
- Pas de mega menu — dropdown simple
- Le CTA "Contact" est toujours visible en dernier, stylé comme un bouton

---

## 2. Header — comportement

### Desktop
```
Position      : fixed en haut, pleine largeur
Fond initial  : transparent (sur hero video)
Fond au scroll: var(--cbs-silver-900) avec transition 0.3s
Logo          : à gauche
Menu          : centré ou à droite
CTA Contact   : bouton secondaire à l'extrémité droite
```

### Seuil de scroll pour le fond opaque
```javascript
// assets/js/nav.js
const SCROLL_THRESHOLD = 80; // px

window.addEventListener('scroll', () => {
    const header = document.querySelector('.site-header');
    header?.classList.toggle('is-scrolled', window.scrollY > SCROLL_THRESHOLD);
}, { passive: true }); // passive: true pour la performance
```

```css
/* assets/css/layout/header.css */
.site-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    background-color: transparent;
    transition: background-color var(--cbs-transition-slow);
}

.site-header.is-scrolled {
    background-color: var(--cbs-silver-900);
    box-shadow: var(--cbs-shadow-md);
}
```

---

## 3. Menu mobile

### Breakpoint de bascule
```css
/* Mobile : < 1024px → menu hamburger */
/* Desktop : ≥ 1024px → menu horizontal */
@media (max-width: 1023px) {
    .nav__menu { display: none; }
    .nav__toggle { display: block; }
}
```

### Structure HTML du bouton hamburger
```html
<button
    class="nav__toggle"
    type="button"
    aria-expanded="false"
    aria-controls="nav-menu"
    aria-label="Ouvrir le menu"
>
    <span class="nav__toggle-icon" aria-hidden="true"></span>
</button>

<nav id="nav-menu" class="nav__menu" aria-hidden="true" role="navigation"
     aria-label="Navigation principale">
    <!-- items du menu -->
</nav>
```

### Comportement JS (voir aussi accessibility.md §7)
```javascript
// assets/js/nav.js
const toggle   = document.querySelector('.nav__toggle');
const menu     = document.querySelector('.nav__menu');
const focusableEls = 'a, button, input, [tabindex]:not([tabindex="-1"])';

toggle?.addEventListener('click', () => {
    const isOpen = toggle.getAttribute('aria-expanded') === 'true';

    toggle.setAttribute('aria-expanded', String(!isOpen));
    menu.setAttribute('aria-hidden', String(isOpen));
    menu.classList.toggle('is-open', !isOpen);
    document.body.classList.toggle('menu-is-open', !isOpen);

    // Bloquer le scroll du body quand le menu est ouvert
    document.body.style.overflow = isOpen ? '' : 'hidden';

    if (!isOpen) {
        // Focus sur le premier lien à l'ouverture
        menu.querySelector(focusableEls)?.focus();
    }
});

// Fermer avec Escape
document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    if (toggle?.getAttribute('aria-expanded') !== 'true') return;

    toggle.setAttribute('aria-expanded', 'false');
    menu.setAttribute('aria-hidden', 'true');
    menu.classList.remove('is-open');
    document.body.classList.remove('menu-is-open');
    document.body.style.overflow = '';
    toggle.focus();
});

// Fermer en cliquant en dehors
document.addEventListener('click', (e) => {
    if (!menu.contains(e.target) && !toggle.contains(e.target)) {
        toggle.setAttribute('aria-expanded', 'false');
        menu.setAttribute('aria-hidden', 'true');
        menu.classList.remove('is-open');
        document.body.style.overflow = '';
    }
});
```

---

## 4. Dropdowns sous-menus

### Structure HTML
```html
<li class="nav__item nav__item--has-children">
    <button
        class="nav__link nav__link--parent"
        type="button"
        aria-expanded="false"
        aria-haspopup="true"
    >
        Pôle Conseil
        <svg class="nav__chevron" aria-hidden="true">...</svg>
    </button>

    <ul class="nav__dropdown" role="list" hidden>
        <li class="nav__dropdown-item">
            <a class="nav__dropdown-link" href="/methode-spa-profit/">
                La Méthode Spa Profit™
            </a>
        </li>
        <!-- autres items -->
    </ul>
</li>
```

### Comportement dropdown
```javascript
// Ouvrir/fermer au clic sur le parent
document.querySelectorAll('.nav__link--parent').forEach(btn => {
    btn.addEventListener('click', () => {
        const isOpen  = btn.getAttribute('aria-expanded') === 'true';
        const dropdown = btn.nextElementSibling;

        // Fermer tous les autres dropdowns
        document.querySelectorAll('.nav__link--parent').forEach(other => {
            if (other !== btn) {
                other.setAttribute('aria-expanded', 'false');
                other.nextElementSibling?.setAttribute('hidden', '');
            }
        });

        btn.setAttribute('aria-expanded', String(!isOpen));
        if (isOpen) {
            dropdown?.setAttribute('hidden', '');
        } else {
            dropdown?.removeAttribute('hidden');
            dropdown?.querySelector('a')?.focus();
        }
    });
});

// Fermer au clic en dehors (tout clic hors .nav__item--has-children)
document.addEventListener('click', (e) => {
    if (e.target.closest('.nav__item--has-children')) return;
    document.querySelectorAll('.nav__link--parent').forEach((btn) => {
        btn.setAttribute('aria-expanded', 'false');
        btn.nextElementSibling?.setAttribute('hidden', '');
    });
});

document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    if (document.querySelector('.nav__toggle')?.getAttribute('aria-expanded') === 'true') return;
    const open = document.querySelector('.nav__link--parent[aria-expanded="true"]');
    if (!open) return;
    open.setAttribute('aria-expanded', 'false');
    open.nextElementSibling?.setAttribute('hidden', '');
    open.focus();
});
```

---

## 5. États actifs

```php
// inc/helpers.php — classe active sur le lien courant
function cbs_nav_active_class( string $url ): string {
    $current = trailingslashit( get_permalink() ?: home_url('/') );
    $target  = trailingslashit( $url );
    return $current === $target ? ' aria-current="page"' : '';
}
```

```html
<!-- Dans le template nav -->
<a class="nav__link" href="/methode-spa-profit/"
   <?php echo cbs_nav_active_class('/methode-spa-profit/'); ?>>
    Pôle Conseil
</a>
```

```css
/* Lien actif */
.nav__link[aria-current="page"] {
    color: var(--cbs-gold);
    border-bottom: 1px solid var(--cbs-gold);
}
```

---

## 6. Enregistrement des menus WordPress

```php
// inc/setup.php — dans cbs_theme_setup()
register_nav_menus([
    'primary'   => __( 'Navigation principale', 'cbs-theme' ),
    'footer-1'  => __( 'Footer — Colonne 1', 'cbs-theme' ),
    'footer-2'  => __( 'Footer — Colonne 2', 'cbs-theme' ),
    'legal'     => __( 'Mentions légales', 'cbs-theme' ),
]);
// add_action( 'after_setup_theme', 'cbs_theme_setup' );
```

> Le fichier `inc/menus.php` reste un point d’extension ; l’enregistrement des emplacements est centralisé dans `cbs_theme_setup()`.

---

## 7. Checklist navigation

- [ ] Header transparent sur hero, opaque au scroll
- [ ] Transition background-color fluide (0.4s)
- [ ] Menu mobile avec `aria-expanded` + `aria-hidden` corrects
- [ ] Fermeture menu mobile avec Escape
- [ ] Fermeture menu mobile au clic en dehors
- [ ] Scroll body bloqué quand menu mobile ouvert
- [ ] Dropdowns fermés quand on en ouvre un autre
- [ ] Dropdowns fermés au clic en dehors du bloc item + sous-menu
- [ ] Dropdowns fermés avec Escape (desktop) ; sous-menus réinitialisés à la fermeture du menu mobile
- [ ] `aria-current="page"` sur le lien actif
- [ ] CTA Contact styé différemment des liens nav
- [ ] Skip link fonctionnel (voir accessibility.md §2)
- [ ] Focus management testé au clavier

---

*Référence : accessibility.md §7 (navigation clavier), design-system.md §7 (transitions)*
