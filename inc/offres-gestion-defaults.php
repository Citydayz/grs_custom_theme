<?php
/**
 * CBS Theme — défauts pages Pôle Gestion (content-structure.md §4 à §6).
 */
defined( 'ABSPATH' ) || exit;

/**
 * @return array<string, string>
 */
function cbs_gestion_hub_defaults(): array {
	return array(
		'hero_kicker'              => __( 'Pôle Gestion & Staffing', 'cbs-theme' ),
		'hero_title'               => __( 'Déléguez la gestion de votre spa à un expert', 'cbs-theme' ),
		'hero_subtitle'            => __( 'Vous gérez un hôtel, pas un spa. Déléguer l\'exploitation à un expert, c\'est garantir la qualité sans mobiliser vos équipes sur un métier qui n\'est pas le vôtre.', 'cbs-theme' ),
		'badge'                    => __( 'Alsace uniquement', 'cbs-theme' ),
		'cta_partielle'            => __( 'Gestion partielle', 'cbs-theme' ),
		'cta_complete'             => __( 'Gestion complète', 'cbs-theme' ),
		'link_staffing'            => __( 'Staffing & renfort d\'équipe', 'cbs-theme' ),
		'link_massages'            => __( 'Massages en chambre hôtel', 'cbs-theme' ),
		'card_partielle_si'        => __( 'vous voulez l\'expertise spa, des praticiens qualifiés et la stratégie commerciale tout en gardant réservations, facturation et pilotage en interne.', 'cbs-theme' ),
		'card_complete_si'         => __( 'vous souhaitez déléguer l\'intégralité de l\'exploitation spa pour vous concentrer sur votre hôtel.', 'cbs-theme' ),
		'link_staffing_si'         => __( 'vous avez un trou de planning, un pic d\'activité ou un renfort ponctuel sans alourdir votre structure RH.', 'cbs-theme' ),
		'link_massages_si'         => __( 'vous n\'avez pas de spa physique et voulez proposer du bien-être premium en chambre.', 'cbs-theme' ),
		'complement'               => '',
		'cta_final_title'          => __( 'Discutons de votre projet spa', 'cbs-theme' ),
		'cta_final_text'           => __( 'Chaque projet est unique. Je vous propose un premier échange pour comprendre vos enjeux et voir comment je peux vous accompagner.', 'cbs-theme' ),
		'cta_final_btn'            => __( 'Prendre rendez-vous', 'cbs-theme' ),
	);
}

/**
 * Profils cibles — hub Pôle Gestion (section « À qui s'adresse ce pôle ? »).
 *
 * @return array<int, array{titre: string, texte: string}>
 */
function cbs_gestion_hub_profiles_default(): array {
	return array(
		array(
			'titre'  => __( 'Directeur d\'hôtel 4★/5★', 'cbs-theme' ),
			'texte'  => __( 'Qui veut déléguer l\'exploitation du spa sans perdre la main sur les résultats.', 'cbs-theme' ),
		),
		array(
			'titre'  => __( 'Investisseur ou propriétaire', 'cbs-theme' ),
			'texte'  => __( 'Qui ouvre ou reprend un établissement avec spa.', 'cbs-theme' ),
		),
		array(
			'titre'  => __( 'Exploitant spa', 'cbs-theme' ),
			'texte'  => __( 'Cherchant un renfort structuré sur la gestion quotidienne.', 'cbs-theme' ),
		),
	);
}

/**
 * Missions — hub (section « Ce que nous prenons en charge »), ordre = icônes.
 *
 * @return array<int, array{titre: string, texte: string}>
 */
