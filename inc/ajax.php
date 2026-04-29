<?php
/**
 * CBS Theme — ajax.php
 * Handlers AJAX (formulaire contact, tunnel diagnostic).
 */

defined( 'ABSPATH' ) || exit;

/**
 * Rate limiting par IP (transients).
 *
 * @param string $action Clé logique (contact, diagnostic…).
 * @param int    $max    Nombre max de requêtes.
 * @param int    $window Fenêtre en secondes.
 */
function cbs_check_rate_limit( string $action, int $max = 5, int $window = 3600 ): bool {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( (string) $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key = 'cbs_rl_' . md5( $action . $ip );
	/** @var int|false $stored */
	$stored = get_transient( $key );
	$count  = (int) $stored;

	if ( $count >= $max ) {
		return false;
	}

	if ( $count === 0 ) {
		set_transient( $key, 1, $window );
	} else {
		set_transient( $key, $count + 1, $window );
	}

	return true;
}

/**
 * Envoie un payload JSON vers un scénario Make (non bloquant hors prod).
 *
 * @param string               $event Nom logique (ex. contact_form → CBS_MAKE_WEBHOOK_CONTACT_FORM).
 * @param array<string, mixed> $data  Données métier.
 */
function cbs_trigger_make_webhook( string $event, array $data ): void {
	if ( cbs_is_development() ) {
		cbs_log_error( 'make_webhook', '[DEV] Webhook simulé : ' . $event, $data );
		return;
	}

	$const = 'CBS_MAKE_WEBHOOK_' . strtoupper( $event );
	if ( ! defined( $const ) ) {
		cbs_log_error( 'make_webhook', 'Constante manquante pour événement : ' . $event );
		return;
	}

	/** @var string $webhook_url */
	$webhook_url = constant( $const );
	if ( $webhook_url === '' ) {
		cbs_log_error( 'make_webhook', 'URL vide pour événement : ' . $event );
		return;
	}

	$payload = array_merge(
		$data,
		array(
			'event'     => $event,
			'timestamp' => current_time( 'c' ),
		)
	);

	$body    = wp_json_encode( $payload );
	$headers = array( 'Content-Type' => 'application/json' );

	if ( defined( 'CBS_MAKE_WEBHOOK_SECRET' ) && CBS_MAKE_WEBHOOK_SECRET ) {
		$headers['X-CBS-Signature'] = hash_hmac( 'sha256', (string) $body, (string) CBS_MAKE_WEBHOOK_SECRET );
	}

	wp_remote_post(
		$webhook_url,
		array(
			'headers'  => $headers,
			'body'     => $body,
			'timeout'  => 10,
			'blocking' => false,
		)
	);
}

/**
 * Types de projet autorisés — content-structure.md §10.
 *
 * @return array<string, string> slug => libellé Airtable
 */
function cbs_contact_type_projet_map(): array {
	return array(
		'conseil'  => __( 'Conseil', 'cbs-theme' ),
		'gestion'  => __( 'Gestion', 'cbs-theme' ),
		'staffing' => __( 'Staffing', 'cbs-theme' ),
		'autre'    => __( 'Autre', 'cbs-theme' ),
	);
}

/**
 * @param array<string, mixed> $post Données $_POST sanitizées attendues.
 * @return array<string, string>|WP_Error
 */
function cbs_contact_validate_payload( array $post ) {
	$prenom      = isset( $post['prenom'] ) ? sanitize_text_field( (string) $post['prenom'] ) : '';
	$nom         = isset( $post['nom'] ) ? sanitize_text_field( (string) $post['nom'] ) : '';
	$hotel       = isset( $post['hotel'] ) ? sanitize_text_field( (string) $post['hotel'] ) : '';
	$email       = isset( $post['email'] ) ? sanitize_email( (string) $post['email'] ) : '';
	$telephone   = isset( $post['telephone'] ) ? sanitize_text_field( (string) $post['telephone'] ) : '';
	$type_projet = isset( $post['type_projet'] ) ? sanitize_text_field( (string) $post['type_projet'] ) : '';
	$message     = isset( $post['message'] ) ? sanitize_textarea_field( (string) $post['message'] ) : '';
	$rgpd        = ! empty( $post['rgpd'] );

	$types = cbs_contact_type_projet_map();
	if ( $prenom === '' ) return new WP_Error( 'validation', __( 'Erreur: Prénom manquant ou invalide.', 'cbs-theme' ) );
	if ( $nom === '' ) return new WP_Error( 'validation', __( 'Erreur: Nom manquant ou invalide.', 'cbs-theme' ) );
	if ( $hotel === '' ) return new WP_Error( 'validation', __( 'Erreur: Hôtel / Société manquant.', 'cbs-theme' ) );
	if ( ! is_email( $email ) ) return new WP_Error( 'validation', __( 'Erreur: Email invalide (' . esc_html($post['email']) . ').', 'cbs-theme' ) );
	if ( ! $rgpd ) return new WP_Error( 'validation', __( 'Erreur: Vous devez accepter la politique de confidentialité (RGPD).', 'cbs-theme' ) );

	if ( ! isset( $types[ $type_projet ] ) ) {
		return new WP_Error( 'validation', __( 'Erreur: Type de projet invalide (' . esc_html($type_projet) . ').', 'cbs-theme' ) );
	}

	if ( $telephone !== '' && ! preg_match( '/^[\d\s+.()\-]{8,}$/', $telephone ) ) {
		return new WP_Error( 'validation', __( 'Erreur: Numéro de téléphone invalide (' . esc_html($telephone) . ').', 'cbs-theme' ) );
	}

	return array(
		'prenom'           => $prenom,
		'nom'              => $nom,
		'hotel'            => $hotel,
		'email'            => $email,
		'telephone'        => $telephone,
		'type_projet'      => $type_projet,
		'type_projet_lib'  => $types[ $type_projet ],
		'message'          => $message,
	);
}

/**
 * Types de projet — diagnostic-tunnel.md §5.
 *
 * @return array<string, string> slug => libellé (Airtable)
 */
function cbs_diagnostic_type_projet_map(): array {
	return array(
		'spa_creation'          => __( "Création d'un spa", 'cbs-theme' ),
		'spa_optimiser'         => __( 'Spa existant à optimiser', 'cbs-theme' ),
		'reflexion_strategique' => __( 'Réflexion stratégique', 'cbs-theme' ),
		'gestion_staffing'      => __( 'Gestion / staffing', 'cbs-theme' ),
	);
}

/**
 * Contexte du tunnel diagnostic (étape qualification).
 *
 * @return array<string, string> slug => libellé
 */
function cbs_diagnostic_context_map(): array {
	return array(
		'consulting_projet'   => __( 'Création ou rénovation (projet)', 'cbs-theme' ),
		'consulting_existant' => __( 'Spa existant à optimiser', 'cbs-theme' ),
		'gestion'             => __( 'Gestion / staffing', 'cbs-theme' ),
	);
}

/**
 * @return array<string, string>
 */
function cbs_diagnostic_gestion_salaries_map(): array {
	return array(
		'salarie_oui'        => __( 'Oui', 'cbs-theme' ),
		'salarie_freelances' => __( 'Freelances uniquement', 'cbs-theme' ),
		'salarie_non'        => __( 'Non, pas encore', 'cbs-theme' ),
	);
}

/**
 * @return array<string, string>
 */
function cbs_diagnostic_gestion_rh_map(): array {
	return array(
		'rh_recrutement'  => __( 'Recrutement', 'cbs-theme' ),
		'rh_fidelisation' => __( 'Fidélisation', 'cbs-theme' ),
		'rh_formation'    => __( 'Formation', 'cbs-theme' ),
		'rh_plannings'    => __( 'Organisation des plannings', 'cbs-theme' ),
	);
}

/**
 * @return array<string, string>
 */
function cbs_diagnostic_gestion_mode_map(): array {
	return array(
		'gest_interne'  => __( 'Interne', 'cbs-theme' ),
		'gest_externe'  => __( 'Externalisé', 'cbs-theme' ),
		'gest_mixte'    => __( 'Mixte', 'cbs-theme' ),
		'gest_indefini' => __( 'Pas encore défini', 'cbs-theme' ),
	);
}

/**
 * Score 0–30 (parcours gestion : pondération sur 6 questions scorées, ramenée à /30).
 *
 * @param array<int, int> $reponses Index 1..10 => 0..3.
 */
function cbs_diagnostic_compute_score( array $reponses, string $contexte ): int {
	if ( 'gestion' === $contexte ) {
		$raw = (int) ( $reponses[1] + $reponses[6] + $reponses[7] + $reponses[8] + $reponses[9] + $reponses[10] );
		return (int) round( ( $raw / 18 ) * 30 );
	}
	return (int) array_sum( $reponses );
}

/**
 * @param array<string, mixed> $post Données formulaire.
 * @return array<int, int>|WP_Error Index question 1..10 => points 0..3.
 */
function cbs_diagnostic_normalize_reponses( array $post ) {
	$raw = isset( $post['reponses'] ) && is_array( $post['reponses'] ) ? $post['reponses'] : array();
	$out = array();

	for ( $i = 1; $i <= 10; $i++ ) {
		$has = array_key_exists( $i, $raw ) || array_key_exists( (string) $i, $raw );
		if ( ! $has ) {
			return new WP_Error( 'validation', __( 'Données invalides. Vérifiez et réessayez.', 'cbs-theme' ) );
		}
		$val = $raw[ $i ] ?? $raw[ (string) $i ];
		$v   = (int) $val;
		if ( ! in_array( $v, array( 0, 1, 2, 3 ), true ) ) {
			return new WP_Error( 'validation', __( 'Données invalides. Vérifiez et réessayez.', 'cbs-theme' ) );
		}
		$out[ $i ] = $v;
	}

	return $out;
}

/**
 * @param array<string, mixed> $post Données $_POST sanitizées.
 * @return array<string, mixed>|WP_Error
 */
function cbs_validate_diagnostic_data( array $post ) {
	$contexte = isset( $post['contexte'] ) ? sanitize_text_field( (string) $post['contexte'] ) : '';
	$ctx_map  = cbs_diagnostic_context_map();
	if ( ! isset( $ctx_map[ $contexte ] ) ) {
		return new WP_Error( 'validation', __( 'Données invalides. Vérifiez et réessayez.', 'cbs-theme' ) );
	}

	$reponses = cbs_diagnostic_normalize_reponses( $post );
	if ( is_wp_error( $reponses ) ) {
		return $reponses;
	}

	if ( 'gestion' === $contexte ) {
		for ( $i = 2; $i <= 5; $i++ ) {
			if ( (int) $reponses[ $i ] !== 0 ) {
				return new WP_Error( 'validation', __( 'Données invalides. Vérifiez et réessayez.', 'cbs-theme' ) );
			}
		}
		$gs = isset( $post['gestion_salaries'] ) ? sanitize_text_field( (string) $post['gestion_salaries'] ) : '';
		$gr = isset( $post['gestion_rh'] ) ? sanitize_text_field( (string) $post['gestion_rh'] ) : '';
		$gg = isset( $post['gestion_gestion'] ) ? sanitize_text_field( (string) $post['gestion_gestion'] ) : '';
		$map_s = cbs_diagnostic_gestion_salaries_map();
		$map_r = cbs_diagnostic_gestion_rh_map();
		$map_g = cbs_diagnostic_gestion_mode_map();
		if ( ! isset( $map_s[ $gs ] ) || ! isset( $map_r[ $gr ] ) || ! isset( $map_g[ $gg ] ) ) {
			return new WP_Error( 'validation', __( 'Données invalides. Vérifiez et réessayez.', 'cbs-theme' ) );
		}
	} elseif (
		( isset( $post['gestion_salaries'] ) && (string) $post['gestion_salaries'] !== '' )
		|| ( isset( $post['gestion_rh'] ) && (string) $post['gestion_rh'] !== '' )
		|| ( isset( $post['gestion_gestion'] ) && (string) $post['gestion_gestion'] !== '' )
	) {
		return new WP_Error( 'validation', __( 'Données invalides. Vérifiez et réessayez.', 'cbs-theme' ) );
	}

	$prenom      = isset( $post['prenom'] ) ? sanitize_text_field( (string) $post['prenom'] ) : '';
	$nom         = isset( $post['nom'] ) ? sanitize_text_field( (string) $post['nom'] ) : '';
	$hotel       = isset( $post['hotel'] ) ? sanitize_text_field( (string) $post['hotel'] ) : '';
	$email       = isset( $post['email'] ) ? sanitize_email( (string) $post['email'] ) : '';
	$telephone   = isset( $post['telephone'] ) ? sanitize_text_field( (string) $post['telephone'] ) : '';
	$type_projet = isset( $post['type_projet'] ) ? sanitize_text_field( (string) $post['type_projet'] ) : '';
	$rgpd        = ! empty( $post['rgpd'] );

	$types = cbs_diagnostic_type_projet_map();
	if ( $prenom === '' || $nom === '' || $hotel === '' || ! is_email( $email ) || ! $rgpd ) {
		return new WP_Error( 'validation', __( 'Données invalides. Vérifiez et réessayez.', 'cbs-theme' ) );
	}

	if ( ! isset( $types[ $type_projet ] ) ) {
		return new WP_Error( 'validation', __( 'Données invalides. Vérifiez et réessayez.', 'cbs-theme' ) );
	}

	if ( $telephone !== '' && ! preg_match( '/^[\d\s+.()\-]{8,}$/', $telephone ) ) {
		return new WP_Error( 'validation', __( 'Données invalides. Vérifiez et réessayez.', 'cbs-theme' ) );
	}

	$pairs = array();
	foreach ( $reponses as $q => $pts ) {
		$pairs[] = (int) $q . ':' . (int) $pts;
	}

	$out = array(
		'prenom'          => $prenom,
		'nom'             => $nom,
		'hotel'           => $hotel,
		'email'           => $email,
		'telephone'       => $telephone,
		'type_projet'     => $type_projet,
		'type_projet_lib' => $types[ $type_projet ],
		'contexte'        => $contexte,
		'contexte_lib'    => $ctx_map[ $contexte ],
		'reponses'        => $reponses,
		'reponses_csv'    => 'ctx:' . $contexte . '|' . implode( ',', $pairs ),
	);

	if ( 'gestion' === $contexte ) {
		$gs                = sanitize_text_field( (string) $post['gestion_salaries'] );
		$gr                = sanitize_text_field( (string) $post['gestion_rh'] );
		$gg                = sanitize_text_field( (string) $post['gestion_gestion'] );
		$out['gestion_salaries']     = $gs;
		$out['gestion_salaries_lib'] = cbs_diagnostic_gestion_salaries_map()[ $gs ];
		$out['gestion_rh']           = $gr;
		$out['gestion_rh_lib']         = cbs_diagnostic_gestion_rh_map()[ $gr ];
		$out['gestion_gestion']        = $gg;
		$out['gestion_gestion_lib']    = cbs_diagnostic_gestion_mode_map()[ $gg ];
	}

	return $out;
}

/**
 * @param int $score Score 0–30.
 */
function cbs_diagnostic_niveau_from_score( int $score ): string {
	if ( $score >= 22 ) {
		return 'A';
	}
	if ( $score >= 13 ) {
		return 'B';
	}
	return 'C';
}

/**
 * @param array<string, mixed> $validated Données validées (diagnostic).
 */
function cbs_diagnostic_persist_and_notify( array $validated, int $score, string $niveau ): void {
	$fields = array(
		'Prénom'              => $validated['prenom'],
		'Nom'                 => $validated['nom'],
		'Hôtel / Société'     => $validated['hotel'],
		'Email'               => $validated['email'],
		'Téléphone'           => $validated['telephone'],
		'Type projet'         => $validated['type_projet_lib'],
		'Contexte diagnostic' => $validated['contexte_lib'],
		'Score'               => $score,
		'Niveau de résultat'  => $niveau,
		'Réponse détaillées' => $validated['reponses_csv'],
		'Source'              => __( 'Diagnostic site', 'cbs-theme' ),
		'Statut du Lead'      => __( 'Nouveau', 'cbs-theme' ),
	);

	if ( isset( $validated['gestion_salaries_lib'] ) ) {
		$fields['Qualitatif RH (salariés)'] = $validated['gestion_salaries_lib'];
		$fields['Qualitatif RH (défi)']    = $validated['gestion_rh_lib'];
		$fields['Qualitatif RH (gestion)'] = $validated['gestion_gestion_lib'];
	}

	if ( defined( 'CBS_AIRTABLE_TABLE_DIAGNOSTICS' ) && CBS_AIRTABLE_TABLE_DIAGNOSTICS ) {
		$result = cbs_send_to_airtable( (string) CBS_AIRTABLE_TABLE_DIAGNOSTICS, $fields );
		if ( is_wp_error( $result ) ) {
			cbs_log_error( 'airtable', $result->get_error_message(), array( 'source' => 'diagnostic' ) );
		}
	}

	$webhook = array(
		'email'           => $validated['email'],
		'prenom'          => $validated['prenom'],
		'nom'             => $validated['nom'],
		'hotel'           => $validated['hotel'],
		'telephone'       => $validated['telephone'],
		'score'           => $score,
		'niveau'          => $niveau,
		'type_projet'     => $validated['type_projet'],
		'type_projet_lib' => $validated['type_projet_lib'],
		'contexte'        => $validated['contexte'],
		'contexte_lib'    => $validated['contexte_lib'],
		'reponses_csv'    => $validated['reponses_csv'],
	);
	if ( isset( $validated['gestion_salaries'] ) ) {
		$webhook['gestion_salaries'] = $validated['gestion_salaries'];
		$webhook['gestion_rh']       = $validated['gestion_rh'];
		$webhook['gestion_gestion']  = $validated['gestion_gestion'];
	}
	cbs_trigger_make_webhook( 'diagnostic_completed', $webhook );
}

/**
 * Handler AJAX tunnel diagnostic (diagnostic-tunnel.md §8).
 */
function cbs_handle_diagnostic_submit(): void {
	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_success(
			array(
				'score'  => 0,
				'niveau' => 'C',
			)
		);
		return;
	}

	if ( ! cbs_check_rate_limit( 'diagnostic', 5, 3600 ) ) {
		wp_send_json_error(
			array(
				'message' => __( 'Trop de tentatives. Réessayez dans une heure.', 'cbs-theme' ),
				'code'    => 'rate_limited',
			),
			429
		);
		return;
	}

	check_ajax_referer( 'cbs_tunnel_nonce', 'nonce' );

	$validated = cbs_validate_diagnostic_data( wp_unslash( $_POST ) );
	if ( is_wp_error( $validated ) ) {
		wp_send_json_error(
			array(
				'message' => $validated->get_error_message(),
				'code'    => 'validation_failed',
			),
			400
		);
		return;
	}

	$score  = cbs_diagnostic_compute_score( $validated['reponses'], $validated['contexte'] );
	$niveau = cbs_diagnostic_niveau_from_score( $score );

	cbs_diagnostic_persist_and_notify( $validated, $score, $niveau );

	wp_send_json_success(
		array(
			'score'  => $score,
			'niveau' => $niveau,
		)
	);
}

