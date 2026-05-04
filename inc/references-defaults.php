<?php
/**
 * Valeurs par défaut — Page Références vitrine (`template-parts/references.php`).
 * Surchargées par `acf-json/group_cbs_page_references.json`.
 */
defined( 'ABSPATH' ) || exit;

/**
 * @return array<string, string>
 */
function cbs_references_page_defaults(): array {
	return array(
		'hero_kicker'       => __( 'RÉFÉRENCES', 'cbs-theme' ),
		'hero_title'        => __( 'Des projets spa hôteliers accompagnés de A à Z', 'cbs-theme' ),
		'hero_subtitle'     => __( 'Création, optimisation, gestion, staffing — auprès d\'hôtels 4 et 5 étoiles en Alsace et en France.', 'cbs-theme' ),
		'cta_label'         => __( 'Discuter de votre projet', 'cbs-theme' ),
		'stat_1_valeur'     => __( '+10 hôtels', 'cbs-theme' ),
		'stat_1_label'      => __( 'accompagnés depuis 2012', 'cbs-theme' ),
		'stat_2_valeur'     => __( '4★ et 5★', 'cbs-theme' ),
		'stat_2_label'      => __( 'uniquement', 'cbs-theme' ),
		'stat_3_valeur'     => __( 'Alsace & France', 'cbs-theme' ),
		'stat_3_label'      => __( 'zones d\'intervention', 'cbs-theme' ),
		'seo_heading'       => __( 'Accompagnement spa hôtelier : des références construites sur le terrain', 'cbs-theme' ),
		'seo_text'          =>
			__(
				"Chaque mission spa produit une empreinte concrète : dossiers de synthèse, listes partagées avec les opérationnels, plans de transfert lorsque vos équipes poursuivent en autonomie, et indicateurs suivis lorsque les données permettent un avant / après lisible. Ces traces relèvent du travail commun avec la direction et le terrain, pour que vos décisions hôtelières restent alignées avec les attentes d’un quatre ou cinq étoiles.\n\n".
				"La création d’un nouveau spa quatre étoiles ou la pérennisation d’un équipement existant passent par des arbitrages précis : ergonomie réelle du parcours, durées cohérentes avec vos prix affichés, rotations en cabine et stabilité des protocoles. La gestion d’un spa hôtelier suivie depuis l’Alsace ou étendue à d’autres sites en France commande les mêmes garde-fous — les gabarits théoriques se recalibrent, tout en préservant la confidentialité des échanges internes et des niveaux de performance que nous consolidons ensemble.\n\n".
				'Une référence spa hôtelière, lorsque l’accompagnement est mené avec un consultant spa expérimenté, anticipe les désalignements qui réapparaissent trop souvent : plannings, formations, saisonnalité du personnel, plutôt que de boucler une mission lorsque subsistent des zones fragiles. Les exemples donnés sur cette page illustrent ces problématiques ; aucun nom d’établissement ni aucun dossier nominatif sans accord explicite n’est communiqué, tout en garantissant des livrables exploitables et des résultats mesurables lorsque vos données le permettent.',
				'cbs-theme'
			),
		'seo_image'         => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&q=80',
		'citation'          => __( 'Chaque projet spa est unique. Ce qui les réunit : une exigence de résultat dès le premier jour d\'exploitation.', 'cbs-theme' ),
		'attribution'       => __( 'Camille Becht, fondatrice', 'cbs-theme' ),
	);
}

/**
 * Blocs grille bento — 3 lignes canoniques si le repeater ACF est vide.
 *
 * @return array<int, array<string, string>>
 */
