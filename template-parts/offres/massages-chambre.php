<?php
/**
 * CBS Theme — Massages en chambre (content-structure.md §6).
 */
defined( 'ABSPATH' ) || exit;

while ( have_posts() ) {
	the_post();
}

$pid = (int) get_the_ID();
$d   = cbs_gestion_massages_defaults();
$h   = cbs_gestion_missions_headings();

$hero_title    = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_m_hero_title', $pid ), $d['hero_title'] ) : $d['hero_title'];
$hero_subtitle = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_m_hero_subtitle', $pid ), $d['hero_subtitle'] ) : $d['hero_subtitle'];
$badge         = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_m_badge', $pid ), $d['badge'] ) : $d['badge'];
$pos_acf       = function_exists( 'get_field' ) ? get_field( 'cbs_gestion_m_position', $pid ) : '';
$modele_intro  = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_m_modele_intro', $pid ), $d['modele_label'] ) : $d['modele_label'];
$modele_h2     = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_m_modele_h2', $pid ), $d['modele_h2'] ) : $d['modele_h2'];
$planif_title  = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_m_planif_title', $pid ), $d['planif_title'] ) : $d['planif_title'];
$planif_acf    = function_exists( 'get_field' ) ? get_field( 'cbs_gestion_m_planif', $pid ) : '';
$cta_label     = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_m_cta_label', $pid ), $d['cta_label'] ) : $d['cta_label'];

$modele_lignes = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_gestion_m_modele_lignes', $pid ), cbs_gestion_massages_modele_lignes_default() )
	: cbs_gestion_massages_modele_lignes_default();
$miss_g        = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_gestion_m_missions_g', $pid ), cbs_gestion_massages_missions_gestionnaire_default() )
	: cbs_gestion_massages_missions_gestionnaire_default();
$miss_h        = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_gestion_m_missions_h', $pid ), cbs_gestion_massages_missions_etab_default() )
	: cbs_gestion_massages_missions_etab_default();

$icons_mass_g = array( 'star', 'team', 'calendar', 'team', 'lightbulb', 'activity', 'list' );
?>
<section class="methode-spa-hero offre-gestion-hero cbs-section" aria-labelledby="massages-hero-heading">
	<div class="methode-spa-hero__inner cbs-container">
		<h1 id="massages-hero-heading" class="methode-spa-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="methode-spa-hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
		<p class="offre-gestion__badge offre-gestion__badge--hero" role="status"><?php echo esc_html( $badge ); ?></p>
	</div>
</section>

<section class="cbs-section offre-gestion-position" aria-labelledby="massages-position-heading">
	<div class="cbs-container offre-detail__inner">
		<h2 id="massages-position-heading" class="offre-detail__h2"><?php esc_html_e( 'Positionnement', 'cbs-theme' ); ?></h2>
		<div class="offre-gestion__position-text">
			<?php
			if ( is_string( $pos_acf ) && trim( $pos_acf ) !== '' ) {
				echo wp_kses_post( $pos_acf );
			} else {
				echo wp_kses_post( wpautop( $d['position'] ) );
			}
			?>
		</div>
	</div>
</section>

<section class="cbs-section offre-gestion-ca" aria-labelledby="massages-modele-heading">
	<div class="cbs-container">
		<div class="offre-gestion__ca-panel">
			<h2 id="massages-modele-heading" class="offre-detail__h2"><?php echo esc_html( $modele_h2 ); ?></h2>
			<p class="offre-gestion__modele-intro"><?php echo esc_html( $modele_intro ); ?></p>
			<ul class="offre-detail__list offre-gestion__modele-list">
				<?php foreach ( $modele_lignes as $line ) : ?>
					<li><?php echo esc_html( $line ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<section class="offre-phases" aria-labelledby="massages-mg-heading">
	<div class="offre-phases__inner">
		<header class="offre-phases__header">
			<h2 id="massages-mg-heading" class="offre-phases__title"><?php echo esc_html( $h['gest'] ); ?></h2>
			<p class="offre-phases__lead"><?php esc_html_e( 'Service clés en main : praticiens, qualité et pilotage.', 'cbs-theme' ); ?></p>
		</header>
		<div class="offre-phases__grid">
			<?php
			$mg_i = 0;
			foreach ( $miss_g as $line ) :
				++$mg_i;
				$ik  = $icons_mass_g[ $mg_i - 1 ] ?? 'star';
				$num = sprintf(
					/* translators: %s: index zero-padded (e.g. 01). */
					__( 'Mission %s', 'cbs-theme' ),
					sprintf( '%02d', $mg_i )
				);
				?>
				<article class="phase-card">
					<div class="phase-card__icon"><?php echo cbs_gestion_icon_svg( $ik ); ?></div>
					<p class="phase-card__number"><?php echo esc_html( $num ); ?></p>
					<h3 class="phase-card__title"><?php echo esc_html( $line ); ?></h3>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="cbs-section methode-niveaux" aria-labelledby="massages-mh-heading">
	<div class="cbs-container offre-phases__inner">
		<h2 id="massages-mh-heading" class="offre-detail__h2"><?php echo esc_html( $h['etab'] ); ?></h2>
		<div class="offre-phases__grid">
			<?php
			$msh_i = 0;
			foreach ( $miss_h as $line ) :
				++$msh_i;
				$num_h = sprintf(
					/* translators: %s: index zero-padded (e.g. 01). */
					__( 'Mission %s', 'cbs-theme' ),
					sprintf( '%02d', $msh_i )
				);
				?>
				<article class="phase-card phase-card--light">
					<p class="phase-card__number"><?php echo esc_html( $num_h ); ?></p>
					<h3 class="phase-card__title"><?php echo esc_html( $line ); ?></h3>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="cbs-section offre-gestion-planif" aria-labelledby="massages-planif-heading">
	<div class="cbs-container offre-detail__inner">
		<h2 id="massages-planif-heading" class="offre-detail__h2"><?php echo esc_html( $planif_title ); ?></h2>
		<div class="offre-gestion__position-text">
			<?php
			if ( is_string( $planif_acf ) && trim( $planif_acf ) !== '' ) {
				echo wp_kses_post( $planif_acf );
			} else {
				echo wp_kses_post( wpautop( $d['planif_text'] ) );
			}
			?>
		</div>
	</div>
</section>

<section class="cbs-section cta-rdv offre-gestion-final-cta" aria-labelledby="massages-cta-heading">
	<div class="cbs-container cta-rdv__inner">
		<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $cta_label ); ?></a>
	</div>
</section>
