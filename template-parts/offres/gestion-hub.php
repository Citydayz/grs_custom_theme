<?php
/**
 * CBS Theme — Hub Pôle Gestion (content-structure.md §4).
 */
defined( 'ABSPATH' ) || exit;

while ( have_posts() ) {
	the_post();
}

$pid = (int) get_the_ID();
$d   = cbs_gestion_hub_defaults();

$hero_kicker   = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_hero_kicker', $pid ), $d['hero_kicker'] ) : $d['hero_kicker'];
$hero_title    = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_hero_title', $pid ), $d['hero_title'] ) : $d['hero_title'];
$hero_subtitle = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_hero_subtitle', $pid ), $d['hero_subtitle'] ) : $d['hero_subtitle'];
$badge         = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_badge', $pid ), $d['badge'] ) : $d['badge'];
$cta_p         = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_cta_partielle', $pid ), $d['cta_partielle'] ) : $d['cta_partielle'];
$cta_c         = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_cta_complete', $pid ), $d['cta_complete'] ) : $d['cta_complete'];
$lnk_s         = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_link_staffing', $pid ), $d['link_staffing'] ) : $d['link_staffing'];
$lnk_m         = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_link_massages', $pid ), $d['link_massages'] ) : $d['link_massages'];
$si_p          = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_card_partielle_si', $pid ), $d['card_partielle_si'] ) : $d['card_partielle_si'];
$si_c          = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_card_complete_si', $pid ), $d['card_complete_si'] ) : $d['card_complete_si'];
$si_s          = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_link_staffing_si', $pid ), $d['link_staffing_si'] ) : $d['link_staffing_si'];
$si_m          = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_link_massages_si', $pid ), $d['link_massages_si'] ) : $d['link_massages_si'];
$complement    = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_complement', $pid ), $d['complement'] ) : $d['complement'];
$cta_t         = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_cta_title', $pid ), $d['cta_final_title'] ) : $d['cta_final_title'];
$cta_x         = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_cta_text', $pid ), $d['cta_final_text'] ) : $d['cta_final_text'];
$cta_b         = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_gestion_hub_cta_btn', $pid ), $d['cta_final_btn'] ) : $d['cta_final_btn'];

$hub_profiles = cbs_gestion_hub_profiles_default();
$hub_missions = cbs_gestion_hub_missions_default();
$hub_stats    = cbs_gestion_hub_stats_resolved( $pid );
$hub_seo      = cbs_gestion_hub_seo_text_default();
$hub_split_img = cbs_gestion_hub_split_image_resolved( $pid );
if ( function_exists( 'get_field' ) ) {
	$hub_profiles = cbs_gestion_hub_profiles_resolved( get_field( 'cbs_gestion_hub_profiles', $pid ), $hub_profiles );
	$hub_missions = cbs_gestion_hub_missions_resolved( get_field( 'cbs_gestion_hub_missions', $pid ), $hub_missions );
	$hub_seo      = cbs_offres_scalar( get_field( 'cbs_gestion_hub_seo_text', $pid ), $hub_seo );
}

$url_p = home_url( '/gestion-partielle/' );
$url_c = home_url( '/gestion-complete/' );

$hero_bg = '';
if ( has_post_thumbnail() ) {
	$thumb_url = get_the_post_thumbnail_url( null, 'full' );
	if ( is_string( $thumb_url ) && $thumb_url !== '' ) {
		$hero_bg = ' style="background-image: url(\'' . esc_url( $thumb_url ) . '\');"';
	}
}
?>
<section class="methode-spa-hero offre-gestion-hero cbs-section" aria-labelledby="gestion-hub-hero-heading"<?php echo $hero_bg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with esc_url(). ?>>
	<div class="methode-spa-hero__inner cbs-container">
		<p class="methode-spa-hero__kicker"><?php echo esc_html( $hero_kicker ); ?></p>
		<h1 id="gestion-hub-hero-heading" class="methode-spa-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="methode-spa-hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
		<p class="offre-gestion__badge offre-gestion__badge--hero" role="status"><?php echo esc_html( $badge ); ?></p>
	</div>
</section>

<section class="cbs-section offre-gestion-ctas" aria-labelledby="gestion-hub-ctas-heading">
	<div class="cbs-container">
		<h2 id="gestion-hub-ctas-heading" class="screen-reader-text"><?php esc_html_e( 'Choix du modèle de gestion', 'cbs-theme' ); ?></h2>
		<div class="offre-gestion__cta-grid">
			<a class="offre-gestion__cta-card" href="<?php echo esc_url( $url_p ); ?>">
				<span class="offre-gestion__cta-card-top">
					<span class="offre-gestion__cta-card-label"><?php echo esc_html( $cta_p ); ?></span>
					<span class="offre-gestion__cta-card-arrow" aria-hidden="true">→</span>
				</span>
				<?php if ( trim( $si_p ) !== '' ) : ?>
					<span class="offre-gestion__cta-card-si"><?php echo esc_html( sprintf( __( 'Ce modèle est fait pour vous si… %s', 'cbs-theme' ), $si_p ) ); ?></span>
				<?php endif; ?>
			</a>
			<a class="offre-gestion__cta-card" href="<?php echo esc_url( $url_c ); ?>">
				<span class="offre-gestion__cta-card-top">
					<span class="offre-gestion__cta-card-label"><?php echo esc_html( $cta_c ); ?></span>
					<span class="offre-gestion__cta-card-arrow" aria-hidden="true">→</span>
				</span>
				<?php if ( trim( $si_c ) !== '' ) : ?>
					<span class="offre-gestion__cta-card-si"><?php echo esc_html( sprintf( __( 'Ce modèle est fait pour vous si… %s', 'cbs-theme' ), $si_c ) ); ?></span>
				<?php endif; ?>
			</a>
		</div>
	</div>