function cbs_gestion_hub_missions_default(): array {
	return array(
		array(
			'titre'  => __( 'Pilotage des équipes et plannings', 'cbs-theme' ),
			'texte'  => __( 'Encadrement, organisation des créneaux et coordination des praticiens.', 'cbs-theme' ),
		),
		array(
			'titre'  => __( 'Suivi du chiffre d\'affaires et de la rentabilité', 'cbs-theme' ),
			'texte'  => __( 'Indicateurs, marges et leviers pour sécuriser la performance spa.', 'cbs-theme' ),
		),
		array(
			'titre'  => __( 'Gestion des stocks et des prestataires', 'cbs-theme' ),
			'texte'  => __( 'Approvisionnement, consommables et relations avec les partenaires.', 'cbs-theme' ),
		),
		array(
			'titre'  => __( 'Reporting mensuel à la direction', 'cbs-theme' ),
			'texte'  => __( 'Synthèse claire des résultats et des priorités pour la gouvernance.', 'cbs-theme' ),
		),
		array(
			'titre'  => __( 'Recrutement et formation des thérapeutes', 'cbs-theme' ),
			'texte'  => __( 'Sourcing, intégration et montée en compétences alignées sur votre standard.', 'cbs-theme' ),
		),
		array(
			'titre'  => __( 'Relation client et gestion des avis', 'cbs-theme' ),
			'texte'  => __( 'Qualité d\'accueil, fidélisation et veille e-réputation.', 'cbs-theme' ),
		),
	);
}

/**
 * Bloc chiffres clés — hub.
 *
 * @return array<int, array{value: string, label: string}>
 */
function cbs_gestion_hub_stats_default(): array {
	return array(
		array(
			'value' => '13',
			'label' => __( 'ans d\'expérience dans le spa hôtelier', 'cbs-theme' ),
		),
		array(
			'value' => '+13',
			'label' => __( 'projets accompagnés', 'cbs-theme' ),
		),
		array(
			'value' => __( 'Alsace', 'cbs-theme' ),
			'label' => __( 'Zone d\'intervention : gestion en Alsace, conseil sur la France entière', 'cbs-theme' ),
		),
	);
}

/**
 * Texte SEO — hub (sous le H2 fixe).
 */
function cbs_gestion_hub_seo_text_default(): string {
	return __(
		'Déléguer l\'exploitation d\'un spa hôtelier ne signifie pas renoncer à la visibilité sur les résultats : il s\'agit de confier le quotidien opérationnel à un expert qui connaît les exigences des maisons 4★ et 5★. De l\'ouverture à la phase de croissance, la gestion spa demande une exigence constante sur le planning, la qualité des soins et la rentabilité dans la durée. En Alsace, la gestion de proximité est au cœur de notre intervention ; pour les projets plus larges, nous intervenons sur la France entière. Déléguer permet de recentrer l\'énergie sur l\'accueil global, avec des reportings adaptés à votre gouvernance et des indicateurs partagés avec la direction. Notre approche privilégie la clarté des rôles et une lecture chiffrée accessible à votre équipe, pour que la rentabilité spa reste un levier de décisions plutôt qu\'un sujet opaque. L\'ambition reste simple : un spa pertinent pour vos clients, soutenable pour votre établissement, et lisible pour votre direction.',
		'cbs-theme'
	);
}

/**
 * Image colonne gauche — bloc SEO split (hub).
 */
function cbs_gestion_hub_split_image_default(): string {
	return 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=600&q=80';
}

/**
 * URL image split SEO : ACF ou défaut Unsplash.
 */
function cbs_gestion_hub_split_image_resolved( int $post_id ): string {
	$default = cbs_gestion_hub_split_image_default();
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$raw = get_field( 'cbs_gestion_hub_split_image', $post_id );
	if ( is_string( $raw ) && $raw !== '' ) {
		return $raw;
	}

	$url = cbs_acf_media_url( $raw );

	return $url !== '' ? $url : $default;
}

/**
 * @param mixed $rows
 * @param array<int, array{titre: string, texte: string}> $default
 * @return array<int, array{titre: string, texte: string}>
 */
function cbs_gestion_hub_profiles_resolved( $rows, array $default ): array {
	if ( ! is_array( $rows ) || $rows === array() ) {
		return $default;
	}

	$out = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$titre = cbs_offres_scalar( $row['titre'] ?? '', '' );
		$texte = cbs_offres_scalar( $row['texte'] ?? '', '' );
		if ( $titre === '' || $texte === '' ) {
			continue;
		}
		$out[] = array(
			'titre' => $titre,
			'texte' => $texte,
		);
	}

	return $out !== array() ? $out : $default;
}

