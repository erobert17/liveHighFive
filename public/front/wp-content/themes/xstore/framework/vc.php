<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

if( ! function_exists('vc_remove_element')) return;

add_action( 'init', 'etheme_VC_setup');

if(!function_exists('etheme_VC_setup')) {
	function etheme_VC_setup() {
		vc_remove_element("vc_tour");
	}
}

if( defined( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' ) ) {
	add_filter(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'etheme_vc_custom_css_class', 10, 3);
	if( ! function_exists('etheme_vc_custom_css_class') ) {
		function etheme_vc_custom_css_class( $classes, $base, $atts = array() ) {
			if( ! empty( $atts['fixed_background'] ) ) {
				$classes .= ' et-attachment-fixed';
			}
			if( ! empty( $atts['fixed_background'] ) ) {
				$classes .= ' et-parallax et-parallax-' . $atts['fixed_background'];
			}
			elseif ( ! empty( $atts['background_position'] ) ) {
				$classes .= ' et-parallax et-parallax-' . $atts['background_position'];
			}
			if( ! empty( $atts['off_center'] ) ) {
				$classes .= ' off-center-' . $atts['off_center'];
			}
			if( ! empty( $atts['columns_reverse'] ) ) {
				$classes .= ' columns-mobile-reverse';
			}
			return $classes;
		}
	}
}

// **********************************************************************//
// ! Add new option to vc_column
// **********************************************************************//
add_action( 'init', 'etheme_columns_options');
if(!function_exists('etheme_columns_options')) {
	function etheme_columns_options() {
		if(!function_exists('vc_map')) return;
		vc_add_param('vc_column', array(
			"type" => "dropdown",
			"heading" => esc_html__("Background position", 'xstore'),
			"param_name" => "background_position",
			"group" => esc_html__('XStore Options', 'xstore'),
			"value" => array(
				'' => '',
				__("Left top", 'xstore') => 'left_top',
				__("Left center", 'xstore') => 'left',
				__("Left bottom", 'xstore') => 'left_bottom',
				__("Right top", 'xstore') => 'right_top',
				__("Right center", 'xstore') => 'right',
				__("Right bottom", 'xstore') => 'right_bottom',
				__("Center top", 'xstore') => 'center_top',
				__("Center center", 'xstore') => 'center',
				__("Center bottom", 'xstore') => 'center_bottom',
			)
		));
		vc_add_param('vc_column', array(
			"type" => "dropdown",
			"heading" => esc_html__("Fixed background position", 'xstore'),
			"param_name" => "fixed_background",
			"group" => esc_html__('XStore Options', 'xstore'),
			"value" => array(
				'' => '',
				__("Left top", 'xstore') => 'left_top',
				__("Left center", 'xstore') => 'left',
				__("Left bottom", 'xstore') => 'left_bottom',
				__("Right top", 'xstore') => 'right_top',
				__("Right center", 'xstore') => 'right',
				__("Right bottom", 'xstore') => 'right_bottom',
				__("Center top", 'xstore') => 'center_top',
				__("Center center", 'xstore') => 'center',
				__("Center bottom", 'xstore') => 'center_bottom',
			)
		));

		vc_add_param('vc_column', array(
			"type" => "dropdown",
			"heading" => esc_html__("Off center", 'xstore'),
			"param_name" => "off_center",
			"value" => array(
				'' => '',
				__("Left", 'xstore') => 'left',
				__("Right", 'xstore') => 'right',
			)
		));

		vc_add_param('vc_row', array(
			"type" => "dropdown",
			"heading" => esc_html__("Fixed background position", 'xstore'),
			"param_name" => "fixed_background",
			"group" => esc_html__('XStore Options', 'xstore'),
			"value" => array(
				'' => '',
				__("Left top", 'xstore') => 'left_top',
				__("Left center", 'xstore') => 'left',
				__("Left bottom", 'xstore') => 'left_bottom',
				__("Right top", 'xstore') => 'right_top',
				__("Right center", 'xstore') => 'right',
				__("Right bottom", 'xstore') => 'right_bottom',
				__("Center top", 'xstore') => 'center_top',
				__("Center center", 'xstore') => 'center',
				__("Center bottom", 'xstore') => 'center_bottom',
			)
		));
		vc_add_param('vc_row', array(
			"type" => "dropdown",
			"heading" => esc_html__("Background position", 'xstore'),
			"param_name" => "background_position",
			"group" => esc_html__('XStore Options', 'xstore'),
			"value" => array(
				'' => '',
				__("Left top", 'xstore') => 'left_top',
				__("Left center", 'xstore') => 'left',
				__("Left bottom", 'xstore') => 'left_bottom',
				__("Right top", 'xstore') => 'right_top',
				__("Right center", 'xstore') => 'right',
				__("Right bottom", 'xstore') => 'right_bottom',
				__("Center top", 'xstore') => 'center_top',
				__("Center center", 'xstore') => 'center',
				__("Center bottom", 'xstore') => 'center_bottom',
			)
		));

		vc_add_param('vc_row', array(
			"type" => "checkbox",
			"heading" => esc_html__("Columns reverse on mobile", 'xstore'),
			"param_name" => "columns_reverse",
			"group" => esc_html__('XStore Options', 'xstore'),
		));
	}
}


if( ! function_exists( 'etheme_get_slider_params' ) ) {
	function etheme_get_slider_params() {
		return array(
			array(
				"type" => "textfield",
				"heading" => esc_html__("Slider speed", 'xstore'),
				"param_name" => "slider_speed",
				"group" => esc_html__('Slider settings', 'xstore'),
				"description" => sprintf( esc_html__( 'Duration of transition between slides. Default: 300', 'xstore' ) ),
			),
			array(
				"type" => "checkbox",
				"heading" => esc_html__("Slider autoplay", 'xstore'),
				"param_name" => "slider_autoplay",
				"group" => esc_html__('Slider settings', 'xstore'),
				'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' )

			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Autoplay speed", 'xstore'),
				"param_name" => "slider_interval",
				"group" => esc_html__('Slider settings', 'xstore'),
				"description" => sprintf( esc_html__( 'Interval between slides. In milliseconds. Default: 1000', 'xstore' ) ),
				'dependency' => array(
					'element' => 'slider_autoplay',
					'value' => 'yes',
				),
			),
			array(
				"type" => "checkbox",
				"heading" => esc_html__("Slider loop", 'xstore'),
				"param_name" => "slider_loop",
				"group" => esc_html__('Slider settings', 'xstore'),
				'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' ),
			),
			array(
				"type" => "checkbox",
				"heading" => esc_html__("Hide prev/next buttons", 'xstore'),
				"param_name" => "hide_buttons",
				"group" => esc_html__('Slider settings', 'xstore'),
				'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' )

			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Pagination type', 'xstore' ),
				'param_name' => 'pagination_type',
				'group' => esc_html__('Slider settings', 'xstore'),
				'value' => array(
					__( 'Hide', 'xstore' ) => 'hide',
					__( 'Bullets', 'xstore' ) => 'bullets',
					__( 'Lines', 'xstore' ) => 'lines',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Hide pagination only for', 'xstore' ),
				'param_name' => 'hide_fo',
				'dependency' => array(
					'element' => 'pagination_type',
					'value' => array( 'bullets', 'lines' ),
				),
				'group' => esc_html__('Slider settings', 'xstore'),
				'value' => array(
					'' => '',
					__( 'Mobile', 'xstore' ) => 'mobile',
					__( 'Desktop', 'xstore' ) => 'desktop',
				),
			),
			array(
				"type" => "colorpicker",
				"heading" => __( "Pagination default color", "xstore" ),
				"param_name" => "default_color",
				'dependency' => array(
					'element' => 'pagination_type',
					'value' => array( 'bullets', 'lines' ),
				),
				"group" => esc_html__('Slider settings', 'xstore'),
				"value" => '#e1e1e1',
			),
			array(
				"type" => "colorpicker",
				"heading" => __( "Pagination active color", "xstore" ),
				"param_name" => "active_color",
				'dependency' => array(
					'element' => 'pagination_type',
					'value' => array( 'bullets', 'lines' ),
				),
				"group" => esc_html__('Slider settings', 'xstore'),
				"value" => '#222',
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Number of slides on large screens", 'xstore'),
				"param_name" => "large",
				"group" => esc_html__('Slider settings', 'xstore')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("On notebooks", 'xstore'),
				"param_name" => "notebook",
				"group" => esc_html__('Slider settings', 'xstore')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("On tablet landscape", 'xstore'),
				"param_name" => "tablet_land",
				"group" => esc_html__('Slider settings', 'xstore')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("On tablet portrait", 'xstore'),
				"param_name" => "tablet_portrait",
				"group" => esc_html__('Slider settings', 'xstore')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("On mobile", 'xstore'),
				"param_name" => "mobile",
				"group" => esc_html__('Slider settings', 'xstore')
			),
		);
	}
}

if( ! function_exists( 'etheme_get_brands_list_params' ) ) {
    function etheme_get_brands_list_params() {
        return array(
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Display A-Z filter", 'xstore'),
                "param_name" => "hide_a_z",
                "group" => esc_html__('Brand settings', 'xstore'),
                'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' )
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Columns', 'xstore' ),
                'param_name' => 'columns',
                'group' => esc_html__('Brand settings', 'xstore'),
                'value' => array(
                    __( '1', 'xstore' ) => '1',
                    __( '2', 'xstore' ) => '2',
                    __( '3', 'xstore' ) => '3',
                    __( '4', 'xstore' ) => '4',
                    __( '5', 'xstore' ) => '5',
                    __( '6', 'xstore' ) => '6',
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Alignment', 'xstore' ),
                'param_name' => 'alignment',
                'group' => esc_html__('Brand settings', 'xstore'),
                'value' => array(
                    __( 'Left', 'xstore' ) => 'left',
                    __( 'Center', 'xstore' ) => 'center',
                    __( 'Right', 'xstore' ) => 'right',
                ),
            ),
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Display brands capital letter", 'xstore'),
                "param_name" => "capital_letter",
                "group" => esc_html__('Brand settings', 'xstore'),
                'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' )
            ),
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Brand title", 'xstore'),
                "param_name" => "brand_title",
                "group" => esc_html__('Brand settings', 'xstore'),
                'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' ),
                'std' => 'yes'
            ),
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Brand image", 'xstore'),
                "param_name" => "brand_image",
                "group" => esc_html__('Brand settings', 'xstore'),
                'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' )
            ),
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Title with tooltip", 'xstore'),
                "param_name" => "tooltip",
                "group" => esc_html__('Brand settings', 'xstore'),
                'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' )
            ),
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Brand description ", 'xstore'),
                "param_name" => "brand_desc",
                "group" => esc_html__('Brand settings', 'xstore'),
                'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' )
            ),
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Hide empty", 'xstore'),
                "param_name" => "hide_empty",
                "group" => esc_html__('Brand settings', 'xstore'),
                'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' )
            ),
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Show Product Counts", 'xstore'),
                "param_name" => "show_product_counts",
                "group" => esc_html__('Brand settings', 'xstore'),
                'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' )
            ),
        );
    }
}

// **********************************************************************//
// ! Rewrite vc google font
// **********************************************************************//

