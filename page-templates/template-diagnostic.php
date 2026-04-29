<?php
/**
 * Template Name: Diagnostic
 *
 * Tunnel de qualification interactif (diagnostic-tunnel.md §3).
 *
 * @package CBS_Theme
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main diagnostic-page">
	<section class="cbs-section diagnostic-page__hero" aria-labelledby="diagnostic-hero-heading">
		<div class="diagnostic-page__hero-inner cbs-container">
			<p class="diagnostic-page__kicker">
				<?php esc_html_e( 'Diagnostic Spa Hôtelier', 'cbs-theme' ); ?>
			</p>
			<h1 id="diagnostic-hero-heading" class="diagnostic-page__title">
				<?php esc_html_e( 'Votre spa est-il réellement pensé pour être rentable ?', 'cbs-theme' ); ?>
			</h1>
			<p class="diagnostic-page__lead">
				<?php esc_html_e( 'Un spa peut être esthétique, bien équipé et pourtant difficile à exploiter au quotidien. En 3 minutes, ce diagnostic vous aide à identifier les principaux points de vigilance de votre projet ou de votre spa existant.', 'cbs-theme' ); ?>
			</p>
		</div>
	</section>

	<section id="diagnostic-form" class="cbs-section diagnostic-page__body" aria-labelledby="diagnostic-tunnel-heading">
		<h2 id="diagnostic-tunnel-heading" class="screen-reader-text">
			<?php esc_html_e( 'Questionnaire de diagnostic', 'cbs-theme' ); ?>
		</h2>
		<div class="cbs-container">
			<?php
			while ( have_posts() ) {
				the_post();
				the_content();
			}
			?>
			<div
				class="tunnel"
				id="tunnel-root"
				data-tunnel-root
				data-tunnel-meta-gestion="<?php echo esc_attr( __( '2 minutes · 9 questions · Résultat immédiat', 'cbs-theme' ) ); ?>"
			>
				<div id="tunnel-live-region" class="screen-reader-text" aria-live="polite" aria-atomic="true"></div>

				<div class="tunnel__panel tunnel__panel--intro" id="tunnel-intro" data-tunnel-step="0">
					<p class="tunnel__intro-lead">
						<?php esc_html_e( 'Répondez aux questions suivantes pour obtenir votre score et vos pistes de vigilance.', 'cbs-theme' ); ?>
					</p>
					<button type="button" class="btn-primary tunnel__cta-start" id="tunnel-start" data-tunnel-start>
						<?php esc_html_e( 'Lancer le diagnostic', 'cbs-theme' ); ?>
					</button>
					<p class="tunnel__intro-meta" id="tunnel-intro-meta">
						<?php esc_html_e( '3 minutes · 10 questions · Résultat immédiat', 'cbs-theme' ); ?>
					</p>
				</div>

				<?php get_template_part( 'template-parts/diagnostic/tunnel-step' ); ?>
				<?php get_template_part( 'template-parts/diagnostic/tunnel-capture' ); ?>
				<?php get_template_part( 'template-parts/diagnostic/tunnel-resultat' ); ?>
			</div>
		</div>
	</section>

	<section class="cbs-section diagnostic-page__reveal" aria-labelledby="diagnostic-reveal-heading">
		<div class="cbs-container">
			<h2 id="diagnostic-reveal-heading" class="diagnostic-page__reveal-heading">
				<?php esc_html_e( 'Ce que ce diagnostic révèle', 'cbs-theme' ); ?>
			</h2>
			<div class="diagnostic-page__reveal-grid">
				<article class="diagnostic-page__reveal-card">
					<h3 class="diagnostic-page__reveal-title"><?php esc_html_e( 'Conception des espaces', 'cbs-theme' ); ?></h3>
					<p class="diagnostic-page__reveal-text">
						<?php esc_html_e( 'Cabines, circulations et équipements : sont-ils alignés avec votre capacité d’accueil, vos coûts fixes et vos objectifs de rentabilité ?', 'cbs-theme' ); ?>
					</p>
				</article>
				<article class="diagnostic-page__reveal-card">
					<h3 class="diagnostic-page__reveal-title"><?php esc_html_e( 'Fluidité d’exploitation', 'cbs-theme' ); ?></h3>
					<p class="diagnostic-page__reveal-text">
						<?php esc_html_e( 'Équipes, stocks et planning : où apparaissent les goulots d’étranglement ou les tâches chronophages au quotidien ?', 'cbs-theme' ); ?>
					</p>
				</article>
				<article class="diagnostic-page__reveal-card">
					<h3 class="diagnostic-page__reveal-title"><?php esc_html_e( 'Expérience client', 'cbs-theme' ); ?></h3>
					<p class="diagnostic-page__reveal-text">
						<?php esc_html_e( 'Parcours, accueil et fidélisation : votre promesse spa est-elle cohérente avec ce que vivent réellement vos clients ?', 'cbs-theme' ); ?>
					</p>
				</article>
				<article class="diagnostic-page__reveal-card">
					<h3 class="diagnostic-page__reveal-title"><?php esc_html_e( 'Organisation opérationnelle', 'cbs-theme' ); ?></h3>
					<p class="diagnostic-page__reveal-text">
						<?php esc_html_e( 'Rôles, processus et pilotage : la structure tient-elle la charge, y compris en période de forte affluence ?', 'cbs-theme' ); ?>
					</p>
				</article>
			</div>
		</div>
	</section>

	<section class="cbs-section diagnostic-page__reassurance" aria-labelledby="diagnostic-reassurance-heading">
		<h2 id="diagnostic-reassurance-heading" class="screen-reader-text">
			<?php esc_html_e( 'Garanties du diagnostic en ligne', 'cbs-theme' ); ?>
		</h2>
		<div class="cbs-container">
			<div class="diagnostic-page__reassurance-grid">
				<div class="diagnostic-page__reassurance-item">
					<span class="diagnostic-page__reassurance-icon" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="12" r="9" />
							<path d="M12 7v5l3 2" />
						</svg>
					</span>
					<p class="diagnostic-page__reassurance-title">
						<?php esc_html_e( 'Résultat immédiat, sans inscription', 'cbs-theme' ); ?>
					</p>
				</div>
				<div class="diagnostic-page__reassurance-item">
					<span class="diagnostic-page__reassurance-icon" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
							<rect x="5" y="11" width="14" height="10" rx="2" />
							<path d="M8 11V8a4 4 0 0 1 8 0v3" />
						</svg>
					</span>
					<p class="diagnostic-page__reassurance-title">
						<?php esc_html_e( 'Diagnostic confidentiel', 'cbs-theme' ); ?>
					</p>
				</div>
				<div class="diagnostic-page__reassurance-item">
					<span class="diagnostic-page__reassurance-icon" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="12" r="9" />
							<path d="M8 12l2.5 2.5L16 9" />
						</svg>
					</span>
					<p class="diagnostic-page__reassurance-title">
						<?php esc_html_e( 'Sans engagement commercial', 'cbs-theme' ); ?>
					</p>
				</div>
			</div>
		</div>
	</section>

	<section class="cbs-section diagnostic-page__seo" aria-labelledby="diagnostic-seo-heading">
		<div class="cbs-container">
			<h2 id="diagnostic-seo-heading" class="diagnostic-page__seo-heading">
				<?php esc_html_e( 'Un diagnostic pensé pour les spas hôteliers d’exception', 'cbs-theme' ); ?>
			</h2>
			<div class="diagnostic-page__seo-prose">
				<p>
					<?php esc_html_e( 'Un spa hôtelier d’exception repose autant sur l’architecture des lieux que sur la façon dont les équipes les font vivre au quotidien. Ce diagnostic en ligne s’adresse aux directions et aux porteurs de projet qui souhaitent un regard expert sur la cohérence entre investissement, promesse client et réalité opérationnelle, avant d’envisager un audit spa plus poussé dans un établissement 4 ou 5 étoiles.', 'cbs-theme' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'En tant que consultant spa hôtelier, j’observe souvent l’écart entre une carte des soins ambitieuse et une organisation qui peine à la tenir. L’objectif ici n’est pas de noter votre spa pour le plaisir, mais de mettre en lumière les zones de vigilance : conception des espaces, fluidité des équipes, expérience client et organisation. Dans un univers du luxe, l’optimisation ne se limite pas à la décoration : elle passe par des choix de parcours, de staffing et de pilotage qui soutiennent la rentabilité. Les établissements 4 et 5 étoiles qui visent l’excellence y trouvent souvent un premier repère pour rapprocher image de marque et réalité en cabine.', 'cbs-theme' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'Que vous prépariez un projet ou que vous cherchiez à fiabiliser un spa existant, ce questionnaire vous donne une base claire pour la suite, sans jargon inutile.', 'cbs-theme' ); ?>
				</p>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
