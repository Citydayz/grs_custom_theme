<?php
/**
 * CBS Theme — Niveau 2 Conception & sécurisation (content-structure.md §3).
 */
defined( 'ABSPATH' ) || exit;

while ( have_posts() ) {
	the_post();
}

$pid    = (int) get_the_ID();
$d      = cbs_offres_niveau_2_defaults();
$ph_def = cbs_offres_niveau_2_phases_defaults();

$hero_kicker   = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n2_hero_kicker', $pid ), $d['hero_kicker'] ) : $d['hero_kicker'];
$hero_title    = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n2_hero_title', $pid ), $d['hero_title'] ) : $d['hero_title'];
$hero_subtitle = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n2_hero_subtitle', $pid ), $d['hero_subtitle'] ) : $d['hero_subtitle'];

$phases_rows = function_exists( 'get_field' ) ? get_field( 'cbs_offres_n2_phases', $pid ) : null;
$phases      = cbs_offres_n2_phases_resolved( $phases_rows, $ph_def );

$phases_kicker = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n2_phases_kicker', $pid ), $d['phases_kicker'] ) : $d['phases_kicker'];
$phases_title  = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n2_phases_title', $pid ), $d['phases_title'] ) : $d['phases_title'];
$phases_lead   = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n2_phases_lead', $pid ), $d['phases_lead'] ) : $d['phases_lead'];

$options = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_offres_n2_options', $pid ), $d['options'] )
	: $d['options'];

$cta_label = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n2_cta_label', $pid ), $d['cta_label'] ) : $d['cta_label'];
?>
<section class="methode-spa-hero methode-spa-hero--compact cbs-section" aria-labelledby="n2-hero-heading">
	<div class="methode-spa-hero__inner cbs-container">
		<p class="methode-spa-hero__kicker"><?php echo esc_html( $hero_kicker ); ?></p>
		<h1 id="n2-hero-heading" class="methode-spa-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="methode-spa-hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
	</div>
</section>

<section class="offre-phases" aria-labelledby="n2-phases-heading">
	<div class="offre-phases__inner">
		<header class="offre-phases__header">
			<p class="offre-phases__kicker"><?php echo esc_html( $phases_kicker ); ?></p>
			<h2 id="n2-phases-heading" class="offre-phases__title"><?php echo esc_html( $phases_title ); ?></h2>
			<p class="offre-phases__lead"><?php echo esc_html( $phases_lead ); ?></p>
		</header>
		<div class="offre-phases__grid">
			<?php
			$phase_num = 0;
			foreach ( $phases as $phase ) :
				++$phase_num;
				$num_label = sprintf(
					/* translators: %s: phase number zero-padded (e.g. 01). */
					__( 'Phase %s', 'cbs-theme' ),
					sprintf( '%02d', $phase_num )
				);
				?>
				<article class="phase-card">
					<div class="phase-card__icon"><?php echo cbs_offres_n2_phase_icon_svg( $phase_num ); ?></div>
					<p class="phase-card__number"><?php echo esc_html( $num_label ); ?></p>
					<h3 class="phase-card__title"><?php echo esc_html( (string) ( $phase['title'] ?? '' ) ); ?></h3>
					<?php
					$phase_intro = isset( $phase['intro'] ) ? trim( (string) $phase['intro'] ) : '';
					if ( $phase_intro !== '' ) :
						?>
						<p class="phase-card__intro"><?php echo esc_html( $phase_intro ); ?></p>
					<?php endif; ?>
					<?php
					$items = $phase['items'] ?? array();
					if ( is_array( $items ) && $items !== array() ) :
						?>
						<ul class="phase-card__list">
							<?php foreach ( $items as $it ) : ?>
								<li><?php echo esc_html( (string) $it ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php
					$liv = isset( $phase['livrables'] ) ? trim( (string) $phase['livrables'] ) : '';
					if ( $liv !== '' ) :
						?>
						<div class="phase-card__livrables"><?php echo esc_html( $liv ); ?></div>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="cbs-section offre-detail" aria-labelledby="n2-options-heading">
	<div class="cbs-container offre-detail__inner">
		<h2 id="n2-options-heading" class="offre-detail__h2"><?php esc_html_e( 'Options tarifaires', 'cbs-theme' ); ?></h2>
		<ul class="offre-detail__list">
			<?php foreach ( $options as $line ) : ?>
				<li><?php echo esc_html( $line ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="cbs-section cta-rdv" aria-labelledby="n2-cta-heading">
	<div class="cbs-container cta-rdv__inner">
		<h2 id="n2-cta-heading" class="screen-reader-text"><?php esc_html_e( 'Étape suivante', 'cbs-theme' ); ?></h2>
		<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $cta_label ); ?></a>
	</div>
</section>