</section>

<section class="cbs-section offre-gestion-hub-profiles" aria-labelledby="gestion-hub-profiles-heading">
	<div class="cbs-container">
		<h2 id="gestion-hub-profiles-heading" class="offre-detail__h2"><?php esc_html_e( 'À qui s\'adresse ce pôle ?', 'cbs-theme' ); ?></h2>
		<div class="offre-gestion-hub-profiles__grid">
			<?php foreach ( $hub_profiles as $prof ) : ?>
				<article class="offre-gestion-hub-profiles__card">
					<h3 class="offre-gestion-hub-profiles__card-title"><?php echo esc_html( $prof['titre'] ); ?></h3>
					<p class="offre-gestion-hub-profiles__card-text"><?php echo esc_html( $prof['texte'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="cbs-section offre-gestion-hub-seo offre-gestion-hub-seo--split" aria-labelledby="gestion-hub-seo-heading">
	<div class="cbs-container">
		<div class="offre-gestion-hub-seo__split">
			<div class="offre-gestion-hub-seo__media">
				<img
					class="offre-gestion-hub-seo__img"
					src="<?php echo esc_url( $hub_split_img ); ?>"
					alt="<?php echo esc_attr__( 'Soin spa en cabine', 'cbs-theme' ); ?>"
					width="600"
					height="800"
					loading="lazy"
					decoding="async"
				/>
			</div>
			<div class="offre-gestion-hub-seo__content">
				<h2 id="gestion-hub-seo-heading" class="offre-detail__h2 offre-gestion-hub-seo__title"><?php esc_html_e( 'Un exploitant spa hôtelier à vos côtés, de l\'ouverture au quotidien', 'cbs-theme' ); ?></h2>
				<div class="offre-gestion-hub-seo__text">
					<?php echo wp_kses_post( wpautop( $hub_seo ) ); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="cbs-section offre-gestion-hub-missions" aria-labelledby="gestion-hub-missions-heading">
	<div class="cbs-container">
		<h2 id="gestion-hub-missions-heading" class="offre-detail__h2"><?php esc_html_e( 'Ce que nous prenons en charge', 'cbs-theme' ); ?></h2>
		<div class="offre-gestion-hub-missions__grid">
			<?php foreach ( $hub_missions as $mi => $miss ) : ?>
				<div class="offre-gestion-hub-mission">
					<span class="offre-gestion-hub-mission__icon" aria-hidden="true">
						<?php echo cbs_gestion_icon_svg( cbs_gestion_hub_mission_icon_key( (int) $mi ) ); ?>
					</span>
					<h3 class="offre-gestion-hub-mission__title"><?php echo esc_html( $miss['titre'] ); ?></h3>
					<p class="offre-gestion-hub-mission__text"><?php echo esc_html( $miss['texte'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="cbs-section offre-gestion-hub-stats" aria-labelledby="gestion-hub-stats-heading">
	<div class="cbs-container">
		<h2 id="gestion-hub-stats-heading" class="screen-reader-text"><?php esc_html_e( 'Chiffres clés', 'cbs-theme' ); ?></h2>
		<ul class="offre-gestion-hub-stats__list" role="list">
			<?php foreach ( $hub_stats as $st ) : ?>
				<li class="offre-gestion-hub-stats__item">
					<p class="offre-gestion-hub-stats__value"><?php echo esc_html( $st['value'] ); ?></p>
					<p class="offre-gestion-hub-stats__label"><?php echo esc_html( $st['label'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="cbs-section offre-gestion-liens" aria-labelledby="gestion-hub-liens-heading">
	<div class="cbs-container offre-gestion-liens__inner">
		<h2 id="gestion-hub-liens-heading" class="offre-detail__h2"><?php esc_html_e( 'Autres offres du pôle', 'cbs-theme' ); ?></h2>
		<ul class="offre-gestion__link-list">
			<li>
				<a class="offre-gestion__text-link" href="<?php echo esc_url( home_url( '/staffing-spa/' ) ); ?>"><?php echo esc_html( $lnk_s ); ?></a>
				<?php if ( trim( $si_s ) !== '' ) : ?>
					<p class="offre-gestion__link-si"><?php echo esc_html( sprintf( __( 'Ce modèle est fait pour vous si… %s', 'cbs-theme' ), $si_s ) ); ?></p>
				<?php endif; ?>
			</li>
			<li>
				<a class="offre-gestion__text-link" href="<?php echo esc_url( home_url( '/massages-en-chambre-hotel/' ) ); ?>"><?php echo esc_html( $lnk_m ); ?></a>
				<?php if ( trim( $si_m ) !== '' ) : ?>
					<p class="offre-gestion__link-si"><?php echo esc_html( sprintf( __( 'Ce modèle est fait pour vous si… %s', 'cbs-theme' ), $si_m ) ); ?></p>
				<?php endif; ?>
			</li>
		</ul>
		<?php if ( trim( $complement ) !== '' ) : ?>
			<p class="offre-gestion__complement"><?php echo esc_html( $complement ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="cbs-section cta-rdv offre-gestion-final-cta" aria-labelledby="gestion-hub-final-cta-heading">
	<div class="cbs-container cta-rdv__inner">
		<h2 id="gestion-hub-final-cta-heading" class="cta-rdv__title"><?php echo esc_html( $cta_t ); ?></h2>
		<p class="cta-rdv__text"><?php echo esc_html( $cta_x ); ?></p>
		<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $cta_b ); ?></a>
	</div>
</section>
