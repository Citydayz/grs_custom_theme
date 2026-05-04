<?php
/**
 * CBS Theme — cpt.php
 * Custom Post Types et taxonomies associées (wordpress-theme.md §5–6).
 */

defined( 'ABSPATH' ) || exit;

/**
 * CPT Études de cas — archive publique `/etudes-de-cas/` (page vitrine réservée à `/references/`).
 */
function cbs_register_cpt_etude_de_cas(): void {
	register_post_type(
		'etude-de-cas',
		array(
			'labels'              => array(
				'name'          => __( 'Études de cas', 'cbs-theme' ),
				'singular_name' => __( 'Étude de cas', 'cbs-theme' ),
				'add_new_item'  => __( 'Ajouter une étude de cas', 'cbs-theme' ),
				'edit_item'     => __( 'Modifier l’étude de cas', 'cbs-theme' ),
				'view_item'     => __( 'Voir l’étude de cas', 'cbs-theme' ),
				'search_items'  => __( 'Rechercher des études de cas', 'cbs-theme' ),
				'not_found'     => __( 'Aucune étude de cas', 'cbs-theme' ),
				'all_items'     => __( 'Toutes les études de cas', 'cbs-theme' ),
				'archives'      => __( 'Références', 'cbs-theme' ),
			),
			'public'              => true,
			'has_archive'         => true,
			'rewrite'             => array( 'slug' => 'etudes-de-cas' ),
			'supports'            => array( 'title', 'thumbnail', 'excerpt' ),
			'menu_icon'           => 'dashicons-portfolio',
			'show_in_rest'        => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
		)
	);
}
add_action( 'init', 'cbs_register_cpt_etude_de_cas' );

/**
 * Taxonomie Type de mission — filtres archive études de cas.
 */
function cbs_register_taxonomy_type_mission(): void {
	register_taxonomy(
		'type-mission',
		array( 'etude-de-cas' ),
		array(
			'labels'            => array(
				'name'          => __( 'Types de mission', 'cbs-theme' ),
				'singular_name' => __( 'Type de mission', 'cbs-theme' ),
				'search_items'  => __( 'Rechercher des types', 'cbs-theme' ),
				'all_items'     => __( 'Tous les types', 'cbs-theme' ),
				'edit_item'     => __( 'Modifier le type', 'cbs-theme' ),
				'add_new_item'  => __( 'Ajouter un type', 'cbs-theme' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_admin_column' => true,
			'show_in_rest'      => false,
			'rewrite'           => array( 'slug' => 'type-mission' ),
		)
	);
}
add_action( 'init', 'cbs_register_taxonomy_type_mission', 11 );
