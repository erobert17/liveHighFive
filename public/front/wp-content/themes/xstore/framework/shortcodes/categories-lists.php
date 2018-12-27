<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************// 
// ! etheme_categories
// **********************************************************************// 

if ( !function_exists('etheme_categories_lists_shortcode') ) {
  function etheme_categories_lists_shortcode($atts) {
      if ( etheme_woocommerce_notice() ) return;

      global $woocommerce_loop;
      extract( shortcode_atts( array(
          'number'     => null,
          'orderby'    => 'name',
          'order'      => 'ASC',
          'hide_empty' => 1,
          'columns' => 3,
          'parent'     => 0,
          'display_type' => 'grid',
          'hover_type' => 'default',
          'ids'        => '',
          'exclude'    => '',
          'large' => 4,
          'notebook' => 3,
          'tablet_land' => 2,
          'tablet_portrait' => 2,
          'mobile' => 1,
          'slider_autoplay' => false,
          'slider_speed' => 300,
          'slider_loop' => false,
          'slider_interval' => 1000,
          'pagination_type' => 'hide',
          'default_color' => '#e1e1e1',
          'active_color' => '#222',
          'hide_fo' => '',
          'hide_buttons' => false,
          'quantity' => '',
          'class'      => ''
      ), $atts ) );

      if ( isset( $atts[ 'ids' ] ) && ! empty( $atts[ 'ids' ] ) ) {
          $ids = explode( ',', $atts[ 'ids' ] );
          $ids = array_map( 'trim', $ids );
          $parent = '';
      } else {
          $ids = false;
      }

      if ( isset( $atts[ 'exclude' ] ) ) {
          $exclude = explode( ',', $atts[ 'exclude' ] );
          $exclude = array_map( 'trim', $exclude );
      } else {
          $exclude = array();
      }

      $hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;

      // get terms and workaround WP bug with parents/pad counts
      $args = array(
          'orderby'    => $orderby,
          'order'      => $order,
          'hide_empty' => $hide_empty,
          'include'    => $ids,
          'exclude'    => $exclude,
          'pad_counts' => true,
          'parent' => $parent
      );

      $product_categories = get_terms( 'product_cat', $args );

      if ( $hide_empty && ! is_wp_error( $product_categories ) ) {
          foreach ( $product_categories as $key => $category ) {
              if ( $category->count == 0 ) {
                  unset( $product_categories[ $key ] );
              }
          }
      }

      if ( $number ) {
          $product_categories = array_slice( $product_categories, 0, $number );
      }

      $box_id = rand(1000,10000);

      $class .= ' slider-' . $box_id;

      $loop = '';

      ob_start();

      if ( $product_categories ) {
          if($display_type == 'slider') {
              $class .= ' categories-lists-slider carousel-area';
          } else {
              $class .= ' categories-lists-grid';
              $class .= ' categories-columns-' . $columns;
          }
          $class .= ' category-hover-'.$hover_type;
          
          if ( ! empty( $quantity ) ) $class .= ' limit-enable';
          
          echo '<div class="clearfix '.$class.'">';

          $lines = '';
          if ($pagination_type == 'lines'){
              $lines = 'swiper-pagination-lines';
          }

                   $autoplay = '';
           if ($slider_autoplay) $autoplay = $slider_interval;

           if ($slider_loop) {
              $loop = ' data-loop="true"';
            }

            if ($display_type == 'slider') { ?>
               <div class="swiper-entry">
                   <div class="swiper-container" data-breakpoints="1" data-xs-slides="<?php echo esc_js($mobile) ?>" data-sm-slides="<?php echo esc_js($tablet_land) ?>" data-md-slides="<?php echo esc_js($notebook) ?>" data-lt-slides="<?php echo esc_js($large) ?>" data-slides-per-view="<?php echo esc_js($large) ?>" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-speed="<?php echo esc_attr($slider_speed); ?>" <?php echo wp_specialchars_decode($loop); ?>>
           <?php } ?>
                   <div class="<?php if ($display_type == 'slider') echo 'swiper-wrapper'; ?>">
                     <?php foreach ( $product_categories as $category ) { ?>
                         <div class="category-list-item-wrapper <?php if ($display_type == 'slider') echo 'swiper-slide'; ?> ">
                           <div class="category-list-item">
                             <a href="<?php echo get_term_link( $category, 'product_cat' ); ?>" class="category-image">
                               <?php woocommerce_subcategory_thumbnail( $category ); ?>
                             </a>
                             <ul>
                               <?php etheme_show_category_in_the_list( $category, $orderby, $order, $exclude, $hide_empty, $quantity ) ?>
                              </ul>
                           </div>
                         </div>
                     <?php } ?>
                   </div>
                  <?php if ($pagination_type != "hide") {
                    echo '<div class="swiper-pagination etheme-css" data-css=".slider-'.$box_id.' .swiper-pagination-bullet{background-color:'.$default_color.'; '. $lines.';} .slider-'.$box_id.' .swiper-pagination-bullet:hover{ background-color:'.$active_color.'; } .slider-'.$box_id.' .swiper-pagination-bullet-active{ background-color:'.$active_color.'; }"></div>';
                    } ?>
                 <?php if ($display_type == 'slider') {
                       echo '</div>';
                        if (!$hide_buttons && $display_type == 'slider') {
                             echo '
                             <div class="swiper-custom-left"></div>
                             <div class="swiper-custom-right"></div>
                         ';
                        }
                  echo '</div>';
               }
               // if (!$hide_buttons && $display_type == 'slider') {
               //     echo '
               //     <div class="swiper-custom-left"></div>
               //     <div class="swiper-custom-right"></div>
               // ';
               // }
               //if ($display_type == 'slider') {
                   echo '</div>';
               //}
       }
       return ob_get_clean();
   }
}

