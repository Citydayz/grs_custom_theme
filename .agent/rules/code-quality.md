# code-quality.md — Qualité de Code
# Conseil & Gestion des rituels du spa by Camille Becht

> Règles de qualité applicables à tout le code du thème.
> Cursor doit les respecter sur chaque fichier PHP, JS et CSS produit.

---

## 1. Principes fondamentaux

### DRY — Don't Repeat Yourself
- Toute logique utilisée plus d'une fois devient une fonction dans `inc/helpers.php`
- Tout bloc HTML réutilisable devient un `template-part` via `get_template_part()`
- Toute valeur répétée (URL, texte, couleur) devient une constante ou une variable CSS

### KISS — Keep It Simple, Stupid
- Préférer la solution la plus simple qui fonctionne
- Pas de pattern complexe (Factory, Observer…) là où une fonction suffit
- Si une fonction nécessite plus de 20 lignes d'explication, la refactoriser

### YAGNI — You Aren't Gonna Need It
- Ne pas coder de fonctionnalité "pour plus tard"
- Pas de paramètres optionnels non utilisés
- Pas de code commenté laissé en place — supprimer ou committer

---

## 2. Taille et responsabilité des fonctions

```
Règle : une fonction = une responsabilité
Taille max recommandée : 30 lignes
Taille max absolue     : 50 lignes — au-delà, décomposer obligatoirement
Arguments max          : 4 — au-delà, passer un tableau $args
```

**Bon exemple :**
```php
// Une fonction, une responsabilité
function cbs_get_diagnostic_niveau( int $score ): string {
    if ( $score >= 22 ) return 'A';
    if ( $score >= 13 ) return 'B';
    return 'C';
}

function cbs_build_diagnostic_payload( array $post_data ): array {
    return [
        'Prénom'         => sanitize_text_field( $post_data['prenom'] ?? '' ),
        'Nom'            => sanitize_text_field( $post_data['nom'] ?? '' ),
        'Email'          => sanitize_email( $post_data['email'] ?? '' ),
        'Score'          => absint( $post_data['score'] ?? 0 ),
    ];
}
```

**Mauvais exemple — god function :**
```php
// ❌ Trop de responsabilités dans une seule fonction
function cbs_handle_everything( $data ) {
    // valide, sanitize, calcule le score, envoie à Airtable,
    // déclenche Make, envoie l'email, retourne la réponse...
}
```

---

## 3. Nommage

### PHP
```
Fonctions   : cbs_[verbe]_[nom]         → cbs_get_niveau(), cbs_send_to_airtable()
Variables   : $snake_case               → $score_total, $airtable_record
Constantes  : CBS_[NOM_MAJUSCULE]       → CBS_AIRTABLE_BASE_ID
Classes     : CbsPascalCase             → CbsDiagnosticHandler (si classes utilisées)
Hooks WP    : 'cbs_[nom_action]'        → 'cbs_diagnostic_submitted'
```

### CSS (BEM — rappel)
```
Block       : .hero, .card-offre, .tunnel
Element     : .hero__title, .card-offre__tag
Modifier    : .hero--conseil, .btn--disabled
```

### JS
```
Variables   : camelCase                 → const scoreTotal, let currentStep
Fonctions   : camelCase verbe + nom     → calculerScore(), afficherResultat()
Constantes  : UPPER_SNAKE_CASE         → const MAX_STEPS = 10
```

### Fichiers
```
PHP         : kebab-case                → api-airtable.php, tunnel-step.php
CSS         : kebab-case                → design-system.css, tunnel.css
JS          : kebab-case                → tunnel.js, nav.js
```

---

## 4. Structure des fichiers PHP

Chaque fichier PHP du thème doit commencer par :

```php
<?php
/**
 * [Description courte du fichier]
 *
 * @package CBS_Theme
 */

defined( 'ABSPATH' ) || exit;
```

- Pas de balise fermante `?>` en fin de fichier PHP pur
- Une ligne vide entre les blocs logiques
- Les `require_once` uniquement dans `functions.php`

---

## 5. Commentaires

```php
// Commentaire inline : une ligne, explique le POURQUOI pas le QUOI
$score = array_sum( $reponses ); // 0 à 30 — calculé côté serveur pour éviter la falsification JS

/**
 * Docblock obligatoire sur toutes les fonctions publiques.
 *
 * @param int    $score  Score brut du diagnostic (0-30)
 * @return string        Niveau : 'A', 'B' ou 'C'
 */
function cbs_get_diagnostic_niveau( int $score ): string {}
```

**Interdit :**
```php
// ❌ Code commenté laissé en place
// $old_result = cbs_old_function( $data );

// ❌ Commentaire qui répète le code
$score = 0; // on met le score à zéro
```

---

## 6. Typage PHP

Toujours typer les paramètres et retours des fonctions :

```php
// ✅ Typé
function cbs_get_diagnostic_niveau( int $score ): string {}
function cbs_send_to_airtable( string $table_id, array $fields ): array|WP_Error {}
function cbs_find_airtable_record( string $table, string $field, string $value ): ?array {}

// ❌ Non typé
function cbs_get_niveau( $score ) {}
```

---

## 7. Interdictions absolues

```php
// ❌ Variables globales
global $cbs_config;

// ❌ extract() — crée des variables invisibles
extract( $_POST );

// ❌ eval()
eval( $user_input );

// ❌ Concatenation SQL directe (utiliser $wpdb->prepare())
$wpdb->query( "SELECT * WHERE id = " . $_GET['id'] );

// ❌ Suppression d'erreurs avec @
$result = @file_get_contents( $url );

// ❌ die() / exit() dans les templates (sauf ABSPATH check)
die( 'Erreur' );
```

---

## 8. JS — règles spécifiques

```javascript
// ✅ const par défaut, let si réassignation nécessaire, jamais var
const score = calculerScore();
let currentStep = 1;

// ✅ Fonctions fléchées pour les callbacks
const options = reponses.map( pts => pts * 2 );

// ✅ Async/await plutôt que .then()
async function soumettreDiagnostic( formData ) {
    const response = await fetch( cbsAjax.url, { method: 'POST', body: formData });
    const data = await response.json();
}

// ❌ var
var score = 0;

// ❌ Manipulation DOM en dehors du DOMContentLoaded
document.querySelector('.btn').addEventListener(...); // peut échouer si DOM pas prêt
```

---

*Référence : wordpress-theme.md §4 (conventions PHP/CSS/JS)*
