<?php
/**
 * Values Formater Helper class
 *
 * @package WooAsaas
 */

namespace WC_Asaas\Split\Helper;

/**
 * Split Wallet formatter helper functions
 */
class Values_Formater_Helper {

	/**
	 * Converts an array of values into the database format.
	 *
	 * @param array $values The array of values to be converted.
	 * @return array The array of values converted into the database format.
	 */
	public function convert_into_database_format( array $values ) {
		$formatted_values = array();

		foreach ( $values as $item ) {
			$formatted_item = array(
				'nickname'        => sanitize_text_field( $item['nickname'] ),
				'walletId'        => sanitize_text_field( $item['walletId'] ),
				'percentualValue' => $this->format_to_float_value( $item['percentualValue'] ),
			);

			$formatted_values[] = $formatted_item;
		}

		return $formatted_values;
	}

	/**
	 * Validates the total percentual value of an array of sanitized values.
	 *
	 * @param array $wallets The array of sanitized values.
	 * @return bool Returns true if the total percentualValue is greater than 100, false otherwise.
	 */
	public function validate_percentual_total( array $wallets ) {
		$total = 0;

		foreach ( $wallets as $value ) {
			if ( isset( $value['percentualValue'] ) ) {
				$total += $this->format_to_float_value( $value['percentualValue'] );
			}
		}

		return $total > 100;
	}

	/**
	 * Validates the format of wallets in the given array.
	 *
	 * @param array $wallets An array of wallets to validate.
	 * @return array An array containing the invalid fields.
	 */
	public function validate_wallets_format( array $wallets ) {
		$invalid_fields = array();

		if ( empty( $wallets ) ) {
			return $invalid_fields;
		}

		foreach ( $wallets as $wallet => $value ) {
			if ( isset( $value['walletId'] ) ) {
				$valid_wallet_id = $this->valid_wallet_id( $value['walletId'] );

				if ( ! $valid_wallet_id ) {
					// translators: %s is the wallet incorrect field number.
					$invalid_fields[ $wallet ] = sprintf( __( 'The wallet %s contains an invalid ID format.', 'woo-asaas' ), $wallet + 1 );
				}
			}
		}

		return $invalid_fields;
	}

	/**
	 * Convert the given array of wallets into the API format.
	 *
	 * @param array $wallets The array of wallets to be converted.
	 * @return array The formatted array of wallets in the API format used in Assas.
	 */
	public function convert_into_wallet_api_format( array $wallets ) {
		$formatted_values = array();

		if ( empty( $wallets ) ) {
			return $formatted_values;
		}

		foreach ( $wallets as $wallet ) {
			if ( $this->valid_wallet_id( $wallet['walletId'] ) && $wallet['percentualValue'] > 0 ) {
				$formatted_wallet = array(
					'walletId'        => $wallet['walletId'],
					'percentualValue' => $wallet['percentualValue'],
				);

				$formatted_values[] = $formatted_wallet;
			}
		}

		return $formatted_values;
	}

	/**
	 * Convert the given array into an order note.
	 *
	 * @param array $wallets The array of wallets.
	 * @return int|string The formatted order note or 0 if the array is null.
	 */
	public function convert_into_order_note( array $wallets ) {
		if ( empty( $wallets ) ) {
			return 0;
		}

		$note_message = __( 'Split', 'woo-asaas' ) . PHP_EOL;

		foreach ( $wallets as $wallet ) {
			if ( ! empty( $wallet['nickname'] ) && $this->valid_wallet_id( $wallet['walletId'] ) && $wallet['percentualValue'] > 0 ) {
				$nickname         = sanitize_text_field( $wallet['nickname'] );
				$wallet_id        = sanitize_text_field( $wallet['walletId'] );
				$percentual_value = $this->format_to_float_value( $wallet['percentualValue'] );

				$note_message .= sprintf(
					// translators: %1$s%% is the percentual value, %2$s is the wallet nickname, %3$s is the wallet ID.
					__( '%1$s%% for wallet %2$s Wallet ID: %3$s', 'woo-asaas' ),
					$percentual_value,
					$nickname,
					$wallet_id
				) . PHP_EOL;
			} else {
				$note_message .= __( 'There are invalid wallets for this request. See the log for more details.', 'woo-asaas' ) . PHP_EOL;
				break;
			}
		}

		return $note_message;
	}

	/**
	 * Convert an array of wallets into log format info.
	 *
	 * @param array $wallets The array of wallets to convert.
	 * @return array The converted array of wallets in log format.
	 */
	public function convert_into_log_format( array $wallets ) {
		$messages = array();

		if ( empty( $wallets ) ) {
			return $messages;
		}

		foreach ( $wallets as $wallet ) {
			if ( ! $this->valid_wallet_id( $wallet['walletId'] ) || $wallet['percentualValue'] <= 0 ) {
				// translators: %s is the nickname field.
				$messages[] = sprintf( __( 'Split to %s wallet was not processed due to invalid Wallet ID format or percentual value equal to zero.', 'woo-asaas' ), $wallet['nickname'] );
				continue;
			}

			$messages[] = sprintf(
				// translators: %1$s is the percentual value, %2$s is the wallet nickname, %3$s is the wallet ID.
				__( 'Split configured at the value of %1$s%% for wallet %2$s Wallet ID: %3$s', 'woo-asaas' ),
				$wallet['percentualValue'],
				$wallet['nickname'],
				$wallet['walletId']
			);
		}

		return $messages;
	}

	/**
	 * Validates a wallet ID.
	 * Supported patterns (UUID v1/v2/v3/v4/v5)
	 *
	 * @param string $wallet_id The wallet ID string in UUID format.
	 * @return bool Returns true if the wallet ID is valid, false otherwise.
	 */
	public function valid_wallet_id( string $wallet_id ) {
		$pattern         = '/^[a-f\d]{8}-[a-f\d]{4}-[a-f\d]{4}-[a-f\d]{4}-[a-f\d]{12}$/i';
		$valid_wallet_id = (bool) preg_match( $pattern, $wallet_id );

		return $valid_wallet_id;
	}

	/**
	 * Formats a string value to a float value.
	 *
	 * @param string $value The string value to be formatted.
	 * @return float The formatted float value.
	 */
	public function format_to_float_value( string $value ) {
		$formatted_value = abs( floatval( str_replace( ',', '.', $value ) ) );

		return $formatted_value;
	}

	/**
	 * Displays an error message in the admin notices.
	 *
	 * @param string $error_message The error message to be displayed.
	 */
	public function show_notice_message_error( string $error_message ) {
		add_action(
			'admin_notices', function () use ( $error_message ) {
				?>
			<div class="notice notice-error is-dismissible">
				<p>
					<?php echo wp_kses_post( '<strong>Split:</strong>' ); ?>
					<?php echo wp_kses_post( $error_message ); ?>
				</p>
			</div>
				<?php
			}
		);
	}
}
