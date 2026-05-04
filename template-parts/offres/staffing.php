<?php
/**
 * CBS Theme — Staffing & Renfort d'équipe (content-structure.md §5).
 */
defined( 'ABSPATH' ) || exit;

while ( have_posts() ) {
	the_post();
}

$pid = (int) get_the_ID();
$d   = cbs_gestion_staffing_defaults();
$h   = cbs_gestion_staffing_missions_headings();

$hero_title    = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_s_hero_title', $pid ), $d['hero_title'] ) : $d['hero_title'];
$hero_subtitle = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_s_hero_subtitle', $pid ), $d['hero_subtitle'] ) : $d['hero_subtitle'];
$badge         = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_s_badge', $pid ), $d['badge'] ) : $d['badge'];
$pos_acf       = function_exists( 'get_field' ) ? get_field( 'cbs_gestion_s_position', $pid ) : '';
$modele_intro  = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_s_modele_intro', $pid ), $d['modele_label'] ) : $d['modele_label'];
$modele_h2     = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_s_modele_h2', $pid ), $d['modele_h2'] ) : $d['modele_h2'];
$cta_label     = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_s_cta_label', $pid ), $d['cta_label'] ) : $d['cta_label'];

$modele_vous_txt = isset( $d['modele_vous_gardez_text'] ) ? (string) $d['modele_vous_gardez_text'] : '';

$pos_img_raw = function_exists( 'get_field' ) ? get_field( 'cbs_staffing_positionnement_image', $pid ) : null;
$pos_img_url = function_exists( 'cbs_offres_acf_image_url' )
	? cbs_offres_acf_image_url( $pos_img_raw, $d['positionnement_image_fallback'] ?? '' )
	: (string) ( $d['positionnement_image_fallback'] ?? '' );

$seo_img_raw = function_exists( 'get_field' ) ? get_field( 'cbs_staffing_seo_image', $pid ) : null;
$seo_txt_raw = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_staffing_seo_text', $pid ), '' ) : '';
$seo_img_url = function_exists( 'cbs_offres_acf_image_url' )
	? cbs_offres_acf_image_url( $seo_img_raw, $d['seo_staffing_image_fallback'] ?? '' )
	: (string) ( $d['seo_staffing_image_fallback'] ?? '' );
$seo_body    = ( $seo_txt_raw !== '' ) ? $seo_txt_raw : (string) ( $d['seo_staffing_body_fallback'] ?? '' );
$seo_heading = isset( $d['seo_staffing_h2_fallback'] ) ? (string) $d['seo_staffing_h2_fallback'] : __( 'Staffing spa hôtelier en Alsace', 'cbs-theme' );

$modele_lignes = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_gestion_s_modele_lignes', $pid ), cbs_gestion_staffing_modele_lignes_default() )
	: cbs_gestion_staffing_modele_lignes_default();
$miss_g        = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_gestion_s_missions_g', $pid ), cbs_gestion_staffing_missions_gestionnaire_default() )
	: cbs_gestion_staffing_missions_gestionnaire_default();
$miss_h        = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_gestion_s_missions_h', $pid ), cbs_gestion_staffing_missions_etab_default() )
	: cbs_gestion_staffing_missions_etab_default();

$icons_staff_g = array( 'star', 'team', 'calendar', 'team', 'lightbulb', 'activity' );

$position_alt = __( 'Professionnel spa en cabine, positionnement staffing', 'cbs-theme' );

$hero_bg = '';
if ( has_post_thumbnail() ) {
	$thumb_url = get_the_post_thumbnail_url( null, 'full' );
	if ( is_string( $thumb_url ) && $thumb_url !== '' ) {
		$hero_bg = ' style="background-image: url(\'' . esc_url( $thumb_url ) . '\');"';
	}
}
?>
<section class="methode-spa-hero offre-gestion-hero cbs-section" aria-labelledby="staffing-hero-heading"<?php echo $hero_bg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with esc_url(). ?>>
	<div class="methode-spa-hero__inner cbs-container">
		<h1 id="staffing-hero-heading" class="methode-spa-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="methode-spa-hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
		<p class="offre-gestion__badge offre-gestion__badge--hero" role="status"><?php echo esc_html( $badge ); ?></p>
	</div>
</section>

