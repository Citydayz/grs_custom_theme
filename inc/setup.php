<?php
/**
 * CBS Theme — setup.php
 * Supports thème (thumbnails, menus, html5…).
 */

defined( 'ABSPATH' ) || exit;

/**
 * Supports du thème et enregistrement des menus (navigation.md §6).
 */
function cbs_theme_setup(): void {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support(
		'custom-logo',
		[
			'height'      => 80,
			'width'       => 280,
			'flex-height' => true,
			'flex-width'  => true,
		]
	);
	add_theme_support(
		'html5',
		[
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		]
	);

	register_nav_menus(
		[
			'primary'  => __( 'Navigation principale', 'cbs-theme' ),
			'footer-1' => __( 'Footer — Colonne 1', 'cbs-theme' ),
			'footer-2' => __( 'Footer — Colonne 2', 'cbs-theme' ),
			'legal'    => __( 'Mentions légales', 'cbs-theme' ),
		]
	);
}
add_action( 'after_setup_theme', 'cbs_theme_setup' );

/**
 * Tailles d’images dédiées (performance.md §4).
 */
function cbs_setup_image_sizes(): void {
	add_image_size( 'cbs-hero', 1440, 810, true );
	add_image_size( 'cbs-card', 768, 512, true );
	add_image_size( 'cbs-thumbnail', 400, 300, true );
	add_image_size( 'cbs-og', 1200, 630, true );
}
add_action( 'after_setup_theme', 'cbs_setup_image_sizes' );

/**
 * Title document via `cbs_get_page_meta()` si aucun plugin SEO (seo.md §3).
 * Avec `title-tag`, la balise title est produite par `wp_get_document_title()` ;
 * `pre_get_document_title` est le point d’accroche officiel (équivalent sémantique à un hook head).
 *
 * @param string|false $title Title court-circuité ou false.
 * @return string|false
 */
function cbs_pre_get_document_title( $title ) {
	if ( cbs_has_seo_plugin() ) {
		return $title;
	}

	$meta = cbs_get_page_meta();
	if ( $meta['title'] !== '' ) {
		return $meta['title'];
	}

	return $title;
}
add_filter( 'pre_get_document_title', 'cbs_pre_get_document_title', 15 );

/**
 * Meta description dans le head si aucun plugin SEO.
 */
function cbs_output_meta_description(): void {
	if ( cbs_has_seo_plugin() ) {
		return;
	}

	$meta = cbs_get_page_meta();
	if ( $meta['description'] === '' ) {
		return;
	}

	echo '<meta name="description" content="' . esc_attr( $meta['description'] ) . '">' . "\n";
}
add_action( 'wp_head', 'cbs_output_meta_description', 2 );

/**
 * robots.txt à l’URL racine /robots.txt (seo.md §8), Sitemap natif WordPress.
 *
 * @param string $output Contenu robots existant.
 * @param bool   $public Site public.
 */
function cbs_robots_txt( $output, $public = true ) {
	if ( ! $public ) {
		return $output;
	}

	$lines   = array(
		'User-agent: *',
		'Disallow: /wp-admin/',
		'Disallow: /wp-login.php',
		'Disallow: /diagnostic/?*',
		'Allow: /wp-admin/admin-ajax.php',
		'',
		'Sitemap: ' . home_url( '/wp-sitemap.xml' ),
	);

	return implode( "\n", $lines ) . "\n";
}
add_filter( 'robots_txt', 'cbs_robots_txt', 10, 2 );
