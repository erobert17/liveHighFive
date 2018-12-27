<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************// 
// ! products of category
// **********************************************************************// 

if ( ! function_exists('etheme_category_shortcode') ) {
    function etheme_category_shortcode($atts) {
        if ( etheme_woocommerce_notice() ) return;
        
        global $wpdb;
        if ( !class_exists('Woocommerce') ) return false;

        extract(shortcode_atts(array(
            'taxonomies' => '',
            'products_type' => '', //featured new sale bestsellings recently_viewed
            'hide_out_stock' => false,
            'orderby' => '',
            'order' => 'ASC',
            'custom' => false,
            'fp_id' => '',
            'sp_id' => '',
            'tp_id' => '',
            'title_color' => '',
            'head_bg' => '',
            'content_bg' => '',
            'radius' => '',
            'sep_color' => '',
            'b_width' => '',
            'b_style' => '',
            'b_color' => ''
        ), $atts));

        $box_id = rand(999, 9999);

        $style = '<style>';
            if ( ! empty($title_color) ) {
                $style .= '.categories-products-'.$box_id.' .category-title h4 a{';
                $style .= 'color:'.$title_color;
                $style .= '}';
            }
            if ( ! empty($head_bg) ) {
                $style .= '.categories-products-'.$box_id.' .category-title{';
                $style .= 'background-color:'.$head_bg.';';
                $style .= '}';
                $style .= '.categories-products-'.$box_id.' .show-products a{';
                $style .= 'color:'.$head_bg.';';
                $style .= 'border-bottom-color:'.$head_bg.';';
                $style .= '}';
            }
                $style .= '.categories-products-'.$box_id.'{';
                if ( ! empty($content_bg) )  $style .= 'background-color:'.$content_bg.';';
                if ( ! empty($radius) ) $style .= 'border-radius:'.$radius.';';
                if ( ! empty($b_width) ) $style .= 'border-width:'.$b_width.';';
                if ( ! empty($b_style) ) $style .= 'border-style:'.$b_style.';';
                if ( ! empty($b_color) ) $style .= 'border-color:'.$b_color.';';
                if ( ! empty($b_color) || !empty($b_style)|| !empty($b_width) ) $style .= 'box-shadow: unset;';
                $style .= '}';

            if ( !empty($sep_color) ) {
                 $style .= '.categories-products-'.$box_id.' .top-products{';
                 $style .= 'border-bottom-color:'.$sep_color.';';
                 $style .= '}';
            }

        $style .= '</style>';


        // Narrow by categories

        $first_product = $second_product = $third_product = '';
        $terms = '';
        $cat_name = esc_html__('Products', 'xstore');
        $cat_link = get_permalink(wc_get_page_id('shop'));
        $args = array(
            'post_type'             => 'product',
            'ignore_sticky_posts'   => 1,
            'no_found_rows'         => 1,
            'posts_per_page'        => 3,
            'orderby'               => $orderby,
            'order'                 => $order,
        );

        if ($hide_out_stock) {
            $args['meta_query'] = array(
                array (
                'key' => '_stock_status',
                'value' => 'instock',
                'compare' => '='
                ),
            );
        }

        $args['tax_query'][] = array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'hidden',
            'operator' => 'NOT IN',
        );

        if ( $products_type == 'featured' ) {
          $args['tax_query'][] = array(
              'taxonomy' => 'product_visibility',
              'field'    => 'name',
              'terms'    => 'featured',
              'operator' => 'IN',
          );
        }

        if ($products_type == 'sale') {
            $product_ids_on_sale = wc_get_product_ids_on_sale();
            $args['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
        }

        if ($orderby == 'price') {
            $args['meta_key'] = '_price';
            $args['orderby'] = 'meta_value_num';
        }

        if ($products_type == 'bestsellings') {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
        }

        if ($products_type == 'recently_viewed') {
            $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
            $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

            if ( empty( $viewed_products ) )
                return;
            $args['post__in'] = $viewed_products;
            $args['orderby'] = 'rand';
        }

        if( ! empty( $taxonomies ) ) {
            $taxonomy_names = get_object_taxonomies( 'product' );
            $terms = get_terms( $taxonomy_names, array(
                'orderby' => 'name',
                'include' => $taxonomies
            ));

            if( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
                $args['posts_per_page'] = 3;
                $args['tax_query'] = array('relation' => 'OR');
                foreach ($terms as $key => $term) {
                    $args['tax_query'][] = array(
                        'taxonomy' => $term->taxonomy,
                        'field' => 'slug',
                        'terms' => array( $term->slug ),
                        'include_children' => true,
                        'operator' => 'IN'
                    );
                }
                $cat_name = (isset($terms[0]->name) && $terms[0]->name != '') ? $terms[0]->name : $cat_name;
                $cat_link = get_term_link( $terms[0]->term_id, 'product_cat' );
            }
        } ?>

        <?php // fp_id = first product id
        if ( $fp_id != '' && $sp_id != '' && $tp_id != '') {
    
            $fp = wc_get_product($fp_id); // first product object
            $sp = wc_get_product($sp_id); // second product object
            $tp = wc_get_product($tp_id); // third product object

            if ( is_object($fp) ) {
                $f_title = $fp->get_title();
                $fp_link = get_permalink($fp_id);
                if ( has_post_thumbnail( $fp_id ) ) {
                    $thumbnail_id = get_post_thumbnail_id( $fp_id );
                    // Permalink to product
                    // Image of product 
                    $full_size_image   = wp_get_attachment_image_src( $thumbnail_id, 'full' );
                    $attributes = array(
                        'title'                   => get_post_field( 'post_title', $thumbnail_id ),
                        'data-caption'            => get_post_field( 'post_excerpt', $thumbnail_id ),
                        'data-src'                => $full_size_image[0],
                        'data-large_image'        => $full_size_image[0],
                        'data-large_image_width'  => $full_size_image[1],
                        'data-large_image_height' => $full_size_image[2],
                    );
                    $f_img = get_the_post_thumbnail( $fp_id, 'shop_catalog', $attributes );
                }
                else {
                    $f_img = wc_placeholder_img();
                }
                
            }

            if ( is_object($sp) ) {
                $s_title = $sp->get_title();
                $sp_link = get_permalink($sp_id);
                if ( has_post_thumbnail( $sp_id ) ) {
                    $thumbnail_id = get_post_thumbnail_id( $sp_id );
                    // Permalink to product
                    // Image of product 
                    $full_size_image   = wp_get_attachment_image_src( $thumbnail_id, 'full' );
                    $attributes = array(
                        'title'                   => get_post_field( 'post_title', $thumbnail_id ),
                        'data-caption'            => get_post_field( 'post_excerpt', $thumbnail_id ),
                        'data-src'                => $full_size_image[0],
                        'data-large_image'        => $full_size_image[0],
                        'data-large_image_width'  => $full_size_image[1],
                        'data-large_image_height' => $full_size_image[2],
                    );
                    $s_img = get_the_post_thumbnail( $sp_id, 'shop_catalog', $attributes );
                }
                else {
                    $s_img = wc_placeholder_img();
                }
            }

            if ( is_object($tp) ) {
                $t_title = $tp->get_title();
                $sp_link = get_permalink($sp_id);
                if ( has_post_thumbnail( $tp_id ) ) {
                    $thumbnail_id = get_post_thumbnail_id( $tp_id );
                    // Permalink to product
                    // Image of product 
                    $full_size_image   = wp_get_attachment_image_src( $thumbnail_id, 'full' );
                    $attributes = array(
                        'title'                   => get_post_field( 'post_title', $thumbnail_id ),
                        'data-caption'            => get_post_field( 'post_excerpt', $thumbnail_id ),
                        'data-src'                => $full_size_image[0],
                        'data-large_image'        => $full_size_image[0],
                        'data-large_image_width'  => $full_size_image[1],
                        'data-large_image_height' => $full_size_image[2],
                    );
                    $t_img = get_the_post_thumbnail( $tp_id, 'shop_catalog', $attributes );
                }
                else {
                    $t_img = wc_placeholder_img();
                }
            }
        }
        elseif ( !empty($taxonomies) ) {

            $products = new WP_Query( $args );

            $_i = 0;

            if ( $products->have_posts() ) : ?>

                    <?php while ( $products->have_posts() ) : $products->the_post();  
                        $id = get_the_ID(); 

                        if ( $_i == 0 ) {
                            $f_title = get_the_title();
                            $fp_link = get_permalink($id);
                            if ( has_post_thumbnail( $id ) ) {
                                $thumbnail_id = get_post_thumbnail_id( $id );
                                $full_size_image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
                                $attributes = array(
                                    'title'                   => get_post_field( 'post_title', $thumbnail_id ),
                                    'data-caption'            => get_post_field( 'post_excerpt', $thumbnail_id ),
                                    'data-src'                => $full_size_image[0],
                                    'data-large_image'        => $full_size_image[0],
                                    'data-large_image_width'  => $full_size_image[1],
                                    'data-large_image_height' => $full_size_image[2],
                                );
                                $f_img = get_the_post_thumbnail( $id, 'shop_catalog', $attributes );
                            }
                            else {
                                $f_img = wc_placeholder_img();
                            }
                        }
                        elseif ( $_i == 1 ) {
                            $s_title = get_the_title();
                            $sp_link = get_permalink($id);
                            if ( has_post_thumbnail( $id ) ) {
                                $thumbnail_id = get_post_thumbnail_id( $id );
                                $full_size_image = wp_get_attachment_image_src( $thumbnail_id );
                                $attributes = array(
                                    'title'                   => get_post_field( 'post_title', $thumbnail_id ),
                                    'data-caption'            => get_post_field( 'post_excerpt', $thumbnail_id ),
                                    'data-src'                => $full_size_image[0],
                                    'data-large_image'        => $full_size_image[0],
                                    'data-large_image_width'  => $full_size_image[1],
                                    'data-large_image_height' => $full_size_image[2],
                                );
                                $s_img = get_the_post_thumbnail( $id, 'shop_catalog', $attributes );
                            }
                            else {
                                $s_img = wc_placeholder_img();
                            }
                        } 
                        else {
                            $t_title = get_the_title();
                            $tp_link = get_permalink($id);
                            if ( has_post_thumbnail( $id ) ) {
                                $thumbnail_id = get_post_thumbnail_id( $id );
                                $full_size_image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
                                $attributes = array(
                                    'title'                   => get_post_field( 'post_title', $thumbnail_id ),
                                    'data-caption'            => get_post_field( 'post_excerpt', $thumbnail_id ),
                                    'data-src'                => $full_size_image[0],
                                    'data-large_image'        => $full_size_image[0],
                                    'data-large_image_width'  => $full_size_image[1],
                                    'data-large_image_height' => $full_size_image[2],
                                );
                                $t_img = get_the_post_thumbnail( $id, 'shop_catalog', $attributes );
                            }
                            else {
                                $t_img = wc_placeholder_img();
                            }
                        } ?>

                        <?php $_i++; ?>

                    <?php endwhile; // end of the loop. ?>

            <?php endif;

            wp_reset_postdata();

        } else {
            return;
        } ?>

        <?php ob_start(); ?>
        <div class="categories-products-two-rows categories-products-<?php echo esc_attr($box_id); ?>">
            <div class="category-title">
                <h4><a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a></h4>
            </div>
        <div class="products-group">
            <div class="top-products">
                <div class="top-product">
                    <div class="content-product">
                        <div class="product-image-wrapper">
                            <a href="<?php echo esc_url($fp_link); ?>" class="product-content-image">
                                <?php echo wp_specialchars_decode($f_img); ?>
                            </a>
                        </div>
                        <p class="product-title"><a href="<?php echo esc_url($fp_link); ?>"><?php echo esc_html($f_title); ?></a></p>
                    </div>
                </div>
                <div class="top-product">
                    <div class="content-product">
                        <div class="product-image-wrapper">
                            <a href="<?php echo esc_url($sp_link); ?>" class="product-content-image">
                                <?php echo wp_specialchars_decode($s_img); ?>
                            </a>
                        </div>
                        <p class="product-title"><a href="<?php echo esc_url($sp_link); ?>"><?php echo esc_html($s_title); ?></a></p>
                    </div>
                </div>
            </div>
            <div class="bottom-product">
                <div class="content-product">
                    <div class="product-image-wrapper">
                        <a href="<?php echo esc_url($tp_link); ?>" class="product-content-image">
                           <?php echo wp_specialchars_decode($t_img); ?>
                        </a>
                    </div>
                    <p class="product-title"><a href="<?php echo esc_url($tp_link); ?>"><?php echo esc_html($t_title);?></a></p>
                </div>
            </div>
        </div>

        <div class="show-products">
            <a href="<?php echo esc_url($cat_link); ?>" class="read-more"><?php esc_html_e('See all', 'xstore'); ?></a>
        </div>
        </div>

        <?php echo wp_specialchars_decode($style); ?>

        <?php $output = ob_get_contents();
        ob_end_clean();
        return $output; ?>

    <?php }
}


