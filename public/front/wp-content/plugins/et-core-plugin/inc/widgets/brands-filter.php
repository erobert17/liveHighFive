<?php
/**
 * Layered nav widget
 *
 * @package WooCommerce/Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if( ! class_exists( 'WC_Widget' ) ) return;

/**
 * Layered Navigation Widget.
 *
 * @author   WooThemes
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.6.0
 * @extends  WC_Widget
 */
class ETheme_Brands_Filter_Widget extends WC_Widget {

    /**
     * Constructor.
     */
    public function __construct() {
        $this->widget_cssclass    = 'sidebar-widget etheme-brands-filter';
        $this->widget_description = __( 'Widget to filtering products by brands', 'xstore' );
        $this->widget_id          = 'etheme_brands_filter';
        $this->widget_name        = '8theme - ' . __( 'Filter Products by Brands', 'xstore' );
        $this->settings           = array(
            'title' => array(
                'type'  => 'text',
                'std'   => __( 'Title', 'xstore' ),
                'label' => __( 'Title', 'xstore' ),
            ),
            'display_type' => array(
                'type'    => 'select',
                'std'     => 'list',
                'label'   => __( 'Display type', 'xstore' ),
                'options' => array(
                    'list'     => __( 'List', 'xstore' ),
                    'dropdown' => __( 'Dropdown', 'xstore' ),
                ),
            ),
            'count' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Show product counts', 'xstore' )
            ),
            'hide_empty' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Hide empty brands', 'xstore' )
            ),
            // 'query_type' => array(
            //  'type'    => 'select',
            //  'std'     => 'and',
            //  'label'   => __( 'Query type', 'xstore' ),
            //  'options' => array(
            //      'and' => __( 'AND', 'xstore' ),
            //      'or'  => __( 'OR', 'xstore' ),
            //  ),
            // ),
        );

        parent::__construct();
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args Arguments.
     * @param array $instance Instance.
     */
    public function widget( $args, $instance ) {
        if ( ! is_shop() && ! is_product_taxonomy() ) {
            return;
        }

        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
        $count              = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
        $title              = isset( $instance['title'] ) ? $instance['title'] : $this->settings['title']['std'];
        // $query_type         = isset( $instance['query_type'] ) ? $instance['query_type'] : $this->settings['query_type']['std'];
        $display_type       = isset( $instance['display_type'] ) ? $instance['display_type'] : $this->settings['display_type']['std'];
        $hide_empty         = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];

        $terms = get_terms(
            array(
                'taxonomy' => 'brand',
                'hide_empty' => $hide_empty,
                'operator'         => 'IN',
                'include_children' => false,
            )
        );

        if ( 0 === count( $terms ) ) {
            return;
        }

        $out = '';

        // Dropdown
        $out .= '<div class="sidebar-widget etheme etheme_widget_brands_filter etheme_widget_brands">';
            if ( $title ) $out .= '<h4 class="widget-title"><span>'.$title.'</span></h4>';

            if ( $display_type == 'dropdown' ) { 
                    $out .= '<select name="product_brand" class="dropdown_product_brand">';
                        $out .= '<option value="" selected="selected" data-url="">'.__('Select a brand', 'xstore').'</option>';
                        $out .= '<option value="" data-url="' . get_permalink( wc_get_page_id( 'shop' ) ). '">'.__('All brands', 'xstore').'</option>';

                        foreach ( $terms as $brand ) {

                            $selected = ( is_tax( 'brand' , $brand->term_id ) ) ? ' selected' : '' ;
                            $stock = $brand->count;

                            if ( $hide_empty && 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
                                $stock  = etheme_stock_taxonomy( $brand->term_id, 'brand' );
                                if ( $stock < 1 ) continue;
                            }

                            $countProd = ($count == 1) ? "({$stock})" : '';
                            
                            $out .= '<option class="level-0" value="' . esc_html( $brand->name ) . '" data-url="' . esc_url( get_term_link( $brand ) ) . '"' . $selected . '>' . esc_html( $brand->name .' '. $countProd ) . '</option>';
                         }
                         
                    $out .= '</select>';

                wc_enqueue_js( "
                    jQuery( '.dropdown_product_brand' ).change( function() {
                        var url = jQuery(this).find( 'option:selected' ).data( 'url' );
                        if ( url != '' ) location.href = url;
                    });
                " );
            // List
            } else {
                $out .= '<ul>';
                $out .= '<li class="cat-item all-items"><a href="' . get_permalink( wc_get_page_id( 'shop' ) ). '">' . __('All brands', 'xstore') . '</a></li>';
                if( ! is_wp_error( $terms ) && count( $terms ) > 0 ) {
                    foreach ( $terms as $brand ) {

                        $class = 'cat-item';
                        $stock = $brand->count;

                        //if ( is_tax( 'brand' , $brand->term_id ) ) $class .= ' current-item';

                        if ( $hide_empty && 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && is_tax( 'product_cat' ) ) {
                            global $wp_query;
                            $cat    = $wp_query->get_queried_object();
                            $stock  = etheme_stock_taxonomy( $brand->term_id, 'brand', $cat->slug );
                        } elseif( $hide_empty && 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
                            $stock  = etheme_stock_taxonomy( $brand->term_id, 'brand' );
                        } elseif( is_tax( 'product_cat' ) ) {
                            global $wp_query;
                            $cat    = $wp_query->get_queried_object();
                            $stock  = etheme_stock_taxonomy( $brand->term_id, 'brand', $cat->slug, false );
                        }

                        if ( $stock < 1 ) continue;

                        $thumbnail_id = absint(get_woocommerce_term_meta($brand->term_id, 'thumbnail_id', true)); 
                        // if ( $displayType == 'name' ) { 
                            $link = remove_query_arg( 'filter_brand', $this->get_current_page_url() );


                            $current_filter = isset( $_GET['filter_brand'] ) ? explode( ',', wc_clean( wp_unslash( $_GET['filter_brand'] ) ) ) : array();
                            $current_filter = array_map( 'sanitize_title', $current_filter );

                            $all_filters = $current_filter;

                            if ( ! in_array( $brand->slug, $current_filter, true ) ) {
                                $all_filters[] = $brand->slug;
                            } else {
                                $key = array_search( $brand->slug, $all_filters );
                                unset( $all_filters[$key] );
                                $class .= ' current-item';
                            }

                            if ( ! empty($all_filters) ) {
                                $link = add_query_arg( 'filter_brand', implode( ',', $all_filters ), $link );
                            }

                            $out .= '<li class="' . $class . '">';

                            $countProd = ( $count == 1 ) ? "({$stock})" : '';
                                $out .= '<a href="' . $link . '">';
                                    $out .= esc_html( $brand->name );
                                    $out .= '<span class="count">' . esc_html( $countProd ) . '</span>';
                                $out .= '</a>';
                        //  } else {
                        //     $brandImg = wp_get_attachment_image( $thumbnail_id, array( 100,50 ) );
                        //     if ( ! empty( $brandImg ) ) { 
                        //         $out .= '<a href="' . get_term_link( $brand ) .'">';
                        //             $out .= $brandImg;
                        //             $out .= '<span class="count">' . esc_html($countProd) . '</span>';
                        //         $out .= '</a>';
                        //     }
                        // } 
                        $out .= '</li>';
                    }
                }
                $out .= '</ul>';
            }
        $out .= '</div>';

        echo $out;
    }
}
