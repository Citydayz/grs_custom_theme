# content-structure.md — Structure & Contenu des Pages
# Conseil & Gestion des rituels du spa by Camille Becht

> Ce fichier documente l'arborescence complète, la structure section par section
> de chaque page, et le contenu disponible issu des documents sources.
> Cursor doit s'y référer pour tout travail de templating, de copy ou d'intégration.
>
> Sources : `Offres_de_conseil_et_accompagnement_spa.docx` + `Offres_de_Gestion_de_spa.docx`

---

## 1. Arborescence globale

```
/                               → Accueil
/methode-spa-profit/            → La Méthode Spa Profit™ (hub Pôle Conseil)
  /diagnostic-strategique/      → Niveau 1
  /conception-securisation/     → Niveau 2
  /mise-en-performance/         → Niveau 3
/gestion-spa-hotelier/          → Hub Pôle Gestion
  /partielle/                   → Gestion mixte (modèle commission)
  /complete/                    → Gestion complète (forfait + commission)
/staffing/                      → Staffing & Renfort d'équipe
/massages-en-chambre-hotel/     → Prestation exclusive (Alsace)
/references/                    → CPT Études de cas (archive)
/qui-sommes-nous/               → Expertise & équipe
/diagnostic-spa/                → Tunnel de qualification interactif
/boutique-pros/                 → CPT Boutique professionnelle
/contact/                       → Formulaire + Calendly
```

---

## 2. PAGE — Accueil (`front-page.php`)

### Section 1 — Hero plein écran (vidéo background)

```
SURTITRE    : [Montserrat, uppercase, gold] — ex. "Conseil & Gestion de spa hôtelier"
TITRE H1    : "On s'occupe de votre spa de A à Z pour qu'il devienne rentable."
SOUS-TITRE  : "J'accompagne les hôtels 4★ et 5★ dans la création et l'optimisation
               de leurs spas — pour éviter les erreurs coûteuses et concevoir des
               espaces réellement performants."
CTA 1       : "Discuter de votre projet" → /contact/
CTA 2       : "Voir la méthode" → /methode-spa-profit/
```

**Variantes de titre disponibles (choisir une) :**
- "On s'occupe de votre spa de A à Z pour qu'il devienne rentable."
- "J'aide les hôtels 4★ et 5★ à créer un spa rentable et parfaitement conçu dès le départ."
- "Je conçois les spas comme ils doivent être exploités, pas seulement comme ils doivent être dessinés."

---

### Section 2 — Segmentation profils (3 cartes cliquables)

Objectif : orienter immédiatement le visiteur vers son pôle.

```
TITRE SECTION : "À quelle situation vous reconnaissez-vous ?"

CARTE A — Investisseur / Porteur de projet
  Icône      : plan/blueprint
  Titre      : "Vous créez ou transformez un spa"
  Texte      : "Vous investissez dans un spa et voulez sécuriser chaque étape
                du projet pour éviter les erreurs coûteuses."
  CTA        : "Découvrir le Pôle Conseil" → /methode-spa-profit/
  Badge      : "France entière"

CARTE B — Exploitant en place
  Icône      : gestion/tableau de bord
  Titre      : "Vous gérez un spa et souhaitez déléguer"
  Texte      : "Vous cherchez un partenaire pour piloter tout ou partie
                de l'exploitation de votre spa."
  CTA        : "Découvrir le Pôle Gestion" → /gestion-spa-hotelier/
  Badge      : "Alsace"

CARTE C — Hôtel sans spa physique
  Icône      : chambre/massage mobile
  Titre      : "Vous voulez proposer des massages sans infrastructure"
  Texte      : "Vous souhaitez enrichir l'expérience client avec des
                massages en chambre, sans spa dédié."
  CTA        : "Découvrir l'offre" → /massages-en-chambre-hotel/
  Badge      : "Alsace"
```

---

### Section 3 — Le problème du marché

