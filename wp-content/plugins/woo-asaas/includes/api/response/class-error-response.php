<?php
/**
 * API response handler class
 *
 * @package WooAsaas
 */

namespace WC_Asaas\Api\Response;

/**
 * API response handler class
 */
class Error_Response extends Response {


	/**
	 * Get response errors, if is error.
	 *
	 * @return \WP_Error|bool The error object, if has error. False, otherwise.
	 */
	public function get_errors() {
		$error = new \WP_Error();

		$customer_message         = __( 'An error processing your order. Contact us.', 'woo-asaas' );
		$default_customer_message = apply_filters( 'woocommerce_asaas_internal_api_error', $customer_message );

		if ( empty( $this->data ) ) {
			$log_message = sprintf( 'The Asaas API return a %d code.', $this->code );
			$this->client->get_gateway()->get_logger()->log( $log_message, 'emergency' );

			$error->add( 'internal-error', $default_customer_message );
		} else {
			foreach ( $this->get_json()->errors as $response_error ) {
				if ( 'invalid_action' === $response_error->code ) {
					$error->add( 'internal-error', $default_customer_message );
				} else {
					$error->add( $response_error->code, $response_error->description );
				}
			}
		}

		return $error;
	}
}