<section class="cbs-section offre-gestion-position-split" aria-labelledby="staffing-position-heading">
	<div class="cbs-container offre-gestion-position-split__grid">
		<div class="offre-gestion-position-split__media offre-gestion-position-split__image">
			<img
				class="offre-gestion-position-split__img"
				src="<?php echo esc_url( $pos_img_url ); ?>"
				alt="<?php echo esc_attr( $position_alt ); ?>"
				width="800"
				height="600"
				decoding="async"
				loading="lazy"
			>
		</div>
		<div class="offre-gestion-position-split__body">
			<h2 id="staffing-position-heading" class="offre-detail__h2"><?php esc_html_e( 'Positionnement', 'cbs-theme' ); ?></h2>
			<div class="offre-gestion__position-text offre-gestion-position-split__text">
				<?php
				if ( is_string( $pos_acf ) && trim( $pos_acf ) !== '' ) {
					echo wp_kses_post( $pos_acf );
				} else {
					echo wp_kses_post( wpautop( $d['position'] ) );
				}
				?>
			</div>
		</div>
	</div>
</section>

<section class="cbs-section offre-gestion-staff-modele" style="background-color: var(--cbs-silver-50);" aria-labelledby="staffing-modele-heading">
	<div class="cbs-container offre-gestion-staff-modele__inner">
		<h2 id="staffing-modele-heading" class="offre-gestion-staff-modele__h2"><?php echo esc_html( $modele_h2 ); ?></h2>
		<p class="offre-gestion-staff-modele__intro"><?php echo esc_html( $modele_intro ); ?></p>
		<div class="offre-gestion-staff-modele__cards">
			<article class="offre-gestion-staff-modele__card">
				<h3 class="offre-gestion-staff-modele__card-title"><?php esc_html_e( 'Ce que Gestion des Rituels du Spa gère', 'cbs-theme' ); ?></h3>
				<ul class="offre-gestion-staff-modele__list">
					<?php foreach ( $modele_lignes as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</article>
			<article class="offre-gestion-staff-modele__card">
				<h3 class="offre-gestion-staff-modele__card-title"><?php esc_html_e( 'Ce que vous gardez', 'cbs-theme' ); ?></h3>
				<p class="offre-gestion-staff-modele__card-text"><?php echo esc_html( $modele_vous_txt ); ?></p>
			</article>
		</div>
	</div>
</section>

<section class="offre-phases" aria-labelledby="staffing-mg-heading">
	<div class="offre-phases__inner">
		<header class="offre-phases__header">
			<h2 id="staffing-mg-heading" class="offre-phases__title"><?php echo esc_html( $h['gest'] ); ?></h2>
			<p class="offre-phases__lead"><?php esc_html_e( 'Renfort opérationnel et encadrement des intervenants.', 'cbs-theme' ); ?></p>
		</header>
		<div class="offre-phases__grid">
			<?php
			$sg_i = 0;
			foreach ( $miss_g as $line ) :
				++$sg_i;
				$ik  = $icons_staff_g[ $sg_i - 1 ] ?? 'star';
				$num = sprintf(
					/* translators: %s: index zero-padded (e.g. 01). */
					__( 'Mission %s', 'cbs-theme' ),
					sprintf( '%02d', $sg_i )
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

<section class="cbs-section methode-niveaux methode-niveaux--light" aria-labelledby="staffing-mh-heading">
	<div class="cbs-container offre-phases__inner">
		<h2 id="staffing-mh-heading" class="offre-detail__h2"><?php echo esc_html( $h['etab'] ); ?></h2>
		<div class="offre-phases__grid">
			<?php
			$sh_i = 0;
			foreach ( $miss_h as $line ) :
				++$sh_i;
				$num_h = sprintf(
					/* translators: %s: index zero-padded (e.g. 01). */
					__( 'Mission %s', 'cbs-theme' ),
					sprintf( '%02d', $sh_i )
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

<section class="cbs-section offre-gestion-staff-seo" aria-labelledby="staffing-seo-heading">
	<div class="cbs-container offre-gestion-staff-seo__split">
		<div class="offre-gestion-staff-seo__content">
			<h2 id="staffing-seo-heading" class="offre-detail__h2"><?php echo esc_html( $seo_heading ); ?></h2>
			<div class="offre-gestion-staff-seo__body">
				<?php echo wp_kses_post( wpautop( $seo_body ) ); ?>
			</div>
		</div>
		<div class="offre-gestion-staff-seo__media" role="presentation" aria-hidden="true">
			<img
				class="offre-gestion-staff-seo__img"
				src="<?php echo esc_url( $seo_img_url ); ?>"
				alt=""
				width="800"
				height="600"
				decoding="async"
				loading="lazy"
			>
		</div>
	</div>
</section>

<section class="cbs-section cta-rdv offre-gestion-final-cta" aria-labelledby="staffing-cta-heading">
	<div class="cbs-container cta-rdv__inner">
		<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $cta_label ); ?></a>
	</div>
</section>
