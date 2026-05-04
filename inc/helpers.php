<?php
/**
 * CBS Theme — helpers.php
 * Fonctions utilitaires partagées.
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL Calendly pour embed inline (ex. CTA accueil).
 * Définir `CBS_CALENDLY_INLINE_URL` dans wp-config.php ou utiliser le filtre `cbs_calendly_inline_url`.
 */
function cbs_get_calendly_inline_url(): string {
	if ( defined( 'CBS_CALENDLY_INLINE_URL' ) && CBS_CALENDLY_INLINE_URL ) {
		return (string) CBS_CALENDLY_INLINE_URL;
	}

	return (string) apply_filters( 'cbs_calendly_inline_url', '' );
}

/**
 * Environnement production (wp-config : CBS_ENV).
 */
function cbs_is_production(): bool {
	return defined( 'CBS_ENV' ) && CBS_ENV === 'production';
}

/**
 * Environnement développement (webhooks Make désactivés — environments.md §3).
 */
function cbs_is_development(): bool {
	return ! defined( 'CBS_ENV' ) || CBS_ENV === 'development';
}

/**
 * Journalise une erreur (sans données sensibles).
 *
 * @param string               $context Contexte (airtable, make_webhook…).
 * @param string               $message Message.
 * @param array<string, mixed> $data    Données contextuelles (sanitisées).
 */
function cbs_log_error( string $context, string $message, array $data = array() ): void {
	$strip_keys = array( 'email', 'telephone', 'api_key', 'webhook_url' );
	$safe_data  = array_diff_key( $data, array_flip( $strip_keys ) );

	$log_entry = sprintf(
		'[CBS][%s][%s] %s | Data: %s',
		strtoupper( $context ),
		current_time( 'Y-m-d H:i:s' ),
		$message,
		wp_json_encode( $safe_data )
	);

	error_log( $log_entry );
}

/**
 * Détecte un plugin SEO courant (évite les doublons de balises / JSON-LD).
 */
function cbs_has_seo_plugin(): bool {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' );
}

/**
 * Extrait une URL depuis un champ ACF image/fichier (url ou tableau).
 *
 * @param mixed $value Valeur brute get_field().
 * @return string URL ou chaîne vide.
 */
function cbs_acf_media_url( $value ): string {
	if ( is_string( $value ) && $value !== '' ) {
		return $value;
	}
	if ( is_array( $value ) && ! empty( $value['url'] ) ) {
		return (string) $value['url'];
	}

	return '';
}

/**
 * ID de la page d’accueil (page statique ou requête courante).
 */
function cbs_get_home_hero_page_id(): int {
	$post_id = (int) get_queried_object_id();
	if ( $post_id <= 0 ) {
		$post_id = (int) get_option( 'page_on_front' );
	}

	return $post_id;
}

/**
 * Médias du hero accueil : champs ACF « CBS — Page Accueil » ou fichiers par défaut du thème.
 *
 * @return array{poster: string, video: string}
 */
function cbs_get_home_hero_media_urls(): array {
	$defaults = array(
		'poster' => CBS_URI . '/assets/images/hero-home.webp',
		'video'  => CBS_URI . '/assets/videos/hero-home.mp4',
	);

	$post_id = cbs_get_home_hero_page_id();
	if ( $post_id <= 0 || ! function_exists( 'get_field' ) ) {
		return $defaults;
	}

	$image_only = (bool) get_field( 'cbs_accueil_hero_image_seule', $post_id );
	$poster_acf = cbs_acf_media_url( get_field( 'cbs_accueil_hero_poster', $post_id ) );
	$video_acf  = cbs_acf_media_url( get_field( 'cbs_accueil_hero_video', $post_id ) );

	$poster = $poster_acf !== '' ? $poster_acf : $defaults['poster'];
	if ( $image_only ) {
		return array(
			'poster' => $poster,
			'video'  => '',
		);
	}

	$video = $video_acf !== '' ? $video_acf : $defaults['video'];

	return array(
		'poster' => $poster,
		'video'  => $video,
	);
}

/**
 * Carte title / meta description statique (seo.md §3).
 *
 * @return array<string, array{title: string, description: string}>
 */
function cbs_get_static_page_meta_map(): array {
	static $map = null;
	if ( $map === null ) {
		$loaded = require CBS_DIR . '/inc/seo-meta-map.php';
		$map    = is_array( $loaded ) ? $loaded : array();
	}
	return $map;
}

/**
 * Meta description pour un contenu singulier (extrait ou extrait généré).
 */
