<?php
/**
 * Bandeau logos partenaires (accueil) — marquee infini CSS (deux bandes identiques, translateX -50 %).
 *
 * Logos : menu Admin « Partenaires hôtels » — image mise en avant = logo, titre = nom de l’hôtel,
 * ordre = menu_order.
 */
defined( 'ABSPATH' ) || exit;

$partners_q = new WP_Query(
	array(
		'post_type'      => 'cbs_partners',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);

$slides = array();
if ( $partners_q->have_posts() ) {
	while ( $partners_q->have_posts() ) {
		$partners_q->the_post();
		$img_id  = (int) get_post_thumbnail_id();
		$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'full' ) : '';
		if ( ! $img_url ) {
			continue;
		}
		$slides[] = array(
			'url' => $img_url,
			'alt' => get_the_title(),
		);
	}
	wp_reset_postdata();
}

if ( empty( $slides ) ) {
	return;
}
?>
<section class="cbs-partners">
	<p class="cbs-partners__label">NOS HÔTELS PARTENAIRES</p>
	<div class="cbs-partners__slider">
		<div class="cbs-partners__track">
			<?php
			for ( $pass = 0; $pass < 2; $pass++ ) :
				?>
			<div class="cbs-partners__strip"<?php echo 1 === $pass ? ' aria-hidden="true"' : ''; ?>>
				<?php
				foreach ( $slides as $slide ) {
					?>
				<div class="cbs-partners__slide">
					<img class="cbs-partners__logo" src="<?php echo esc_url( $slide['url'] ); ?>" alt="<?php echo esc_attr( $slide['alt'] ); ?>" loading="lazy" decoding="async" />
				</div>
					<?php
				}
				?>
			</div>
				<?php
			endfor;
			?>
		</div>
	</div>
</section>