if( ! function_exists( 'etheme_show_category_in_the_list' ) ) {
  function etheme_show_category_in_the_list( $category, $orderby, $order, $exclude, $hide_empty, $quantity ) {
    ?>
      <li>
        <a href="<?php echo get_term_link( $category, 'product_cat' ); ?>" class="category-name"><?php echo esc_html($category->name); ?>
          <?php
            if ( $category->count > 0 )
              echo ' <mark class="count">(' . $category->count . ')</mark>';
          ?>
        </a>

        <?php 
          $subcategories =  get_terms( 'product_cat', array(
            'orderby'    => $orderby,
            'order'      => $order,
            'exclude'    => $exclude,
            'hide_empty' => $hide_empty,
            'pad_counts' => true,
            'parent' => $category->term_id
          ) );
          $i=0;
         ?>
    
         <?php if( ! empty( $subcategories ) && ! is_wp_error( $subcategories ) ) {
            echo '<ul>';
            foreach ($subcategories as $category) {
              $i++;
              if ( $i > $quantity && ! empty( $quantity ) ) {
                echo '<a href="' . get_category_link( $category->parent ) . '" class="limit-link"><span class="read-more">' . esc_html__( 'View All', 'xstore' ) . '</span></a>';
                return;
              } 

              etheme_show_category_in_the_list( $category, $orderby, $order, $exclude, $hide_empty, $quantity );
            }
            echo '</ul>';

         } ?>
       </li>
    <?php
  }
}