function cbs_seo_singular_meta_description( int $post_id ): string {
	$excerpt = (string) get_post_field( 'post_excerpt', $post_id );
	if ( $excerpt !== '' ) {
		return wp_strip_all_tags( $excerpt );
	}
	$content = (string) get_post_field( 'post_content', $post_id );
	return wp_trim_words( wp_strip_all_tags( $content ), 24, '…' );
}

/**
 * Meta title/description pour les archives CPT concernées.
 *
 * @param array<string, array{title: string, description: string}> $map
 * @param array{title: string, description: string}                 $empty
 * @return array{title: string, description: string}|null
 */
function cbs_get_page_meta_archives( array $map, array $empty ): ?array {
	if ( is_post_type_archive( 'etude-de-cas' ) ) {
		return $map['etudes-de-cas'] ?? $empty;
	}
	if ( is_post_type_archive( 'produit-pro' ) ) {
		$obj   = get_post_type_object( 'produit-pro' );
		$label = $obj && isset( $obj->labels->archives ) ? $obj->labels->archives : __( 'Boutique pros', 'cbs-theme' );
		return array(
			'title'       => sprintf( '%s | Camille Becht', $label ),
			'description' => get_bloginfo( 'description', 'display' ),
		);
	}
	return null;
}

/**
 * Meta pour les contenus singuliers CPT étude-de-cas / produit-pro.
 *
 * @return array{title: string, description: string}|null
 */
function cbs_get_page_meta_singular_cpts(): ?array {
	if ( is_singular( 'etude-de-cas' ) ) {
		return array(
			'title'       => sprintf( '%s — Références | Camille Becht', get_the_title() ),
			'description' => cbs_seo_singular_meta_description( get_queried_object_id() ),
		);
	}
	if ( is_singular( 'produit-pro' ) ) {
		return array(
			'title'       => sprintf( '%s | Boutique pros | Camille Becht', get_the_title() ),
			'description' => cbs_seo_singular_meta_description( get_queried_object_id() ),
		);
	}
	return null;
}

/**
 * Meta pour pages hiérarchiques + page des articles.
 *
 * @param array<string, array{title: string, description: string}> $map
 * @return array{title: string, description: string}|null
 */
function cbs_get_page_meta_pages_and_blog( array $map ): ?array {
	if ( is_page() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			$uri = get_page_uri( $post );
			if ( isset( $map[ $uri ] ) ) {
				return $map[ $uri ];
			}
			$excerpt = has_excerpt( $post ) ? get_the_excerpt( $post ) : '';
			$desc    = $excerpt ? wp_strip_all_tags( $excerpt ) : '';
			return array(
				'title'       => sprintf( '%s | Camille Becht', get_the_title( $post ) ),
				'description' => $desc,
			);
		}
	}
	if ( is_home() && ! is_front_page() ) {
		$posts_page = (int) get_option( 'page_for_posts' );
		if ( $posts_page ) {
			$excerpt = has_excerpt( $posts_page ) ? get_the_excerpt( $posts_page ) : '';
			return array(
				'title'       => sprintf( '%s | Camille Becht', get_the_title( $posts_page ) ),
				'description' => $excerpt ? wp_strip_all_tags( $excerpt ) : get_bloginfo( 'description', 'display' ),
			);
		}
	}
	return null;
}

/**
 * Title et meta description pour la requête courante (seo.md §3).
 *
 * @return array{title: string, description: string}
 */
function cbs_get_page_meta(): array {
	$empty = array(
		'title'       => '',
		'description' => '',
	);
	$map   = cbs_get_static_page_meta_map();

	if ( is_front_page() ) {
		return array(
			'title'       => 'Consultant Spa Hôtelier — Création & Gestion | Camille Becht',
			'description' => 'J\'accompagne les hôtels 4★ et 5★ dans la création et la gestion de spas rentables. Expertise terrain, méthode éprouvée. France entière.',
		);
	}

	$archives = cbs_get_page_meta_archives( $map, $empty );
	if ( $archives !== null ) {
		return $archives;
	}

	$cpts = cbs_get_page_meta_singular_cpts();
	if ( $cpts !== null ) {
		return $cpts;
	}

	$pages = cbs_get_page_meta_pages_and_blog( $map );
	if ( $pages !== null ) {
		return $pages;
	}

	if ( is_singular() ) {
		return array(
			'title'       => sprintf( '%s | Camille Becht', get_the_title() ),
			'description' => cbs_seo_singular_meta_description( get_queried_object_id() ),
		);
	}

	return $empty;
}

/**
 * URL canonique courante pour Open Graph.
 */