/**
 * @param mixed $rows
 * @param array<int, array{titre: string, texte: string}> $default
 * @return array<int, array{titre: string, texte: string}>
 */
function cbs_gestion_hub_missions_resolved( $rows, array $default ): array {
	if ( ! is_array( $rows ) || $rows === array() ) {
		return $default;
	}

	$out = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$titre = cbs_offres_scalar( $row['titre'] ?? '', '' );
		$texte = cbs_offres_scalar( $row['texte'] ?? '', '' );
		if ( $titre === '' || $texte === '' ) {
			continue;
		}
		$out[] = array(
			'titre' => $titre,
			'texte' => $texte,
		);
	}

	return $out !== array() ? $out : $default;
}

/**
 * Clé d’icône (cbs_gestion_icon_svg) pour la mission d’index $index.
 */
function cbs_gestion_hub_mission_icon_key( int $index ): string {
	$keys = array( 'team', 'chart_line', 'box', 'chart_bars', 'lightbulb', 'megaphone' );

	return $keys[ $index % 6 ] ?? 'team';
}

/**
 * @return array<int, array{value: string, label: string}>
 */
function cbs_gestion_hub_stats_resolved( int $post_id ): array {
	$defaults = cbs_gestion_hub_stats_default();
	if ( ! function_exists( 'get_field' ) ) {
		return $defaults;
	}

	$out = array();
	for ( $i = 1; $i <= 3; $i++ ) {
		$def   = $defaults[ $i - 1 ] ?? array( 'value' => '', 'label' => '' );
		$v_raw = get_field( 'cbs_gestion_hub_stat_' . $i . '_value', $post_id );
		$l_raw = get_field( 'cbs_gestion_hub_stat_' . $i . '_label', $post_id );
		$out[] = array(
			'value' => cbs_offres_scalar( $v_raw, (string) ( $def['value'] ?? '' ) ),
			'label' => cbs_offres_scalar( $l_raw, (string) ( $def['label'] ?? '' ) ),
		);
	}

	return $out;
}

/**
 * Lignes du tableau répartition CA — gestion partielle (§4).
 *
 * @return array<int, array{poste: string, detail: string}>
 */
function cbs_gestion_partielle_ca_default(): array {
	return array(
		array(
			'poste'  => __( 'Prestations de soins', 'cbs-theme' ),
			'detail' => __( '15 % pour l\'établissement / 85 % pour le gestionnaire (ou base tarifaire fixe fournie par Gestion des Rituels du Spa, l\'hôtel applique sa marge)', 'cbs-theme' ),
		),
		array(
			'poste'  => __( 'Vente de produits', 'cbs-theme' ),
			'detail' => __( '10 % du CA HT pour l\'établissement', 'cbs-theme' ),
		),
		array(
			'poste'  => __( 'Offres Day Spa', 'cbs-theme' ),
			'detail' => __( '100 % pour l\'établissement', 'cbs-theme' ),
		),
		array(
			'poste'  => __( 'Extras spa', 'cbs-theme' ),
			'detail' => __( '100 % établissement', 'cbs-theme' ),
		),
	);
}

/**
 * @return array<int, string>
 */
function cbs_gestion_partielle_missions_gestionnaire_default(): array {
	return array(
		__( 'Pilotage stratégique de l\'activité spa', 'cbs-theme' ),
		__( 'Supervision de la qualité des prestations', 'cbs-theme' ),
		__( 'Création et évolution de la carte de soins', 'cbs-theme' ),
		__( 'Développement des expériences bien-être', 'cbs-theme' ),
		__( 'Stratégie de commercialisation', 'cbs-theme' ),
		__( 'Mise à disposition et supervision des professionnels intervenants', 'cbs-theme' ),
		__( 'Soutien à l\'organisation du planning des praticiens', 'cbs-theme' ),
		__( 'Management et gestion RH', 'cbs-theme' ),
		__( 'Accompagnement au développement de l\'offre bien-être', 'cbs-theme' ),
		__( 'Participation au développement du CA', 'cbs-theme' ),
		__( 'Participation à la stratégie marketing', 'cbs-theme' ),
		__( 'Suivi de la performance de l\'activité', 'cbs-theme' ),
		__( 'Gestion des stocks des consommables (cabine, produits professionnels, produits ventes)', 'cbs-theme' ),
	);
}