add_action( 'init', 'etheme_register_vc_category');
if(!function_exists('etheme_register_vc_category')) {
    function etheme_register_vc_category() {
        if(!function_exists('vc_map')) return;

        // Necessary hooks for blog autocomplete fields
        add_filter( 'vc_autocomplete_et_category_fp_id_callback', 'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
        add_filter( 'vc_autocomplete_et_category_fp_id_render', 'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
        add_filter( 'vc_autocomplete_et_category_sp_id_callback', 'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
        add_filter( 'vc_autocomplete_et_category_sp_id_render', 'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
        add_filter( 'vc_autocomplete_et_category_tp_id_callback', 'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
        add_filter( 'vc_autocomplete_et_category_tp_id_render', 'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

        if( class_exists('Vc_Vendor_Woocommerce')) {
            $Vc_Vendor_Woocommerce = new Vc_Vendor_Woocommerce();
            add_filter( 'vc_autocomplete_et_category_taxonomies_callback', array($Vc_Vendor_Woocommerce, 'productCategoryCategoryAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_et_category_taxonomies_render', array($Vc_Vendor_Woocommerce, 'productCategoryCategoryRenderByIdExact',), 10, 1 ); // Render exact category by id. Must return an array (label,value)
        }

        $order_by_values = array(
            '',
            esc_html__( 'Date', 'xstore' ) => 'date',
            esc_html__( 'ID', 'xstore' ) => 'ID',
            esc_html__( 'Author', 'xstore' ) => 'author',
            esc_html__( 'Title', 'xstore' ) => 'title',
            esc_html__( 'Modified', 'xstore' ) => 'modified',
            esc_html__( 'Random', 'xstore' ) => 'rand',
            esc_html__( 'Comment count', 'xstore' ) => 'comment_count',
            esc_html__( 'Menu order', 'xstore' ) => 'menu_order',
            esc_html__( 'Price', 'xstore' ) => 'price',

        );

        $order_way_values = array(
            '',
            esc_html__( 'Descending', 'xstore' ) => 'DESC',
            esc_html__( 'Ascending', 'xstore' ) => 'ASC',
        );

        $params = array(
            'name' => '[8THEME] Products of category',
            'base' => 'et_category',
            'icon' => 'icon-wpb-etheme',
            'icon' => ETHEME_CODE_IMAGES . 'vc/el-product.png',
            'category' => 'Eight Theme',
            'params' => array(
                array(
                    'type' => 'autocomplete',
                    'heading' => esc_html__( 'Categories or tags', 'xstore' ),
                    'param_name' => 'taxonomies',
                    'settings' => array(
                        'multiple' => true,
                        // is multiple values allowed? default false
                        // 'sortable' => true, // is values are sortable? default false
                        'min_length' => 1,
                        // min length to start search -> default 2
                        // 'no_hide' => true, // In UI after select doesn't hide an select list, default false
                        'groups' => true,
                        // In UI show results grouped by groups, default false
                        'unique_values' => true,
                        // In UI show results except selected. NB! You should manually check values in backend, default false
                        'display_inline' => true,
                        // In UI show results inline view, default false (each value in own line)
                        'delay' => 500,
                        // delay for search. default 500
                        'auto_focus' => true,
                        // auto focus input, default true
                    ),
                    'description' => esc_html__( 'Enter one category, tag or custom taxonomy.', 'xstore' ),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Products type", 'xstore'),
                    "param_name" => "products_type",
                    "value" => array( esc_html__("All", 'xstore') => '', esc_html__("Featured", 'xstore') => 'featured', esc_html__("Sale", 'xstore') => 'sale', esc_html__("Recently viewed", 'xstore') => 'recently_viewed', esc_html__("Bestsellings", 'xstore') => 'bestsellings'),
                    "dependency" => array('element' => 'custom', 'value_not_equal_to' => 'true')
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Order by', 'xstore' ),
                    'param_name' => 'orderby',
                    'value' => $order_by_values,
                    'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'xstore' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
                    "dependency" => array('element' => 'custom', 'value_not_equal_to' => 'true')
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Order way', 'xstore' ),
                    'param_name' => 'order',
                    'value' => $order_way_values,
                    'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'xstore' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
                    "dependency" => array('element' => 'custom', 'value_not_equal_to' => 'true')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Hide out of stock products", 'xstore'),
                    "param_name" => "hide_out_stock",
                    "value" => array(
                        "",
                        'Yes' => 'yes',
                    ),
                    "dependency" => array('element' => 'custom', 'value_not_equal_to' => 'true')
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__('Select custom products', 'xstore'),
                    'param_name' => 'custom',
                    'description' => esc_html__('Select custom products, if not then products will be gotten randomly', 'xstore'),
                    'default' => false
                ),
                array(
                    'type' => 'autocomplete',
                    'heading' => esc_html__( 'First Product', 'xstore' ),
                    'param_name' => 'fp_id',
                    'settings' => array(
                        'multiple' => true,
                        'sortable' => true,
                        'groups' => true,
                    ),
                    'description' => esc_html__( 'Add product by title.', 'xstore' ),
                    'dependency' => array('element' => 'custom', 'value' => 'true')
                ),
                array(
                    'type' => 'autocomplete',
                    'heading' => esc_html__( 'Second Product', 'xstore' ),
                    'param_name' => 'sp_id',
                    'settings' => array(
                        'multiple' => true,
                        'sortable' => true,
                        'groups' => true,
                    ),
                    'description' => esc_html__( 'Add product by title.', 'xstore' ),
                    'dependency' => array('element' => 'custom', 'value' => 'true')
                ),
                array(
                    'type' => 'autocomplete',
                    'heading' => esc_html__( 'Third Product', 'xstore' ),
                    'param_name' => 'tp_id',
                    'settings' => array(
                        'multiple' => true,
                        'sortable' => true,
                        'groups' => true,
                    ),
                    'description' => esc_html__( 'Add product by title.', 'xstore' ),
                    'dependency' => array('element' => 'custom', 'value' => 'true')
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Title color', 'xstore'),
                    'param_name' => 'title_color',
                    'group' => 'Style'
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Title background color', 'xstore'),
                    'param_name' => 'head_bg',
                    'group' => 'Style'
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Element background color', 'xstore'),
                    'param_name' => 'content_bg',
                    'group' => 'Style'
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Divider color', 'xstore'),
                    'param_name' => 'sep_color',
                    'group' => 'Style'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Element border radius', 'xstore'),
                    'param_name' => 'radius',
                    'group' => 'Style',
                    'edit_field_class' => 'vc_col-sm-3 vc_column',
                ),
                array (
                    'type' => 'textfield',
                    'heading' => esc_html__('Element border width', 'xstore'),
                    'param_name' => 'b_width',
                    'group' => 'Style',
                    'edit_field_class' => 'vc_col-sm-3 vc_column',
                ),
                array (
                    'type' => 'dropdown',
                    'heading' => esc_html__('Element border style', 'xstore'),
                    'param_name' => 'b_style',
                    'value' => array(
                        '' => __('Unset', 'xstore'),
                        'solid' => __('Solid', 'xstore'),
                        'dashed' => __('Dashed', 'xstore'),
                        'dotted' => __('Dotted', 'xstore'),
                        'double' => __('Double', 'xstore'),
                        'groove' => __('Groove', 'xstore'),
                        'ridge' => __('Ridge', 'xstore'),
                        'inset' => __('Inset', 'xstore'),
                        'outset' => __('Outset', 'xstore'),
                    ),
                    'group' => 'Style',
                    'edit_field_class' => 'vc_col-sm-3 vc_column',
                ),
                array (
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Element border color', 'xstore'),
                    'param_name' => 'b_color',
                    'group' => 'Style',
                    'edit_field_class' => 'vc_col-sm-3 vc_column',
                ),
            ),
        );

        vc_map($params);
    }

}