if( ! function_exists( 'et_rewrite_vc_google_font' ) ) {

	function et_rewrite_vc_google_font(){

		// Get from js_composer/include/params/google_fonts/google_fonts.php 07.02.2016

		$fonts_list['vc'] = '{"font_family":"Abril Fatface","font_styles":"regular","font_types":"400 regular:400:normal"},{"font_family":"Arimo","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Arvo","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Bitter","font_styles":"regular,italic,700","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal"},{"font_family":"Cabin","font_styles":"regular,italic,500,500italic,600,600italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,500 bold regular:500:normal,500 bold italic:500:italic,600 bold regular:600:normal,600 bold italic:600:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Cinzel","font_styles":"regular,700,900","font_types":"400 regular:400:normal,700 bold regular:700:normal,900 bold regular:900:normal"},{"font_family":"Coda","font_styles":"regular,800","font_types":"400 regular:400:normal,800 bold regular:800:normal"},{"font_family":"Condiment","font_styles":"regular","font_types":"400 regular:400:normal"},{"font_family":"Delius","font_styles":"regular","font_types":"400 regular:400:normal"},{"font_family":"Dosis","font_styles":"200,300,regular,500,600,700,800","font_types":"200 light regular:200:normal,300 light regular:300:normal,400 regular:400:normal,500 bold regular:500:normal,600 bold regular:600:normal,700 bold regular:700:normal,800 bold regular:800:normal"},{"font_family":"Droid Sans","font_styles":"regular,700","font_types":"400 regular:400:normal,700 bold regular:700:normal"},{"font_family":"Droid Serif","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Exo","font_styles":"100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic","font_types":"100 light regular:100:normal,100 light italic:100:italic,200 light regular:200:normal,200 light italic:200:italic,300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,500 bold regular:500:normal,500 bold italic:500:italic,600 bold regular:600:normal,600 bold italic:600:italic,700 bold regular:700:normal,700 bold italic:700:italic,800 bold regular:800:normal,800 bold italic:800:italic,900 bold regular:900:normal,900 bold italic:900:italic"},{"font_family":"Hind","font_styles":"300,regular,500,600,700","font_types":"300 light regular:300:normal,400 regular:400:normal,500 bold regular:500:normal,600 bold regular:600:normal,700 bold regular:700:normal"},{"font_family":"Istok Web","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Josefin Sans","font_styles":"100,100italic,300,300italic,regular,italic,600,600italic,700,700italic","font_types":"100 light regular:100:normal,100 light italic:100:italic,300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,600 bold regular:600:normal,600 bold italic:600:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Josefin Slab","font_styles":"100,100italic,300,300italic,regular,italic,600,600italic,700,700italic","font_types":"100 light regular:100:normal,100 light italic:100:italic,300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,600 bold regular:600:normal,600 bold italic:600:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Lato","font_styles":"100,100italic,300,300italic,regular,italic,700,700italic,900,900italic","font_types":"100 light regular:100:normal,100 light italic:100:italic,300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic,900 bold regular:900:normal,900 bold italic:900:italic"},{"font_family":"Libre Baskerville","font_styles":"regular,italic,700","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal"},{"font_family":"Lobster","font_styles":"regular","font_types":"400 regular:400:normal"},{"font_family":"Lora","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Merienda","font_styles":"regular,700","font_types":"400 regular:400:normal,700 bold regular:700:normal"},{"font_family":"Merriweather","font_styles":"300,300italic,regular,italic,700,700italic,900,900italic","font_types":"300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic,900 bold regular:900:normal,900 bold italic:900:italic"},{"font_family":"Merriweather Sans","font_styles":"300,300italic,regular,italic,700,700italic,800,800italic","font_types":"300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic,800 bold regular:800:normal,800 bold italic:800:italic"},{"font_family":"Montserrat","font_styles":"regular,700","font_types":"400 regular:400:normal,700 bold regular:700:normal"},{"font_family":"Muli","font_styles":"300,300italic,regular,italic","font_types":"300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic"},{"font_family":"Neuton","font_styles":"200,300,regular,italic,700,800","font_types":"200 light regular:200:normal,300 light regular:300:normal,400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,800 bold regular:800:normal"},{"font_family":"Nothing You Could Do","font_styles":"regular","font_types":"400 regular:400:normal"},{"font_family":"Noto Sans","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Noto Serif","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Old Standard TT","font_styles":"regular,italic,700","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal"},{"font_family":"Oleo Script","font_styles":"regular,700","font_types":"400 regular:400:normal,700 bold regular:700:normal"},{"font_family":"Open Sans","font_styles":"300,300italic,regular,italic,600,600italic,700,700italic,800,800italic","font_types":"300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,600 bold regular:600:normal,600 bold italic:600:italic,700 bold regular:700:normal,700 bold italic:700:italic,800 bold regular:800:normal,800 bold italic:800:italic"},{"font_family":"Open Sans Condensed","font_styles":"300,300italic,700","font_types":"300 light regular:300:normal,300 light italic:300:italic,700 bold regular:700:normal"},{"font_family":"Orbitron","font_styles":"regular,500,700,900","font_types":"400 regular:400:normal,500 bold regular:500:normal,700 bold regular:700:normal,900 bold regular:900:normal"},{"font_family":"Oswald","font_styles":"300,regular,700","font_types":"300 light regular:300:normal,400 regular:400:normal,700 bold regular:700:normal"},{"font_family":"Oxygen","font_styles":"300,regular,700","font_types":"300 light regular:300:normal,400 regular:400:normal,700 bold regular:700:normal"},{"font_family":"PT Sans","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"PT Serif","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Pacifico","font_styles":"regular","font_types":"400 regular:400:normal"},{"font_family":"Permanent Marker","font_styles":"regular","font_types":"400 regular:400:normal"},{"font_family":"Philosopher","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Playfair Display","font_styles":"regular,italic,700,700italic,900,900italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic,900 bold regular:900:normal,900 bold italic:900:italic"},{"font_family":"Radley","font_styles":"regular,italic","font_types":"400 regular:400:normal,400 italic:400:italic"},{"font_family":"Raleway","font_styles":"100,200,300,regular,500,600,700,800,900","font_types":"100 light regular:100:normal,200 light regular:200:normal,300 light regular:300:normal,400 regular:400:normal,500 bold regular:500:normal,600 bold regular:600:normal,700 bold regular:700:normal,800 bold regular:800:normal,900 bold regular:900:normal"},{"font_family":"Roboto","font_styles":"100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic","font_types":"100 light regular:100:normal,100 light italic:100:italic,300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,500 bold regular:500:normal,500 bold italic:500:italic,700 bold regular:700:normal,700 bold italic:700:italic,900 bold regular:900:normal,900 bold italic:900:italic"},{"font_family":"Roboto Condensed","font_styles":"300,300italic,regular,italic,700,700italic","font_types":"300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Roboto Slab","font_styles":"100,300,regular,700","font_types":"100 light regular:100:normal,300 light regular:300:normal,400 regular:400:normal,700 bold regular:700:normal"},{"font_family":"Satisfy","font_styles":"regular","font_types":"400 regular:400:normal"},{"font_family":"Signika","font_styles":"300,regular,600,700","font_types":"300 light regular:300:normal,400 regular:400:normal,600 bold regular:600:normal,700 bold regular:700:normal"},{"font_family":"Source Code Pro","font_styles":"200,300,regular,500,600,700,900","font_types":"200 light regular:200:normal,300 light regular:300:normal,400 regular:400:normal,500 bold regular:500:normal,600 bold regular:600:normal,700 bold regular:700:normal,900 bold regular:900:normal"},{"font_family":"Ubuntu","font_styles":"300,300italic,regular,italic,500,500italic,700,700italic","font_types":"300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,500 bold regular:500:normal,500 bold italic:500:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Ubuntu Mono","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Vollkorn","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Yeseva One","font_styles":"regular","font_types":"400 regular:400:normal"}';

		$fonts_list['et'] = '{"font_family":"Catamaran","font_styles":"regular","font_types":"100 thin:100:normal,200 extra-light:200:normal,300 light:300:normal,400 regular:400:normal,500 medium:500:normal,600 semi-bold:600:normal,700 bold:700:normal,800 extra-bold:800:normal,900 black:900:normal"},{"font_family":"Cormorant Garamond","font_styles":"serif,regular,italic,300italic,400italic,500italic,600italic,700italic","font_types":"300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,500 bold regular:500:normal,500 bold italic:500:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Engagement","font_styles":"cursive","font_types":"400 regular:400:normal"},{"font_family":"Great Vibes","font_styles":"cursive","font_types":"400 regular:400:normal"},{"font_family":"Niconne","font_styles":"cursive","font_types":"400 regular:400:normal"},{"font_family":"Norican","font_styles":"cursive","font_types":"400 regular:400:normal"},{"font_family":"Molle","font_styles":"400i","font_types":"400 italic:400:italic"},{"font_family":"Palanquin","font_styles":"regular","font_types":"100 thin:100:normal,200 extra-light:200:normal,300 light:300:normal,400 regular:400:normal,500 medium:500:normal,600 semi-bold:600:normal,700 bold:700:normal"},{"font_family":"Trirong","font_styles":"serif,regular,italic,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic","font_types":"100 lighter regular:100:normal,100 lighter italic:100:italic,200 lighter regular:200:normal,200 lighter italic:200:italic,300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,500 bold regular:500:normal,500 bold italic:500:italic,600 bold regular:600:normal,600 bold italic:600:italic,700 bold regular:700:normal,700 bold italic:700:italic,800 bolder regular:800:normal,800 bolder italic:800:italic,900 bolder regular:900:normal,900 bolder italic:900:italic"}, {"font_family":"Yantramanav","font_styles":"100,300,regular,500,700,900","font_types":"100 ultra-light regular:100:normal,300 light regular:300:normal,400 regular:400:normal,500 medium regular:500:normal,700 bold regular:700:normal,900 ultra-bold regular:900:normal"},{"font_family":"Poppins","font_styles":"regular","font_types":"300 light:300:normal,400 regular:400:normal,500 medium:500:normal,600 semi-bold:600:normal,700 bold:700:normal"},{"font_family":"Reenie Beanie","font_styles":"cursive","font_types":"400 regular:400:normal"},{"font_family":"Arizonia","font_styles":"cursive","font_types":"400 regular:400:normal"},{"font_family":"Elsie", "font_styles":"regular, 900","font_types":"400 regular:400:normal, 900 black:900:normal"},{"font_family":"Allerta Stencil", "font_styles":"regular","font_types":"400 regular:400:normal"}';


		


		$fonts_list = sprintf( '[%1$s,%2$s]', $fonts_list['vc'], $fonts_list['et'] );

		return json_decode( $fonts_list );
	}

	add_filter( 'vc_google_fonts_get_fonts_filter', 'et_rewrite_vc_google_font' );
}

