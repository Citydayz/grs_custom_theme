# automations.md — Scénarios d'Automation Make
# Conseil & Gestion des rituels du spa by Camille Becht

> Ce fichier décrit tous les scénarios Make (ex-Integromat) du projet :
> déclencheurs, actions, données transmises, conditions et outils connectés.
> Cursor s'y réfère pour tout travail sur les webhooks PHP et les intégrations.
>
> Outils connectés : Make · Airtable · Brevo (ou Mailjet) · Calendly · Telegram

---

## 1. Vue d'ensemble des scénarios

| # | Nom du scénario | Déclencheur | Priorité |
|---|---|---|---|
| S1 | Diagnostic complété | Webhook site → Make | 🔴 Critique |
| S2 | Relance diagnostic sans RDV | Timer H+24 (Airtable) | 🔴 Critique |
| S3 | Envoi lead magnet | Webhook site → Make | 🔴 Critique |
| S4 | RDV Calendly pris | Calendly → Make | 🔴 Critique |
| S5 | Feedback satisfaction 30j | Timer Airtable | 🟡 Important |
| S6 | Demande d'avis Google | Score satisfaction élevé | 🟡 Important |
| S7 | Alerte conformité praticien | Timer Airtable | 🟡 Important |

---

## 2. Architecture technique

### Webhooks sortants (site → Make)

Tous les webhooks sont déclenchés depuis `inc/ajax.php` via la fonction :

```php
// inc/ajax.php
function cbs_trigger_make_webhook( string $event, array $data ): void {
    $webhook_url = defined( 'CBS_MAKE_WEBHOOK_' . strtoupper( $event ) )
        ? constant( 'CBS_MAKE_WEBHOOK_' . strtoupper( $event ) )
        : null;

    if ( ! $webhook_url ) return;

    wp_remote_post( $webhook_url, [
        'headers'     => [ 'Content-Type' => 'application/json' ],
        'body'        => wp_json_encode( array_merge( $data, [
            'event'     => $event,
            'timestamp' => current_time( 'c' ),
            'source'    => home_url(),
        ])),
        'timeout'     => 10,
        'blocking'    => false, // non-bloquant pour la perf
    ]);
}
```

**Constantes à définir dans `wp-config.php` :**

```php
define( 'CBS_MAKE_WEBHOOK_DIAGNOSTIC_COMPLETED', 'https://hook.make.com/xxx' );
define( 'CBS_MAKE_WEBHOOK_CONTACT_FORM',         'https://hook.make.com/xxx' );
```

---

## 3. Scénario S1 — Diagnostic complété

**Objectif :** Notifier l'équipe interne + enregistrer le lead dans Airtable.

### Déclencheur
Webhook Make reçoit les données après soumission du formulaire (étape 11 du tunnel).

### Payload reçu par Make
```json
{
  "event":       "diagnostic_completed",
  "timestamp":   "2026-03-20T10:30:00+01:00",
  "prenom":      "Jean",
  "nom":         "Dupont",
  "hotel":       "Hôtel Les Pins 4★",
  "email":       "j.dupont@hotel-les-pins.fr",
  "telephone":   "06 12 34 56 78",
  "type_projet": "Spa existant à optimiser",
  "score":       17,
  "niveau":      "B",
  "reponses":    "3,2,1,2,2,1,2,2,1,1"
}
```

### Actions Make (dans l'ordre)

**Action 1 — Airtable : Créer un enregistrement dans la table `Diagnostics`**
```
Table    : Diagnostics
Champs   :
  Prénom             ← prenom
  Nom                ← nom
  Hôtel / Société    ← hotel
  Email              ← email
  Téléphone          ← telephone
  Type de projet     ← type_projet
  Score              ← score
  Niveau             ← niveau
  Réponses           ← reponses
  Date               ← timestamp
  Statut lead        ← "Nouveau"
  RDV pris           ← false
  Source             ← "Diagnostic site"
```

**Action 2 — Brevo : Ajouter le contact à la liste `Diagnostics_[Niveau]`**
```
Liste    : Diagnostics_A / Diagnostics_B / Diagnostics_C (selon niveau)
Attributs:
  PRENOM       ← prenom
  NOM          ← nom
  HOTEL        ← hotel
  SCORE        ← score
  NIVEAU       ← niveau
  TYPE_PROJET  ← type_projet
  DATE_DIAG    ← timestamp
```

