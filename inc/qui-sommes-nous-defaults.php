<?php
/**
 * Valeurs par défaut — Page Qui sommes-nous (`template-parts/offres/qui-sommes-nous.php`).
 *
 * @package CBS_Theme
 */
defined( 'ABSPATH' ) || exit;

/**
 * Chiffres clés (bandeau) si le repeater ACF est vide.
 *
 * @return array<int, array<string, string>>
 */
function cbs_qsn_default_chiffres(): array {
	return array(
		array(
			'cbs_qsn_chiffre_valeur'  => '2012',
			'cbs_qsn_chiffre_libelle' => __( 'Année de création de l’entreprise', 'cbs-theme' ),
		),
		array(
			'cbs_qsn_chiffre_valeur'  => '+13 ans',
			'cbs_qsn_chiffre_libelle' => __( 'D’expertise en spa hôtelier haut de gamme', 'cbs-theme' ),
		),
		array(
			'cbs_qsn_chiffre_valeur'  => __( '4★ et 5★', 'cbs-theme' ),
			'cbs_qsn_chiffre_libelle' => __( 'Hôtels uniquement', 'cbs-theme' ),
		),
	);
}

/**
 * Bloc valeurs (repeater) si ACF vide.
 *
 * @return array<int, array<string, string>>
 */
function cbs_qsn_default_valeurs(): array {
	return array(
		array(
			'cbs_qsn_valeur_titre' => __( 'L’exigence du terrain', 'cbs-theme' ),
			'cbs_qsn_valeur_texte' => __(
				'Nous connaissons la réalité opérationnelle d’un spa hôtelier : cadences de cabine, stocks, équipes, flux clients et contraintes techniques. D’où l’arbitrage constant entre un espace pensé pour séduire sur un plan et un spa pensé pour durer au quotidien, tenir les protocoles et soutenir le modèle économique de l’hôtel.',
				'cbs-theme'
			),
		),
		array(
			'cbs_qsn_valeur_titre' => __( 'La transmission', 'cbs-theme' ),
			'cbs_qsn_valeur_texte' => __(
				'La formation est le prolongement naturel de l’expertise terrain : par l’Académie des Rituels du Spa, nous portons plus loin le niveau d’exigence attendu des praticiens du très haut de gamme. Il s’agit d’outiller des gestes précis, une tenue de poste irréprochable et une lecture juste des attentes d’une clientèle hôtelière pressée et avertie.',
				'cbs-theme'
			),
		),
		array(
			'cbs_qsn_valeur_titre' => __( 'La discrétion', 'cbs-theme' ),
			'cbs_qsn_valeur_texte' => __(
				'Les établissements partenaires nous confient des enjeux commerciaux et humains sensibles : nous traitons ces sujets avec une confidentialité stricte, sans communication opportuniste sur les noms ou les dossiers. La relation de confiance sur le long terme prime ; elle permet d’aller plus profondément dans le diagnostic et les plans d’action.',
				'cbs-theme'
			),
		),
	);
}

/**
 * Bio WYSIWYG par défaut (~150 mots).
 */
function cbs_qsn_default_bio_html(): string {
	return wp_kses_post(
		wpautop(
			__(
				'Le parcours de Camille Becht s’inscrit d’abord dans un voyage initiatique à Londres : praticienne auprès de hauts dirigeants, elle y affûte une exigence de gestuelle, de relation et de calendrier propres au très haut de gamme anglo-saxon. Le retour en Alsace marque une maturation : en 2012, elle crée l’entreprise et relie conseil, formation et opérationnels autour d’une vision complète du spa hôtelier. Le socle académique — Bachelor Spa à l’école Élysées Marbeuf Strasbourg — est prolongé par des formations avancées en Thaïlande, à l’école ITM de Chiang Mai (massage thaï, niveaux 1 à 4), pour intégrer des protocoles et une précision corporelle reconnues mondialement. De cette double lecture — exigence européenne et immersion technique en Asie — naît un concept spa global haut de gamme : du diagnostic à la formation des équipes et à la structuration des rituels, chaque brique dialogue avec le terrain des hôtels 4 et 5 étoiles que l’entreprise accompagne.',
				'cbs-theme'
			)
		)
	);
}

/**
 * Texte bloc Académie / écosystème (~80 mots), affiché si aucun contenu éditorial additionnel.
 */
function cbs_qsn_default_academie_intro_html(): string {
	return wp_kses_post(
		wpautop(
			__(
				'L’entreprise s’articule autour de trois pôles : le conseil et la création de spas hôteliers (Gestion des Rituels du Spa), la formation des praticiens haut de gamme (Académie des Rituels du Spa), et les soins à domicile. Cet écosystème couvre l’ensemble de la chaîne de valeur du spa de luxe — de la faisabilité et du cahier des charges aux équipes sur le plateau technique et au suivi des performances. Une même exigence relie ces briques : la cohérence entre promesse hôtelière, réalité opérationnelle et niveau de service attendu en 4★ et 5★.',
				'cbs-theme'
			)
		)
	);
}

/**
 * URL placeholder portrait bio.
 */
function cbs_qsn_placeholder_bio_image(): string {
	return 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=800&q=80';
}

/**
 * URL placeholder visuel Académie / spa.
 */
function cbs_qsn_placeholder_academie_image(): string {
	return 'https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?w=800&q=80';
}

/**
 * URL affichable pour un champ ACF image (URL, tableau ou ID).
 *
 * @param mixed $acf_val Valeur get_field().
 */
function cbs_qsn_image_src( $acf_val, string $fallback ): string {
	$url = cbs_acf_media_url( $acf_val );
	if ( $url !== '' ) {
		return $url;
	}
	if ( is_array( $acf_val ) && ! empty( $acf_val['ID'] ) ) {
		$u = wp_get_attachment_image_url( (int) $acf_val['ID'], 'large' );
		if ( is_string( $u ) && $u !== '' ) {
			return $u;
		}
	}
	if ( is_numeric( $acf_val ) ) {
		$u = wp_get_attachment_image_url( (int) $acf_val, 'large' );
		if ( is_string( $u ) && $u !== '' ) {
			return $u;
		}
	}
	return $fallback;
}

/**
 * Texte alternatif pour un champ ACF image.
 *
 * @param mixed $acf_val Valeur get_field().
 */
function cbs_qsn_image_alt( $acf_val, string $fallback ): string {
	if ( is_array( $acf_val ) && ! empty( $acf_val['ID'] ) ) {
		$alt = get_post_meta( (int) $acf_val['ID'], '_wp_attachment_image_alt', true );
		if ( is_string( $alt ) && $alt !== '' ) {
			return $alt;
		}
	}
	if ( is_numeric( $acf_val ) ) {
		$alt = get_post_meta( (int) $acf_val, '_wp_attachment_image_alt', true );
		if ( is_string( $alt ) && $alt !== '' ) {
			return $alt;
		}
	}
	return $fallback;
}
