<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************// 
// ! Best offer
// **********************************************************************// 
if ( !function_exists('etheme_offer_shortcode') ) {
  function etheme_offer_shortcode($atts, $content) {
      global $woocommerce_loop;

      if ( ! class_exists('Woocommerce') ) return false;

      $output = '';

      $atts = shortcode_atts(array(
          'post_type'  => 'ids',
          'include'  => '',
          'custom_query'  => '',
          'taxonomies'  => '',
          'items_per_page'  => 10,
          'columns' => 3,
          'hover' => 'disable',
          'banner_double' => '',
          'orderby'  => 'date',
          'order'  => 'DESC',
          'meta_key'  => '',
          'exclude'  => '',
          'class'  => '',
          'product_view' => '',
          'product_view_color' => '',
          'css' => '',
          'img_size' => 'medium',
          'dis_type' => 'type1',
          // ! slider args
          'slider_autoplay' => false,
          'slider_speed' => 10000,
          'pagination_type' => 'hide',
          'default_color' => '#e6e6e6',
          'active_color' => '#b3a089',
          'hide_fo' => '',
          'hide_buttons' => false,
      ), $atts);

      extract($atts);

      if ( ! in_array( $img_size, array(  'thumbnail', 'medium', 'large', 'full' ) ) ) {
        $size = explode( 'x', $img_size );
      } else {
        $size = $img_size;
      }

      $paged = (get_query_var('page')) ? get_query_var('page') : 1;

      $args = array(
        'post_type' => 'product',
        'status' => 'published',
        'paged' => $paged,  
        'posts_per_page' => $items_per_page
      );

      if($post_type == 'ids' && $include != '') {
        $args['post__in'] = explode(',', $include);
        $orderby = 'post__in';
      }

      if(!empty( $exclude ) ) {
        $args['post__not_in'] = explode(',', $exclude);
      }


      if(!empty( $taxonomies )) {
        $terms = get_terms( array('product_cat', 'product_tag'), array(
          'orderby' => 'name',
          'include' => $taxonomies
        ));

        if( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
          $args['tax_query'] = array('relation' => 'OR');
          foreach ($terms as $key => $term) {
            $args['tax_query'][] = array(
                  'taxonomy' => $term->taxonomy,        //(string) - Taxonomy.
                  'field' => 'slug',                    //(string) - Select taxonomy term by ('id' or 'slug')
                  'terms' => array( $term->slug ),      //(int/string/array) - Taxonomy term(s).
                  'include_children' => true,           //(bool) - Whether or not to include children for hierarchical taxonomies. Defaults to true.
                  'operator' => 'IN'  
            );
          }
        }
      }

      if(!empty( $order )) {
        $args['order'] = $order;
      }

      if(!empty( $meta_key )) {
        $args['meta_key'] = $meta_key;
      }

      if(!empty( $orderby )) {
        $args['orderby'] = $orderby;
      }

      $output = '';

      $box_id = rand( 1000,10000 );

      ob_start();

      $products = new WP_Query( $args );

      $class = $el_class = $title_output = $images_class = '';

      $view = etheme_get_option('product_view');
      $view_color = etheme_get_option('product_view_color');

      if ( ! empty( $woocommerce_loop['product_view'] ) )
        $view = $woocommerce_loop['product_view'];

      if ( ! empty( $woocommerce_loop['product_view_color'] ) )
        $view_color = $woocommerce_loop['product_view_color'];

      $shop_url = get_permalink(wc_get_page_id('shop'));

      $woocommerce_loop['columns'] = $columns;

      if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
          $images_class = vc_shortcode_custom_css_class( $css );
          $images_style = explode('{', $css);
          $images_style = '[data-class="' . $images_class . '"] .product-content-image img {' . $images_style[1];
          $css = '<style>' . $images_style . '</style>';
      }

      if( $banner_double ) {
        $columns = $columns / 2;
      }
      if ( $dis_type == 'type2' ) {
        $type2 = true;
      }
      $el_class .= ' '.$dis_type;

      if ( $products->have_posts() ) : ?>
        <div class="et-offer <?php echo $el_class; ?> slider-<?php echo esc_attr($box_id);?> clearfix" data-class="<?php echo esc_attr($images_class); ?>">
          <?php $i=0; while ( $products->have_posts() ) : $products->the_post(); ?>

            <?php $id = get_the_ID();
            $stock_line = '';
            if ( $dis_type == 'type2' && 'yes' === get_option( 'woocommerce_manage_stock' ) ) {
              $product = wc_get_product($id);
              $stock_quantity = $product->get_stock_quantity();
              $already_sold = get_post_meta( $id, 'total_sales', true );
              $all_stock = $stock_quantity + $already_sold; 
              if ( !empty($stock_quantity) ) {
                ob_start(); ?>
                <div class="product-stock">
                <span class="stock-in"><?php echo esc_html__('Available:', 'xstore') . ' <span class="stock-count">' . $stock_quantity . '</span>'; ?></span>
                <span class="stock-out"><?php echo esc_html__('Already sold:', 'xstore') . ' <span class="stock-count">' . $already_sold . '</span>'; ?></span>
                <span class="stock-line"><span class="stock-line-inner" style="width: <?php echo ( ( $already_sold * 100 ) / $all_stock ); ?>%"></span></span>
                </div>
                <?php $stock_line = ob_get_clean();
              }
            }
            $product_view = etheme_get_custom_field('product_view_hover');
            if ( $product_view && $product_view != 'inherit' ) $view = $product_view;

            $product_view_color = etheme_get_custom_field('product_view_color');
            if ( $product_view_color && $product_view_color != 'inherit' ) $view_color = $product_view_color;
            $classes = get_post_class();
            $classes[] = 'product-hover-' . $hover;
            $classes[] = 'product-view-' . $view;
            $classes[] = 'view-color-' . $view_color;
            if ( $hover == 'slider' ) $classes[] = 'arrows-hovered'; ?>

              <div <?php post_class($classes); ?>>
                  <div class="content-product">
                    <?php etheme_loader(); ?>
                    <?php
                      /**
                       * woocommerce_before_shop_loop_item hook.
                       *
                       * @hooked woocommerce_template_loop_product_link_open - 10
                       */
                      do_action( 'woocommerce_before_shop_loop_item' );

                      /**
                       * woocommerce_before_shop_loop_item_title hook.
                       *
                       * @hooked woocommerce_show_product_loop_sale_flash - 10
                       * @hooked woocommerce_template_loop_product_thumbnail - 10
                       */
                      // do_action( 'woocommerce_before_shop_loop_item_title' );


                      // ! Remove image from title action
                      remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
                    ?>

                      <?php if ( !$type2 ) : ?>  
                        <?php
                          etheme_product_cats();
                        ?>
                        <p class="product-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </p>

                      <?php woocommerce_template_loop_rating(); ?>
                      <?php endif; ?>

                      <div class="product-image-wrapper hover-effect-<?php echo esc_attr( $hover ); ?>">

                        <?php etheme_product_availability(); ?>
                        <?php if ( $hover == 'slider' ) echo '<div class="images-slider-wrapper">'; ?>
                        <a class="product-content-image" href="<?php the_permalink(); ?>" data-images="<?php echo etheme_get_image_list( $size ); ?>">
                          <?php if( $hover == 'swap' ) etheme_get_second_image( $size ); ?>
                          <?php echo etheme_get_image( get_post_thumbnail_id(), $size ); ?>
                          <?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
                        </a>
                        <?php if ( $hover == 'slider' ) echo '</div>'; ?>

                        <?php  /*<footer class="footer-product">
                            <?php if (etheme_get_option('quick_view')): ?>
                                <span class="show-quickly" data-prodid="<?php echo get_the_ID();?>"><?php esc_html_e('Quick View', 'xstore') ?></span>
                            <?php endif ?>
                            <?php
                                do_action( 'woocommerce_after_shop_loop_item' );
                              ?>
                            <?php echo etheme_wishlist_btn(); ?>
                        </footer>
                        */ ?>
                        <?php if ($view == 'info'): ?>
                          <div class="product-mask">

                              <?php // if (array_key_exists('product_page_productname', $product_settings)): ?>
                                  <p class="product-title">
                                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                  </p>
                              <?php // endif ?>

                              <?php
                                  /**
                                   * woocommerce_after_shop_loop_item_title hook
                                   *
                                   * @hooked woocommerce_template_loop_rating - 5
                                   * @hooked woocommerce_template_loop_price - 10
                                   */
                                  // if (array_key_exists('product_page_price', $product_settings)) {
                                      do_action( 'woocommerce_after_shop_loop_item_title' );
                                  // }
                              ?>
                          </div>
                      <?php endif ?>
                      <?php if ( $view == 'mask' || $view == 'mask2' || $view == 'mask3' || $view == 'default' || $view == 'info' ) : ?>
                        <footer class="footer-product">
                          <?php if ( $view == 'mask3' ): ?>
                              <?php echo etheme_wishlist_btn(); ?>
                          <?php else: ?>
                              <?php if (etheme_get_option('quick_view')): ?>
                                  <span class="show-quickly" data-prodid="<?php echo esc_attr($id);?>"><?php esc_html_e('Quick View', 'xstore') ?></span>
                              <?php endif; ?>
                          <?php endif; ?>

                          <?php if ($view != 'default') {
                              //if (array_key_exists('product_page_addtocart', $product_settings)) {
                                  do_action( 'woocommerce_after_shop_loop_item' );
                              //}
                          }?>
                          <?php if ( $view == 'mask3' ): ?>
                              <?php if (etheme_get_option('quick_view')): ?>
                                  <span class="show-quickly" data-prodid="<?php echo esc_attr($id);?>"><?php esc_html_e('Quick View', 'xstore') ?></span>
                               <?php endif ?>
                          <?php elseif ($view != 'default'): ?>
                              <?php echo etheme_wishlist_btn(); ?>
                          <?php endif; ?>
                        </footer>
                      <?php endif; ?>
                      </div>

                      <div class="product-details <?php echo ($type2) ? 'text-center' : ''; ?>">
                          <?php if ( $type2 ) : 
                          if ( $view == 'light' ) : ?>
                            <div class="light-right-side">
                                <?php if (etheme_get_option('quick_view')): ?>
                                    <span class="show-quickly" data-prodid="<?php echo esc_attr($id);?>"><?php esc_html_e('Quick View', 'xstore') ?></span>
                                <?php endif; ?>

                                <?php echo etheme_wishlist_btn(); ?>
                            </div><!-- .light-right-side -->
                        <?php endif; ?>

                        <?php if ( $view == 'light' ) echo '<div class="light-left-side">'; 
                            etheme_product_cats(); ?>
                            <p class="product-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </p>
                             <?php woocommerce_template_loop_rating(); ?>
                             <?php woocommerce_template_loop_price(); ?>
                             <?php echo $stock_line; ?>

                          <?php endif; ?>

                        <?php if ( $view == 'light' ) echo '</div>'; ?>

                          <?php if ( !$type2 ) : ?> 
                              <?php woocommerce_template_loop_price(); ?>
                          <?php endif; ?>

                          <?php etheme_product_countdown($dis_type); ?>

                          <?php if ( $type2 ) : ?>
                            <a class="btn active" href="<?php the_permalink(); ?>"><?php esc_html_e('Shop now', 'xstore'); ?></a>
                          <?php endif; ?>

                      </div>
                     <?php add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 ); ?>
                </div><!-- .content-product -->
              </div>
          <?php endwhile; // end of the loop. ?>
          <?php
            unset($woocommerce_loop['columns']); 
            unset($woocommerce_loop['isotope']); 
            unset($woocommerce_loop['size']); 
            unset($woocommerce_loop['product_view']); 
            unset($woocommerce_loop['product_view_color']); 
          ?>
        </div>

      <?php endif;

      wp_reset_postdata();

      $output = ob_get_clean();
        
      return $output;
  }
}

