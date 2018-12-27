<?php  if ( ! defined('ABSPATH')) exit('No direct script access allowed');

define('ETHEME_THEME_NAME', 'XStore');
define('ETHEME_THEME_SLUG', 'xstore');

// **********************************************************************// 
// ! Specific functions only for this theme
// **********************************************************************//
if(!function_exists('etheme_theme_setup')) {

    add_action('after_setup_theme', 'etheme_theme_setup', 1);
    add_theme_support( 'woocommerce' );

    // ! Add support for woocommerce v3.0
    // we need only zoom part
    add_theme_support( 'wc-product-gallery-zoom' );
    // ! Default theme support
    //add_theme_support( 'wc-product-gallery-lightbox' );
    //add_theme_support( 'wc-product-gallery-slider' );

    function etheme_theme_setup(){
        add_theme_support( 'post-formats', array( 'video', 'quote', 'gallery', 'audio' ) );
        add_theme_support( 'post-thumbnails', array('post', 'page', 'product') );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
    }
}

// **********************************************************************// 
// ! Remove css/js files version
// **********************************************************************// 
add_filter( 'style_loader_src', 'etheme_remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'etheme_remove_cssjs_ver', 10, 2 );
if ( ! function_exists( 'etheme_remove_cssjs_ver' ) ) {
    function etheme_remove_cssjs_ver( $src ) {
        if ( etheme_get_option( 'cssjs_ver' ) ) {
            // ! Do not do it for revslider and essential-grid.
            if ( strpos( $src, 'revslider' ) || strpos( $src, 'essential-grid' ) ) return $src;

            if( strpos( $src, '?ver=' ) ) $src = remove_query_arg( 'ver', $src );
        }
        return $src;   
    }
}

// **********************************************************************// 
// ! Disable emojis
// **********************************************************************//
add_action( 'init', 'etheme_disable_emojis' );
if ( ! function_exists( 'etheme_disable_emojis' ) ) {
    function etheme_disable_emojis() {
        if ( etheme_get_option( 'disable_emoji' ) ) {
            remove_action( 'admin_print_styles', 'print_emoji_styles' );
            remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
            remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
            remove_action( 'wp_print_styles', 'print_emoji_styles' );
            remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
            remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
            remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        }
    }
}

// **********************************************************************// 
// ! Menus
// **********************************************************************// 
if(!function_exists('etheme_register_menus')) {
    function etheme_register_menus() {
        register_nav_menus(array(
            'main-menu'       => esc_html__('Main menu', 'xstore'),
            'main-menu-right' => esc_html__('Main menu right', 'xstore'),
            'mobile-menu'     => esc_html__('Mobile menu', 'xstore'),
            'secondary'       => esc_html__('Secondary menu', 'xstore'),
            'my-account'      => esc_html__('My account', 'xstore')
        ));
    }
    add_action('init', 'etheme_register_menus');
}