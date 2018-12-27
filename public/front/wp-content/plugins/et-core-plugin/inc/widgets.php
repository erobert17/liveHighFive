<?php  if ( ! defined('ABSPATH') ) exit( 'No direct script access allowed' );
// **********************************************************************// 
// ! Register 8theme Widgets
// **********************************************************************// 
if( ! function_exists( 'etheme_register_general_widgets' ) ) {
	// **********************************************************************// 
	// ! Call 8theme Widgets
	// **********************************************************************// 
	require_once( 'widgets/recent-posts.php' );
	require_once( 'widgets/recent-comments.php' );
	require_once( 'widgets/twitter.php' );
	require_once( 'widgets/flickr.php' );
	require_once( 'widgets/wp-instagram-widget.php' );
	require_once( 'widgets/static-block.php' );
	require_once( 'widgets/qr-code.php' );
	require_once( 'widgets/about-author.php' );
	require_once( 'widgets/socials.php' );
	require_once( 'widgets/featured-posts.php' );
	require_once( 'widgets/posts-tabs.php' );
	require_once( 'widgets/menu.php' );
	
	add_action( 'widgets_init', 'etheme_register_general_widgets' );
	function etheme_register_general_widgets() {
		// ! Register it only for XStore theme
		if ( ! defined( 'ETHEME_THEME_NAME' ) || ETHEME_THEME_NAME != 'XStore' ) return;

	    register_widget('ETheme_Twitter_Widget');
	    register_widget('ETheme_Recent_Posts_Widget');
	    register_widget('ETheme_Recent_Comments_Widget');
	    register_widget('ETheme_Flickr_Widget');
	    register_widget('ETheme_Instagram_Widget');
	    register_widget('ETheme_StatickBlock_Widget');
	    register_widget('ETheme_QRCode_Widget');
	    register_widget('ETheme_About_Author_Widget');
	    register_widget('ETheme_Socials_Widget');
	    register_widget('ETheme_Featured_Posts_Widget');
	    register_widget('ETheme_Posts_Tabs_Widget');
	    register_widget('ETheme_Menu_Widget');

	    // ! Register WooCommerce depend widgets
	    if( class_exists('WooCommerce') && class_exists( 'WC_Widget' ) ) {
	    	require_once( 'widgets/brands.php');
			register_widget('ETheme_Brands_Widget');

			require_once( 'widgets/products.php');
			register_widget('ETheme_Products_Widget');

			require_once( 'widgets/brands-filter.php');
			register_widget('ETheme_Brands_Filter_Widget');

			require_once( 'widgets/active-filters.php');
			register_widget('ET_Widget_Layered_Nav_Filters');

			require_once( 'widgets/price-filter.php');
			register_widget('ET_Widget_Price_Filter');

			if ( class_exists( 'St_Woo_Swatches_Base' ) ) {
				require_once( 'widgets/swatches-filter.php');
				register_widget('ETheme_Swatches_Filter_Widget');
			}
	    }
	}
}

// **********************************************************************// 
// ! Forms for Widgets
// **********************************************************************// 
if(!function_exists('etheme_widget_label')) {
	function etheme_widget_label( $label, $id ) {
	    echo "<label for='{$id}'>{$label}</label>";
	}
}

if(!function_exists('etheme_widget_input_checkbox')) {
	function etheme_widget_input_checkbox( $label, $id, $name, $checked, $value = 1 ) {
	    echo "\n\t\t\t<p>";
	    echo "<label for='{$id}'>";
	    echo "<input type='checkbox' id='{$id}' value='{$value}' name='{$name}' {$checked} /> ";
	    echo "{$label}</label>";
	    echo '</p>';
	}
}

if(!function_exists('etheme_widget_textarea')) {
	function etheme_widget_textarea( $label, $id, $name, $value ) {
	    echo "\n\t\t\t<p>";
	    etheme_widget_label( $label, $id );
	    echo "<textarea id='{$id}' name='{$name}' rows='3' cols='10' class='widefat'>" . ( $value ) . "</textarea>";
	    echo '</p>';
	}
}

if(!function_exists('etheme_widget_input_text')) {
	function etheme_widget_input_text( $label, $id, $name, $value ) {
	    echo "\n\t\t\t<p>";
	    etheme_widget_label( $label, $id );
	    echo "<input type='text' id='{$id}' name='{$name}' value='" . strip_tags( $value ) . "' class='widefat' />";
	    echo '</p>';
	}
}

if( ! function_exists( 'etheme_widget_input_image' ) ) {
	function etheme_widget_input_image( $label, $id, $name, $value ) {
	    $out = "\n\t\t\t<p>";
		    etheme_widget_label( $label, $id );

		    $class = ( $value ) ? 'selected' : '' ;

		    $out .= '<div class="media-widget-control ' . $class . '">';
		    	$out .= '<div class="media-widget-preview etheme_media-image">';
					if ( $value ) {
						$out .= '<img class="attachment-thumb etheme_upload-image" src="' . $value . '">';
					} else {
						$out .= '<div class="attachment-media-view">';
							$out .= '<div class="placeholder etheme_upload-image">' . esc_html__( 'No image selected', 'xstore' ) . '</div>';
						$out .= '</div>';
					}
		    	$out .= '</div>';
		    	$out .= '<p class="media-widget-buttons">';
					if ( $value ) {
						//$out .= '<button type="button" class="button edit-media selected">Edit Image</button>';
						$out .= '<button type="button" class="button change-media select-media etheme_upload-image selected">' . esc_html__( 'Replace Image', 'xstore' ) . '</button>';
					} else {
						$out .= '<button type="button" class="button etheme_upload-image not-selected">' . esc_html__( 'Add Image', 'xstore' ) . '</button>';
					}
		    	$out .= '</p>';
		    	$out .= '<input type="hidden" id="' . $id . '" name="' . $name . '" value="' . strip_tags( $value ) . '" class="widefat" />';
		    $out .= '</div>';
		$out .= '</p>';
		echo $out;
	}
}

if(!function_exists('etheme_widget_input_dropdown')) {
	function etheme_widget_input_dropdown( $label, $id, $name, $value, $options ) {
	    echo "\n\t\t\t<p>";
	    etheme_widget_label( $label, $id );
	    echo "<select id='{$id}' name='{$name}' class='widefat'>";
		$val = current( array_flip( $options ) );
    	if( ! empty( $val ) ) echo '<option value=""></option>';
	    foreach ($options as $key => $option) {
	    	echo '<option value="' . $key . '" ' . selected( strip_tags( $value ), $key ) . '>' . $option . '</option>';
	    }
	    echo "</select>";
	    echo '</p>';
	}
}