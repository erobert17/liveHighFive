<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

$page_id = wc_get_page_id('shop');
$l = array();

$l['sidebar'] = etheme_get_option('grid_sidebar');
$l['breadcrumb'] = etheme_get_option('breadcrumb_type');
$l['bc_color'] = etheme_get_option('breadcrumb_color');
$l['bc_effect'] = etheme_get_option('breadcrumb_effect');

$page_breadcrumb = etheme_get_custom_field('breadcrumb_type', $page_id);
$breadcrumb_effect = etheme_get_custom_field('breadcrumb_effect', $page_id);
$page_sidebar = etheme_get_custom_field('sidebar_state', $page_id);
$sidebar_width = etheme_get_custom_field('sidebar_width', $page_id);
$widgetarea = etheme_get_custom_field('widget_area', $page_id);
$slider = etheme_get_custom_field('page_slider', $page_id);
$product_disable_sidebar = etheme_get_custom_field('disable_sidebar');
$l['sidebar-size'] = 3;

if(!empty($page_sidebar) && $page_sidebar != 'default') {
    $l['sidebar'] = $page_sidebar;
}

if(!empty($sidebar_width) && $sidebar_width != 'default') {
    $l['sidebar-size'] = $sidebar_width;
}

if(!empty($page_breadcrumb) && $page_breadcrumb != 'inherit') {
    $l['breadcrumb'] = $page_breadcrumb;
}

if(!empty($breadcrumb_effect) && $breadcrumb_effect != 'inherit') {
    $l['bc_effect'] = $breadcrumb_effect;
}

if(!empty($widgetarea) && $widgetarea != 'default') {
    $l['widgetarea'] = $widgetarea;
}

if(!empty($slider) && $slider != 'no_slider') {
    $l['slider'] = $slider;
}

// Thats all about custom options for the particular page

if(!$l['sidebar'] || $l['sidebar'] == 'without' || $l['sidebar'] == 'no_sidebar') {
    $l['sidebar-size'] = 0;
}

if($l['sidebar-size'] == 0) {
    $l['sidebar'] = 'without';
}


$l['content-size'] = 12 - $l['sidebar-size'];

$l['sidebar-class'] = 'col-md-' . $l['sidebar-size'];
$l['content-class'] = 'col-md-' . $l['content-size'];

if($l['sidebar'] == 'left') {
    $l['sidebar-class'] .= ' col-md-pull-' . $l['content-size'];
    $l['content-class'] .= ' col-md-push-' . $l['sidebar-size'];
}
$full_width = etheme_get_option('shop_full_width');

if($full_width) {
    $content_span = 'col-md-12';
}

$store_user = get_userdata( get_query_var( 'author' ) );
$store_info = dokan_get_store_info( $store_user->ID );
$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';

$scheme = is_ssl() ? 'https' : 'http';
wp_enqueue_script( 'google-maps', $scheme . '://maps.google.com/maps/api/js?sensor=true' );

get_header( 'shop' ); 
    
    /**
     * woocommerce_before_main_content hook
     *
     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
     * @hooked woocommerce_breadcrumb - 20
     */
    do_action( 'woocommerce_before_main_content' );
?>

<div class="<?php echo (!$full_width) ? 'container' : 'shop-full-width'; ?> sidebar-mobile-<?php etheme_option( 'sidebar_for_mobile' ); ?> content-page">
    <div class="sidebar-position-<?php echo esc_attr( $l['sidebar'] ); ?>">
        <div class="row">
            <div id="dokan-primary" class="content-area dokan-single-store <?php echo esc_attr( $l['content-class'] ); ?>">
                <div id="dokan-content" class="site-content store-page-wrap woocommerce" role="main">

                    <?php dokan_get_template_part( 'store-header' ); ?>

                    <?php do_action( 'dokan_store_profile_frame_after', $store_user, $store_info ); ?>

                    <?php if ( have_posts() ) { ?>

                        <div class="seller-items">

                            <?php woocommerce_product_loop_start(); ?>
                    
                                    <?php while ( have_posts() ) : the_post(); ?>

                                        <?php do_action( 'woocommerce_shop_loop' ); ?>
                    
                                        <?php wc_get_template_part( 'content', 'product' ); ?>
                    
                                    <?php endwhile; // end of the loop. ?>
                    
                                <?php woocommerce_product_loop_end(); ?>


                        </div>

                        <?php dokan_content_nav( 'nav-below' ); ?>

                    <?php } else { ?>

                        <p class="dokan-info"><?php esc_html_e( 'No products were found of this seller!', 'xstore' ); ?></p>

                    <?php } ?>
                </div>
            </div><!-- #content .site-content -->
            <?php
            if(!$l['sidebar'] || $l['sidebar'] == 'without' || $l['sidebar'] == 'no_sidebar') return;
            if ( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_general', 'off' ) == 'off' ) {
            ?>
                <div id="dokan-secondary" class="<?php echo esc_attr( $l['sidebar-class'] ); ?> sidebar dokan-clearfix dokan-w3 dokan-store-sidebar sidebar-<?php echo esc_attr( $l['sidebar'] ); ?> <?php echo (etheme_get_option('shop_sidebar_hide_mobile')) ? 'hidden-xs' : '' ; echo (!etheme_get_option('first_catItem_opened')) ? ' first-category-closed' : '' ?>" role="complementary">
                    <div class="widget-area sidebar-widget">
                        <?php
                        if ( ! dynamic_sidebar( 'sidebar-store' ) ) {

                            $args = array(
                                'before_widget' => '<div class="sidebar-widget">',
                                'after_widget'  => '</div>',
                                'before_title'  => '<h3 class="widget-title">',
                                'after_title'   => '</h3>',
                            );

                            if ( class_exists( 'Dokan_Store_Location' ) ) {
                                the_widget( 'Dokan_Store_Category_Menu', array( 'title' => __( 'Store Category', 'xstore' ) ), $args );
                                the_widget( 'Dokan_Store_Location', array( 'title' => __( 'Store Location', 'xstore' ) ), $args );
                                the_widget( 'Dokan_Store_Contact_Form', array( 'title' => __( 'Contact Seller', 'xstore' ) ), $args );
                            }

                        }
                        ?>

                        <?php do_action( 'dokan_sidebar_store_after', $store_user, $store_info ); ?>
                    </div>
                </div><!-- #secondary .widget-area -->
            <?php
            }else {
                ?>
                <div class="col-md-3">
                    <?php
                        get_sidebar( 'store' );
                    ?>
                </div>
                <?php
            }?>
        </div>
    </div>
</div>
<?php do_action( 'woocommerce_after_main_content' ); ?>
<?php get_footer( 'shop' ); ?>