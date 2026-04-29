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
 * CTA ; témoignages N1 (`cbs_offres_n1_temoignages` → `cbs_offres_temoignage_*`).
 *
 * Groupe « CBS — Pages Gestion » : `acf-json/group_cbs_pages_gestion.json`
 * (slugs `gestion-spa-hotelier`, `gestion-partielle`, `gestion-complete`, `staffing-spa`, `massages-en-chambre-hotel`).
 * Préfixe des champs : `cbs_gestion_*` — hub (hero, badge, CTA, liens, profils cibles, missions + icônes, chiffres clés,
 * texte SEO, CTA final), partielle (position, tableau CA,
 * missions, note RDV), complète (position, options A\/B, note, responsabilités), staffing §5 (hero, position, modèle,
 * missions, note pilotage, CTA), massages §6 (idem + bloc planification). Défauts PHP : `inc/offres-gestion-defaults.php`.
 *
 * Groupe « CBS — Études de cas » : `acf-json/group_cbs_etudes_de_cas.json` (CPT `etude-de-cas`, archive `/references/`).
 * Champs content-structure.md §7 : `cbs_contexte`, `cbs_enjeux`, `cbs_accompagnement`, `cbs_resultats`, `cbs_temoignage`,
 * `cbs_profil_prospect` (A\/B\/C), `cbs_type_mission` (taxonomie `type-mission`, save_terms). Pas de `the_field()` dans
 * les templates — `get_field()` uniquement (`single-etude-de-cas.php`, `etude-de-cas-card.php`).
 *
 * Groupe « CBS — Qui sommes-nous » : `acf-json/group_cbs_page_qui_sommes_nous.json` (page slug `qui-sommes-nous`,
 * routage `page.php` → `offres/qui-sommes-nous.php`). Champs : `cbs_bio` ; repeater `cbs_qsn_chiffres`
 * (`cbs_qsn_chiffre_valeur`, `cbs_qsn_chiffre_libelle`) ; `cbs_qsn_valeurs` ; `cbs_qsn_academie_intro`, `cbs_qsn_academie_url` ;
 * repeater `cbs_qsn_temoignages` (`cbs_qsn_temoignage_*`).
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
