# diagnostic-tunnel.md — Tunnel de Qualification Interactif
# Conseil & Gestion des rituels du spa by Camille Becht

> Ce fichier décrit la logique complète du diagnostic interactif :
> questions, scoring, segmentation des profils, résultats affichés,
> capture email et déclenchement des automations.
> Cursor doit s'y référer pour tout travail sur le tunnel front-end (JS)
> et les handlers AJAX back-end (PHP).

---

## 1. Vue d'ensemble

Le diagnostic est un formulaire multi-étapes (10 questions) qui :
1. Qualifie le visiteur sur 4 dimensions (conception, exploitation, expérience client, organisation)
2. Calcule un score sur 30
3. Capture les coordonnées avant d'afficher le résultat
4. Affiche un résultat personnalisé selon le score
5. Enregistre le lead dans Airtable
6. Déclenche les automations Make (notification interne + lead magnet + relance)

**URL :** `/diagnostic/`
**Template PHP :** `page-templates/template-diagnostic.php`
**JS :** `assets/js/tunnel.js`
**AJAX handler :** `inc/ajax.php` → `cbs_handle_diagnostic_submit()`

---

## 2. Structure du tunnel (étapes front-end)

```
Étape 0 — Introduction         (pas de question, CTA "Lancer le diagnostic")
Étapes 1 à 10 — Questions       (une question par écran)
Étape 11 — Capture email        (formulaire coordonnées avant résultat)
Étape 12 — Résultat             (affiché selon score + CTA personnalisé)
```

**Barre de progression** visible à chaque étape (1/10, 2/10…).
**Navigation :** bouton "Suivant" après chaque réponse — pas de retour arrière (UX tunnel).
**Pas de rechargement de page** — tout en JS, soumission finale via AJAX.

---

## 3. Écran d'introduction (Étape 0)

```
SURTITRE : "Diagnostic Spa Hôtelier"
TITRE    : "Votre spa est-il réellement pensé pour être rentable ?"
TEXTE    : "Un spa peut être esthétique, bien équipé et pourtant difficile
            à exploiter au quotidien. En 3 minutes, ce diagnostic vous aide
            à identifier les principaux points de vigilance de votre projet
            ou de votre spa existant."

4 DIMENSIONS ANALYSÉES :
  ① Conception des espaces
  ② Fluidité d'exploitation
  ③ Expérience client
  ④ Organisation opérationnelle

CTA      : "Lancer le diagnostic" (→ Question 1)
MENTION  : "3 minutes · 10 questions · Résultat immédiat"
```

---

## 4. Les 10 questions

### Système de scoring

Chaque question propose 4 réponses avec les points suivants :

| Position | Signification | Points |
|---|---|---|
| Réponse A | Situation optimale | 3 |
| Réponse B | Situation partielle | 2 |
| Réponse C | Situation défavorable | 1 |
| Réponse D | Incertitude totale | 0 |

**Score total : 0 à 30 points.**

---

### Q1 — Dimension : Conception

```
QUESTION :
"Votre spa a-t-il été conçu avec une expertise d'exploitation spa intégrée
au projet ?"

RÉPONSES :
A (3pts) — Oui, dès le départ
B (2pts) — Partiellement
C (1pt)  — Non
D (0pt)  — Je ne sais pas / Projet en cours
```

---

### Q2 — Dimension : Conception

```
QUESTION :
"Les cabines de soins sont-elles dimensionnées de manière confortable
pour les équipes et les clients ?"

RÉPONSES :
A (3pts) — Oui, parfaitement
B (2pts) — Globalement oui
C (1pt)  — Pas vraiment
D (0pt)  — Je ne sais pas
```

---

### Q3 — Dimension : Conception

```
QUESTION :
"La ventilation, l'humidité et le renouvellement de l'air ont-ils été
pensés spécifiquement pour l'usage spa ?"

RÉPONSES :
A (3pts) — Oui
B (2pts) — Partiellement
C (1pt)  — Non
D (0pt)  — Je ne sais pas
```

---

### Q4 — Dimension : Exploitation

```
QUESTION :
"Les circulations clients, équipes et linge sont-elles fluides
et bien séparées ?"

RÉPONSES :
A (3pts) — Oui
B (2pts) — Partiellement
C (1pt)  — Non
D (0pt)  — Je ne sais pas
```

---

### Q5 — Dimension : Expérience client

