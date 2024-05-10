<?php
/**
 * Split Settings Section class
 *
 * @package WooAsaas
 */

namespace WC_Asaas\Split\Admin\Settings;

use Exception;
use WC_Asaas\Admin\Settings\Settings;
use WC_Asaas\Api\Api_Limit;

/**
 * Split section fields for gateway settings
 */
class Split_Settings_Fields {


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
	 * Add split gateway settings section.
	 *
	 * @param array    $sections Gateway sections.
	 * @param Settings $settings Gateway settings object.
	 * @return array
	 */
	public function add_section( $sections, $settings ) {
		return array_merge(
			$sections,
			array(
				'split' => array(
					'title'       => __( 'Split', 'woo-asaas' ),
					'priority'    => 10,
					'description' => __( 'Split does not support subscriptions.', 'woo-asaas' ),
				),
			)
		);
	}

	/**
	 * Add split gateway settings fields.
	 *
	 * @param array    $fields Gateway fields.
	 * @param Settings $settings Gateway settings object.
	 * @return array
	 */
	public function add_fields( $fields, $settings ) {
		$gateway          = $settings->gateway;
		$api_limit        = new Api_Limit();
		$split_settings   = new Split_Settings( $settings->gateway );
		$default_settings = new Default_Split_Settings( $gateway, $api_limit );

		$default_wallet_value = $default_settings->get_min_wallet_value();

		return array_merge(
			$fields,
			array(
				'wallets'      => array(
					'title'             => __( 'Wallet quantity', 'woo-asaas' ),
					'type'              => 'text',
					/* translators: %s: minimum wallets quantity value  */
					'description'       => sprintf( __( 'Defines the number of wallets. Use <code>%s</code> to disable this option.', 'woo-asaas' ), $default_wallet_value ),
					'default'           => $default_wallet_value,
					'section'           => 'split',
					'priority'          => 10,
					'sanitize_callback' => array( $split_settings, 'validate_wallet_value_field' ),
				),
				'split_wallet' => array(
					'title'             => __( 'Wallets', 'woo-asaas' ),
					'type'              => 'split_wallet',
					'section'           => 'split',
					'priority'          => 50,
					'sanitize_callback' => array( $split_settings, 'validate_split_wallet_field' ),
				),
			)
		);
	}
}
