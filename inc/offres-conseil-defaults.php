<?php
/**
 * CBS Theme — contenus par défaut « Méthode Spa Profit™ » (content-structure.md §3).
 * Surchargés par les champs ACF du groupe « CBS — Pages Offres Conseil ».
 */
defined( 'ABSPATH' ) || exit;

/**
 * @return array<string, mixed>
 */
function cbs_offres_methode_hub_defaults(): array {
	return array(
		'hero_kicker'          => __( 'Pôle Conseil & Création', 'cbs-theme' ),
		'hero_title'           => __( 'La Méthode Spa Profit™', 'cbs-theme' ),
		'hero_subtitle'        => __( 'Concevoir des spas hôteliers pensés pour l\'exploitation et la rentabilité — par une consultante spa avec 13 ans de terrain.', 'cbs-theme' ),
		'hero_cta_label'       => __( 'Voir les 3 niveaux d\'accompagnement', 'cbs-theme' ),
		'position_title'       => __( 'Un spa réussi ne repose pas uniquement sur un beau design', 'cbs-theme' ),
		'position_text'        => __( "La plupart des projets spa sont conçus par des architectes ou des designers sans expertise d'exploitation. Résultat : ergonomie des cabines négligée, gestion des flux non anticipée, offre inadaptée à la clientèle hôtelière. Ces erreurs coûtent entre 50 000 et 100 000 € en travaux correctifs — sans compter les pertes d'exploitation les premières années.", 'cbs-theme' ),
		'quote'                => __( 'Je conçois les spas comme ils doivent être exploités, pas seulement comme ils doivent être dessinés.', 'cbs-theme' ),
		'cta_final_title'      => __( 'Discutons de votre projet spa', 'cbs-theme' ),
		'cta_final_text'       => __( 'Chaque projet est unique. Je vous propose un premier échange pour comprendre vos enjeux et voir comment je peux vous accompagner.', 'cbs-theme' ),
		'cta_final_btn'        => __( 'Prendre rendez-vous', 'cbs-theme' ),
		'niveaux_cards'        => array(
			array(
				'kicker'    => __( 'Niveau 1 — Diagnostic stratégique spa · Offre d\'entrée', 'cbs-theme' ),
				'title'     => __( 'Diagnostic stratégique spa', 'cbs-theme' ),
				'duration'  => __( '1 à 3 mois', 'cbs-theme' ),
				'objective' => __( 'Comprendre le potentiel de votre spa hôtelier, identifier les risques de conception et définir la stratégie d\'exploitation avant les travaux.', 'cbs-theme' ),
				'obtenez'   => __( 'Rapport d\'audit écrit, cartographie des risques, plan d\'action priorisé.', 'cbs-theme' ),
				'url'       => home_url( '/diagnostic-strategique/' ),
			),
			array(
				'kicker'    => __( 'Niveau 2 — Conception & sécurisation du projet · Offre principale', 'cbs-theme' ),
				'title'     => __( 'Conception & sécurisation du projet', 'cbs-theme' ),
				'duration'  => __( '6 à 12 mois', 'cbs-theme' ),
				'objective' => __( 'Accompagnement complet du projet spa hôtelier — de la stratégie à la préparation de l\'exploitation, en coordination avec architectes et direction.', 'cbs-theme' ),
				'obtenez'   => __( 'Dossier technique complet, brief prestataires, plan de lancement opérationnel.', 'cbs-theme' ),
				'url'       => home_url( '/conception-securisation/' ),
			),
			array(
				'kicker'    => __( 'Niveau 3 — Mise en performance du spa · Offre premium', 'cbs-theme' ),
				'title'     => __( 'Mise en performance du spa', 'cbs-theme' ),
				'duration'  => __( '3 à 6 mois', 'cbs-theme' ),
				'objective' => __( 'Transformer votre spa existant en vrai centre de profit : optimisation des process, de l\'offre et des indicateurs de performance.', 'cbs-theme' ),
				'obtenez'   => __( 'Tableau de bord KPI, protocoles opérationnels, plan de montée en charge.', 'cbs-theme' ),
				'url'       => home_url( '/mise-en-performance/' ),
			),
		),
	);
}