// **********************************************************************// 
// ! Register New Element: Best offer
// **********************************************************************//
add_action( 'init', 'etheme_register_offer');
if(!function_exists('etheme_register_offer')) {
  function etheme_register_offer() {
    if(!function_exists('vc_map')) return;

      add_filter( 'vc_autocomplete_et_offer_include_callback',
        'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
      add_filter( 'vc_autocomplete_et_offer_include_render',
        'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

      // Narrow data taxonomies
      add_filter( 'vc_autocomplete_et_offer_taxonomies_callback',
        'vc_autocomplete_taxonomies_field_search', 10, 1 );
      add_filter( 'vc_autocomplete_et_offer_taxonomies_render',
        'vc_autocomplete_taxonomies_field_render', 10, 1 );

      // Narrow data taxonomies for exclude_filter
      add_filter( 'vc_autocomplete_et_offer_exclude_filter_callback',
        'vc_autocomplete_taxonomies_field_search', 10, 1 );
      add_filter( 'vc_autocomplete_et_offer_exclude_filter_render',
        'vc_autocomplete_taxonomies_field_render', 10, 1 );

      add_filter( 'vc_autocomplete_et_offer_exclude_callback',
        'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
      add_filter( 'vc_autocomplete_et_offer_exclude_render',
    'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)


      $post_types_list = array();
      $post_types_list[] = array( 'product', esc_html__( 'Product', 'xstore' ) );
      //$post_types_list[] = array( 'custom', esc_html__( 'Custom query', 'xstore' ) );
      $post_types_list[] = array( 'ids', esc_html__( 'List of IDs', 'xstore' ) );

      $params = array(
        'name' => '[8THEME] Best offer',
        'base' => 'et_offer',
        'icon' => 'icon-wpb-etheme',
        'category' => 'Eight Theme',
        'content_element' => true,
        'icon' => ETHEME_CODE_IMAGES . 'vc/el-lookbook.png',
        'params' => array(
          array(
            'type' => 'autocomplete',
            'heading' => esc_html__( 'Product', 'xstore' ),
            'param_name' => 'include',
            'settings' => array(
              'multiple' => false,
              'sortable' => true,
              'groups' => true,
            ),
          ),
           array(
              "type" => "textfield",
              "heading" => esc_html__("Limit", 'xstore'),
              "param_name" => "items_per_page",
              'value' => 10,
              "description" => sprintf( esc_html__( 'Use "-1" to show all products.', 'xstore' ) )
          ),
          array(
            'type' => 'textfield',
            'heading' => esc_html__('Image size', 'xstore' ),
            'param_name' => 'img_size',
            'description' => esc_html__('Enter image size. Example in pixels: 200x100 (Width x Height).', 'xstore'),
          ),
          array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Display type', 'xstore' ),
            'param_name' => 'dis_type',
            'value' => array(
              __( 'Default', 'xstore' ) => 'default',
              __( 'Advanced', 'xstore' ) => 'type2',
            ),
          ),
          array(
            'type' => 'dropdown',
            'heading' => __('Hover effect', 'xstore'),
            'param_name' => 'hover',
            'value' => array (
              __('Disable', 'xstore') => 'disable',
              __('Swap', 'xstore') => 'swap',
              __('Slider', 'xstore') => 'slider'
            ),
          ),
        ),   
      );  
      vc_map($params);
  }
}