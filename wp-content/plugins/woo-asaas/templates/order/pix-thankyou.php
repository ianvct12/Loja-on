<?php
/**
 * Pix print link
 *
 * @package WooAsaas
 */

use WC_Asaas\Helper\Checkout_Helper;
use WC_Asaas\WC_Asaas;

$checkout_helper = new Checkout_Helper();
$data            = $order->get_meta_data();

?>
<section class="woocommerce-order-details">
	<h2 class="woocommerce-order-details__title"><?php esc_html_e( 'Payment details', 'woo-asaas' ); ?></h2>

	<?php if ( false !== $data ): ?>
		<ul class="order_details">
			<li>
				<?php esc_html_e( 'Pay with Pix.', 'woo-asaas' ); ?>
			</li>
			<li class="asaas-pix-instructions">
				<img
					class="js-pix-qr-code"
					height="250px" width="250px"
					src="data:image/jpeg;base64,
					<?php /* phpcs:ignore WordPress.NamingConventions.ValidVariableName.NotSnakeCaseMemberVar */ echo esc_attr( $data->encodedImage ); ?>"
					alt="QR Code Pix"
				>
				<?php
				WC_Asaas::get_instance()->get_template_file(
					'order/pix-thankyou-instructions.php', array(
						'show_copy_and_paste' => $show_copy_and_paste,
						'expiration_time'     => $expiration_time,
						'expiration_period'   => $expiration_period,
					)
				);
				?>
			</li>
			<?php if ( true === $show_copy_and_paste ) : ?>
			<li class="asaas-pix-copy-to-clipboard">
				<div>
					<p class="woocommerce-order-details__asaas-pix-payload"><?php echo esc_attr( $data->payload ); ?></p>
					<input class="woocommerce-order-details__asaas-pix-code" type="hidden" value="<?php echo esc_attr( $data->payload ); ?>">
					<button class="button woocommerce-order-details__asaas-pix-button" data-success-copy="<?php esc_html_e( 'Code copied to clipboard', 'woo-asaas' ); ?>">
						<?php esc_html_e( 'Click here to copy the Pix code', 'woo-asaas' ); ?>
					</button>
				</div>
			</li>
			<?php endif; ?>
		</ul>		
	<?php else: ?>
		<?php 
		$wc_order = $order->get_wc();
		$total    = $wc_order->get_total();
		if ( 0 >= $total ) {
			if ( true === $order->has_subscription() ) {
				$subscriptions = wcs_get_subscriptions_for_order( $wc_order, array( 'order_type' => array( 'any' ) ) );
				foreach ( $subscriptions as $subscription ) {
					$trial_end     = $subscription->get_date( 'trial_end', 'site' );
					$trial_end_fmt = date_i18n( 'd/M/Y H:i', strtotime( $trial_end ) );
					break;
				}
				/* translators: %1$s: trial end date  */
				$message = sprintf( esc_html__( 'This order does not require payment at this time. Your trial period has started and is valid until %1$s.', 'woo-asaas' ), $trial_end_fmt );
			} else {
				$message = esc_html__( 'This order does not require payment at this time.', 'woo-asaas' );
			}
		} else {
			$message = esc_html__( 'Unable to load payment details.', 'woo-asaas' );
		}
		wc_print_notice( $message, 'notice' );
		?>
	<?php endif; ?>
</section>
