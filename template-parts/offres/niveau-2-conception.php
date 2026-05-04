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

$split_d   = cbs_offres_niveau_2_split_defaults();
$split_img = function_exists( 'get_field' ) ? cbs_offres_acf_image_url( get_field( 'cbs_conception_split_image', $pid ), $split_d['image'] ) : $split_d['image'];
$split_txt = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_conception_split_text', $pid ), $split_d['text'] ) : $split_d['text'];
$split_ttl = $split_d['title'];

$prof_d   = cbs_offres_niveau_2_profiles_defaults();
$profiles = $prof_d;
if ( function_exists( 'get_field' ) ) {
	$raw_prof = get_field( 'cbs_conception_profiles', $pid );
	if ( is_array( $raw_prof ) && $raw_prof !== array() ) {
		$profiles = array();
		foreach ( $raw_prof as $i => $p ) {
			$profiles[] = array(
				'titre' => cbs_offres_scalar( $p['titre'] ?? '', $prof_d[$i]['titre'] ?? '' ),
				'texte' => cbs_offres_scalar( $p['texte'] ?? '', $prof_d[$i]['texte'] ?? '' ),
			);
		}
	}
}

$stats   = cbs_offres_niveau_2_stats_resolved( $pid );
$seo_d   = cbs_offres_niveau_2_seo_text_default();
$seo_txt = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_conception_seo_text_bottom', $pid ), $seo_d ) : $seo_d;
$seo_img_d = 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800&q=80';
$seo_img = function_exists( 'get_field' ) ? cbs_offres_acf_image_url( get_field( 'cbs_conception_seo_image', $pid ), $seo_img_d ) : $seo_img_d;

$options_cards = array();
foreach ( $options as $opt_idx => $opt_str ) {
	$parts = explode( ':', $opt_str, 2 );
	$options_cards[] = array(
		'num'   => sprintf( '%02d', $opt_idx + 1 ),
		'kicker'=> 'OPTION',
		'titre' => trim( $parts[0] ),
		'texte' => isset( $parts[1] ) ? trim( $parts[1] ) : '',
	);
}

$hero_bg = '';
if ( has_post_thumbnail() ) {
	$thumb_url = get_the_post_thumbnail_url( null, 'full' );
	if ( is_string( $thumb_url ) && $thumb_url !== '' ) {
		$hero_bg = ' style="background-image: url(\'' . esc_url( $thumb_url ) . '\');"';
	}
}
?>
<section class="methode-spa-hero methode-spa-hero--compact perf-hero cbs-section" aria-labelledby="n2-hero-heading"<?php echo $hero_bg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with esc_url(). ?>>
	<div class="methode-spa-hero__inner cbs-container">
		<p class="methode-spa-hero__kicker"><?php echo esc_html( $hero_kicker ); ?></p>
		<h1 id="n2-hero-heading" class="methode-spa-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="methode-spa-hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
	</div>
</section>

<section class="cbs-section methode-hub-moa" aria-labelledby="n2-split-heading">
	<div class="cbs-container methode-hub-moa__split perf-split">
		<div class="methode-hub-moa__media">
			<div class="methode-hub-moa__frame">
				<img class="methode-hub-moa__img" src="<?php echo esc_url( $split_img ); ?>" alt="" width="800" height="600" loading="lazy" decoding="async" />
			</div>
		</div>
		<div class="methode-hub-moa__content">
			<h2 id="n2-split-heading" class="methode-hub-moa__title"><?php echo esc_html( $split_ttl ); ?></h2>
			<div class="methode-hub-moa__text">
				<?php echo wp_kses_post( wpautop( $split_txt ) ); ?>
			</div>
		</div>
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

<section class="cbs-section methode-hub-bento" style="background-color: var(--cbs-white);" aria-labelledby="n2-profiles-heading">
	<div class="cbs-container">
		<h2 id="n2-profiles-heading" class="methode-hub-bento__title"><?php esc_html_e( 'Cette mission est faite pour vous si…', 'cbs-theme' ); ?></h2>
		<div class="perf-profiles-grid">
			<?php foreach ( $profiles as $prof ) : ?>
				<article class="perf-profile-card">
					<h3 class="perf-profile-card__title"><?php echo esc_html( $prof['titre'] ); ?></h3>
					<?php if ( $prof['texte'] !== '' ) : ?>
						<p class="perf-profile-card__text"><?php echo esc_html( $prof['texte'] ); ?></p>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="cbs-section offre-detail" style="background-color: var(--cbs-silver-900);" aria-labelledby="n2-options-heading">
	<div class="cbs-container">
		<h2 id="n2-options-heading" class="methode-hub-bento__title" style="margin-bottom: var(--cbs-space-8); color: var(--cbs-white);"><?php esc_html_e( 'Options tarifaires', 'cbs-theme' ); ?></h2>
		<div class="n2-options-grid">
			<?php foreach ( $options_cards as $card ) : ?>
				<article class="n2-option-card">
					<span class="n2-option-card__watermark" aria-hidden="true"><?php echo esc_html( $card['num'] ); ?></span>
					<p class="n2-option-card__kicker"><?php echo esc_html( $card['kicker'] ); ?></p>
					<h3 class="n2-option-card__title"><?php echo esc_html( $card['titre'] ); ?></h3>
					<?php if ( $card['texte'] !== '' ) : ?>
						<p class="n2-option-card__text"><?php echo esc_html( $card['texte'] ); ?></p>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="cbs-section perf-seo" aria-labelledby="n2-seo-heading">
	<div class="cbs-container perf-seo__inner">
		<div class="perf-seo__content">
			<h2 id="n2-seo-heading" class="methode-hub-moa__title"><?php esc_html_e( "Assistance à maîtrise d'ouvrage spa hôtelier", 'cbs-theme' ); ?></h2>
			<div class="methode-hub-moa__text">
				<?php echo wp_kses_post( wpautop( $seo_txt ) ); ?>
			</div>
		</div>
		<div class="perf-seo__media">
			<img class="perf-seo__img" src="<?php echo esc_url( $seo_img ); ?>" alt="" width="800" height="600" loading="lazy" decoding="async" />
		</div>
	</div>
</section>

<section class="cbs-section cta-rdv" aria-labelledby="n2-cta-heading">
	<div class="cbs-container cta-rdv__inner">
		<h2 id="n2-cta-heading" class="screen-reader-text"><?php esc_html_e( 'Étape suivante', 'cbs-theme' ); ?></h2>
		<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $cta_label ); ?></a>
	</div>
</section>