```
TITRE   : "Créer un spa hôtelier est un investissement majeur"
INTRO   : "Un spa représente souvent un investissement entre 500 000 € et 2 millions d'euros.
           Pourtant, beaucoup sont conçus uniquement d'un point de vue architectural —
           sans expertise d'exploitation."

LISTE DES CONSÉQUENCES :
- Cabines mal dimensionnées
- Problèmes de ventilation et d'humidité
- Mauvaise acoustique
- Parcours client inefficace
- Organisation complexe pour les équipes

ACCROCHE CHIFFRÉE : "Ces erreurs peuvent coûter 50 000 à 100 000 € en travaux correctifs
                     et pertes d'exploitation."
```

---

### Section 4 — Vue d'ensemble des deux pôles

```
TITRE : "Deux expertises, une vision"

PÔLE CONSEIL (fond sombre)
  Surtitre  : "Pôle Conseil & Création"
  Titre     : "La Méthode Spa Profit™"
  Texte     : "De l'audit stratégique à la conception fonctionnelle —
               un accompagnement complet pour créer un spa rentable
               et parfaitement exploitable dès l'ouverture."
  CTA       : "Découvrir la méthode" → /methode-spa-profit/

PÔLE GESTION (fond clair)
  Surtitre  : "Pôle Gestion & Staffing"
  Titre     : "Pilotage externalisé"
  Texte     : "Gestion partielle ou complète, staffing, massages en chambre —
               déléguez l'exploitation à un expert pendant que vous vous
               concentrez sur votre hôtel."
  CTA       : "Découvrir les offres" → /gestion-spa-hotelier/
```

---

### Section 5 — Preuves sociales

```
CHIFFRES CLÉS (à valider avec Camille) :
- +10 hôtels 4★ accompagnés
- Hôtels 5★ et groupes hôteliers
- 13 ans d'expertise bien-être hôtelier
- Alsace + France entière

LOGOS PARTENAIRES : [à insérer — même format que academie-rituels-spa.fr]
TÉMOIGNAGES       : [à recueillir — prévoir CPT ou ACF repeater]
```

---

### Section 6 — CTA final

```
TITRE : "Discutons de votre projet spa"
TEXTE : "Chaque projet est unique. Je vous propose un premier échange pour
         comprendre vos enjeux et voir comment je peux vous accompagner."
CTA   : "Prendre rendez-vous" → /contact/ (Calendly)
```

---

## 3. PAGE — La Méthode Spa Profit™ (`/methode-spa-profit/`)

### Section 1 — Hero

```
SURTITRE : "Pôle Conseil & Création"
TITRE    : "La Méthode Spa Profit™"
SOUS-TIT : "Concevoir des spas pensés pour l'exploitation et la rentabilité."
CTA      : "Voir les 3 niveaux d'accompagnement"
```

---

### Section 2 — Positionnement (le problème)

```
TITRE : "Un spa réussi ne repose pas uniquement sur un beau design"

TEXTE :
"La plupart des projets spa sont conçus par des architectes ou des designers.
Sans expertise d'exploitation, certaines contraintes essentielles sont négligées :
ergonomie des cabines, organisation du travail, gestion des flux, ventilation,
acoustique, cohérence de l'offre avec la clientèle.

Ces éléments ont un impact direct sur l'expérience client, les conditions de
travail des équipes et la performance économique du spa."

CITATION FORTE :
"Je conçois les spas comme ils doivent être exploités —
pas seulement comme ils doivent être dessinés."
```

---

### Section 3 — Les 3 niveaux (value ladder)

**Niveau 1 — Diagnostic stratégique spa** (`/diagnostic-strategique/`)
```
Surtitre : "Niveau 1 — Offre d'entrée"
Titre    : "Diagnostic stratégique spa"
Durée    : "1 à 3 mois"
Objectif : "Comprendre le potentiel, identifier les risques, définir la stratégie."

PRESTATIONS :
- Analyse du positionnement de l'hôtel et de sa clientèle
- Analyse du marché bien-être local et concurrentiel
- Identification des opportunités de différenciation
- Recommandations stratégiques pour le développement du spa
- Définition des orientations conceptuelles du projet

LIVRABLES :
- Note de diagnostic stratégique
- Recommandations de développement du spa

RÉSULTAT : "Un plan clair pour éviter les erreurs de conception et d'exploitation."
CTA      : "Discuter de votre diagnostic" → /contact/
```

