<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************// 
// ! Menu list item
// **********************************************************************// 
if ( !function_exists('etheme_menu_list_item_shortcode') ) {
  function etheme_menu_list_item_shortcode($atts) {

      $output = $icon = $holder_class = $img_class = $a_title = $icon_style = $custom_class = $icon_style_hover = '';

    if( is_array($atts) && empty( $atts['title_google_fonts'] ) ) {
      $atts['title_google_fonts'] = 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal';
    }

      extract(shortcode_atts(array(
          'class'  => '',
          'css' => '',
          'title_link'  => '',
          'title'  => '',
          'label' => '',
          'hover_color' => '',
          'hover_bg' => '',
          'padding_top' => '',
          'padding_right' => '',
          'padding_bottom' => '',
          'padding_left' => '',
          'transform' => '',
          'spacing' => '',
          'use_custom_fonts_title' => '',
          'img' => '',
          'img_size' => '270x170',
          'css' => '',
          // icons 
          'icon' => '',
          'type' => 'fontawesome',
          'icon_fontawesome' => '',
          'icon_openiconic' => '',
          'icon_typicons' => '',
          'icon_entypo' => '',
          'icon_linecons' => '',
          'icon_monosocial' => '',
          'icon_color' => '',
          'icon_color_hover' => '',
          'icon_bg_color' => '',
          'icon_bg_color_hover' => '',
          'icon_size' => '',
          'position' => '',
      ), $atts));

      $current_page_link = get_permalink();
      $head_class = 'menu-title';

      // icon styles 

      if($icon_color != '') {
        $icon_style .= 'color:' . $icon_color . ';';
      }

      if($icon_bg_color != '') {
        $icon_style .= 'background-color:' . $icon_bg_color . ';';
      }

      if($icon_color_hover != '') {
        $icon_style_hover .= 'color:' . $icon_color_hover . ';';
      }

      if($icon_bg_color_hover != '') {
        $icon_style_hover .= 'background-color:' . $icon_bg_color_hover . ';';
      }

      if($icon_size != '') {
        $icon_style .= 'font-size:' . $icon_size . ';';
      }

      $id = rand(1000,9999);

      $link = ( '||' === $title_link ) ? '' : $title_link;
      $link = vc_build_link( $link );
      $a_href = '#';
      $a_target = '_self';

      if ( strlen( $link['url'] ) > 0 ) {
        $a_href = $link['url'];
        $a_title = $link['title'];
        $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
        $class .= ($current_page_link == $a_href) ? 'current-menu-item' : '';
      }

      if ( is_array($atts) ) {
        $atts['link'] = $atts['title_link'] = '';
      }
      
      vc_icon_element_fonts_enqueue( $type );

      if( $type == 'image' ) {
        $icon .= etheme_get_image($img, $img_size);
      } else {
        $iconClass = isset( ${'icon_' . $type} ) ? esc_attr( ${'icon_' . $type} ) : 'fa fa-adjust';
        $icon = '<i class="et-icon ' . $iconClass . '"></i>';
      }

      if ( !empty($label) ) {
        $holder_class .= 'item-has-label menu-label-'.$label;
      }

      if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
        $class .= ' ' . vc_shortcode_custom_css_class( $css );
      }

      // to prevent last child from css
      $output .= '<style>';
       if ( !empty($hover_color)) {
          $output .= ' .menu-item-'.$id .'> .subitem-title-holder:hover h2, .menu-item-'.$id .'> .subitem-title-holder:active h2, ' . ' .menu-item-'.$id .'.current-menu-item > .subitem-title-holder h2 { color:';
          $output .= $hover_color;
          $output .= ' !important;}';
       }

       if ( !empty($hover_bg)) {
          $output .= ' .menu-item-'.$id .':hover, .menu-item-'.$id .':active,' . ' .menu-item-'.$id .'.current-menu-item { background-color:';
          $output .= $hover_bg;
          $output .= ' !important;}';
       }

       if ( !empty($padding_top) || !empty($padding_right) || !empty($padding_bottom) || !empty($padding_left)) {
          $output .= ' .menu-item-'.$id .' .subitem-title-holder .menu-title {';
          if ( !empty($padding_top) ) {
            $output .= "padding-top:".$padding_top.';';
          }
          if ( !empty($padding_right) ) {
            $output .= "padding-right:".$padding_right.';';
          }
          if ( !empty($padding_bottom) ) {
            $output .= "padding-bottom:".$padding_bottom.';';
          }
          if ( !empty($padding_left) ) {
            $output .= "padding-left:".$padding_left.';';
          }
          $output .= '}';
        }

       if ( !empty($spacing)) {
          $output .= ' .menu-item-'.$id .'> .subitem-title-holder h2 { letter-spacing:';
          $output .= $spacing;
          $output .= ';}';
       }

      $output .= ' .menu-item-'.$id .'> .subitem-title-holder > .et-icon { ';
      $output .= $icon_style;
      $output .= $icon_bg_color;
      $output .= '}';
      $output .= ' .menu-item-'.$id .'> .subitem-title-holder:hover  > .et-icon { ';
      $output .= $icon_style_hover;
      $output .= $icon_bg_color_hover;
      $output .= '}';
      $output .= '</style>';

        $output .= '<li class="menu-item menu-item-type-post_type menu-item-'.$id.' '. esc_attr( $class ).'">';

        if( ! empty( $title ) ) {

          $output .= '<div class="subitem-title-holder '.$holder_class.'">';

          if ($type != 'image' && trim($icon) != '') {

            $output .= $icon;
          
          }

          elseif ( !empty($icon) && trim($icon) != '' ) {

            $output .= '<div class="nav-item-image type-img position-' . $position . '">';

          }

          $output .= '<a href="'. $a_href . '" class="menu-title '.$transform.'" title="'.$a_title. '" target="'. $a_target. '">'; 

          $output .= etheme_getHeading('title', $atts);

          if ( !empty($label) ) {
            $output .= '<span class="label-text">'.$label.'</span>';
          }

          $output .= '</a>'; 

          // if image then show under title
          if ( $type == 'image' && trim($icon) != '') { 

            $output .= $icon;

            // if ( $use_custom_fonts_title ) {

              $output .= '</div>';

            // }

          }
          $output .= '</div>';
        }
        $output .= '</li>';

      return $output;
  }
}

