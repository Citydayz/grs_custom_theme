<?php
/**
 * CBS Theme — archive.php — archives taxonomy / dates sur les articles (liste identique au blog).
 */
defined( 'ABSPATH' ) || exit;

get_header();

if ( cbs_archive_use_blog_layout() ) :
	?>
	<main id="primary" class="site-main site-main--blog-archive">
	<?php get_template_part( 'template-parts/blog/blog-archive' ); ?>
	</main>
	<?php
else :
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
endif;

get_footer();
