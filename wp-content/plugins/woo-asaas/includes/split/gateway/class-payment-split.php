<?php
/**
 * Payment Split class
 *
 * @package WooAsaas
 */

namespace WC_Asaas\Split\Gateway;

use Exception;
use WC_Order;
use WC_Asaas\Gateway\Gateway;
use WC_Asaas\Split\Helper\Values_Formater_Helper;

/**
 * Handle init payment splits.
 */
class Payment_Split {


	/**
	 * Instance of this class
	 *
	 * @var self
	 */
	protected static $instance = null;

	/**
	 * Is not allowed to call from outside to prevent from creating multiple instances.
	 */
	private function __construct() {
	}

	/**
	 * Prevent the instance from being cloned.
	 */
	private function __clone() {
	}

	/**
	 * Prevent from being unserialized.
	 *
	 * @throws Exception If create a second instance of it.
	 */
	public function __wakeup() {
		throw new Exception( esc_html__( 'Cannot unserialize singleton', 'woo-asaas' ) );
	}

	/**
	 * Return an instance of this class
	 *
	 * @return self A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Handle with Gateway payment split.
	 *
	 * @param array    $payment_data Number of split.
	 * @param WC_Order $wc_order WC Order object.
	 * @param Gateway  $gateway Current payment gateway.
	 */
	public function split_payment_data( array $payment_data, WC_Order $wc_order, Gateway $gateway ) {
		$wallets = $gateway->settings['split_wallet'];

		if ( null === $wallets ) {
			return $payment_data;
		}

		$wc_order->add_order_note( $this->order_notes( $wallets ) );

		$this->add_split_log( $gateway, $wallets );

		$split_data = $this->split_api_format( $wallets );
		if ( ! empty( $split_data ) ) {
			$payment_data['split'] = $split_data;
		}

		return $payment_data;
	}

	/**
	 * Generates the function comment for the given function body.
	 *
	 * @param array $wallets The array of wallets.
	 * @return int|string The order note.
	 */
	private function order_notes( array $wallets ) {
		$order_note = ( new Values_Formater_Helper() )->convert_into_order_note( $wallets );
		return $order_note;
	}

	/**
	 * Adds the split log for the given gateway and wallets.
	 *
	 * @param Gateway $gateway The gateway object.
	 * @param array   $wallets An array of wallets.
	 */
	private function add_split_log( Gateway $gateway, array $wallets ) {
		$messages = ( new Values_Formater_Helper() )->convert_into_log_format( $wallets );
		if ( empty( $messages ) ) {
			return;
		}
		foreach ( $messages as $message ) {
			$gateway->get_logger()->log( $message );
		}
	}

	/**
	 * Convert the given array of wallets into the API format used by Asaas.
	 *
	 * @param array $wallets The array of wallets to be converted.
	 * @return array The formatted wallets in the API format.
	 */
	private function split_api_format( array $wallets ) {
		$formatted_wallets = ( new Values_Formater_Helper() )->convert_into_wallet_api_format( $wallets );
		return $formatted_wallets;
	}
}
