<?php
/**
 * CBS Theme — functions.php
 * Point d'entrée. N'écrit aucune logique ici, tout est dans /inc/
 */

defined( 'ABSPATH' ) || exit;

// Constantes du thème
define( 'CBS_VERSION', '1.0.0' );
define( 'CBS_DIR', get_template_directory() );
define( 'CBS_URI', get_template_directory_uri() );

// Inclusions (helpers avant setup : meta title / SEO dans setup.php).
require_once CBS_DIR . '/inc/helpers.php';
require_once CBS_DIR . '/inc/setup.php';
require_once CBS_DIR . '/inc/enqueue.php';
require_once CBS_DIR . '/inc/cpt.php';
require_once CBS_DIR . '/inc/cpt-partners.php';
require_once CBS_DIR . '/inc/taxonomies.php';
require_once CBS_DIR . '/inc/menus.php';
require_once CBS_DIR . '/inc/widgets.php';
require_once CBS_DIR . '/inc/acf-fields.php';
require_once CBS_DIR . '/inc/api-airtable.php';
require_once CBS_DIR . '/inc/ajax.php';
require_once CBS_DIR . '/inc/shortcodes.php';
require_once CBS_DIR . '/inc/offres-conseil-defaults.php';
require_once CBS_DIR . '/inc/offres-gestion-defaults.php';