```
QUESTION :
"Les espaces humides, techniques et de détente sont-ils cohérents
avec le niveau de gamme de votre hôtel ?"

RÉPONSES :
A (3pts) — Oui
B (2pts) — Partiellement
C (1pt)  — Non
D (0pt)  — Je ne sais pas
```

---

### Q6 — Dimension : Exploitation

```
QUESTION :
"Votre spa est-il simple à exploiter au quotidien pour les équipes ?"

RÉPONSES :
A (3pts) — Oui
B (2pts) — Assez
C (1pt)  — Non
D (0pt)  — Je ne sais pas
```

---

### Q7 — Dimension : Performance

```
QUESTION :
"Le spa génère-t-il aujourd'hui les résultats attendus pour l'hôtel ?"

RÉPONSES :
A (3pts) — Oui
B (2pts) — En partie
C (1pt)  — Non
D (0pt)  — Pas encore ouvert / Projet en cours
```

---

### Q8 — Dimension : Expérience client

```
QUESTION :
"L'offre de soins et l'organisation du spa sont-elles adaptées
à votre clientèle cible ?"

RÉPONSES :
A (3pts) — Oui
B (2pts) — En partie
C (1pt)  — Non
D (0pt)  — Je ne sais pas
```

---

### Q9 — Dimension : Organisation

```
QUESTION :
"Avez-vous identifié des points de friction récurrents
dans l'exploitation ?"

RÉPONSES :
A (3pts) — Non, aucun
B (2pts) — Quelques-uns
C (1pt)  — Oui, plusieurs
D (0pt)  — Je ne sais pas encore
```

---

### Q10 — Dimension : Performance

```
QUESTION :
"Pensez-vous qu'une erreur de conception ou d'organisation pourrait
freiner durablement la rentabilité du spa ?"

RÉPONSES :
A (3pts) — Non
B (2pts) — Peut-être
C (1pt)  — Oui
D (0pt)  — C'est déjà le cas
```

---

## 5. Étape 11 — Capture email (avant résultat)

```
TITRE  : "Recevez votre résultat détaillé"
TEXTE  : "Indiquez vos coordonnées pour accéder à votre niveau de diagnostic
          et recevoir vos points de vigilance prioritaires."

CHAMPS FORMULAIRE :
  - Prénom *
  - Nom *
  - Hôtel / Société *
  - Email * (validation format)
  - Téléphone
  - Type de projet * (select) :
      → Création d'un spa
      → Spa existant à optimiser
      → Réflexion stratégique
      → Gestion / staffing

MENTIONS LÉGALES : case à cocher RGPD obligatoire
CTA    : "Voir mon résultat"
```

**À la soumission :**
1. Données + score envoyés via AJAX → `cbs_handle_diagnostic_submit()`
2. Enregistrement Airtable (via `inc/api-airtable.php`)
3. Notification interne mail (Make)
4. Envoi lead magnet PDF (Make → Brevo)
5. Affichage résultat Étape 12

---

## 6. Étape 12 — Résultats (3 niveaux)

### Résultat A — Score 22 à 30 : Spa globalement bien structuré

```
BADGE    : "Score [X]/30 — Bases solides"  (couleur : gold)
TITRE    : "Votre spa semble reposer sur des bases solides."
TEXTE    : "Cela ne signifie pas qu'aucune optimisation n'est possible,
            mais la structure générale paraît cohérente sur les dimensions
            essentielles : conception, exploitation et expérience client.
            Des ajustements ciblés peuvent encore améliorer la performance."

ÉTUDE DE CAS SUGGÉRÉE : type "Optimisation spa existant"

CTA PRINCIPAL  : "Échanger sur les optimisations possibles" → /contact/
CTA SECONDAIRE : "Découvrir la Méthode Spa Profit™" → /methode-spa-profit/

LEAD MAGNET ENVOYÉ : "Guide des questions à se poser pour optimiser son spa"
```

---

### Résultat B — Score 13 à 21 : Points de vigilance à analyser

```
BADGE    : "Score [X]/30 — Points de vigilance détectés"  (couleur : silver-600)
TITRE    : "Votre spa présente plusieurs zones de fragilité."
TEXTE    : "Ces points peuvent limiter la fluidité d'exploitation,
            l'expérience client ou la performance économique.
            Un regard externe permet souvent d'identifier rapidement
            les ajustements prioritaires."

ÉTUDE DE CAS SUGGÉRÉE : type "Audit et optimisation"

CTA PRINCIPAL  : "Demander un pré-audit spa" → /contact/
CTA SECONDAIRE : "Voir nos références" → /references/

LEAD MAGNET ENVOYÉ : "Guide des questions à se poser avant un audit spa"
```

