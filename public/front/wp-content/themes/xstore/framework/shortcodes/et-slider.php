<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************// 
// ! ETHEME Slider 
// **********************************************************************// 

if ( !function_exists('etheme_slider_shortcode') ) {
  function etheme_slider_shortcode($atts, $content) {

      extract(shortcode_atts(array(

            'height' => 'full',
            'height_value' => '',
            'stretch' => '',
            'nav' => 'arrows_bullets',
            'nav_color' => '#222',
            'arrows_bg_color' => '#e1e1e1',
            'slider_autoplay' => false,
            'slider_speed' => 300,
            'slider_loop' => 'yes',
            'slider_interval' => 5000,
            'nav_on_hover' => '',
            'transition_effect' => '',
            'bg_color' => '',
            'el_class' => '',
        ), $atts));

        $data_attr = $data_css = $style = $loader_style = '';

        $box_id = rand(1000,10000);

        if ( $slider_autoplay ) {
            $slider_autoplay = $slider_interval;
        }

        if ( $slider_loop ) {
            $data_attr .= ' data-loop="true"';
        }

        if ( $height == 'full' ) {
            $el_class .= ' full-height';
        }

        if ( !empty($nav_color) || !empty($arrows_bg_color) ) {
            $data_css = 'data-css="';
            if ( !empty($nav_color) ) {
                $data_css .= '.slider-'.$box_id.' span.swiper-pagination-bullet{background-color:'.$nav_color.';}.slider-'.$box_id.' .swiper-custom-left, .slider-'.$box_id.' .swiper-custom-right {color:'.$nav_color.';}';
            }
             if ( !empty($arrows_bg_color) ) {
                $data_css .= '.slider-'.$box_id.' .swiper-custom-left, .slider-'.$box_id.' .swiper-custom-right, .slider-'.$box_id.' .swiper-custom-left:hover, .slider-'.$box_id.' .swiper-custom-right:hover { background-color: '.$arrows_bg_color.' !important; }';
             }
            $data_css .= '"';
        }

        ob_start(); ?>

         <?php if ( !empty($height) && !empty($height_value) || !empty($bg_color) ) {
            $style = ' style="';

            if (!empty($height) && !empty($height_value)) {
                $style .= 'height:'.$height_value.';';
            }

            if (!empty($bg_color)) {
                $style .= 'background-color:'.$bg_color.';';
            }

            $style .= '"';
            }
        ?>

        <?php 
        if (!empty($bg_color)) { ?>
        <style type="text/css">
            .slider-<?php echo esc_attr($box_id); ?> .et-loader:before { background-color: <?php echo esc_attr($bg_color); ?> }
        </style>
        <?php } ?>


        <div class="swiper-entry et-slider arrows-long-path etheme-css slider-<?php echo esc_attr($box_id); ?> <?php echo esc_attr($el_class); ?> <?php if ( $nav_on_hover ) { echo 'nav-on-hover'; } ?>" <?php echo wp_specialchars_decode($data_css);?> <?php echo wp_specialchars_decode($style); ?>>
            <div class="swiper-container" data-centeredSlides="1" data-breakpoints="1" data-xs-slides="1" data-sm-slides="1" data-md-slides="1" data-lt-slides="1" data-slides-per-view="1" data-autoplay="<?php echo esc_attr($slider_autoplay); ?>" data-speed="<?php echo esc_attr($slider_speed); ?>" data-effect="<?php echo esc_attr($transition_effect); ?>" <?php echo wp_specialchars_decode($data_attr); ?>>
                <div class="et-loader swiper-lazy-preloader" <?php echo wp_specialchars_decode($loader_style); ?>>
                </div>
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                        <?php
                        etheme_override_shortcodes();
                        echo do_shortcode($content);
                        etheme_restore_shortcodes(); ?>
                </div>
                <?php if ($nav == "bullets" || $nav == 'arrows_bullets') { echo '<div class="swiper-pagination swiper-nav"></div>'; } ?>
                <?php if ($nav == "arrows" || $nav == 'arrows_bullets') { ?>
                    <div class="swiper-custom-left swiper-nav"></div>
                    <div class="swiper-custom-right swiper-nav"></div>
                <?php } ?>
            </div>
        </div>

    <?php return ob_get_clean();
  }
}