/**
 * @return array<string, mixed>
 */
function cbs_offres_niveau_1_defaults(): array {
	return array(
		'hero_kicker'       => __( 'Niveau 1 — Offre d\'entrée', 'cbs-theme' ),
		'hero_title'        => __( 'Diagnostic stratégique spa', 'cbs-theme' ),
		'hero_subtitle'     => __( 'Avant d\'investir, comprendre. Avant de construire, sécuriser. Le diagnostic spa pose les fondations d\'un projet rentable.', 'cbs-theme' ),
		'prestations_intro' => __( 'Chaque projet spa est unique. Le diagnostic stratégique permet d\'analyser votre situation avec précision avant toute décision d\'investissement.', 'cbs-theme' ),
		'prestations'       => array(
			__( 'Analyse du positionnement de l\'hôtel et de sa clientèle', 'cbs-theme' ),
			__( 'Analyse du marché bien-être local et concurrentiel', 'cbs-theme' ),
			__( 'Identification des opportunités de différenciation', 'cbs-theme' ),
			__( 'Recommandations stratégiques pour le développement du spa', 'cbs-theme' ),
			__( 'Définition des orientations conceptuelles du projet', 'cbs-theme' ),
		),
		'livrables'     => array(
			__( 'Note de diagnostic stratégique', 'cbs-theme' ),
			__( 'Recommandations de développement du spa', 'cbs-theme' ),
		),
		'resultat'          => __( "Un plan clair pour éviter les erreurs de conception et d'exploitation.\n\nVous identifiez à temps les erreurs de positionnement et de cadrage marché, avant qu'elles ne figent le projet.\n\nVous validez une stratégie spa viable, alignée avec votre clientèle hôtelière et votre territoire.\n\nVous repartez avec un plan d'action concret pour la suite : conception, offre et lancement.", 'cbs-theme' ),
		'pour_qui'          => array(
			__( 'Hôtel qui envisage de créer un spa', 'cbs-theme' ),
			__( 'Hôtel dont le spa sous-performe', 'cbs-theme' ),
			__( 'Investisseur qui sécurise son projet', 'cbs-theme' ),
		),
		'cta_label'         => __( 'Discuter de votre diagnostic', 'cbs-theme' ),
	);
}

/**
 * @return array<int, array<string, mixed>>
 */