/**
 * @return array<int, string>
 */
function cbs_gestion_partielle_missions_etab_default(): array {
	return array(
		__( 'Gestion du planning des praticiens', 'cbs-theme' ),
		__( 'Réservation des prestations spa', 'cbs-theme' ),
		__( 'Facturation', 'cbs-theme' ),
		__( 'Gestion de la relation client', 'cbs-theme' ),
		__( 'Mise en place d\'actions marketing et partenariats', 'cbs-theme' ),
		__( 'Optimisation du taux d\'occupation des cabines', 'cbs-theme' ),
		__( 'Entretien et nettoyage des espaces', 'cbs-theme' ),
		__( 'Consommables : serviettes, chaussons, paniers, peignoirs', 'cbs-theme' ),
	);
}

/**
 * @return array<string, string>
 */
function cbs_gestion_partielle_defaults(): array {
	return array(
		'modele'     => __( 'Gestion mixte, rémunération par commissions', 'cbs-theme' ),
		'hero_title' => __( 'Gestion externalisée partielle, modèle hybride', 'cbs-theme' ),
		'position'   => __( "Vous conservez le pilotage de votre hôtel. J'apporte l'expertise spa, les praticiens qualifiés et la stratégie commerciale. Un partenariat flexible, sans restructuration de vos équipes.\n\nLe changement de partenaire est simple et fluide, sans risque opérationnel pour votre établissement.", 'cbs-theme' ),
		'note_rdv'   => __( 'Les conditions financières sont transmises en rendez-vous, pas de tarifs publics.', 'cbs-theme' ),
		'cta_label'  => __( 'Discuter de ce modèle', 'cbs-theme' ),
	);
}

/**
 * @return array<int, string>
 */
function cbs_gestion_complete_option_a_lines_default(): array {
	return array(
		__( 'Loyer mensuel : à partir de 1 000 € HT / mois', 'cbs-theme' ),
		__( 'Prestations de soins : 8 % du CA HT pour le gestionnaire', 'cbs-theme' ),
		__( 'Vente de produits : 10 % du CA HT pour le gestionnaire', 'cbs-theme' ),
		__( 'Offres Day Spa : 40 % établissement / 60 % gestionnaire', 'cbs-theme' ),
	);
}

/**
 * @return array<int, string>
 */
function cbs_gestion_complete_option_b_lines_default(): array {
	return array(
		__( 'Prestations de soins : 12 % du CA HT pour le gestionnaire', 'cbs-theme' ),
		__( 'Vente de produits : 10 % du CA HT pour le gestionnaire', 'cbs-theme' ),
		__( 'Offres Day Spa : 50 % établissement / 50 % gestionnaire', 'cbs-theme' ),
	);
}

/**
 * @return array<int, string>
 */
function cbs_gestion_complete_resp_gestionnaire_default(): array {
	return array(
		__( 'Pilotage et gestion complète de l\'activité spa', 'cbs-theme' ),
		__( 'Organisation du planning des praticiens et de l\'activité soins', 'cbs-theme' ),
		__( 'Management et gestion RH', 'cbs-theme' ),
		__( 'Supervision qualité', 'cbs-theme' ),
		__( 'Développement offre bien-être + carte des soins', 'cbs-theme' ),
		__( 'Stratégie marketing et commerciale', 'cbs-theme' ),
		__( 'Développement du CA', 'cbs-theme' ),
		__( 'Suivi de la performance', 'cbs-theme' ),
		__( 'Gestion des stocks et consommables', 'cbs-theme' ),
		__( 'Entretien et nettoyage des espaces (hors installations)', 'cbs-theme' ),
		__( 'Consommables pris en charge : chaussons, paniers, consommables cabine, produits cabine, produits ventes', 'cbs-theme' ),
	);
}

