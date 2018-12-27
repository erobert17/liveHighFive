<?php  if ( ! defined('ABSPATH')) exit('No direct script access allowed');

// **********************************************************************// 
// ! Load complicated shortcodes
// **********************************************************************// 


add_action( 'init', 'xstore_shortcodes_init');
if( ! function_exists( 'xstore_shortcodes_init' ) ) {
    function xstore_shortcodes_init() {
        if(! class_exists('ETheme_Blog_Shortcodes')) return;
        $blog = new ETheme_Blog_Shortcodes();

        add_shortcode('banner','etheme_banner_shortcode');
        add_shortcode('etheme_carousel', 'etheme_carousel_shortcode');
        add_shortcode('etheme_brands', 'etheme_brands_shortcode');
        add_shortcode('et_category','etheme_category_shortcode');
        add_shortcode('etheme_categories','etheme_categories_shortcode');
        add_shortcode('etheme_categories_lists','etheme_categories_lists_shortcode');
        add_shortcode('follow', 'etheme_follow_shortcode');
        add_shortcode('icon_box','etheme_icon_box_shortcode');
        add_shortcode('instagram','etheme_instagram_shortcode');
        add_shortcode('et_looks', 'etheme_looks_shortcode');
        add_shortcode('etheme_products','etheme_products_shortcode');
        add_shortcode('team_member','etheme_team_member_shortcode');
        add_shortcode('et_the_look', 'etheme_the_look_shortcode');
        add_shortcode('et_offer', 'etheme_offer_shortcode');
        add_shortcode('title','etheme_title_shortcode');
        add_shortcode('twitter','etheme_twitter_shortcode');

        add_shortcode('quick_view', 'etheme_quick_view_shortcodes');
        add_shortcode('button', 'etheme_btn_shortcode');
        add_shortcode('counter', 'etheme_counter_shortcode');
        add_shortcode('dropcap', 'etheme_dropcap_shortcode');
        add_shortcode('mark', 'etheme_mark_shortcode');
        add_shortcode('blockquote', 'etheme_blockquote_shortcode');
        add_shortcode('checklist', 'etheme_checklist_shortcode');
        add_shortcode('countdown','etheme_countdown_shortcode');
        add_shortcode('qrcode', 'etheme_qrcode_shortcode');
        add_shortcode('project_links', 'etheme_project_links');
        add_shortcode('tooltip', 'etheme_tooltip_shortcode');
        add_shortcode('share', 'etheme_share_shortcode');
        add_shortcode('block','etheme_block_shortcode');
        add_shortcode('et_blog', array($blog, 'blog') );
        add_shortcode('et_blog_timeline', array($blog, 'blog_timeline') );
        add_shortcode('et_blog_list', array($blog, 'blog_list') );
        add_shortcode('et_blog_carousel', array($blog, 'blog_carousel') );
        add_shortcode('menu','etheme_menu_shortcode');
        add_shortcode('etheme_brands_list','etheme_brands_list_shortcode');
        add_shortcode('etheme_post_meta','etheme_post_meta_shortcode');
        add_shortcode('et_menu_list', 'etheme_menu_list_shortcode');
        add_shortcode('et_menu_list_item', 'etheme_menu_list_item_shortcode');
        add_shortcode('etheme_slider', 'etheme_slider_shortcode');
        add_shortcode('etheme_slider_item', 'etheme_slider_item_shortcode');

        add_shortcode('etheme_scroll_text', 'etheme_scroll_text_shortcode');
        add_shortcode('etheme_scroll_text_item', 'etheme_scroll_text_item_shortcode');

        // ! Product grid shortcodes
        add_shortcode( 'etheme_product_name', 'etheme_product_name_render');
        add_shortcode( 'etheme_product_image', 'etheme_product_image_render' );
        add_shortcode( 'etheme_product_excerpt', 'etheme_product_excerpt_render' );
        add_shortcode( 'etheme_product_rating', 'etheme_product_rating_render' );
        add_shortcode( 'etheme_product_price', 'etheme_product_price_render' );
        add_shortcode( 'etheme_product_sku', 'etheme_product_sku_render' );
        add_shortcode( 'etheme_product_brands', 'etheme_product_brands_render' );
        add_shortcode( 'etheme_product_categories', 'etheme_product_categories_render' );
        add_shortcode( 'etheme_product_buttons', 'etheme_product_buttons_render' );
    }
}

?>
