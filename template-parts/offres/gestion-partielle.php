<?php
/**
 * CBS Theme — Gestion externalisée partielle (content-structure.md §4).
 */
defined( 'ABSPATH' ) || exit;

while ( have_posts() ) {
	the_post();
}

$pid = (int) get_the_ID();
$d   = cbs_gestion_partielle_defaults();
$h   = cbs_gestion_missions_headings();

$modele     = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_p_modele', $pid ), $d['modele'] ) : $d['modele'];
$hero_title = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_p_hero_title', $pid ), $d['hero_title'] ) : $d['hero_title'];
$pos_acf    = function_exists( 'get_field' ) ? get_field( 'cbs_gestion_p_position', $pid ) : '';
$note       = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_p_note', $pid ), $d['note_rdv'] ) : $d['note_rdv'];
$cta_label  = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_p_cta_label', $pid ), $d['cta_label'] ) : $d['cta_label'];

$ca_rows = function_exists( 'get_field' )
	? cbs_gestion_ca_rows_resolved( get_field( 'cbs_gestion_p_ca', $pid ), cbs_gestion_partielle_ca_default() )
	: cbs_gestion_partielle_ca_default();

$miss_g = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_gestion_p_missions_g', $pid ), cbs_gestion_partielle_missions_gestionnaire_default() )
	: cbs_gestion_partielle_missions_gestionnaire_default();
$miss_h = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_gestion_p_missions_h', $pid ), cbs_gestion_partielle_missions_etab_default() )
	: cbs_gestion_partielle_missions_etab_default();

$icons_missions_g = array(
	'helm', 'star', 'list', 'sparkles', 'chart_bars', 'team', 'calendar',
	'team', 'lightbulb', 'chart_line', 'megaphone', 'activity', 'box',
);
?>
<section class="methode-spa-hero methode-spa-hero--compact offre-gestion-hero cbs-section" aria-labelledby="gestion-p-hero-heading">
	<div class="methode-spa-hero__inner cbs-container">
		<p class="methode-spa-hero__kicker"><?php echo esc_html( $modele ); ?></p>
		<h1 id="gestion-p-hero-heading" class="methode-spa-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
	</div>
</section>

<section class="cbs-section offre-gestion-position" aria-labelledby="gestion-p-position-heading">
	<div class="cbs-container offre-detail__inner">
		<h2 id="gestion-p-position-heading" class="offre-detail__h2"><?php esc_html_e( 'Positionnement', 'cbs-theme' ); ?></h2>
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

<section class="offre-phases" aria-labelledby="gestion-p-mg-heading">
	<div class="offre-phases__inner">
		<header class="offre-phases__header">
			<h2 id="gestion-p-mg-heading" class="offre-phases__title"><?php echo esc_html( $h['gest'] ); ?></h2>
			<p class="offre-phases__lead"><?php esc_html_e( 'Pilotage, qualité, offre, commercialisation, équipes et approvisionnement — portés par le gestionnaire.', 'cbs-theme' ); ?></p>
		</header>
		<div class="offre-phases__grid">
			<?php
			$mg_i = 0;
			foreach ( $miss_g as $line ) :
				++$mg_i;
				$ik  = $icons_missions_g[ $mg_i - 1 ] ?? 'helm';
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

<section class="cbs-section methode-niveaux" aria-labelledby="gestion-p-me-heading">
	<div class="cbs-container offre-phases__inner">
		<h2 id="gestion-p-me-heading" class="offre-detail__h2"><?php echo esc_html( $h['etab'] ); ?></h2>
		<div class="offre-phases__grid">
			<?php
			$mh_i = 0;
			foreach ( $miss_h as $line ) :
				++$mh_i;
				$num_h = sprintf(
					/* translators: %s: index zero-padded (e.g. 01). */
					__( 'Mission %s', 'cbs-theme' ),
					sprintf( '%02d', $mh_i )
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

<section class="cbs-section offre-gestion-ca" aria-labelledby="gestion-p-ca-heading">
	<div class="cbs-container">
		<div class="offre-gestion__ca-panel">
			<h2 id="gestion-p-ca-heading" class="offre-detail__h2"><?php echo esc_html( cbs_gestion_partielle_table_caption() ); ?></h2>
			<div class="offre-gestion__table-wrap">
				<table class="offre-gestion__table">
					<thead>
						<tr>
							<th scope="col"><?php esc_html_e( 'Poste', 'cbs-theme' ); ?></th>
							<th scope="col"><?php esc_html_e( 'Répartition', 'cbs-theme' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $ca_rows as $row ) : ?>
							<tr>
								<th scope="row"><?php echo esc_html( $row['poste'] ); ?></th>
								<td><?php echo esc_html( $row['detail'] ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<p class="offre-gestion__note-rdv"><?php echo esc_html( $note ); ?></p>
		</div>
	</div>
</section>

<section class="cbs-section cta-rdv offre-gestion-final-cta" aria-labelledby="gestion-p-cta-heading">
	<div class="cbs-container cta-rdv__inner">
		<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $cta_label ); ?></a>
	</div>
</section>