// Etheme content product shortcode included to vc grid type 
add_filter( 'vc_grid_item_shortcodes', 'et_add_vc_grid_shortcodes' );
function et_add_vc_grid_shortcodes( $shortcodes ) {

	require_once vc_path_dir( 'CONFIG_DIR', 'content/vc-custom-heading-element.php' );
	$title_custom_heading = vc_map_integrate_shortcode( vc_custom_heading_element_params(), 'title_', esc_html__( 'Typography', 'xstore' ), array(
      'exclude' => array(
        'link',
        'source',
        'text',
        'css',
        'el_class',
        'css_animation'
      ),
    ), array(
      'element' => 'use_custom_fonts_title',
      'value' =>'true',
    ) );

    // This is needed to remove custom heading _tag and _align options.
    if ( is_array( $title_custom_heading ) && ! empty( $title_custom_heading ) ) {
      foreach ( $title_custom_heading as $key => $param ) {
        if ( is_array( $param ) && isset( $param['type'] ) && 'font_container' === $param['type'] ) {
          $title_custom_heading[ $key ]['value'] = '';
          if ( isset( $param['settings'] ) && is_array( $param['settings'] ) && isset( $param['settings']['fields'] ) ) {
            $sub_key = array_search( 'text_align', $param['settings']['fields'] );
            if ( false !== $sub_key ) {
              unset( $title_custom_heading[ $key ]['settings']['fields'][ $sub_key ] );
            } elseif ( isset( $param['settings']['fields']['text_align'] ) ) {
              unset( $title_custom_heading[ $key ]['settings']['fields']['text_align'] );
            }
            $sub_key = array_search( 'font_size', $param['settings']['fields'] );
            if ( false !== $sub_key ) {
              unset( $title_custom_heading[ $key ]['settings']['fields'][ $sub_key ] );
            } elseif ( isset( $param['settings']['fields']['font_size'] ) ) {
              unset( $title_custom_heading[ $key ]['settings']['fields']['font_size'] );
            }
            $sub_key = array_search( 'line_height', $param['settings']['fields'] );
            if ( false !== $sub_key ) {
              unset( $title_custom_heading[ $key ]['settings']['fields'][ $sub_key ] );
            } elseif ( isset( $param['settings']['fields']['line_height'] ) ) {
              unset( $title_custom_heading[ $key ]['settings']['fields']['line_height'] );
            }
            $sub_key = array_search( 'color', $param['settings']['fields'] );
            if ( false !== $sub_key ) {
              unset( $title_custom_heading[ $key ]['settings']['fields'][ $sub_key ] );
            } elseif ( isset( $param['settings']['fields']['color'] ) ) {
              unset( $title_custom_heading[ $key ]['settings']['fields']['color'] );
            }
          }
        }
      }
    }

    $horiz_align = array(
		__('Left', 'xstore') => 'left',
		__('Right', 'xstore') => 'right',
		__('Center', 'xstore') => 'center',
		__('Justify', 'xstore') => 'justify'
	);

	$text_transform = array(
		__('None', 'xstore') => '',
		__('Uppercase', 'xstore') => 'text-uppercase',
		__('Lowercase', 'xstore') => 'text-lowercase',
		__('Capitalize', 'xstore') => 'text-capitalize'
	);
	$compare_arr = $compare_checkbox = array();
	$sorted_list = array (
		array(
			'type' => 'sorted_list',
			'heading' => __( 'Buttons layout', 'xstore' ),
			'param_name' => 'sorting',
			'description' => __( 'Sorting the buttons layout', 'xstore' ),
			'value' => 'cart,wishlist,q_view',
			'options' => array(
				array(
					'cart',
					__( 'Add to cart', 'xstore' ),
				),
				array(
					'wishlist',
					__( 'Wishlist', 'xstore' ),
				),
				array(
					'q_view',
					__( 'Quick view', 'xstore' ),
				),
			),
		)
	);
	if ( class_exists('YITH_Woocompare') ) {
		$compare_checkbox = array (
			array(
		        'type' => 'checkbox',
		        'heading' => esc_html__( 'Compare', 'xstore' ),
		        'param_name' => 'compare',
		        'description' => esc_html__( 'Compare button.', 'xstore' ),
	        ),
		);
		$compare_arr = array (
	        array (
	        	'type' => 'dropdown',
	        	'heading' => esc_html__('Type', 'xstore'),
	        	'param_name' => 'compare_type',
	        	'value' => array (
	        		__('Icon', 'xstore') => 'icon',
	        		__('Text', 'xstore') => 'text',
	        		__('Icon + text', 'xstore') => 'icon-text',
	        		__('Button', 'xstore') => 'button',
	        	),
	        	'group' => 'Compare',
	        	'dependency' => array('element' => 'compare', 'value' => 'true')
	        ),
	        array (
	        	'type' => 'textfield',
	        	'heading' => esc_html__('Font size', 'xstore'),
	        	'param_name' => 'c_size',
	        	'group' => 'Compare',
	        	'dependency' => array('element' => 'compare', 'value' => 'true')
	        ),
	        array (
	        	'type' => 'dropdown',
	        	'heading' => esc_html__('Text transform', 'xstore'),
	        	'param_name' => 'c_transform',
	        	'value' => array (
	        		__('None', 'xstore') => '',
					__('Uppercase', 'xstore') => 'uppercase',
					__('Lowercase', 'xstore') => 'lowercase',
					__('Capitalize', 'xstore') => 'capitalize'
	        	),
	        	'group' => 'Compare',
	        	'dependency' => array('element' => 'compare_type', 'value_not_equal_to' => 'icon' ),
	        ),
	        array (
	        	'type' => 'colorpicker',
	        	'heading' => esc_html__('Button background color', 'xstore'),
	        	'param_name' => 'c_bg',
	        	'group' => 'Compare',
	        	'dependency' =>  array('element' => 'compare_type', 'value' => array('button', 'icon') ),
	        	'edit_field_class' => 'vc_col-sm-6 vc_column',
	        ),
	        array (
	        	'type' => 'colorpicker',
	        	'heading' => esc_html__('Button background color (hover)', 'xstore'),
	        	'param_name' => 'c_hover_bg',
	        	'group' => 'Compare',
	        	'dependency' =>  array('element' => 'compare_type', 'value' => array('button', 'icon') ),
	        	'edit_field_class' => 'vc_col-sm-6 vc_column',
	        ),
	        array (
		        'type' => 'textfield',
		        'heading' => 'Border radius',
		        'param_name' => 'c_radius',
		        'group' => 'Compare',
		        'dependency' =>  array('element' => 'compare_type', 'value' => array('button', 'icon')),
		        'edit_field_class' => 'vc_col-sm-6 vc_column',
		    ),
		    array (
		        'type' => 'textfield',
		        'heading' => esc_html__('Margins (top right bottom left)','xstore'),
		        'param_name' => 'c_margin',
		        'group' => 'Compare',
		        'description' => esc_html__('Use this field to add element margin. For example 10px 20px 30px 40px', 'xstore'),
		        'dependency' =>  array('element' => 'compare_type', 'value' => array('button', 'icon') ),
		        'edit_field_class' => 'vc_col-sm-6 vc_column',
		    ),
		);
		$sorted_list = array (
			array(
				'type' => 'sorted_list',
				'heading' => __( 'Buttons layout', 'xstore' ),
				'param_name' => 'sorting',
				'description' => __( 'Sorting the buttons layout', 'xstore' ),
				'value' => 'cart,wishlist,compare,q_view',
				'options' => array(
					array(
						'cart',
						__( 'Add to cart', 'xstore' ),
					),
					array(
						'wishlist',
						__( 'Wishlist', 'xstore' ),
					),
					array(
						'compare',
						__( 'Compare', 'xstore' ),
					),
					array(
						'q_view',
						__( 'Quick view', 'xstore' ),
					),
				),
			)
		);
	}

   $shortcodes['etheme_product_name'] = array(
     'name' => __( 'Product title', 'xstore' ),
     'base' => 'etheme_product_name',
     'category' => __( 'Content product by 8theme', 'xstore' ),
     'description' => __( 'Show current product name', 'xstore' ),
     'post_type' => Vc_Grid_Item_Editor::postType(),
     'params' => array_merge( 
     		array (
		     	array(
		     		'type' => 'dropdown',
		     		'heading' => __('Add link', 'xstore'),
		     		'param_name' => 'link',
		     		'value' => array(
		     			__('Product link', 'xstore') => 'product_link',
		     			__('Custom link', 'xstore') => 'custom',
		     			__('None', 'xstore') => ''
		     		),
		     	),
		     	array(
		     		'type' => 'vc_link',
		     		'heading' => __('Custom link', 'xstore'),
		     		'param_name' => 'url',
		 			'dependency' => array(
		 				'element' => 'link', 'value' => 'custom',
		 			),
		     	),
		     	array(
		     		'type' => 'dropdown',
		     		'heading' => __('Cut product name', 'xstore'),
		     		'param_name' => 'cutting',
		     		'value' => array(
		     			__('None', 'xstore') => 'none',
		     			__('Words', 'xstore') => 'words',
		     			__('Letters', 'xstore') => 'letters'
		     		),
		     	),
		     	array (
		     		'type' => 'textfield',
		     		'heading' => __('Count words/letters', 'xstore'),
		     		'param_name' => 'count',
		     		'dependency' => array (
		     			'element' => 'cutting',
		     			'value_not_equal_to' => 'none'
		     		),
		     	),
		     	array (
	     			'type' => 'textfield',
		     		'heading' => __('Symbols', 'xstore'),
		     		'param_name' => 'symbols',
		     		'description' => esc_html__( 'Default "...".', 'xstore' ),
		     		'dependency' => array (
		     			'element' => 'cutting',
		     			'value_not_equal_to' => 'none'
		     		),
		     	),
		     	array(
		     		'type' => 'dropdown',
		     		'heading' => __('Text align', 'xstore'),
		     		'param_name' => 'align',
		     		'value' => $horiz_align,
		     	),
		     	array(
		     		'type' => 'textfield',
		     		'heading' => __('Font size', 'xstore'),
					'param_name' => 'size',
					'group' => 'Typography'
		     	),
		     	array(
		     		'type' => 'textfield',
		     		'heading' => __('Letter spacing', 'xstore'),
					'param_name' => 'spacing',
					'group' => 'Typography'
		     	),
		     	array(
		     		'type' => 'textfield',
		     		'heading' => __('Line height', 'xstore'),
					'param_name' => 'line_height',
					'group' => 'Typography'
		     	),
		     	array(
		     		'type' => 'colorpicker',
		     		'heading' => __('Color', 'xstore'),
					'param_name' => 'color',
					'group' => 'Typography'
		     	),
		     	array(
		          'type' => 'checkbox',
		          'heading' => esc_html__( 'Use custom font ?', 'xstore' ),
		          'param_name' => 'use_custom_fonts_title',
		          'description' => esc_html__( 'Enable Google fonts.', 'xstore' ),
		        ),
			    array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'xstore' ),
					'param_name' => 'el_class',
					'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'xstore' ),
				),
		  	),
			$title_custom_heading,
			array (
				array(
		          'type' => 'css_editor',
		          'heading' => esc_html__( 'CSS box', 'xstore' ),
		          'param_name' => 'css',
		          'group' => esc_html__( 'Design', 'xstore' )
		        ),
			)
	    ),
	);

	$shortcodes['etheme_product_image'] = array(
	 'name' => __( 'Product image', 'xstore' ),
     'base' => 'etheme_product_image',
     'category' => __( 'Content product by 8theme', 'xstore' ),
     'post_type' => Vc_Grid_Item_Editor::postType(),
     'params' => array (
			array(
	     		'type' => 'dropdown',
	     		'heading' => __('Add link', 'xstore'),
	     		'param_name' => 'link',
	     		'value' => array(
	     			__('Product link', 'xstore') => 'product_link',
	     			__('Custom link', 'xstore') => 'custom',
	     			__('None', 'xstore') => ''
	     		),
	     	),
	     	array(
				'type' => 'vc_link',
				'heading' => __( 'URL (Link)', 'xstore' ),
				'param_name' => 'url',
				'dependency' => array(
					'element' => 'link',
					'value' => array( 'custom' ),
				),
				'description' => __( 'Add custom link.', 'xstore' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image alignment', 'xstore' ),
				'param_name' => 'align',
				'value' => array_diff($horiz_align, array(__('Justify', 'xstore') => 'justify')),
				'description' => __( 'Select image alignment.', 'xstore' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image style', 'xstore' ),
				'param_name' => 'style',
				'value' => getVcShared( 'single image styles' ),
				'description' => __( 'Select image display style.', 'xstore' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Hover effect', 'xstore'),
				'param_name' => 'hover',
				'value' => array (
					__('Disable', 'xstore') => '',
					__('Swap', 'xstore') => 'swap',
					__('Slider', 'xstore') => 'slider'
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Border color', 'xstore' ),
				'param_name' => 'border_color',
				'value' => getVcShared( 'colors' ),
				'std' => 'grey',
				'dependency' => array(
					'element' => 'style',
					'value' => array(
						'vc_box_border',
						'vc_box_border_circle',
						'vc_box_outline',
						'vc_box_outline_circle',
					),
				),
				'description' => __( 'Border color.', 'xstore' ),
				'param_holder_class' => 'vc_colored-dropdown',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'xstore' ),
				'param_name' => 'el_class',
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'xstore' ),
			),
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS box', 'xstore' ),
				'param_name' => 'css',
				'group' => __( 'Design Options', 'xstore' ),
			),
		),
	);

    $shortcodes['etheme_product_excerpt'] = array(
     'name' => __( 'Product excerpt', 'xstore' ),
     'base' => 'etheme_product_excerpt',
     'category' => __( 'Content product by 8theme', 'xstore' ),
     'post_type' => Vc_Grid_Item_Editor::postType(),
     'params' => array_merge( 
     	array (
	     	array(
	     		'type' => 'dropdown',
	     		'heading' => __('Cut excerpt', 'xstore'),
	     		'param_name' => 'cutting',
	     		'value' => array(
	     			__('None', 'xstore') => 'none',
	     			__('Words', 'xstore') => 'words',
	     			__('Letters', 'xstore') => 'letters'
	     		),
	     	),
	     	array (
	     		'type' => 'textfield',
	     		'heading' => __('Count words/letters', 'xstore'),
	     		'param_name' => 'count',
	     		'dependency' => array (
	     			'element' => 'cutting',
	     			'value_not_equal_to' => 'none'
	     		),
	     	),
	     	array (
	     		'type' => 'textfield',
	     		'heading' => __('Symbols after string', 'xstore'),
	     		'param_name' => 'symbols',
	     		'description' => esc_html__( 'Default "...".', 'xstore' ),
	     		'dependency' => array (
	     			'element' => 'cutting',
	     			'value_not_equal_to' => 'none'
	     		),
	     	),
	     	array(
	     		'type' => 'dropdown',
	     		'heading' => __('Text align', 'xstore'),
	     		'param_name' => 'align',
	     		'value' => $horiz_align,
	     	),
	     	array(
	     		'type' => 'textfield',
	     		'heading' => __('Font size', 'xstore'),
				'param_name' => 'size',
				'group' => 'Typography'
	     	),
	     	array(
	     		'type' => 'textfield',
	     		'heading' => __('Letter spacing', 'xstore'),
				'param_name' => 'spacing',
				'group' => 'Typography'
	     	),
	     	array(
	     		'type' => 'textfield',
	     		'heading' => __('Line height', 'xstore'),
				'param_name' => 'line_height',
				'group' => 'Typography'
	     	),
	     	array(
	     		'type' => 'colorpicker',
	     		'heading' => __('Color', 'xstore'),
				'param_name' => 'color',
				'group' => 'Typography'
	     	),
	     	array(
		        'type' => 'checkbox',
		        'heading' => esc_html__( 'Use custom font ?', 'xstore' ),
		        'param_name' => 'use_custom_fonts_title',
		        'description' => esc_html__( 'Enable Google fonts.', 'xstore' ),
	        ),
		    array(
		    	'type' => 'textfield',
		    	'heading' => __('Class', 'xstore'),
		    	'param_name' => 'el_class',
		    ),
     	),
		$title_custom_heading,
		array(
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS box', 'xstore' ),
				'param_name' => 'css',
				'group' => __( 'Design Options', 'xstore' ),
			)
		)
	),
    );
	$shortcodes['etheme_product_rating'] = array(
	     'name' => __( 'Product rating', 'xstore' ),
	     'base' => 'etheme_product_rating',
	     'category' => __( 'Content product by 8theme', 'xstore' ),
	     'post_type' => Vc_Grid_Item_Editor::postType(),
	     'params' => array (
	     	array(
		    	'type' => 'checkbox',
		    	'heading' => __('Show by default ?', 'xstore'),
		    	'param_name' => 'default',
		    ),
		    array(
		    	'type' => 'textfield',
		    	'heading' => __('Class', 'xstore'),
		    	'param_name' => 'el_class',
		    ),
		    array(
				'type' => 'css_editor',
				'heading' => __( 'CSS box', 'xstore' ),
				'param_name' => 'css',
				'group' => __( 'Design Options', 'xstore' ),
			)
     	),
    );
	$shortcodes['etheme_product_price'] = array(
	     'name' => __( 'Product price', 'xstore' ),
	     'base' => 'etheme_product_price',
	     'category' => __( 'Content product by 8theme', 'xstore' ),
	     'post_type' => Vc_Grid_Item_Editor::postType(),
	     'params' => array (
	     	array(
	     		'type' => 'dropdown',
	     		'heading' => __('Text align', 'xstore'),
	     		'param_name' => 'align',
	     		'value' => $horiz_align,
	     	),
	     	array (
	        	"type" => 'textfield',
	        	"heading" => __('Font size', 'xstore'),
	        	"param_name" => 'size',
	        	'group' => 'Typography',
	        ),
	     	array(
		          "type" => "textfield",
		          "heading" => "Letter spacing",
		          "param_name" => "spacing",
		          'group' => 'Typography',
		          'description' => esc_html__('Enter letter spacing', 'xstore'),
	        ),
	        array (
	        	"type" => 'colorpicker',
	        	"heading" => __('Regular price color', 'xstore'),
	        	"param_name" => 'color',
	        	'group' => 'Typography',
	        ),
	        array (
	        	"type" => 'colorpicker',
	        	"heading" => __('Sale price color', 'xstore'), 
	        	"param_name" => 'color_sale',
	        	'group' => 'Typography'
	        ),
	        array(
				'type' => 'css_editor',
				'heading' => __( 'CSS box', 'xstore' ),
				'param_name' => 'css',
				'group' => __( 'Design Options', 'xstore' ),
			),
		    array(
		    	'type' => 'textfield',
		    	'heading' => __('Class', 'xstore'),
		    	'param_name' => 'el_class',
		    ),
     	),
    );

	$shortcodes['etheme_product_sku'] = array(
	     'name' => __( 'Product sku', 'xstore' ),
	     'base' => 'etheme_product_sku',
	     'category' => __( 'Content product by 8theme', 'xstore' ),
	     'post_type' => Vc_Grid_Item_Editor::postType(),
	     'params' => array (
	     	array(
	     		'type' => 'dropdown',
	     		'heading' => __('Text align', 'xstore'),
	     		'param_name' => 'align',
	     		'value' => $horiz_align,
	     	),
	     	array(
	     		'type' => 'dropdown',
	     		'heading' => __('Text transform', 'xstore'),
	     		'param_name' => 'transform',
	     		'value' => $text_transform,
	     	),
	     	array (
	        	"type" => 'textfield',
	        	"heading" => __('Font size', 'xstore'),
	        	"param_name" => 'size',
	        	'group' => 'Typography',
	        ),
	        array (
	        	"type" => 'colorpicker',
	        	"heading" => __('Color', 'xstore'),
	        	"param_name" => 'color',
	        	'group' => 'Typography',
	        ),
	        array(
				'type' => 'css_editor',
				'heading' => __( 'CSS box', 'xstore' ),
				'param_name' => 'css',
				'group' => __( 'Design Options', 'xstore' ),
			),
		    array(
		    	'type' => 'textfield',
		    	'heading' => __('Class', 'xstore'),
		    	'param_name' => 'el_class',
		    ),
     	),
    );

	/* Product brands shortcode */

	$shortcodes['etheme_product_brands'] = array(
	     'name' => __( 'Product brands', 'xstore' ),
	     'base' => 'etheme_product_brands',
	     'category' => __( 'Content product by 8theme', 'xstore' ),
	     'post_type' => Vc_Grid_Item_Editor::postType(),
	     'params' => array (
	     	array(
	     		'type' => 'dropdown',
	     		'heading' => __('Text align', 'xstore'),
	     		'param_name' => 'align',
	     		'value' => $horiz_align,
	     	),
	     	array(
	     		'type' => 'checkbox',
	     		'heading' => __('Show image', 'xstore'),
	     		'param_name' => 'img',
	     		'description' => __('The image will be shown in case if product\'s brand has it', 'xstore')
	     	),
	     	array(
	     		'type' => 'dropdown',
	     		'heading' => __('Text transform', 'xstore'),
	     		'param_name' => 'transform',
	     		'value' => $text_transform,
	     	),
	     	array (
	        	"type" => 'textfield',
	        	"heading" => __('Font size', 'xstore'),
	        	"param_name" => 'size',
	        	'group' => 'Typography',
	        ),
	        array (
	        	"type" => 'textfield',
	        	"heading" => __('Letter spacing', 'xstore'),
	        	"param_name" => 'spacing',
	        	'group' => 'Typography'
	        ),
	        array(
				'type' => 'css_editor',
				'heading' => __( 'CSS box', 'xstore' ),
				'param_name' => 'css',
				'group' => __( 'Design Options', 'xstore' ),
			),
		    array(
		    	'type' => 'textfield',
		    	'heading' => __('Class', 'xstore'),
		    	'param_name' => 'el_class',
		    ),
     	),
    );

	/* end product brands shortcode */

    $shortcodes['etheme_product_categories'] = array(
     'name' => __( 'Product categories', 'xstore' ),
     'base' => 'etheme_product_categories',
     'category' => __( 'Content product by 8theme', 'xstore' ),
     'post_type' => Vc_Grid_Item_Editor::postType(),
     'params' => array_merge( 
	     	array (
				array(
		     		'type' => 'dropdown',
		     		'heading' => __('Text align', 'xstore'),
		     		'param_name' => 'align',
		     		'value' => $horiz_align,
		     	),
		     	array(
			        'type' => 'checkbox',
			        'heading' => esc_html__( 'Use custom font ?', 'xstore' ),
			        'param_name' => 'use_custom_fonts_title',
			        'description' => esc_html__( 'Enable Google fonts.', 'xstore' ),
		        ),
			    array(
			    	'type' => 'textfield',
			    	'heading' => __('Class', 'xstore'),
			    	'param_name' => 'el_class',
			    ),
	     	),
			$title_custom_heading,
			array(
				array(
					'type' => 'css_editor',
					'heading' => __( 'CSS box', 'xstore' ),
					'param_name' => 'css',
					'group' => __( 'Design Options', 'xstore' ),
				)
			)
		),
  	);