function cbs_offres_niveau_2_phases_defaults(): array {
	return array(
		array(
			'title'     => __( 'Phase 1 — Diagnostic stratégique (cf. Niveau 1)', 'cbs-theme' ),
			'intro'     => __( 'Même logique que le Niveau 1 : analyser positionnement hôtel, marché bien-être local, différenciation et orientations conceptuelles avant de verrouiller plans et budgets.', 'cbs-theme' ),
			'items'     => array(),
			'livrables' => '',
		),
		array(
			'title' => __( 'Phase 2 — Conception fonctionnelle de l\'espace spa', 'cbs-theme' ),
			'intro' => __( 'Étude des plans, optimisation du parcours client, implantation cabines et zones humides, ergonomie, acoustique et ambiance : on traduit la stratégie en espace réellement exploitable au quotidien.', 'cbs-theme' ),
			'items' => array(
				__( 'Étude des plans architecturaux', 'cbs-theme' ),
				__( 'Optimisation du parcours client', 'cbs-theme' ),
				__( 'Recommandations d\'implantation : cabines, zones humides, espaces détente, zones techniques', 'cbs-theme' ),
				__( 'Recommandations sur l\'ergonomie des cabines', 'cbs-theme' ),
				__( 'Préconisations acoustiques et ambiance sensorielle', 'cbs-theme' ),
			),
			'livrables' => __( 'Livrables : dossier de recommandations fonctionnelles + plans annotés', 'cbs-theme' ),
		),
		array(
			'title' => __( 'Phase 3 — Coordination projet avec la maîtrise d\'œuvre', 'cbs-theme' ),
			'intro' => __( 'Participation aux réunions projet, échanges avec l\'architecte, validation des choix techniques liés à l\'exploitation et aux équipements spa : les arbitrages restent alignés avec la réalité terrain.', 'cbs-theme' ),
			'items' => array(
				__( 'Participation aux réunions projet', 'cbs-theme' ),
				__( 'Échanges avec l\'architecte', 'cbs-theme' ),
				__( 'Validation des choix techniques liés à l\'exploitation', 'cbs-theme' ),
				__( 'Recommandations sur les équipements spa', 'cbs-theme' ),
				__( 'Ajustements fonctionnels en phase conception', 'cbs-theme' ),
			),
			'livrables' => '',
		),
		array(
			'title' => __( 'Phase 4 — Suivi de chantier spa (3 visites incluses)', 'cbs-theme' ),
			'intro' => __( 'Vérification des cabines, équipements, espaces techniques et zones clients sur site : repérer les écarts avant livraison pour limiter les coûts de correction (souvent 50 000 à 100 000 € quand le spa est mal conçu).', 'cbs-theme' ),
			'items' => array(
				__( 'Vérification de l\'implantation des cabines et équipements', 'cbs-theme' ),
				__( 'Validation des espaces techniques et zones clients', 'cbs-theme' ),
				__( 'Recommandations d\'ajustement si nécessaire', 'cbs-theme' ),
			),
			'livrables' => '',
		),
		array(
			'title' => __( 'Phase 5 — Sélection équipements, mobilier et consommables', 'cbs-theme' ),
			'intro' => __( 'Mobilier spa, aménagement des cabines, équipements, linge et accessoires, shopping list fournisseurs : des choix cohérents avec l\'image, le confort client et l\'efficacité des équipes.', 'cbs-theme' ),
			'items' => array(
				__( 'Sélection du mobilier spa', 'cbs-theme' ),
				__( 'Recommandations pour l\'aménagement des cabines', 'cbs-theme' ),
				__( 'Sélection des équipements et accessoires (paniers, chaussons, peignoirs, linge spa, matériel)', 'cbs-theme' ),
				__( 'Élaboration d\'une shopping list fournisseurs', 'cbs-theme' ),
			),
			'livrables' => __( 'Livrables : liste fournisseurs + liste équipements et consommables', 'cbs-theme' ),
		),
		array(
			'title' => __( 'Phase 6 — Préparation à la gestion opérationnelle', 'cbs-theme' ),
			'intro' => __( 'Organisation de l\'exploitation, dimensionnement des soins, structuration de l\'offre bien-être, prévisionnel sur trois scénarios (pessimiste, réaliste, ambitieux) : un spa prêt à être piloté et performant dès l\'ouverture.', 'cbs-theme' ),
			'items' => array(
				__( 'Recommandations organisationnelles pour l\'exploitation', 'cbs-theme' ),
				__( 'Dimensionnement de l\'activité soins', 'cbs-theme' ),
				__( 'Structuration de l\'offre bien-être', 'cbs-theme' ),
				__( 'Modélisation du potentiel d\'activité', 'cbs-theme' ),
				__( 'Prévisionnel d\'activité spa (3 scénarios : pessimiste / réaliste / ambitieux)', 'cbs-theme' ),
			),
			'livrables' => __( 'Livrables : prévisionnel d\'activité + recommandations organisationnelles', 'cbs-theme' ),
		),
	);
}

/**
 * @return array<string, mixed>
 */
function cbs_offres_niveau_2_defaults(): array {
	return array(
		'hero_kicker'   => __( 'Niveau 2 — Offre principale', 'cbs-theme' ),
		'hero_title'    => __( 'Conception & sécurisation du projet spa', 'cbs-theme' ),
		'hero_subtitle' => __( 'Un spa représente entre 500 000 € et 2 millions d\'euros d\'investissement. Une erreur de conception peut coûter 50 000 à 100 000 € en travaux correctifs. Mon rôle : sécuriser cet investissement.', 'cbs-theme' ),
		'phases_kicker' => __( 'Accompagnement complet', 'cbs-theme' ),
		'phases_title'  => __( 'Les 6 phases de la mission', 'cbs-theme' ),
		'phases_lead'   => __(
			'La plupart des spas sont conçus par des architectes qui ne connaissent pas l\'exploitation quotidienne. Résultat : cabines mal dimensionnées, ventilation insuffisante, parcours client inefficace. Ces 6 phases intègrent la réalité du terrain dès la conception.',
			'cbs-theme'
		),
		'options'       => array(
			__( '20% sur les économies réalisées dans le cadre d\'aides et subventions', 'cbs-theme' ),
			__( '250 € par réunion supplémentaire sur site', 'cbs-theme' ),
			__( '60 € / heure par réunion supplémentaire à distance', 'cbs-theme' ),
		),
		'cta_label'     => __( 'Discuter de votre projet', 'cbs-theme' ),
	);
}

