<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************// 
// ! Scroll text item
// **********************************************************************// 
if ( ! function_exists('etheme_scroll_text_item_shortcode') ) {
	function etheme_scroll_text_item_shortcode($atts, $content) {

		 extract(shortcode_atts(array(
	        'button_link'  => '#',
	        'tooltip'  => false,
	        'tooltip_content' => '',
	        'tooltip_content_pos' => 'bottom',
			'el_class' => '',
		), $atts));

		// Button link 
		 
		$button_link = ( '||' === $button_link ) ? '' : $button_link;
		$button_link = vc_build_link( $button_link );

		ob_start();?>
		<div class="autoscrolling-item <?php echo esc_attr($el_class); ?>">
			<?php echo wp_kses_post( $content ) . ' ';
			if ( !$tooltip ) {
			if ( strlen( $button_link['title'] ) > 0 ) { ?>
				<a 
					href="<?php echo (!empty($button_link['url']) ) ? esc_attr($button_link['url']) : '#' ?>" 
					class="scr-text-button" 
					target="<?php echo strlen( $button_link['target'] ) > 0 ? esc_attr($button_link['target']) : '_self' ?>" 
					rel="<?php echo esc_attr($button_link['rel']); ?>"><?php echo esc_html($button_link['title']); ?>
				</a>
			<?php } 
			} else { ?>
			<div class="et-text-tooltip" rel="tooltip" data-placement="<?php echo esc_attr($tooltip_content_pos); ?>">
				<?php echo esc_html( $atts['tooltip_title'] ); ?>
				<div class="tooltip-content"><?php echo wp_kses_post( $tooltip_content ); ?></div>
			</div>
			<?php } ?>
		</div>
		<?php return ob_get_clean();
	}
}

// **********************************************************************// 
// ! Register New Element: Scroll text item
// **********************************************************************//
add_action( 'init', 'etheme_register_scroll_text_item');
if(!function_exists('etheme_register_scroll_text_item')) {
	function etheme_register_scroll_text_item() {
		if(!function_exists('vc_map')) return;
		vc_map(array(
	      	'name' => '[8THEME] Scroll text content',
      		'base' => 'etheme_scroll_text_item',
	      	'category' => 'Eight Theme',
	      	'content_element' => true,
	        'icon' => ETHEME_CODE_IMAGES . 'vc/el-banner.png',
	        'as_child' => array('only' => 'etheme_scroll_text'),            
        	'is_container' => false,
	      	'params' => array ( 
		      		array(
						"type" => "textarea",
						"holder" => "div",
						"heading" => "Text",
						"param_name" => "content",
						"value" => "Lorem ipsum dolor ..."
					),
					array (
						"type" => "checkbox",
						"heading" => esc_html__("Use tooltip instead of link", 'xstore'),
						"param_name" => "tooltip",
					),
					array (
						"type" => "textfield",
						"heading" => esc_html__("Tooltip title", 'xstore'),
						"param_name" => "tooltip_title",
						'dependency' =>  array('element' => 'tooltip', 'value' => 'true' ),
					),
					array (
						"type" => "textarea",
						"heading" => esc_html__("Tooltip content", 'xstore'),
						"param_name" => "tooltip_content",
						'dependency' =>  array('element' => 'tooltip', 'value' => 'true' ),
					),
					array (
						"type" => "dropdown",
						"heading" => esc_html__("Tooltip content position", 'xstore'),
						"param_name" => "tooltip_content_pos",
						"value" => array (
							'Bottom' => 'bottom',
							'Top' => 'top',
						),
						'dependency' =>  array('element' => 'tooltip', 'value' => 'true' ),
					),
		      		array(
						"type" => "vc_link",
						"heading" => esc_html__("Button link", 'xstore'),
						"param_name" => "button_link",
						'dependency' =>  array('element' => 'tooltip', 'value_not_equal_to' => 'true' ),
					),
					 array(
	                    "type" => "textfield",
	                    "heading" => esc_html__("Extra Class", 'xstore'),
	                    "param_name" => "el_class"
	                ),
				),
		    )
	    );
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_ETHEME_scroll_text_item extends WPBakeryShortCode {
    }
}