# CHANGELOG.md
# Conseil & Gestion des rituels du spa by Camille Becht

> Format : [Semantic Versioning](https://semver.org/)
> MAJOR.MINOR.PATCH — ex: 1.2.3
>
> - MAJOR : changement incompatible (refonte, nouvelle architecture)
> - MINOR : nouvelle fonctionnalité rétrocompatible
> - PATCH : correction de bug, ajustement mineur
>
> Statuts : `Added` · `Changed` · `Fixed` · `Removed` · `Security`

---

## [Unreleased]
> Fonctionnalités en cours de développement — pas encore en production.

---

## [0.18.2] — 2026-04-09
### Changed
- **`template-parts/offres/methode-hub.php`** — cartes **« 3 temps »** : icônes SVG en tête, labels or, titres **h3** (Cormorant), texte inchangé ; bloc **témoignage** en **`.methode-testimonial`** (guillemet, citation, auteur) ; wrapper **`.methode-hub-page`** pour l’espacement vertical des sections.
- **`assets/css/components/cards.css`** — styles **3 temps** (sans `position: absolute`), **témoignage** (fond `--cbs-silver-100`, typo demandée), **`.methode-hub-page > section`** : `padding` vertical **`--cbs-space-16`** max entre sections ; retrait des anciens styles **`.methode-temoignage`** et des numéros décoratifs.

---

## [0.18.1] — 2026-04-09
### Changed
- **`assets/css/components/cards.css`** — hub Méthode Spa Profit™ : cartes **« 3 temps »** (numéros décoratifs 01–03 en Cormorant, or à 7 %, label or légèrement agrandi, corps 0.95rem / 1.7) ; espacement vertical entre **3 temps** ↔ **3 niveaux** et **3 niveaux** ↔ **témoignage** plafonné à **`--cbs-space-12`** (sélecteurs adjacents + `:has`) ; bloc **témoignage** (fond `--cbs-silver-900`, citation / auteur, max-width 720px, ordre visuel auteur au-dessus via `order`).

---

## [0.18.0] — 2026-04-09
### Added
- **Hub Méthode Spa Profit™** — champ ACF **`cbs_methode_hero_bg`** (image, URL) dans **`acf-json/group_cbs_pages_offres_conseil.json`** ; hero avec **`background-image`** inline, repli sur fond sombre existant, overlay **rgba(0,0,0,0.55)** via **`.methode-spa-hero--photo-bg`** dans **`assets/css/components/cards.css`**
- **Sections** — bandeau **crédibilité** (`.methode-credibilite`), **méthode en 3 temps** (`.methode-methode-temps`), **témoignage** (`.methode-temoignage`) dans **`template-parts/offres/methode-hub.php`**

### Changed
- **`template-parts/offres/methode-hub.php`** — ordre des sections (hero → crédibilité → problème → 3 temps → 3 niveaux → témoignage → CTA) ; copy hero, problème, cartes niveaux ; libellé **« Ce que vous obtenez »** conservé pour les livrables
- **`inc/offres-conseil-defaults.php`** — textes par défaut alignés sur le nouveau contenu (chapeau hero, paragraphe marché, cartes enrichies)
- **`inc/seo-meta-map.php`** — entrée **`methode-spa-profit`** : titre et meta description avec les expressions **consultant spa hôtelier**, **création spa hôtel**, **rentabilité spa hôtelier**

---

## [0.17.2] — 2026-04-09
### Added
- **`inc/helpers.php`** — **`cbs_get_home_hero_media_urls()`** : résolution des URLs média hero (image / vidéo) pour la page d’accueil.
- **`acf-json/group_cbs_page_accueil.json`** — trois champs hero : image, vidéo, bascule « image seule » (alignés sur le pilotage ACF de l’accueil).

### Changed
- **`template-parts/home/hero.php`** — lecture dynamique image / vidéo via ACF (avec repli sur les comportements existants selon les champs renseignés).
- **`inc/enqueue.php`** — **preload** dynamique sur l’URL média fournie par ACF lorsque pertinent.

---

## [0.17.1] — 2026-04-09
### Fixed
- **Navigation principale** — entrées avec enfants : le libellé parent est de nouveau un **lien** vers la page parent (plus un bouton seul qui bloquait la navigation).

### Changed
- **`inc/class-cbs-nav-walker.php`** — lien parent restauré + **bouton chevron** séparé (`aria-controls` vers le sous-menu).
- **`assets/js/nav.js`** — ouverture au **survol** sur desktop (appareil avec `hover: hover`) ; **chevron** pour ouvrir/fermer sur mobile et sur grand écran tactile ; focus clavier conservé.
- **`assets/css/components/nav.css`** & **`assets/css/layout/header.css`** — layout **`.nav__parent-row`** ; **zone tampon** **`::before`** sous le sous-menu pour éviter la fermeture accidentelle au passage de la souris.

---

## [0.17.0] — 2026-04-04
### Added
- **Accueil** — section **« Le problème du marché »** (§3) : **`template-parts/home/probleme-marche.php`**, styles **`.probleme-marche`** dans **`assets/css/components/cards.css`**, inclusion dans **`front-page.php`** entre segmentation et vue d’ensemble des pôles.

### Changed
- **`content-structure.md`** (`.agent/rules` & `.cursor/rules`) — slugs alignés sur le site : **`/gestion-spa-hotelier/`**, **`/massages-en-chambre-hotel/`**, **`/diagnostic-spa/`** (remplacement des anciennes URLs dans tout le fichier).

---

## [0.16.1] — 2026-03-24
### Security
- **`inc/helpers.php`** — **`cbs_security_headers()`** : en-têtes `X-Content-Type-Options`, `X-Frame-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy` ; **Content-Security-Policy** (Calendly, Airtable, Make, `frame-src` Calendly) ; filtre **`wp_headers`**
- **`inc/ajax.php`** — handlers **`cbs_handle_contact_form`** & **`cbs_handle_diagnostic_submit`** : ordre **honeypot** → **`cbs_check_rate_limit()`** → **`check_ajax_referer()`** → validation / traitement
- **`inc/enqueue.php`** — formulaire contact : **`wp_localize_script( 'cbs-forms', 'cbsContactAjax', … )`** avec **`url`** + **`nonce`** (`cbs_contact_nonce`)
- **`assets/js/forms.js`** — envoi AJAX contact via **`cbsContactAjax`** ; **`formData.set( 'cbs_nonce', … )`** prioritaire sur le champ caché du formulaire
- **`page-templates/template-contact.php`** — classe modificateur page contact via **`esc_attr( $extra_class )`** (fini l’echo booléen brut)

---

## [0.16.0] — 2026-03-24
### Added
- **Hub Méthode Spa Profit™** — section **« Ce que vous obtenez »** sur chaque carte des 3 niveaux (`template-parts/offres/methode-hub.php`) ; sous-champ repeater **`card_obtenez`** dans **`acf-json/group_cbs_pages_offres_conseil.json`** ; styles **`.card-offre__obtenez-label`** / **`.card-offre__obtenez`** dans **`assets/css/components/cards.css`**
- **Niveau 1 — Diagnostic stratégique** — section **« Pour qui ? »** (liste à puces) ; champs ACF **`cbs_offres_n1_prestations_intro`**, repeater **`cbs_offres_n1_pour_qui`** (sous-champ `ligne`) ; résultat enrichi rendu en **`<div class="offre-detail__lead--rich">`** avec **`wpautop`**
- **Niveau 3 — Mise en performance** — intro bloc « Contenu » pilotée par **`cbs_offres_n3_contenu_lead`** (ACF + défaut **`contenu_lead`** dans **`inc/offres-conseil-defaults.php`**)
- **Hub Pôle Gestion** — libellés **« Ce modèle est fait pour vous si… »** sous les cartes partielle / complète et sous les liens Staffing / Massages ; champs ACF **`cbs_gestion_hub_card_partielle_si`**, **`cbs_gestion_hub_card_complete_si`**, **`cbs_gestion_hub_link_staffing_si`**, **`cbs_gestion_hub_link_massages_si`** dans **`acf-json/group_cbs_pages_gestion.json`** ; structure **`.offre-gestion__cta-card-top`** + **`.offre-gestion__cta-card-si`** / **`.offre-gestion__link-si`** dans **`assets/css/components/offres-gestion.css`**
- **Gestion complète** — intro du bloc options financières : champ **`cbs_gestion_c_options_lead`** + clé **`options_lead`** dans **`inc/offres-gestion-defaults.php`**
- **Niveau 2 — Conception** — paragraphes d’intro visibles sous le titre de chaque phase (**`.phase-card__intro`** dans **`cards.css`**) ; résolution inchangée via **`cbs_offres_n2_phases_resolved()`**

### Changed
- **`inc/offres-conseil-defaults.php`** — copy enrichie (hub : positionnement + accroche 50k–100k € source **content-structure.md**, citation, **`obtenez`** par carte ; N1 : hero, intro prestations, résultat en 4 paragraphes, **`pour_qui`** ; N2 : hero, **`phases_lead`**, intros des 6 phases ; N3 : hero + **`contenu_lead`**) ; **`cbs_offres_hub_cards_resolved()`** : clé **`obtenez`** / **`card_obtenez`**
- **`inc/offres-gestion-defaults.php`** — copy enrichie (hub hero, **`card_*_si`**, **`link_*_si`**, **`complement`** vide par défaut ; partielle / complète / staffing / massages / massages **`planif_text`**) ; complète : **`position`**, **`options_lead`**
- **`template-parts/offres/niveau-2-conception.php`** — affichage du champ **`intro`** de chaque phase
- **`template-parts/offres/gestion-complete.php`** — lead section options via **`$opt_lead`** / **`get_field( 'cbs_gestion_c_options_lead' )`**
- **`template-parts/offres/gestion-hub.php`** — **`sprintf( __( 'Ce modèle est fait pour vous si… %s', … ) )`** ; complément bas de page affiché seulement si non vide
- **`acf-json/group_cbs_pages_offres_conseil.json`** & **`group_cbs_pages_gestion.json`** — horodatages **`modified`** mis à jour pour synchro admin

---

## [0.15.0] — 2026-03-24
### Added
- **`assets/css/components/cards.css`** — **`.phase-card--light`** : variantes cartes missions « établissement » (fond blanc, bordure `silver-200`, titres / listes contrastés sur fond clair, hover sobre, `prefers-reduced-motion`)
- **`inc/offres-gestion-defaults.php`** — **`cbs_gestion_icon_svg( string $key )`** : SVG décoratifs 32px (`currentColor`) pour les cartes missions Pôle Gestion (gouvernail, étoile, liste, graphiques, calendrier, équipe, boîte, etc.)
- **`assets/css/components/offres-gestion.css`** — **`.offre-gestion__ca-panel`** : encadré modèle tarifaire / tableau CA (fond `silver-100`, filet gauche or) ; **`.offre-gestion-options.offre-phases`** + **`.phase-card.offre-gestion__option-card`** : options tarifaires A/B (fond `silver-800`, kickers or, texte `silver-300`, liste type phase-card) ; note sous les options lisible sur fond sombre

### Changed
- **Méthode Spa Profit™ — cartes phases / prestations / blocs**
  - **`template-parts/offres/niveau-1-diagnostic.php`** — section **`.offre-phases`** (fond `silver-900`), grille **`phase-card`** sombres + icônes par prestation ; livrables en encart clair (`testimonial-card`)
  - **`template-parts/offres/niveau-2-conception.php`** — en-tête phases (kicker, H2, lead) ; **`cbs_offres_n2_phase_icon_svg()`** dans **`inc/offres-conseil-defaults.php`** ; champs ACF **`cbs_offres_n2_phases_*`** (surtitre, titre, intro) ; cartes sombres `#1a1f26`, grille responsive 3/2/1
  - **`template-parts/offres/niveau-3-performance.php`** — même pattern **`offre-phases`** / **`phase-card`** / **`phase-card__list`** avec icônes par volet
- **Pôle Gestion — cartes missions**
  - **`template-parts/offres/gestion-partielle.php`** — missions gestionnaire : grille sombre + icônes alignées sur l’ordre des défauts ; missions établissement : **`phase-card--light`** sur **`methode-niveaux`** ; CA dans **`offre-gestion__ca-panel`**
  - **`template-parts/offres/gestion-complete.php`** — options A/B en **`offre-phases`** + **`phase-card offre-gestion__option-card`** ; responsabilités gestionnaire (sombre + icônes) / hôtel (**`phase-card--light`**)
  - **`template-parts/offres/staffing.php`** & **`template-parts/offres/massages-chambre.php`** — modèle tarifaire en **`ca-panel`** ; missions gestionnaire sombres + établissement claires ; note staffing isolée en section **`offre-detail`**
- **`acf-json/group_cbs_pages_offres_conseil.json`** — champs N2 surtitre / titre / intro section phases (synchronisation admin)
- **`inc/offres-conseil-defaults.php`** — défauts & résolution **`intro`** phases N2 ; **`cbs_offres_n2_phase_icon_svg()`**

---

## [0.14.0] — 2026-03-24
### Added
- **`inc/helpers.php`** — SEO technique sans plugin : **Schema.org** `ProfessionalService` (bloc organisation / service global, seo.md §5) via `cbs_schema_organization()`, **Open Graph** + **Twitter Card** via `cbs_open_graph_tags()`, **BreadcrumbList** JSON-LD via `cbs_breadcrumb_schema()` ; **meta title & description** via `cbs_get_page_meta()` et helpers (`cbs_seo_singular_meta_description`, archives / pages / CPT) ; `cbs_has_seo_plugin()` (Yoast / Rank Math) pour éviter les doublons
- **`inc/seo-meta-map.php`** — cartes title / meta description des pages statiques (seo.md §3)
- **`inc/setup.php`** — `pre_get_document_title` + `cbs_output_meta_description` (`wp_head`) lorsqu’aucun plugin SEO n’est actif ; filtre **`robots_txt`** : règles seo.md §8, **Sitemap** vers **`/wp-sitemap.xml`** (sitemap natif WordPress ; Rank Math pourra remplacer plus tard si besoin)

### Changed
- **`functions.php`** — **`helpers.php`** chargé avant **`setup.php`** pour que les fonctions SEO soient disponibles dans `setup.php`

---

## [0.13.0] — 2026-03-24
### Added
- **`page.php`** — routage slug `qui-sommes-nous` → `template-parts/offres/qui-sommes-nous`
- **`template-parts/offres/qui-sommes-nous.php`** — page Qui sommes-nous (content-structure.md §9) : hero H1 « Notre expertise », bio `cbs_bio` (repli `[À COMPLÉTER]`), bandeau chiffres (repeater ACF), valeurs et positionnement (repli `[À COMPLÉTER]`), bloc lien **Académie** (`academie-rituels-spa.fr`), témoignages clients (repeater), CTA `/contact/`
- **`acf-json/group_cbs_page_qui_sommes_nous.json`** — groupe **« CBS — Qui sommes-nous »** (règle `page_slug` == `qui-sommes-nous`) : `cbs_bio`, `cbs_qsn_chiffres`, `cbs_qsn_valeurs`, `cbs_qsn_academie_intro` / `cbs_qsn_academie_url`, `cbs_qsn_temoignages`
- **`assets/css/components/cards.css`** — styles `.qui-sn-*` (hero, bio, chiffres, valeurs, carte Académie, CTA)

### Changed
- **`assets/js/nav.js`** — `body.page-qui-sommes-nous` : header forcé en `is-scrolled` (comme la page Contact, lisibilité sur hero sombre)
- **`inc/acf-fields.php`** — documentation du groupe Qui sommes-nous et des champs

---

## [0.12.0] — 2026-03-24
### Added
- **`inc/cpt.php`** — CPT `etude-de-cas` (archive publique `/references/`, supports titre / à la une / extrait, pas de REST) ; taxonomie **`type-mission`** rattachée au CPT (slug `type-mission`, colonne admin)
- **`archive-etude-de-cas.php`** — page Références (content-structure.md §7) : hero H1 « Références & Études de cas », accroche + intro §7, bandeau chiffres clés ; `WP_Query` (6 posts, `no_found_rows` false, pagination) ; filtre par `type_mission` si des termes existent ; état vide avec CTA contact
- **`single-etude-de-cas.php`** — fiche étude : champs ACF via `get_field()` (contexte, enjeux, accompagnement, résultats, témoignage, profil prospect), type de mission via termes ; lien retour archive ; CTA `/contact/` et `/diagnostic-spa/`
- **`template-parts/shared/etude-de-cas-card.php`** — carte cliquable (titre, type mission, extrait depuis `cbs_contexte` ou extrait WP, CTA « Voir l’étude »)
- **`acf-json/group_cbs_etudes_de_cas.json`** — groupe **« CBS — Études de cas »** : `cbs_contexte`, `cbs_enjeux`, `cbs_accompagnement`, `cbs_resultats`, `cbs_temoignage`, `cbs_profil_prospect` (A/B/C), `cbs_type_mission` (taxonomie, save/load terms)
- **`assets/css/components/cards.css`** — styles `.references-page`, `.etude-cas-card`, `.etude-cas-single`, pagination archive

### Changed
- **`inc/taxonomies.php`** — précision : taxonomie `type-mission` déclarée dans `inc/cpt.php`
- **`inc/acf-fields.php`** — documentation du groupe Études de cas et des champs §7

---

## [0.11.0] — 2026-03-24
### Added
- **`page-templates/template-diagnostic.php`** — page Diagnostic : hero sobre (surtitre, H1, chapô, 4 dimensions analysées, mention durée), `the_content()`, conteneur `.tunnel` avec région `#tunnel-live-region` (`aria-live="polite"`), intro étape 0 + CTA « Lancer le diagnostic », inclusion des partials tunnel
- **`template-parts/diagnostic/tunnel-step.php`** — 10 questions (diagnostic-tunnel.md §4), barre `role="progressbar"` (0–10), H2 `tabindex="-1"`, `role="radiogroup"` / `role="radio"` + `data-points` / `data-question`
- **`template-parts/diagnostic/tunnel-capture.php`** — formulaire étape 11 (§5) : prénom, nom, hôtel, email, téléphone, type de projet (4 options via `cbs_diagnostic_type_projet_map()`), `wp_nonce_field` `cbs_tunnel_nonce`, honeypot `website`, RGPD, CTA « Voir mon résultat », `novalidate`
- **`template-parts/diagnostic/tunnel-resultat.php`** — trois résultats A / B / C (§6) : badge score, titres, textes, 2 CTA par niveau, message confirmation email
- **`assets/js/tunnel.js`** — état `reponses` / `currentStep` / `isSubmitting`, navigation étapes 0→12, scoring client, `soumettreFormulaire()` (AJAX `cbs_diagnostic`, timeout 15s, anti double envoi), `afficherResultat` / `afficherErreur`, focus H2, annonces live region, clavier sur options type radio
- **`inc/ajax.php`** — `cbs_diagnostic_type_projet_map()`, `cbs_diagnostic_normalize_reponses()`, `cbs_validate_diagnostic_data()`, `cbs_diagnostic_niveau_from_score()`, `cbs_diagnostic_persist_and_notify()`, handler `cbs_handle_diagnostic_submit()` : `check_ajax_referer`, rate limit 5/h, recalcul score serveur, `cbs_send_to_airtable` + `cbs_trigger_make_webhook( 'diagnostic_completed' )`, `wp_ajax_nopriv_cbs_diagnostic` / `wp_ajax_cbs_diagnostic`
- **`assets/css/components/tunnel.css`** — styles page diagnostic + tunnel : intro, progressbar, options (hover / sélection / disabled), transitions d’étapes, badges résultat par niveau
- **`inc/enqueue.php`** — `cbsAjax.strings` (erreur générique, timeout, hors ligne) pour le script tunnel

---

## [0.10.1] — 2026-03-24
### Changed
- **`assets/css/components/forms.css`** — page Contact : hero aligné sur les autres heroes du site (fond `--cbs-silver-900`, titres / chapô en clair, `padding-top` pour compenser le header fixe, `padding-bottom` `--cbs-section-py`) ; grille deux colonnes Calendly + formulaire en **55 % / 45 %** (≥1024px) ; sans Calendly : formulaire centré `max-width` 680px avec plus d’air (padding bloc / inline) ; champs : bordure `1px solid var(--cbs-silver-200)`, fond blanc ; labels `var(--cbs-silver-700)` ; espacement des groupes `var(--cbs-space-6)`
- **`assets/js/nav.js`** — page Contact (`body.page-template-template-contact`) : le header reste en état `is-scrolled` au chargement et au scroll (lisibilité sur hero sombre)
- **`page-templates/template-contact.php`** — URL Calendly : `CBS_CALENDLY_URL` avec repli `cbs_get_calendly_inline_url()` si la constante est absente ou vide

---

## [0.9.0] — 2026-03-21
### Added
- **`template-parts/offres/staffing.php`** — page Staffing & Renfort d’équipe (content-structure.md §5) : hero, badge Alsace, positionnement intérim, modèle tarifaire forfait, missions gestionnaire / établissement, note pilotage, CTA `/contact/`
- **`template-parts/offres/massages-chambre.php`** — page Massages en chambre (§6) : hero, badge, positionnement réseau + planification, modèle base fixe CB / marge hôtel, missions, bloc « Système de planification fluide », CTA `/contact/`
- **`page.php`** — routage `staffing-spa` → `offres/staffing`, `massages-en-chambre-hotel` → `offres/massages-chambre`

### Changed
- **`acf-json/group_cbs_pages_gestion.json`** — extension du groupe « CBS — Pages Gestion » : onglets et champs ACF pour `staffing-spa` et `massages-en-chambre-hotel` (§5 / §6), règles `page_slug` associées
- **`inc/acf-fields.php`** — documentation du groupe Gestion (slugs + champs `cbs_gestion_s_*` / `cbs_gestion_m_*`)
- **`inc/offres-gestion-defaults.php`** — défauts §5 / §6 et helpers listes (staffing, massages)
- **`assets/css/components/offres-gestion.css`** — styles `.offre-gestion__modele-intro`, `.offre-gestion__modele-list`

### Fixed
- **`template-parts/home/segmentation-profils.php`** — carte C : lien vers `/massages-en-chambre-hotel/` (slug page massages)
- **`template-parts/offres/gestion-hub.php`** — lien Staffing vers `/staffing-spa/` (slug page staffing)

---

## [0.7.0] — 2026-03-20
### Added
- **`page.php`** — routage par slug vers `template-parts/offres/*` (Méthode Spa Profit™ + 3 niveaux) ; sinon `the_content()`
- **`template-parts/offres/methode-hub.php`**, **`niveau-1-diagnostic.php`**, **`niveau-2-conception.php`**, **`niveau-3-performance.php`** — sections §3 `content-structure.md`, ACF + repli sur défauts PHP
- **`inc/offres-conseil-defaults.php`** — textes §3 et helpers repeaters / cartes / phases / blocs N3
- **`acf-json/group_cbs_pages_offres_conseil.json`** — groupe ACF « CBS — Pages Offres Conseil » (Local JSON)
- **`assets/css/components/cards.css`** — `.methode-spa-hero`, `.methode-positionnement`, `.methode-niveaux`, `.card-offre`, détail offres / phases / témoignages N1

### Changed
- **`functions.php`** — `require_once` de `inc/offres-conseil-defaults.php`
- **`inc/acf-fields.php`** — documentation du groupe Offres Conseil

---

## [0.6.1] — 2026-03-20
### Added
- **`acf-json/group_cbs_page_accueil.json`** — groupe « CBS — Page Accueil » (témoignages, logos partenaires, `cbs_afficher_calendly`) ; synchro ACF Local JSON

### Changed
- **`inc/enqueue.php`** — Calendly chargé seulement si template `page-templates/template-contact.php` (ou `template-contact.php`) **ou** `cbs_afficher_calendly` sur la page courante (`cbs_should_enqueue_calendly_scripts()`)
- **`inc/acf-fields.php`** — filtres `save_json` / `load_json` vers `acf-json/` + documentation des champs page d’accueil
- **`template-parts/home/preuves-sociales.php`** — logos via repeater `cbs_accueil_logos` ; témoignages : `cbs_temoignage_texte` / `cbs_temoignage_etablissement`
- **`template-parts/shared/cta-rdv.php`** — embed Calendly uniquement si URL inline **et** `cbs_afficher_calendly`
- **`assets/css/components/cards.css`** — `.social-proof__logo-img` (logos ACF)

---

## [0.6.0] — 2026-03-20
### Added
- **`template-parts/home/preuves-sociales.php`** — bandeau 4 chiffres clés, placeholders logos partenaires, témoignages via ACF repeater `cbs_accueil_temoignages` (sous-champs `cbs_temoignage_*`)
- **`template-parts/shared/cta-rdv.php`** — section « Discutons de votre projet spa », embed Calendly conditionnel ou CTA vers `/contact/`
- **`assets/css/components/cards.css`** — styles `.social-proof`, `.testimonial-*`, `.cta-rdv`
- **`inc/helpers.php`** — `cbs_get_calendly_inline_url()` (`CBS_CALENDLY_INLINE_URL` ou filtre `cbs_calendly_inline_url`)
- **`assets/js/calendly.js`** — `Calendly.initInlineWidget` pour `.calendly-inline-widget[data-url]`
- **`front-page.php`** — inclusion de `template-parts/shared/cta-rdv` après les preuves sociales

### Changed
- **`inc/enqueue.php`** — Calendly chargé sur la page Contact **ou** sur l’accueil si URL inline définie (`cbs_enqueue_calendly_when_needed`)

### Fixed
- **`.profile-card__badge`** — commentaire explicite WCAG AA / `accessibility.md` §1 (`--cbs-gold-dark` sur `--cbs-gold-light`)

---

## [0.5.0] — 2026-03-20
### Added
- **`template-parts/home/segmentation-profils.php`** — 3 cartes profils cliquables + badges géographiques (content-structure.md §2 §2)
- **`template-parts/home/poles-overview.php`** — blocs Pôle Conseil (fond sombre) et Pôle Gestion (fond clair) (§2 §4)
- **`assets/css/components/cards.css`** — styles segmentation, `.profile-card`, `.pole-block`, grille responsive

---

## [0.4.0] — 2026-03-20
### Added
- **`template-parts/global/footer.php`** — `<footer class="site-footer">`, `.cbs-container`, grille 3 colonnes : menus `footer-1` (offres), `footer-2` + `legal` (légal), bloc marque + copyright
- **`assets/css/layout/footer.css`** — fond `silver-900`, texte `silver-400`, liens `silver-300` / hover or, grille responsive
- **`template-parts/home/hero.php`** — hero plein écran (vidéo + poster), overlay, surtitre / H1 / sous-titre / 2 CTA (content-structure.md §2 §1)
- **`assets/css/components/hero.css`** — mise en page hero, tokens, CTA sur fond sombre, `prefers-reduced-motion` (fond WebP sans vidéo)
- **`inc/enqueue.php`** — `cbs_preload_critical_assets()` (`wp_head` prio 1) : preload polices woff2 + `hero-home.webp` sur l’accueil (`fetchpriority="high"`)
- **`assets/videos/.gitkeep`** — dossier pour `hero-home.mp4` (et autres médias vidéo)

### Changed
- **Copyright (footer)** — année affichée avec `wp_date( 'Y' )` au lieu de `date( 'Y' )` (fuseau horaire WordPress)

---

## [0.3.0] — 2026-03-20
### Added
- **Fondations CSS** — `assets/css/base/tokens.css` (tokens design-system §9), `typography.css` (@font-face Cormorant + Montserrat), `reset.css` (reset minimal, `prefers-reduced-motion`, skip link / `.screen-reader-text`)
- **`main.css`** — `@import` actifs (reset → tokens → typography → components → layout)
- **Composants & layout** — `components/buttons.css` (`.btn-primary`, `.btn-secondary`, `.btn-ghost`), `layout/grid.css` (`.cbs-container`, `.cbs-grid`), `layout/header.css` (`.site-header` fixe, transparent → `.is-scrolled`), `components/nav.css` (desktop / mobile / dropdowns, breakpoint 1024px)
- **`assets/js/nav.js`** — scroll passif + `.is-scrolled`, menu mobile (ARIA, body overflow, focus), Escape / clic extérieur, dropdowns, `matchMedia` desktop pour `aria-hidden` + libellés toggle
- **`template-parts/global/header.php`** — skip link, en-tête complet (`wp_nav_menu` emplacement `primary`, toggle, CTA Contact `.btn-secondary`, logo / nom du site)
- **`inc/class-cbs-nav-walker.php`** — `CBS_Nav_Walker` (boutons parents + sous-menus BEM)
- **`inc/menus.php`** — `require_once` du walker
- **`inc/setup.php`** — `add_theme_support( 'custom-logo' )`
- **`assets/fonts/.gitkeep`** — dossier polices auto-hébergées
- Ajustements doc : chemins `@font-face` dans `rules/design-system.md` §3

---

## [0.2.0] — 2026-03-20
### Added
- **Phase 1 démarrée** — initialisation de la structure du thème WordPress `cbs-theme` (racine `wp-content/themes/cbs-theme/`)
- `style.css` — en-tête de thème (métadonnées WP)
- `functions.php` — point d’entrée, constantes `CBS_VERSION` / `CBS_DIR` / `CBS_URI`, `require_once` de tous les fichiers `inc/` (dont `widgets.php`)
- `header.php` / `footer.php` (racine) — délégation vers `template-parts/global/`
- Templates racine : `index.php`, `front-page.php`, `page.php`, `single.php`, `archive.php`, `404.php`, `search.php`, `single-etude-de-cas.php`, `archive-etude-de-cas.php`, `single-produit-pro.php`
- `template-parts/` — global, home, offres, diagnostic, shared (fichiers squelette)
- `page-templates/` — Diagnostic, Contact, Boutique
- `inc/` — `setup`, `enqueue`, `cpt`, `taxonomies`, `menus`, `widgets`, `acf-fields`, `ajax`, `api-airtable`, `shortcodes`, `helpers` (squelettes)
- `assets/css/` — `base/`, `components/`, `layout/`, `main.css` (imports commentés)
- `assets/js/` — `nav`, `tunnel`, `animations`, `calendly` (squelettes)
- `assets/images/icons/` et `placeholders/` (dossiers)
- `languages/cbs-theme.pot`
- `acf-json/` — dossier pour export ACF JSON
- Alignement de `rules/wordpress-theme.md` (§2 : `header.php` / `footer.php` ; §3 : `require_once` `widgets.php`)

---

## [0.1.0] — 2026-03-20
### Added
- Initialisation du projet
- Structure complète des fichiers agents et rules Cursor
- `agents.md` — vision globale, stack, arborescence
- `rules/wordpress-theme.md`
- `rules/design-system.md` — palette silver, Cormorant Garamond + Montserrat
- `rules/content-structure.md` — contenu issu des documents sources
- `rules/diagnostic-tunnel.md` — 10 questions, scoring, résultats A/B/C
- `rules/automations.md` — 7 scénarios Make
- `rules/seo.md`
- `rules/integrations.md`
- `rules/code-quality.md`
- `rules/security.md`
- `rules/error-handling.md`
- `rules/environments.md`
- `rules/performance.md`
- `rules/accessibility.md`
- `rules/forms.md`
- `rules/navigation.md`
- `rules/git-conventions.md`
- 8 agents Cursor (principal, theme, design, content, tunnel, integrations, seo, qa)
- 2 agents supplémentaires (forms, navigation)

---

## Template pour les prochaines entrées

```markdown
## [X.Y.Z] — YYYY-MM-DD
### Added
-

### Changed
-

### Fixed
-

### Removed
-

### Security
-
```

---

*Ce fichier est mis à jour par `agent-principal` à chaque merge sur `main`.*
