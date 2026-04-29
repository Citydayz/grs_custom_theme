<?php
/**
 * CBS Theme — Vue d’ensemble des pôles (content-structure.md §2 section 4)
 */
defined( 'ABSPATH' ) || exit;

$pole_conseil_img = CBS_URI . '/assets/images/placeholders/pole-conseil.jpg';
$pole_gestion_img = CBS_URI . '/assets/images/placeholders/pole-gestion.jpg';
?>
<section class="cbs-section poles-overview" aria-labelledby="poles-overview-heading">
	<div class="poles-overview__header">
		<div class="cbs-container">

			<span class="poles-overview__surtitre"><?php esc_html_e( 'Notre expertise', 'cbs-theme' ); ?></span>

			<h2 id="poles-overview-heading" class="poles-overview__titre">
				<?php esc_html_e( 'Deux expertises, une vision', 'cbs-theme' ); ?>
			</h2>

			<p class="poles__intro">
				<?php esc_html_e( 'Une réponse à chaque stade de maturité d\'un spa — de l\'investisseur qui construit à l\'hôtelier qui souhaite déléguer son exploitation.', 'cbs-theme' ); ?>
			</p>

			<div class="poles-overview__stats">
				<div class="poles-overview__stat">
					<span class="poles-overview__stat-value"><?php esc_html_e( '+10', 'cbs-theme' ); ?></span>
					<span class="poles-overview__stat-label"><?php esc_html_e( 'Hôtels 4 et 5 étoiles accompagnés', 'cbs-theme' ); ?></span>
				</div>
				<div class="poles-overview__stat">
					<span class="poles-overview__stat-value"><?php esc_html_e( '13', 'cbs-theme' ); ?></span>
					<span class="poles-overview__stat-label"><?php esc_html_e( 'Ans d\'expertise spa hôtelier', 'cbs-theme' ); ?></span>
				</div>
				<div class="poles-overview__stat">
					<span class="poles-overview__stat-value"><?php esc_html_e( '2', 'cbs-theme' ); ?></span>
					<span class="poles-overview__stat-label"><?php esc_html_e( 'Pôles d\'expertise complémentaires', 'cbs-theme' ); ?></span>
				</div>
			</div>

		</div>
	</div>

	<section class="pole-section pole-section--conseil" aria-label="<?php echo esc_attr( __( 'Pôle Conseil & Création — La Méthode Spa Profit™', 'cbs-theme' ) ); ?>">
		<div class="pole-section__content">
			<span class="pole-section__surtitre"><?php esc_html_e( 'Pôle Conseil & Création', 'cbs-theme' ); ?></span>
			<h3 class="pole-section__titre">
				<?php esc_html_e( 'La Méthode Spa Profit™', 'cbs-theme' ); ?>
			</h3>
			<p class="pole-section__texte">
				<?php esc_html_e( "De l'audit stratégique à la conception fonctionnelle — un accompagnement complet pour créer un spa rentable et parfaitement exploitable dès l'ouverture.", 'cbs-theme' ); ?>
			</p>
			<ul class="pole-block__niveaux">
				<li><?php esc_html_e( 'Niveau 1 — Diagnostic stratégique', 'cbs-theme' ); ?></li>
				<li><?php esc_html_e( 'Niveau 2 — Conception & sécurisation', 'cbs-theme' ); ?></li>
				<li><?php esc_html_e( 'Niveau 3 — Mise en performance', 'cbs-theme' ); ?></li>
			</ul>
			<p class="pole-block__argument">
				<?php esc_html_e( 'Évitez jusqu\'à 100 000 € d\'erreurs de conception.', 'cbs-theme' ); ?>
			</p>
			<a class="btn-secondary pole-section__cta" href="<?php echo esc_url( home_url( '/methode-spa-profit/' ) ); ?>">
				<?php esc_html_e( 'Découvrir la méthode', 'cbs-theme' ); ?>
			</a>
		</div>
		<div class="pole-section__image">
			<img
				src="<?php echo esc_url( $pole_conseil_img ); ?>"
				alt="<?php echo esc_attr( __( 'Conception de spa hôtelier haut de gamme', 'cbs-theme' ) ); ?>"
				width="800"
				height="600"
				loading="lazy"
				decoding="async"
			>
		</div>
	</section>

	<section class="pole-section pole-section--gestion pole-section--reverse" aria-label="<?php echo esc_attr( __( 'Pôle Gestion & Staffing — Pilotage externalisé', 'cbs-theme' ) ); ?>">
		<div class="pole-section__image">
			<img
				src="<?php echo esc_url( $pole_gestion_img ); ?>"
				alt="<?php echo esc_attr( __( 'Gestion externalisée de spa hôtelier', 'cbs-theme' ) ); ?>"
				width="800"
				height="600"
				loading="lazy"
				decoding="async"
			>
		</div>
		<div class="pole-section__content">
			<span class="pole-section__surtitre"><?php esc_html_e( 'Pôle Gestion & Staffing', 'cbs-theme' ); ?></span>
			<h3 class="pole-section__titre">
				<?php esc_html_e( 'Pilotage externalisé', 'cbs-theme' ); ?>
			</h3>
			<p class="pole-section__texte">
				<?php esc_html_e( "Gestion partielle ou complète, staffing, massages en chambre — déléguez l'exploitation à un expert pendant que vous vous concentrez sur votre hôtel.", 'cbs-theme' ); ?>
			</p>
			<ul class="pole-block__niveaux">
				<li><?php esc_html_e( 'Gestion externalisée partielle ou complète', 'cbs-theme' ); ?></li>
				<li><?php esc_html_e( 'Staffing & renfort d\'équipe', 'cbs-theme' ); ?></li>
				<li><?php esc_html_e( 'Massages en chambre clés en main', 'cbs-theme' ); ?></li>
			</ul>
			<p class="pole-block__argument">
				<?php esc_html_e( "Disponible en Alsace — partenaire de confiance des hôtels 4\u{2605} et 5\u{2605}.", 'cbs-theme' ); ?>
			</p>
			<a class="btn-secondary pole-section__cta" href="<?php echo esc_url( home_url( '/gestion-spa-hotelier/' ) ); ?>">
				<?php esc_html_e( 'Découvrir les offres', 'cbs-theme' ); ?>
			</a>
		</div>
	</section>
</section>