**Niveau 2 — Conception & sécurisation du projet spa** (`/conception-securisation/`)
```
Surtitre : "Niveau 2 — Offre principale"
Titre    : "Conception & sécurisation du projet spa"
Durée    : "6 à 12 mois"
Objectif : "Accompagnement complet — de la stratégie à la préparation exploitation."

ÉTAPES :
Phase 1 — Diagnostic stratégique (cf. Niveau 1)
Phase 2 — Conception fonctionnelle de l'espace spa
  - Étude des plans architecturaux
  - Optimisation du parcours client
  - Recommandations d'implantation : cabines, zones humides, espaces détente, zones techniques
  - Recommandations sur l'ergonomie des cabines
  - Préconisations acoustiques et ambiance sensorielle
  Livrables : dossier de recommandations fonctionnelles + plans annotés

Phase 3 — Coordination projet avec la maîtrise d'œuvre
  - Participation aux réunions projet
  - Échanges avec l'architecte
  - Validation des choix techniques liés à l'exploitation
  - Recommandations sur les équipements spa
  - Ajustements fonctionnels en phase conception

Phase 4 — Suivi de chantier spa (3 visites incluses)
  - Vérification de l'implantation des cabines et équipements
  - Validation des espaces techniques et zones clients
  - Recommandations d'ajustement si nécessaire

Phase 5 — Sélection équipements, mobilier et consommables
  - Sélection du mobilier spa
  - Recommandations pour l'aménagement des cabines
  - Sélection des équipements et accessoires (paniers, chaussons, peignoirs, linge spa, matériel)
  - Élaboration d'une shopping list fournisseurs
  Livrables : liste fournisseurs + liste équipements et consommables

Phase 6 — Préparation à la gestion opérationnelle
  - Recommandations organisationnelles pour l'exploitation
  - Dimensionnement de l'activité soins
  - Structuration de l'offre bien-être
  - Modélisation du potentiel d'activité
  - Prévisionnel d'activité spa (3 scénarios : pessimiste / réaliste / ambitieux)
  Livrables : prévisionnel d'activité + recommandations organisationnelles

OPTIONS :
- 20% sur les économies réalisées dans le cadre d'aides et subventions
- 250 € par réunion supplémentaire sur site
- 60 € / heure par réunion supplémentaire à distance

CTA : "Discuter de votre projet" → /contact/
```

**Niveau 3 — Mise en performance du spa** (`/mise-en-performance/`)
```
Surtitre : "Niveau 3 — Offre premium long terme"
Titre    : "Mise en performance du spa"
Durée    : "3 à 6 mois"
Objectif : "Faire du spa un vrai centre de profit."

CONTENU :
- Branding spa (avec graphiste/agence partenaire)
  → nom du spa, identité physique, marque cosmétique associée, logo, charte graphique
  → plan de communication personnalisé selon budget
- Création d'un soin signature exclusif
  → protocole sur-mesure + livret détaillé + cession complète des droits
  → formation des praticiennes actuelles et futures en option
- Accompagnement à l'optimisation des process organisationnels
  → audit + analyse + recommandations
  → livrable : rapport d'audit + plan d'action opérationnel
  → formation organisationnelle et managériale (prise en charge OPCO)
  → suivi & coaching terrain
- Accompagnement à l'optimisation des équipes
  → recrutement (annonce, tri CV, entretiens, test de la main)
  → onboarding et formation sur les process
  → expertise légale & RH freelances (évaluation, contrats, conformité dossiers)
- Offres de formation pour le personnel spa
  → massage & soins (présentiel + e-learning)
  → accueil client en cabine
  → vente de produits
  → hygiène & sécurité
- Offres de formation pour les équipes réception
  → vente de produits
  → accueil client et discours spa
  → hygiène & sécurité

CTA : "Discuter de vos besoins" → /contact/
```

---

## 4. PAGE — Gestion externalisée hub (`/gestion-spa-hotelier/`)

