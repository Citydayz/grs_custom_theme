<?php
/**
 * CBS Theme — template-parts/global/header.php
 * Skip link, en-tête et navigation (navigation.md §1–§4).
 */
defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Aller au contenu', 'cbs-theme' ); ?></a>

<header class="site-header" role="banner">
	<div class="site-header__inner">
		<div class="site-header__brand">
			<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="site-header__logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="site-header__logo-main"><?php esc_html_e( 'Conseil & Gestion', 'cbs-theme' ); ?></span>
					<span class="site-header__logo-sub">des rituels du spa</span>
				</a>
			<?php endif; ?>
		</div>

		<div class="site-header__nav">
			<div class="nav">
				<button
					type="button"
					class="nav__toggle"
					aria-expanded="false"
					aria-controls="nav-menu"
					aria-label="<?php esc_attr_e( 'Ouvrir le menu', 'cbs-theme' ); ?>"
					data-cbs-label-open="<?php esc_attr_e( 'Ouvrir le menu', 'cbs-theme' ); ?>"
					data-cbs-label-close="<?php esc_attr_e( 'Fermer le menu', 'cbs-theme' ); ?>"
				>
					<span class="nav__toggle-icon" aria-hidden="true"></span>
				</button>

				<nav
					id="nav-menu"
					class="nav__menu"
					role="navigation"
					aria-label="<?php esc_attr_e( 'Navigation principale', 'cbs-theme' ); ?>"
					aria-hidden="true"
				>
					<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'container'         => false,
							'menu_class'        => 'nav__list',
							'fallback_cb'       => false,
							'depth'             => 2,
							'walker'            => new CBS_Nav_Walker(),
						)
					);
					?>
				</nav>
			</div>
		</div>

		<div class="site-header__cta">
			<span class="site-header__cta-rule" aria-hidden="true"></span>
			<a class="site-header__contact" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
				<?php esc_html_e( 'Contact', 'cbs-theme' ); ?>
			</a>
		</div>
	</div>
</header>
