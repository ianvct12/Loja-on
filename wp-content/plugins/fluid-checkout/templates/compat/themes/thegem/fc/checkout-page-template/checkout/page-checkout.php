<?php
/**
 * The checkout template file.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/page-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package fluid-checkout
 * @version 3.0.4
 */

defined( 'ABSPATH' ) || exit;

// Replace header with our distraction free template
if ( class_exists( 'FluidCheckout_CheckoutPageTemplate' ) && FluidCheckout_CheckoutPageTemplate::instance()->is_distraction_free_header_footer_checkout() ) {
	wc_get_template( 'checkout/page-checkout-header.php' );
}
// Display the site's default header
else {
	get_header( 'checkout' );
}
?>

<?php // CHANGE: Add theme's page title ?>
<?php
if ( class_exists( 'FluidCheckout_ThemeCompat_TheGem' ) && method_exists( 'FluidCheckout_ThemeCompat_TheGem', 'maybe_display_page_title' ) ) {
	FluidCheckout_ThemeCompat_TheGem::instance()->maybe_display_page_title();
}
?>

<div class="fc-content <?php echo esc_attr( apply_filters( 'fc_content_section_class', '' ) ); ?>">

	<?php // CHANGE: Add inner `div` container used by theme ?>
	<div class="container">

		<h1 class="fc-checkout__title <?php echo false === apply_filters( 'fc_display_checkout_page_title', false ) ? 'screen-reader-text' : ''; ?>"><?php the_title(); ?></h1>

		<?php
		// Load the checkout page content
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>

	<?php // CHANGE: Add closing `div` tag ?>
	</div>

</div>

<?php
// Replace footer with our distraction free template
if ( class_exists( 'FluidCheckout_CheckoutPageTemplate' ) && FluidCheckout_CheckoutPageTemplate::instance()->is_distraction_free_header_footer_checkout() ) {
	wc_get_template( 'checkout/page-checkout-footer.php' );
}
// Display the site's default footer
else {
	get_footer( 'checkout' );
}
