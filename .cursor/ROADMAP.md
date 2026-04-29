# ROADMAP.md
# Conseil & Gestion des rituels du spa by Camille Becht

> Aligné sur le planning du cahier des charges (démarrage : 17 mars 2026).
> Mis à jour par `agent-principal` à chaque fin de phase.
>
> Statuts : `✅ Terminé` · `🔄 En cours` · `⏳ À venir` · `🚫 Bloqué`

---

## Phase 0 — Préparation projet
**Durée :** semaine 0 | **Statut :** ✅ Terminé

- [x] Lecture et analyse du cahier des charges
- [x] Analyse du site de référence (academie-rituels-spa.fr)
- [x] Analyse des documents sources (offres conseil + gestion)
- [x] Création de tous les fichiers rules Cursor
- [x] Création de tous les agents Cursor
- [x] Initialisation CHANGELOG et ROADMAP

---

## Phase 1 — Maquettage UI/UX
**Durée :** semaines 1-2 | **Statut :** ✅ Terminé

**Objectif :** valider la direction artistique et la structure des pages avant de coder.

- [x] Finalisation de la charte graphique (logo, couleurs exactes, typographies)
- [x] Mise à jour de `rules/design-system.md` avec les valeurs définitives
- [x] Maquette page d'accueil (hero, segmentation profils, preuves sociales)
- [x] Maquette page Méthode Spa Profit™
- [x] Maquette tunnel diagnostic (étapes 1-10, capture, résultat)
- [x] Maquette page Gestion externalisée
- [x] Maquette page Contact + Calendly
- [x] Validation des maquettes avec Camille

**Agents concernés :** `agent-design`, `agent-content`

---

## Phase 2 — Développement WordPress
**Durée :** semaines 3-4 | **Statut :** ✅ Terminé

**Objectif :** thème fonctionnel avec toutes les pages et le contenu intégré.

### Semaine 3 — Structure & fondations
- [x] Initialisation du thème `cbs-theme`
- [x] `functions.php` + tous les fichiers `inc/`
- [x] `assets/css/base/tokens.css` — variables CSS complètes
- [x] `assets/css/base/typography.css` — polices auto-hébergées
- [x] Header + navigation (desktop + mobile)
- [x] Footer
- [x] CPT `etude-de-cas` + groupes ACF
- [x] CPT `produit-pro` + groupes ACF
- [x] Template page d'accueil (`front-page.php`)
- [x] Template pages offres (`page.php` + ACF)

**Agents concernés :** `agent-theme`, `agent-design`

### Semaine 4 — Pages & contenu
- [x] Page Méthode Spa Profit™ + 3 sous-pages niveaux
- [x] Pages Gestion externalisée (hub + partielle + complète)
- [x] Pages Staffing + Massages en chambre
- [x] Page Références (archive CPT)
- [x] Page Qui sommes-nous
- [x] Page Contact + embed Calendly
- [x] Intégration contenu `content-structure.md` sur toutes les pages
- [x] Styles CSS de tous les composants
- [x] Responsive mobile sur toutes les pages

**Agents concernés :** `agent-theme`, `agent-design`, `agent-content`, `agent-seo`

---

## Phase 3 — Tunnel diagnostic + Automations
**Durée :** semaine 5 | **Statut :** ✅ Terminé

**Objectif :** tunnel fonctionnel end-to-end + tous les scénarios Make opérationnels.

### Tunnel diagnostic
- [x] `page-templates/template-diagnostic.php`
- [x] `template-parts/diagnostic/` — étapes, capture, résultat
- [x] `assets/js/tunnel.js` — logique multi-steps, scoring, AJAX
- [x] Handler AJAX `inc/ajax.php` — validation, rate limiting, Airtable
- [x] Tests end-to-end (clavier, mobile, erreurs réseau)

**Agents concernés :** `agent-tunnel`, `agent-design`, `agent-qa`

