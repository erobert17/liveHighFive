<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************// 
// ! team_member
// **********************************************************************// 
if ( !function_exists('etheme_team_member_shortcode') ) {
	function etheme_team_member_shortcode($atts, $content = null) {
	    $a = shortcode_atts(array(
	        'class' => '',
	        'type' => 1,
	        'name' => '',
	        'email' => '',
	        
	        // socials 
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

	        'position' => '',
	        'content_position' => 'top',
	        'img_position' => 'left',
	        'content' => '',
	        'img' => '',
	        'img_size' => '270x170'
	    ), $atts);

		$img = intval( $a['img'] );

		$image = etheme_get_image($img, $a['img_size']);

		if ( !empty($a['content'])) $content = $a['content'];
	    
	    $html = '';
	    $span = 12;
	    $html .= '<div class="team-member member-type-'.$a['type'].' '.$a['class'].' content-position-' . $a['content_position'] . ' image-position-' . $a['img_position'] . '">';

	        if($a['type'] == 2) {
	            $html .= '<div class="row">';
	        }
		    if( ! empty( $image ) ){

	            if($a['type'] == 2) {
	                $html .= '<div class="image-section col-md-6">';
	                $span = 6;
	            }
	            $html .= '<div class="member-image">';
	                $html .= $image;
		                $html .= '<div class="member-content">';
		                    $html .= do_shortcode('[follow size="'.$a['size'].'" align="'.$a['align'].'" target="'. $a['target'] .'" facebook="'.$a['facebook'].'" twitter="'.$a['twitter'].'" instagram="'.$a['instagram'].'" google="'.$a['google'].'" skype="'.$a['skype'].'" pinterest="'.$a['pinterest'].'" linkedin="'.$a['linkedin'].'" tumblr="'.$a['tumblr'].'" youtube="'.$a['youtube'].'" vimeo="'.$a['vimeo'].'" rss="'.$a['rss'].'" vk="'.$a['vk'].'" tripadvisor="'.$a['tripadvisor'].'" houzz="'.$a['houzz'].'" icons_bg="'.$a['icons_bg'].'" icons_color="'.$a['icons_color'].'" icons_bg_hover="'.$a['icons_bg_hover'].'" icons_color_hover="'.$a['icons_color_hover'].'" filled="'.$a['filled'].'" ]');
		                $html .= '</div>';
	            $html .= '</div>';
	            $html .= '<div class="clear"></div>';
	            if($a['type'] == 2) {
	                $html .= '</div>';
	            }		      
		    }

	    
	        if($a['type'] == 2) {
	            $html .= '<div class="content-section col-md-'.$span.'">';
	        }
	        $html .= '<div class="member-details">';
	            if($a['position'] != ''){
	                $html .= '<h4>'.$a['name'].'</h4>';
	            }

			    if($a['name'] != ''){
				    $html .= '<h5 class="member-position">'.$a['position'].'</h5>';
			    }

	            if($a['email'] != ''){
	                $html .= '<p class="member-email"><span>'.__('Email:', 'xstore').'</span> <a href="mailto:'.$a['email'].'">'.$a['email'].'</a></p>';
	            }
			    $html .= do_shortcode($content);
	    	$html .= '</div>';

	        if($a['type'] == 2) {
	                $html .= '</div>';
	            $html .= '</div>';
	        }
	    $html .= '</div>';
	    
	    
	    return $html;
	}
}

// **********************************************************************// 
// ! Register New Element: team_member
// **********************************************************************//
add_action( 'init', 'etheme_register_vc_team_member');
if(!function_exists('etheme_register_vc_team_member')) {
	function etheme_register_vc_team_member() {
		if(!function_exists('vc_map')) return;
	    $team_member_params = array(
	      'name' => '[8theme] Team member',
	      'base' => 'team_member',
		  'icon' => ETHEME_CODE_IMAGES . 'vc/el-team.png',
	      'category' => 'Eight Theme',
	      'params' => array(
	        array(
	          'type' => 'textfield',
	          "heading" => esc_html__("Member name", 'xstore'),
	          "param_name" => "name"
	        ),
	        array(
	          'type' => 'textfield',
	          "heading" => esc_html__("Member email", 'xstore'),
	          "param_name" => "email"
	        ),
	        array(
	          'type' => 'textfield',
	          "heading" => esc_html__("Position", 'xstore'),
	          "param_name" => "position"
	        ),
	        array(
	          'type' => 'attach_image',
	          "heading" => esc_html__("Avatar", 'xstore'),
	          "param_name" => "img"
	        ),
	        array(
	          "type" => "textfield",
	          "heading" => esc_html__("Image size", 'xstore' ),
	          "param_name" => "img_size",
	          "description" => esc_html__("Enter image size. Example in pixels: 200x100 (Width x Height).", 'xstore' )
	        ),
	        array(
	          "type" => "textarea_html",
	          "holder" => "div",
	          "heading" => esc_html__("Member information", 'xstore' ),
	          "param_name" => "content",
	          "value" => esc_html__("Member description", 'xstore' )
	        ),
	        array(
	          "type" => "dropdown",
	          "heading" => esc_html__("Display Type", 'xstore' ),
	          "param_name" => "type",
	          "value" => array( 
	              "", 
	              esc_html__("Vertical", 'xstore') => 1,
	              esc_html__("Horizontal", 'xstore') => 2
	            )
	        ),
	       	array(
	          "type" => "dropdown",
	          "heading" => esc_html__("Content position", 'xstore' ),
	          "param_name" => "content_position",
	          "dependency" => array('element' => "type", 'value' => array('2')),
	          "value" => array(
	              esc_html__("Top", 'xstore') => 'top',
	              esc_html__("Middle", 'xstore') => 'middle',
	              esc_html__("Bottom", 'xstore') => 'bottom'
	            )
	        ),
	        array(
	          "type" => "dropdown",
	          "heading" => esc_html__("Image position", 'xstore' ),
	          "param_name" => "img_position",
	          "dependency" => array('element' => "type", 'value' => array('2')),
	          "value" => array(
	              esc_html__("Left", 'xstore') => 'left',
	              esc_html__("Right", 'xstore') => 'right'
	            )
	        ),
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
		        'type' => 'textfield',
		        "heading" => esc_html__("Skype name", 'xstore'),
		        "param_name" => "skype"
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
	          "type" => "textfield",
	          "heading" => esc_html__("Extra Class", 'xstore'),
	          "param_name" => "class",
	          "description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'xstore')
	        )
	      )
	
	    );  
	    vc_map($team_member_params);
	}
}
