<?php
/**
 * CBS Theme — Problème du marché (content-structure.md §2 section 3)
 */
defined( 'ABSPATH' ) || exit;
?>
<section class="cbs-section probleme-marche" aria-labelledby="probleme-titre">
	<div class="cbs-container">

		<h2 id="probleme-titre" class="probleme-marche__titre">
			<?php esc_html_e( 'Créer un spa hôtelier est un investissement majeur', 'cbs-theme' ); ?>
		</h2>

		<p class="probleme-marche__intro">
			<?php esc_html_e( 'Un spa représente souvent un investissement entre 500 000 € et 2 millions d\'euros pour un hôtel. Pourtant, beaucoup sont conçus uniquement d\'un point de vue architectural — sans expertise d\'exploitation.', 'cbs-theme' ); ?>
		</p>

		<div class="probleme-marche__grid">

			<ul class="probleme-marche__liste">
				<li><?php esc_html_e( 'Cabines mal dimensionnées', 'cbs-theme' ); ?></li>
				<li><?php esc_html_e( 'Problèmes de ventilation et d\'humidité', 'cbs-theme' ); ?></li>
				<li><?php esc_html_e( 'Mauvaise acoustique', 'cbs-theme' ); ?></li>
				<li><?php esc_html_e( 'Parcours client inefficace', 'cbs-theme' ); ?></li>
				<li><?php esc_html_e( 'Organisation complexe pour les équipes', 'cbs-theme' ); ?></li>
			</ul>

			<div class="probleme-marche__accroche">
				<p class="probleme-marche__chiffre">
					<?php esc_html_e( '50 000 à 100 000 €', 'cbs-theme' ); ?>
				</p>
				<p class="probleme-marche__chiffre-label">
					<?php esc_html_e( 'de travaux correctifs et pertes d\'exploitation évitables avec la bonne expertise dès la conception.', 'cbs-theme' ); ?>
				</p>
				<a href="<?php echo esc_url( home_url( '/methode-spa-profit/' ) ); ?>" class="btn-secondary">
					<?php esc_html_e( 'Découvrir notre méthode', 'cbs-theme' ); ?>
				</a>
			</div>

		</div>
	</div>
</section>
