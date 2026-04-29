<?php
/**
 * CBS Theme — Gestion externalisée complète (content-structure.md §4).
 */
defined( 'ABSPATH' ) || exit;

while ( have_posts() ) {
	the_post();
}

$pid = (int) get_the_ID();
$d   = cbs_gestion_complete_defaults();
$h   = cbs_gestion_complete_resp_headings();

$modele     = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_c_modele', $pid ), $d['modele'] ) : $d['modele'];
$hero_title = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_c_hero_title', $pid ), $d['hero_title'] ) : $d['hero_title'];
$pos_acf    = function_exists( 'get_field' ) ? get_field( 'cbs_gestion_c_position', $pid ) : '';

$t_a = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_c_option_a_title', $pid ), $d['option_a_title'] ) : $d['option_a_title'];
$i_a = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_c_option_a_intro', $pid ), $d['option_a_intro'] ) : $d['option_a_intro'];
$t_b = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_c_option_b_title', $pid ), $d['option_b_title'] ) : $d['option_b_title'];
$i_b = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_c_option_b_intro', $pid ), $d['option_b_intro'] ) : $d['option_b_intro'];
$note = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_c_note', $pid ), $d['note_finance'] ) : $d['note_finance'];
$opt_lead = function_exists( 'get_field' )
	? cbs_offres_scalar( get_field( 'cbs_gestion_c_options_lead', $pid ), $d['options_lead'] )
	: $d['options_lead'];
$cta  = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_c_cta_label', $pid ), $d['cta_label'] ) : $d['cta_label'];

$lines_a = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_gestion_c_option_a_lignes', $pid ), cbs_gestion_complete_option_a_lines_default() )
	: cbs_gestion_complete_option_a_lines_default();
$lines_b = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_gestion_c_option_b_lignes', $pid ), cbs_gestion_complete_option_b_lines_default() )
	: cbs_gestion_complete_option_b_lines_default();

$resp_g = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_gestion_c_resp_g', $pid ), cbs_gestion_complete_resp_gestionnaire_default() )
	: cbs_gestion_complete_resp_gestionnaire_default();
$resp_h = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_gestion_c_resp_h', $pid ), cbs_gestion_complete_resp_hotel_default() )
	: cbs_gestion_complete_resp_hotel_default();

$icons_resp_g = array(
	'helm', 'calendar', 'team', 'star', 'list', 'megaphone', 'chart_line',
	'activity', 'box', 'brush', 'box',
);
?>
<section class="methode-spa-hero methode-spa-hero--compact offre-gestion-hero cbs-section" aria-labelledby="gestion-c-hero-heading">
	<div class="methode-spa-hero__inner cbs-container">
		<p class="methode-spa-hero__kicker"><?php echo esc_html( $modele ); ?></p>
		<h1 id="gestion-c-hero-heading" class="methode-spa-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
	</div>
</section>

<section class="cbs-section offre-gestion-position" aria-labelledby="gestion-c-position-heading">
	<div class="cbs-container offre-detail__inner">
		<h2 id="gestion-c-position-heading" class="offre-detail__h2"><?php esc_html_e( 'Positionnement', 'cbs-theme' ); ?></h2>
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

<section class="offre-phases offre-gestion-options" aria-labelledby="gestion-c-options-heading">
	<div class="offre-phases__inner">
		<header class="offre-phases__header">
			<h2 id="gestion-c-options-heading" class="offre-phases__title"><?php esc_html_e( 'Rémunération (deux options présentées en RDV)', 'cbs-theme' ); ?></h2>
			<p class="offre-phases__lead"><?php echo esc_html( $opt_lead ); ?></p>
		</header>
		<div class="offre-phases__grid">
			<article class="phase-card offre-gestion__option-card">
				<p class="offre-phases__kicker"><?php esc_html_e( 'Option A', 'cbs-theme' ); ?></p>
				<h3 class="phase-card__title"><?php echo esc_html( $t_a ); ?></h3>
				<p class="offre-gestion__option-intro"><?php echo esc_html( $i_a ); ?></p>
				<ul class="phase-card__list">
					<?php foreach ( $lines_a as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</article>
			<article class="phase-card offre-gestion__option-card">
				<p class="offre-phases__kicker"><?php esc_html_e( 'Option B', 'cbs-theme' ); ?></p>
				<h3 class="phase-card__title"><?php echo esc_html( $t_b ); ?></h3>
				<p class="offre-gestion__option-intro"><?php echo esc_html( $i_b ); ?></p>
				<ul class="phase-card__list">
					<?php foreach ( $lines_b as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</article>
		</div>
		<p class="offre-gestion__note-rdv"><?php echo esc_html( $note ); ?></p>
	</div>
</section>

<section class="offre-phases" aria-labelledby="gestion-c-rg-heading">
	<div class="offre-phases__inner">
		<header class="offre-phases__header">
			<h2 id="gestion-c-rg-heading" class="offre-phases__title"><?php echo esc_html( $h['gest'] ); ?></h2>
			<p class="offre-phases__lead"><?php esc_html_e( 'Un périmètre opérationnel étendu, clé en main.', 'cbs-theme' ); ?></p>
		</header>
		<div class="offre-phases__grid">
			<?php
			$rg_i = 0;
			foreach ( $resp_g as $line ) :
				++$rg_i;
				$ik  = $icons_resp_g[ $rg_i - 1 ] ?? 'helm';
				$num = sprintf(
					/* translators: %s: index zero-padded (e.g. 01). */
					__( 'Mission %s', 'cbs-theme' ),
					sprintf( '%02d', $rg_i )
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

<section class="cbs-section methode-niveaux" aria-labelledby="gestion-c-rh-heading">
	<div class="cbs-container offre-phases__inner">
		<h2 id="gestion-c-rh-heading" class="offre-detail__h2"><?php echo esc_html( $h['hotel'] ); ?></h2>
		<div class="offre-phases__grid">
			<?php
			$rh_i = 0;
			foreach ( $resp_h as $line ) :
				++$rh_i;
				$num_h = sprintf(
					/* translators: %s: index zero-padded (e.g. 01). */
					__( 'Mission %s', 'cbs-theme' ),
					sprintf( '%02d', $rh_i )
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

<section class="cbs-section cta-rdv offre-gestion-final-cta" aria-labelledby="gestion-c-cta-heading">
	<div class="cbs-container cta-rdv__inner">
		<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $cta ); ?></a>
	</div>
</section>
