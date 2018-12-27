<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************//
// ! Follow icons
// **********************************************************************//
if(!function_exists('etheme_follow_shortcode')) {
    function etheme_follow_shortcode($atts) {
        extract(shortcode_atts(array(
        'title'  => '',
        'size' => 'normal',
        'align' => 'center',
        'target' => '_blank',
        'facebook' => '',
        'twitter' => '',
        'instagram' => '',
        'google' => '',
        'skype' => '',
        'pinterest' => '',
        'linkedin' => '',
        'tumblr' => '',
        'youtube' => '',
        'vimeo' => '',
        'rss' => '',
        'vk' => '',
        'tripadvisor' => '',
        'houzz' => '',
        'icons_bg' => '',
        'icons_color' => '',
        'icons_bg_hover' => '',
        'icons_color_hover' => '',
        'filled' => '',
        'css' => ''
        ), $atts));

        $class = '';
        $class .= 'buttons-size-'.$size;
        $class .= ' align-'.$align;

        if( $filled ) {
            $class .= ' icons-filled';
        }

        $target = 'target="' . $target . '"';

        $id = rand( 100, 999 );

        if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
            $class = ' ' . vc_shortcode_custom_css_class( $css );
        }

        $class .= ' follow-'. $id;

        $output = '<div class="et-follow-buttons '.$class.'">';

        if( $facebook ) {
            $output .= '<a href="'. esc_url( $facebook ) .'" class="follow-facebook" '.$target.'><i class="et-icon et-facebook "></i></a>';
        }

        if( $twitter ) {
            $output .= '<a href="'. esc_url( $twitter ) .'" class="follow-twitter" '.$target.'><i class="et-icon et-twitter"></i></a>';
        }

        if( $instagram ) {
            $output .= '<a href="'. esc_url( $instagram ) .'" class="follow-instagram" '.$target.'><i class="et-icon et-instagram"></i></a>';
        }

        if( $google ) {
            $output .= '<a href="'. esc_url( $google ) .'" class="follow-google" '.$target.'><i class="et-icon et-google-plus"></i></a>';
        }

        if( $skype ) {
            $output .= '<a href="'. esc_url( $skype ) .'" class="follow-skype" '.$target.'><i class="et-icon et-skype"></i></a>';
        }

        if( $pinterest ) {
            $output .= '<a href="'. esc_url( $pinterest ) .'" class="follow-pinterest" '.$target.'><i class="et-icon et-pinterest"></i></a>';
        }

        if( $linkedin ) {
            $output .= '<a href="'. esc_url( $linkedin ) .'" class="follow-linkedin" '.$target.'><i class="et-icon et-linkedin"></i></a>';
        }

        if( $tumblr ) {
            $output .= '<a href="'. esc_url( $tumblr ) .'" class="follow-tumblr" '.$target.'><i class="et-icon et-tumblr"></i></a>';
        }

        if( $youtube ) {
            $output .= '<a href="'. esc_url( $youtube ) .'" class="follow-youtube" '.$target.'><i class="et-icon et-youtube"></i></a>';
        }

        if( $vimeo ) {
            $output .= '<a href="'. esc_url( $vimeo ) .'" class="follow-vimeo" '.$target.'><i class="et-icon et-vimeo"></i></a>';
        }

        if( $rss ) {
            $output .= '<a href="'. esc_url( $rss ) .'" class="follow-rss" '.$target.'><i class="et-icon et-rss"></i></a>';
        }

        if( $vk ) {
            $output .= '<a href="'. esc_url( $vk ) .'" class="follow-vk" '.$target.'><i class="et-icon et-vk"></i></a>';
        }

        if( $houzz ) {
            $output .= '<a href="'. esc_url( $houzz ) .'" class="follow-houzz" '.$target.'><i class="et-icon et-houzz"></i></a>';
        }
        
        if( $tripadvisor ) {
            $output .= '<a href="'. esc_url( $tripadvisor ) .'" class="follow-tripadvisor" '.$target.'><i class="et-icon et-tripadvisor"></i></a>';
        }

        $output .= '</div>';

        if ( ! empty( $icons_bg) || ! empty( $icons_color ) || ! empty( $icons_bg_hover ) || ! empty( $icons_color_hover ) ) :

        $output .= '<style type="text/css">';
        if( ! empty( $icons_bg ) ) {
            $output .= '.follow-' . $id . ' a {';
            $output .= 'background-color:' . $icons_bg . '!important;';
            $output .= '}';
        }
        if( ! empty( $icons_color ) ) {
            $output .= '.follow-' . $id . ' a i{';
            $output .= 'color:' . $icons_color . '!important;';
            $output .= '}';
        }

        if( ! empty( $icons_bg_hover ) ) {
            $output .= '.follow-' . $id . ' a:hover {';
            $output .= 'background-color:' . $icons_bg_hover . '!important;';
            $output .= '}';
        }
        if( ! empty( $icons_color_hover ) ) {
            $output .= '.follow-' . $id . ' a:hover i {';
            $output .= 'color:' . $icons_color_hover . '!important;';
            $output .= '}';
        }
        $output .= '</style>';

        endif;

        return $output;

    }
}


