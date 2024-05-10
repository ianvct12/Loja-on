<?php
/**
 * Default Split Settings class
 *
 * @package WooAsaas
 */

namespace WC_Asaas\Split\Admin\Settings;

use WC_Asaas\Api\Api_Limit;
use WC_Asaas\Gateway\Gateway;

/**
 * Split default settings values
 */
class Default_Split_Settings {

	/**
	 * The prefix gateway
	 *
	 * @var string
	 */
	private $gateway_prefix;

	/**
	 * The Api Limit object
	 *
	 * @var Api_Limit
	 */
	private $api_limit;

	/**
	 * Constructor
	 *
	 * @param Gateway   $gateway The gateway object.
	 * @param Api_Limit $api_limit The api limit object.
	 */
	public function __construct( Gateway $gateway, Api_Limit $api_limit ) {
		$this->gateway_prefix = $gateway->prefix();
		$this->api_limit      = $api_limit;
	}

	/**
	 * Retrieves the value of the wallet.
	 *
	 * @return string The value of the wallet.
	 */
	public function get_min_wallet_value() {
		$default_wallet_value = $this->api_limit->min_wallet_value();

		return apply_filters( "woocommerce_asaas_{$this->gateway_prefix}_wallets", $default_wallet_value );
	}
}