/**
 * @return array<int, array<string, mixed>>
 */
function cbs_offres_niveau_3_blocs_defaults(): array {
	return array(
		array(
			'title' => __( 'Branding spa (avec graphiste/agence partenaire)', 'cbs-theme' ),
			'items' => array(
				__( 'nom du spa, identité physique, marque cosmétique associée, logo, charte graphique', 'cbs-theme' ),
				__( 'plan de communication personnalisé selon budget', 'cbs-theme' ),
			),
		),
		array(
			'title' => __( 'Création d\'un soin signature exclusif', 'cbs-theme' ),
			'items' => array(
				__( 'protocole sur-mesure + livret détaillé + cession complète des droits', 'cbs-theme' ),
				__( 'formation des praticiennes actuelles et futures en option', 'cbs-theme' ),
			),
		),
		array(
			'title' => __( 'Accompagnement à l\'optimisation des process organisationnels', 'cbs-theme' ),
			'items' => array(
				__( 'audit + analyse + recommandations', 'cbs-theme' ),
				__( 'livrable : rapport d\'audit + plan d\'action opérationnel', 'cbs-theme' ),
				__( 'formation organisationnelle et managériale (prise en charge OPCO)', 'cbs-theme' ),
				__( 'suivi & coaching terrain', 'cbs-theme' ),
			),
		),
		array(
			'title' => __( 'Accompagnement à l\'optimisation des équipes', 'cbs-theme' ),
			'items' => array(
				__( 'recrutement (annonce, tri CV, entretiens, test de la main)', 'cbs-theme' ),
				__( 'onboarding et formation sur les process', 'cbs-theme' ),
				__( 'expertise légale & RH freelances (évaluation, contrats, conformité dossiers)', 'cbs-theme' ),
			),
		),
		array(
			'title' => __( 'Offres de formation pour le personnel spa', 'cbs-theme' ),
			'items' => array(
				__( 'massage & soins (présentiel + e-learning)', 'cbs-theme' ),
				__( 'accueil client en cabine', 'cbs-theme' ),
				__( 'vente de produits', 'cbs-theme' ),
				__( 'hygiène & sécurité', 'cbs-theme' ),
			),
		),
		array(
			'title' => __( 'Offres de formation pour les équipes réception', 'cbs-theme' ),
			'items' => array(
				__( 'vente de produits', 'cbs-theme' ),
				__( 'accueil client et discours spa', 'cbs-theme' ),
				__( 'hygiène & sécurité', 'cbs-theme' ),
			),
		),
	);
}

/**
 * @return array<string, mixed>
 */
function cbs_offres_niveau_3_defaults(): array {
	return array(
		'hero_kicker'   => __( 'Niveau 3 — Offre premium long terme', 'cbs-theme' ),
		'hero_title'    => __( 'Mise en performance du spa', 'cbs-theme' ),
		'hero_subtitle' => __( 'Votre spa est ouvert mais ne génère pas les résultats attendus ? Cette mission transforme un spa existant en vrai centre de profit.', 'cbs-theme' ),
		'contenu_lead'  => __(
			'Après l\'ouverture, l\'écart entre prévision et réalité apparaît souvent : taux d\'occupation des cabines, panier moyen, ventes produits au spa et à la réception, organisation des équipes. L\'optimisation post-ouverture agit sur le branding, un soin signature, les process, le recrutement et les formations pour rendre l\'activité rentable et durable.',
			'cbs-theme'
		),
		'cta_label'     => __( 'Discuter de vos besoins', 'cbs-theme' ),
	);
}

