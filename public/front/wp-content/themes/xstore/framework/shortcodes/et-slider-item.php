<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************// 
// ! Banner With mask
// **********************************************************************// 
if ( ! function_exists('etheme_slider_item_shortcode') ) {
	function etheme_slider_item_shortcode($atts, $content) {
	    

	    $onclick = $button_onclick = $button_class = $custom_class = $output = $img =  $description_attr = $button_attr = '';

		if( empty( $atts['subtitle_google_fonts'] ) ) {
			$atts['subtitle_google_fonts'] = 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal';
		}

		if( empty( $atts['title_google_fonts'] ) ) {
			$atts['title_google_fonts'] = 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal';
		}

		if ( empty($atts['title_font_container']) ) {
			$atts['title_font_container'] = '';
		}

		if ( empty($atts['subtitle_font_container']) ) {
			$atts['subtitle_font_container'] = '';
		}

	    extract(shortcode_atts(array(
	        'align'  => 'left',
	        'valign'  => 'top',
	        'class'  => '',
	        'link'  => '',
	        'hover'  => '',
			'title'  => '',
			'subtitle'  => '',
			'subtitle_above' => '',

			// classes 
			'title_class' => '',
			'subtitle_class' => '',
			'el_class' => '',

			// animations 

			'title_animation_duration' => '500',
			'subtitle_animation_duration' => '500',
			'description_animation_duration' => '500',
			'button_animation_duration' => '500',

			'description_animation' => '',
			'button_animation' => '',

			'title_animation_delay' => '0',
			'subtitle_animation_delay' => '0',
			'description_animation_delay' => '0',
			'button_animation_delay' => '0',
			'content_width' => '',
			// Aligns 

			'align' => 'start',
			'v_align' => 'start',
			'text_align' => '',

			// Title options 
			'size' => '',
			'spacing' => '',
			'line_height' => '',
			'color' => '',

			// Subtitle options 
			'subtitle_size' => '',
			'subtitle_spacing' => '',
			'subtitle_line_height' => '',
			'subtitle_color' => '',

			// Button 

	        'button_link' => '',
	        'button_font_size' => '12px',
	        'button_border_radius' => '',
			'button_color' => '',
			'button_hover_color' => '',
			'button_bg' => '',
			'button_hover_bg' => '',
			'button_paddings' => '7px 15px',
			'button_margins' => '',

			// Background 
			'bg_img' => '',
			'background_position' => '',
			'content_bg_position' => '',
			'bg_pos_x' => '50',
			'bg_pos_y' => '50',
			'background_repeat' => '',
			'bg_size' => 'cover',
			'bg_color' => '',
			'bg_overlay' => '',

			'css' => ''
	    ), $atts));

		if( $bg_img > 0 && !empty($background_position) && $background_position != 'custom' ) {
			$el_class .= ' et-parallax et-parallax-' . $background_position;
		}

	    if ( $bg_img > 0 ) {
			$img = wp_get_attachment_image_src($bg_img, 'full');
	    }

	    // Button link 

		$button_link = ( '||' === $button_link ) ? '' : $button_link;
		$button_link = vc_build_link( $button_link );
		$use_link = false;
		if ( strlen( $button_link['url'] ) > 0 ) {
			$use_link = true;
			$a_href = $button_link['url'];
			//$a_title = $link['title'];
			$a_target = strlen( $button_link['target'] ) > 0 ? $button_link['target'] : '_self';
		}

	    if( $use_link ) {
	        $button_class = ' cursor-pointer';
	        if( strpos( $a_target, 'blank' ) ) {
	        	$button_onclick = 'onclick="window.open(\''. esc_url( $a_href ).'\',\'_blank\')"';
	        } else {
	        	$button_onclick = 'onclick="window.location=\''. esc_url( $a_href ).'\'"';
	        }
	    }

		//parse link

	    if( $link && $use_link ) {
	        $el_class .= ' cursor-pointer';
	        if( strpos( $a_target, 'blank' ) ) {
	        	$onclick = 'onclick="window.open(\''. esc_url( $a_href ).'\',\'_blank\')"';
	        } else {
	        	$onclick = 'onclick="window.location=\''. esc_url( $a_href ).'\'"';
	        }
	    }

	    $id = rand(1000,9999);

	    $box_id = 'slider-item-' . $id;
	    $box_class = '.'.$box_id;

	    $align_class = (!empty($align)) ? ' justify-content-'.$align : '';
		$align_class .= (!empty($v_align)) ? ' align-items-'.$v_align : '';

	    $el_class .= ' etheme-css';

	    // Data css

	    $data_css = 'data-css="';

	    if ( !empty($content_width) ) {
	    	$data_css .= $box_class . ' .slide-content { flex-basis: '.$content_width.'%;}';
	    }

	    if( $bg_img > 0 && $background_position == 'custom' ) {
	    	$data_css .= $box_class . '{ background-position:'.$bg_pos_x.'% '.$bg_pos_y.'%}';
	    }

	    if ( (is_array($img) && count($img) > 0) || !empty($bg_color) ) {
	    	$data_css .= $box_class . '{';
	    	if ( is_array($img) && count($img) > 0 ) {
	    		if ( !empty($bg_size) ) {
	    			$data_css .= 'background-size:'.$bg_size.';';
	    		}
	    	}
	    	if ( !empty($bg_color) ) {
	    		$data_css .= 'background-color:'.$bg_color.';';
	    	}
	    	$data_css .= '}';
	    }

	    if ( !empty($bg_overlay) ) {
	    	$data_css .= $box_class.' .bg-overlay {background-color:'.$bg_overlay.';}';
	    }

	   	// title, subtitle styles 

    	if ( !empty($color) ) {
    		$atts['title_font_container'] = $atts['title_font_container'].'|color:'.$color;
    	}
    	if ( !empty($spacing) ) {
    		$atts['title_font_container'] = $atts['title_font_container'].'|letter_spacing:'.$spacing;
    	}
    	if ( !empty($size) ) {
    		$atts['title_font_container'] = $atts['title_font_container'].'|font_size:'.$size;
    	}
    	if ( !empty($line_height) ) {
    		$atts['title_font_container'] = $atts['title_font_container'].'|line_height:'.$line_height;
    	}
    	$atts['title_font_container'] = $atts['title_font_container'].'|animation_duration:'.$title_animation_duration.'ms|animation_delay:'.$title_animation_delay.'ms';

    	if ( !empty($subtitle_color) ) {
    		$atts['subtitle_font_container'] = $atts['subtitle_font_container'].'|color:'.$subtitle_color;
    	}
    	if ( !empty($subtitle_spacing) ) {
    		$atts['subtitle_font_container'] = $atts['subtitle_font_container'].'|letter_spacing:'.$subtitle_spacing;
    	}
    	if ( !empty($subtitle_size) ) {
    		$atts['subtitle_font_container'] = $atts['subtitle_font_container'].'|font_size:'.$subtitle_size;
    	}
    	if ( !empty($subtitle_line_height) ) {
    		$atts['subtitle_font_container'] = $atts['subtitle_font_container'].'|line_height:'.$subtitle_line_height;
    	}
    	$atts['subtitle_font_container'] = $atts['subtitle_font_container'].'|animation_duration:'.$subtitle_animation_duration.'ms|animation_delay:'.$subtitle_animation_delay.'ms';


    	// description, button styles
	   	if ( !empty($description_animation) ) {
	    	$description_attr = ' style="animation-duration:'.$description_animation_duration.'ms;animation-delay:'.$description_animation_delay.'ms;"';
	   	}

	   	if ( !empty($button_animation) ) {
	    	$button_attr = ' style="animation-duration:'.$button_animation_duration.'ms;animation-delay:'.$button_animation_delay.'ms;"';
	   	}

	    if ( strlen( $button_link['title'] ) > 0 && ( !empty($button_color) || !empty($button_bg) || !empty($button_hover_bg) || $button_hover_color) || !empty($button_paddings) || !empty($button_margins) || !empty($button_font_size) || !empty($button_border_radius) ) {
	    	$data_css .= $box_class . ' .slide-button {';
	    	if ( !empty($button_color) ) {
	    		$data_css .= 'color:'.$button_color.';';
	    	}
	    	if ( !empty($button_bg) ) {
	    		$data_css .= 'background-color:'.$button_bg.';';
	    	}
	    	if ( !empty($button_paddings) ) {
	    		$data_css .= 'padding:'.$button_paddings.';';
	    	}
	    	if ( !empty($button_margins) ) {
	    		$data_css .= 'margin:'.$button_margins.';';
	    	}

	    	if ( !empty($button_font_size) ) {
	    		$data_css .= 'font-size:'.$button_font_size.';';
	    	}

	    	if ( !empty($button_border_radius) ) {
	    		$data_css .= 'border-radius: ' . $button_border_radius.';';
	    	}

	    	$data_css .= '}';
	    	if ( !empty($button_hover_bg ) || !empty($button_hover_color)) {
	    		$data_css .= $box_class . ' .slide-button:hover {';
	    		if ( !empty($button_hover_bg ) ) {
		    		$data_css .= 'background-color:'.$button_hover_bg.';';
		    	}
		    	if ( !empty($button_hover_color ) ) {
		    		$data_css .= 'color:'.$button_hover_color.';';
		    	}
		    	$data_css .= '}';
	    	}
	    }

 	    $data_css .= '"';

 	    if ( !empty($text_align) ) {
 	    	$custom_class .= 'text-'.$text_align.' ';
 	    }

 	    if ( !empty($content_bg_position) ) {
 	    	$custom_class .= 'et-parallax et-parallax-' . $content_bg_position;
 	    }

		if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
			$custom_class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

	    if ( !empty($button_animation) ) {
			$button_animation .= ' animated';
		}

		if ( !empty($description_animation) ) {
			$description_animation .= ' animated';
		}

		$data_attr = 'style="';

		if ( is_array($img) && count($img) > 0 ) {
			// $el_class .= ' swiper-bg-image-lazy';
	    	$data_attr .= ' background-image: url('.$img[0].');';
	    }
	    if ( !empty($background_repeat) ) {
	    	$data_attr .= 'background-repeat:'.$background_repeat.';';
	    }

	    $data_attr .= '"';

	    $output .= '<div class="slider-item fadeIn-slide '.$box_id.' '. esc_attr( $el_class ). '" '. $onclick . ' ' . $data_css.' '. $data_attr.' data-slide-id='.$id.'>';
	    if ( !empty($bg_overlay) ) {
	    	$output .= '<div class="bg-overlay"></div>';
	    }

	    $output .= '<div class="container '.$align_class.'">';

    	$output .= '<div class="slide-content '.esc_attr($custom_class).'" >';

    		if ( $subtitle_above ) {
    			if( ! empty( $subtitle ) ) {
					$output .= etheme_getHeading('subtitle', $atts, 'slide-subtitle no-uppercase'. $subtitle_class);
				}
    		}

			if( ! empty( $title ) ) {
				$output .= etheme_getHeading('title', $atts, 'slide-title no-uppercase'. $title_class);
			}
			if ( !$subtitle_above ) {
				if( ! empty( $subtitle ) ) {
					$output .= etheme_getHeading('subtitle', $atts, 'slide-subtitle no-uppercase'. $subtitle_class);
				}
			}
		    $output .= '<div class="description wpb_animate_when_almost_visible '.$description_animation.' " '.$description_attr.'>' . do_shortcode($content) . '</div>';

		    if ( strlen( $button_link['title'] ) > 0 ) {
		    	$output .= '<div class="slide-button wpb_animate_when_almost_visible '.$button_class.' ' .$button_animation. '"'. $button_onclick. ' '. $button_attr. '>';
		    	$output .= $button_link['title'];
		    	$output .= '</div>';
		    }

		$output .= '</div>'; // end slide content

		$output .= '</div>'; // end container 
	    $output .= '</div>'; // end slider item 
	    
	    return $output;
	}
}

