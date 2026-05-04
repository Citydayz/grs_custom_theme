<?php
/**
 * CBS Theme — acf-fields.php
 *
 * Local JSON : sauvegarde et chargement depuis `/acf-json/` (voir wordpress-theme.md §6).
 *
 * Groupe « CBS — Page Accueil » : définition versionnée dans
 * `acf-json/group_cbs_page_accueil.json` (synchronisation depuis l’écran ACF).
 *
 * Champs :
 * - `cbs_accueil_hero_poster` (image, URL) — image hero ; défaut thème si vide.
 * - `cbs_accueil_hero_video` (fichier MP4, URL) — vidéo hero ; défaut thème si vide (sauf si image seule).
 * - `cbs_accueil_hero_image_seule` (true/false) — bandeau image sans lecture vidéo (`cbs_get_home_hero_media_urls()`).
 * - `cbs_accueil_temoignages` (repeater) : `cbs_temoignage_texte`, `cbs_temoignage_auteur`, `cbs_temoignage_etablissement`
 * - `cbs_accueil_logos` (repeater) : `cbs_logo_partenaire` (image), `cbs_logo_alt`
 * - `cbs_afficher_calendly` (true/false) — contrôle le chargement des scripts Calendly (voir `cbs_should_enqueue_calendly_scripts()`)
 *
 * Groupe « CBS — Pages Offres Conseil » : `acf-json/group_cbs_pages_offres_conseil.json`
 * (pages slug `methode-spa-profit`, `diagnostic-strategique`, `conception-securisation`, `mise-en-performance`).
 * Onglets Hub / Niveau 1 / 2 / 3 : textes hero, positionnement, citation, cartes 3 niveaux, listes, phases, options,
 * CTA ; bandeau N1 diagnostic (`cbs_diag_accroche`, `cbs_diag_accroche_sub`) ; témoignages N1 (`cbs_offres_n1_temoignages` → `cbs_offres_temoignage_*`).
 *
 * Groupe « CBS — Pages Gestion » : `acf-json/group_cbs_pages_gestion.json`
 * (slugs `gestion-spa-hotelier`, `gestion-partielle`, `gestion-complete`, `staffing-spa`, `massages-en-chambre-hotel`).
 * Préfixe des champs : `cbs_gestion_*` — hub (hero, badge, CTA, liens, profils cibles, missions + icônes, chiffres clés,
 * texte SEO, CTA final), partielle (position, tableau CA, missions, note RDV), complète (position, options A\/B, note, responsabilités),
 * staffing §5 (hero, `cbs_staffing_positionnement_image`, position WYSIWYG, modèle, missions, `cbs_staffing_seo_image` / `cbs_staffing_seo_text`, CTA),
 * massages §6 (idem + `cbs_massages_positionnement_image`, `cbs_massages_planif_image`, `cbs_massages_seo_*`). Défauts PHP : `inc/offres-gestion-defaults.php`.
 *
 * Groupe « CBS — Études de cas » : `acf-json/group_cbs_etudes_de_cas.json` (CPT `etude-de-cas`, archive `/etudes-de-cas/`).
 * Champs content-structure.md §7 : `cbs_contexte`, `cbs_enjeux`, `cbs_accompagnement`, `cbs_resultats`, `cbs_temoignage`,
 * `cbs_profil_prospect` (A\/B\/C), `cbs_type_mission` (taxonomie `type-mission`, save_terms). Pas de `the_field()` dans
 * les templates — `get_field()` uniquement (`single-etude-de-cas.php`, `etude-de-cas-card.php`).
 *
 * Groupe « CBS — Qui sommes-nous » : `acf-json/group_cbs_page_qui_sommes_nous.json` (page slug `qui-sommes-nous`,
 * routage `page.php` → `offres/qui-sommes-nous.php`). Champs : `cbs_qsn_photo`, `cbs_qsn_bio` ; repeater `cbs_qsn_chiffres` ;
 * repeater `cbs_qsn_valeurs` (`cbs_qsn_valeur_titre`, `cbs_qsn_valeur_texte`) ; `cbs_qsn_academie_image`, `cbs_qsn_academie_url` ;
 * repeater `cbs_qsn_temoignages`. Défauts PHP : `inc/qui-sommes-nous-defaults.php`.
 *
 * Groupe « CBS — Page Références (vitrine) » : `acf-json/group_cbs_page_references.json` (page slug `references`,
 * routage `page.php` → `references.php`). Champs : hero `cbs_ref_hero_*` ; repeater `cbs_references` (`ref_image`, `ref_badge`,
 * `ref_titre`, `ref_description`, `ref_zone`) ; stats `cbs_ref_stat_{1..3}_{valeur,label}` ; SEO `cbs_ref_seo_image`, `cbs_ref_seo_text` ;
 * `cbs_ref_citation`, `cbs_ref_attribution` ; `cbs_ref_cta_label`. Défauts PHP : `inc/references-defaults.php`.
 *
 * Groupe « CBS — Page légale » : `acf-json/group_cbs_page_legal.json` (template `page-templates/page-legal.php`).
 * Champ : `last_updated` (date picker d/m/Y) — affichage « Dernière mise à jour » sous le titre ; vide = date de modification WP.
 * Fallback : meta post `last_updated` (chaîne).
 */

defined( 'ABSPATH' ) || exit;

/**
 * @param string $path Chemin de sauvegarde par défaut (ACF).
 * @return string
 */
function cbs_acf_json_save_path( $path ) {
	return CBS_DIR . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'cbs_acf_json_save_path' );

/**
 * @param string[] $paths Chemins de chargement JSON.
 * @return string[]
 */
function cbs_acf_json_load_paths( $paths ) {
	$paths[] = CBS_DIR . '/acf-json';

	return $paths;
}
add_filter( 'acf/settings/load_json', 'cbs_acf_json_load_paths' );
