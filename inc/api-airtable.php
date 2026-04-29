<?php
/**
 * CBS Theme — api-airtable.php
 * Envoi d’enregistrements vers l’API Airtable.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Crée un enregistrement dans une table Airtable.
 *
 * @param string               $table_id ID table (ex. CBS_AIRTABLE_TABLE_DIAGNOSTICS).
 * @param array<string, mixed> $fields   Champs (noms colonnes Airtable).
 * @return array<string, mixed>|WP_Error
 */
function cbs_send_to_airtable( string $table_id, array $fields ) {
	if ( ! defined( 'CBS_AIRTABLE_API_KEY' ) || ! defined( 'CBS_AIRTABLE_BASE_ID' ) ) {
		return new WP_Error( 'missing_config', 'Airtable non configuré.' );
	}

	$url  = 'https://api.airtable.com/v0/' . rawurlencode( (string) CBS_AIRTABLE_BASE_ID ) . '/' . rawurlencode( $table_id );
	$body = wp_json_encode( array( 'fields' => $fields ) );

	$response = wp_remote_post(
		$url,
		array(
			'headers' => array(
				'Authorization' => 'Bearer ' . CBS_AIRTABLE_API_KEY,
				'Content-Type'  => 'application/json',
			),
			'body'    => $body,
			'timeout' => 15,
		)
	);

	if ( is_wp_error( $response ) ) {
		return $response;
	}

	$code = wp_remote_retrieve_response_code( $response );
	$data = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( $code < 200 || $code >= 300 ) {
		$msg = is_array( $data ) && isset( $data['error']['message'] )
			? (string) $data['error']['message']
			: 'Erreur Airtable inconnue.';

		return new WP_Error( 'airtable_error', $msg, array( 'status' => $code ) );
	}

	return is_array( $data ) ? $data : array();
}