$shortcodes['etheme_product_buttons'] = array(
     'name' => __( 'Product buttons ', 'xstore' ),
     'base' => 'etheme_product_buttons',
     'category' => __( 'Content product by 8theme', 'xstore' ),
     'post_type' => Vc_Grid_Item_Editor::postType(),
     'params' => array_merge(
     		$sorted_list,
		    array (
		    	array(
		        	'type' => 'dropdown',
		        	'heading' => esc_html__( 'Design type', 'xstore' ),
		        	'param_name' => 'type',
		        	'value' => array(
		        		esc_html__( 'Horizontal', 'xstore' ) => '',
		        		esc_html__( 'Vertical', 'xstore' ) => 'vertical',
		        	),
		        ),
		        array (
		        	'type' => 'dropdown',
		        	'heading' => esc_html__( 'Align', 'xstore' ),
		        	'param_name' => 'align',
		        	'value' => array (
		        		esc_html__( 'Left', 'xstore' ) => 'start',
		        		esc_html__( 'Right', 'xstore' ) => 'end',
		        		esc_html__( 'Center', 'xstore' ) => 'center',
		        		esc_html__( 'Stretch', 'xstore' ) => 'between',
		        		esc_html__( 'Stretch (no paddings)', 'xstore' ) => 'around',
		        	),
		        ),
		        array(
		        	'type' => 'dropdown',
		        	'heading' => esc_html__( 'Vertical align', 'xstore' ),
		        	'param_name' => 'v_align',
		        	'value' => array(
		        		esc_html__( 'Top', 'xstore' ) => 'start',
		        		esc_html__( 'Bottom', 'xstore' ) => 'end',
		        		esc_html__( 'Middle', 'xstore' ) => 'center',
		        		esc_html__( 'Full height', 'xstore' ) => 'stretch',
		        	),
		        ),
		        // Cart options 
		        array (
		        	'type' => 'dropdown',
		        	'heading' => esc_html__('Type', 'xstore'),
		        	'param_name' => 'cart_type',
		        	'value' => array (
		        		esc_html__('Icon', 'xstore') => 'icon',
	        			esc_html__('Text', 'xstore') => 'text',
		        		esc_html__('Icon + text', 'xstore') => 'icon-text',
		        		esc_html__('Button', 'xstore') => 'button',
		        	),
		        	'group' => 'Cart',
		        ),
		        array (
		        	'type' => 'textfield',
		        	'heading' => esc_html__('Font size', 'xstore'),
		        	'param_name' => 'a_size',
		        	'group' => 'Cart'
		        ),
		        array (
		        	'type' => 'dropdown',
		        	'heading' => esc_html__('Text transform', 'xstore'),
		        	'param_name' => 'a_transform',
		        	'value' => array (
		        		__('None', 'xstore') => '',
						__('Uppercase', 'xstore') => 'uppercase',
						__('Lowercase', 'xstore') => 'lowercase',
						__('Capitalize', 'xstore') => 'capitalize'
		        	),
		        	'group' => 'Cart',
		        	'dependency' =>  array('element' => 'cart_type', 'value_not_equal_to' => 'icon'),
		        ),
		        array (
		        	'type' => 'colorpicker',
		        	'heading' => esc_html__('Button background color', 'xstore'),
		        	'param_name' => 'a_bg',
		        	'group' => 'Cart',
		        	'dependency' =>  array('element' => 'cart_type', 'value' => array('button', 'icon') ),
		        	'edit_field_class' => 'vc_col-sm-6 vc_column',
		        ),
		        array (
		        	'type' => 'colorpicker',
		        	'heading' => esc_html__('Button background color (hover)', 'xstore'),
		        	'param_name' => 'a_hover_bg',
		        	'group' => 'Cart',
		        	'dependency' =>  array('element' => 'cart_type', 'value' => array('button', 'icon') ),
		        	'edit_field_class' => 'vc_col-sm-6 vc_column',
		        ),
		        array (
			          'type' => 'textfield',
			          'heading' => 'Border radius',
			          'param_name' => 'a_radius',
			          'group' => 'Cart',
			          'dependency' =>  array('element' => 'cart_type', 'value' => array('button', 'icon') ),
			          'edit_field_class' => 'vc_col-sm-6 vc_column',
			    ),
			    array (
			          'type' => 'textfield',
			          'heading' => esc_html__('Margins (top right bottom left)','xstore'),
			          'param_name' => 'a_margin',
			          'group' => 'Cart',
			          'description' => esc_html__('Use this field to add element margin. For example 10px 20px 30px 40px', 'xstore'),
			          'dependency' =>  array('element' => 'cart_type', 'value' => array('button', 'icon') ),
			          'edit_field_class' => 'vc_col-sm-6 vc_column',
			    ),

		        // Wishlist options 
		        array (
		        	'type' => 'dropdown',
		        	'heading' => esc_html__('Type', 'xstore'),
		        	'param_name' => 'w_type',
		        	'value' => array (
		        		__('Icon', 'xstore') => 'icon',
	        			__('Text', 'xstore') => 'text',
		        		__('Icon + text', 'xstore') => 'icon-text',
		        		__('Button', 'xstore') => 'button',
		        	),
		        	'group' => 'Wishlist'
		        ),
		        array (
		        	'type' => 'textfield',
		        	'heading' => esc_html__('Font size', 'xstore'),
		        	'param_name' => 'w_size',
		        	'group' => 'Wishlist'
		        ),
		        array (
		        	'type' => 'dropdown',
		        	'heading' => esc_html__('Text transform', 'xstore'),
		        	'param_name' => 'w_transform',
		        	'value' => array (
		        		__('None', 'xstore') => '',
						__('Uppercase', 'xstore') => 'uppercase',
						__('Lowercase', 'xstore') => 'lowercase',
						__('Capitalize', 'xstore') => 'capitalize'
		        	),
		        	'group' => 'Wishlist',
		        	'dependency' => array('element' => 'w_type', 'value_not_equal_to' => 'icon')
		        ),
		        array (
		        	'type' => 'colorpicker',
		        	'heading' => esc_html__('Button background color', 'xstore'),
		        	'param_name' => 'w_bg',
		        	'group' => 'Wishlist',
		        	'dependency' =>  array('element' => 'w_type', 'value' => array('button', 'icon') ),
		        	'edit_field_class' => 'vc_col-sm-6 vc_column',
		        ),
		        array (
		        	'type' => 'colorpicker',
		        	'heading' => esc_html__('Button background color (hover)', 'xstore'),
		        	'param_name' => 'w_hover_bg',
		        	'group' => 'Wishlist',
		        	'dependency' =>  array('element' => 'w_type', 'value' => array('button', 'icon') ),
		        	'edit_field_class' => 'vc_col-sm-6 vc_column',
		        ),
		        array (
			        'type' => 'textfield',
			        'heading' => 'Border radius',
			        'param_name' => 'w_radius',
			        'group' => 'Wishlist',
			        'dependency' =>  array('element' => 'w_type', 'value' => array('button', 'icon') ),
			        'edit_field_class' => 'vc_col-sm-6 vc_column',
			    ),
			    array (
			        'type' => 'textfield',
			        'heading' => esc_html__('Margins (top right bottom left)','xstore'),
			        'param_name' => 'w_margin',
			        'group' => 'Wishlist',
			        'description' => esc_html__('Use this field to add element margin. For example 10px 20px 30px 40px', 'xstore'),
			        'dependency' =>  array('element' => 'w_type', 'value' => array('button', 'icon') ),
			        'edit_field_class' => 'vc_col-sm-6 vc_column',
			    ),
		    	
		    	// Quick view 
		    	array (
		        	'type' => 'dropdown',
		        	'heading' => esc_html__('Type', 'xstore'),
		        	'param_name' => 'quick_type',
		        	'value' => array (
		        		__('Icon', 'xstore') => 'icon',
	        			__('Text', 'xstore') => 'text',
		        		__('Icon + text', 'xstore') => 'icon-text',
		        		__('Button', 'xstore') => 'button',
		        	),
		        	'group' => 'Quick view'
		        ),
		        array (
		        	'type' => 'textfield',
		        	'heading' => esc_html__('Font size', 'xstore'),
		        	'param_name' => 'q_size',
		        	'group' => 'Quick view'
		        ),
		        array (
		        	'type' => 'dropdown',
		        	'heading' => esc_html__('Text transform', 'xstore'),
		        	'param_name' => 'q_transform',
		        	'value' => array (
		        		__('None', 'xstore') => '',
						__('Uppercase', 'xstore') => 'uppercase',
						__('Lowercase', 'xstore') => 'lowercase',
						__('Capitalize', 'xstore') => 'capitalize'
		        	),
		        	'group' => 'Quick view',
		        	'dependency' =>  array('element' => 'quick_type', 'value_not_equal_to' => 'icon'),
		       ),
		        array (
		        	'type' => 'colorpicker',
		        	'heading' => esc_html__('Button background color', 'xstore'),
		        	'param_name' => 'q_bg',
		        	'group' => 'Quick view',
		        	'dependency' =>  array('element' => 'quick_type', 'value' => array('button', 'icon') ),
		        	'edit_field_class' => 'vc_col-sm-6 vc_column',
		        ),
		        array (
		        	'type' => 'colorpicker',
		        	'heading' => esc_html__('Button background color (hover)', 'xstore'),
		        	'param_name' => 'q_hover_bg',
		        	'group' => 'Quick view',
		        	'dependency' =>  array('element' => 'quick_type', 'value' => array('button', 'icon') ),
		        	'edit_field_class' => 'vc_col-sm-6 vc_column',
		        ),
		        array (
			          'type' => 'textfield',
			          'heading' => 'Border radius',
			          'param_name' => 'q_radius',
			          'group' => 'Quick view',
			          'dependency' =>  array('element' => 'quick_type', 'value' => array('button', 'icon') ),
			          'edit_field_class' => 'vc_col-sm-6 vc_column',
			    ),
			    array (
			        'type' => 'textfield',
			        'heading' => esc_html__('Margins (top right bottom left)','xstore'),
			        'param_name' => 'q_margin',
			        'group' => 'Quick view',
			        'description' => esc_html__('Use this field to add element margin. For example 10px 20px 30px 40px', 'xstore'),
			        'dependency' =>  array('element' => 'quick_type', 'value' => array('button', 'icon') ),
			        'edit_field_class' => 'vc_col-sm-6 vc_column',
			    ),
		      ),

		        // Compare 
		        $compare_arr,
		        array (
	   		        array (
			        	'type' => 'colorpicker',
			        	'heading' => esc_html__('Text/icons color', 'xstore'),
			        	'param_name' => 'color',
			        	'edit_field_class' => 'vc_col-sm-3 vc_column',
			        ),
			        array (
			        	'type' => 'colorpicker',
			        	'heading' => esc_html__('Background color', 'xstore'),
			        	'param_name' => 'bg',
						'edit_field_class' => 'vc_col-sm-3 vc_column',			        
					),
			        array (
			        	'type' => 'colorpicker',
			        	'heading' => esc_html__('Text/icons hover color', 'xstore'),
			        	'param_name' => 'hover_color',
						'edit_field_class' => 'vc_col-sm-3 vc_column',			        
					),
			        array (
			        	'type' => 'colorpicker',
			        	'heading' => esc_html__('Background hover color', 'xstore'),
			        	'param_name' => 'hover_bg',
						'edit_field_class' => 'vc_col-sm-3 vc_column',			        
					),
			        array (
				          'type' => 'textfield',
				          'heading' => esc_html__('Border radius','xstore'),
				          'param_name' => 'radius',
				          'edit_field_class' => 'vc_col-sm-4 vc_column',
				    ),
				    array (
				          'type' => 'textfield',
				          'heading' => esc_html__('Paddings (top right bottom left)','xstore'),
				          'param_name' => 'paddings',
				          'description' => esc_html__('Use this field to add element paddings. For example 10px 20px 30px 40px', 'xstore'),
				          'edit_field_class' => 'vc_col-sm-4 vc_column',
				    ),
				    array(
				    	'type' => 'textfield',
				    	'heading' => esc_html__('Extra class', 'xstore'),
				    	'param_name' => 'el_class',
				    ),
				    array(
						'type' => 'css_editor',
						'heading' => esc_html__( 'CSS box', 'xstore' ),
						'param_name' => 'css',
						'group' => __( 'Design Options', 'xstore' ),
					)
			    )
	     	),
  	);
 
   return $shortcodes;
}
 