/**
 * Valeur ACF ou défaut (scalaires).
 *
 * @param mixed  $value Valeur brute get_field().
 * @param string $default Défaut.
 */
function cbs_offres_scalar( $value, string $default ): string {
	if ( $value === null || false === $value ) {
		return $default;
	}
	if ( is_string( $value ) && $value !== '' ) {
		return $value;
	}
	if ( is_numeric( $value ) ) {
		return (string) $value;
	}

	return $default;
}

/**
 * @param mixed $rows
 * @param array<int, string>|array<int, array<string, mixed>> $default
 * @return array<int, string>|array<int, array<string, mixed>>
 */
function cbs_offres_list_field( $rows, array $default ): array {
	if ( ! is_array( $rows ) || $rows === array() ) {
		return $default;
	}

	return $rows;
}

/**
 * Repeater ACF dont chaque ligne contient la clé `ligne` (texte).
 *
 * @param mixed $rows
 * @param array<int, string> $default
 * @return array<int, string>
 */
function cbs_offres_repeater_lignes( $rows, array $default ): array {
	if ( ! is_array( $rows ) || $rows === array() ) {
		return $default;
	}

	$out = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$line = isset( $row['ligne'] ) ? (string) $row['ligne'] : '';
		if ( $line !== '' ) {
			$out[] = $line;
		}
	}

	return $out !== array() ? $out : $default;
}

/**
 * Cartes « 3 niveaux » (hub) : repeater ACF ou défauts structure.md §3.
 *
 * @param mixed $rows
 * @param array<int, array<string, string>> $default
 * @return array<int, array<string, string>>
 */
function cbs_offres_hub_cards_resolved( $rows, array $default ): array {
	if ( ! is_array( $rows ) || $rows === array() ) {
		return $default;
	}

	$out = array();
	foreach ( $rows as $i => $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$def = $default[ $i ] ?? array(
			'kicker'    => '',
			'title'     => '',
			'duration'  => '',
			'objective' => '',
			'obtenez'   => '',
			'url'       => home_url( '/' ),
		);
		$url = isset( $row['card_url'] ) ? trim( (string) $row['card_url'] ) : '';
		$out[] = array(
			'kicker'    => cbs_offres_scalar( $row['card_kicker'] ?? '', (string) ( $def['kicker'] ?? '' ) ),
			'title'     => cbs_offres_scalar( $row['card_title'] ?? '', (string) ( $def['title'] ?? '' ) ),
			'duration'  => cbs_offres_scalar( $row['card_duration'] ?? '', (string) ( $def['duration'] ?? '' ) ),
			'objective' => cbs_offres_scalar( $row['card_objective'] ?? '', (string) ( $def['objective'] ?? '' ) ),
			'obtenez'   => cbs_offres_scalar( $row['card_obtenez'] ?? '', (string) ( $def['obtenez'] ?? '' ) ),
			'url'       => $url !== '' ? $url : (string) ( $def['url'] ?? home_url( '/' ) ),
		);
	}

	return $out !== array() ? $out : $default;
}

/**
 * Phases Niveau 2 : repeater ACF (titre + intro + lignes + livrables) ou défauts.
 *
 * @param mixed $rows
 * @param array<int, array<string, mixed>> $default
 * @return array<int, array<string, mixed>>
 */
function cbs_offres_n2_phases_resolved( $rows, array $default ): array {
	if ( ! is_array( $rows ) || $rows === array() ) {
		return $default;
	}

	$out = array();
	foreach ( $rows as $i => $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$title = isset( $row['phase_title'] ) ? trim( (string) $row['phase_title'] ) : '';
		$intro = isset( $row['phase_intro'] ) ? trim( (string) $row['phase_intro'] ) : '';
		$items_raw = isset( $row['phase_items'] ) ? (string) $row['phase_items'] : '';
		$items     = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $items_raw ) ) );
		$livr      = isset( $row['phase_livrables'] ) ? trim( (string) $row['phase_livrables'] ) : '';
		$fallback  = $default[ $i ] ?? array( 'title' => '', 'intro' => '', 'items' => array(), 'livrables' => '' );

		$out[] = array(
			'title'     => $title !== '' ? $title : (string) ( $fallback['title'] ?? '' ),
			'intro'     => $intro !== '' ? $intro : (string) ( $fallback['intro'] ?? '' ),
			'items'     => $items !== array() ? array_values( $items ) : ( is_array( $fallback['items'] ?? null ) ? $fallback['items'] : array() ),
			'livrables' => $livr !== '' ? $livr : (string) ( $fallback['livrables'] ?? '' ),
		);
	}

	return $out !== array() ? $out : $default;
}