---

### Résultat C — Score 0 à 12 : Risque élevé de sous-performance

```
BADGE    : "Score [X]/30 — Points de vigilance importants"  (couleur : error)
TITRE    : "Votre spa présente des points de vigilance importants."
TEXTE    : "Dans ce type de situation, les conséquences peuvent être durables :
            coûts d'exploitation élevés, inconfort des équipes, expérience
            client dégradée ou rentabilité insuffisante.
            Un audit stratégique permet de clarifier les causes et de définir
            un plan d'action priorisé."

ÉTUDE DE CAS SUGGÉRÉE : type "Création" ou "Groupe hôtelier"

CTA PRINCIPAL  : "Planifier un échange confidentiel" → /contact/
CTA SECONDAIRE : "Découvrir la Méthode Spa Profit™" → /methode-spa-profit/

LEAD MAGNET ENVOYÉ : "Guide des erreurs de conception les plus coûteuses"
```

---

## 7. Segmentation profil prospect

En plus du score, le champ "Type de projet" sert à affiner le profil :

| Type de projet déclaré | Profil | Offre prioritaire à proposer |
|---|---|---|
| Création d'un spa | A | Méthode Spa Profit™ Niveau 1 ou 2 |
| Spa existant à optimiser | A ou B | Niveau 3 ou Diagnostic stratégique |
| Réflexion stratégique | A | Niveau 1 — Diagnostic stratégique |
| Gestion / staffing | B ou C | Pôle Gestion → /gestion-externalisee/ |

Ce profil est enregistré dans Airtable et utilisé dans les relances Make.

---

## 8. Implémentation PHP / AJAX

### Handler AJAX (inc/ajax.php)

```php
add_action( 'wp_ajax_nopriv_cbs_diagnostic', 'cbs_handle_diagnostic_submit' );
add_action( 'wp_ajax_cbs_diagnostic',        'cbs_handle_diagnostic_submit' );

function cbs_handle_diagnostic_submit() {
    // 1. Sécurité
    check_ajax_referer( 'cbs_tunnel_nonce', 'nonce' );

    // 2. Sanitize des données
    $reponses     = array_map( 'absint', $_POST['reponses'] ?? [] );
    $prenom       = sanitize_text_field( $_POST['prenom']   ?? '' );
    $nom          = sanitize_text_field( $_POST['nom']      ?? '' );
    $hotel        = sanitize_text_field( $_POST['hotel']    ?? '' );
    $email        = sanitize_email(      $_POST['email']    ?? '' );
    $telephone    = sanitize_text_field( $_POST['telephone']?? '' );
    $type_projet  = sanitize_text_field( $_POST['type_projet'] ?? '' );

    // 3. Calcul du score
    $score = array_sum( $reponses ); // 0 à 30

    // 4. Détermination du niveau de résultat
    if ( $score >= 22 ) {
        $niveau = 'A'; // Bases solides
    } elseif ( $score >= 13 ) {
        $niveau = 'B'; // Points de vigilance
    } else {
        $niveau = 'C'; // Risque élevé
    }

    // 5. Envoi vers Airtable
    $airtable_data = [
        'Prénom'        => $prenom,
        'Nom'           => $nom,
        'Hôtel'         => $hotel,
        'Email'         => $email,
        'Téléphone'     => $telephone,
        'Type projet'   => $type_projet,
        'Score'         => $score,
        'Niveau'        => $niveau,
        'Réponses'      => implode( ',', $reponses ),
        'Date'          => current_time( 'Y-m-d H:i:s' ),
        'Source'        => 'Diagnostic site',
    ];
    cbs_send_to_airtable( $airtable_data ); // voir inc/api-airtable.php

    // 6. Déclenchement Make (webhook)
    cbs_trigger_make_webhook( 'diagnostic_completed', [
        'email'       => $email,
        'prenom'      => $prenom,
        'score'       => $score,
        'niveau'      => $niveau,
        'type_projet' => $type_projet,
    ]);

    // 7. Réponse
    wp_send_json_success([
        'score'  => $score,
        'niveau' => $niveau,
    ]);
}
```

---

### Calcul du score JS (assets/js/tunnel.js)

