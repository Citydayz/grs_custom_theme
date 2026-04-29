<?php
/**
 * CBS Theme — 404.php
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">
	<h1><?php esc_html_e( 'Page introuvable', 'cbs-theme' ); ?></h1>
	<p><?php esc_html_e( 'Le contenu demandé n’existe pas ou a été déplacé.', 'cbs-theme' ); ?></p>
</main>
<?php
get_footer();