/**
 * SVG statique (décoratif) pour les cartes phases Niveau 2 — 1 à 6.
 *
 * @param int $phase_index Index 1–6.
 * @return string Markup SVG sûr (chemins figés).
 */
function cbs_offres_n2_phase_icon_svg( int $phase_index ): string {
	$phase_index = max( 1, min( 6, $phase_index ) );
	$o           = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">';
	$icons       = array(
		1 => $o . '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>',
		2 => $o . '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="9" y1="15" x2="15" y2="15"/><line x1="9" y1="11" x2="13" y2="11"/></svg>',
		3 => $o . '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
		4 => $o . '<rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>',
		5 => $o . '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>',
		6 => $o . '<path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>',
	);

	return $icons[ $phase_index ];
}

/**
 * Blocs Niveau 3 : repeater (titre + lignes) ou défauts.
 *
 * @param mixed $rows
 * @param array<int, array<string, mixed>> $default
 * @return array<int, array<string, mixed>>
 */
function cbs_offres_n3_blocs_resolved( $rows, array $default ): array {
	if ( ! is_array( $rows ) || $rows === array() ) {
		return $default;
	}

	$out = array();
	foreach ( $rows as $i => $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$title = isset( $row['bloc_title'] ) ? trim( (string) $row['bloc_title'] ) : '';
		$raw   = isset( $row['bloc_items'] ) ? (string) $row['bloc_items'] : '';
		$items = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $raw ) ) );
		$fb    = $default[ $i ] ?? array( 'title' => '', 'items' => array() );

		$out[] = array(
			'title' => $title !== '' ? $title : (string) ( $fb['title'] ?? '' ),
			'items' => $items !== array() ? array_values( $items ) : ( is_array( $fb['items'] ?? null ) ? $fb['items'] : array() ),
		);
	}

	return $out !== array() ? $out : $default;
}

/**
 * URL d’image depuis une valeur ACF (ID, tableau, URL) ou chaîne vide.
 *
 * @param mixed $raw Valeur brute get_field().
 * @param string $fallback URL de secours.
 */
function cbs_offres_acf_image_url( $raw, string $fallback ): string {
	if ( $raw === null || false === $raw || '' === $raw ) {
		return $fallback;
	}
	if ( is_string( $raw ) ) {
		$t = trim( $raw );
		if ( $t !== '' && filter_var( $t, FILTER_VALIDATE_URL ) ) {
			return $t;
		}

		return $fallback;
	}
	if ( is_numeric( $raw ) ) {
		$u = wp_get_attachment_image_url( (int) $raw, 'large' );

		return $u ? $u : $fallback;
	}
	if ( is_array( $raw ) ) {
		if ( ! empty( $raw['url'] ) && is_string( $raw['url'] ) ) {
			return $raw['url'];
		}
		$id = isset( $raw['ID'] ) ? (int) $raw['ID'] : 0;
		if ( $id > 0 ) {
			$u = wp_get_attachment_image_url( $id, 'large' );

			return $u ? $u : $fallback;
		}
	}

	return $fallback;
}

/**
 * @return array<int, array{image: string, badge: string, titre: string}>
 */
function cbs_offres_methode_hub_bento_defaults(): array {
	return array(
		array(
			'image' => 'https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?w=800&q=80',
			'badge' => __( 'DIRECTION HÔTELIÈRE', 'cbs-theme' ),
			'titre' => __( 'Déléguer sans perdre le contrôle', 'cbs-theme' ),
		),
		array(
			'image' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=400&q=80',
			'badge' => __( 'MAÎTRISE D\'OUVRAGE', 'cbs-theme' ),
			'titre' => __( 'Sécuriser la conception', 'cbs-theme' ),
		),
		array(
			'image' => 'https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?w=400&q=80',
			'badge' => __( 'INVESTISSEUR', 'cbs-theme' ),
			'titre' => __( 'Concevoir pour la rentabilité', 'cbs-theme' ),
		),
	);
}

