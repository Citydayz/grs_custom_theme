<?php
/**
 * CBS Theme — front-page.php
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">
<?php
get_template_part( 'template-parts/home/hero' );
get_template_part( 'template-parts/home/partners' );
get_template_part( 'template-parts/home/segmentation-profils' );
get_template_part( 'template-parts/home/probleme-marche' );
get_template_part( 'template-parts/home/poles-overview' );
get_template_part( 'template-parts/home/preuves-sociales' );
get_template_part( 'template-parts/shared/cta-rdv' );
?>
</main>
<?php
get_footer();