/**
 * @return array<int, string>
 */
function cbs_gestion_complete_resp_hotel_default(): array {
	return array(
		__( 'Peignoirs clients', 'cbs-theme' ),
		__( 'Serviettes spa', 'cbs-theme' ),
		__( 'Espace tisanerie', 'cbs-theme' ),
		__( 'Maintenance et gestion technique des installations', 'cbs-theme' ),
		__( 'Gestion des consommations énergétiques', 'cbs-theme' ),
	);
}

/**
 * @return array<string, string>
 */
function cbs_gestion_complete_defaults(): array {
	return array(
		'modele'          => __( 'Forfait mensuel + commission variable', 'cbs-theme' ),
		'hero_title'      => __( 'Gestion externalisée complète, tranquillité absolue', 'cbs-theme' ),
		'position'        => __( 'Tranquillité absolue. Je gère l\'intégralité de l\'activité spa, des équipes et du planning à la qualité, au CA et aux stocks, pendant que vous vous concentrez sur votre hôtel.', 'cbs-theme' ),
		'options_lead'    => __( 'Les modalités financières sont définies ensemble en rendez-vous selon votre situation. Deux modèles existent pour s\'adapter à votre structure.', 'cbs-theme' ),
		'option_a_title'  => __( 'Option A, avec loyer', 'cbs-theme' ),
		'option_a_intro'  => __( 'À partir des éléments suivants (détail en rendez-vous) :', 'cbs-theme' ),
		'option_b_title'  => __( 'Option B, sans loyer', 'cbs-theme' ),
		'option_b_intro'  => __( 'À partir des taux suivants (ajustables en rendez-vous) :', 'cbs-theme' ),
		'note_finance'    => __( 'Les conditions financières sont transmises en rendez-vous. Les montants et taux affichés sont indicatifs ; le détail du contrat est défini lors de l\'échange.', 'cbs-theme' ),
		'cta_label'       => __( 'Discuter de ce modèle', 'cbs-theme' ),
	);
}

/**
 * Repeater CA : sous-champs poste + detail.
 *
 * @param mixed $rows
 * @param array<int, array{poste: string, detail: string}> $default
 * @return array<int, array{poste: string, detail: string}>
 */
function cbs_gestion_ca_rows_resolved( $rows, array $default ): array {
	if ( ! is_array( $rows ) || $rows === array() ) {
		return $default;
	}

	$out = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$poste = isset( $row['poste'] ) ? trim( (string) $row['poste'] ) : '';
		$det   = isset( $row['detail'] ) ? trim( (string) $row['detail'] ) : '';
		if ( $poste === '' && $det === '' ) {
			continue;
		}
		$out[] = array(
			'poste'  => $poste,
			'detail' => $det,
		);
	}

	return $out !== array() ? $out : $default;
}

/**
 * Titre de section tableau (partielle).
 */
function cbs_gestion_partielle_table_caption(): string {
	return __( 'Répartition CA', 'cbs-theme' );
}

/**
 * Colonnes missions (partielle / complète).
 *
 * @return array{gest: string, etab: string}
 */
function cbs_gestion_missions_headings(): array {
	return array(
		'gest' => __( 'Missions gestionnaire', 'cbs-theme' ),
		'etab' => __( 'Missions établissement', 'cbs-theme' ),
	);
}

/**
 * Titres colonnes — gestion complète.
 *
 * @return array{gest: string, hotel: string}
 */
function cbs_gestion_complete_resp_headings(): array {
	return array(
		'gest'  => __( 'Responsabilités gestionnaire (tout inclus)', 'cbs-theme' ),
		'hotel' => __( 'Responsabilités hôtel', 'cbs-theme' ),
	);
}

/**
 * Staffing — défauts textes (content-structure.md §5).
 *
 * @return array<string, string>
 */
