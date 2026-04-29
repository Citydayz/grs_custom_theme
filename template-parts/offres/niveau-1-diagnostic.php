<?php
/**
 * CBS Theme — Niveau 1 Diagnostic stratégique spa (content-structure.md §3).
 */
defined( 'ABSPATH' ) || exit;

while ( have_posts() ) {
	the_post();
}

$pid = (int) get_the_ID();
$d   = cbs_offres_niveau_1_defaults();

$hero_kicker   = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n1_hero_kicker', $pid ), $d['hero_kicker'] ) : $d['hero_kicker'];
$hero_title    = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n1_hero_title', $pid ), $d['hero_title'] ) : $d['hero_title'];
$hero_subtitle = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n1_hero_subtitle', $pid ), $d['hero_subtitle'] ) : $d['hero_subtitle'];

$prestations = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_offres_n1_prestations', $pid ), $d['prestations'] )
	: $d['prestations'];
$livrables   = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_offres_n1_livrables', $pid ), $d['livrables'] )
	: $d['livrables'];

$resultat  = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n1_resultat', $pid ), $d['resultat'] ) : $d['resultat'];
$prestations_intro = function_exists( 'get_field' )
	? cbs_offres_scalar( get_field( 'cbs_offres_n1_prestations_intro', $pid ), $d['prestations_intro'] )
	: $d['prestations_intro'];
$pour_qui = function_exists( 'get_field' )
	? cbs_offres_repeater_lignes( get_field( 'cbs_offres_n1_pour_qui', $pid ), $d['pour_qui'] )
	: $d['pour_qui'];
$cta_label = function_exists( 'get_field' ) ? cbs_offres_scalar( get_field( 'cbs_offres_n1_cta_label', $pid ), $d['cta_label'] ) : $d['cta_label'];

$temoignages = function_exists( 'get_field' ) ? get_field( 'cbs_offres_n1_temoignages', $pid ) : null;

$n1_prestation_svgs = array(
	1 => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>',
	2 => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>',
	3 => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>',
	4 => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>',
	5 => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>',
);
?>
<section class="methode-spa-hero methode-spa-hero--compact cbs-section" aria-labelledby="n1-hero-heading">
	<div class="methode-spa-hero__inner cbs-container">
		<p class="methode-spa-hero__kicker"><?php echo esc_html( $hero_kicker ); ?></p>
		<h1 id="n1-hero-heading" class="methode-spa-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="methode-spa-hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
	</div>
</section>

<section class="offre-phases" aria-labelledby="n1-prestations-heading">
	<div class="offre-phases__inner">
		<header class="offre-phases__header">
			<p class="offre-phases__kicker"><?php esc_html_e( 'Diagnostic stratégique', 'cbs-theme' ); ?></p>
			<h2 id="n1-prestations-heading" class="offre-phases__title"><?php esc_html_e( 'Prestations', 'cbs-theme' ); ?></h2>
			<p class="offre-phases__lead"><?php echo esc_html( $prestations_intro ); ?></p>
		</header>
		<div class="offre-phases__grid">
			<?php
			$prestation_idx = 0;
			foreach ( $prestations as $line ) :
				++$prestation_idx;
				$icon_svg       = $n1_prestation_svgs[ $prestation_idx ] ?? $n1_prestation_svgs[1];
				$prestation_num = sprintf(
					/* translators: %s: prestation index zero-padded (e.g. 01). */
					__( 'Prestation %s', 'cbs-theme' ),
					sprintf( '%02d', $prestation_idx )
				);
				?>
				<article class="phase-card">
					<div class="phase-card__icon"><?php echo $icon_svg; ?></div>
					<p class="phase-card__number"><?php echo esc_html( $prestation_num ); ?></p>
					<h3 class="phase-card__title"><?php echo esc_html( $line ); ?></h3>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="cbs-section offre-detail" aria-labelledby="n1-livrables-heading">
	<div class="cbs-container offre-detail__inner">
		<div class="testimonial-card">
			<h2 id="n1-livrables-heading" class="offre-detail__h2"><?php esc_html_e( 'Livrables', 'cbs-theme' ); ?></h2>
			<ul class="offre-detail__list">
				<?php foreach ( $livrables as $line ) : ?>
					<li><?php echo esc_html( $line ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<h2 class="offre-detail__h2"><?php esc_html_e( 'Résultat', 'cbs-theme' ); ?></h2>
		<div class="offre-detail__lead offre-detail__lead--rich"><?php echo wp_kses_post( wpautop( $resultat ) ); ?></div>
	</div>
</section>

<?php if ( is_array( $pour_qui ) && $pour_qui !== array() ) : ?>
<section class="cbs-section offre-detail" aria-labelledby="n1-pour-qui-heading">
	<div class="cbs-container offre-detail__inner">
		<h2 id="n1-pour-qui-heading" class="offre-detail__h2"><?php esc_html_e( 'Pour qui ?', 'cbs-theme' ); ?></h2>
		<ul class="offre-detail__list">
			<?php foreach ( $pour_qui as $profil ) : ?>
				<li><?php echo esc_html( (string) $profil ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<section class="cbs-section offre-temoignages" aria-labelledby="n1-temoignages-heading">
	<div class="cbs-container">
		<h2 id="n1-temoignages-heading" class="offre-detail__h2"><?php esc_html_e( 'Témoignages', 'cbs-theme' ); ?></h2>
		<?php if ( is_array( $temoignages ) && $temoignages !== array() ) : ?>
			<ul class="testimonial-list">
				<?php foreach ( $temoignages as $t ) : ?>
					<?php
					if ( ! is_array( $t ) ) {
						continue;
					}
					$txt = isset( $t['cbs_offres_temoignage_texte'] ) ? (string) $t['cbs_offres_temoignage_texte'] : '';
					if ( $txt === '' ) {
						continue;
					}
					$aut = isset( $t['cbs_offres_temoignage_auteur'] ) ? (string) $t['cbs_offres_temoignage_auteur'] : '';
					$eta = isset( $t['cbs_offres_temoignage_etablissement'] ) ? (string) $t['cbs_offres_temoignage_etablissement'] : '';
					?>
					<li>
						<figure class="testimonial-card">
							<blockquote class="testimonial-card__quote">
								<p><?php echo wp_kses_post( wpautop( $txt ) ); ?></p>
							</blockquote>
							<figcaption class="testimonial-card__footer">
								<?php if ( $aut !== '' ) : ?>
									<cite class="testimonial-card__author"><?php echo esc_html( $aut ); ?></cite>
								<?php endif; ?>
								<?php if ( $eta !== '' ) : ?>
									<span class="testimonial-card__role"><?php echo esc_html( $eta ); ?></span>
								<?php endif; ?>
							</figcaption>
						</figure>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p class="offre-placeholder"><?php esc_html_e( '[À COMPLÉTER] — Témoignages clients (cf. content-structure.md §12).', 'cbs-theme' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="cbs-section cta-rdv" aria-labelledby="n1-cta-heading">
	<div class="cbs-container cta-rdv__inner">
		<h2 id="n1-cta-heading" class="screen-reader-text"><?php esc_html_e( 'Étape suivante', 'cbs-theme' ); ?></h2>
		<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $cta_label ); ?></a>
	</div>
</section>
