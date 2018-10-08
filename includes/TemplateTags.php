<?php
/**
 * Function that load a template file and template date.
 *
 * @param string $__template_file the template file.
 * @param srray $__template_data the template date.
 */
function tscmm_get_template( $__template_file, array $__template_data = [ ] ) {

	$__template_file = apply_filters(
		'tscTSC\ManagedMissionsTemplate',
		TSCMM_PATH . "views/$__template_file.php",
		$__template_file,
		$__template_data
	);

	if ( $__template_file && file_exists( $__template_file ) ) {
		extract( $__template_data, EXTR_SKIP );
		require $__template_file;
	}
}

/**
 * Funtion that returns the Managed Missions options.
 *
 * @return array an array of options.
 */
function tscmm_get_options() {

	$options = get_option( 'tsc-managed-missions-options' );

	return $options;
}

/**
 * Function that returns the API Call Type.
 *
 * @return string the API Call Type
 */
function tscmm_get_api_call_type() {

	$options = tscmm_get_options();
	$callType = ! empty( $options['api-call-type'] ) ? $options['api-call-type'] : '';

	return $callType;
}

/**
 * Function that returns the Managed Missions API Key.
 *
 * @return string the API Key.
 */
function tscmm_get_api_key() {

	$options = tscmm_get_options();
	$key = ! empty( $options['api-key'] ) ? $options['api-key'] : '';

	return $key;
}

/**
 * Function that returns the query params for the API call.
 *
 * @return script the query params.
 */
function tscmm_get_api_query_params() {

	$options = tscmm_get_options();
	$queryParams = ! empty( $options['api-query-params'] ) ? $options['api-query-params'] : '';

	return $queryParams;
}