function cbs_gestion_staffing_defaults(): array {
	return array(
		'hero_title'    => __( 'Staffing & Renfort d\'équipe, l\'intérim de luxe', 'cbs-theme' ),
		'hero_subtitle' => __( 'Des praticiens qualifiés, vérifiés, conformes, disponibles quand vous en avez besoin.', 'cbs-theme' ),
		'badge'         => __( 'Alsace uniquement', 'cbs-theme' ),
		'position'      => __( "Besoin d'un praticien qualifié demain matin ? Mon réseau de professionnels certifiés, vérifiés et conformes est disponible à la demande. Sans alourdir votre structure RH.\n\nChaque praticien est suivi administrativement et réglementairement. Vous intervenez sur la prestation. Je gère la conformité.", 'cbs-theme' ),
		'modele_label'  => __( 'Collaboration exclusive, rémunération au forfait', 'cbs-theme' ),
		'modele_h2'     => __( 'Modèle tarifaire', 'cbs-theme' ),
		'note_pilotage' => __( 'L\'établissement conserve le pilotage.', 'cbs-theme' ),
		'cta_label'     => __( 'Nous contacter', 'cbs-theme' ),

		'positionnement_image_fallback' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&q=80',
		'seo_staffing_h2_fallback'        => __( 'Staffing spa hôtelier en Alsace', 'cbs-theme' ),

		'seo_staffing_body_fallback'      => __( "Le staffing spa hôtelier en Alsace prend tout son sens lorsqu'un palace ou un resort doit tenir ses promesses d'excellence sans briser un planning déjà sous tension. Dans ce contexte exigeant, fournir un praticien spa qualifié, à l'aise avec le luxe comme avec la précision gestuelle attendue dans la cabine, devient stratégique : le client doit sentir une continuité parfaite, du premier contact à la proposition de soins. L'intérim spa luxe répond précisément à ces fenêtres d'occupation forte, aux absences non planifiées ou aux projets saisonniers, sans passer par une annonce longue et coûteuse.\n\nChaque renfort équipe spa hôtel Alsace s'articule autour du profil défini ensemble : niveau linguistique, sens du détail vestimentaire, maîtrise des protocoles et respect des usages internes qui font votre différence concurrentielle. Avant mise à disposition, les habilitations, assurances et règles d'hygiène sont confrontées aux normes locales : la conformité réglementaire ne relève alors plus d'une charge diffuse pour vos équipes RH, puisqu'un cadre vérifiant accompagne déjà les intervenants. Un praticien certifié spa, habitué au rythme d'un établissement quatre ou cinq étoiles, sait prendre ses marques sans retarder vos flux opérationnels. Vous préservez ainsi la maîtrise de carte, de tarifs, de réservation et d'animation commerciale, tout en apportant sur le lit de massage une présence impeccable, signe tangible de votre niveau premium.", 'cbs-theme' ),

		'seo_staffing_image_fallback'     => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&q=80',

		'modele_vous_gardez_text'         => __( 'Vous intervenez sur la prestation. Je gère la conformité administrative et réglementaire de chaque praticien.', 'cbs-theme' ),
	);
}

/**
 * @return array<int, string>
 */
function cbs_gestion_staffing_modele_lignes_default(): array {
	return array(
		__( 'Prestations de soins : base tarifaire fixe fournie par Gestion des Rituels du Spa, l\'hôtel applique sa marge', 'cbs-theme' ),
		__( 'Achat de la marque par l\'hôtel / rémunération ventes praticiens externes : 15% facturé par Gestion des Rituels du Spa', 'cbs-theme' ),
		__( 'Day Spa : 100% établissement', 'cbs-theme' ),
		__( 'Extras : 100% établissement', 'cbs-theme' ),
	);
}

/**
 * @return array<int, string>
 */
