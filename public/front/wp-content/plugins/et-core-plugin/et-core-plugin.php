<?php
/*
Plugin Name: XStore Core
Plugin URI: http://8theme.com
Description: 8theme Core Plugin for Xstore theme
Version: 1.1.6
Author: 8theme
Text Domain: xstore-core
Author URI: http://8theme.com
*/

if(!defined('WPINC')) die();

if ( @is_child_theme() ) {
	$theme = wp_get_theme( 'xstore' );
} else {
	$theme = wp_get_theme();
}

if (  $theme->name == ('XStore') &&  version_compare( $theme->version, '5.1.1', '<' ) ) {
	add_action( 'admin_notices', 'etheme_required_theme_notice', 50 );
	return;
}

/**
 * define ET_CORE_URL.
 * 
 * @since 1.1.1
 */
define( 'ET_CORE_URL', plugin_dir_url( __FILE__ ) );

/**
 * define ET_CORE_DIR.
 * 
 * @since 1.1.3
 */
define( 'ET_CORE_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Load functions.
 * 
 * @since 1.0
 */
include 'inc/functions.php';

/**
 * Load post-types.
 * 
 * @since 1.0
 */
include 'inc/post-types.php';

/**
 * Load shortcodes.
 * 
 * @since 1.0
 */
include 'inc/shortcodes.php';

/**
 * Load plugin widgets.
 * 
 * @since 1.1.1
 */
include 'inc/widgets.php';

/**
 * Load soundcloud.
 * 
 * @since 1.0
 */
include 'inc/soundcloud/soundcloud-shortcode.php';

/**
 * Load plugin testimonials.
 * Do it to prevent errors with old 8theme themes
 * @since 1.1
 */
add_action( 'init', 'et_third_party' );
function et_third_party(){
	if ( ! class_exists('Woothemes_Testimonials') ) {
		include 'inc/testimonials/woothemes-testimonials.php';
	}

	if ( ! class_exists( 'TwitterOAuth' ) ) {
		include 'inc/twitteroauth/twitteroauth.php';
	}
}

/**
 * Load plugin import.
 * 
 * @since 1.1
 */
add_action( 'plugins_loaded', 'xstore_load_importers', 999 );
function xstore_load_importers() {
	if ( is_admin() && ! defined( 'IMPORT_DEBUG' ) ) {
		include 'inc/import.php';
	}
}

/**
 * Load plugin st-woo-swatches.
 * 
 * @since 1.1
 */
add_action( 'after_setup_theme', 'xstore_load_swatches', 999 );
function xstore_load_swatches(){
	if ( ! class_exists( 'Woocommerce' ) || ! function_exists( 'etheme_get_option' ) || ! etheme_get_option( 'enable_swatch' ) ) {
		return;
	}
	include 'inc/st-woo-swatches/st-woo-swatches.php';
}

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
add_action( 'plugins_loaded', 'xstore_core_load_textdomain' );
function xstore_core_load_textdomain() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'xstore-core' );

	load_textdomain( 'xstore-core', WP_LANG_DIR . '/xstore-core/xstore-core-' . $locale . '.mo' );
	load_plugin_textdomain( 'xstore-core', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );



	add_filter('pre_set_site_transient_update_plugins', 'check_for_plugin_update');
}

/**
 * ! Notice "Theme version"
 * @since 1.1
 */
function etheme_required_theme_notice(){

	if ( is_child_theme() ) {
    	$theme = wp_get_theme( 'xstore' );
    } else {
    	$theme = wp_get_theme();
    }

    $downgrade = '';

    if ( defined( 'ETHEME_API' ) ) {
    	$plugins_dir = ETHEME_API . 'files/get/';
    	$activated_data = get_option( 'etheme_activated_data' );
    	if ( isset( $activated_data['api_key'] ) && ! empty( $activated_data['api_key'] ) ) {
    		$key   = $activated_data['api_key'];
    		$token = '?token=' . $key;
    		$link  = $plugins_dir . 'et-core-plugin-23.zip' . $token;
    		$downgrade .= '<p>Downgrade the plugin to version 1.0.23 to use it with the current theme version. 1.0.23 plugin version you can find <a href="' . $link . '">here</a> </p>';
    	}
    }

    if (  $theme->name == ('XStore') &&  version_compare( $theme->version, '5.1.1', '<' ) ) {
      	echo '
			<div class="error">
				<p>Xstore Core plugin requires the following theme: <strong>Xstore</strong> v5.1.1 or higher.</p>
				' . $downgrade . '
			</div>
		';
    }
}

/**
 * Check for plugin update
 *
 * @since 1.0.20
 */
function check_for_plugin_update($checked_data){
	if ( ! defined( 'ETHEME_API' ) ) return $checked_data;

	$activated_data = get_option( 'etheme_activated_data' );
	$update_info    = get_option( 'xstore-update-info', false );
	$key 			= $activated_data['api_key'];
	$plugins_dir 	= ETHEME_API . 'files/get/';
	$token 			= '?token=' . $key;
	$plugin_ver 	= ( isset( $update_info->plugin_version ) && ! empty( $update_info->plugin_version ) ) ? $update_info->plugin_version : false;

	if ( version_compare( '1.1.6', $plugin_ver, '<' ) ) {
		$plugins_dir = ETHEME_API . 'files/get/';
		$plugins_dir . 'et-core-plugin.zip';

		$plugin = new stdClass();
		$plugin->slug = 'et-core-plugin';
		$plugin->plugin = 'et-core-plugin/et-core-plugin.php';
		$plugin->new_version = $plugin_ver;
		$plugin->url = 'http://8theme.com/demo/xstore/change-log.php';
		$plugin->package = $plugins_dir . 'et-core-plugin.zip' . $token;
		$plugin->tested = '4.9.4';
		$plugin->icons = Array(
            '2x' =>esc_url( ET_CORE_URL . 'inc/st-woo-swatches/public/images/256x256.png' ),
            '1x' =>esc_url( ET_CORE_URL . 'inc/st-woo-swatches/public/images/128x128.png' )
        );
		$checked_data->response['et-core-plugin/et-core-plugin.php'] = $plugin;
	}

	return $checked_data;
}
?>