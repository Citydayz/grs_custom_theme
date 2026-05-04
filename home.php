<?php
/**
 * CBS Theme — home.php — index des articles (page « Publications » configurée sous Réglages → Lecture).
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main site-main--blog-archive">
<?php get_template_part( 'template-parts/blog/blog-archive' ); ?>
</main>
<?php
get_footer();