```javascript
// Stockage des réponses
const reponses = {}; // { q1: 3, q2: 2, q3: 1, ... }

function enregistrerReponse(question, points) {
    reponses[question] = points;
    afficherQuestion(question + 1);
}

function calculerScore() {
    return Object.values(reponses).reduce((sum, pts) => sum + pts, 0);
}

function determinerNiveau(score) {
    if (score >= 22) return 'A';
    if (score >= 13) return 'B';
    return 'C';
}

// Soumission finale (étape 11)
async function soumettreDiagnostic(formData) {
    const score  = calculerScore();
    const niveau = determinerNiveau(score);

    const payload = new FormData();
    payload.append('action', 'cbs_diagnostic');
    payload.append('nonce',  cbsAjax.nonce);
    payload.append('score',  score);
    payload.append('niveau', niveau);

    // Ajout des réponses
    Object.entries(reponses).forEach(([q, pts]) => {
        payload.append(`reponses[${q}]`, pts);
    });

    // Ajout des coordonnées
    for (const [key, value] of formData.entries()) {
        payload.append(key, value);
    }

    const response = await fetch(cbsAjax.url, { method: 'POST', body: payload });
    const data     = await response.json();

    if (data.success) {
        afficherResultat(data.data.score, data.data.niveau);
    }
}
```

---

## 9. Structure HTML des étapes (template-parts/diagnostic/)

### Étape question (`tunnel-step.php`)

```php
<div class="tunnel__step" data-step="<?php echo esc_attr($step_number); ?>">
    <div class="tunnel__progress">
        <span class="tunnel__progress-label">
            <?php echo esc_html($step_number); ?>/10
        </span>
        <div class="tunnel__progress-bar">
            <div class="tunnel__progress-fill"
                 style="width: <?php echo esc_attr(($step_number / 10) * 100); ?>%">
            </div>
        </div>
    </div>

    <h2 class="tunnel__question"><?php echo esc_html($question); ?></h2>

    <div class="tunnel__options">
        <?php foreach ($options as $key => $option) : ?>
        <button class="tunnel__option"
                data-question="<?php echo esc_attr($step_number); ?>"
                data-points="<?php echo esc_attr($option['points']); ?>">
            <?php echo esc_html($option['label']); ?>
        </button>
        <?php endforeach; ?>
    </div>
</div>
```

### Résultat (`tunnel-resultat.php`)

```php
<div class="tunnel__resultat tunnel__resultat--niveau-<?php echo esc_attr(strtolower($niveau)); ?>">
    <div class="tunnel__score-badge">
        Score <?php echo esc_html($score); ?>/30
    </div>
    <h2 class="tunnel__resultat-titre"><?php echo esc_html($titre); ?></h2>
    <p class="tunnel__resultat-texte"><?php echo esc_html($texte); ?></p>

    <div class="tunnel__ctas">
        <a href="<?php echo esc_url($cta_principal_url); ?>"
           class="btn-primary">
            <?php echo esc_html($cta_principal_label); ?>
        </a>
        <a href="<?php echo esc_url($cta_secondaire_url); ?>"
           class="btn-secondary">
            <?php echo esc_html($cta_secondaire_label); ?>
        </a>
    </div>

    <p class="tunnel__email-confirm">
        Un récapitulatif a été envoyé à votre adresse email.
    </p>
</div>
```

---

## 10. Données enregistrées dans Airtable

**Table : `Diagnostics`**

| Champ Airtable | Type | Source |
|---|---|---|
| Prénom | Texte | Formulaire |
| Nom | Texte | Formulaire |
| Hôtel / Société | Texte | Formulaire |
| Email | Email | Formulaire |
| Téléphone | Téléphone | Formulaire |
| Type de projet | Select | Formulaire |
| Score | Nombre | Calculé |
| Niveau de résultat | Select (A/B/C) | Calculé |
| Réponses détaillées | Texte long | Q1 à Q10 (points) |
| Date | Date | Automatique |
| Source | Texte | "Diagnostic site" |
| Statut lead | Select | "Nouveau" par défaut |
| RDV pris | Checkbox | Mise à jour via Make (Calendly) |

---

## 11. Automations déclenchées

| Événement | Automation | Délai |
|---|---|---|
| Formulaire soumis | Enregistrement Airtable | Immédiat |
| Formulaire soumis | Notification interne (mail + Telegram) | Immédiat |
| Formulaire soumis | Envoi lead magnet PDF (selon niveau) | Immédiat |
| Diagnostic complété sans RDV Calendly | Relance mail personnalisée | H+24 |

> Voir `automations.md` pour les schémas détaillés de chaque scénario Make.

---

*Référence : content-structure.md §8 (page Diagnostic), automations.md, integrations.md*
