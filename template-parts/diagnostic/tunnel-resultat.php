<?php
/**
 * Résultats du tunnel diagnostic (diagnostic-tunnel.md §6).
 *
 * @package CBS_Theme
 */
defined( 'ABSPATH' ) || exit;
?>
<div
	class="tunnel__panel tunnel__panel--result"
	id="tunnel-result"
	data-tunnel-step="12"
	data-tunnel-panel="12"
	hidden
>
	<article
		class="tunnel__resultat tunnel__resultat--niveau-a"
		id="tunnel-resultat-a"
		data-niveau="A"
		hidden
	>
		<div class="tunnel__score-badge tunnel__score-badge--a">
			<?php
			echo esc_html( __( 'Score', 'cbs-theme' ) );
			?>
			<span class="tunnel__score-num" data-tunnel-score-display>0</span>/30 :
			<?php esc_html_e( 'Bases solides', 'cbs-theme' ); ?>
		</div>
		<h2 class="tunnel__resultat-titre" id="tunnel-resultat-a-heading" tabindex="-1">
			<?php esc_html_e( 'Votre spa semble reposer sur des bases solides.', 'cbs-theme' ); ?>
		</h2>
		<p class="tunnel__resultat-texte">
			<?php esc_html_e( 'Cela ne signifie pas qu’aucune optimisation n’est possible, mais la structure générale paraît cohérente sur les dimensions essentielles : conception, exploitation et expérience client. Des ajustements ciblés peuvent encore améliorer la performance.', 'cbs-theme' ); ?>
		</p>
		<div class="tunnel__ctas">
			<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
				<?php esc_html_e( 'Échanger sur les optimisations possibles', 'cbs-theme' ); ?>
			</a>
			<a class="btn-secondary" href="<?php echo esc_url( home_url( '/methode-spa-profit/' ) ); ?>">
				<?php esc_html_e( 'Découvrir la Méthode Spa Profit™', 'cbs-theme' ); ?>
			</a>
		</div>
		<p class="tunnel__email-confirm">
			<?php esc_html_e( 'Un récapitulatif a été envoyé à votre adresse email.', 'cbs-theme' ); ?>
		</p>
	</article>

	<article
		class="tunnel__resultat tunnel__resultat--niveau-b"
		id="tunnel-resultat-b"
		data-niveau="B"
		hidden
	>
		<div class="tunnel__score-badge tunnel__score-badge--b">
			<?php echo esc_html( __( 'Score', 'cbs-theme' ) ); ?>
			<span class="tunnel__score-num" data-tunnel-score-display>0</span>/30 :
			<?php esc_html_e( 'Points de vigilance détectés', 'cbs-theme' ); ?>
		</div>
		<h2 class="tunnel__resultat-titre" id="tunnel-resultat-b-heading" tabindex="-1">
			<?php esc_html_e( 'Votre spa présente plusieurs zones de fragilité.', 'cbs-theme' ); ?>
		</h2>
		<p class="tunnel__resultat-texte">
			<?php esc_html_e( 'Ces points peuvent limiter la fluidité d’exploitation, l’expérience client ou la performance économique. Un regard externe permet souvent d’identifier rapidement les ajustements prioritaires.', 'cbs-theme' ); ?>
		</p>
		<div class="tunnel__ctas">
			<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
				<?php esc_html_e( 'Demander un pré-audit spa', 'cbs-theme' ); ?>
			</a>
			<a class="btn-secondary" href="<?php echo esc_url( home_url( '/references/' ) ); ?>">
				<?php esc_html_e( 'Voir nos références', 'cbs-theme' ); ?>
			</a>
		</div>
		<p class="tunnel__email-confirm">
			<?php esc_html_e( 'Un récapitulatif a été envoyé à votre adresse email.', 'cbs-theme' ); ?>
		</p>
	</article>

	<article
		class="tunnel__resultat tunnel__resultat--niveau-c"
		id="tunnel-resultat-c"
		data-niveau="C"
		hidden
	>
		<div class="tunnel__score-badge tunnel__score-badge--c">
			<?php echo esc_html( __( 'Score', 'cbs-theme' ) ); ?>
			<span class="tunnel__score-num" data-tunnel-score-display>0</span>/30 :
			<?php esc_html_e( 'Points de vigilance importants', 'cbs-theme' ); ?>
		</div>
		<h2 class="tunnel__resultat-titre" id="tunnel-resultat-c-heading" tabindex="-1">
			<?php esc_html_e( 'Votre spa présente des points de vigilance importants.', 'cbs-theme' ); ?>
		</h2>
		<p class="tunnel__resultat-texte">
			<?php esc_html_e( 'Dans ce type de situation, les conséquences peuvent être durables : coûts d’exploitation élevés, inconfort des équipes, expérience client dégradée ou rentabilité insuffisante. Un audit stratégique permet de clarifier les causes et de définir un plan d’action priorisé.', 'cbs-theme' ); ?>
		</p>
		<div class="tunnel__ctas">
			<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
				<?php esc_html_e( 'Planifier un échange confidentiel', 'cbs-theme' ); ?>
			</a>
			<a class="btn-secondary" href="<?php echo esc_url( home_url( '/methode-spa-profit/' ) ); ?>">
				<?php esc_html_e( 'Découvrir la Méthode Spa Profit™', 'cbs-theme' ); ?>
			</a>
		</div>
		<p class="tunnel__email-confirm">
			<?php esc_html_e( 'Un récapitulatif a été envoyé à votre adresse email.', 'cbs-theme' ); ?>
		</p>
	</article>
</div>