function cbs_gestion_staffing_missions_gestionnaire_default(): array {
	return array(
		__( 'Supervision qualité des prestations des praticiens externes', 'cbs-theme' ),
		__( 'Mise à disposition et supervision des professionnels', 'cbs-theme' ),
		__( 'Soutien à l\'organisation du planning', 'cbs-theme' ),
		__( 'Management et gestion RH des intervenants', 'cbs-theme' ),
		__( 'Accompagnement au développement de l\'offre', 'cbs-theme' ),
		__( 'Suivi de la performance', 'cbs-theme' ),
	);
}

/**
 * @return array<int, string>
 */
function cbs_gestion_staffing_missions_etab_default(): array {
	return array(
		__( 'Planning, réservation, facturation, relation client', 'cbs-theme' ),
		__( 'Stratégie, carte de soins, marketing', 'cbs-theme' ),
		__( 'Gestion de tous les consommables', 'cbs-theme' ),
	);
}

/**
 * @return array{gest: string, etab: string}
 */
function cbs_gestion_staffing_missions_headings(): array {
	return array(
		'gest' => __( 'Missions gestionnaire', 'cbs-theme' ),
		'etab' => __( 'Missions établissement (conserve le pilotage)', 'cbs-theme' ),
	);
}

/**
 * Massages en chambre — défauts (content-structure.md §6).
 *
 * @return array<string, string>
 */
function cbs_gestion_massages_defaults(): array {
	return array(
		'hero_title'       => __( 'Massages en chambre, service premium clés en main', 'cbs-theme' ),
		'hero_subtitle'    => __( 'Proposez des massages haut de gamme à vos clients, sans infrastructure spa dédiée.', 'cbs-theme' ),
		'badge'            => __( 'Alsace uniquement', 'cbs-theme' ),
		'position'         => __( 'Proposez une expérience bien-être haut de gamme à vos clients sans infrastructure spa dédiée. Un service clés en main, disponible sur réservation, avec des praticiens qui véhiculent l\'image premium de votre établissement.', 'cbs-theme' ),
		'modele_label'     => __( 'Collaboration exclusive, rémunération au forfait', 'cbs-theme' ),
		'modele_h2'        => __( 'Modèle tarifaire', 'cbs-theme' ),
		'planif_title'     => __( 'Système de planification fluide', 'cbs-theme' ),
		'planif_text'      => __( "La réservation repose sur un système intégré où créneaux, confirmations et historique restent lisibles dans une vue unique qui peut s\'aligner avec votre organisation habituelle. Une assistance téléphonique dédiée encadre vos hôtes : prise du rendez-vous, validation des créneaux et confirmations ne reposent pas sur votre équipe de réception, qui n\'a donc aucune charge opérationnelle supplémentaire à absorber avant le jour J. Les consignes se transmettent jusqu\'aux praticiens dans ce même mouvement, tout en garantissant prévisibilité lorsque votre client retrouve le professionnel dans la suite.", 'cbs-theme' ),

		'modele_vous_gardez_text' => __( 'Vous fixez le prix client et gérez la relation avec vos hôtes. Nous gérons les praticiens, la qualité et la conformité.', 'cbs-theme' ),

		'positionnement_image_fallback' => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=800&q=80',
		'planif_image_fallback'          => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=800&q=80',
		'seo_massages_image_fallback'     => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&q=80',
		'seo_massages_h2_fallback'        => __( 'Massages en chambre pour hôtels haut de gamme en Alsace', 'cbs-theme' ),

		'seo_massages_body_fallback'      => __( "L\'expérience de massages en chambre prolonge la promesse de bien-être lorsque votre établissement ne peut pas encore aménager un spa physique. Dans une maison quatre ou cinq étoiles, vos hôtes attendent une exigence comparable à celle d\'une cabine : protocoles partagés, hygiène stricte, tenue impeccable. En Alsace, cette continuité prolonge naturellement votre service bien-être hôtelier jusqu\'aux suites, là où vos clients souhaitent rester après une journée chargée sans parcourir tout l\'hôtel.\n\nVous décidez des prix affichés et portez la relation directe avec vos invités lorsque la promesse tarifaire se poursuit encore dans leur chambre. Nous mettons au contact des praticiens de massage qui connaissent l\'attente d\'une maison quatre étoiles, vérifions la conformité et faisons passer les consignes qualité jusqu\'au jour du soin dans l\'intimité de leur espace privatif. Une assistance téléphonique dédiée enregistre les créneaux, assure les confirmations et garde une trace commune dans un tableau partagé, ce qui évite tout surcroît à votre équipe de réception. C\'est ainsi une voie très crédible pour offrir un niveau quatre étoiles sans déployer encore une infrastructure spa traditionnelle lourde sur site.", 'cbs-theme' ),

		'cta_label'        => __( 'Nous contacter', 'cbs-theme' ),
	);
}

