<?php
/**
 * CBS Theme — cpt-partners.php
 * CPT `cbs_partners` — bandeau logos hôtels (accueil), sans page front.
 *
 * Gestion : menu Admin « Partenaires hôtels » — image mise en avant = logo, titre = nom,
 * ordre d’affichage = menu_order (Attributs de page / ordre).
 */
defined( 'ABSPATH' ) || exit;

/**
 * CPT Partenaires hôtels — back-office uniquement.
 */
function cbs_register_cpt_partners(): void {
	register_post_type(
		'cbs_partners',
		array(
			'labels'              => array(
				'name'               => __( 'Partenaires hôtels', 'cbs-theme' ),
				'singular_name'      => __( 'Partenaire hôtel', 'cbs-theme' ),
				'add_new'            => __( 'Ajouter', 'cbs-theme' ),
				'add_new_item'       => __( 'Ajouter un partenaire', 'cbs-theme' ),
				'edit_item'          => __( 'Modifier le partenaire', 'cbs-theme' ),
				'new_item'           => __( 'Nouveau partenaire', 'cbs-theme' ),
				'view_item'          => __( 'Voir le partenaire', 'cbs-theme' ),
				'search_items'       => __( 'Rechercher des partenaires', 'cbs-theme' ),
				'not_found'          => __( 'Aucun partenaire', 'cbs-theme' ),
				'not_found_in_trash' => __( 'Aucun partenaire dans la corbeille', 'cbs-theme' ),
				'all_items'          => __( 'Tous les partenaires', 'cbs-theme' ),
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => false,
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
			'menu_icon'           => 'dashicons-building',
			'show_in_rest'        => false,
		)
	);
}
add_action( 'init', 'cbs_register_cpt_partners' );