```
SURTITRE : "Pôle Gestion & Staffing"
TITRE    : "Déléguez la gestion de votre spa à un expert"
TEXTE    : "Vous gérez un hôtel, pas un spa. Je m'occupe de l'exploitation —
            partiellement ou totalement — pour que votre spa génère du chiffre
            sans vous mobiliser."
CTA 1    : "Gestion partielle" → /gestion-spa-hotelier/partielle/
CTA 2    : "Gestion complète" → /gestion-spa-hotelier/complete/
BADGE    : "Alsace uniquement"
```

---

### Sous-page — Gestion externalisée partielle (`/partielle/`)

```
MODÈLE : Gestion mixte — rémunération par commissions
TITRE  : "Gestion externalisée partielle — Modèle hybride"

POSITIONNEMENT :
"Bénéficiez d'une expertise spa spécialisée et de praticiens qualifiés,
tout en conservant l'exploitation interne. Le changement de partenaire
est facile et fluide."

RÉPARTITION CA :
- Prestations de soins  : 15% pour l'établissement / 85% pour le gestionnaire
  (ou base tarifaire fixe fournie par CB, l'hôtel applique sa marge)
- Vente de produits     : 10% du CA HT pour l'établissement
- Offres Day Spa        : 100% pour l'établissement
- Extras spa            : 100% établissement

MISSIONS GESTIONNAIRE :
- Pilotage stratégique de l'activité spa
- Supervision de la qualité des prestations
- Création et évolution de la carte de soins
- Développement des expériences bien-être
- Stratégie de commercialisation
- Mise à disposition et supervision des professionnels intervenants
- Soutien à l'organisation du planning des praticiens
- Management et gestion RH
- Accompagnement au développement de l'offre bien-être
- Participation au développement du CA
- Participation à la stratégie marketing
- Suivi de la performance de l'activité
- Gestion des stocks des consommables (cabine, produits professionnels, produits ventes)

MISSIONS ÉTABLISSEMENT :
- Gestion du planning des praticiens
- Réservation des prestations spa
- Facturation
- Gestion de la relation client
- Mise en place d'actions marketing et partenariats
- Optimisation du taux d'occupation des cabines
- Entretien et nettoyage des espaces
- Consommables : serviettes, chaussons, paniers, peignoirs

CTA : "Discuter de ce modèle" → /contact/
```

---

### Sous-page — Gestion externalisée complète (`/complete/`)

```
MODÈLE : Forfait mensuel + commission variable
TITRE  : "Gestion externalisée complète — Tranquillité absolue"

POSITIONNEMENT :
"Une gestion professionnelle complète du spa, une visibilité budgétaire
pour l'établissement, un engagement du gestionnaire dans la performance."

RÉMUNÉRATION (deux options présentées en RDV) :
Option A — avec loyer :
  - Loyer mensuel       : 1 000 € HT / mois
  - Prestations de soins: 8% du CA HT pour le gestionnaire
  - Vente de produits   : 10% du CA HT pour le gestionnaire
  - Offres Day Spa      : 40% établissement / 60% gestionnaire

Option B — sans loyer :
  - Prestations de soins: 12% du CA HT pour le gestionnaire
  - Vente de produits   : 10% du CA HT pour le gestionnaire
  - Offres Day Spa      : 50% établissement / 50% gestionnaire

NOTE : Les conditions financières sont transmises en rendez-vous.
       Afficher sur le site uniquement les fourchettes ou "à partir de".

RESPONSABILITÉS GESTIONNAIRE (tout inclus) :
- Pilotage et gestion complète de l'activité spa
- Organisation du planning des praticiens et de l'activité soins
- Management et gestion RH
- Supervision qualité
- Développement offre bien-être + carte des soins
- Stratégie marketing et commerciale
- Développement du CA
- Suivi de la performance
- Gestion des stocks et consommables
- Entretien et nettoyage des espaces (hors installations)
- Consommables pris en charge : chaussons, paniers, consommables cabine, produits cabine, produits ventes

RESPONSABILITÉS HÔTEL :
- Peignoirs clients
- Serviettes spa
- Espace tisanerie
- Maintenance et gestion technique des installations
- Gestion des consommations énergétiques

CTA : "Discuter de ce modèle" → /contact/
```