// **********************************************************************// 
// ! Register New Element: Menu list item
// **********************************************************************//
add_action( 'init', 'etheme_register_menu_list_item');
if(!function_exists('etheme_register_menu_list_item')) {
  function etheme_register_menu_list_item() {
    if(!function_exists('vc_map')) return;

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
            $sub_key = array_search( 'tag', $param['settings']['fields'] );
            if ( false !== $sub_key ) {
              unset( $title_custom_heading[ $key ]['settings']['fields'][ $sub_key ] );
            } elseif ( isset( $param['settings']['fields']['tag'] ) ) {
              unset( $title_custom_heading[ $key ]['settings']['fields']['tag'] );
            }
            $sub_key = array_search( 'text_align', $param['settings']['fields'] );
            if ( false !== $sub_key ) {
              unset( $title_custom_heading[ $key ]['settings']['fields'][ $sub_key ] );
            } elseif ( isset( $param['settings']['fields']['text_align'] ) ) {
              unset( $title_custom_heading[ $key ]['settings']['fields']['text_align'] );
            }
          }
        }
      }
    }

    $params = array_merge( array(
      array(
        "type" => "textfield",
        "heading" => "Title",
        "param_name" => "title",
        "admin_label" => true
      ),
      array(
        "type" => "vc_link",
        "heading" => "Link",
        "param_name" => "title_link",
      ),
      array(
          "type" => "dropdown",
          "heading" => esc_html__('Label', 'xstore'),
          "param_name" => 'label',
          "value" => array (
            'Select label' => '',
            esc_html__( 'Hot', 'xstore' ) => 'hot',
            esc_html__( 'Sale', 'xstore' ) => 'sale',
            esc_html__( 'New', 'xstore' ) => 'new'
          ),
        ),
      array (
        "type" => "dropdown",
          "heading" => esc_html__("Text transform", 'xstore'),
          "param_name" => "transform",
          "value" => array( 
            '' => '',
          esc_html__('Uppercase', 'xstore') => 'text-uppercase',
          esc_html__("Lowercase", 'xstore') => 'text-lowercase', 
          esc_html__("Capitalize", 'xstore') => 'text-capitalize', 
          ),
     ),
      array(
          'type' => 'checkbox',
          'heading' => esc_html__( 'Use custom font ?', 'xstore' ),
          'param_name' => 'use_custom_fonts_title',
          'description' => esc_html__( 'Enable Google fonts.', 'xstore' ),
        ),
       array(
          'type' => 'checkbox',
          'heading' => esc_html__( 'Add icon ?', 'xstore' ),
          'param_name' => 'add_icon',
        ),
        array(
          'type' => 'dropdown',
          'heading' => esc_html__( 'Icon library', 'xstore' ),
          'value' => array(
            esc_html__( 'Font Awesome', 'xstore' ) => 'fontawesome',
            esc_html__( 'Open Iconic', 'xstore' ) => 'openiconic',
            esc_html__( 'Typicons', 'xstore' ) => 'typicons',
            esc_html__( 'Entypo', 'xstore' ) => 'entypo',
            esc_html__( 'Linecons', 'xstore' ) => 'linecons',
            esc_html__( 'Mono Social', 'xstore' ) => 'monosocial',
            esc_html__( 'Upload image', 'xstore' ) => 'image',
          ),
          // 'admin_label' => true,
          'param_name' => 'type',
          'description' => esc_html__( 'Select icon library.', 'xstore' ),
          'dependency' => array (
            'element' => 'add_icon', 
            'value' => 'true'
            )
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__( 'Icon', 'xstore' ),
          'param_name' => 'icon_fontawesome',
          'value' => 'fa fa-adjust', // default value to backend editor admin_label
          'settings' => array(
            'emptyIcon' => false,
            // default true, display an "EMPTY" icon?
            'iconsPerPage' => 4000,
            // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'fontawesome',
          ),
          'description' => esc_html__( 'Select icon from library.', 'xstore' ),
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__( 'Icon', 'xstore' ),
          'param_name' => 'icon_openiconic',
          'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
          'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'type' => 'openiconic',
            'iconsPerPage' => 4000, // default 100, how many icons per/page to display
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'openiconic',
          ),
          'description' => esc_html__( 'Select icon from library.', 'xstore' ),
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__( 'Icon', 'xstore' ),
          'param_name' => 'icon_typicons',
          'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
          'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'type' => 'typicons',
            'iconsPerPage' => 4000, // default 100, how many icons per/page to display
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'typicons',
          ),
          'description' => esc_html__( 'Select icon from library.', 'xstore' ),
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__( 'Icon', 'xstore' ),
          'param_name' => 'icon_entypo',
          'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
          'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'type' => 'entypo',
            'iconsPerPage' => 4000, // default 100, how many icons per/page to display
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'entypo',
          ),
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__( 'Icon', 'xstore' ),
          'param_name' => 'icon_linecons',
          'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
          'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'type' => 'linecons',
            'iconsPerPage' => 4000, // default 100, how many icons per/page to display
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'linecons',
          ),
          'description' => esc_html__( 'Select icon from library.', 'xstore' ),
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__( 'Icon', 'xstore' ),
          'param_name' => 'icon_monosocial',
          'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
          'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'type' => 'monosocial',
            'iconsPerPage' => 4000, // default 100, how many icons per/page to display
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'monosocial',
          ),
          'description' => esc_html__( 'Select icon from library.', 'xstore' ),
        ),
        array(
          'type' => 'colorpicker',
          "heading" => esc_html__("Icon color", 'xstore'),
          "param_name" => "icon_color",
          'dependency' => array(
            'element' => 'type',
            'value_not_equal_to' => 'image',
          ),
        ),
        array(
          'type' => 'colorpicker',
          "heading" => esc_html__("Icon background color", 'xstore'),
          "param_name" => "icon_bg_color",
          'dependency' => array(
            'element' => 'type',
            'value_not_equal_to' => 'image',
          ),
        ),
        array(
          'type' => 'colorpicker',
          "heading" => esc_html__("Icon color (hover)", 'xstore'),
          "param_name" => "icon_color_hover",
          'dependency' => array(
              'element' => 'type',
              'value_not_equal_to' => 'image',
            ),
        ),
        array(
          'type' => 'colorpicker',
          "heading" => esc_html__("Icon background color (hover)", 'xstore'),
          "param_name" => "icon_bg_color_hover",
          'dependency' => array(
              'element' => 'type',
              'value_not_equal_to' => 'image',
            ),
        ),
        array(
          "type" => "textfield",
          "heading" => "Icon size (in pixels)",
          "param_name" => "icon_size",
          'dependency' => array(
            'element' => 'type',
            'value_not_equal_to' => 'image',
          ),
        ),
        array(
          'type' => 'attach_image',
          'heading' => esc_html__( 'Image', 'xstore' ),
          'param_name' => 'img',
          'dependency' => array(
            'element' => 'type',
            'value' => 'image',
          ),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Image size", 'xstore' ),
          "param_name" => "img_size",
            'dependency' => array(
              'element' => 'type',
              'value' => 'image',
            ),
          "description" => esc_html__("Enter image size. Example in pixels: 200x100 (Width x Height).", 'xstore'),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Position of the image", 'xstore'),
          "param_name" => "position",
          "value" => array( 
            __('Select position', 'xstore') => '',
            __("Left top", 'xstore') => 'left-top', 
            __("Left center", 'xstore') => 'left-center', 
            __("Left bottom", 'xstore') => 'left-bottom', 
            __("Center center", 'xstore') => 'center-center',
            __("Center bottom", 'xstore') => 'center-bottom',
            __("Right top", 'xstore') => 'right-top',
            __("Right center", 'xstore') => 'right-center',
            __("Right bottom", 'xstore') => 'right-bottom',
           ),
           'dependency' => array (
            'element' => 'type',
            'value' =>'image'
          ),
        ),
        array (
          "type" => "textfield",
          "heading" => 'Link paddings <br/> Top',
          "param_name" => 'padding_top',
          'edit_field_class' => 'vc_col-sm-3 vc_column',
          'description' => __('Note: CSS measurement units allowed', 'xstore'),
        ),
        array (
          "type" => "textfield",
          "heading" => '<br/> Right',
          "param_name" => 'padding_right',
          'edit_field_class' => 'vc_col-sm-3 vc_column',
        ),
        array (
          "type" => "textfield",
          "heading" => '<br/> Bottom',
          "param_name" => 'padding_bottom',
          'edit_field_class' => 'vc_col-sm-3 vc_column',
        ),
        array (
          "type" => "textfield",
          "heading" => '<br/> Left',
          "param_name" => 'padding_left',
          'edit_field_class' => 'vc_col-sm-3 vc_column',
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Extra Class", 'xstore'),
          "param_name" => "class",
          "description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'xstore')
        ),
        array(
          "type" => "textfield",
          "heading" => "Letter spacing",
          "param_name" => "spacing",
          'group' => 'Typography',
          'description' => esc_html__('Enter letter spacing', 'xstore'),
          'dependency' => array (
            'element' => 'use_custom_fonts_title',
            'value' =>'true'
          ),
        ),
    ), $title_custom_heading,
    array(
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Text color", 'xstore'),
          "param_name" => "hover_color",
          "group" => "Hover",
          'dependency' => array (
            'element' => 'use_custom_fonts_title',
            'value' => 'true'
          ),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Background color", 'xstore'),
          "param_name" => "hover_bg",
          "group" => "Hover",
          'dependency' => array (
            'element' => 'use_custom_fonts_title',
            'value' => 'true'
          ),
        ),
        array(
          'type' => 'css_editor',
          'heading' => esc_html__( 'CSS box', 'xstore' ),
          'param_name' => 'css',
          'group' => esc_html__( 'Design', 'xstore' )
        ),
        )
      );

      $menu_item_params = array(
          'name' => '[8THEME] Menu list item',
          'base' => 'et_menu_list_item',
          'icon' => 'icon-wpb-etheme',
          'category' => 'Eight Theme',
            'content_element' => true,
            'icon' => ETHEME_CODE_IMAGES . 'vc/el-menu-list.png',
            'as_child' => array('only' => 'et_menu_list'),            
            'is_container' => false,
          'params' => $params,
  
      );  
  
      vc_map($menu_item_params);
  }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_ET_Menu_List_Item extends WPBakeryShortCode {
    }
}