/* **************************** */
/* === Product title render === */
/* **************************** */

function etheme_product_name_render($atts) {

	if ( ! class_exists('WooCommerce') ) return;

	global $post;
	$id = $post->ID;
	$product = wc_get_product($id);

	if ( ! is_array( $atts ) ) {
		$atts = array();
	}

	if( empty( $atts['title_google_fonts'] ) ) {
      $atts['title_google_fonts'] = 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal';
    }

	extract( shortcode_atts( 
		array(
			'align' => '',
			'link' => 'product_link',
			'url' => '',
			'symbols' => '...',
			'cutting' => '',
			'count' => '',
			'spacing' => '',
			'size' => '',
			'line_height' => '',
			'color' => '',
			'el_class' => '',
			'css' => ''
		), $atts)
	);

	$full_name = $post_name = unicode_chars($product->get_title());

	// get the link
	$link = ($link != '' ) ? get_permalink() : '';
	$url = vc_build_link($url);
  	$a_target = '_self';
  	$a_title = $class =  $style = '';
  	$el_class .= (!empty($align)) ? ' text-'.$align : '';
  	if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
        $el_class .= ' ' . vc_shortcode_custom_css_class( $css );
    }

	if (isset($url['url']) && strlen( $url['url'] ) > 0 ) {
	    $link = $url['url'];
	    $a_title = $url['title'];
	    $a_target = strlen( $url['target'] ) > 0 ? $url['target'] : '_self';
	}

	if ( strlen($post_name) > 0 && $cutting != 'none') {
		if ( $cutting == 'letters' )
		$split = preg_split('/(?<!^)(?!$)/u', $post_name);
		else
		$split = explode(' ', $post_name);

		$post_name = ($count != '' && $count > 0 && (count($split) >= $count)) ? '' : $post_name;
		if ( $post_name == '' ) {
			if ( $cutting == 'letters' ) {
				for ($i=0; $i < $count; $i++) { 
					$post_name .= $split[$i];
				}
			}
			else {
				for ($i=0; $i < $count; $i++) { 
					$post_name .= ' '.$split[$i];
				}
			}
		}
		if ( strlen($post_name) < strlen($full_name) ) $post_name .= $symbols;
	}

	/* data css */
	if ( !empty($spacing) || !empty($color) || !empty($size) ) {
  		$el_class .= ' etheme-css-one';
    	$style .= 'data-css=".content-product .product-title{';
    	if ( !empty($spacing) ) {
    		$style .= 'letter-spacing: '.$spacing.';';
    	}
    	if ( !empty($color) ) {
    		$style .= 'color: '.$color.';';
    	}
   	 	if ( !empty($size) ) {
	    	$style .= 'font-size: '.$size.';';
	    }
    	$style .= '}';
		$style .= '"';
	}

	$atts['title_link'] = '';
	$atts['title'] = $post_name;

	$out = '<div class="'.$el_class.' text-'.$align.'" '.$style.'>';

	$out .= ($link != '') ? '<a href="'. $link . '" title="'.$a_title. '" target="'. $a_target. '">' : '';

	$out .= etheme_getHeading('title', $atts, 'product-title');

	$out .= ($link != '') ? '</a>' : '';

	$out .= '</div>';
	
   return $out; // usage of template variable post_data with argument "ID"
} 

