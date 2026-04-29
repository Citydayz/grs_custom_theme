<?php
/**
 * CBS Theme — Hub « La Méthode Spa Profit™ » (content-structure.md §3).
 */
defined( 'ABSPATH' ) || exit;

while ( have_posts() ) {
	the_post();
}

$pid = (int) get_the_ID();
$d   = cbs_offres_methode_hub_defaults();

$hero_kicker    = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_hub_hero_kicker', $pid ), $d['hero_kicker'] ) : $d['hero_kicker'];
$hero_title     = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_hub_hero_title', $pid ), $d['hero_title'] ) : $d['hero_title'];
$hero_subtitle  = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_hub_hero_subtitle', $pid ), $d['hero_subtitle'] ) : $d['hero_subtitle'];
$hero_cta       = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_hub_hero_cta_label', $pid ), $d['hero_cta_label'] ) : $d['hero_cta_label'];
$cta_t          = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_hub_cta_title', $pid ), $d['cta_final_title'] ) : $d['cta_final_title'];
$cta_x          = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_hub_cta_text', $pid ), $d['cta_final_text'] ) : $d['cta_final_text'];
$cta_b          = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_hub_cta_btn', $pid ), $d['cta_final_btn'] ) : $d['cta_final_btn'];

$hero_bg_url = '';
if ( function_exists( 'get_field' ) ) {
	$bg_raw = get_field( 'cbs_methode_hero_bg', $pid );
	if ( is_string( $bg_raw ) && trim( $bg_raw ) !== '' ) {
		$hero_bg_url = esc_url( $bg_raw );
	}
}

$cards_rows = function_exists( 'get_field' ) ? get_field( 'cbs_offres_hub_niveaux', $pid ) : null;
$cards      = cbs_offres_hub_cards_resolved( $cards_rows, $d['niveaux_cards'] );

$bento_defaults = cbs_offres_methode_hub_bento_defaults();
$bento_rows     = function_exists( 'get_field' ) ? get_field( 'cbs_methode_hub_bento', $pid ) : null;
$bento_items    = cbs_offres_methode_hub_bento_resolved( $bento_rows, $bento_defaults );

$moa_d       = cbs_offres_methode_hub_moa_defaults();
$moa_title   = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_methode_hub_moa_title', $pid ), $moa_d['title'] ) : $moa_d['title'];
$moa_acf_txt = function_exists( 'get_field' ) ? get_field( 'cbs_methode_hub_moa_text', $pid ) : '';
$moa_text    = ( is_string( $moa_acf_txt ) && trim( $moa_acf_txt ) !== '' ) ? $moa_acf_txt : $moa_d['text'];
$moa_quote   = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_methode_hub_moa_quote', $pid ), $moa_d['quote'] ) : $moa_d['quote'];
$moa_raw_1   = function_exists( 'get_field' ) ? get_field( 'cbs_methode_hub_moa_img_1', $pid ) : null;
$moa_raw_2   = function_exists( 'get_field' ) ? get_field( 'cbs_methode_hub_moa_img_2', $pid ) : null;
$moa_img_1   = cbs_offres_acf_image_url( $moa_raw_1, $moa_d['img_1'] );
$moa_img_2   = cbs_offres_acf_image_url( $moa_raw_2, $moa_d['img_2'] );

$hero_section_class = 'methode-spa-hero cbs-section';
$hero_section_attr  = '';
if ( $hero_bg_url !== '' ) {
	$hero_section_class .= ' methode-spa-hero--photo-bg';
	$hero_section_attr   = sprintf(
		' style="background-image: url(%s); background-size: cover; background-position: center;"',
		esc_attr( $hero_bg_url )
	);
}
?>
<div class="methode-hub-page">
<section class="<?php echo esc_attr( $hero_section_class ); ?>" aria-labelledby="methode-hero-heading"<?php echo $hero_section_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with esc_attr for URL. ?>>
	<div class="methode-spa-hero__inner cbs-container">
		<p class="methode-spa-hero__kicker"><?php echo esc_html( $hero_kicker ); ?></p>
		<h1 id="methode-hero-heading" class="methode-spa-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="methode-spa-hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
		<a class="btn-primary methode-spa-hero__cta" href="#methode-niveaux"><?php echo esc_html( $hero_cta ); ?></a>
	</div>
</section>

<section class="cbs-section methode-credibilite" aria-label="<?php echo esc_attr__( 'Crédibilité', 'cbs-theme' ); ?>">
	<div class="cbs-container methode-credibilite__inner">
		<p class="methode-credibilite__line">
			<?php esc_html_e( '13 ans d\'expérience', 'cbs-theme' ); ?>
			<span class="methode-credibilite__sep" aria-hidden="true">·</span>
			<?php esc_html_e( '+13 projets spa hôteliers accompagnés', 'cbs-theme' ); ?>
			<span class="methode-credibilite__sep" aria-hidden="true">·</span>
			<?php esc_html_e( 'Hôtels 4★ et 5★ en France', 'cbs-theme' ); ?>
		</p>
	</div>
