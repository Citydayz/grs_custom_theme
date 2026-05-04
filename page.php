<?php
/**
 * CBS Theme — page.php
 */
defined( 'ABSPATH' ) || exit;

get_header();

$slug = get_post_field( 'post_name', get_queried_object_id() );
$map  = array(
	'methode-spa-profit'      => 'offres/methode-hub',
	'diagnostic-strategique'  => 'offres/niveau-1-diagnostic',
	'conception-securisation' => 'offres/niveau-2-conception',
	'mise-en-performance'     => 'offres/niveau-3-performance',
	'gestion-spa-hotelier'    => 'offres/gestion-hub',
	'gestion-partielle'       => 'offres/gestion-partielle',
	'gestion-complete'        => 'offres/gestion-complete',
	'staffing-spa'            => 'offres/staffing',
	'massages-en-chambre-hotel' => 'offres/massages-chambre',
	'qui-sommes-nous'         => 'offres/qui-sommes-nous',
	'references'              => 'references',
);
?>
<main id="primary" class="site-main">
<?php
if ( isset( $map[ $slug ] ) ) {
	get_template_part( 'template-parts/' . $map[ $slug ] );
} else {
	while ( have_posts() ) {
		the_post();
		the_content();
	}
}
?>
</main>
<?php
get_footer();