/* **************************** */
/* === Product image render === */
/* **************************** */

function etheme_product_image_render($atts) {
	global $post;
	if ( ! class_exists('WooCommerce') ) return;

	extract(shortcode_atts(
		array(
			'link' => 'product_link',
			'url' => '',
			'align' => '',
			'style' => '',
			'hover' => '',
			'border_color' => '',
			'el_class' => '',
			'css' => ''
		), $atts)
	);

	$id = $post->ID;
	$el_class .= ' '.$style;
	$el_class .= ' hover-effect-'.$hover;
	// get the link 
	$link = ($link != '' ) ? get_permalink() : '';
	$url = vc_build_link($url);
  	$a_target = '_self';
  	$a_title = '';
	if (isset($url['url']) && strlen( $url['url'] ) > 0 ) {
	    $link = $url['url'];
	    $a_title = $url['title'];
	    $a_target = strlen( $url['target'] ) > 0 ? $url['target'] : '_self';
	}

	// get the css 
	if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
        $el_class .= ' ' . vc_shortcode_custom_css_class( $css );
      }

	// vc image style 
	$el_class .= ($border_color != '') ? ' vc_box_border_'.$border_color : ' vc_box_border_grey';

	// product image under 
	$post_thumbnail_id = get_post_thumbnail_id( $id );
    $full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
    $placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
	$attributes = array(
        'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
        'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
        'data-src'                => $full_size_image[0],
        'data-large_image'        => $full_size_image[0],
        'data-large_image_width'  => $full_size_image[1],
        'data-large_image_height' => $full_size_image[2],
    );


    // echo product image
     ob_start(); ?>
    <div class="wpb_single_image text-<?php echo esc_attr( $align ); ?>">
    <div class="product-image-wrapper vc_single_image-wrapper <?php echo esc_attr( $el_class ); ?>">
    <?php if ($link != '') { ?> <a class="product-content-image" href="<?php echo esc_url( $link ); ?>" data-images="<?php echo  etheme_get_image_list( 'shop_catalog' ); ?>"> <?php } ?>
    <?php if ( $hover == 'swap' ) echo etheme_get_second_image('shop_catalog'); ?>
    <?php echo ( get_the_post_thumbnail( $id, 'shop_catalog' ) != '' ) ? get_the_post_thumbnail( $id, 'shop_catalog', $attributes ) : wc_placeholder_img(); ?>
    <?php if($link != '') { ?> </a> <?php } ?>
    </div>
    </div>

	
   <?php return ob_get_clean(); // usage of template variable post_data with argument "ID"
}

/* **************************** */
/* === Product excerpt render === */
/* **************************** */

function etheme_product_excerpt_render($atts) {
	global $post;
	if ( ! class_exists('WooCommerce') ) return;

	if( empty( $atts['title_google_fonts'] ) ) {
      $atts['title_google_fonts'] = 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal';
    }

	$id = $post->ID;
	$product = wc_get_product($id);
	extract( shortcode_atts( 
		array(
			'cutting' => '',
			'count' => '',
			'align' => '',
			'use_custom_fonts_title' => '',
			'symbols' => '...',
			'spacing' => '',
			'size' => '',
			'line_height' => '',
			'color' => '',
			'css' => '',
			'el_class' => ''
		), $atts)
	);

	$style = '';
	$el_class .= (!empty($align)) ? ' text-'.$align : '';
	if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
        $el_class .= ' ' . vc_shortcode_custom_css_class( $css );
    }

	$excerpt = $short_descr = unicode_chars($product->get_short_description());
	if ( strlen($short_descr) > 0 && $cutting != 'none') {
		if ( $cutting == 'letters' )
		$split = preg_split('/(?<!^)(?!$)/u', $short_descr);
		else
		$split = explode(' ', $short_descr);

		$excerpt = ($count != '' && $count > 0 && (count($split) >= $count)) ? '' : $short_descr;
		if ( $excerpt == '' ) {
			if ( $cutting == 'letters' ) {
				for ($i=0; $i < $count; $i++) { 
					$excerpt .= $split[$i];
				}
			}
			else {
				for ($i=0; $i < $count; $i++) { 
					$excerpt .= ' '.$split[$i];
				}
			}
		}
		if ( strlen($excerpt) < strlen($short_descr) ) $excerpt .= $symbols;
	}
	/* data css */
	if ( !empty($spacing) || !empty($color) || !empty($size) || !empty($color_sale)) {
    	$style .= 'data-css=".content-product .excerpt {';
    	if ( !empty($spacing) ) {
    		$style .= 'letter-spacing: '.$spacing.';';
    	}
    	if ( !empty($color) ) {
    		$style .= 'color: '.$color.';';
    	}
   	 	if ( !empty($size) ) {
	    	$style .= 'font-size: '.$size.';';
	    }
    	$style .= '}';
		$style .= '"';
	}

	$atts['title_link'] = '';
	$atts['title'] = $excerpt;

	$out = etheme_getHeading('title', $atts, 'excerpt '. $el_class);
	$out .= !empty($style) ? '<span class="etheme-css-one hidden" '.$style.'></span>' : '';
	
   return $out; 
}

/* **************************** */
/* === Product rating render === */
/* **************************** */

function etheme_product_rating_render($atts) {
	global $post;
	if ( ! class_exists('WooCommerce') ) return;

	$id = $post->ID;
	$product = wc_get_product($id);
	extract( shortcode_atts( 
		array(
			'default' => '',
			'css' => '',
			'el_class' => ''
		), $atts)
	);
	$rating_count = $product->get_rating_count();
	$review_count = $product->get_review_count();
	$average      = $product->get_average_rating();
	$out = '';

	if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
        $el_class .= ' ' . vc_shortcode_custom_css_class( $css );
    }

	if ( $default) {
		$rating_html = '<div class="woocommerce-product-rating '.$el_class.'">';
	 	$rating_html .= '<div class="star-rating" title="' . sprintf( esc_attr__( 'Rated %s out of 5', 'xstore' ), $average ) . '">'; 
        $rating_html .= '<span style="width:' . ( ( $average / 5 ) * 100 ) . '%"><strong class="rating">' . $average . '</strong> ' . esc_html__( 'out of 5', 'xstore' ) . '</span>'; 
        $rating_html .= '</div>'; 
		$rating_html .= '</div>';
		$out = apply_filters( 'woocommerce_product_get_rating_html', $rating_html, $average );
	}
	elseif ( $rating_count > 0 ) {
		$out .= '<div class="woocommerce-product-rating '.$el_class.'">';
		$out .= wc_get_rating_html( $average, $rating_count );
		$out .= '</div>';
	}

	return $out; 
}

/* **************************** */
/* === Product price render === */
/* **************************** */

function etheme_product_price_render($atts) {
	global $post;
	if ( ! class_exists('WooCommerce') ) return;
	$id = $post->ID;
	$product = wc_get_product($id);
	extract( shortcode_atts( 
		array(
			'align' => '',
			'spacing' => '',
			'color' => '',
			'color_sale' => '',
			'size' => '',
			'css' => '',
			'el_class' => ''
		), $atts)
	);

	$el_class .= (!empty($align)) ? ' text-'.$align : '';
	$out = '';

	if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
        $el_class .= ' ' . vc_shortcode_custom_css_class( $css );
    }

    $style = '';

  	if ( !empty($spacing) || !empty($color) || !empty($size) || !empty($color_sale)) {
  		$el_class .= ' etheme-css-one';
    	$style .= 'data-css=".content-product .price{';
    	if ( !empty($spacing) ) {
    		$style .= 'letter-spacing: '.$spacing.';';
    	}
    	if ( !empty($color) ) {
    		$style .= 'color: '.$color.';';
    	}
   	 	if ( !empty($size) ) {
	    	$style .= 'font-size: '.$size.';';
	    }
    	$style .= '}';
    	if ( !empty($color_sale) ){
	   		$style .=  '.content-product .price ins .amount{';
	   		$style .= 'color:'.$color_sale.';';
	   		$style .= '}';
   		}
   		$style .= '"';
    }

    $out .= '<div class="price '.$el_class.'" '.$style.'>';

    $out .= $product->get_price_html();

    $out .= '</div>';
	
   return $out;
}

/* **************************** */
/* === Product sku render === */
/* **************************** */

function etheme_product_sku_render($atts) {
	global $post;
	if ( ! class_exists('WooCommerce') ) return;
	$id = $post->ID;
	$product = wc_get_product($id);
	extract( shortcode_atts( 
		array(
			'align' => '',
			'transform' => '',
			'color' => '',
			'size' => '',
			'css' => '',
			'el_class' => ''
		), $atts)
	);

	$el_class .= (!empty($align)) ? ' text-'.$align : '';
	$el_class .= (!empty($transform)) ? ' '.$transform : '';
	$sku = $product->get_sku();
	$out = $style = '';

	if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
        $el_class = ' ' . vc_shortcode_custom_css_class( $css );
    }

    if ( !empty($color) || !empty($size) ) {
  		$el_class .= ' etheme-css-one';
    	$style .= 'data-css=".content-product .sku{';
    	if ( !empty($color) ) {
    		$style .= 'color: '.$color.';';
    	}
   	 	if ( !empty($size) ) {
	    	$style .= 'font-size: '.$size.';';
	    }
    	$style .= '}';
   		$style .= '"';
    }

    if ( strlen($sku) > 0 ) {

	    $out .= '<div class="sku '.$el_class.'" '.$style.'>';

	    $out .= $sku;

	    $out .= '</div>';
	}
	
   return $out;
}


