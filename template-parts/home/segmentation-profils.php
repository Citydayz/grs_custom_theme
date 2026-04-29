<?php
/**
 * CBS Theme — Segmentation profils (content-structure.md §2 section 2)
 */
defined( 'ABSPATH' ) || exit;
?>
<section class="cbs-section segmentation" aria-labelledby="segmentation-heading">
	<div class="cbs-container">
		<h2 id="segmentation-heading" class="segmentation__title">
			<?php esc_html_e( 'À quelle situation vous reconnaissez-vous ?', 'cbs-theme' ); ?>
		</h2>

		<div class="segmentation__grid">
			<a class="profile-card" href="<?php echo esc_url( home_url( '/methode-spa-profit/' ) ); ?>">
				<span class="profile-card__badge"><?php esc_html_e( 'France entière', 'cbs-theme' ); ?></span>
				<span class="profile-card__icon" aria-hidden="true">
					<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false">
						<path d="M8 38V10l16-6 16 6v28l-16 6-16-6z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
						<path d="M16 20h16M16 26h10M16 32h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
					</svg>
				</span>
				<h3 class="profile-card__heading">
					<?php esc_html_e( 'Vous créez ou transformez un spa', 'cbs-theme' ); ?>
				</h3>
				<p class="profile-card__text">
					<?php esc_html_e( "Vous investissez dans un spa et voulez sécuriser chaque étape du projet pour éviter les erreurs coûteuses.", 'cbs-theme' ); ?>
				</p>
				<span class="profile-card__cta">
					<?php esc_html_e( 'Découvrir le Pôle Conseil', 'cbs-theme' ); ?>
				</span>
			</a>

			<a class="profile-card" href="<?php echo esc_url( home_url( '/gestion-spa-hotelier/' ) ); ?>">
				<span class="profile-card__badge"><?php esc_html_e( 'Alsace', 'cbs-theme' ); ?></span>
				<span class="profile-card__icon" aria-hidden="true">
					<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false">
						<rect x="10" y="12" width="28" height="24" rx="2" stroke="currentColor" stroke-width="1.5"/>
						<path d="M14 20h20M14 26h12M14 32h8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
						<circle cx="32" cy="16" r="3" stroke="currentColor" stroke-width="1.5"/>
					</svg>
				</span>
				<h3 class="profile-card__heading">
					<?php esc_html_e( 'Vous gérez un spa et souhaitez déléguer', 'cbs-theme' ); ?>
				</h3>
				<p class="profile-card__text">
					<?php esc_html_e( "Vous cherchez un partenaire pour piloter tout ou partie de l'exploitation de votre spa.", 'cbs-theme' ); ?>
				</p>
				<span class="profile-card__cta">
					<?php esc_html_e( 'Découvrir le Pôle Gestion', 'cbs-theme' ); ?>
				</span>
			</a>

			<a class="profile-card" href="<?php echo esc_url( home_url( '/massages-en-chambre-hotel/' ) ); ?>">
				<span class="profile-card__badge"><?php esc_html_e( 'Alsace', 'cbs-theme' ); ?></span>
				<span class="profile-card__icon" aria-hidden="true">
					<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false">
						<path d="M12 32c0-6 4-10 12-10s12 4 12 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
						<path d="M16 20c0-3 2.5-5 8-5s8 2 8 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
						<path d="M8 36h32" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
					</svg>
				</span>
				<h3 class="profile-card__heading">
					<?php esc_html_e( 'Vous voulez proposer des massages sans infrastructure', 'cbs-theme' ); ?>
				</h3>
				<p class="profile-card__text">
					<?php esc_html_e( "Vous souhaitez enrichir l'expérience client avec des massages en chambre, sans spa dédié.", 'cbs-theme' ); ?>
				</p>
				<span class="profile-card__cta">
					<?php esc_html_e( "Découvrir l'offre", 'cbs-theme' ); ?>
				</span>
			</a>
		</div>
	</div>
</section>
