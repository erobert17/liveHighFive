<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product, $etheme_global, $post;
$product_settings = etheme_get_option('quick_view_switcher');
$product_settings = $product_settings['enabled'];

$zoom = etheme_get_option('zoom_effect');
if( class_exists( 'YITH_WCWL_Init' ) ) {
	add_action( 'woocommerce_single_product_summary', function () { echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );}, 31 );
}
remove_all_actions( 'woocommerce_product_thumbnails' );

$etheme_global['quick_view'] = true;

if( get_option('yith_wcwl_button_position') == 'shortcode' ) {
	add_action( 'woocommerce_after_add_to_cart_button', 'etheme_wishlist_btn', 30 );
}

$class = '';
if ( etheme_get_option('quick_view_layout') == 'centered' ) $class = 'text-center';
if ( etheme_get_option('quick_images') == 'slider') $class .= ' swipers-couple-wrapper swiper-entry arrows-hovered';

$product_class = array();
$product_class[] = 'product-content';
$product_class[] = 'quick-view-layout-' . etheme_get_option( 'quick_view_layout' );
$product_class[] = ( $product->is_sold_individually() ) ? 'sold-individually' : '' ;

?>

    <div <?php wc_product_class( $product_class ); ?> >
        <div class="row">

			<?php if (etheme_get_option('quick_images') != 'none'): ?>
				<div class="col-lg-6 col-sm-6 product-images <?php echo esc_attr($class); ?>">
					<?php
                    if (etheme_get_option('quick_images') == 'slider'): ?>
						<?php
						/**
						 * woocommerce_before_single_product_summary hook
						 *
						 * @hooked woocommerce_show_product_sale_flash - 10
						 * @hooked woocommerce_show_product_images - 20
						 */
						do_action( 'woocommerce_before_single_product_summary' );
						?>
					<?php else: ?>
						<?php the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) ); ?>
					<?php endif; ?>
				</div><!-- Product images/ END -->
			<?php endif; ?>
            
            <div class="col-lg-<?php if (etheme_get_option('quick_images') != 'none'): ?>6<?php else: ?>12<?php endif; ?> col-sm-6 product-information <?php if (!array_key_exists('quick_categories', $product_settings)) { echo 'hide-categories'; } ?>">
				<?php if (array_key_exists('quick_product_name', $product_settings)): ?>
					<h3 class="product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php endif ?>

				<div class="quick-view-info">

					<?php if (array_key_exists('quick_price', $product_settings)): ?>
						<?php woocommerce_template_single_price(); ?>
					<?php endif; ?>

					<?php if (array_key_exists('quick_rating', $product_settings)): ?>
						<?php woocommerce_template_single_rating(); ?>
					<?php endif ?>

					<?php if (array_key_exists('quick_short_descr', $product_settings)): ?>
						<?php woocommerce_template_single_excerpt(); ?>
					<?php endif ?>

					<?php do_action( 'et_quick_view_swatch' ); ?>

					<?php
						if (array_key_exists('quick_add_to_cart', $product_settings)) {
							if( $product->get_type() == 'simple' ) {
								woocommerce_template_single_add_to_cart();
							} else {
								woocommerce_template_loop_add_to_cart();
							}
						}

						woocommerce_template_single_meta();
					?>

					<?php if ( array_key_exists('quick_share', $product_settings)) : ?>
						<div class="product-share">
	                		<?php echo do_shortcode('[share title="' . esc_html__( 'Share:', 'xstore' ) . '" text="' . get_the_title() . '"]'); ?>
	           			</div>
					<?php endif ?>

				</div>

				<?php
					$length = etheme_get_option( 'quick_descr_length' );
					$length = ( $length ) ? $length : 120;
					$description = etheme_trunc( etheme_strip_shortcodes(get_the_content()), $length );
					$description = trim($description);
				?>
				
				<?php if (etheme_get_option( 'quick_descr' ) && !empty( $description )): ?>
					<div class="quick-view-excerpts">
						<div class="excerpt-title"><?php esc_html_e('Details', 'xstore'); ?></div>
						<div class="excerpt-content">
							<div class="excerpt-content-inner">
								<?php echo wp_kses_post($description); ?>
							</div>
						</div>
						<?php if (array_key_exists('product_link', $product_settings)): ?>
							<a href="<?php the_permalink(); ?>" class="show-full-details"><?php esc_html_e('Show full details', 'xstore'); ?></a>
						<?php endif; ?>
					</div>
				<?php elseif (array_key_exists('product_link', $product_settings)): ?>
					<a href="<?php the_permalink(); ?>" class="show-full-details"><?php esc_html_e('Show full details', 'xstore'); ?></a>
				<?php endif; ?>

            </div><!-- Product information/ END -->
        </div>
        
    </div> <!-- CONTENT/ END -->