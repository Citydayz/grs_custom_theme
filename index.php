<?php
/**
 * CBS Theme — index.php
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">
<?php
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		the_content();
	}
} else {
	echo '<p>' . esc_html__( 'Aucun contenu à afficher.', 'cbs-theme' ) . '</p>';
}
?>
</main>
<?php
get_footer();