**Action 3 — Mail interne : Notification à Camille**
```
De       : notifications@[domaine-site].fr
À        : camille@[domaine].fr
Sujet    : "🔔 Nouveau diagnostic — [hotel] — Score [score]/30 — Niveau [niveau]"
Corps    :
  Nouveau diagnostic complété sur le site.

  Prospect   : [prenom] [nom]
  Hôtel      : [hotel]
  Email      : [email]
  Téléphone  : [telephone]
  Projet     : [type_projet]

  Score      : [score]/30
  Niveau     : [niveau]
  Réponses   : [reponses]

  → Lien Airtable : [url_enregistrement_airtable]
  → Envoyer un RDV : [lien_calendly]
```

**Action 4 — Telegram : Notification rapide**
```
Bot      : CBS_Notifications_Bot
Chat ID  : [id_chat_camille]
Message  :
  🏨 Nouveau diagnostic
  *[prenom] [nom]* — [hotel]
  Score : [score]/30 · Niveau [niveau]
  Projet : [type_projet]
  📧 [email]
```

---

## 4. Scénario S2 — Relance diagnostic sans RDV (H+24)

**Objectif :** Relancer le prospect qui a complété le diagnostic mais n'a pas pris de RDV Calendly dans les 24h.

### Déclencheur
Make scheduler : toutes les heures, vérifie dans Airtable la table `Diagnostics` :
```
Filtre Airtable :
  - Statut lead  = "Nouveau"
  - RDV pris     = false
  - Date         ≤ maintenant - 24h
  - Relance1_envoyee = false
```

### Actions Make

**Action 1 — Airtable : Récupérer les enregistrements éligibles**
```
Table   : Diagnostics
Filtre  : (voir ci-dessus)
Limite  : 10 par run
```

**Action 2 — Brevo : Envoyer l'email de relance**

L'email est personnalisé selon le **niveau** et le **type de projet**.

```
Template Brevo selon niveau :
  Niveau A → Template "Relance_A" (optimisation / amélioration)
  Niveau B → Template "Relance_B" (audit / points de vigilance)
  Niveau C → Template "Relance_C" (urgence / risque élevé)

Variables dynamiques :
  {{ prenom }}
  {{ hotel }}
  {{ score }}
  {{ type_projet }}
  {{ lien_rdv_calendly }}
  {{ etude_de_cas_url }}  ← étude de cas pertinente selon niveau
```

**Contenu type — Relance Niveau B (à adapter pour A et C) :**
```
Sujet : "[prenom], votre diagnostic spa révèle des points de vigilance"

Corps :
  Bonjour [prenom],

  Vous avez réalisé le diagnostic de votre spa hier — score [score]/30.

  Votre résultat indique plusieurs zones de fragilité qui peuvent
  limiter la performance de [hotel] sur le moyen terme.

  J'ai accompagné des hôtels dans une situation similaire.
  Voici un exemple concret : [lien_etude_de_cas]

  Si vous souhaitez en discuter, vous pouvez réserver un créneau
  directement dans mon agenda :
  → [lien_rdv_calendly]

  Cordialement,
  Camille Becht
  Conseil & Gestion des rituels du spa
```

**Action 3 — Airtable : Mettre à jour l'enregistrement**
```
Table   : Diagnostics
Champ   : Relance1_envoyee ← true
Champ   : Date_relance1    ← maintenant
```

**Action 4 — Telegram : Notification**
```
Message :
  📨 Relance envoyée
  [prenom] [nom] — [hotel]
  Score [score]/30 · Niveau [niveau]
```

---

## 5. Scénario S3 — Envoi lead magnet

**Objectif :** Envoyer automatiquement le PDF lead magnet dès la capture email,
personnalisé selon le niveau de résultat.

### Déclencheur
Même webhook que S1 (`diagnostic_completed`).
Make gère S1 et S3 dans le même scénario ou en parallèle (branche).

### Lead magnets selon niveau

