<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************//
// ! Scroll text
// **********************************************************************//
if ( !function_exists('etheme_scroll_text_shortcode') ) {
    function etheme_scroll_text_shortcode($atts = array(), $content) {
        extract( shortcode_atts( array(
            'height_value' => '',
            'transition_effect' => 'slide',
            'slider_interval' => 7000,
            'bg_color' => '#222',
            'color' => '#fff',
            'el_class' => '',
        ), $atts ) );

        $box_id = rand(1000,10000);

        ob_start(); ?>

        <div class="swiper-entry autoscrolling-text-wrapper <?php echo esc_attr($el_class); ?>" style="background-color:<?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($color); ?>; ">
            <div class="swiper-container stop-on-hover" data-centeredSlides="1" data-breakpoints="1" data-xs-slides="1" data-sm-slides="1" data-md-slides="1" data-lt-slides="1" data-slides-per-view="1" data-autoplay="<?php echo esc_attr($slider_interval); ?>" data-speed="1200" data-effect="<?php echo esc_attr($transition_effect); ?>" data-loop="true" <?php echo ( !empty($height_value) ) ? 'style="height:'.$height_value.'"' : ''; ?>>
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                        <?php
                        etheme_override_shortcodes();
                        echo do_shortcode($content);
                        etheme_restore_shortcodes(); ?>
                </div>
            </div>
        </div>


    <?php return ob_get_clean();
    }
}

// **********************************************************************//
// ! Register New Element: scroll text
// **********************************************************************//
add_action( 'init', 'etheme_register_scroll_text');
if(!function_exists('etheme_register_scroll_text')) {
    function etheme_register_scroll_text() {
        if(!function_exists('vc_map')) return;
        $params = array(
            'name' => '[8theme] Autoscrolling text',
            'base' => 'etheme_scroll_text',
            'icon' => ETHEME_CODE_IMAGES . 'vc/el-categories.png',
            'content_element' => true,
            'is_container' => true,
            'js_view' => 'VcColumnView',
            'show_settings_on_create' => true,
            'as_parent' => array(
                'only' => 'etheme_scroll_text_item',
            ),
            'category' => 'Eight Theme',
            'params' => array(
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Custom height value", 'xstore'),
                    'description' => esc_html__('Enter height value with dimensions for ex. 30px', 'xstore'),
                    "param_name" => "height_value",
                ),
                array (
                    "type" => "dropdown",
                    "heading" => esc_html__("Transition style", 'xstore'),
                    "param_name" => "transition_effect",
                    "value" => array(
                        esc_html__("Slide", 'xstore') => 'slide',
                        esc_html__("Fade", 'xstore') => 'fade',
                        esc_html__("Cube", 'xstore') => 'cube',
                        esc_html__("Coverflow", 'xstore') => 'coverflow',
                        esc_html__("Flip", 'xstore') => 'flip',
                    )
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Autoplay speed", 'xstore'),
                    "param_name" => "slider_interval",
                    "group" => esc_html__('Slider settings', 'xstore'),
                    "description" => sprintf( esc_html__( 'Interval between slides. In milliseconds. Default: 7000', 'xstore' ) ),
                ),
                array (
                    "type" => 'colorpicker',
                    "heading" => esc_html__('Background color', 'xstore'),
                    "param_name" => 'bg_color',
                    'group' => esc_html__('Design', 'xstore'),
                    "value" => '#222',
                ),
                array (
                    "type" => 'colorpicker',
                    "heading" => esc_html__('Color', 'xstore'),
                    "param_name" => 'color',
                    'group' => esc_html__('Design', 'xstore'),
                    "value" => '#ffffff',
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Extra Class", 'xstore'),
                    "param_name" => "el_class"
                ),
            ),
        );

        vc_map($params);
    }
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Etheme_scroll_text extends WPBakeryShortCodesContainer {
    }
}