/**
 * Handler AJAX formulaire contact (forms.md §5).
 */
function cbs_handle_contact_form(): void {
	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_success(
			array(
				'message' => __( 'Votre message a bien été envoyé. Nous vous répondrons sous 24h.', 'cbs-theme' ),
			)
		);
		return;
	}

	if ( ! cbs_check_rate_limit( 'contact', 3, 3600 ) ) {
		wp_send_json_error(
			array(
				'message' => __( 'Trop de tentatives. Réessayez dans une heure.', 'cbs-theme' ),
				'code'    => 'rate_limited',
			),
			429
		);
		return;
	}

	check_ajax_referer( 'cbs_contact_nonce', 'cbs_nonce' );

	$validated = cbs_contact_validate_payload( wp_unslash( $_POST ) );
	if ( is_wp_error( $validated ) ) {
		wp_send_json_error(
			array(
				'message' => $validated->get_error_message(),
				'code'    => 'validation_failed',
			),
			400
		);
		return;
	}

	$airtable_fields = array(
		'Prénom'          => $validated['prenom'],
		'Nom'             => $validated['nom'],
		'Hôtel / Société' => $validated['hotel'],
		'Email'           => $validated['email'],
		'Téléphone'       => $validated['telephone'],
		'Type projet'     => $validated['type_projet_lib'],
		'Message'         => $validated['message'],
		'Source'          => __( 'Formulaire contact', 'cbs-theme' ),
		'Statut du Lead'  => __( 'Nouveau', 'cbs-theme' ),
	);

	if ( defined( 'CBS_AIRTABLE_TABLE_DIAGNOSTICS' ) && CBS_AIRTABLE_TABLE_DIAGNOSTICS ) {
		$result = cbs_send_to_airtable( (string) CBS_AIRTABLE_TABLE_DIAGNOSTICS, $airtable_fields );
		if ( is_wp_error( $result ) ) {
			cbs_log_error( 'airtable', $result->get_error_message(), array( 'source' => 'contact' ) );
		}
	}

	cbs_trigger_make_webhook(
		'contact_form',
		array(
			'prenom'          => $validated['prenom'],
			'nom'             => $validated['nom'],
			'email'           => $validated['email'],
			'hotel'           => $validated['hotel'],
			'telephone'       => $validated['telephone'],
			'type_projet'     => $validated['type_projet'],
			'type_projet_lib' => $validated['type_projet_lib'],
			'message'         => $validated['message'],
		)
	);

	wp_send_json_success(
		array(
			'message' => __( 'Votre message a bien été envoyé. Nous vous répondrons sous 24h.', 'cbs-theme' ),
		)
	);
}

add_action( 'wp_ajax_nopriv_cbs_contact_form', 'cbs_handle_contact_form' );
add_action( 'wp_ajax_cbs_contact_form', 'cbs_handle_contact_form' );

add_action( 'wp_ajax_nopriv_cbs_diagnostic', 'cbs_handle_diagnostic_submit' );
add_action( 'wp_ajax_cbs_diagnostic', 'cbs_handle_diagnostic_submit' );