| Niveau | Titre du PDF | Fichier |
|---|---|---|
| A | "Guide : Les questions à se poser pour optimiser son spa" | `lead-magnet-niveau-a.pdf` |
| B | "Guide : Les points de vigilance d'un spa hôtelier" | `lead-magnet-niveau-b.pdf` |
| C | "Guide : Les erreurs de conception les plus coûteuses" | `lead-magnet-niveau-c.pdf` |

> Les PDFs sont hébergés sur le site ou sur un espace Make/Google Drive.
> À créer par Camille — structure suggérée : 5-8 pages, format A4, charte CBS.

### Actions Make

**Action 1 — Brevo : Envoyer l'email avec pièce jointe ou lien de téléchargement**
```
Template : "LeadMagnet_[Niveau]"
Sujet    : "Votre guide spa — [titre_pdf]"
Variables:
  {{ prenom }}
  {{ lien_telechargement }}  ← URL du PDF (lien public ou signé)
```

**Action 2 — Airtable : Mettre à jour**
```
Champ : Lead_magnet_envoye ← true
```

---

## 6. Scénario S4 — RDV Calendly pris

**Objectif :** Notifier l'équipe interne + mettre à jour Airtable + supprimer de la file de relance.

### Déclencheur
Calendly webhook → Make (événement `invitee.created`).

### Payload Calendly (simplifié)
```json
{
  "event": "invitee.created",
  "payload": {
    "invitee": {
      "name":  "Jean Dupont",
      "email": "j.dupont@hotel-les-pins.fr"
    },
    "event": {
      "start_time": "2026-03-25T14:00:00+01:00",
      "name":       "Échange découverte 30min"
    }
  }
}
```

### Actions Make

**Action 1 — Airtable : Rechercher le contact par email**
```
Table   : Diagnostics
Filtre  : Email = payload.invitee.email
```

**Action 2 — Airtable : Mettre à jour si trouvé**
```
Champ : RDV pris       ← true
Champ : Date_RDV       ← start_time
Champ : Statut lead    ← "RDV planifié"
```

**Action 3 — Mail interne : Notification à Camille**
```
Sujet : "📅 Nouveau RDV — [name] — [start_time]"
Corps :
  Nouveau rendez-vous planifié.

  Nom    : [name]
  Email  : [email]
  Date   : [start_time]
  Type   : [event_name]

  → Voir dans Airtable : [url]
```

**Action 4 — Telegram : Notification rapide**
```
Message :
  📅 RDV planifié
  *[name]*
  📆 [start_time]
  📧 [email]
```

---

## 7. Scénario S5 — Feedback satisfaction 30 jours après mission

**Objectif :** Envoyer un questionnaire de satisfaction 30 jours après la fin d'une mission de conseil.

### Déclencheur
Make scheduler : toutes les 24h, vérifie dans Airtable la table `Missions` :
```
Filtre :
  - Date_fin_mission  ≤ maintenant - 30j
  - Satisfaction_envoye = false
  - Statut mission    = "Terminée"
```

### Table Airtable : `Missions`

| Champ | Type |
|---|---|
| Client (Nom) | Texte |
| Email client | Email |
| Hôtel | Texte |
| Type de mission | Select |
| Date début | Date |
| Date fin | Date |
| Satisfaction_envoye | Checkbox |
| Score_satisfaction | Nombre |
| Avis_Google_demande | Checkbox |

### Actions Make

**Action 1 — Brevo : Envoyer questionnaire satisfaction**
```
Template : "Satisfaction_30j"
Sujet    : "Comment s'est passé notre collaboration ?"
Variables: {{ prenom }}, {{ hotel }}, {{ lien_formulaire_satisfaction }}
```

> Le formulaire de satisfaction est un formulaire simple (Typeform, Tally ou custom)
> renvoyant le score à Airtable via webhook.

**Action 2 — Airtable : Mettre à jour**
```
Champ : Satisfaction_envoye ← true
Champ : Date_satisfaction   ← maintenant
```

---

## 8. Scénario S6 — Demande d'avis Google

**Objectif :** Solliciter un avis Google automatiquement si la note de satisfaction est ≥ 4/5.

### Déclencheur
Webhook Make reçoit le score depuis le formulaire de satisfaction (Typeform/Tally).

### Condition
```
Si score_satisfaction >= 4 :
  → Déclencher Action 1 + Action 2
Sinon :
  → Mettre à jour Airtable uniquement (pas de demande d'avis)
```