function cbs_references_rep_default_rows(): array {
	return array(
		array(
			'ref_image'       => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800&q=80',
			'ref_badge'       => __( 'DIAGNOSTIC & CONCEPTION', 'cbs-theme' ),
			'ref_titre'       => __( 'Hôtel 5★ — Alsace', 'cbs-theme' ),
			'ref_description' => '',
			'ref_zone'        => __( 'Création de spa from scratch, assistance MOA', 'cbs-theme' ),
		),
		array(
			'ref_image'       => 'https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?w=800&q=80',
			'ref_badge'       => __( 'MISE EN PERFORMANCE', 'cbs-theme' ),
			'ref_titre'       => __( 'Resort 4★ — Alsace', 'cbs-theme' ),
			'ref_description' => '',
			'ref_zone'        => __( 'Audit et optimisation post-ouverture', 'cbs-theme' ),
		),
		array(
			'ref_image'       => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&q=80',
			'ref_badge'       => __( 'GESTION & STAFFING', 'cbs-theme' ),
			'ref_titre'       => __( 'Hôtel 4★ — Grand Est', 'cbs-theme' ),
			'ref_description' => '',
			'ref_zone'        => __( 'Gestion externalisée + renfort équipe', 'cbs-theme' ),
		),
	);
}

/**
 * Fusionne une ligne repeater avec les clés attendues ; image via URL média ACF.
 *
 * @param array<string, mixed> $row
 * @param array<string, string> $fallback
 * @return array{badge:string,titre:string,zone:string,image_url:string}
 */
function cbs_references_normalized_row( array $row, array $fallback ): array {
	$url = '';
	if ( isset( $row['ref_image'] ) ) {
		$url = cbs_acf_media_url( $row['ref_image'] );
	}

	return array(
		'badge'     => isset( $row['ref_badge'] ) && is_string( $row['ref_badge'] ) && $row['ref_badge'] !== ''
			? $row['ref_badge']
			: $fallback['ref_badge'],
		'titre'     => isset( $row['ref_titre'] ) && is_string( $row['ref_titre'] ) && $row['ref_titre'] !== ''
			? $row['ref_titre']
			: $fallback['ref_titre'],
		'zone'      => cbs_references_row_zone_label( $row, $fallback ),
		'image_url' => $url !== '' ? $url : $fallback['ref_image'],
	);
}

/**
 * Priorité champ zone (sous-titre court) puis description pour le pied de vignette.
 *
 * @param array<string, mixed> $row
 * @param array<string, string> $fallback
 */
function cbs_references_row_zone_label( array $row, array $fallback ): string {
	$z = isset( $row['ref_zone'] ) && is_string( $row['ref_zone'] ) ? trim( $row['ref_zone'] ) : '';
	if ( $z !== '' ) {
		return $z;
	}
	$d = isset( $row['ref_description'] ) && is_string( $row['ref_description'] ) ? trim( wp_strip_all_tags( $row['ref_description'] ) ) : '';
	if ( $d !== '' ) {
		return $d;
	}

	return $fallback['ref_zone'];
}

/**
 * Repère ACF `cbs_references` résolu avec défauts.
 *
 * @param mixed $rows
 * @return array<int, array{badge:string,titre:string,zone:string,image_url:string}>
 */
function cbs_references_items_resolved( $rows ): array {
	$fallbacks = cbs_references_rep_default_rows();
	$n         = count( $fallbacks );

	if ( ! is_array( $rows ) || $rows === array() ) {
		return array_map(
			static function ( array $fb ): array {
				return cbs_references_normalized_row( $fb, $fb );
			},
			$fallbacks
		);
	}

	$out = array();
	for ( $i = 0; $i < $n; $i++ ) {
		$fb       = $fallbacks[ $i ];
		$row_raw  = isset( $rows[ $i ] ) && is_array( $rows[ $i ] ) ? $rows[ $i ] : array();
		$merged   = array_merge(
			array(
				'ref_image'       => '',
				'ref_badge'       => '',
				'ref_titre'       => '',
				'ref_description' => '',
				'ref_zone'        => '',
			),
			$row_raw
		);
		$normalized = cbs_references_normalized_row( $merged, $fb );
		if ( $normalized['titre'] !== '' || $normalized['image_url'] !== '' || $normalized['badge'] !== '' ) {
			$out[] = $normalized;
		} else {
			$out[] = cbs_references_normalized_row( $fb, $fb );
		}
	}

	return $out;
}
