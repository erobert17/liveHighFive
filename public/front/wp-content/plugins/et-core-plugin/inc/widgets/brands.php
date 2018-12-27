<?php  if ( ! defined('ABSPATH')) exit('No direct script access allowed');

// **********************************************************************//
// ! Products Widget
// **********************************************************************//
if( ! class_exists( 'WC_Widget' ) ) return;
class ETheme_Brands_Widget extends WC_Widget {
    /**
     * Current Brand.
     *
     * @var bool
     */
     public $current_cat;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->widget_cssclass    = 'sidebar-widget etheme etheme_widget_brands';
        $this->widget_description = __( 'A list or dropdown of product brands.', 'xstore' );
        $this->widget_id          = 'etheme_widget_brands';
        $this->widget_name        = '8theme - ' . __( 'Brand List', 'xstore' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => esc_html__( 'Brands list', 'xstore' ),
                'label' => __( 'Title', 'xstore' )
            ),
            'displayType' => array(
                'type'  => 'select',
                'std'   => 'name',
                'label' => __( 'Display type:', 'xstore' ),
                'options' => array(
                    'name' => __( 'Name', 'xstore' ),
                    'image'  => __( 'Image', 'xstore' )
                )
            ),
            'dropdown' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Show as dropdown (Only for Display type: Name)', 'xstore' )
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
            )
        );

        parent::__construct();
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {

        $count              = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
        $title              = isset( $instance['title'] ) ? $instance['title'] : $this->settings['title']['std'];
        $dropdown           = isset( $instance['dropdown'] ) ? $instance['dropdown'] : $this->settings['dropdown']['std'];
        $displayType        = isset( $instance['displayType'] ) ? $instance['displayType'] : $this->settings['displayType']['std'];
        $hide_empty         = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];

        // Setup Current Category
        $this->current_cat   = false;
        $hide_empty = ($hide_empty == 1) ? true : false;
        $args = array(
            'taxonomy' => 'brand',
            'hide_empty' => $hide_empty,
        );
        $terms = get_terms($args);

        $out = '';

        // Dropdown
        $out .= '<div class="sidebar-widget etheme etheme_widget_brands">';
            if ( $title ) $out .= '<h4 class="widget-title"><span>'.$title.'</span></h4>';

            if ( $dropdown ) { 
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

                        if ( is_tax( 'brand' , $brand->term_id ) ) $class .= ' current-item';

                        if ( $hide_empty && 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
                            $stock  = etheme_stock_taxonomy( $brand->term_id, 'brand' );
                            if ( $stock < 1 ) continue;
                        }

                        $thumbnail_id = absint(get_woocommerce_term_meta($brand->term_id, 'thumbnail_id', true)); 

                        $out .= '<li class="' . $class . '">';

                            $countProd = ( $count == 1 ) ? "({$stock})" : '';

                            if ( $displayType == 'name' ) { 
                                $out .= '<a href="' . get_term_link( $brand ) . '">';
                                    $out .= esc_html( $brand->name );
                                    $out .= '<span class="count">' . esc_html( $countProd ) . '</span>';
                                $out .= '</a>';
                             } else {
                                $brandImg = wp_get_attachment_image( $thumbnail_id, array( 100,50 ) );
                                if ( ! empty( $brandImg ) ) { 
                                    $out .= '<a href="' . get_term_link( $brand ) .'">';
                                        $out .= $brandImg;
                                        $out .= '<span class="count">' . esc_html($countProd) . '</span>';
                                    $out .= '</a>';
                                }
                            } 
                        $out .= '</li>';
                    }
                }                
                $out .= '</ul>';
            }
        $out .= '</div>';

        echo $out;
    }
}