function cbs_get_og_canonical_url(): string {
	if ( is_front_page() ) {
		return trailingslashit( home_url( '/' ) );
	}

	if ( is_singular() ) {
		$p = get_permalink();
		return $p ? $p : home_url( '/' );
	}

	if ( is_post_type_archive() ) {
		$pt = get_query_var( 'post_type' );
		if ( is_array( $pt ) ) {
			$pt = reset( $pt );
		}
		if ( is_string( $pt ) && $pt !== '' ) {
			$link = get_post_type_archive_link( $pt );
			if ( $link ) {
				return $link;
			}
		}
	}

	global $wp;
	if ( $wp instanceof WP && is_string( $wp->request ) && $wp->request !== '' ) {
		return home_url( user_trailingslashit( $wp->request ) );
	}

	return home_url( '/' );
}

/**
 * Fil d’Ariane : branche archive CPT.
 *
 * @param array<int, array{name: string, url: string}> $items
 * @return array<int, array{name: string, url: string}>|null
 */
function cbs_breadcrumb_items_cpt_archive( array $items, string $post_type, string $label ): ?array {
	if ( ! is_post_type_archive( $post_type ) ) {
		return null;
	}
	$link = get_post_type_archive_link( $post_type );
	if ( $link ) {
		$items[] = array(
			'name' => $label,
			'url'  => $link,
		);
	}
	return $items;
}

/**
 * Fil d’Ariane : single CPT avec archive.
 *
 * @param array<int, array{name: string, url: string}> $items
 * @return array<int, array{name: string, url: string}>|null
 */
function cbs_breadcrumb_items_cpt_singular( array $items, string $post_type, string $label ): ?array {
	if ( ! is_singular( $post_type ) ) {
		return null;
	}
	$archive = get_post_type_archive_link( $post_type );
	if ( $archive ) {
		$items[] = array(
			'name' => $label,
			'url'  => $archive,
		);
	}
	$items[] = array(
		'name' => get_the_title(),
		'url'  => get_permalink() ?: '',
	);
	return $items;
}

/**
 * Éléments fil d’Ariane pour JSON-LD (hors page d’accueil).
 *
 * @return array<int, array{name: string, url: string}>
 */
function cbs_get_breadcrumb_items(): array {
	$items = array(
		array(
			'name' => __( 'Accueil', 'cbs-theme' ),
			'url'  => home_url( '/' ),
		),
	);

	if ( is_front_page() ) {
		return $items;
	}

	$branch = cbs_breadcrumb_items_cpt_singular( $items, 'etude-de-cas', __( 'Références', 'cbs-theme' ) );
	if ( $branch !== null ) {
		return $branch;
	}

	$branch = cbs_breadcrumb_items_cpt_singular( $items, 'produit-pro', __( 'Boutique pros', 'cbs-theme' ) );
	if ( $branch !== null ) {
		return $branch;
	}

	$branch = cbs_breadcrumb_items_cpt_archive( $items, 'etude-de-cas', __( 'Références', 'cbs-theme' ) );
	if ( $branch !== null ) {
		return $branch;
	}

	$branch = cbs_breadcrumb_items_cpt_archive( $items, 'produit-pro', __( 'Boutique pros', 'cbs-theme' ) );
	if ( $branch !== null ) {
		return $branch;
	}

	return cbs_breadcrumb_items_remaining( $items );
}

/**
 * Fil d’Ariane : pages WordPress hiérarchiques.
 *
 * @param array<int, array{name: string, url: string}> $items
 * @return array<int, array{name: string, url: string}>|null
 */
function cbs_breadcrumb_items_hierarchical_page( array $items ): ?array {
	if ( ! is_page() || is_front_page() ) {
		return null;
	}
	global $post;
	if ( ! $post instanceof WP_Post ) {
		return $items;
	}
	$ancestors = array_reverse( get_post_ancestors( $post ) );
	foreach ( $ancestors as $ancestor_id ) {
		$items[] = array(
			'name' => get_the_title( $ancestor_id ),
			'url'  => get_permalink( $ancestor_id ) ?: '',
		);
	}
	$items[] = array(
		'name' => get_the_title( $post ),
		'url'  => get_permalink( $post ) ?: '',
	);
	return $items;
}

/**
 * Pages hiérarchiques, singuliers génériques, blog, taxonomies.
 *
 * @param array<int, array{name: string, url: string}> $items
 * @return array<int, array{name: string, url: string}>
 */
function cbs_breadcrumb_items_remaining( array $items ): array {
	$page = cbs_breadcrumb_items_hierarchical_page( $items );
	if ( $page !== null ) {
		return $page;
	}

	if ( is_singular() ) {
		$items[] = array(
			'name' => get_the_title(),
			'url'  => get_permalink() ?: '',
		);
		return $items;
	}

	if ( is_home() && ! is_front_page() ) {
		$pforposts = (int) get_option( 'page_for_posts' );
		if ( $pforposts ) {
			$items[] = array(
				'name' => get_the_title( $pforposts ),
				'url'  => get_permalink( $pforposts ) ?: '',
			);
		}
		return $items;
	}

	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$tlink = get_term_link( $term );
			$items[] = array(
				'name' => $term->name,
				'url'  => ! is_wp_error( $tlink ) ? $tlink : '',
			);
		}
		return $items;
	}

	return $items;
}

