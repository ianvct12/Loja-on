<?php defined('ABSPATH') || exit;

$editor_mode = (\Elementor\Plugin::$instance->editor->is_edit_mode() || is_preview());

if($editor_mode) {

	global $wp_query, $post;
	$main_query = clone $wp_query;
	$main_post = clone $post;

	$wp_query = new \WP_Query([]);
}

\ShopEngine\Widgets\Widget_Helper::instance()->wc_template_filter();

\ShopEngine\Widgets\Widget_Helper::instance()->wc_template_part_filter();

?>

<?php 
	if ( is_plugin_active( 'iconic-woo-image-swap/iconic-woo-image-swap.php' ) )
	{
		global $iconic_woo_image_swap_class;
		remove_action('woocommerce_before_shop_loop_item',array($iconic_woo_image_swap_class,'template_loop_product_thumbnail'),5);
				
	}
?>

<?php 
	//blocksy theme conflict issue
     $themeName = get_template();
	if($themeName == 'blocksy'):?>
	 <?php remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 ); ?>
	<?php endif;
?>

<div class="shopengine-related <?php echo ($is_slider_enable ? 'slider-enabled' : 'slider-disabled'); ?>" data-controls="<?php echo esc_attr($encode_slider_options); ?>">
	<?php

	$relatedProduct = $args['related_products'];
	
	if(empty($relatedProduct)) {
		?>
		<p style="font-size: 18px; font-weight:600"><?php echo esc_html__('No related products found.', 'shopengine'); ?></p>
		<?php
	} else{
		woocommerce_related_products($args);
		if($is_slider_enable && $shopengine_related_product_slider_show_dots) {
			echo '<div class="swiper-pagination" style="width: 100%;"></div>';
		}
	
		if($is_slider_enable && $shopengine_related_product_slider_show_arrows) {
			shopengine_content_render(
				sprintf(
					'<div class="swiper-button-prev">%1$s</div><div class="swiper-button-next">%2$s</div>',
					$this->get_icon_html($shopengine_related_product_slider_left_arrow_icon),
					$this->get_icon_html($shopengine_related_product_slider_right_arrow_icon)
				)
			);
		}
	}

	

	
	?>
</div>

<?php

if($editor_mode) {
	global $wp_query, $post;

	$wp_query = $main_query;
	$post = $main_post;
	wp_reset_query();
	wp_reset_postdata();
}