### Intégrations
- [x] `inc/api-airtable.php` — toutes les fonctions CRUD
- [x] Création des 3 tables Airtable avec les bons champs
- [x] Configuration Calendly + webhook → Make
- [x] Scénario S1 — Diagnostic complété
- [x] Scénario S2 — Relance H+24
- [x] Scénario S3 — Lead magnet
- [x] Scénario S4 — RDV Calendly pris
- [x] Scénario S5 — Satisfaction 30j
- [x] Scénario S6 — Avis Google
- [x] Scénario S7 — Alerte conformité praticien
- [x] Templates email Brevo (10 templates)
- [x] Bot Telegram + notifications

**Agents concernés :** `agent-integrations`, `agent-qa`

---

## Phase 4 — Mise en ligne
**Durée :** semaine 6+ | **Statut :** 🔄 En cours

**Objectif :** finaliser les assets, le contenu éditorial, les tests, les intégrations production et le déploiement.

**Agents concernés :** `agent-principal`, `agent-qa`, `agent-seo`, `agent-integrations`

### Suivi technique (itérations v0.17.x)
- [x] **Navigation** — ✅ **Résolu** (v0.17.1) : sous-menus en survol sur desktop, lien parent cliquable, chevron pour le dépliage mobile / tactile ; alignement `navigation.md` / accessibilité conservé.
- [x] **Hero d’accueil** — ✅ **Médias pilotables depuis l’admin** (v0.17.2) : image et/ou vidéo configurables via ACF ; les fichiers par défaut sous **`assets/images/`** et **`assets/videos/`** restent des **repli valides** si les champs ne sont pas renseignés.

### Assets à créer
- [ ] `assets/images/og-default.jpg` (1200×630px)
- [ ] `assets/images/logo.svg` + `logo-white.svg`
- [ ] `assets/images/hero-home.webp` *(optionnel si média hero défini dans ACF — fichier de secours toujours supporté)*
- [ ] `assets/videos/hero-home.mp4` *(idem)*
- [ ] 6 fichiers `.woff2` dans `assets/fonts/` (confirmés)

### Contenu à saisir dans WP Admin
- [ ] Bio Camille Becht (page Qui sommes-nous)
- [ ] Chiffres clés validés avec Camille
- [ ] 3 études de cas (CPT Références)
- [ ] Témoignages clients (accueil + qui sommes-nous)
- [ ] Logos partenaires hôtels
- [ ] Menus `footer-1` et `legal`

### Tests à valider
- [ ] Formulaire contact end-to-end
- [ ] Tunnel diagnostic end-to-end
- [ ] Calendly embed fonctionnel
- [ ] Responsive mobile sur toutes les pages
- [ ] Lighthouse mobile ≥ 90 sur accueil
- [ ] Checklist SEO `seo.md` §10
- [ ] Checklist sécurité `security.md` §7
- [ ] Checklist accessibilité `accessibility.md` §8

### Intégrations prod
- [ ] Créer les 3 tables Airtable
- [ ] Configurer les 7 scénarios Make
- [ ] Vérifier domaine Brevo (SPF + DKIM)
- [ ] Créer les 10 templates email Brevo
- [ ] Bot Telegram + notifications
- [ ] `CBS_ENV=production` dans `wp-config.php`

### Déploiement
- [ ] Hébergement WordPress choisi
- [ ] Déploiement staging
- [ ] Validation finale avec Camille
- [ ] Tag `v1.0.0` sur `main`
- [ ] Soumission sitemap Google Search Console

---

## Backlog — Post v1.0

> Fonctionnalités identifiées mais hors scope du lancement initial.

- [ ] Blog / journal (CPT articles, SEO longue traîne)
- [ ] Boutique pros fonctionnelle (paiement en ligne)
- [ ] Espace client (accès praticiens, documents)
- [ ] Version multilingue (anglais pour prospects internationaux)
- [ ] Tableau de bord Airtable pour Camille (suivi leads + missions)
- [ ] Lead magnet vidéo (webinaire "les 5 erreurs du spa hôtelier")

---

*Dernière mise à jour : 2026-04-09 — Phase 4 : navigation principale et médias hero (ACF + repli `assets/`) notés à jour ; checklists pré-lancement inchangées par ailleurs.*