/* **************************** */
/* === Product brands render === */
/* **************************** */

function etheme_product_brands_render($atts) {
	global $post;
	if ( ! class_exists('WooCommerce') ) return;

	extract( shortcode_atts( 
		array(
			'align' => '',
			'transform' => '',
			'spacing' => '',
			'size' => '',
			'img' => '',
			'css' => '',
			'el_class' => ''
		), $atts)
	);

	$el_class .= (!empty($align)) ? ' text-'.$align : '';
	$el_class .= (!empty($transform)) ? ' '.$transform : '';
	$style = '';

	if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
        $el_class = ' ' . vc_shortcode_custom_css_class( $css );
    }

   if ( !empty($spacing) || !empty($color) || !empty($size) ) {
  		$el_class .= ' etheme-css-one';
    	$style .= 'data-css=".content-product .product_brand{';
    	if ( !empty($spacing) ) {
    		$style .= 'letter-spacing: '.$spacing.';';
    	}
    	if ( !empty($color) ) {
    		$style .= 'color: '.$color.';';
    	}
   	 	if ( !empty($size) ) {
	    	$style .= 'font-size: '.$size.';';
	    }
    	$style .= '}';
   		$style .= '"';
    }

    $terms = wp_get_post_terms( $post->ID, 'brand' );
		if ( count( $terms ) < 1 ) return;
		$_i = 0;
		ob_start();
		?>
			<div class="product_brand <?php echo esc_attr( $el_class ); ?>" <?php echo esc_attr( $style ); ?>>
				<?php foreach( $terms as $brand ) : $_i++;?>
					<?php 
						$thumbnail_id 	= absint( get_woocommerce_term_meta( $brand->term_id, 'thumbnail_id', true ) ); ?>
						<a href="<?php echo get_term_link( $brand ); ?>">
							<?php if ($thumbnail_id && $img ) {
				                echo wp_get_attachment_image( $thumbnail_id, 'full' );
							} else {?>
				            	<?php echo esc_html( $brand->name ); ?>
			            	<?php } ?>
						</a>
					<?php if ( count( $terms ) > $_i ) echo ", "; ?>
				<?php endforeach; ?>
			</div>
		<?php
	
   return ob_get_clean();
}

/* **************************** */
/* === Product categories render === */
/* **************************** */

function etheme_product_categories_render($atts) {
	global $post;
	if ( ! class_exists('WooCommerce') ) return;

	if( empty( $atts['title_google_fonts'] ) ) {
      $atts['title_google_fonts'] = 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal';
    }

	$id = $post->ID;
	$product = wc_get_product($id);
	extract( shortcode_atts( 
		array(
			'cutting' => '',
			'count' => '',	
			'tag' => 'p',
			'align' => '',
			'use_custom_fonts_title' => '',
			'symbols' => '...',
			'css' => '',
			'el_class' => ''
		), $atts)
	);

	$el_class .= ' products-page-cats';
	$el_class .= (!empty($align)) ? ' text-'.$align : '';
	if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
        $el_class .= ' ' . vc_shortcode_custom_css_class( $css );
    }
	$atts['title_link'] = '';
	$atts['title'] = $cats = wc_get_product_category_list( $id, ', ' );

	if ( !$use_custom_fonts_title ) 
	$out = '<div class="'.$el_class.'">'.$cats.'</div>';
	else 
	$out = etheme_getHeading('title', $atts, $el_class);
	
   return $out; // usage of template variable post_data with argument "ID"
}

/* **************************** */
/* === Product buttons render === */
/* **************************** */

function etheme_product_buttons_render ($atts) {
	global $post;

	if ( !class_exists('WooCommerce') ) return;

	$id = $post->ID;
	$product = wc_get_product($id);

	extract( shortcode_atts(
		array (
			// Buttons types
			'cart_type' => 'icon',
			'w_type' => 'icon',
			'compare_type' => 'icon',
			'quick_type' => 'icon',
			// Sizes
			'a_size' => '',
			'w_size' => '',
			'q_size' => '',
			'c_size' => '',
			// Transforms
			'a_transform' => '',
			'w_transform' => '',
			'q_transform' => '',
			'c_transform' => '',
			// Background colors
			'a_bg' => '',
			'w_bg' => '',
			'q_bg' => '',
			'c_bg' => '',

			// Background colors (hover)
			'a_hover_bg' => '',
			'w_hover_bg' => '',
			'q_hover_bg' => '',
			'c_hover_bg' => '',

			// Border radius
			'a_radius' => '',
			'w_radius' => '',
			'q_radius' => '',
			'c_radius' => '',

			// Margins 
			'a_margin' => '',
			'w_margin' => '',
			'q_margin' => '',
			'c_margin' => '',

			// Common options
			'align' => 'start',
			'v_align' => 'start',
			'type' => '',
			'color' => '',
			'bg' => '',
			'hover_color' => '',
			'hover_bg' => '',

			// Paddings and radius
			'radius' => '',
			'paddings' => '',

			'el_class' => '',
			'css' => '',
			'sorting' => '',
		), $atts )
	);
	$out = $style = $footer_class = ''; 

	$sorting = (!empty($sorting)) ? explode(',', $sorting) : array();

	$rand_id = rand(100, 999);
	$el_class .= ' footer-product-'.$rand_id;

	$footer_class .= (!empty($align)) ? ' justify-content-'.$align : '';
	$footer_class .= (!empty($v_align)) ? ' align-items-'.$v_align : '';
	$footer_class .= ' '.$type;

	if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
        $el_class .= ' ' . vc_shortcode_custom_css_class( $css );
    }

    $sorting = array_flip($sorting);

    $data_css = $a_size || $w_size || $q_size || $c_size || $a_transform || $w_transform || $q_transform || $c_transform || $color || $bg || $hover_color || $hover_bg || $radius || $paddings || $a_bg || $w_bg || $q_bg || $c_bg || $a_hover_bg || $w_hover_bg || $q_hover_bg || $c_hover_bg || $a_radius || $w_radius || $q_radius || $c_radius || $a_margin || $w_margin || $q_margin || $c_margin || (count($sorting) > 0);
    if ( $data_css ) {
    	$el_class .= ' etheme-css-one';
    	$style .= ' data-css="';

		if ( $a_transform || $a_size || $a_bg || $a_radius || $a_margin || isset($sorting['cart'])) { 
			$style .= '.footer-product-'.$rand_id . ' .add_to_cart_button { ';
			if ($a_transform) $style .= 'text-transform: '.$a_transform.';';
			if ($a_size) $style .= 'font-size: '.$a_size.';';
			if ($a_bg) $style .= 'background-color:'.$a_bg.';';
			if ($a_radius) $style .= 'border-radius:'.$a_radius.';';
			if ($a_margin) $style .= 'margin:'.$a_margin.';';
			if (isset($sorting['cart'])) $style .= 'order: '.$sorting['cart'].';';
			$style .= '}';
		}
		if ($a_hover_bg) {
			$style .= '.footer-product-'.$rand_id . ' .add_to_cart_button:hover { ';
			$style .= 'background-color:'.$a_hover_bg.';';
			$style .= '}';
		}
		if ( $w_transform  || $w_size || $w_bg || $w_radius || $w_margin || isset($sorting['wishlist'])) { 
			$style .= '.footer-product-'.$rand_id . ' .et-wishlist-holder { ';
			if ($w_transform) $style .= 'text-transform: '.$w_transform.';';
			if ($w_size) $style .= 'font-size: '.$w_size.';';
			if ($w_bg) $style .= 'background-color:'.$w_bg.';';
			if ($w_radius) $style .= 'border-radius:'.$w_radius.';';
			if ($w_margin) $style .= 'margin:'.$w_margin.';';
			if (isset($sorting['wishlist'])) $style .= 'order: '.$sorting['wishlist'].';';
			$style .= '}';
			
		}
		if ($w_hover_bg) {
			$style .= '.footer-product-'.$rand_id . ' .et-wishlist-holder:hover { ';
			$style .= 'background-color:'.$w_hover_bg.';';
			$style .= '}';
		}
		if ( $q_transform  || $q_size || $q_bg || $q_radius || $q_margin || isset($sorting['q_view']) ) { 
			$style .= '.footer-product-'.$rand_id . ' .show-quickly { ';
			if ($q_transform) $style .= 'text-transform: '.$q_transform.';';
			if ($q_size) $style .= 'font-size: '.$q_size.';';
			if ($q_bg) $style .= 'background-color:'.$q_bg.';';
			if ($q_radius) $style .= 'border-radius:'.$q_radius.';';
			if ($q_margin) $style .= 'margin:'.$q_margin.';';
			if (isset($sorting['q_view'])) $style .= 'order: '.$sorting['q_view'].';';
			$style .= '}';
		}
		if ($q_hover_bg) {
			$style .= '.footer-product-'.$rand_id . ' .show-quickly:hover { ';
			$style .= 'background-color:'.$q_hover_bg.';';
			$style .= '}';
		}
		if ( $c_transform  || $c_size || $c_bg || $c_radius || $c_margin || isset($sorting['compare']) ) { 
			$style .= '.footer-product-'.$rand_id . ' .compare { ';
			if ($c_transform) $style .= 'text-transform: '.$c_transform.';';
			if ($c_size) $style .= 'font-size: '.$c_size.';';
			if ($c_bg) $style .= 'background-color:'.$c_bg.';';
			if ($c_radius) $style .= 'border-radius:'.$c_radius.';';
			if ($c_margin) $style .= 'margin:'.$c_margin.';';
			if (isset($sorting['compare'])) $style .= 'order: '.$sorting['compare'].';';
			$style .= '}';
		}
		if ($c_hover_bg) {
			$style .= '.footer-product-'.$rand_id . ' .compare:hover { ';
			$style .= 'background-color:'.$c_hover_bg.';';
			$style .= '}';
		}
		if ( $color ) {
			$style .= '.footer-product-'.$rand_id . '> *, .footer-product-'.$rand_id.' .button, .footer-product-'.$rand_id.' a {color:'.$color.'}';
		}
		if ( $bg ) {
			$style .= '.footer-product-'.$rand_id . ' {background-color:'.$bg.'}';
		}

		if ( $hover_color ) {
			$style .= '.footer-product-'.$rand_id . '> *:hover, .footer-product-'.$rand_id . '> *:hover *, .footer-product-'.$rand_id.' .button:hover, .footer-product-'.$rand_id.' .yith-wcwl-wishlistexistsbrowse.show a:before {color:'.$hover_color.'}';
		}
		if ( $hover_bg ) {
			$style .= '.footer-product-'.$rand_id . ':hover {background-color:'.$hover_bg.'}';
		}

		if ( $radius ) $style .= '.footer-product-'.$rand_id.'{border-radius:'.$radius.';}';
		if ( $paddings ) $style .= '.footer-product-'.$rand_id.'{padding:'.$paddings.';}';

    	$style .= '"';
    }

    if ( count($sorting) > 0 && !array_key_exists('compare', $sorting) ) $footer_class .= ' compare-hidden';
    if ( (count($sorting) > 0 && array_key_exists('cart', $sorting)) || count($sorting) == 0 ) $footer_class .= ' cart-type-'.$cart_type;
    if ( (count($sorting) > 0 && array_key_exists('compare', $sorting)) || count($sorting) == 0 ) $footer_class .= ' compare-type-'.$compare_type;

	ob_start(); ?>
	<footer class="footer-product2 <?php echo esc_attr( $footer_class ); ?>"><div class="footer-inner <?php echo esc_attr( $el_class ); ?>" <?php echo wp_specialchars_decode($style); ?>>

		<?php 

			if ( (count($sorting) > 0 && array_key_exists('q_view', $sorting)) || count($sorting) == 0 ) : ?>
			<span class="show-quickly type-<?php echo esc_attr( $quick_type ); ?>" data-prodid="<?php echo esc_attr( $id ); ?>"><?php esc_html_e('Quick View', 'xstore'); ?></span>
			<?php endif; ?>

			<?php if ( (count($sorting) > 0 && array_key_exists('cart', $sorting)) || count($sorting) == 0 )
			do_action('woocommerce_after_shop_loop_item'); 

			if ( (count($sorting) > 0 && array_key_exists('wishlist', $sorting)) || count($sorting) == 0 )
			echo etheme_wishlist_btn(array('type' => $w_type)); ?>

	</div>
	</footer>

	<?php return ob_get_clean();

}
class ET_product_templates {