// **********************************************************************//
// ! Register New Element: Social links
// **********************************************************************//
add_action( 'init', 'etheme_register_follow');
if(!function_exists('etheme_register_follow')) {
    function etheme_register_follow() {
        if(!function_exists('vc_map')) return;


        $params = array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Facebook link", 'xstore'),
                "param_name" => "facebook"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Twitter link", 'xstore'),
                "param_name" => "twitter"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Instagram link", 'xstore'),
                "param_name" => "instagram"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Google + link", 'xstore'),
                "param_name" => "google"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Pinterest link", 'xstore'),
                "param_name" => "pinterest"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("LinkedIn link", 'xstore'),
                "param_name" => "linkedin"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Tumblr link", 'xstore'),
                "param_name" => "tumblr"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("YouTube link", 'xstore'),
                "param_name" => "youtube"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Vimeo link", 'xstore'),
                "param_name" => "vimeo"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("RSS link", 'xstore'),
                "param_name" => "rss"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("VK link", 'xstore'),
                "param_name" => "vk"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Houzz link", 'xstore'),
                "param_name" => "houzz"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Tripadvisor link", 'xstore'),
                "param_name" => "tripadvisor"
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Size", 'xstore'),
                "param_name" => "size",
                "value" => array(
                    esc_html__("Normal", 'xstore') => "normal",
                    esc_html__("Small", 'xstore') => "small",
                    esc_html__("Large", 'xstore') => "large"
                ),
				"group" => "Icons styles",
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Align", 'xstore'),
                "param_name" => "align",
                "value" => array(
                    esc_html__("Center", 'xstore') => "center",
                    esc_html__("Left", 'xstore') => "left",
                    esc_html__("Right", 'xstore') => "right"
                )
            ),
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Filled icons", 'xstore'),
                "param_name" => "filled",
				"group" => "Icons styles",
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Links target", 'xstore'),
                "param_name" => "target",
                "value" => array(
                    esc_html__("Current window", 'xstore') => "_self",
                    esc_html__("Blank", 'xstore') => "_blank",
                )
            ),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => esc_html__("Icons background", 'xstore'),
				"param_name" => "icons_bg",
				"value" => "",
				"description" => "",
				"group" => "Icons styles",
                'dependency' =>  array('element' => 'filled', 'value' => 'true' ),
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => esc_html__("Icons color", 'xstore'),
				"param_name" => "icons_color",
				"value" => "",
				"description" => "",
				"group" => "Icons styles",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => esc_html__("Icons background hover", 'xstore'),
				"param_name" => "icons_bg_hover",
				"value" => "",
				"description" => "",
				"group" => "Icons styles",
                'dependency' =>  array('element' => 'filled', 'value' => 'true' ),
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => esc_html__("Icons color hover", 'xstore'),
				"param_name" => "icons_color_hover",
				"value" => "",
				"description" => "",
				"group" => "Icons styles",
			),
            array(
                'type' => 'css_editor',
                'heading' => esc_html__( 'CSS box', 'xstore' ),
                'param_name' => 'css',
                'group' => esc_html__( 'Design', 'xstore' )
            ),
        );

        $banner_params = array(
            'name' => '[8THEME] Social links',
            'base' => 'follow',
            'icon' => ETHEME_CODE_IMAGES . 'vc/el-follow.png',
            'category' => 'Eight Theme',
            'params' => $params
        );

        vc_map($banner_params);
    }
}