// **********************************************************************// 
// ! Register New Element: Etheme slider item 
// **********************************************************************//
add_action( 'init', 'etheme_register_et_slider_item');
if(!function_exists('etheme_register_et_slider_item')) {
	function etheme_register_et_slider_item() {
		if(!function_exists('vc_map')) return;
		require_once vc_path_dir( 'CONFIG_DIR', 'content/vc-custom-heading-element.php' );

		$title_custom_heading = vc_map_integrate_shortcode( vc_custom_heading_element_params(), 'title_', esc_html__( 'Title font', 'xstore' ), array(
			'exclude' => array(
				'vc_link',
				'source',
				'text',
				'css',
				'el_class',
				'el_id',
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

		$subtitle_custom_heading = vc_map_integrate_shortcode( vc_custom_heading_element_params(), 'subtitle_', esc_html__( 'Subtitle font', 'xstore' ), array(
			'exclude' => array(
				'source',
				'vc_link',
				'text',
				'css',
				'el_class',
				'el_id',
			),
		), array(
			'element' => 'use_custom_fonts_subtitle',
			'value' =>'true',
		) );

		// This is needed to remove custom heading _tag and _align options.
		if ( is_array( $subtitle_custom_heading ) && ! empty( $subtitle_custom_heading ) ) {
	      foreach ( $subtitle_custom_heading as $key => $param ) {
	        if ( is_array( $param ) && isset( $param['type'] ) && 'font_container' === $param['type'] ) {
	          $subtitle_custom_heading[ $key ]['value'] = '';
	          if ( isset( $param['settings'] ) && is_array( $param['settings'] ) && isset( $param['settings']['fields'] ) ) {
	            $sub_key = array_search( 'text_align', $param['settings']['fields'] );
	            if ( false !== $sub_key ) {
	              unset( $subtitle_custom_heading[ $key ]['settings']['fields'][ $sub_key ] );
	            } elseif ( isset( $param['settings']['fields']['text_align'] ) ) {
	              unset( $subtitle_custom_heading[ $key ]['settings']['fields']['text_align'] );
	            }
	            $sub_key = array_search( 'font_size', $param['settings']['fields'] );
	            if ( false !== $sub_key ) {
	              unset( $subtitle_custom_heading[ $key ]['settings']['fields'][ $sub_key ] );
	            } elseif ( isset( $param['settings']['fields']['font_size'] ) ) {
	              unset( $subtitle_custom_heading[ $key ]['settings']['fields']['font_size'] );
	            }
	            $sub_key = array_search( 'line_height', $param['settings']['fields'] );
	            if ( false !== $sub_key ) {
	              unset( $subtitle_custom_heading[ $key ]['settings']['fields'][ $sub_key ] );
	            } elseif ( isset( $param['settings']['fields']['line_height'] ) ) {
	              unset( $subtitle_custom_heading[ $key ]['settings']['fields']['line_height'] );
	            }
	            $sub_key = array_search( 'color', $param['settings']['fields'] );
	            if ( false !== $sub_key ) {
	              unset( $subtitle_custom_heading[ $key ]['settings']['fields'][ $sub_key ] );
	            } elseif ( isset( $param['settings']['fields']['color'] ) ) {
	              unset( $subtitle_custom_heading[ $key ]['settings']['fields']['color'] );
	            }
	          }
	        }
	      }
	    }

		$params = array_merge(
		 array(
			array(
				"type" => "textfield",
				"heading" => "Title",
				"param_name" => "title",
				'edit_field_class' => 'vc_col-sm-9 vc_column',
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Use custom font?', 'xstore' ),
				'param_name' => 'use_custom_fonts_title',
				'description' => esc_html__( 'Enable Google fonts.', 'xstore' ),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
			),
			array(
				"type" => "textfield",
				"heading" => "Subtitle",
				"param_name" => "subtitle",
				'edit_field_class' => 'vc_col-sm-9 vc_column',
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Use custom font?', 'xstore' ),
				'param_name' => 'use_custom_fonts_subtitle',
				'description' => esc_html__( 'Enable custom font option.', 'xstore' ),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Show subtitle above title ?', 'xstore' ),
				'param_name' => 'subtitle_above',
			),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"heading" => "Description",
				"param_name" => "content",
				"value" => "Some promo words"
			),

			array (
				"type" => 'dropdown',
				"heading" => esc_html__("Description animation" , 'xstore'),
				"param_name" => 'description_animation',
				"value" => array (
					esc_html__("None", 'xstore') => 'none',
					esc_html__("FadeIn", 'xstore') => 'fadeIn',
					esc_html__("FadeInDown", 'xstore') => 'fadeInDown',
					esc_html__("FadeInUp", 'xstore') => 'fadeInUp',
					esc_html__("FadeInRight", 'xstore') => 'fadeInRight',
					esc_html__("FadeInLeft", 'xstore') => 'fadeInLeft',
					esc_html__("Zoom in", 'xstore' ) => 'zoomIn',
					esc_html__("SlideInDown", 'xstore') => 'slideInDown',
					esc_html__("SlideInUp", 'xstore') => 'slideInUp',
					esc_html__("SlideInRight", 'xstore') => 'slideInRight',
					esc_html__("SlideInLeft", 'xstore') => 'slideInLeft',
					esc_html__("Top to bottom", 'xstore') => 'top-to-bottom',
					esc_html__("Bottom to top", 'xstore') => 'bottom-to-top',
					esc_html__("Left to right", 'xstore') => 'left-to-right',
					esc_html__("Right to left", 'xstore') => 'right-to-left',
				)
			),
			array (
		 		'type' => 'textfield',
		 		'heading' => esc_html__('Description animation duration', 'xstore'),
		 		'param_name' => 'description_animation_duration',
		 		'description' => esc_html__('Default 500. Write number in ms','xstore'),
		 		'edit_field_class' => 'vc_col-md-6 vc_column',
		 		'dependency' => array ('element' => 'description_animation', 'value_not_equal_to' => 'none')
		 	),
		 	array (
		 		'type' => 'textfield',
		 		'heading' => esc_html__('Description animation delay', 'xstore'),
		 		'param_name' => 'description_animation_delay',
		 		'description' => esc_html__('Write number in ms','xstore'),
		 		'edit_field_class' => 'vc_col-md-6 vc_column',
		 		'dependency' => array ('element' => 'description_animation', 'value_not_equal_to' => 'none')
		 	),
			array(
				"type" => "vc_link",
				"heading" => esc_html__("Button link", 'xstore'),
				"param_name" => "button_link",
				"edit_field_class" => "vc_col-md-9 vc_column",
			),
			array(
				"type" => "checkbox",
				"heading" => esc_html__("Link for all slide", 'xstore'),
				"param_name" => "link",
				'edit_field_class' => 'vc_col-md-3 vc_column',
			),

			array (
				'type' => 'dropdown',
				'heading' => esc_html__('Content width', 'xstore'),
				'param_name' => 'content_width',
				'value' => array ("",
					esc_html__( '100%', 'xstore' ) => '100',
					esc_html__( '90%', 'xstore' ) => '90',
					esc_html__( '80%', 'xstore' ) => '80',
					esc_html__( '70%', 'xstore' ) => '70',
					esc_html__( '60%', 'xstore' ) => '60',
					esc_html__( '50%', 'xstore' ) => '50',
					esc_html__( '40%', 'xstore' ) => '40',
					esc_html__( '30%', 'xstore' ) => '30',
					esc_html__( '20%', 'xstore' ) => '20',
					esc_html__( '10%', 'xstore' ) => '10',
				)
			),

			array (
	        	'type' => 'dropdown',
	        	'heading' => esc_html__( 'Horizontal align', 'xstore' ),
	        	'param_name' => 'align',
	        	'value' => array (
	        		esc_html__( 'Left', 'xstore' ) => 'start',
	        		esc_html__( 'Right', 'xstore' ) => 'end',
	        		esc_html__( 'Center', 'xstore' ) => 'center',
	        		esc_html__( 'Stretch', 'xstore' ) => 'between',
	        		esc_html__( 'Stretch (no paddings)', 'xstore' ) => 'around',
	        	),
	        	'edit_field_class' => 'vc_col-md-4 vc_column',
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
	        	'edit_field_class' => 'vc_col-md-4 vc_column',
	        ),
	        array(
	        	'type' => 'dropdown',
	        	'heading' => esc_html__( 'Text align', 'xstore' ),
	        	'param_name' => 'text_align',
	        	'value' => array(
	        		esc_html__('Left', 'xstore') => 'left',
					esc_html__('Right', 'xstore') => 'right',
					esc_html__('Center', 'xstore') => 'center',
					esc_html__('Justify', 'xstore') => 'justify'
	        	),
	        	'edit_field_class' => 'vc_col-md-4 vc_column',
	        ),
			array(
				"type" => "attach_image",
				"heading" => esc_html__("Background image", 'xstore'),
				"param_name" => "bg_img",
				"group" => "Background",
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Background size", 'xstore' ),
				"param_name" => "bg_size",
				"value" => array (
					esc_html__("Cover", 'xstore') => 'cover',
					esc_html__("Contain", 'xstore') => 'contain',
					esc_html__("Auto", 'xstore') => 'auto',
				),
				"group" => "Background",
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Background position", 'xstore'),
				"param_name" => "background_position",
				"group" => esc_html__('Background', 'xstore'),
				"value" => array(
					'' => '',
					esc_html__("Left top", 'xstore') => 'left_top',
					esc_html__("Left center", 'xstore') => 'left',
					esc_html__("Left bottom", 'xstore') => 'left_bottom',
					esc_html__("Right top", 'xstore') => 'right_top',
					esc_html__("Right center", 'xstore') => 'right',
					esc_html__("Right bottom", 'xstore') => 'right_bottom',
					esc_html__("Center top", 'xstore') => 'center_top',
					esc_html__("Center center", 'xstore') => 'center',
					esc_html__("Center bottom", 'xstore') => 'center_bottom',
					esc_html__("(x% y%)", 'xstore') => 'custom',
				)
			),
			array (
				"type" => 'textfield',
				"heading" => esc_html__("Axis X", 'xstore'),
				"param_name" => "bg_pos_x",
				"group" => esc_html__('Background', 'xstore'),
				'edit_field_class' => 'vc_col-md-6 vc_column',
				'description' => esc_html__("Use this field to add background position by X axis. For example 50", 'xstore'),
				"dependency" => array ("element" => 'background_position', 'value' => 'custom')
			),
			array (
				"type" => 'textfield',
				"heading" => esc_html__("Axis Y", 'xstore'),
				"param_name" => "bg_pos_y",
				"group" => esc_html__('Background', 'xstore'),
				'edit_field_class' => 'vc_col-md-6 vc_column',
				'description' => esc_html__("Use this field to add background position by Y axis. For example 50", 'xstore'),
				"dependency" => array ("element" => 'background_position', 'value' => 'custom')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Background repeat", 'xstore'),
				"param_name" => "background_repeat",
				"group" => esc_html__('Background', 'xstore'),
				"value" => array(
					esc_html__("Unset", 'xstore') => '',
					esc_html__("No repeat", 'xstore') => 'no-repeat',
					esc_html__("Repeat", 'xstore') => 'repeat',
					esc_html__("Repeat x", 'xstore') => 'repeat-x',
					esc_html__("Repeat y", 'xstore') => 'repeat-y',
					esc_html__("Round", 'xstore') => 'round',
					esc_html__("Space", 'xstore') => 'space',
				)
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Background Color", 'xstore'),
				"param_name" => "bg_color",
				"group" => "Background",
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__("Background Overlay", 'xstore'),
				"param_name" => "bg_overlay",
				"group" => "Background",
			),

			array (
				"type" => 'colorpicker',
				"heading" => esc_html__("Button text color", 'xstore'),
				"param_name" => "button_color",
				"group" => esc_html__("Button", 'xstore'),
				'edit_field_class' => 'vc_col-md-6 vc_column',
			),
			array (
				"type" => 'colorpicker',
				"heading" => esc_html__("Button text color (hover)", 'xstore'),
				"param_name" => "button_hover_color",
				"group" => esc_html__("Button", 'xstore'),
				'edit_field_class' => 'vc_col-md-6 vc_column',
			),

			array (
				"type" => 'colorpicker',
				"heading" => esc_html__("Button background color", 'xstore'),
				"param_name" => "button_bg",
				"group" => esc_html__("Button", 'xstore'),
				'edit_field_class' => 'vc_col-md-6 vc_column',
			),
			array (
				"type" => 'colorpicker',
				"heading" => esc_html__("Button background color (hover)", 'xstore'),
				"param_name" => "button_hover_bg",
				"group" => esc_html__("Button", 'xstore'),
				'edit_field_class' => 'vc_col-md-6 vc_column',
			),
			array (
				"type" => 'textfield',
				"heading" => esc_html__("Button font size", 'xstore'),
				"param_name" => "button_font_size",
				"group" => esc_html__("Button", 'xstore'),
				"description" => esc_html__('Use this field to add element font size. For example 20px', 'xstore'),
				'edit_field_class' => 'vc_col-md-6 vc_column',
			),
			array (
				"type" => 'textfield',
				"heading" => esc_html__("Button border radius", 'xstore'),
				"param_name" => "button_border_radius",
				"group" => esc_html__("Button", 'xstore'),
				"description" => esc_html__('Use this field to add element border radius. For example 3px 7px', 'xstore'),
				'edit_field_class' => 'vc_col-md-6 vc_column',
			),
			array (
				"type" => 'textfield',
				"heading" => esc_html__("Button paddings (top right bottom left)", 'xstore'),
				"param_name" => "button_paddings",
				"group" => esc_html__("Button", 'xstore'),
				"description" => esc_html__('Use this field to add element margin. For example 10px 20px 30px 40px', 'xstore'),
				'edit_field_class' => 'vc_col-md-6 vc_column',
			),
			array (
				"type" => 'textfield',
				"heading" => esc_html__("Button margins (top right bottom left)", 'xstore'),
				"param_name" => "button_margins",
				"group" => esc_html__("Button", 'xstore'),
				"description" => esc_html__('Use this field to add element margin. For example 10px 20px 30px 40px', 'xstore'),
				'edit_field_class' => 'vc_col-md-6 vc_column',
			),
			array (
				"type" => 'dropdown',
				"heading" => esc_html__("Button animation" , 'xstore'),
				"group" => esc_html__("Button", 'xstore'),
				"param_name" => 'button_animation',
				"value" => array (
					esc_html__("None", 'xstore') => 'none',
					esc_html__("FadeIn", 'xstore') => 'fadeIn',
					esc_html__("FadeInDown", 'xstore') => 'fadeInDown',
					esc_html__("FadeInUp", 'xstore') => 'fadeInUp',
					esc_html__("FadeInRight", 'xstore') => 'fadeInRight',
					esc_html__("FadeInLeft", 'xstore') => 'fadeInLeft',
					esc_html__("SlideInDown", 'xstore') => 'slideInDown',
					esc_html__("SlideInUp", 'xstore') => 'slideInUp',
					esc_html__("SlideInRight", 'xstore') => 'slideInRight',
					esc_html__("SlideInLeft", 'xstore') => 'slideInLeft',
					esc_html__("Top to bottom", 'xstore') => 'top-to-bottom',
					esc_html__("Bottom to top", 'xstore') => 'bottom-to-top',
					esc_html__("Left to right", 'xstore') => 'left-to-right',
					esc_html__("Right to left", 'xstore') => 'right-to-left',
				)
			),

			array (
		 		'type' => 'textfield',
		 		'heading' => esc_html__('Animation duration', 'xstore'),
		 		"group" => esc_html__("Button", 'xstore'),
		 		'param_name' => 'button_animation_duration',
		 		'description' => esc_html__('Default 500. Write number in ms','xstore'),
		 		'edit_field_class' => 'vc_col-md-6 vc_column',
		 		'dependency' => array ('element' => 'button_animation', 'value_not_equal_to' => 'none')
		 	),
		 	array (
		 		'type' => 'textfield',
		 		'heading' => esc_html__('Animation delay', 'xstore'),
		 		"group" => esc_html__("Button", 'xstore'),
		 		'param_name' => 'button_animation_delay',
		 		'description' => esc_html__('Write number in ms','xstore'),
		 		'edit_field_class' => 'vc_col-md-6 vc_column',
		 		'dependency' => array ('element' => 'button_animation', 'value_not_equal_to' => 'none')
		 	),

			array(
				"type" => "textfield",
				"heading" => esc_html__("Extra Class", 'xstore'),
				"param_name" => "el_class",
				"description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'xstore')
			),
		  	array(
			  'type' => 'css_editor',
			  'heading' => esc_html__( 'CSS box', 'xstore' ),
			  'param_name' => 'css',
			  'group' => esc_html__( 'Design for slide content', 'xstore' )
		  	),
		  	array(
				"type" => "dropdown",
				"heading" => esc_html__("Background position", 'xstore'),
				"param_name" => "content_bg_position",
				"group" => esc_html__( 'Design for slide content', 'xstore' ),
				"value" => array(
					__("Inherit from slide settings", 'xstore') => '',
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
			),
			array(
	     		'type' => 'textfield',
	     		'heading' => __('Font size', 'xstore'),
				'param_name' => 'size',
				'group' => esc_html__( 'Title font', 'xstore' ),
				'description' => esc_html__('Write font size for element with dimentions. Example 14px, 15em, 20%', 'xstore'),
				'dependency' => array( 'element' => 'use_custom_fonts_title', 'value' =>'true' )
	     	),
	     	array(
	     		'type' => 'textfield',
	     		'heading' => __('Letter spacing', 'xstore'),
				'param_name' => 'spacing',
				'group' => esc_html__( 'Title font', 'xstore' ),
				'description' => esc_html__('Write letter spacing for element with dimentions. Example 2px, 0.2em', 'xstore'),
				'dependency' => array( 'element' => 'use_custom_fonts_title', 'value' =>'true' )
	     	),
	     	array(
	     		'type' => 'textfield',
	     		'heading' => __('Line height', 'xstore'),
				'param_name' => 'line_height',
				'group' => esc_html__( 'Title font', 'xstore' ),
				'description' => esc_html__('Write line height for element with dimentions or without. Example 14px, 15em, 2', 'xstore'),
				'dependency' => array( 'element' => 'use_custom_fonts_title', 'value' =>'true' )
	     	),
	     	array(
	     		'type' => 'colorpicker',
	     		'heading' => __('Color', 'xstore'),
				'param_name' => 'color',
				'group' => esc_html__( 'Title font', 'xstore' ),
				'dependency' => array( 'element' => 'use_custom_fonts_title', 'value' =>'true' )
	     	),
		  ),
		$title_custom_heading,
		array(
			array(
				'type' => 'textfield',
				'heading' => __('Animation duration', 'xstore'),
				'param_name' => 'title_animation_duration',
				'description' => esc_html__('Default 500ms. Write number in ms','xstore'),
				'group' => esc_html__( 'Title font', 'xstore' ),
				'edit_field_class' => 'vc_col-md-6 vc_column',
				'dependency' => array( 'element' => 'use_custom_fonts_title', 'value' =>'true' )
			),
			array (
		 		'type' => 'textfield',
		 		'heading' => esc_html__('Animation delay', 'xstore'),
		 		'group' => esc_html__( 'Title font', 'xstore' ),
		 		'param_name' => 'title_animation_delay',
		 		'description' => esc_html__('Write number in ms','xstore'),
		 		'edit_field_class' => 'vc_col-md-6 vc_column',
		 		'dependency' => array( 'element' => 'use_custom_fonts_title', 'value' =>'true' )
		 	),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Extra Class", 'xstore'),
				"param_name" => "title_class",
				'group' => esc_html__( 'Title font', 'xstore' ),
				"description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'xstore'),
				'dependency' => array( 'element' => 'use_custom_fonts_title', 'value' =>'true' )
			),

			array(
	     		'type' => 'textfield',
	     		'heading' => __('Font size', 'xstore'),
				'param_name' => 'subtitle_size',
				'group' => esc_html__( 'Subtitle font', 'xstore' ),
				'description' => esc_html__('Write font size for element with dimentions. Example 14px, 15em, 20%', 'xstore'),
				'dependency' => array( 'element' => 'use_custom_fonts_subtitle', 'value' =>'true' )
	     	),
	     	array(
	     		'type' => 'textfield',
	     		'heading' => __('Letter spacing', 'xstore'),
				'param_name' => 'subtitle_spacing',
				'group' => esc_html__( 'Subtitle font', 'xstore' ),
				'description' => esc_html__('Write letter spacing for element with dimentions. Example 2px, 0.2em', 'xstore'),
				'dependency' => array( 'element' => 'use_custom_fonts_subtitle', 'value' =>'true' )
	     	),
	     	array(
	     		'type' => 'textfield',
	     		'heading' => __('Line height', 'xstore'),
				'param_name' => 'subtitle_line_height',
				'group' => esc_html__( 'Subtitle font', 'xstore' ),
				'description' => esc_html__('Write line height for element with dimentions or without. Example 14px, 15em, 2', 'xstore'),
				'dependency' => array( 'element' => 'use_custom_fonts_subtitle', 'value' =>'true' )
	     	),
	     	array(
	     		'type' => 'colorpicker',
	     		'heading' => __('Color', 'xstore'),
				'param_name' => 'subtitle_color',
				'group' => esc_html__( 'Subtitle font', 'xstore' ),
				'dependency' => array( 'element' => 'use_custom_fonts_subtitle', 'value' =>'true' )
	     	),
	     ),
		$subtitle_custom_heading,
		array(
			array(
				'type' => 'textfield',
				'heading' => __('Animation duration', 'xstore'),
				'param_name' => 'subtitle_animation_duration',
				'description' => esc_html__('Default 500ms. Write number in ms','xstore'),
				'group' => esc_html__( 'Subtitle font', 'xstore' ),
				'edit_field_class' => 'vc_col-md-6 vc_column',
				'dependency' => array( 'element' => 'use_custom_fonts_subtitle', 'value' =>'true' )
			),
			array (
		 		'type' => 'textfield',
		 		'heading' => esc_html__('Animation delay', 'xstore'),
		 		'group' => esc_html__( 'Subtitle font', 'xstore' ),
		 		'param_name' => 'subtitle_animation_delay',
		 		'description' => esc_html__('Write number in ms','xstore'),
		 		'edit_field_class' => 'vc_col-md-6 vc_column',
		 		'dependency' => array( 'element' => 'use_custom_fonts_subtitle', 'value' =>'true' )
		 	),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Extra Class", 'xstore'),
				"param_name" => "subtitle_class",
				"description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'xstore'),
				'group' => esc_html__( 'Subtitle font', 'xstore' ),
				'dependency' => array( 'element' => 'use_custom_fonts_subtitle', 'value' =>'true' )
			),
		) );

	    $slider_item_params = array(
	      'name' => '[8THEME] Slider item',
	      'base' => 'etheme_slider_item',
	      'category' => 'Eight Theme',
	      'content_element' => true,
	        'icon' => ETHEME_CODE_IMAGES . 'vc/el-banner.png',
	        'as_child' => array('only' => 'etheme_slider'),            
	        'is_container' => false,
	      'params' => $params
	    );
	
	    vc_map($slider_item_params);
	}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_ETHEME_Slider_item extends WPBakeryShortCode {
    }
}
