# agents.md — Projet : Conseil & Gestion des rituels du spa by Camille Becht

> Fichier de référence global pour Cursor. Toujours consulter ce fichier avant de commencer une tâche.
> Version : 1.0 | Statut : En cours de construction

---

## 1. Vision du projet

Site vitrine B2B premium pour **Camille Becht**, consultante et gestionnaire de spas hôteliers 4★ et 5★.

**Promesse centrale :** *"On s'occupe de votre spa de A à Z pour qu'il devienne rentable."*

Le site porte **deux pôles distincts** :
- **Pôle Conseil & Création** — Ingénierie de conception, audits, la Méthode Spa Profit™
- **Pôle Gestion & Staffing** — Gestion externalisée, staffing, massages en chambre

**Trois profils prospects à segmenter dès l'entrée :**
- Profil A — Investisseur / Porteur de projet (France entière + DOM-TOM + francophonie)
- Profil B — Exploitant en place cherchant une délégation (Alsace uniquement)
- Profil C — Hôtel sans spa physique cherchant des massages en chambre (Alsace uniquement)

---

## 2. Stack technique

| Couche | Technologie |
|---|---|
| CMS | WordPress (thème custom, sans builder lourd) |
| Thème | Custom PHP / HTML / CSS — inspiré de `academie-rituels-spa.fr` |
| CPT | Custom Post Types pour Études de Cas et Boutique pros |
| Formulaires & Tunnel | ACF + logique conditionnelle custom |
| RDV | Calendly (intégration iframe) |
| CRM & données | Airtable API |
| Automations | Make (ex-Integromat) |
| Emailing transactionnel | Brevo ou Mailjet |
| Notifications internes | Mail + Telegram |
| Hébergement | À définir (compatible WordPress) |

---

## 3. Architecture des fichiers agents

Chaque fichier agent couvre un domaine précis. Cursor doit charger uniquement les fichiers pertinents à la tâche en cours.

```
.cursor/
├── agents.md                    ← CE FICHIER — vision globale, stack, conventions
├── rules/
│   ├── wordpress-theme.md       ← Structure du thème custom, conventions PHP/CSS
│   ├── design-system.md         ← Tokens de design, palette, typographie, espacement
│   ├── content-structure.md     ← Arborescence, copy des pages, CPT
│   ├── diagnostic-tunnel.md     ← Logique du questionnaire de qualification
│   ├── automations.md           ← Schémas Make, scénarios Airtable/Brevo/Telegram
│   ├── integrations.md          ← Calendly, Airtable API, webhooks entrants/sortants
│   └── seo.md                   ← Conventions SEO, structure des URLs, balises
```

---

## 4. Conventions globales