/**
 * @param mixed $rows
 * @param array<int, array{image: string, badge: string, titre: string}> $default
 * @return array<int, array{image: string, badge: string, titre: string}>
 */
function cbs_offres_methode_hub_bento_resolved( $rows, array $default ): array {
	$rows = is_array( $rows ) ? array_values( $rows ) : array();
	$out  = array();
	foreach ( $default as $i => $def ) {
		$row = isset( $rows[ $i ] ) && is_array( $rows[ $i ] ) ? $rows[ $i ] : array();
		$img = $row['bento_image'] ?? null;
		$out[] = array(
			'image' => cbs_offres_acf_image_url( $img, (string) ( $def['image'] ?? '' ) ),
			'badge' => cbs_offres_scalar( $row['bento_badge'] ?? '', (string) ( $def['badge'] ?? '' ) ),
			'titre' => cbs_offres_scalar( $row['bento_titre'] ?? '', (string) ( $def['titre'] ?? '' ) ),
		);
	}

	return $out;
}

/**
 * @return array{title: string, text: string, quote: string, img_1: string, img_2: string}
 */
function cbs_offres_methode_hub_moa_defaults(): array {
	return array(
		'title' => __( 'Une expertise spa au service de votre projet architectural', 'cbs-theme' ),
		'text'  => __(
			'L\'assistance à maîtrise d\'ouvrage spa hôtelier relie la conception à l\'exploitation : je coordonne vos architectes et vos équipes pour traduire les impératifs de cabines, de flux clients et d\'offre bien-être en exigences claires et partagées. Le vocabulaire du spa est rendu accessible aux maîtres d\'œuvre, sans diluer la précision technique indispensable à un projet 4★ ou 5★. Ensemble, nous sécurisons les arbitrages avant qu\'ils ne figent le chantier — dimensionnement, ergonomie, ambiance, zones techniques — afin que le plan supporte une exploitation viable et une rentabilité dès l\'ouverture. Chaque échange instaure un langage commun entre direction, architectes et exploitants, pour que les choix restent traçables et cohérents jusqu\'à l\'ouverture.',
			'cbs-theme'
		),
		'quote' => __(
			'Un projet spa durable naît du dialogue entre le dessin des architectes et la réalité du plateau.',
			'cbs-theme'
		),
		'img_1' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=500&q=80',
		'img_2' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&q=80',
	);
}

/**
 * @return array<int, array{value: string, label: string}>
 */
function cbs_offres_methode_hub_stats_default(): array {
	return array(
		array(
			'value' => __( '13', 'cbs-theme' ),
			'label' => __( 'ans d\'expérience dans le spa hôtelier', 'cbs-theme' ),
		),
		array(
			'value' => __( '+13', 'cbs-theme' ),
			'label' => __( 'projets accompagnés', 'cbs-theme' ),
		),
		array(
			'value' => '',
			'label' => __( 'De la conception à l\'ouverture', 'cbs-theme' ),
		),
	);
}

/**
 * @return array<int, array{value: string, label: string}>
 */
function cbs_offres_methode_hub_stats_resolved( int $post_id ): array {
	$defaults = cbs_offres_methode_hub_stats_default();
	if ( ! function_exists( 'get_field' ) ) {
		return $defaults;
	}

	$out = array();
	for ( $i = 1; $i <= 3; $i++ ) {
		$def   = $defaults[ $i - 1 ] ?? array( 'value' => '', 'label' => '' );
		$v_raw = get_field( 'cbs_methode_hub_stat_' . $i . '_value', $post_id );
		$l_raw = get_field( 'cbs_methode_hub_stat_' . $i . '_label', $post_id );
		$out[] = array(
			'value' => cbs_offres_scalar( $v_raw, (string) ( $def['value'] ?? '' ) ),
			'label' => cbs_offres_scalar( $l_raw, (string) ( $def['label'] ?? '' ) ),
		);
	}

	return $out;
}