// **********************************************************************// 
// ! Register New Element: scslug
// **********************************************************************//
add_action( 'init', 'etheme_register_etheme_categories_lists');
if(!function_exists('etheme_register_etheme_categories_lists')) {
  if( class_exists('Vc_Vendor_Woocommerce')) {
    $Vc_Vendor_Woocommerce = new Vc_Vendor_Woocommerce();
    add_filter( 'vc_autocomplete_etheme_categories_lists_ids_callback', array($Vc_Vendor_Woocommerce, 'productCategoryCategoryAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array
    add_filter( 'vc_autocomplete_etheme_categories_lists_ids_render', array($Vc_Vendor_Woocommerce, 'productCategoryCategoryRenderByIdExact',), 10, 1 ); // Render exact category by id. Must return an array (label,value)
    add_filter( 'vc_autocomplete_etheme_categories_lists_exclude_callback', array($Vc_Vendor_Woocommerce, 'productCategoryCategoryAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array
    add_filter( 'vc_autocomplete_etheme_categories_lists_exclude_render', array($Vc_Vendor_Woocommerce, 'productCategoryCategoryRenderByIdExact',), 10, 1 ); // Render exact category by id. Must return an array (label,value)
  }

  function etheme_register_etheme_categories_lists() {
    if(!function_exists('vc_map')) return;
      $order_by_values = array(
        '',
        esc_html__( 'ID', 'xstore' ) => 'ID',
        esc_html__( 'Title', 'xstore' ) => 'name',
        esc_html__( 'Modified', 'xstore' ) => 'modified',
        esc_html__( 'Products count', 'xstore' ) => 'count',
          esc_html__( 'As IDs provided order', 'xstore' ) => 'include',
      );

      $order_way_values = array(
        '',
        esc_html__( 'Descending', 'xstore' ) => 'DESC',
        esc_html__( 'Ascending', 'xstore' ) => 'ASC',
      );
      
      $params = array(
        'name' => '[8theme] Product categories lists',
        'base' => 'etheme_categories_lists',
        'icon' => 'icon-wpb-etheme',
        'icon' => ETHEME_CODE_IMAGES . 'vc/el-categories.png',
        'category' => 'Eight Theme',
        'params' => array_merge(array(
          array(
            "type" => "textfield",
            "heading" => esc_html__("Number of categories", 'xstore'),
            "param_name" => "number"
          ),
            array(
              'type' => 'autocomplete',
              'heading' => esc_html__( 'Categories', 'xstore' ),
              'param_name' => 'ids',
              'settings' => array(
                'multiple' => true,
                'sortable' => true,
              ),
              'save_always' => true,
              'description' => esc_html__( 'List of product categories', 'xstore' ),
            ),
            array(
              "type" => "textfield",
              "heading" => esc_html__("Subcategories limit", 'xstore'),
              "param_name" => "quantity"
            ),
            array(
              'type' => 'autocomplete',
              'heading' => esc_html__( 'Exclude Categories', 'xstore' ),
              'param_name' => 'exclude',
              'settings' => array(
                'multiple' => true,
                'sortable' => true,
              ),
              'save_always' => true,
              'description' => esc_html__( 'List of product categories to exclude', 'xstore' ),
            ),
            array(
              "type" => "dropdown",
              "heading" => esc_html__("Display type", 'xstore'),
              "param_name" => "display_type",
              "value" => array( 
                  esc_html__("Grid", 'xstore') => 'grid',
                  esc_html__("Slider", 'xstore') => 'slider',
                )
            ),
            array(
              "type" => "dropdown",
              "heading" => esc_html__("Hover type", 'xstore'),
              "param_name" => "hover_type",
              "value" => array( 
                  esc_html__("Default", 'xstore') => 'default',
                  esc_html__("Disable", 'xstore') => 'Disable',
                )
            ),
            array(
              "type" => "dropdown",
              "heading" => esc_html__("Columns", 'xstore'),
              "param_name" => "columns",
              "value" => array( 
                  esc_html__("2", 'xstore') => 2,
                  esc_html__("3", 'xstore') => 3,
                  esc_html__("4", 'xstore') => 4,
                  esc_html__("5", 'xstore') => 5,
                  esc_html__("6", 'xstore') => 6,
                ),
              "dependency" => array('element' => "display_type", 'value' => array('grid'))
            ),
            array(
              'type' => 'dropdown',
              'heading' => esc_html__( 'Order by', 'xstore' ),
              'param_name' => 'orderby',
              'value' => $order_by_values,
              'save_always' => true,
              'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'xstore' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
            ),
            array(
              'type' => 'dropdown',
              'heading' => esc_html__( 'Sort order', 'xstore' ),
              'param_name' => 'order',
              'value' => $order_way_values,
              'save_always' => true,
              'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'xstore' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
            ),
          array(
            "type" => "textfield",
            "heading" => esc_html__("Extra Class", 'xstore'),
            "param_name" => "class"
          )
          ), etheme_get_slider_params())
      );  
  
      vc_map($params);
  }
}
