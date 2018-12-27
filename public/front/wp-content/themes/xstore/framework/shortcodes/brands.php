<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************//
// ! Brands
// **********************************************************************//

if ( !function_exists('etheme_brands_shortcode') ) {
    function etheme_brands_shortcode($atts) {
        if ( etheme_woocommerce_notice() ) return;
        
        extract( shortcode_atts( array(
            'number'     => 12,
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => 0,
            'columns' => 3,
            'parent'     => '',
            'ids'        => '',
            'large' => 4,
            'notebook' => 3,
            'tablet_land' => 2,
            'tablet_portrait' => 2,
            'mobile' => 1,
            'slider_autoplay' => false,
            'slider_speed' => 300,
            'slider_interval' => 1000,
            'slider_loop' => false,
            'pagination_type' => 'hide',
            'default_color' => '#e1e1e1',
            'active_color' => '#222',
            'hide_fo' => '',
            'hide_buttons' => false,
            'per_move' => 1,
            'class'      => ''
        ), $atts ) );

        // get terms and workaround WP bug with parents/pad counts

        if ( $orderby == 'ids_order') {
            $orderby = 'include';
        }

        $args = array(
            'orderby'    => $orderby,
            'order'      => $order,
            'pad_counts' => true,
            'include'    => $ids,
            'number' => $number,
            'hide_empty' => $hide_empty
        );

        $product_brands = get_terms( 'brand', $args );

        $box_id = rand(1000,10000);

        if ( $orderby == 'name' ){
            $product_brands = et_force_name_sort( $product_brands, $order );
        }

        ob_start();

        $lines = '';
        $loop = '';
        if ($pagination_type == 'lines'){
            $lines = 'swiper-pagination-lines';
        }

        if ( $slider_speed ) {
                $slider_speed = 'data-speed="'.$slider_speed.'"';
            } else {
                $slider_speed = '';
            }

            if ( $slider_autoplay ) {
                $slider_autoplay = $slider_interval;
            }

            if ($slider_loop) {
                $loop = ' data-loop="true"';
            }

        if ( is_array( $product_brands ) && count( $product_brands ) > 0 ) {
            echo '<div class="swiper-entry brands-carousel">';
                echo '<div class="brands-carousel-'.$box_id.' swiper-container '.$lines.'" data-breakpoints="1" data-xs-slides="'.esc_js($mobile).'" data-sm-slides="'.esc_js($tablet_land).'" data-md-slides="'.esc_js($notebook).'" data-lt-slides="'.esc_js($large).'" data-slides-per-view="'.esc_js($large).'" data-space="30" data-autoplay="'.esc_attr($slider_autoplay).'" '.$slider_speed.' '. $loop .' data-slides-per-group="'.esc_attr($per_move).'">
                <div class="swiper-wrapper"> ';
             foreach ( $product_brands as $brand ) {
                $thumbnail_id   = absint( get_woocommerce_term_meta( $brand->term_id, 'thumbnail_id', true ) );

                if ( $hide_empty && 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
                    $stock  = etheme_stock_taxonomy( $brand->term_id, 'brand' );
                    if ( $stock < 1 ) continue;
                }

                ?>
                    <div class="swiper-slide">
                        <div class="categories-mask">
                            <?php if( $thumbnail_id ) : ?>
                                <?php
                                    $image = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
                                    $src = $image[0];
                                ?>
                                <a href="<?php echo esc_url( get_term_link( $brand ) ); ?>" title="<?php sprintf(__('View all products from %s', 'xstore'), $brand->name); ?>">
                                    <img class="swiper-lazy" data-src="<?php echo esc_url($src); ?>" title="<?php echo esc_attr( $brand->name ); ?>"/>
                                    <?php etheme_loader(true, 'swiper-lazy-preloader'); ?>
                                </a>
                            <?php else: ?>
                                <h3><a href="<?php echo esc_url( get_term_link( $brand ) ); ?>" title="<?php sprintf(__('View all products from %s', 'xstore'), $brand->name); ?>"><?php echo esc_html($brand->name); ?></a></h3>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
            }
            echo '</div>';
                if ($pagination_type != "hide") { echo '<div class="swiper-pagination etheme-css" data-css=".brands-carousel-'.$box_id.' .swiper-pagination-bullet{background-color:'.$default_color.'; '. $lines.';} .brands-carousel-'.$box_id.' .swiper-pagination-bullet:hover{ background-color:'.$active_color.'; } .brands-carousel-'.$box_id.' .swiper-pagination-bullet-active{ background-color:'.$active_color.'; }"></div>'; }

            echo '</div>';
                if (!$hide_buttons) {
                    echo '
                        <div class="swiper-custom-left"></div>
                        <div class="swiper-custom-right"></div>
                    ';
                }
            echo '</div>';
        } else {
            echo '<p class="text-center">' . esc_html( 'No brands are available', 'xstore' ) . '<p>';
        }

        return ob_get_clean();
    }
}