	protected $template = '';
	protected $html_template = false;
	protected $post = false;
	protected $grid_atts = array();
	protected $is_end = false;
	protected static $templates_added = false;
	protected $shortcodes = false;
	protected $found_variables = false;
	protected static $predefined_templates = false;
	protected $template_id = false;
	protected static $custom_fields_meta_data = false;

	/**
	 * Get shortcodes to build vc grid item templates.
	 *
	 * @return bool|mixed|void
	 */
	public function shortcodes() {
		if ( false === $this->shortcodes ) {
			$this->shortcodes = include vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/shortcodes.php' );
			$this->shortcodes = apply_filters( 'vc_grid_item_shortcodes', $this->shortcodes );
		}
		add_filter( 'vc_shortcode_set_template_vc_icon', array( $this, 'addVcIconShortcodesTemplates' ) );
		add_filter( 'vc_shortcode_set_template_vc_button2', array( $this, 'addVcButton2ShortcodesTemplates' ) );
		add_filter( 'vc_shortcode_set_template_vc_single_image', array(
			$this,
			'addVcSingleImageShortcodesTemplates',
		) );
		add_filter( 'vc_shortcode_set_template_vc_custom_heading', array(
			$this,
			'addVcCustomHeadingShortcodesTemplates',
		) );
		add_filter( 'vc_shortcode_set_template_vc_btn', array( $this, 'addVcBtnShortcodesTemplates' ) );

		add_filter( 'vc_gitem_template_attribute_post_image_background_image_css', array ( $this, 'vc_gitem_template_attribute_post_image_background_image_css'), 10, 2 );

		return $this->shortcodes;
	}

	/**
 * Get post image url
 *
 * @param $value
 * @param $data
 * @return string
 */
public function vc_gitem_template_attribute_post_image_background_image_css( $value, $data ) {
	$output = '';
	if ( !class_exists('WooCommerce') ) return $output;

	global $post;
	/**
	 * @var null|Wp_Post $post ;
	 */
	extract( array_merge( array(
		'data' => '',
	), $data ) );
	$size = 'shop_catalog'; // default size

	if ( ! empty( $data ) ) {
		$size = $data;
	}

	$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
    $src   = wp_get_attachment_image_src( $post_thumbnail_id, $size );

	if ( ! empty( $src ) ) {
		$output = 'background-image: url(\'' . ( is_array( $src ) ? $src[0] : $src ) . '\') !important;';
	} elseif (class_exists('WooCommerce')) {
		$output = 'background-image: url(\'' . wc_placeholder_img_src() . '\') !important;';
	}

	return apply_filters( 'vc_gitem_template_attribute_post_image_background_image_css_value', $output );
}

	/**
	 * Used by filter vc_shortcode_set_template_vc_icon to set custom template for vc_icon shortcode.
	 *
	 * @param $template
	 *
	 * @return string
	 */
	public function addVcIconShortcodesTemplates( $template ) {
		$file = vc_path_dir( 'TEMPLATES_DIR', 'params/vc_grid_item/shortcodes/vc_icon.php' );
		if ( is_file( $file ) ) {
			return $file;
		}

		return $template;
	}

	/**
	 * Used by filter vc_shortcode_set_template_vc_button2 to set custom template for vc_button2 shortcode.
	 *
	 * @param $template
	 *
	 * @return string
	 */
	public function addVcButton2ShortcodesTemplates( $template ) {
		$file = vc_path_dir( 'TEMPLATES_DIR', 'params/vc_grid_item/shortcodes/vc_button2.php' );
		if ( is_file( $file ) ) {
			return $file;
		}

		return $template;
	}

	/**
	 * Used by filter vc_shortcode_set_template_vc_single_image to set custom template for vc_single_image shortcode.
	 *
	 * @param $template
	 *
	 * @return string
	 */
	public function addVcSingleImageShortcodesTemplates( $template ) {
		$file = vc_path_dir( 'TEMPLATES_DIR', 'params/vc_grid_item/shortcodes/vc_single_image.php' );
		if ( is_file( $file ) ) {
			return $file;
		}

		return $template;
	}

	/**
	 * Used by filter vc_shortcode_set_template_vc_custom_heading to set custom template for vc_custom_heading
	 * shortcode.
	 *
	 * @param $template
	 *
	 * @return string
	 */
	public function addVcCustomHeadingShortcodesTemplates( $template ) {
		$file = vc_path_dir( 'TEMPLATES_DIR', 'params/vc_grid_item/shortcodes/vc_custom_heading.php' );
		if ( is_file( $file ) ) {
			return $file;
		}

		return $template;
	}

	/**
	 * Used by filter vc_shortcode_set_template_vc_button2 to set custom template for vc_button2 shortcode.
	 *
	 * @param $template
	 *
	 * @return string
	 */
	public function addVcBtnShortcodesTemplates( $template ) {
		$file = vc_path_dir( 'TEMPLATES_DIR', 'params/vc_grid_item/shortcodes/vc_btn.php' );
		if ( is_file( $file ) ) {
			return $file;
		}

		return $template;
	}

	/**
	 * Map shortcodes for vc_grid_item param type.
	 */
	public function mapShortcodes() {
		// @kludge
		// TODO: refactor with with new way of roles for shortcodes.
		// NEW ROLES like post_type for shortcode and access policies.
		$shortcodes = $this->shortcodes();
		foreach ( $shortcodes as $shortcode_settings ) {
			vc_map( $shortcode_settings );
		}
	}

	/**
	 * Get list of predefined templates.
	 *
	 * @return bool|mixed
	 */
	public static function predefinedTemplates() {
		if ( false === self::$predefined_templates ) {
			self::$predefined_templates = apply_filters( 'vc_grid_item_predefined_templates',
			include vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/templates.php' ) );
		}

		return self::$predefined_templates;
	}

	/**
	 * @param $id - Predefined templates id
	 *
	 * @return array|bool
	 */
	public static function predefinedTemplate( $id ) {
		if ( $id == '' ) { $id = etheme_get_option('custom_product_template'); }
		$predefined_templates = self::predefinedTemplates();
		if ( isset( $predefined_templates[ $id ]['template'] ) ) {
			return $predefined_templates[ $id ];
		}

		return false;
	}

	/**
	 * Set template which should grid used when vc_grid_item param value is rendered.
	 *
	 * @param $id
	 *
	 * @return bool
	 */
	public function setTemplateById( $id ) {
		if ( $id == '' ) { $id = etheme_get_option('custom_product_template'); }
		require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/templates.php' );
		if ( 0 === strlen( $id ) ) {
			return false;
		}
		if ( preg_match( '/^\d+$/', $id ) ) {
			$post = get_post( (int) $id );
			$post && $this->setTemplate( $post->post_content, $post->ID );

			return true;
		} elseif ( false !== ( $predefined_template = $this->predefinedTemplate( $id ) ) ) {
			$this->setTemplate( $predefined_template['template'], $id );

			return true;
		}

		return false;
	}

	/**
	 * Setter for template attribute.
	 *
	 * @param $template
	 * @param $template_id
	 */
	public function setTemplate( $template, $template_id ) {
		$this->template = $template;
		$this->template_id = $template_id;
		$this->parseTemplate( $template );
	}

	/**
	 * Add custom css from shortcodes that were mapped for vc grid item.
	 * @return string
	 */
	public function addShortcodesCustomCss($id = '') {
		$output = $shortcodes_custom_css = '';
		if ( preg_match( '/^\d+$/', $id ) ) {
			$shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
		} elseif ( false !== ( $predefined_template = $this->predefinedTemplate( $id ) ) ) {
			$shortcodes_custom_css = visual_composer()->parseShortcodesCustomCss( $predefined_template['template'] );
		}
		if ( ! empty( $shortcodes_custom_css ) ) {
			$shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
			$output .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
			$output .= $shortcodes_custom_css;
			$output .= '</style>';
		}

		return $output;
	}

	/**
	 * Generates html with template's variables for rendering new project.
	 *
	 * @param $template
	 */
	public function parseTemplate( $template ) {
		$this->mapShortcodes();
		WPBMap::addAllMappedShortcodes();
		$attr = ' width="' . $this->gridAttribute( 'element_width', 12 ) . '"'
		        . ' is_end="' . ( 'true' === $this->isEnd() ? 'true' : '' ) . '"';
		$template = preg_replace( '/(\[(\[?)vc_gitem\b)/', '$1' . $attr, $template );
		$this->html_template .= do_shortcode( $template );
	}

	/**
	 * Regexp for variables.
	 * @return string
	 */
	public function templateVariablesRegex() {
		return '/\{\{' . '\{?' . '\s*' . '([^\}\:]+)(\:([^\}]+))?' . '\s*' . '\}\}' . '\}?/';
	}

	/**
	 * Get default variables.
	 *
	 * @return array|bool
	 */
	public function getTemplateVariables() {
		if ( ! is_array( $this->found_variables ) ) {
			preg_match_all( $this->templateVariablesRegex(), $this->html_template, $this->found_variables, PREG_SET_ORDER );
		}

		return $this->found_variables;
	}

	/**
	 * Render item by replacing template variables for exact post.
	 *
	 * @param WP_Post $post
	 *
	 * @return mixed
	 */
	function renderItem( WP_Post $post, $content ) {
		$pattern = array();
		$replacement = array();
		foreach ( $this->getTemplateVariables() as $var ) {
			$pattern[] = '/' . preg_quote( $var[0], '/' ) . '/';
			$replacement[] = preg_replace( '/\\$/', '\\\$', $this->attribute( $var[1], $post, isset( $var[3] ) ? trim( $var[3] ) : '' ) );
		}

		return preg_replace( $pattern, $replacement, do_shortcode( $content ) );
	}

	/**
	 * Adds filters to build templates variables values.
	 */
	public function addAttributesFilters() {
		require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/attributes.php' );
	}

	/**
	 * Setter for Grid shortcode attributes.
	 *
	 * @param $name
	 * @param string $default
	 *
	 * @return string
	 */
	public function gridAttribute( $name, $default = '' ) {
		return isset( $this->grid_atts[ $name ] ) ? $this->grid_atts[ $name ] : $default;
	}

	/**
	 * Get attribute value for WP_post object.
	 *
	 * @param $name
	 * @param $post
	 * @param string $data
	 *
	 * @return mixed|void
	 */
	public function attribute( $name, $post, $data = '' ) {
		$data = html_entity_decode( $data );
		return apply_filters( 'vc_gitem_template_attribute_' . trim( $name ),
			( isset( $post->$name ) ? $post->$name : '' ), array(
				'post' => $post,
				'data' => $data,
			) );
	}

	/**
	 * Checks is the end.
	 * @return bool
	 */
	public function isEnd() {
		return $this->is_end;
	}

    }