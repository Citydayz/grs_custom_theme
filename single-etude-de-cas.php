<?php
/**
 * Single étude de cas (content-structure.md §7).
 *
 * @package CBS_Theme
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) {
	the_post();

	$contexte       = function_exists( 'get_field' ) ? get_field( 'cbs_contexte' ) : '';
	$enjeux         = function_exists( 'get_field' ) ? get_field( 'cbs_enjeux' ) : '';
	$accompagnement = function_exists( 'get_field' ) ? get_field( 'cbs_accompagnement' ) : '';
	$resultats      = function_exists( 'get_field' ) ? get_field( 'cbs_resultats' ) : '';
	$temoignage     = function_exists( 'get_field' ) ? get_field( 'cbs_temoignage' ) : '';
	$profil         = function_exists( 'get_field' ) ? get_field( 'cbs_profil_prospect' ) : '';

	$mission_terms = get_the_terms( get_the_ID(), 'type-mission' );
	$mission_label = '';
	if ( $mission_terms && ! is_wp_error( $mission_terms ) && isset( $mission_terms[0] ) ) {
		$mission_label = $mission_terms[0]->name;
	}

	$archive_url = get_post_type_archive_link( 'etude-de-cas' );
	?>
	<main id="primary" class="site-main etude-cas-single">
		<article <?php post_class( 'etude-cas-single__article' ); ?> id="post-<?php the_ID(); ?>">
			<header class="cbs-section etude-cas-single__hero">
				<div class="etude-cas-single__hero-inner cbs-container">
					<?php if ( $archive_url ) : ?>
						<p class="etude-cas-single__back-wrap">
							<a class="etude-cas-single__back" href="<?php echo esc_url( $archive_url ); ?>">
								<?php esc_html_e( '← Retour aux références', 'cbs-theme' ); ?>
							</a>
						</p>
					<?php endif; ?>

					<?php if ( $mission_label !== '' ) : ?>
						<p class="etude-cas-single__type"><?php echo esc_html( $mission_label ); ?></p>
					<?php endif; ?>

					<?php if ( is_string( $profil ) && $profil !== '' ) : ?>
						<p class="etude-cas-single__profil">
							<span class="etude-cas-single__profil-badge">
								<?php
								echo esc_html(
									sprintf(
										/* translators: %s: A, B ou C */
										__( 'Profil %s', 'cbs-theme' ),
										$profil
									)
								);
								?>
							</span>
						</p>
					<?php endif; ?>

					<h1 class="etude-cas-single__title"><?php the_title(); ?></h1>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="etude-cas-single__thumb">
							<?php
							the_post_thumbnail(
								'large',
								array(
									'class'   => 'etude-cas-single__img',
									'loading' => 'lazy',
									'decoding' => 'async',
								)
							);
							?>
						</div>
					<?php endif; ?>
				</div>
			</header>

			<div class="cbs-section etude-cas-single__body">
				<div class="etude-cas-single__inner cbs-container etude-cas-single__prose">
					<?php if ( is_string( $contexte ) && $contexte !== '' ) : ?>
						<section class="etude-cas-single__block" aria-labelledby="etude-contexte-heading">
							<h2 id="etude-contexte-heading" class="etude-cas-single__block-title">
								<?php esc_html_e( 'Contexte', 'cbs-theme' ); ?>
							</h2>
							<div class="etude-cas-single__block-content">
								<?php echo wp_kses_post( $contexte ); ?>
							</div>
						</section>
					<?php endif; ?>

					<?php if ( is_string( $enjeux ) && $enjeux !== '' ) : ?>
						<section class="etude-cas-single__block" aria-labelledby="etude-enjeux-heading">
							<h2 id="etude-enjeux-heading" class="etude-cas-single__block-title">
								<?php esc_html_e( 'Enjeux', 'cbs-theme' ); ?>
							</h2>
							<div class="etude-cas-single__block-content">
								<?php echo wp_kses_post( $enjeux ); ?>
							</div>
						</section>
					<?php endif; ?>

					<?php if ( is_string( $accompagnement ) && $accompagnement !== '' ) : ?>
						<section class="etude-cas-single__block" aria-labelledby="etude-accompagnement-heading">
							<h2 id="etude-accompagnement-heading" class="etude-cas-single__block-title">
								<?php esc_html_e( 'Accompagnement', 'cbs-theme' ); ?>
							</h2>
							<div class="etude-cas-single__block-content">
								<?php echo wp_kses_post( $accompagnement ); ?>
							</div>
						</section>
					<?php endif; ?>

					<?php if ( is_string( $resultats ) && $resultats !== '' ) : ?>
						<section class="etude-cas-single__block" aria-labelledby="etude-resultats-heading">
							<h2 id="etude-resultats-heading" class="etude-cas-single__block-title">
								<?php esc_html_e( 'Résultats', 'cbs-theme' ); ?>
							</h2>
							<div class="etude-cas-single__block-content">
								<?php echo wp_kses_post( $resultats ); ?>
							</div>
						</section>
					<?php endif; ?>

					<?php if ( is_string( $temoignage ) && trim( $temoignage ) !== '' ) : ?>
						<section class="etude-cas-single__block etude-cas-single__block--temoignage" aria-labelledby="etude-temoignage-heading">
							<h2 id="etude-temoignage-heading" class="screen-reader-text">
								<?php esc_html_e( 'Témoignage', 'cbs-theme' ); ?>
							</h2>
							<blockquote class="etude-cas-single__quote">
								<?php echo wp_kses_post( $temoignage ); ?>
							</blockquote>
						</section>
					<?php endif; ?>

					<section class="etude-cas-single__ctas" aria-labelledby="etude-ctas-heading">
						<h2 id="etude-ctas-heading" class="screen-reader-text">
							<?php esc_html_e( 'Étapes suivantes', 'cbs-theme' ); ?>
						</h2>
						<div class="etude-cas-single__ctas-row">
							<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
								<?php esc_html_e( 'Discuter de votre projet', 'cbs-theme' ); ?>
							</a>
							<a class="btn-secondary" href="<?php echo esc_url( home_url( '/diagnostic-spa/' ) ); ?>">
								<?php esc_html_e( 'Lancer le diagnostic spa', 'cbs-theme' ); ?>
							</a>
						</div>
					</section>
				</div>
			</div>
		</article>
	</main>
	<?php
}
get_footer();