---

## 5. PAGE — Staffing & Renfort d'équipe (`/staffing/`)

```
TITRE       : "Staffing & Renfort d'équipe — L'Intérim de luxe"
SOUS-TITRE  : "Des praticiens qualifiés, vérifiés, conformes — disponibles quand vous en avez besoin."
POSITIONNEMENT : "Modèle d'interim permettant de bénéficier d'une expertise spa
                  spécialisée et de praticiens qualifiés, tout en conservant
                  l'exploitation interne."
BADGE       : "Alsace uniquement"

MODÈLE : Collaboration exclusive — rémunération au forfait
  - Prestations de soins : base tarifaire fixe fournie par CB, l'hôtel applique sa marge
  - Achat de la marque par l'hôtel / rémunération ventes praticiens externes : 15% facturé par CB
  - Day Spa : 100% établissement
  - Extras  : 100% établissement

MISSIONS GESTIONNAIRE :
- Supervision qualité des prestations des praticiens externes
- Mise à disposition et supervision des professionnels
- Soutien à l'organisation du planning
- Management et gestion RH des intervenants
- Accompagnement au développement de l'offre
- Suivi de la performance

MISSIONS ÉTABLISSEMENT (conserve le pilotage) :
- Planning, réservation, facturation, relation client
- Stratégie, carte de soins, marketing
- Gestion de tous les consommables

CTA : "Nous contacter" → /contact/
```

---

## 6. PAGE — Massages en chambre (`/massages-en-chambre-hotel/`)

```
TITRE       : "Massages en chambre — Service premium clés en main"
SOUS-TITRE  : "Proposez des massages haut de gamme à vos clients, sans infrastructure spa dédiée."
POSITIONNEMENT : "Un réseau de praticiens qualifiés, vérifiés, suivis et en conformité —
                  disponibles à la demande via un système de planification fluide."
BADGE       : "Alsace uniquement"

MODÈLE : Collaboration exclusive — rémunération au forfait
  - Base tarifaire fixe fournie par CB
  - L'hôtel applique la marge qu'il souhaite et fixe le prix client

MISSIONS GESTIONNAIRE :
- Supervision qualité
- Mise à disposition et supervision des praticiens
- Soutien à la planification (système de RDV + assistance téléphonique)
- Management RH, administratif et réglementaire des intervenants
- Accompagnement au développement de l'offre bien-être
- Suivi de la performance
- Création et mise à disposition de la carte de soins

MISSIONS ÉTABLISSEMENT :
- Planning, réservation, facturation
- Relation client
- Développement des expériences bien-être
- Stratégie de commercialisation
- Actions marketing

CTA : "Nous contacter" → /contact/
```

---

## 7. PAGE — Références & Études de cas (`/references/`)

> Page dynamique via CPT `etude-de-cas`. Voir `wordpress-theme.md` §6.

### Structure de la page archive

```
TITRE       : "Des projets spa accompagnés dans l'hôtellerie haut de gamme"
INTRO       : "Chaque établissement a ses spécificités. Voici quelques exemples
               de missions de conseil et de gestion menées par Camille Becht."

CHIFFRES (bandeau) :
- +10 hôtels 4★ accompagnés
- Hôtels 5★ et groupes hôteliers
- Missions de conseil + contrats de gestion

GRILLE CPT  : Cards études de cas (filtrables par type-mission)
```

### Structure d'une étude de cas (single)

```
Champs ACF à remplir :
- cbs_contexte         : description de l'établissement et du besoin
- cbs_enjeux           : liste des problématiques identifiées
- cbs_accompagnement   : ce qui a été fait
- cbs_resultats        : résultats obtenus (qualitatif + chiffres si dispo)
- cbs_temoignage       : citation client (optionnel)
- cbs_profil_prospect  : A / B / C
- cbs_type_mission     : conseil / gestion / staffing (taxonomie)
```