/**
 * Schema.org ProfessionalService — toutes les pages (seo.md §5).
 */
function cbs_schema_organization(): void {
	if ( cbs_has_seo_plugin() ) {
		return;
	}

	$schema = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'ProfessionalService',
		'name'          => 'Conseil & Gestion des rituels du spa by Camille Becht',
		'url'           => home_url( '/' ),
		'logo'          => CBS_URI . '/assets/images/logo.svg',
		'description'   => 'Conseil, création et gestion de spas hôteliers 4★ et 5★.',
		'areaServed'    => array(
			array( '@type' => 'Country', 'name' => 'France' ),
			array( '@type' => 'AdministrativeArea', 'name' => 'Alsace' ),
		),
		'founder'       => array(
			'@type' => 'Person',
			'name'  => 'Camille Becht',
		),
	);

	$same_as = apply_filters( 'cbs_schema_same_as', array() );
	$same_as = array_values( array_filter( array_map( 'esc_url_raw', (array) $same_as ) ) );
	if ( $same_as !== array() ) {
		$schema['sameAs'] = $same_as;
	}

	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
	);
}
add_action( 'wp_head', 'cbs_schema_organization', 5 );

/**
 * Open Graph + Twitter Card — sans plugin SEO (seo.md §6).
 */
function cbs_open_graph_tags(): void {
	if ( cbs_has_seo_plugin() ) {
		return;
	}

	$meta        = cbs_get_page_meta();
	$title       = $meta['title'] !== '' ? $meta['title'] : wp_get_document_title();
	$description = $meta['description'] !== '' ? $meta['description'] : get_bloginfo( 'description', 'display' );
	$image       = CBS_URI . '/assets/images/og-default.jpg';

	if ( is_singular() && has_post_thumbnail() ) {
		$thumb = get_the_post_thumbnail_url( null, 'cbs-og' );
		if ( ! is_string( $thumb ) || $thumb === '' ) {
			$thumb = get_the_post_thumbnail_url( null, 'large' );
		}
		if ( is_string( $thumb ) && $thumb !== '' ) {
			$image = $thumb;
		}
	}

	$url = cbs_get_og_canonical_url();

	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:locale" content="fr_FR">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}
add_action( 'wp_head', 'cbs_open_graph_tags', 7 );

/**
 * Schema BreadcrumbList — toutes les pages sauf l’accueil (seo.md §5).
 */
function cbs_breadcrumb_schema(): void {
	if ( cbs_has_seo_plugin() ) {
		return;
	}

	if ( is_front_page() ) {
		return;
	}

	$raw   = cbs_get_breadcrumb_items();
	$list  = array();
	$pos   = 1;

	foreach ( $raw as $item ) {
		if ( empty( $item['url'] ) ) {
			continue;
		}
		$list[] = array(
			'@type'    => 'ListItem',
			'position' => $pos,
			'name'     => wp_strip_all_tags( (string) $item['name'] ),
			'item'     => esc_url_raw( $item['url'] ),
		);
		++$pos;
	}

	if ( count( $list ) < 2 ) {
		return;
	}

	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $list,
	);

	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
	);
}
add_action( 'wp_head', 'cbs_breadcrumb_schema', 6 );

/**
 * En-têtes HTTP de sécurité (security.md §5).
 *
 * @param array<string, string> $headers En-têtes envoyés par WordPress.
 * @return array<string, string>
 */
function cbs_security_headers( array $headers ): array {
	$headers['X-Content-Type-Options'] = 'nosniff';
	$headers['X-Frame-Options']      = 'SAMEORIGIN';
	$headers['X-XSS-Protection']     = '1; mode=block';
	$headers['Referrer-Policy']       = 'strict-origin-when-cross-origin';
	$headers['Permissions-Policy']    = 'camera=(), microphone=(), geolocation=()';
	$headers['Content-Security-Policy'] = implode(
		'; ',
		array(
			"default-src 'self'",
			"script-src 'self' 'unsafe-inline' https://assets.calendly.com",
			"style-src 'self' 'unsafe-inline'",
			"img-src 'self' data: https:",
			"font-src 'self' data:",
			"connect-src 'self' https://api.airtable.com https://*.make.com",
			'frame-src https://calendly.com',
		)
	);

	return $headers;
}
add_filter( 'wp_headers', 'cbs_security_headers' );
