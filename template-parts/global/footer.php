<?php
/**
 * CBS Theme — template-parts/global/footer.php
 */
defined( 'ABSPATH' ) || exit;
?>
<footer class="site-footer">
	<div class="cbs-container">
		<div class="site-footer__grid">
			<div class="site-footer__col site-footer__col--brand">
				<p class="site-footer__logo-text"><?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?></p>
				<p class="site-footer__copyright">
					<?php
					printf(
						/* translators: 1: year (Y), 2: site name */
						esc_html__( '© %1$s %2$s. Tous droits réservés.', 'cbs-theme' ),
						esc_html( wp_date( 'Y' ) ),
						esc_html( get_bloginfo( 'name', 'display' ) )
					);
					?>
				</p>
			</div>

			<div class="site-footer__col site-footer__col--offers">
				<h2 class="site-footer__heading"><?php esc_html_e( 'Offres', 'cbs-theme' ); ?></h2>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-1',
						'container'        => false,
						'menu_class'       => 'site-footer__menu',
						'depth'            => 2,
						'fallback_cb'      => false,
					)
				);
				?>
			</div>

			<div class="site-footer__col site-footer__col--legal">
				<div class="site-footer__legal-stack">
					<div class="site-footer__legal-block">
						<h2 class="site-footer__heading"><?php esc_html_e( 'Liens utiles', 'cbs-theme' ); ?></h2>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer-2',
								'container'        => false,
								'menu_class'       => 'site-footer__menu',
								'depth'            => 2,
								'fallback_cb'      => false,
							)
						);
						?>
					</div>
					<div class="site-footer__legal-block">
						<h2 class="site-footer__heading"><?php esc_html_e( 'Légal', 'cbs-theme' ); ?></h2>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'legal',
								'container'        => false,
								'menu_class'       => 'site-footer__menu',
								'depth'            => 2,
								'fallback_cb'      => false,
							)
						);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