**3 études de cas pré-rédigées disponibles dans les sources :**
1. Création d'un spa pour un hôtel 4★
2. Optimisation d'un spa existant
3. Accompagnement d'un projet spa au sein d'un groupe hôtelier

---

## 8. PAGE — Diagnostic interactif (`/diagnostic-spa/`)

> Voir `diagnostic-tunnel.md` pour la logique complète de scoring et les résultats.

```
TITRE       : "Diagnostic Spa Hôtelier"
SOUS-TITRE  : "Évaluez en 3 minutes les points de vigilance de votre spa"
INTRO       : "Votre spa est-il réellement pensé pour être rentable ?
               Ce diagnostic vous aide à identifier les principaux points de
               vigilance de votre projet ou spa existant sur 4 dimensions :
               conception, exploitation, expérience client, organisation."

10 QUESTIONS (cf. diagnostic-tunnel.md) — scoring sur 30
3 NIVEAUX DE RÉSULTAT :
  - 22-30 : Spa globalement bien structuré → CTA : optimisations possibles
  - 13-21 : Points de vigilance à analyser → CTA : pré-audit spa
  - 0-12  : Risque élevé de sous-performance → CTA : échange confidentiel

CAPTURE EMAIL avant affichage du résultat détaillé :
  Champs : prénom, nom, hôtel/société, email, téléphone, type de projet
```

---

## 9. PAGE — Qui sommes-nous (`/qui-sommes-nous/`)

```
TITRE     : "Notre expertise"
SECTIONS  :
  - Présentation Camille Becht (bio + parcours terrain)
  - Valeurs et positionnement
  - Chiffres clés
  - Présentation de l'écosystème (lien avec l'Académie)
  - Témoignages clients
```

> Contenu détaillé à recueillir avec Camille.

---

## 10. PAGE — Contact (`/contact/`)

> Template : `page-templates/template-contact.php`

```
TITRE   : "Parlons de votre projet"
TEXTE   : "Je vous propose un premier échange de 30 minutes pour comprendre
           votre situation et voir comment je peux vous accompagner."

DEUX BLOCS :
  1. Calendly (iframe) — prise de RDV directe
  2. Formulaire de contact simple (AJAX) :
     - Prénom / Nom
     - Hôtel / Société
     - Email
     - Téléphone
     - Type de projet (liste déroulante : conseil / gestion / staffing / autre)
     - Message libre
```

---

## 11. Mots-clés et champs sémantiques à utiliser

Issus directement des documents sources — à utiliser dans les titres, textes et métas SEO.

**Résultats attendus :**
- spa rentable / centre de profit
- spa bien conçu dès le départ
- éviter les erreurs coûteuses (50 000 à 100 000 €)
- expérience client haut de gamme
- exploitation fluide et efficace

**Lexique métier à reprendre :**
- cabines de soins / zones humides / parcours client / zones techniques
- praticiens qualifiés / gestion RH / conformité légale
- prévisionnel d'activité / taux d'occupation des cabines
- Méthode Spa Profit™ / soin signature / branding spa

**Ton & posture :**
- Expert terrain (pas théorique)
- Partenaire long terme (pas prestataire ponctuel)
- Vocabulaire B2B, direct, factuel — pas de sur-promesse

---

## 12. Éléments manquants (à compléter avec Camille)

- [ ] Texte biographique complet (page Qui sommes-nous)
- [ ] Chiffres clés validés (nb hôtels, années d'expérience, CA généré…)
- [ ] Témoignages clients (nom, établissement, texte)
- [ ] Logos des hôtels partenaires (avec droits d'utilisation)
- [ ] Photos / vidéos (hero, pages offres, équipe)
- [ ] Tarifs ou fourchettes à afficher sur le site vs à garder pour RDV
- [ ] Nom de domaine du nouveau site
- [ ] Politique de prix boutique pros (contenu à définir)

---

*Référence : agents.md §5 (Arborescence), wordpress-theme.md §6 (CPT)*
*Fichier suivant : diagnostic-tunnel.md, automations.md*
