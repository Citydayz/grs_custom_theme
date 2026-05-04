<?php
/**
 * CBS Theme — gabarits listing articles (posts natifs).
 *
 * Dans WP Admin → Réglages → Lecture :
 * — si « Une page statique » est cochée, désigner aussi une « Page des articles »
 *   pour que la liste du blog soit accessible (/blog ou slug choisi).
 */
defined( 'ABSPATH' ) || exit;

/**
 * Contexte front où `blog.css` doit se charger (liste + article post).
 */
function cbs_is_blog_frontend_view(): bool {
	if ( is_singular( 'post' ) ) {
		return true;
	}
	if ( is_home() ) {
		return true;
	}
	if ( is_archive() && cbs_archive_use_blog_layout() ) {
		return true;
	}

	return false;
}

/**
 * Archive.php doit afficher le listing blog uniquement pour des archives d’articles.
 */
function cbs_archive_use_blog_layout(): bool {
	if ( ! is_archive() ) {
		return false;
	}
	if ( is_post_type_archive() ) {
		return is_post_type_archive( 'post' );
	}
	if ( is_category() || is_tag() || is_author() || is_date() ) {
		return true;
	}
	if ( is_tax() ) {
		$obj = get_queried_object();
		if ( $obj instanceof WP_Term ) {
			$tax_obj = get_taxonomy( $obj->taxonomy );

			return is_object( $tax_obj )
				&& isset( $tax_obj->object_type )
				&& in_array( 'post', (array) $tax_obj->object_type, true );
		}
	}

	return false;
}

/**
 * Arguments WP_Query commun à la liste blog (filtres taxonomy / archives).
 *
 * @return array<string, mixed>
 */
function cbs_blog_archive_base_query_args(): array {
	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
		'nopaging'            => false,
	);

	if ( is_category() ) {
		$args['cat'] = (int) get_queried_object_id();

		return $args;
	}

	if ( is_tag() ) {
		$args['tag_id'] = (int) get_queried_object_id();

		return $args;
	}

	if ( is_author() ) {
		$args['author'] = (int) get_queried_object_id();

		return $args;
	}

	if ( is_year() ) {
		$args['year'] = (int) get_query_var( 'year' );

		return $args;
	}

	if ( is_month() ) {
		$args['year']     = (int) get_query_var( 'year' );
		$args['monthnum'] = (int) get_query_var( 'monthnum' );

		return $args;
	}

	if ( is_day() ) {
		$args['year']     = (int) get_query_var( 'year' );
		$args['monthnum'] = (int) get_query_var( 'monthnum' );
		$args['day']      = (int) get_query_var( 'day' );

		return $args;
	}

	if ( is_tax() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => $term->taxonomy,
					'field'    => 'term_id',
					'terms'    => array( $term->term_id ),
				),
			);

			return $args;
		}
	}

	return $args;
}

/**
 * Total d’articles publiés pour la liste courante (sans charger tous les IDs).
 */
function cbs_blog_archive_matching_count(): int {
	$query = new WP_Query(
		array_merge(
			cbs_blog_archive_base_query_args(),
			array(
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'no_found_rows'  => false,
			)
		)
	);
	$found = (int) $query->found_posts;
	wp_reset_postdata();

	return max( 0, $found );
}

/**
 * Nombre total de « pages » de grille après le bloc mis en avant (page 1 : 6 cartes après le premier post).
 */
function cbs_blog_archive_total_grid_pages(): int {
	$n = cbs_blog_archive_matching_count();

	if ( $n <= 0 ) {
		return 1;
	}

	if ( $n <= 7 ) {
		return 1;
	}

	return (int) ( 1 + (int) ceil( max( 0, $n - 7 ) / 6 ) );
}

/**
 * Forcer le type principal « post » sur la page des articles quand elle est configurée comme telle.
 */
function cbs_pre_get_posts_blog_page( WP_Query $query ): void {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_home() ) {
		return;
	}
	if ( 'page' !== (string) get_option( 'show_on_front', 'posts' ) ) {
		return;
	}

	$page_id = (int) get_option( 'page_for_posts', 0 );
	if ( $page_id <= 0 ) {
		return;
	}

	$query->set( 'post_type', 'post' );
	$query->set( 'ignore_sticky_posts', true );
}
add_action( 'pre_get_posts', 'cbs_pre_get_posts_blog_page', 5 );
