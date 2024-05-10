<?php
/**
 * Show Split wallets section table.
 *
 * @package WooAsaas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<tr valign="top">
	<th scope="row" class="titledesc">
		<label for="<?php echo esc_attr( $args['field_key'] . '[1][nickname]' ); ?>">
			<?php echo esc_attr( $args['data']['title'] ); ?>
		</label>
	</th>
	<td class="forminp">
		<table class="wc_gateways widefat" cellspacing="0">
			<thead>
				<tr>
					<th class="sort">
						<?php esc_attr_e( 'Wallet', 'woo-asaas' ); ?>
					</th>
					<th class="sort">
						<?php esc_attr_e( 'Nickname', 'woo-asaas' ); ?>
					</th>
					<th class="name">
						<?php esc_attr_e( 'Wallet ID', 'woo-asaas' ); ?>
					</th>
					<th class="name">
						<?php esc_attr_e( 'Percentage', 'woo-asaas' ); ?>
					</th>
				</tr>
			</thead>
			<tbody class="split-wallet__list">
				<?php
				for ( $wallet = 1; $wallet <= $args['wallets']; $wallet++ ) :
					$wallet_index = $wallet - 1;
					$wallet_data  = isset( $args['split_wallet'][ $wallet_index ] ) ? $args['split_wallet'][ $wallet_index ] : array();
					// translators: %s is the wallet number.
					$nickname_value   = ! empty( $wallet_data['nickname'] ) ? $wallet_data['nickname'] : sprintf( __( 'Wallet %s', 'woo-asaas' ), $wallet );
					$wallet_value     = $wallet_data['walletId'] ?? '';
					$percentual_value = $wallet_data['percentualValue'] ?? 0;
					?>
					<tr>
						<td width="10%">
							<?php echo esc_attr( $wallet ); ?>
						</td>
						<td>
							<input class="small-input" type="text"
								name="<?php echo esc_attr( $field_key ); ?>[<?php echo esc_attr( $wallet ); ?>][nickname]"
								id="<?php echo esc_attr( $field_key ); ?>[<?php echo esc_attr( $wallet ); ?>][nickname]"
								value="<?php echo esc_attr( $nickname_value ); ?>" />
						</td>
						<td>
							<input class="small-input" type="text"
								name="<?php echo esc_attr( $field_key ); ?>[<?php echo esc_attr( $wallet ); ?>][walletId]"
								id="<?php echo esc_attr( $field_key ); ?>[<?php echo esc_attr( $wallet ); ?>][walletId]"
								value="<?php echo esc_attr( $wallet_value ); ?>" />
						</td>
						<td>
							<input class="small-input" type="text"
								name="<?php echo esc_attr( $field_key ); ?>[<?php echo esc_attr( $wallet ); ?>][percentualValue]"
								id="<?php echo esc_attr( $field_key ); ?>[<?php echo esc_attr( $wallet ); ?>][percentualValue]"
								value="<?php echo esc_attr( floatval( $percentual_value ) ); ?>" placeholder="0" /> %
						</td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	</td>
</tr>
