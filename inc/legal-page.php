<?php
/**
 * CBS Theme — pages légales (CGU, mentions, confidentialité).
 *
 * @package CBS_Theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Libellé de date « dernière mise à jour » : ACF `last_updated`, meta `last_updated`, sinon date de modification du post.
 *
 * @param int $post_id ID de la page.
 * @return string
 */
function cbs_legal_get_last_updated_display( int $post_id ): string {
	if ( function_exists( 'get_field' ) ) {
		$acf = get_field( 'last_updated', $post_id );
		if ( is_string( $acf ) && $acf !== '' ) {
			return $acf;
		}
	}

	$meta = get_post_meta( $post_id, 'last_updated', true );
	if ( is_string( $meta ) && $meta !== '' ) {
		return $meta;
	}

	return (string) get_the_modified_date( 'd/m/Y', $post_id );
}

/**
 * Applique `the_content`, ajoute des IDs aux h2 s’il manquent, retourne le HTML et la liste des sections.
 *
 * @param string $raw_content Contenu brut du post.
 * @return array{html: string, headings: array<int, array{id: string, text: string}>}
 */
function cbs_legal_prepare_content( string $raw_content ): array {
	$html = apply_filters( 'the_content', $raw_content );

	$headings = array();
	$used_ids = array();
	$index    = 0;

	if ( ! is_string( $html ) || $html === '' || ! preg_match( '/<h2[\s>]/i', $html ) ) {
		return array(
			'html'     => is_string( $html ) ? $html : '',
			'headings' => array(),
		);
	}

	$replaced = preg_replace_callback(
		'/<h2(\s[^>]*)?>(.*?)<\/h2>/is',
		static function ( array $m ) use ( &$headings, &$used_ids, &$index ): string {
			++$index;
			$attr_raw = isset( $m[1] ) ? trim( $m[1] ) : '';
			$inner    = $m[2];

			$text = wp_strip_all_tags( $inner );
			$text = html_entity_decode( $text, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
			$text = trim( preg_replace( '/\s+/u', ' ', $text ) );

			if ( preg_match( '/\sid\s*=\s*([\'"])([^\'"]*)\1/', $attr_raw, $id_match ) && $id_match[2] !== '' ) {
				$id = $id_match[2];
				if ( ! in_array( $id, $used_ids, true ) ) {
					$used_ids[] = $id;
				}
			} else {
				$slug = sanitize_title( $text );
				if ( $slug === '' ) {
					$slug = 'section-' . $index;
				}
				$base = $slug;
				$n    = 2;
				while ( in_array( $slug, $used_ids, true ) ) {
					$slug = $base . '-' . $n;
					++$n;
				}
				$used_ids[] = $slug;
				$id         = $slug;
				$attr_raw  .= ( $attr_raw !== '' ? ' ' : '' ) . 'id="' . esc_attr( $id ) . '"';
			}

			$headings[] = array(
				'id'   => $id,
				'text' => $text !== '' ? $text : __( '(Sans titre)', 'cbs-theme' ),
			);

			return '<h2' . ( $attr_raw !== '' ? ' ' . $attr_raw : '' ) . '>' . $inner . '</h2>';
		},
		$html
	);

	return array(
		'html'     => is_string( $replaced ) ? $replaced : $html,
		'headings' => $headings,
	);
}
