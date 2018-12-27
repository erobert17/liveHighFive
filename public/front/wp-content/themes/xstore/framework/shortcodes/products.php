<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************// 
// ! products
// **********************************************************************// 

if ( ! function_exists('etheme_products_shortcode') ) {
    function etheme_products_shortcode($atts, $content) {
        if ( etheme_woocommerce_notice() ) return;
        
        global $wpdb, $woocommerce_loop;
        if ( !class_exists('Woocommerce') ) return false;

        $from_first = $class = '';

        extract(shortcode_atts(array(
            'ids' => '',
            'columns' => 4,
            'shop_link' => 1,
            'limit' => 20,
            'taxonomies' => '',
            'block_id' => false,
            'hover' => '',
            'type' => 'slider',
            'navigation' => 'off',
            'first_loaded' => 4,
            'style' => 'default',
            'show_counter' => false,
            'from_first' => '',
            'products' => '', //featured new sale bestsellings recently_viewed
            'title' => '',
            'hide_out_stock' => false,
            'large' => 4,
            'notebook' => 3,
            'tablet_land' => 2,
            'tablet_portrait' => 2,
            'mobile' => 1,
            'slider_autoplay' => false,
            'slider_interval' => 1000,
            'slider_speed' => 300,
            'slider_loop' => false,
            'pagination_type' => 'hide',
            'default_color' => '#e1e1e1',
            'active_color' => '#222',
            'hide_fo' => '',
            'hide_buttons' => false,
            'size' => 'shop_catalog',
            'orderby' => '',
            'no_spacing' => '',
            'order' => 'ASC',
            'product_view' => '',
            'product_view_color' => '',
            'product_img_hover' => '',
            'custom_template' => '',
            'per_move' => 1,
            'autoheight' => false,
            'ajax' => false,
            'css' => ''
        ), $atts));

        if ( $ajax && $navigation != 'lazy' ) {
            if ( $type )  $extra = 'slider';
            return et_ajax_element_holder( 'etheme_products', $atts, $extra );
        }

        $args = array(
            'post_type'             => 'product',
            'ignore_sticky_posts'   => 1,
            'no_found_rows'         => 1,
            'posts_per_page'        => $limit,
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

        if ( $products == 'featured' ) {
          $args['tax_query'][] = array(
              'taxonomy' => 'product_visibility',
              'field'    => 'name',
              'terms'    => 'featured',
              'operator' => 'IN',
          );
        }

        if( ! empty($css) && function_exists( 'vc_shortcode_custom_css_class' )) {
            $class .= ' ' . vc_shortcode_custom_css_class( $css );
        }

        $woocommerce_loop['hover'] = $hover;

        if ($products == 'sale') {
            $product_ids_on_sale = wc_get_product_ids_on_sale();
            $args['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
        }

        if ($orderby == 'price') {
            $args['meta_key'] = '_price';
            $args['orderby'] = 'meta_value_num';
        }

        if ($products == 'bestsellings') {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
        }

        if ($products == 'recently_viewed') {
            $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
            $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

            if ( empty( $viewed_products ) )
                return;
            $args['post__in'] = $viewed_products;
            $args['orderby'] = 'rand';
        }

        if($ids != ''){
            $ids = explode(',', $atts['ids']);
            $ids = array_map('trim', $ids);
            $args['post__in'] = $ids;
        }

        // Narrow by categories
        if( ! empty( $taxonomies ) ) {
            $taxonomy_names = get_object_taxonomies( 'product' );
            $terms = get_terms( $taxonomy_names, array(
                'orderby' => 'name',
                'include' => $taxonomies
            ));

            if( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
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
            }
        }

        $woocommerce_loop['product_view'] = $product_view;
        $woocommerce_loop['product_view_color'] = $product_view_color;
        $woocommerce_loop['hover'] = $product_img_hover;
        $woocommerce_loop['show_counter'] = $show_counter;
        if ( !empty($custom_template) ) $woocommerce_loop['custom_template'] = $custom_template;
        ob_start();
        if ($type == 'slider') {
            $slider_args = array(
                'title' => $title,
                'shop_link' => $shop_link,
                'slider_type' => false,
                'style' => $style,
                'no_spacing' => $no_spacing,
                'large' => $large,
                'notebook' => $notebook,
                'tablet_land' => $tablet_land,
                'tablet_portrait' => $tablet_portrait,
                'mobile' => $mobile,
                'slider_autoplay' => $slider_autoplay,
                'slider_interval' => $slider_interval,
                'slider_speed' => $slider_speed,
                'slider_loop' => $slider_loop,
                'pagination_type' => $pagination_type,
                'default_color' => $default_color,
                'active_color' => $active_color,
                'hide_buttons' => $hide_buttons,
                'hide_fo' => $hide_fo,
                'per_move' => $per_move,
                'autoheight' => $autoheight,
                'class' => ( !empty($custom_template) ) ? 'products-with-custom-template products-template-'.$custom_template. $class : $class,
                'attr' => ( !empty($custom_template) ) ? 'data-post-id="'.$custom_template.'"' : '',
                'echo' => true
            );
            etheme_slider( $args, 'product', $slider_args );
        } elseif($type == 'full-screen') {
            $slider_args = array(
                'title' => $title,
                'size' => $size,
                'class' => $class
            );
            echo etheme_fullscreen_products($args, $slider_args);
        } else {

            // ! Add attr for lazy loading
            $attr = '';
            $extra = array();
            $extra['navigation'] = $navigation;
            if ( $navigation != 'off' ) {
                if ( isset( $args['post__in'] ) ) $attr .= ' ids="' . implode( ",", $args['post__in'] ) . '"';
                if ( isset( $args['orderby'] ) ) $attr .= ' orderby="' . $args['orderby'] . '"';
                if ( isset( $args['order'] ) ) $attr .= ' order="' . $args['order'] . '"';
                if ( $hide_out_stock ) $attr .= ' stock="true"';
                if ( $products ) $attr .= ' type="' . $products . '"';
                if ( ! empty( $taxonomies ) ) $attr .= ' taxonomies="' . $taxonomies . '"';
                if ( $first_loaded > $limit ) $first_loaded = $limit;

                $extra['per-page'] = ( $limit != -1 && $limit < $columns ) ? $limit : $columns;
                $extra['limit'] = $limit;
                $extra['columns'] = $columns;

                $attr .= ' columns="' . $columns . '"';
                $attr .= ' per-page="' . $extra['per-page'] . '"';
            }

            // ! Add attr for lazy loading end.

            $woocommerce_loop['view_mode'] = $type;
            echo '<div class="etheme_products ' . $class . '"' . $attr . '>';
                echo etheme_products( $args, $title, $columns, $extra );
            echo '</div>';
            unset($woocommerce_loop['view_mode']);
        }

        unset($woocommerce_loop['product_view']);
        unset($woocommerce_loop['product_view_color']);
        unset($woocommerce_loop['hover']);
        unset($woocommerce_loop['show_counter']);
        if ( !empty($custom_template) ) unset($woocommerce_loop['custom_template']);

        return ob_get_clean();
    }
}

// **********************************************************************//
// ! Register New Element: products
// **********************************************************************//
add_action( 'init', 'etheme_register_vc_products');
if(!function_exists('etheme_register_vc_products')) {
    function etheme_register_vc_products() {
        if(!function_exists('vc_map')) return;
        // Necessary hooks for blog autocomplete fields
        add_filter( 'vc_autocomplete_etheme_products_ids_callback', 'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
        add_filter( 'vc_autocomplete_etheme_products_ids_render', 'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

        $order_by_values = array(
            '',
            esc_html__( 'Date', 'xstore' ) => 'date',
            esc_html__( 'ID', 'xstore' ) => 'ID',
            esc_html__( 'As IDs provided order', 'xstore' ) => 'post__in',
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

        $static_blocks = array('--choose--' => '');

        foreach(etheme_get_static_blocks() as $value) {
            $static_blocks[$value['label']] = $value['value'];
        }

        $content_product_args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'category'         => '',
            'category_name'    => '',
            'orderby'          => 'date',
            'order'            => 'DESC',
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'vc_grid_item',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'author'       => '',
            'author_name'      => '',
            'post_status'      => 'publish',
            'suppress_filters' => true 
        );

        $content_product_args = get_posts( $content_product_args );
        $product_templates = array();
        foreach ($content_product_args as $key) {
            $product_templates[$key->post_title] = $key->ID;
        }

        $params = array(
            'name' => '[8THEME] Products',
            'base' => 'etheme_products',
            'icon' => 'icon-wpb-etheme',
            'icon' => ETHEME_CODE_IMAGES . 'vc/el-product.png',
            'category' => 'Eight Theme',
            'params' => array_merge(array(
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Title", 'xstore'),
                    "param_name" => "title"
                ),
                array(
                    'type' => 'autocomplete',
                    'heading' => esc_html__( 'Product IDs', 'xstore' ),
                    'param_name' => 'ids',
                    'settings' => array(
                        'multiple' => true,
                        'sortable' => true,
                        'groups' => true,
                    ),
                    'save_always' => true,
                    'description' => esc_html__( 'Add products by title.', 'xstore' ),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Display Type", 'xstore'),
                    "param_name" => "type",
                    "value" => array(
                        esc_html__("Slider", 'xstore') => 'slider',
                        esc_html__("Grid", 'xstore') => 'grid',
                        esc_html__("List", 'xstore') => 'list',
                        esc_html__("Full screen", 'xstore') => 'full-screen',
                    )
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Navigation", 'xstore'),
                    "param_name" => "navigation",
                    "dependency" => array( 'element' => "type", 'value' => array( 'grid' ) ),
                    "value" => array(
                        esc_html__( "Off", 'xstore' ) => 'off',
                        esc_html__( "Load More button", 'xstore' ) => 'btn',
                        esc_html__( "Lazy loading", 'xstore' ) => 'lazy',
                    )
                ),

                
                // array(
                //     "type" => "textfield",
                //     "heading" => esc_html__("First loaded", 'xstore'),
                //     "param_name" => "first_loaded",
                //     "description" => sprintf( esc_html__( 'Quantity of first loaded products (can not be more than limit param)', 'xstore' ) ),
                //     "dependency" => array( 'element' => "navigation", 'value' => array( 'button' ) ),
                // ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Images size", 'xstore'),
                    "param_name" => "size",
                    "dependency" => array('element' => "type", 'value' => array('full-width')),
                    "value" => array(
                        "",
                        esc_html__('Catalog image size', 'xstore') => 'shop_catalog',
                        esc_html__('Single product image size', 'xstore') => 'shop_single',
                    )
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Remove space between slides", 'xstore'),
                    "param_name" => "no_spacing",
                    "dependency" => array('element' => "type", 'value' => array('slider')),
                    "value" => array(
                        "",
                        'Yes' => 'yes',
                    )
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Columns", 'xstore'),
                    "param_name" => "columns",
                    "dependency" => array('element' => "type", 'value' => array('grid', 'list')),
                    "value" => array(
                        "",
                        1,
                        2,
                        3,
                        4,
                        5,
                        6
                    )
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Product View", 'xstore'),
                    "param_name" => "product_view",
                    "dependency" => array('element' => "type", 'value' => array('grid', 'list', 'slider')),
                    "value" => array( "",
                        'Inherit' => '',
                        'Default' => 'default',
                        'Buttons on hover middle ' => 'mask3',
                        'Buttons on hover bottom' => 'mask',
                        'Buttons on hover right' => 'mask2',
                        'Information mask' => 'info',
                        'Booking' => 'booking',
                        'Light'   => 'light',
                        'Custom' => 'custom',
                        'Disable' => 'Disable',
                    )
                ),
                array (
                    'type' => 'dropdown',
                    'heading' => esc_html__('Custom product templates', 'xstore'),
                    'param_name' => 'custom_template',
                    'dependency' => array('element' => 'product_view', 'value' => array('custom')),
                    'value' => $product_templates
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Product View Color", 'xstore'),
                    "param_name" => "product_view_color",
                    "dependency" => array('element' => "type", 'value' => array('grid', 'list', 'slider')),
                    "value" => array( "",
                        'White' => 'white',
                        'Dark' => 'dark',
                    )
                ),
                array (
                    'type' => 'dropdown',
                    'param_name' => 'product_img_hover',
                    'heading' => __( 'Image hover effect', 'xstore' ),
                    'value' => array (
                        __( 'Disable', 'xstore' ) => 'disable',
                        __( 'Swap', 'xstore' ) => 'swap',
                        __( 'Images Slider', 'xstore' ) => 'slider',
                    ),
                    'dependency' => array ("element" => "product_view", "value_not_equal_to" => "custom")
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Product layout for this slider", 'xstore'),
                    "param_name" => "style",
                    "dependency" => Array('element' => "type", 'value' => array('slider')),
                    "value" => array( esc_html__("Default", 'xstore') => 'default', esc_html__("Advanced", 'xstore') => 'advanced')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Products type", 'xstore'),
                    "param_name" => "products",
                    "value" => array( esc_html__("All", 'xstore') => '', esc_html__("Featured", 'xstore') => 'featured', esc_html__("Sale", 'xstore') => 'sale', esc_html__("Recently viewed", 'xstore') => 'recently_viewed', esc_html__("Bestsellings", 'xstore') => 'bestsellings')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show sale counter", 'xstore'),
                    "param_name" => "show_counter",
                    "value" => array(
                        "",
                        'Yes' => 'yes',
                    )
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Order by', 'xstore' ),
                    'param_name' => 'orderby',
                    'value' => $order_by_values,
                    'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'xstore' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Order way', 'xstore' ),
                    'param_name' => 'order',
                    'value' => $order_way_values,
                    'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'xstore' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Hide out of stock products", 'xstore'),
                    "param_name" => "hide_out_stock",
                    "value" => array(
                        "",
                        'Yes' => 'yes',
                    )
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Limit", 'xstore'),
                    "param_name" => "limit",
                    "description" => sprintf( esc_html__( 'Use "-1" to show all products.', 'xstore' ) )
                ),
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
                    'param_holder_class' => 'vc_not-for-custom',
                    'description' => esc_html__( 'Enter categories, tags or custom taxonomies.', 'xstore' ),
                ),
                    array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Lazy loading for this element', 'xstore' ),
                    'param_name' => 'ajax',
                    //'dependency' => array( 'element' => "navigation", 'value' => array( 'off', 'btn', 'lazy' ) ),
                    'value' => array(
                        __( 'Yes', 'xstore' ) => 1,
                    ),
                ),
            ), etheme_get_slider_params(),
            array(
                array(
                  'type' => 'css_editor',
                  'heading' => esc_html__( 'CSS box', 'xstore' ),
                  'param_name' => 'css',
                  'group' => esc_html__( 'Design', 'xstore' )
                ),
            )
            ),
        );

        vc_map($params);
    }
    // Necessary hooks for blog autocomplete fields
    add_filter( 'vc_autocomplete_etheme_products_include_callback', 'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
    add_filter( 'vc_autocomplete_etheme_products_include_render',
        'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

    // Narrow data taxonomies
    add_filter( 'vc_autocomplete_etheme_products_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
    add_filter( 'vc_autocomplete_etheme_products_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

    // Narrow data taxonomies for exclude_filter
    add_filter( 'vc_autocomplete_etheme_products_exclude_filter_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
    add_filter( 'vc_autocomplete_etheme_products_exclude_filter_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

    add_filter( 'vc_autocomplete_etheme_products_exclude_callback', 'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
    add_filter( 'vc_autocomplete_etheme_products_exclude_render', 'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
}