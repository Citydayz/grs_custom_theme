<?php
/**
 * CBS Theme — search.php
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">
	<h1>
<?php
if ( get_search_query() ) {
	printf(
		/* translators: %s: search query */
		esc_html__( 'Résultats pour « %s »', 'cbs-theme' ),
		esc_html( get_search_query() )
	);
} else {
	esc_html_e( 'Recherche', 'cbs-theme' );
}
?>
	</h1>
<?php
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		the_title( '<h2><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
		the_excerpt();
	}
} else {
	echo '<p>' . esc_html__( 'Aucun résultat.', 'cbs-theme' ) . '</p>';
}
?>
</main>
<?php
get_footer();
