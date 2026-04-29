<?php
/**
 * CBS Theme — Niveau 3 Mise en performance du spa (content-structure.md §3).
 */
defined( 'ABSPATH' ) || exit;

while ( have_posts() ) {
	the_post();
}

$pid  = (int) get_the_ID();
$d    = cbs_offres_niveau_3_defaults();
$bloc = cbs_offres_niveau_3_blocs_defaults();

$hero_kicker   = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n3_hero_kicker', $pid ), $d['hero_kicker'] ) : $d['hero_kicker'];
$hero_title    = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n3_hero_title', $pid ), $d['hero_title'] ) : $d['hero_title'];
$hero_subtitle = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n3_hero_subtitle', $pid ), $d['hero_subtitle'] ) : $d['hero_subtitle'];

$rows  = function_exists( 'get_field' ) ? get_field( 'cbs_offres_n3_blocs', $pid ) : null;
$blocs = cbs_offres_n3_blocs_resolved( $rows, $bloc );

$cta_label = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n3_cta_label', $pid ), $d['cta_label'] ) : $d['cta_label'];
$contenu_lead = function_exists( 'get_field' )
	? cbs_offres_scalar( get_field( 'cbs_offres_n3_contenu_lead', $pid ), $d['contenu_lead'] )
	: $d['contenu_lead'];

$n3_bloc_svgs = array(
	1 => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3-1.9 5.8L4 11l5.8 1.9L12 19l1.9-5.8L20 11l-5.8-1.9L12 3z"/><path d="M5 3v4"/><path d="M19 17v4"/><path d="M3 5h4"/><path d="M17 19h4"/></svg>',
	2 => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg>',
	3 => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="3"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>',
	4 => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
	5 => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg>',
	6 => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>',
);
?>
<section class="methode-spa-hero methode-spa-hero--compact cbs-section" aria-labelledby="n3-hero-heading">
	<div class="methode-spa-hero__inner cbs-container">
		<p class="methode-spa-hero__kicker"><?php echo esc_html( $hero_kicker ); ?></p>
		<h1 id="n3-hero-heading" class="methode-spa-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="methode-spa-hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
	</div>
</section>

<section class="offre-phases" aria-labelledby="n3-contenu-heading">
	<div class="offre-phases__inner">
		<header class="offre-phases__header">
			<p class="offre-phases__kicker"><?php esc_html_e( 'Mise en performance', 'cbs-theme' ); ?></p>
			<h2 id="n3-contenu-heading" class="offre-phases__title"><?php esc_html_e( 'Contenu', 'cbs-theme' ); ?></h2>
			<p class="offre-phases__lead"><?php echo esc_html( $contenu_lead ); ?></p>
		</header>
		<div class="offre-phases__grid">
			<?php
			$bloc_idx = 0;
			foreach ( $blocs as $b ) :
				++$bloc_idx;
				$icon_svg = $n3_bloc_svgs[ $bloc_idx ] ?? $n3_bloc_svgs[1];
				$bloc_num = sprintf(
					/* translators: %s: bloc index zero-padded (e.g. 01). */
					__( 'Volet %s', 'cbs-theme' ),
					sprintf( '%02d', $bloc_idx )
				);
				?>
				<article class="phase-card">
					<div class="phase-card__icon"><?php echo $icon_svg; ?></div>
					<p class="phase-card__number"><?php echo esc_html( $bloc_num ); ?></p>
					<h3 class="phase-card__title"><?php echo esc_html( (string) ( $b['title'] ?? '' ) ); ?></h3>
					<?php
					$items = $b['items'] ?? array();
					if ( is_array( $items ) && $items !== array() ) :
						?>
						<ul class="phase-card__list">
							<?php foreach ( $items as $it ) : ?>
								<li><?php echo esc_html( (string) $it ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="cbs-section cta-rdv" aria-labelledby="n3-cta-heading">
	<div class="cbs-container cta-rdv__inner">
		<h2 id="n3-cta-heading" class="screen-reader-text"><?php esc_html_e( 'Étape suivante', 'cbs-theme' ); ?></h2>
		<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $cta_label ); ?></a>
	</div>
</section>
