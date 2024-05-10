<?php
/**
 * Credit card status after checkout
 *
 * @package WooAsaas
 */

use WC_Asaas\Helper\Checkout_Helper;

$checkout_helper = new Checkout_Helper();
$data            = $order->get_meta_data();

?>
<section class="woocommerce-order-details">
	<h2 class="woocommerce-order-details__title"><?php esc_html_e( 'Payment details', 'woo-asaas' ); ?></h2>

	<?php if ( false !== $data ): ?>
		<ul class="order_details">
			<li>
				<?php
					/* translators: %s: the order status  */
					echo wp_kses_post( sprintf( __( 'Status: <strong>%s</strong>', 'woo-asaas' ), $checkout_helper->convert_status( $data->status ) ) );
				?>
			</li>
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