</section>

<section class="cbs-section methode-methode-temps" aria-labelledby="methode-methode-temps-heading">
	<div class="cbs-container">
		<h2 id="methode-methode-temps-heading" class="methode-methode-temps__title"><?php esc_html_e( 'Une approche structurée, du projet à la performance', 'cbs-theme' ); ?></h2>
		<div class="methode-methode-temps__grid">
			<div class="methode-methode-temps__col">
				<span class="methode-methode-temps__icon" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
				</span>
				<p class="methode-methode-temps__label"><?php esc_html_e( '01 — ANALYSER', 'cbs-theme' ); ?></p>
				<h3 class="methode-methode-temps__titre"><?php esc_html_e( 'Analyser', 'cbs-theme' ); ?></h3>
				<p class="methode-methode-temps__text"><?php esc_html_e( 'Audit du potentiel, identification des risques, cadrage stratégique', 'cbs-theme' ); ?></p>
			</div>
			<div class="methode-methode-temps__col">
				<span class="methode-methode-temps__icon" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
				</span>
				<p class="methode-methode-temps__label"><?php esc_html_e( '02 — CONCEVOIR', 'cbs-theme' ); ?></p>
				<h3 class="methode-methode-temps__titre"><?php esc_html_e( 'Concevoir', 'cbs-theme' ); ?></h3>
				<p class="methode-methode-temps__text"><?php esc_html_e( 'Co-construction du projet avec les équipes techniques et hôtelières', 'cbs-theme' ); ?></p>
			</div>
			<div class="methode-methode-temps__col">
				<span class="methode-methode-temps__icon" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M3 3v18h18"/><path d="M7 16v-4"/><path d="M12 16V8"/><path d="M17 16v-9"/></svg>
				</span>
				<p class="methode-methode-temps__label"><?php esc_html_e( '03 — PERFORMER', 'cbs-theme' ); ?></p>
				<h3 class="methode-methode-temps__titre"><?php esc_html_e( 'Performer', 'cbs-theme' ); ?></h3>
				<p class="methode-methode-temps__text"><?php esc_html_e( 'Mise en exploitation, formation, suivi de la rentabilité', 'cbs-theme' ); ?></p>
			</div>
		</div>
	</div>
</section>

