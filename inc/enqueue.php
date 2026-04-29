<?php
/**
 * CBS Theme — enqueue.php
 * Enqueue scripts & styles.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enregistre et charge les assets front-office.
 */
function cbs_enqueue_assets(): void {
	wp_enqueue_style(
		'cbs-main',
		CBS_URI . '/assets/css/main.css',
		[],
		CBS_VERSION
	);

	wp_enqueue_script(
		'cbs-nav',
		CBS_URI . '/assets/js/nav.js',
		[],
		CBS_VERSION,
		true
	);
	wp_enqueue_script(
		'cbs-animations',
		CBS_URI . '/assets/js/animations.js',
		[],
		CBS_VERSION,
		true
	);

	cbs_script_defer( 'cbs-nav' );
	cbs_script_defer( 'cbs-animations' );

	cbs_enqueue_tunnel_when_diagnostic();
	cbs_enqueue_calendly_when_needed();
	cbs_enqueue_contact_form_assets();
	cbs_enqueue_partners_on_front_page();
}
add_action( 'wp_enqueue_scripts', 'cbs_enqueue_assets' );

/**
 * Bandeau partenaires (accueil) — `assets/css/components/partners.css` (CPT cbs_partners).
 */
function cbs_enqueue_partners_on_front_page(): void {
	if ( ! is_front_page() ) {
		return;
	}
	wp_enqueue_style(
		'cbs-partners',
		CBS_URI . '/assets/css/components/partners.css',
		array( 'cbs-main' ),
		CBS_VERSION
	);
}

/**
 * Tunnel + données AJAX — uniquement sur le template Diagnostic.
 */
function cbs_enqueue_tunnel_when_diagnostic(): void {
	if ( ! is_page_template( 'page-templates/template-diagnostic.php' ) ) {
		return;
	}

	wp_enqueue_script(
		'cbs-tunnel',
		CBS_URI . '/assets/js/tunnel.js',
		[],
		CBS_VERSION,
		true
	);
	cbs_script_defer( 'cbs-tunnel' );

	wp_localize_script(
		'cbs-tunnel',
		'cbsAjax',
		[
			'url'     => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'cbs_tunnel_nonce' ),
			'strings' => [
				'genericError' => __( 'Une erreur est survenue. Veuillez réessayer.', 'cbs-theme' ),
				'timeout'      => __( 'Le serveur met trop longtemps à répondre. Réessayez dans un instant.', 'cbs-theme' ),
				'offline'      => __( 'Vérifiez votre connexion internet puis réessayez.', 'cbs-theme' ),
			],
		]
	);
}

/**
 * Indique si les scripts Calendly (tiers) doivent être chargés sur cette requête.
 *
 * — Template page Contact dédié (`page-templates/template-contact.php`).
 * — Ou champ ACF `cbs_afficher_calendly` activé sur la page courante (ex. accueil).
 */
function cbs_should_enqueue_calendly_scripts(): bool {
	if ( is_page_template( 'page-templates/template-contact.php' ) ) {
		return true;
	}

	if ( function_exists( 'get_field' ) ) {
		$post_id = (int) get_queried_object_id();
		if ( $post_id > 0 && (bool) get_field( 'cbs_afficher_calendly', $post_id ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Widget Calendly — uniquement template Contact ou si `cbs_afficher_calendly` est vrai.
 */
function cbs_enqueue_calendly_when_needed(): void {
	if ( ! cbs_should_enqueue_calendly_scripts() ) {
		return;
	}

	wp_enqueue_script(
		'cbs-calendly-widget',
		'https://assets.calendly.com/assets/external/widget.js',
		[],
		null,
		true
	);
	cbs_script_defer( 'cbs-calendly-widget' );

	wp_enqueue_script(
		'cbs-calendly',
		CBS_URI . '/assets/js/calendly.js',
		[ 'cbs-calendly-widget' ],
		CBS_VERSION,
		true
	);
	cbs_script_defer( 'cbs-calendly' );
}

/**
 * Preconnect / dns-prefetch + preload du script widget — uniquement si Calendly est utilisé sur la page.
 *
 * Réduit la latence du premier chargement (résolution DNS + TCP/TLS + début du téléchargement de widget.js).
 */
function cbs_print_calendly_resource_hints(): void {
	if ( ! cbs_should_enqueue_calendly_scripts() ) {
		return;
	}

	$widget_js = 'https://assets.calendly.com/assets/external/widget.js';

	echo '<link rel="preconnect" href="https://assets.calendly.com">' . "\n";
	echo '<link rel="preconnect" href="https://calendly.com">' . "\n";
	echo '<link rel="dns-prefetch" href="https://assets.calendly.com">' . "\n";
	echo '<link rel="dns-prefetch" href="https://calendly.com">' . "\n";
	echo '<link rel="preload" href="' . esc_url( $widget_js ) . '" as="script">' . "\n";
}
add_action( 'wp_head', 'cbs_print_calendly_resource_hints', 0 );

/**
 * Formulaire contact AJAX — uniquement template Contact (forms.md §4).
 */
function cbs_enqueue_contact_form_assets(): void {
	if ( ! is_page_template( 'page-templates/template-contact.php' ) ) {
		return;
	}

	wp_enqueue_script(
		'cbs-forms',
		CBS_URI . '/assets/js/forms.js',
		array(),
		CBS_VERSION,
		true
	);
	cbs_script_defer( 'cbs-forms' );

	wp_localize_script(
		'cbs-forms',
		'cbsContactAjax',
		array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'cbs_contact_nonce' ),
		)
	);
}

/**
 * Ajoute l’attribut defer via l’API Script (WordPress 6.3+).
 *
 * @param string $handle Handle du script.
 */
function cbs_script_defer( string $handle ): void {
	wp_script_add_data( $handle, 'strategy', 'defer' );
}

/**
 * Preload polices + image hero (performance.md §5).
 */
function cbs_preload_critical_assets(): void {
	echo '<link rel="preload" href="' . esc_url( CBS_URI . '/assets/fonts/CormorantGaramond-Regular.woff2' ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	echo '<link rel="preload" href="' . esc_url( CBS_URI . '/assets/fonts/Montserrat-Regular.woff2' ) . '" as="font" type="font/woff2" crossorigin>' . "\n";

	if ( is_front_page() ) {
		$hero = cbs_get_home_hero_media_urls();
		echo '<link rel="preload" href="' . esc_url( $hero['poster'] ) . '" as="image" fetchpriority="high">' . "\n";
	}
}
add_action( 'wp_head', 'cbs_preload_critical_assets', 1 );