### Code
- PHP : PSR-12, pas de fonctions dépréciées WordPress
- CSS : variables CSS natives (pas de Sass), nommage BEM
- JS : vanilla JS ou modules ES6 légers — pas de jQuery sauf si WP l'exige
- Pas de page builder (pas d'Elementor, Divi, WPBakery)
- Pas de plugin pour ce qui peut être fait en custom (ex. : sliders, accordéons)

### Performance
- Images : WebP uniquement, lazy loading natif
- Pas de requêtes bloquantes en `<head>`
- Score Lighthouse cible : ≥ 90 mobile

### Sécurité
- Pas de credentials en dur dans le code
- Variables d'environnement via `wp-config.php` ou `.env`
- Nonces WordPress sur tous les formulaires

### Nommage
- Préfixe de thème : `cbs_` (Camille Becht Spa)
- Slugs en français pour les CPT (ex. : `etude-de-cas`, `boutique`)
- IDs Airtable et clés Make : documentés dans `integrations.md`

---

## 5. Arborescence du site

```
/                           → Accueil (Hero global + segmentation profils)
/methode-spa-profit/        → La Méthode Spa Profit™ (hub Pôle Conseil)
  /diagnostic-strategique/  → Niveau 1
  /conception-securisation/ → Niveau 2
  /mise-en-performance/     → Niveau 3
/gestion-externalisee/      → Hub Pôle Gestion
  /partielle/               → Gestion mixte
  /complete/                → Gestion complète
/staffing/                  → Staffing & Renfort d'équipe
/massages-en-chambre/       → Prestation exclusive (Alsace)
/references/                → CPT Études de cas
/qui-sommes-nous/           → Expertise & équipe
/diagnostic/                → Tunnel de qualification interactif
/boutique-pros/             → CPT Boutique professionnelle
/contact/                   → Formulaire + Calendly
```

---

## 6. Custom Post Types (CPT)

### `etude-de-cas`
- Champs : titre, secteur, problématique, solution apportée, résultats (chiffres), témoignage, logo client, profil prospect associé (A/B/C)
- Taxonomie : `type-mission` (conseil / gestion / staffing)

### `produit-pro`
- Champs : nom, description, prix HT, image, catégorie, lien achat ou contact
- Taxonomie : `categorie-produit`

---

## 7. Tunnel de qualification — logique générale

Le diagnostic interactif segmente le visiteur en **3 profils** (A, B, C) via une série de questions à choix multiples. Le score final détermine :
- La page de résultat affichée (personnalisée par profil)
- Le lead magnet envoyé automatiquement (Make → Brevo)
- La donnée enregistrée dans Airtable
- La notification interne (mail + Telegram)

> Voir `diagnostic-tunnel.md` pour la logique complète.

---

## 8. Automations — vue d'ensemble

| Déclencheur | Action | Outil |
|---|---|---|
| Diagnostic complété | Enregistrement Airtable + notif interne | Make |
| Diagnostic complété sans RDV sous 1h | Relance mail H+24 avec étude de cas | Make + Brevo |
| Email capturé | Envoi lead magnet PDF | Make + Brevo |
| RDV Calendly pris | Notif interne mail | Make |
| 30j après fin de mission | Questionnaire satisfaction | Make + Brevo |
| Note élevée satisfaction | Demande d'avis Google | Make + Brevo |
| Document praticien expirant dans 15j | Alerte conformité interne | Make + Airtable |

> Voir `automations.md` pour les schémas détaillés.

---

## 9. Direction artistique — principes clés

Le nouveau site hérite de la **structure et de l'exigence typographique** d'`academie-rituels-spa.fr` mais avec :
- Une **palette différente** (couleurs à définir — voir `design-system.md`)
- Un **positionnement visuel B2B** : moins "école", plus "cabinet de conseil hôtelier de luxe"
- Visuels Pôle Conseil : techniques, plans, ambiance bureau d'étude
- Visuels Pôle Gestion : humain, qualité du soin, management d'équipe
- Hero plein écran avec vidéo background (comme le site de référence)
- Sections très aérées, espacement généreux
- Typographie éditoriale : serif pour les titres, sans-serif lisible pour le corps

> Voir `design-system.md` pour les tokens complets.

---

## 10. Planning de référence

| Semaines | Objectif |
|---|---|
| S1–S2 | Maquettage UI/UX + `design-system.md` finalisé |
| S3–S4 | Développement thème WordPress + CPT + intégration médias |
| S5 | Tunnel de diagnostic + déploiement automations Make |

---

## 11. Fichiers agents à produire (statut)

| Fichier | Statut |
|---|---|
| `agents.md` | ✅ V1 produite |
| `rules/wordpress-theme.md` | ⏳ À produire |
| `rules/design-system.md` | ⏳ À produire (attente charte complète) |
| `rules/content-structure.md` | ⏳ À produire |
| `rules/diagnostic-tunnel.md` | ⏳ À produire |
| `rules/automations.md` | ⏳ À produire |
| `rules/integrations.md` | ⏳ À produire |
| `rules/seo.md` | ⏳ À produire |

---

*Dernière mise à jour : mars 2026*
