<?php
/**
 * Page vitrine Références (`page.php` slug `references`).
 *
 * Données ACF groupe `group_cbs_page_references`; défauts `inc/references-defaults.php`.
 *
 * @package CBS_Theme
 */
defined( 'ABSPATH' ) || exit;

while ( have_posts() ) {
	the_post();
}

$page_id = (int) get_the_ID();
$d_page  = cbs_references_page_defaults();

$hero_kicker   = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_ref_hero_kicker', $page_id ), $d_page['hero_kicker'] ) : $d_page['hero_kicker'];
$hero_title    = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_ref_hero_title', $page_id ), $d_page['hero_title'] ) : $d_page['hero_title'];
$hero_subtitle = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_ref_hero_subtitle', $page_id ), $d_page['hero_subtitle'] ) : $d_page['hero_subtitle'];

$cta_label = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_ref_cta_label', $page_id ), $d_page['cta_label'] ) : $d_page['cta_label'];

$citation_text = function_exists( 'get_field' )
	? cbs_offres_scalar( get_field( 'cbs_ref_citation', $page_id ), $d_page['citation'] )
	: $d_page['citation'];
$attribution   = function_exists( 'get_field' )
	? cbs_offres_scalar( get_field( 'cbs_ref_attribution', $page_id ), $d_page['attribution'] )
	: $d_page['attribution'];

$stats = array();
for ( $si = 1; $si <= 3; $si++ ) {
	$vk = 'cbs_ref_stat_' . $si . '_valeur';
	$lk = 'cbs_ref_stat_' . $si . '_label';
	$vk_d = $d_page[ 'stat_' . $si . '_valeur' ];
	$lk_d = $d_page[ 'stat_' . $si . '_label' ];
	$v    = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( $vk, $page_id ), $vk_d ) : $vk_d;
	$lab  = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( $lk, $page_id ), $lk_d ) : $lk_d;
	$stats[] = array( 'val' => $v, 'label' => $lab );
}

$seo_heading = $d_page['seo_heading'];
$seo_text    = function_exists( 'get_field' )
	? cbs_offres_scalar( get_field( 'cbs_ref_seo_text', $page_id ), $d_page['seo_text'] )
	: $d_page['seo_text'];

$seo_image_acf = function_exists( 'get_field' ) ? get_field( 'cbs_ref_seo_image', $page_id ) : null;
$seo_image_url = cbs_acf_media_url( $seo_image_acf );
if ( $seo_image_url === '' ) {
	$seo_image_url = $d_page['seo_image'];
}

