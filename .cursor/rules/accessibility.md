# accessibility.md — Accessibilité (WCAG AA)
# Conseil & Gestion des rituels du spa by Camille Becht

> Règles d'accessibilité applicables à tout le thème.
> Cible : conformité WCAG 2.1 niveau AA.
> Cursor doit appliquer ces règles sur tous les templates HTML,
> composants JS et formulaires — en particulier le tunnel diagnostic.

---

## 1. Contraste des couleurs — palette CBS

Vérification des contrastes selon WCAG AA (ratio minimum 4.5:1 pour le texte normal,
3:1 pour le texte large ≥ 18px ou gras ≥ 14px).

| Combinaison | Ratio | Statut |
|---|---|---|
| `--cbs-silver-900` (#0D1117) sur `--cbs-white` | 19.5:1 | ✅ AAA |
| `--cbs-silver-800` (#212529) sur `--cbs-silver-50` | 14.7:1 | ✅ AAA |
| `--cbs-silver-600` (#495057) sur `--cbs-white` | 7.0:1 | ✅ AA |
| `--cbs-gold` (#C9A84C) sur `--cbs-silver-900` | 6.2:1 | ✅ AA |
| `--cbs-gold` (#C9A84C) sur `--cbs-white` | 2.8:1 | ❌ Échec — ne pas utiliser pour du texte |
| `--cbs-white` sur `--cbs-gold` | 2.8:1 | ❌ Échec — ne pas utiliser pour du texte |
| `--cbs-silver-500` (#868E96) sur `--cbs-white` | 3.9:1 | ⚠️ AA large uniquement |

**Règles dérivées :**
- `--cbs-gold` uniquement pour bordures, icônes, ornements et CTA avec fond sombre
- Texte sur fond gold : toujours `--cbs-silver-900`, jamais blanc
- `--cbs-silver-500` uniquement pour les textes ≥ 18px ou en gras ≥ 14px

---

## 2. Structure sémantique HTML

```html
<body>
    <a href="#main-content" class="skip-link">Aller au contenu principal</a>

    <header role="banner">
        <nav role="navigation" aria-label="Navigation principale">
        </nav>
    </header>

    <main id="main-content" role="main">
    </main>

    <footer role="contentinfo">
    </footer>
</body>
```

```css
/* skip-link : visible uniquement au focus clavier */
.skip-link {
    position: absolute;
    top: -100%;
    left: 1rem;
    background: var(--cbs-silver-900);
    color: var(--cbs-white);
    padding: var(--cbs-space-3) var(--cbs-space-6);
    z-index: 9999;
    transition: top var(--cbs-transition-fast);
}
.skip-link:focus {
    top: 1rem;
}
```

---

## 3. Focus visible — règle absolue

```css
/* ❌ INTERDIT — ne jamais supprimer l'outline sans alternative */
/* * { outline: none; } */

/* ✅ Personnaliser dans la charte */
:focus-visible {
    outline: 2px solid var(--cbs-gold);
    outline-offset: 3px;
    border-radius: var(--cbs-radius-sm);
}

/* Sur fonds sombres */
.hero :focus-visible,
.section--dark :focus-visible {
    outline-color: var(--cbs-white);
}
```

---

## 4. Tunnel diagnostic — accessibilité spécifique

### Structure ARIA du tunnel

```html
<section
    class="tunnel__step"
    role="group"
    aria-labelledby="question-1"
    aria-live="polite"
>
    <div class="tunnel__progress"
         role="progressbar"
         aria-valuenow="1"
         aria-valuemin="1"
         aria-valuemax="10"
         aria-label="Question 1 sur 10">
        <div class="tunnel__progress-fill" style="width: 10%"></div>
    </div>

    <h2 class="tunnel__question" id="question-1" tabindex="-1">
        Texte de la question
    </h2>

    <div class="tunnel__options" role="radiogroup" aria-labelledby="question-1">
        <button type="button" role="radio" aria-checked="false"
                class="tunnel__option" data-points="3">
            Oui, dès le départ
        </button>
    </div>
</section>

<!-- Région aria-live cachée pour les annonces aux lecteurs d'écran -->
<div id="tunnel-live-region" aria-live="polite" aria-atomic="true" class="sr-only"></div>
```

### Focus management entre étapes (JS)

```javascript
// assets/js/tunnel.js
function afficherQuestion( stepNumber ) {
    const currentStep = document.querySelector('.tunnel__step.is-active');
    if ( currentStep ) {
        currentStep.classList.remove('is-active');
        currentStep.setAttribute('aria-hidden', 'true');
    }

    const nextStep = document.querySelector(`.tunnel__step[data-step="${stepNumber}"]`);
    if ( ! nextStep ) return;

    nextStep.classList.add('is-active');
    nextStep.removeAttribute('aria-hidden');

    // Déplacer le focus sur le titre — critique pour clavier et lecteurs d'écran
    const questionTitle = nextStep.querySelector('.tunnel__question');
    if ( questionTitle ) questionTitle.focus();

    // Annoncer le changement d'étape
    const liveRegion = document.getElementById('tunnel-live-region');
    if ( liveRegion ) liveRegion.textContent = `Question ${stepNumber} sur 10`;
}
```

```css
/* Visuellement caché mais lisible par les lecteurs d'écran */
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}
```

---

## 5. Formulaires accessibles

```html
<div class="form__group">
    <label class="form__label" for="cbs-email">
        Adresse email <span aria-label="champ obligatoire">*</span>
    </label>
    <input
        class="form__input"
        type="email"
        id="cbs-email"
        name="email"
        required
        aria-required="true"
        aria-describedby="cbs-email-error"
        autocomplete="email"
    >
    <span class="form__error" id="cbs-email-error"
          role="alert" aria-live="assertive" hidden>
        Veuillez entrer une adresse email valide.
    </span>
</div>
```

**Règles :**
- `<label>` associé à chaque `<input>` via `for` + `id`
- `aria-required="true"` sur les champs obligatoires
- `aria-describedby` pointant vers le message d'erreur
- `role="alert"` + `aria-live="assertive"` sur les erreurs
- `autocomplete` renseigné sur les champs standards
- Jamais de placeholder comme seule indication du champ

---

## 6. Images et médias

```html
<!-- Image informative -->
<img src="spa-hotel.webp"
     alt="Cabine de soin d'un hôtel 4 étoiles en Alsace" ...>

<!-- Image décorative -->
<img src="ornement.webp" alt="" role="presentation" ...>

<!-- Vidéo hero background — cachée aux lecteurs d'écran -->
<video autoplay muted loop playsinline aria-hidden="true">
    <source src="hero.webm" type="video/webm">
    <source src="hero.mp4"  type="video/mp4">
</video>
```

---

## 7. Navigation au clavier — menu mobile

```javascript
// assets/js/nav.js
const menuBtn  = document.querySelector('.nav__toggle');
const menuList = document.querySelector('.nav__menu');

menuBtn?.addEventListener('click', () => {
    const isOpen = menuBtn.getAttribute('aria-expanded') === 'true';
    menuBtn.setAttribute('aria-expanded', String(!isOpen));
    menuList.setAttribute('aria-hidden',  String(isOpen));

    if (!isOpen) {
        menuList.querySelector('a')?.focus(); // focus premier lien à l'ouverture
    } else {
        menuBtn.focus(); // retour au bouton à la fermeture
    }
});

// Fermer avec Escape
document.addEventListener('keydown', (e) => {
    if ( e.key === 'Escape' && menuBtn?.getAttribute('aria-expanded') === 'true' ) {
        menuBtn.setAttribute('aria-expanded', 'false');
        menuList.setAttribute('aria-hidden', 'true');
        menuBtn.focus();
    }
});
```

---

## 8. Checklist accessibilité — avant mise en ligne

**Contraste**
- [ ] Texte blanc sur gold interdit (ratio insuffisant)
- [ ] `--cbs-silver-500` uniquement sur grands textes
- [ ] Vérification avec axe DevTools ou WAVE

**Navigation clavier**
- [ ] Skip link visible au focus
- [ ] Ordre de tabulation logique sur toutes les pages
- [ ] Focus visible sur tous les éléments interactifs
- [ ] Menu mobile fermable avec Escape

**Tunnel diagnostic**
- [ ] Focus déplacé automatiquement à chaque changement d'étape
- [ ] Progressbar avec attributs ARIA corrects
- [ ] Annonces aria-live fonctionnelles (tester avec VoiceOver/NVDA)
- [ ] Options cliquables au clavier (Enter + Space)

**Formulaires**
- [ ] Chaque input a un label associé
- [ ] Messages d'erreur avec role="alert"
- [ ] Champs obligatoires marqués visuellement ET aria-required

**Médias**
- [ ] Images informatives : alt descriptif
- [ ] Images décoratives : alt="" et role="presentation"
- [ ] Vidéo hero : aria-hidden="true"

---

*Référence : design-system.md §2 (palette couleurs), diagnostic-tunnel.md §9 (HTML tunnel)*
