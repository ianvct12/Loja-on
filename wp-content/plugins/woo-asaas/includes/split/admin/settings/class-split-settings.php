<?php
/**
 * Split Settings class
 *
 * @package WooAsaas
 */

namespace WC_Asaas\Split\Admin\Settings;

use WC_Asaas\Admin\View;
use WC_Asaas\Api\Api_Limit;
use WC_Asaas\Gateway\Gateway;
use WC_Asaas\Split\Admin\Settings\Default_Split_Settings;
use WC_Asaas\Split\Helper\Values_Formater_Helper;

/**
 * Split settings common methods
 */
class Split_Settings {


	/**
	 * The billing type object data
	 *
	 * @var Gateway
	 */
	protected $gateway;

	/**
	 * Default settings
	 *
	 * @var Default_Split_Settings
	 */
	protected $default_settings;

	/**
	 * Init the default field sections
	 *
	 * @param Gateway $gateway The gateway that call the logger.
	 */
	public function __construct( $gateway ) {
		$this->gateway          = $gateway;
		$this->default_settings = $this->default_settings();
	}

	/**
	 * Split default settings.
	 *
	 * @return array The settings.
	 */
	private function default_settings() {
		$api_limit        = new Api_Limit();
		$default_settings = new Default_Split_Settings( $this->gateway, $api_limit );

		return $default_settings;
	}

	/**
	 * Validate the default wallet value setting
	 *
	 * @param string $value The input value.
	 * @return int The value sanitized.
	 */
	public function validate_wallet_value_field( string $value ) {
		$value            = floatval( str_replace( ',', '.', $value ) );
		$min_wallet_value = $this->default_settings->get_min_wallet_value();

		if ( $min_wallet_value > $value ) {
			return $min_wallet_value;
		}

		return str_replace( '.', ',', $value );
	}

	/**
	 * Render custom type attribute.
	 *
	 * @param string $key The split wallet value key.
	 * @param array  $data Field config data.
	 * @return string
	 */
	public function generate_split_wallet_html( string $key, array $data ) {
		$wallet_value = absint( $this->gateway->settings['wallets'] );

		if ( 0 === $wallet_value ) {
			return '';
		}

		$field_key    = $this->gateway->get_field_key( $key );
		$value        = (array) $this->gateway->get_option( $key, array() );
		$split_wallet = $this->gateway->settings['split_wallet'];

		$args = array(
			'value'        => $value,
			'data'         => $data,
			'field_key'    => $field_key,
			'wallets'      => $wallet_value,
			'split_wallet' => $split_wallet,
		);

		return View::get_instance()->get_template_file( 'split-wallet-list.php', $args, true, 'split' );
	}

	/**
	 * Validate the split wallet values setting.
	 *
	 * @param array|null $value The input value.
	 * @return array|null The value sanitized.
	 */
	public function validate_split_wallet_field( $value ) {
		if ( false === is_array( $value ) ) {
			return $value;
		}

		$wallet_value = (int) $this->gateway->settings['wallets'];
		$split_wallet = $this->gateway->settings['split_wallet'];

		$formater_helper = new Values_Formater_Helper();

		$wallets            = $formater_helper->convert_into_database_format( $value );
		$invalid_wallets    = $formater_helper->validate_wallets_format( $wallets );
		$invalid_percentual = $formater_helper->validate_percentual_total( $wallets );

		if ( count( $value ) === $wallet_value && $invalid_wallets ) {
			$invalid_fields_messages = implode( '<br>', array_values( $invalid_wallets ) );
			// translators: %s is the invalid messages.
			$invalid_wallet_messages = sprintf( __( 'Wallets without a nickname, invalid ID or percentage equal to zero will not be processed at checkout.<br><br> %s', 'woo-asaas' ), $invalid_fields_messages );
			$formater_helper->show_notice_message_error( $invalid_wallet_messages );
		}

		if ( $invalid_percentual ) {
			$formater_helper->show_notice_message_error( __( 'The sum of the split wallets cannot exceeds 100%.', 'woo-asaas' ) );

			$prev_values = $split_wallet;
			return $prev_values;
		}

		return $wallets;
	}
}