$hero_bg = '';
if ( has_post_thumbnail() ) {
	$thumb_url = get_the_post_thumbnail_url( null, 'full' );
	if ( is_string( $thumb_url ) && $thumb_url !== '' ) {
		$hero_bg = ' style="background-image: url(\'' . esc_url( $thumb_url ) . '\');"';
	}
}
?>
<div class="page-references">
	<section class="cbs-section methode-spa-hero page-references__hero" aria-labelledby="ref-hero-heading"<?php echo $hero_bg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with esc_url(). ?>>
		<div class="methode-spa-hero__inner page-references__hero-inner cbs-container">
			<p class="methode-spa-hero__kicker"><?php echo esc_html( $hero_kicker ); ?></p>
			<h1 id="ref-hero-heading" class="methode-spa-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
			<p class="methode-spa-hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
		</div>
	</section>

	<section class="cbs-section page-references__bento" aria-labelledby="ref-bento-heading">
		<div class="cbs-container">
			<h2 id="ref-bento-heading" class="screen-reader-text"><?php esc_html_e( 'Sélection de références', 'cbs-theme' ); ?></h2>
			<?php
			$ref_bento_placeholders = array(
				'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800&q=80',
				'https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?w=800&q=80',
				'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&q=80',
			);
			$n_ph                   = count( $ref_bento_placeholders );

			$ref_query = new WP_Query(
				array(
					'post_type'      => 'etude-de-cas',
					'posts_per_page' => 5,
					'post_status'    => 'publish',
					'no_found_rows'  => true,
				)
			);

			if ( $ref_query->have_posts() ) :
				$ref_trunc_80 = static function ( string $str ): string {
					$t = trim( preg_replace( '/\s+/u', ' ', $str ) );
					if ( $t === '' ) {
						return '';
					}
					if ( function_exists( 'mb_strlen' ) && function_exists( 'mb_substr' ) && mb_strlen( $t, 'UTF-8' ) > 80 ) {
						return mb_substr( $t, 0, 80, 'UTF-8' ) . '…';
					}
					return strlen( $t ) > 80 ? substr( $t, 0, 77 ) . '...' : $t;
				};
				?>
			<div class="page-references__bento-grid" role="list">
				<?php
				$ref_idx = 0;
				while ( $ref_query->have_posts() ) :
					$ref_query->the_post();
					$ref_pid       = get_the_ID();
					$tile_class    = 0 === $ref_idx ? 'page-references__bento-tile page-references__bento-tile--large' : 'page-references__bento-tile page-references__bento-tile--small';
					$thumb_raw     = get_the_post_thumbnail_url( $ref_pid, 'large' );
					$img_url       = is_string( $thumb_raw ) && $thumb_raw !== '' ? $thumb_raw : $ref_bento_placeholders[ $ref_idx % $n_ph ];
					$heading_id    = 'ref-bento-titre-' . (int) $ref_idx;
					$ref_title     = get_the_title();

					$ref_badge = '';
					$ref_terms = get_the_terms( $ref_pid, 'type-mission' );
					if ( ! is_wp_error( $ref_terms ) && is_array( $ref_terms ) && $ref_terms !== array() ) {
						$ref_badge = (string) $ref_terms[0]->name;
					} elseif ( function_exists( 'get_field' ) ) {
						$tm_raw = get_field( 'cbs_type_mission', $ref_pid );
						if ( $tm_raw instanceof WP_Term ) {
							$ref_badge = $tm_raw->name;
						} elseif ( is_array( $tm_raw ) && isset( $tm_raw['name'] ) ) {
							$ref_badge = (string) $tm_raw['name'];
						}
					}

					$zone_out = '';
					if ( function_exists( 'get_field' ) ) {
						$c_ctx = get_field( 'cbs_contexte', $ref_pid );
						if ( is_string( $c_ctx ) ) {
							$zone_out = $ref_trunc_80( wp_strip_all_tags( $c_ctx ) );
						}
					}
					if ( $zone_out === '' ) {
						$zone_out = $ref_trunc_80( wp_strip_all_tags( get_the_excerpt() ) );
					}

					$alt_parts = array_filter( array( $ref_title, $ref_badge ) );
					$alt_piece = implode( ' — ', $alt_parts );
					if ( $alt_piece === '' ) {
						$alt_piece = __( 'Référence spa hôtelière — photographie illustrative', 'cbs-theme' );
					}

					$ref_loading = ( 0 === $ref_idx ) ? 'eager' : 'lazy';
					++$ref_idx;
					?>
				<article class="<?php echo esc_attr( $tile_class ); ?>" role="listitem">
					<div class="page-references__bento-media">
						<img
							class="page-references__bento-img"
							src="<?php echo esc_url( $img_url ); ?>"
							width="800"
							height="533"
							alt="<?php echo esc_attr( $alt_piece ); ?>"
							loading="<?php echo esc_attr( $ref_loading ); ?>"
							decoding="async"
						>
						<div class="page-references__bento-overlay" aria-hidden="true"></div>
						<div class="page-references__bento-caption">
							<?php if ( $ref_badge !== '' ) : ?>
								<p class="page-references__bento-badge"><?php echo esc_html( $ref_badge ); ?></p>
							<?php endif; ?>
							<h3 id="<?php echo esc_attr( $heading_id ); ?>" class="page-references__bento-title"><?php echo esc_html( $ref_title ); ?></h3>
							<?php if ( $zone_out !== '' ) : ?>
								<p class="page-references__bento-zone"><?php echo esc_html( $zone_out ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</article>
				<?php endwhile; ?>
			</div>
				<?php
			else :
				printf(
					'<p class="page-references__empty">%s</p>',
					esc_html__( 'Les références seront disponibles prochainement.', 'cbs-theme' )
				);
			endif;
			wp_reset_postdata();
			?>
		</div>
	</section>

	<section class="cbs-section page-references__stats-strip" aria-labelledby="ref-stats-heading">
		<div class="cbs-container">
			<h2 id="ref-stats-heading" class="screen-reader-text"><?php esc_html_e( 'Chiffres clés', 'cbs-theme' ); ?></h2>
			<ul class="page-references__stats-list">
				<?php foreach ( $stats as $s ) : ?>
					<li class="page-references__stats-item">
						<?php if ( $s['val'] !== '' ) : ?>
							<p class="page-references__stats-value"><?php echo esc_html( $s['val'] ); ?></p>
						<?php endif; ?>
						<?php if ( $s['label'] !== '' ) : ?>
							<p class="page-references__stats-label"><?php echo esc_html( $s['label'] ); ?></p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="cbs-section page-references__seo" aria-labelledby="ref-seo-heading">
		<div class="cbs-container">
			<div class="page-references__seo-split">
				<div class="page-references__seo-copy">
					<h2 id="ref-seo-heading" class="page-references__seo-title"><?php echo esc_html( $seo_heading ); ?></h2>
					<div class="page-references__seo-text">
						<?php echo wp_kses_post( wpautop( $seo_text ) ); ?>
					</div>
				</div>
				<div class="page-references__seo-media">
					<img
						class="page-references__seo-img"
						src="<?php echo esc_url( $seo_image_url ); ?>"
						width="800"
						height="533"
						alt="<?php echo esc_attr__( 'Illustration : accompagnement spa hôtelier sur le terrain', 'cbs-theme' ); ?>"
						loading="lazy"
						decoding="async"
					>
				</div>
			</div>
		</div>
	</section>

	<section class="cbs-section page-references__quote" aria-labelledby="ref-quote-heading">
		<div class="cbs-container page-references__quote-inner">
			<h2 id="ref-quote-heading" class="screen-reader-text"><?php esc_html_e( 'Citation', 'cbs-theme' ); ?></h2>
			<div class="page-references__quote-mark" aria-hidden="true">&ldquo;</div>
			<blockquote class="page-references__quote-body">
				<p class="page-references__quote-text"><?php echo esc_html( $citation_text ); ?></p>
			</blockquote>
			<hr class="page-references__quote-rule" aria-hidden="true">
			<?php if ( $attribution !== '' ) : ?>
				<cite class="page-references__quote-by"><?php echo esc_html( $attribution ); ?></cite>
			<?php endif; ?>
		</div>
	</section>

	<section class="cbs-section cta-rdv page-references__cta" aria-labelledby="ref-cta-heading">
		<div class="cbs-container cta-rdv__inner page-references__cta-inner">
			<h2 id="ref-cta-heading" class="screen-reader-text"><?php esc_html_e( 'Contact', 'cbs-theme' ); ?></h2>
			<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $cta_label ); ?></a>
		</div>
	</section>
</div>
