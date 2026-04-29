<?php
/**
 * CBS Theme — Hero accueil (content-structure.md §2 section 1)
 */
defined( 'ABSPATH' ) || exit;

$hero_media = cbs_get_home_hero_media_urls();
$poster     = $hero_media['poster'];
$video      = $hero_media['video'];
$hero_style = sprintf(
	'--cbs-hero-poster: url(%s)',
	esc_url( $poster )
);
?>
<section class="hero" style="<?php echo esc_attr( $hero_style ); ?>" aria-label="<?php esc_attr_e( 'Introduction', 'cbs-theme' ); ?>">
	<div class="hero__media" aria-hidden="true">
		<?php if ( $video !== '' ) : ?>
		<video
			class="hero__video"
			autoplay
			muted
			loop
			playsinline
			poster="<?php echo esc_url( $poster ); ?>"
		>
			<source src="<?php echo esc_url( $video ); ?>" type="video/mp4" />
		</video>
		<?php else : ?>
		<img
			class="hero__video"
			src="<?php echo esc_url( $poster ); ?>"
			alt=""
			width="1440"
			height="810"
			decoding="async"
			fetchpriority="high"
		/>
		<?php endif; ?>
		<div class="hero__overlay"></div>
	</div>

	<div class="hero__inner cbs-container">
		<p class="hero__kicker"><?php esc_html_e( 'Conseil & Gestion de spa hôtelier', 'cbs-theme' ); ?></p>
		<h1 class="hero__title">
			<?php esc_html_e( "On s'occupe de votre spa de A à Z pour qu'il devienne rentable.", 'cbs-theme' ); ?>
		</h1>
		<p class="hero__subtitle">
			<?php esc_html_e( "J'accompagne les hôtels 4★ et 5★ dans la création et l'optimisation de leurs spas — pour éviter les erreurs coûteuses et concevoir des espaces réellement performants.", 'cbs-theme' ); ?>
		</p>
		<div class="hero__actions">
			<a class="btn-primary hero__cta-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
				<?php esc_html_e( 'Discuter de votre projet', 'cbs-theme' ); ?>
			</a>
			<a class="btn-secondary hero__cta-secondary" href="<?php echo esc_url( home_url( '/methode-spa-profit/' ) ); ?>">
				<?php esc_html_e( 'Voir la méthode', 'cbs-theme' ); ?>
			</a>
		</div>
	</div>
</section>
