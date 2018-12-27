<?php  if ( ! defined('ABSPATH')) exit('No direct script access allowed');

// **********************************************************************//
// ! Swatches Filter Widget
// **********************************************************************//
if( ! class_exists( 'WC_Widget' ) ) return;
class ETheme_Swatches_Filter_Widget extends WC_Widget {

    public function __construct() {
        // ! Get the taxonomies
        $attribute_array      = array();
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        if ( ! empty( $attribute_taxonomies ) ) {
            foreach ( $attribute_taxonomies as $tax ) {
                $attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
            }
        }

        $this->widget_cssclass    = 'sidebar-widget etheme-swatches-filter';
        $this->widget_description = esc_html__( 'Widget to filtering products by swatches attributes', 'xstore' );
        $this->widget_id          = 'etheme_swatches_filter';
        $this->widget_name        = '8theme - ' . esc_html__( 'Swatches filter', 'xstore' );
        $this->settings           = array(
            'title' => array(
                'type'  => 'text',
                'std'   => esc_html__( 'Filter by', 'xstore' ),
                'label' => esc_html__( 'Title', 'xstore' ),
            ),
            'attribute' => array(
                'type'    => 'select',
                'std'     => '',
                'label'   => esc_html__( 'Attribute', 'xstore' ),
                'options' => $attribute_array,
            ),
            'query_type' => array(
                'type'    => 'select',
                'std'     => '',
                'label'   => esc_html__( 'Query type', 'xstore' ),
                'options' => array(
                    'and' => 'AND',
                    'or'  => 'OR'
                ),
            ),
        );
        parent::__construct();
    }

    public function widget( $args, $instance ) {
        if ( ! is_shop() && ! is_product_taxonomy() ) return;

        global $wpdb;
        // ! Set main variables
        $html               = '';
        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
        $taxonomy           = isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name( $instance['attribute'] ) : $this->settings['attribute']['std'];
        $query_type         = isset( $instance['query_type'] ) ? $instance['query_type'] : $this->settings['query_type']['std'];
        $title              = isset( $instance['title'] ) ? $instance['title'] : $this->settings['title']['std'];
        $orderby            = wc_attribute_orderby( $taxonomy );

        // ! Set get_terms args
        $terms_args['orderby']    = $orderby;
        $terms_args['menu_order'] = ( $orderby == 'menu_order' ) ? true : false;
        $terms = get_terms( $taxonomy, $terms_args );

        // ! Set class
        $class = '';
        $class .= 'st-swatch-size-large';

        // ! Get the taxonomies attribute 
        $attr = substr( $taxonomy, 3 );
        $attr = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attr'" );

        if ( ! $attr || ! $attr->attribute_type ) {
            return;
        }

        $attribute_type = $attr->attribute_type;

        if ( strpos( $attribute_type, '-sq') !== false ) {
            $et_attribute_type = str_replace( '-sq', '', $attribute_type );
            $class .= ' st-swatch-shape-square';
            $subtype = 'subtype-square';
        } else {
            $et_attribute_type = $attribute_type;
            $class .= ' st-swatch-shape-circle';
            $subtype = '';
        }

        // ! Get current filter
        $filter_name    = 'filter_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
        $current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array();
        $current_filter = array_map( 'sanitize_title', $current_filter );

        foreach( $terms as $taxonomy ) {
            $all_filters = $current_filter;
            $metadata    = get_term_meta( $taxonomy->term_id, '', true );
            $link        = remove_query_arg( $filter_name, $this->get_current_page_url() );

            $data_tooltip = $taxonomy->name;
            $li_class  = '';

            // ! Generate link
            if ( ! in_array( $taxonomy->slug, $current_filter, true ) ) {
                $all_filters[] = $taxonomy->slug;
            } else {
                $key = array_search( $taxonomy->slug, $all_filters );
                unset( $all_filters[$key] );
                $li_class .= ' selected';
            }

            if ( ! empty( $all_filters ) ) {
                asort( $all_filters );
                $link = add_query_arg( $filter_name, implode( ',', $all_filters ), $link );

                if ( 'or' === $query_type && ! ( 1 === count( $all_filters ) ) ) {
                    $link = add_query_arg( 'query_type_' . sanitize_title( str_replace( 'pa_', '', $taxonomy->taxonomy ) ), 'or', $link );
                }
                $link = str_replace( '%2C', ',', $link );
            }

            // ! Generate html
            switch ( $et_attribute_type ) {
                case 'st-color-swatch':
                    $value = $metadata['st-color-swatch'][0];
                    $html .= '<li class="type-color ' . $subtype . $li_class . '"  data-tooltip="'.$data_tooltip.'"><a href="' . $link . '"><span class="st-custom-attribute" style="background-color:' . $value . '"></span></a></li>';
                    break;

                case 'st-image-swatch':
                    $value = $metadata['st-image-swatch'][0];
                    $image = ( $value ) ? wp_get_attachment_image( $value ) : wc_placeholder_img();
                    $html .= '<li class="type-image ' . $subtype . $li_class . '"  data-tooltip="'.$data_tooltip.'"><a href="' . $link . '"><span class="st-custom-attribute">' . $image . '</span></a></li>';
                    break;

                case 'st-label-swatch':
                     $value = $metadata['st-label-swatch'][0];
                    $html .= '<li class="type-label ' . $subtype . $li_class . '"><a href="' . $link . '"><span class="st-custom-attribute">' . $value . '</span></a></li>';
                    break;
                
                default:
                    $html .= '<li class="type-select ' . $li_class . '"><a href="' . $link . '"><span class="st-custom-attribute">' . $taxonomy->name . '</span></a></li>';
                    break;
            }
        }

        if ( $title ) $title = '<h4 class="widget-title"><span>' . $title . '</span></h4>';

        echo '
            <div class="sidebar-widget etheme_swatches_filter">
                ' . $title . '
                <ul class="st-swatch-preview st-color-swatch ' . esc_attr( $class ) . '">
                    ' . $html . '
                </ul>
            </div>
        ';
    }
}