// **********************************************************************//
// ! Register New Element: scslug
// **********************************************************************//
add_action( 'init', 'etheme_register_brands_categories');
if(!function_exists('etheme_register_brands_categories')) {
    function etheme_register_brands_categories() {
        if(!function_exists('vc_map') || ! etheme_get_option( 'enable_brands' )) return;
        add_filter( 'vc_autocomplete_etheme_brands_ids_callback', 'etheme_productBrandBrandAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
        add_filter( 'vc_autocomplete_etheme_brands_ids_render', 'etheme_productBrandBrandRenderByIdExact', 10, 1 ); // Render exact category by id. Must return an array (label,value)
        
        $order_by_values = array(
            '',
            esc_html__( 'As IDs provided order', 'xstore' ) => 'ids_order',
            esc_html__( 'ID', 'xstore' ) => 'ID',
            esc_html__( 'Title', 'xstore' ) => 'name',
            esc_html__( 'Quantity', 'xstore' ) => 'count',
        );

        $order_way_values = array(
            '',
            esc_html__( 'Descending', 'xstore' ) => 'DESC',
            esc_html__( 'Ascending', 'xstore' ) => 'ASC',
        );
        $params = array(
            'name' => '[8theme] Brands carousel',
            'base' => 'etheme_brands',
            'icon' => 'icon-wpb-etheme',
            'icon' => ETHEME_CODE_IMAGES . 'vc/el-categories.png',
            'category' => 'Eight Theme',
            'params' => array_merge(array(
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Number of brands", 'xstore'),
                    "param_name" => "number"
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
                  'type' => 'autocomplete',
                  'heading' => esc_html__( 'Brands', 'xstore' ),
                  'param_name' => 'ids',
                  'settings' => array(
                    'multiple' => true,
                    'sortable' => true,
                  ),
                  'save_always' => true,
                  'description' => esc_html__( 'List of product brands', 'xstore' ),
                ),
                array(
                    "type" => "checkbox",
                    "heading" => esc_html__("Hide empty brands", 'xstore'),
                    "param_name" => "hide_empty",
                    'value' => array( esc_html__( 'Yes, please', 'xstore' ) => 1 )
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

if( ! function_exists( 'etheme_productBrandBrandAutocompleteSuggester' ) ) {
    function etheme_productBrandBrandAutocompleteSuggester( $query, $slug = false ) {
        global $wpdb;
        $cat_id = (int) $query;
        $query = trim( $query );
        $post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
                        FROM {$wpdb->term_taxonomy} AS a
                        INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
                        WHERE a.taxonomy = 'brand' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

        $result = array();
        if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
            foreach ( $post_meta_infos as $value ) {
                $data = array();
                $data['value'] = $slug ? $value['slug'] : $value['id'];
                $data['label'] = __( 'Id', 'xstore' ) . ': ' . $value['id'] . ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'xstore' ) . ': ' . $value['name'] : '' ) . ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'xstore' ) . ': ' . $value['slug'] : '' );
                $result[] = $data;
            }
        }

        return $result;
    }
}

if( ! function_exists( 'etheme_productBrandBrandRenderByIdExact' ) ) {
    function etheme_productBrandBrandRenderByIdExact( $query ) {
            $query = $query['value'];
            $cat_id = (int) $query;
            $term = get_term( $cat_id, 'brand' );

            return etheme_productBrandTermOutput( $term );
    }
}

if( ! function_exists( 'etheme_productBrandTermOutput' ) ) {
    function etheme_productBrandTermOutput( $term ) {
        $term_slug = $term->slug;
        $term_title = $term->name;
        $term_id = $term->term_id;

        $term_slug_display = '';
        if ( ! empty( $term_slug ) ) {
            $term_slug_display = ' - ' . __( 'Sku', 'xstore' ) . ': ' . $term_slug;
        }

        $term_title_display = '';
        if ( ! empty( $term_title ) ) {
            $term_title_display = ' - ' . __( 'Title', 'xstore' ) . ': ' . $term_title;
        }

        $term_id_display = __( 'Id', 'xstore' ) . ': ' . $term_id;

        $data = array();
        $data['value'] = $term_id;
        $data['label'] = $term_id_display . $term_title_display . $term_slug_display;

        return ! empty( $data ) ? $data : false;
    }
}

