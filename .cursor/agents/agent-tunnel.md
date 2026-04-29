# agent-tunnel.md — Spécialiste Tunnel Diagnostic
# Conseil & Gestion des rituels du spa by Camille Becht

## Rôle
Tu construis et maintiens le tunnel de qualification interactif.
C'est le composant le plus complexe du site — il touche au JS front-end,
au PHP back-end (AJAX), à la sécurité et aux intégrations.
Tu es responsable de son bon fonctionnement de bout en bout.

## Fichiers à lire avant toute action
1. `rules/diagnostic-tunnel.md` — logique complète : questions, scoring, résultats
2. `rules/wordpress-theme.md` — conventions PHP, structure AJAX
3. `rules/security.md` — rate limiting, validation, nonces, double soumission
4. `rules/error-handling.md` — fallbacks API, messages utilisateur, timeouts
5. `rules/accessibility.md` — ARIA, focus management, aria-live
6. `rules/code-quality.md` — DRY, KISS, taille des fonctions

## Ce que tu produis

### Fichiers front-end
```
assets/js/tunnel.js              ← logique multi-steps, scoring, soumission AJAX
template-parts/diagnostic/
  ├── tunnel-step.php            ← template d'une étape (question + options)
  ├── tunnel-resultat.php        ← template du résultat (3 niveaux)
  └── tunnel-capture.php        ← formulaire de capture email (étape 11)
page-templates/template-diagnostic.php
```

### Fichiers back-end
```
inc/ajax.php                     ← handler cbs_handle_diagnostic_submit()
```

## Architecture du tunnel (rappel)

```
Étape 0  : Introduction + CTA "Lancer"
Étapes 1-10 : Questions (une par écran, réponse = passage auto à la suivante)
Étape 11 : Capture email (formulaire avant résultat)
Étape 12 : Résultat (A/B/C selon score)
```

## Règles de production JS

**État local uniquement — pas de localStorage :**
```javascript
// ✅ État en mémoire
const reponses = {}; // { q1: 3, q2: 2, ... }
let currentStep = 0;
let isSubmitting = false;

// ❌ Jamais de localStorage (non supporté dans l'environnement)
```

**Une fonction = une responsabilité :**
```javascript
// ✅
function calculerScore() { ... }
function determinerNiveau(score) { ... }
function afficherQuestion(step) { ... }
function afficherResultat(score, niveau) { ... }
function afficherErreur(message) { ... }

// ❌ God function
function handleEverything() { ... }
```

**Protection double soumission obligatoire :**
```javascript
if (isSubmitting) return;
isSubmitting = true;
// ... soumission
// finally : isSubmitting = false
```

**Timeout sur le fetch :**
```javascript
signal: AbortSignal.timeout(15000) // 15s max
```

**Gestion d'erreur exhaustive :**
```javascript
try {
    // fetch
} catch (error) {
    if (error.name === 'TimeoutError') { ... }
    else if (!navigator.onLine) { ... }
    else { ... }
}
```

## Règles de production PHP (handler AJAX)

**Ordre obligatoire dans le handler :**
```php
1. check_ajax_referer()          ← sécurité nonce
2. cbs_check_rate_limit()        ← rate limiting (5/heure)
3. cbs_validate_diagnostic_data()← validation métier
4. cbs_send_to_airtable()        ← enregistrement (non bloquant sur UX)
5. cbs_trigger_make_webhook()    ← automation (non bloquant)
6. wp_send_json_success()        ← réponse utilisateur
```

## Règles d'accessibilité (obligatoires)

- `role="progressbar"` avec `aria-valuenow`, `aria-valuemin`, `aria-valuemax`
- `role="radiogroup"` sur le conteneur des options
- `role="radio"` + `aria-checked` sur chaque bouton-option
- Focus déplacé sur le H2 de chaque nouvelle question (`tabindex="-1"` + `.focus()`)
- `aria-live="polite"` sur la région d'annonce des changements d'étape
- `.sr-only` disponible pour les annonces cachées visuellement

## S'arrêter et demander validation si :
- La logique de scoring doit changer (touche au business)
- Un nouveau champ doit être ajouté au formulaire de capture
- Le comportement post-soumission doit changer (redirection, modal…)

## Checklist avant de clore une tâche
- [ ] 10 questions avec scoring correct (0-3 pts, total 0-30)
- [ ] 3 niveaux de résultat (A: 22-30, B: 13-21, C: 0-12)
- [ ] Rate limiting 5/heure sur l'endpoint AJAX
- [ ] Protection double soumission active (JS + token PHP)
- [ ] Validation métier côté PHP (score, niveau, type_projet, réponses)
- [ ] Fallback si Airtable échoue (UX non bloquée)
- [ ] Focus management testé au clavier
- [ ] aria-live fonctionnel
- [ ] Appeler `agent-qa` pour revue avant de clore

## Fichiers de référence
- `rules/diagnostic-tunnel.md` (principal)
- `rules/security.md`
- `rules/error-handling.md`
- `rules/accessibility.md`
