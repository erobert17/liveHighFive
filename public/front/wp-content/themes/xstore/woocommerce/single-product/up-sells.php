<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$upsells = $product->get_upsell_ids();

if ( sizeof( $upsells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => array( 'product', 'product_variation' ),
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->get_id() ),
	'meta_query'          => $meta_query,
);

$sidebar_slider = false;

if( etheme_get_option( 'upsell_location' ) == 'sidebar' ) {
    $slider_args = array(
        'before'          => '<h4 class="widget-title"><span>' . esc_html__( 'You may like it', 'xstore' ) . '</span></h4>',
        'slider_autoplay' => false,
        'slider_speed'    => '0',
        'autoheight'      => false,
        'large'           => 1,
        'notebook'        => 1,
        'tablet_land'     => 2,
        'tablet_portrait' => 2,
        'mobile'          => 1,
        'attr'            => 'data-slidesPerColumn="3"',
        'widget'          => true,
        'echo'            => false
    );

	echo '<div class="sidebar-slider">' . etheme_slider( $args, 'product', $slider_args ) . '</div>';
} else {
	$slider_args = array(
		'title' 		  => '',
		'slider_autoplay' => false,
		'slider_speed'    => '0',
		'autoheight' 	  => false,
		'echo' 			  => true
	);
	echo '<h2 class="products-title"><span>' . esc_html__( 'You may like it', 'xstore' ) . '</span></h2>';
	etheme_slider( $args, 'product', $slider_args );
}


wp_reset_postdata();