### Actions Make

**Action 1 — Brevo : Envoyer email demande d'avis Google**
```
Template : "Avis_Google"
Sujet    : "Un dernier mot sur notre collaboration ?"
Corps    :
  Bonjour [prenom],

  Merci pour votre retour — je suis ravie que notre collaboration
  ait été positive.

  Si vous avez quelques minutes, un avis Google aide beaucoup
  à faire connaître mon activité :
  → [lien_google_mybusiness]

  Merci d'avance,
  Camille
```

**Action 2 — Airtable : Mettre à jour la mission**
```
Table : Missions
Champ : Score_satisfaction    ← score reçu
Champ : Avis_Google_demande   ← true
Champ : Statut lead           ← "Client satisfait"
```

---

## 9. Scénario S7 — Alerte conformité praticien

**Objectif :** Alerter Camille 15 jours avant l'expiration d'un document légal d'un praticien freelance.

### Déclencheur
Make scheduler : toutes les 24h, vérifie dans Airtable la table `Praticiens` :
```
Filtre :
  - Date_expiration_document  ≤ maintenant + 15j
  - Alerte_envoyee            = false
  - Statut praticien          = "Actif"
```

### Table Airtable : `Praticiens`

| Champ | Type |
|---|---|
| Prénom / Nom | Texte |
| Email | Email |
| Téléphone | Téléphone |
| Type de document | Select (SIRET, assurance, carte pro…) |
| Date_expiration_document | Date |
| Alerte_envoyee | Checkbox |
| Statut praticien | Select (Actif / Inactif) |

### Actions Make

**Action 1 — Mail interne : Alerte conformité**
```
À      : camille@[domaine].fr
Sujet  : "⚠️ Document expirant — [prenom_nom] — dans [nb_jours] jours"
Corps  :
  Alerte de conformité.

  Praticien    : [prenom_nom]
  Document     : [type_document]
  Expiration   : [date_expiration] (dans [nb_jours] jours)

  → Voir le dossier dans Airtable : [url]
```

**Action 2 — Telegram : Notification rapide**
```
Message :
  ⚠️ Conformité praticien
  *[prenom_nom]*
  Document : [type_document]
  Expire le [date_expiration]
```

**Action 3 — Airtable : Mettre à jour**
```
Champ : Alerte_envoyee    ← true
Champ : Date_alerte       ← maintenant
```

---

## 10. Récapitulatif des tables Airtable

| Table | Usage | Alimentée par |
|---|---|---|
| `Diagnostics` | Leads issus du tunnel | S1 (webhook site) |
| `Missions` | Suivi des missions actives et terminées | Manuel (Camille) |
| `Praticiens` | Dossiers praticiens freelance | Manuel (Camille) |
| `RDV` | Optionnel — historique des RDV Calendly | S4 (Calendly webhook) |

---

## 11. Récapitulatif des webhooks Make à configurer

| Webhook | URL Make | Constante wp-config.php |
|---|---|---|
| Diagnostic complété | `hook.make.com/[id_s1]` | `CBS_MAKE_WEBHOOK_DIAGNOSTIC_COMPLETED` |
| Formulaire contact | `hook.make.com/[id_s4b]` | `CBS_MAKE_WEBHOOK_CONTACT_FORM` |

> Les URLs Make sont générées à la création des scénarios.
> Les stocker UNIQUEMENT dans `wp-config.php`, jamais dans le code du thème.

---

## 12. Checklist de mise en place

- [ ] Créer les 3 tables Airtable avec les champs documentés (§10)
- [ ] Créer les 7 scénarios Make et noter leurs webhook URLs
- [ ] Ajouter les constantes webhook dans `wp-config.php`
- [ ] Créer les templates email dans Brevo (un par scénario)
- [ ] Créer le bot Telegram CBS_Notifications et récupérer le Chat ID
- [ ] Créer les 3 PDFs lead magnet (Camille)
- [ ] Connecter Calendly à Make (OAuth dans Make)
- [ ] Tester chaque scénario end-to-end en staging avant mise en production

---

*Référence : diagnostic-tunnel.md §11 (automations déclenchées), integrations.md (Airtable API, Calendly)*