/**
 * @return array<int, string>
 */
function cbs_gestion_massages_modele_lignes_default(): array {
	return array(
		__( 'Base tarifaire fixe fournie par Gestion des Rituels du Spa', 'cbs-theme' ),
		__( 'L\'hôtel applique la marge qu\'il souhaite et fixe le prix client', 'cbs-theme' ),
	);
}

/**
 * @return array<int, string>
 */
function cbs_gestion_massages_missions_gestionnaire_default(): array {
	return array(
		__( 'Supervision qualité', 'cbs-theme' ),
		__( 'Mise à disposition et supervision des praticiens', 'cbs-theme' ),
		__( 'Soutien à la planification (système de RDV + assistance téléphonique)', 'cbs-theme' ),
		__( 'Management RH, administratif et réglementaire des intervenants', 'cbs-theme' ),
		__( 'Accompagnement au développement de l\'offre bien-être', 'cbs-theme' ),
		__( 'Suivi de la performance', 'cbs-theme' ),
		__( 'Création et mise à disposition de la carte de soins', 'cbs-theme' ),
	);
}

/**
 * @return array<int, string>
 */
function cbs_gestion_massages_missions_etab_default(): array {
	return array(
		__( 'Planning, réservation, facturation', 'cbs-theme' ),
		__( 'Relation client', 'cbs-theme' ),
		__( 'Développement des expériences bien-être', 'cbs-theme' ),
		__( 'Stratégie de commercialisation', 'cbs-theme' ),
		__( 'Actions marketing', 'cbs-theme' ),
	);
}

/**
 * SVG décoratif (stroke) pour cartes missions Pôle Gestion.
 *
 * @param string $key helm|star|list|chart_bars|calendar|team|box|droplet|chart_line|megaphone|activity|lightbulb|sparkles|brush
 */
function cbs_gestion_icon_svg( string $key ): string {
	$o = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">';
	$m = array(
		'helm'       => $o . '<circle cx="12" cy="12" r="3"/><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>',
		'star'       => $o . '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
		'list'       => $o . '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>',
		'chart_bars' => $o . '<line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>',
		'calendar'   => $o . '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
		'team'       => $o . '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
		'box'        => $o . '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
		'droplet'    => $o . '<path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg>',
		'chart_line' => $o . '<path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>',
		'megaphone'  => $o . '<path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>',
		'activity'   => $o . '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>',
		'lightbulb'  => $o . '<path d="M9 18h6"/><path d="M10 22h4"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 12 4a4.65 4.65 0 0 0-3.5 7.5c.76.76 1.23 1.52 1.41 2.5"/></svg>',
		'sparkles'   => $o . '<path d="m12 3-1.9 5.8L4 11l5.8 1.9L12 19l1.9-5.8L20 11l-5.8-1.9L12 3z"/><path d="M5 3v4"/><path d="M19 17v4"/><path d="M3 5h4"/><path d="M17 19h4"/></svg>',
		'brush'      => $o . '<path d="m9.06 11.9 8.94-8.94a2 2 0 0 0-2.83-2.83l-8.94 8.94"/><path d="m18 2 4 4"/><path d="m12.5 6.5 4.5 4.5"/><path d="M8.5 10.5 5 14 3 21l6-2 3.5-3.5"/></svg>',
	);

	return $m[ $key ] ?? $m['helm'];
}