// **********************************************************************//
// ! Register New Element: Etheme slider
// **********************************************************************//
add_action( 'init', 'etheme_register_et_slider');
if(!function_exists('etheme_register_et_slider')) {
    function etheme_register_et_slider() {
        if(!function_exists('vc_map')) return;
        $params = array(
            'name' => '[8theme] Slider',
            'base' => 'etheme_slider',
            'icon' => ETHEME_CODE_IMAGES . 'vc/el-banner.png',
            'content_element' => true,
            'is_container' => true,
            'js_view' => 'VcColumnView',
            'show_settings_on_create' => true,
            'as_parent' => array(
                'only' => 'etheme_slider_item',
            ),
            'category' => 'Eight Theme',
            'params' => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Height", 'xstore'),
                    "param_name" => "height",
                    "value" => array(
                        esc_html__("Full height", 'xstore') => 'full',
                        esc_html__("Custom height", 'xstore') => 'custom',
                        esc_html__("Height of content", 'xstore') => 'auto',
                    )
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Custom height value", 'xstore'),
                    "param_name" => "height_value",
                    "dependency" => array ('element' => 'height', 'value' => 'custom')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Navigation", 'xstore'),
                    "param_name" => "nav",
                    "value" => array(
                        esc_html__("Arrows + Bullets", 'xstore') => 'arrows_bullets',
                        esc_html__("Arrows", 'xstore') => 'arrows',
                        esc_html__("Bullets", 'xstore') => 'bullets', 
                        esc_html__("Disable", 'xstore') => 'disable'           
                    )
                ),
                array (
                    "type" => "colorpicker",
                    "heading" => esc_html__("Navigation color", 'xstore'),
                    "param_name" => "nav_color",
                    "value" => '#222',
                    "dependency" => array ('element' => 'nav', 'value_not_equal_to' => 'disable'),
                    "edit_field_class" => 'vc_col-md-6 vc_column',
                ),
                array (
                    "type" => "colorpicker",
                    "heading" => esc_html__("Arrows background color", 'xstore'),
                    "param_name" => "arrows_bg_color",
                    "value" => '#e1e1e1',
                    "dependency" => array ('element' => 'nav', 'value_not_equal_to' => 'disable'),
                    "edit_field_class" => 'vc_col-md-6 vc_column',
                ),
                array (
                    "type" => "checkbox",
                    "heading" => esc_html__("Show navigation on hover", 'xstore'),
                    "param_name" => "nav_on_hover",
                    'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' ),
                    "dependency" => array ('element' => 'nav', 'value_not_equal_to' => 'disable')
                ),
                array(
                    "type" => "checkbox",
                    "heading" => esc_html__("Slider autoplay", 'xstore'),
                    "param_name" => "slider_autoplay",
                    'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' )

                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Interval", 'xstore'),
                    "param_name" => "slider_interval",
                    "description" => sprintf( esc_html__( 'Interval between slides. In milliseconds. Default: 5000', 'xstore' ) ),
                    'dependency' => array(
                        'element' => 'slider_autoplay',
                        'value' => 'yes',
                    ),
                ),
                array (
                    "type" => "checkbox",
                    "heading" => esc_html__("Slider loop", 'xstore'),
                    "param_name" => 'slider_loop',
                    'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 'yes' ),
                    'default' => 'yes'
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
                    "heading" => esc_html__("Transition speed", 'xstore'),
                    "param_name" => "slider_speed",
                    "description" => esc_html__( 'Duration of transition between slides. Default: 300', 'xstore' ),
                ),
                array (
                    "type" => "colorpicker",
                    "heading" => esc_html__("Background color", 'xstore'),
                    'description' => esc_html__('Apply for slider and loader background colors', 'xstore'),
                    "param_name" => "bg_color",
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
    class WPBakeryShortCode_Etheme_Slider extends WPBakeryShortCodesContainer {
    }
}