<section id="methode-niveaux" class="cbs-section methode-niveaux methode-niveaux--dark" aria-labelledby="methode-niveaux-heading">
	<div class="cbs-container">
		<h2 id="methode-niveaux-heading" class="methode-niveaux__title"><?php esc_html_e( "Les 3 niveaux d'accompagnement", 'cbs-theme' ); ?></h2>
		<div class="methode-niveaux__grid">
			<?php foreach ( $cards as $idx => $card ) : ?>
				<?php
				$is_featured = ( 1 === (int) $idx );
				$card_class  = 'methode-niveau-card' . ( $is_featured ? ' methode-niveau-card--featured' : '' );
				$num         = str_pad( (string) ( $idx + 1 ), 2, '0', STR_PAD_LEFT );
				$kicker_raw  = isset( $card['kicker'] ) ? (string) $card['kicker'] : '';
				$badge_text  = trim( $kicker_raw );
				if ( preg_match( '/·\s*(.+)$/u', $badge_text, $m ) ) {
					$badge_text = trim( $m[1] );
				}
				$obtenez = isset( $card['obtenez'] ) ? trim( (string) $card['obtenez'] ) : '';
				?>
				<div class="<?php echo esc_attr( $card_class ); ?>">
					<div class="methode-niveau-card__number"><?php echo esc_html( $num ); ?></div>
					<?php if ( $badge_text !== '' ) : ?>
						<div class="methode-niveau-card__badge"><?php echo esc_html( $badge_text ); ?></div>
					<?php endif; ?>
					<h3 class="methode-niveau-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
					<div class="methode-niveau-card__duration"><?php echo esc_html( $card['duration'] ); ?></div>
					<div class="methode-niveau-card__sep" aria-hidden="true"></div>
					<p class="methode-niveau-card__objective"><?php echo esc_html( $card['objective'] ); ?></p>
					<?php if ( $obtenez !== '' ) : ?>
						<div class="methode-niveau-card__obtiens-label"><?php esc_html_e( 'Ce que vous obtenez', 'cbs-theme' ); ?></div>
						<p class="methode-niveau-card__obtiens-text"><?php echo esc_html( $obtenez ); ?></p>
					<?php endif; ?>
					<a href="<?php echo esc_url( $card['url'] ); ?>" class="methode-niveau-card__cta"><?php esc_html_e( 'Découvrir', 'cbs-theme' ); ?></a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="cbs-section methode-hub-bento" aria-labelledby="methode-hub-bento-heading">
	<div class="cbs-container">
		<h2 id="methode-hub-bento-heading" class="methode-hub-bento__title"><?php esc_html_e( 'À qui s\'adresse cette méthode ?', 'cbs-theme' ); ?></h2>
		<div class="methode-hub-bento__grid">
			<?php foreach ( $bento_items as $bi => $cell ) : ?>
				<?php
				$cell_class = ( 0 === (int) $bi ) ? 'methode-hub-bento__cell methode-hub-bento__cell--large' : 'methode-hub-bento__cell methode-hub-bento__cell--small';
				$img_alt    = $cell['titre'] !== '' ? $cell['titre'] : __( 'Illustration', 'cbs-theme' );
				?>
				<article class="<?php echo esc_attr( $cell_class ); ?>">
					<div class="methode-hub-bento__visual">
						<img
							class="methode-hub-bento__img"
							src="<?php echo esc_url( $cell['image'] ); ?>"
							alt="<?php echo esc_attr( $img_alt ); ?>"
							width="800"
							height="533"
							loading="lazy"
							decoding="async"
						/>
						<div class="methode-hub-bento__overlay" aria-hidden="true"></div>
						<div class="methode-hub-bento__caption">
							<?php if ( $cell['badge'] !== '' ) : ?>
								<span class="methode-hub-bento__badge"><?php echo esc_html( $cell['badge'] ); ?></span>
							<?php endif; ?>
							<?php if ( $cell['titre'] !== '' ) : ?>
								<p class="methode-hub-bento__img-title"><?php echo esc_html( $cell['titre'] ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="cbs-section methode-hub-moa" aria-labelledby="methode-hub-moa-heading">
	<div class="cbs-container methode-hub-moa__split">
		<div class="methode-hub-moa__content">
			<p class="methode-hub-moa__kicker"><?php esc_html_e( 'ASSISTANCE À MAÎTRISE D\'OUVRAGE', 'cbs-theme' ); ?></p>
			<h2 id="methode-hub-moa-heading" class="methode-hub-moa__title"><?php echo esc_html( $moa_title ); ?></h2>
			<div class="methode-hub-moa__text">
				<?php echo wp_kses_post( wpautop( $moa_text ) ); ?>
			</div>
		</div>
		<div class="methode-hub-moa__media">
			<div class="methode-hub-moa__stack">
				<div class="methode-hub-moa__frame methode-hub-moa__frame--primary">
					<img
						class="methode-hub-moa__img"
						src="<?php echo esc_url( $moa_img_1 ); ?>"
						alt="<?php echo esc_attr__( 'Espace spa hôtelier, vue d\'ambiance', 'cbs-theme' ); ?>"
						width="500"
						height="375"
						loading="lazy"
						decoding="async"
					/>
				</div>
				<div class="methode-hub-moa__frame methode-hub-moa__frame--offset">
					<img
						class="methode-hub-moa__img"
						src="<?php echo esc_url( $moa_img_2 ); ?>"
						alt="<?php echo esc_attr__( 'Cabine de soins, détail architectural', 'cbs-theme' ); ?>"
						width="500"
						height="375"
						loading="lazy"
						decoding="async"
					/>
				</div>
			</div>
			<?php if ( trim( $moa_quote ) !== '' ) : ?>
				<blockquote class="methode-hub-moa__quote">
					<p><?php echo esc_html( $moa_quote ); ?></p>
				</blockquote>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="methode-testimonial" aria-labelledby="methode-testimonial-heading">
	<!-- TODO : remplacer par témoignage client validé avant staging -->
	<h2 id="methode-testimonial-heading" class="screen-reader-text"><?php esc_html_e( 'Témoignage', 'cbs-theme' ); ?></h2>
	<div class="methode-testimonial__inner">
		<span class="methode-testimonial__guillemets" aria-hidden="true">&ldquo;</span>
		<blockquote class="methode-testimonial__citation">
			<?php esc_html_e( 'L\'intervention de Camille en amont de nos travaux nous a permis d\'éviter des erreurs de conception majeures. Notre spa est rentable dès le quatrième mois d\'exploitation.', 'cbs-theme' ); ?>
		</blockquote>
		<p class="methode-testimonial__auteur"><?php esc_html_e( '— Directeur général, Hôtel 4★, Alsace', 'cbs-theme' ); ?></p>
	</div>
</section>

<section class="cbs-section cta-rdv methode-hub-cta" aria-labelledby="methode-hub-cta-heading">
	<div class="cbs-container cta-rdv__inner">
		<h2 id="methode-hub-cta-heading" class="cta-rdv__title"><?php echo esc_html( $cta_t ); ?></h2>
		<p class="cta-rdv__text"><?php echo esc_html( $cta_x ); ?></p>
		<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $cta_b ); ?></a>
	</div>
</section>
</div>
