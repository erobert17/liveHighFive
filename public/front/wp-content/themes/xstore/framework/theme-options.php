<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */


if ( ! etheme_support_date() ) {
    if ( class_exists( 'Redux' ) && etheme_is_activated() ) {
        Redux::setOption( 'et_options','support_chat', false );
    }
}

if ( ! class_exists( 'Redux' ) || ! etheme_is_activated() ) {
    global $et_options;

    $et_options = array(
        'main_layout' => 'wide',
        'header_type' => 'xstore',
        'header_full_width' => '0',
        'header_color' => 'dark',
        'header_overlap' => '0',
        'top_bar' => '1',
        'top_bar_color' => 'dark',
        'logo_width' => '200',
        'top_links' => '1',
        'search_form' => false,
        'breadcrumb_type' => 'left2',
        'breadcrumb_effect' => 'none',
        'breadcrumb_color' => 'dark',
        'activecol' => '#c62828',
        'blog_hover' => 'default',
        'blog_byline' => '1',
        'read_more' => '1',
        'views_counter' => '1',
        'blog_sidebar' => 'right',
        'excerpt_length' => '25',
        'excerpt_words' => '...',
        'post_template' => 'default',
        'blog_featured_image' => '1',
        'top_wishlist_widget' => 'header', 
        'cart_widget' => 'header',
        'shopping_cart_icon' => 1,
    );
    return;
}

// ! Get options that need plugins
if ( ! function_exists( 'etheme_depend_options' ) ) :
    function etheme_depend_options( $plugin = '', $opt = '', $type = 'class' ){

        if ( empty( $plugin ) || empty( $opt ) || empty( $type ) ) return array();

        $options = array();

        switch ( $plugin ) {
            // ! Wishlist options
            case 'YITH_WCWL_Shortcode':
                if ( class_exists( 'YITH_WCWL_Shortcode' ) ) {
                    switch ( $opt ) {
                        case 'single_wishlist_type':
                            $options = array (
                                'id' => 'single_wishlist_type',
                                'type' => 'select',
                                'title' => __( 'Wishlist type', 'xstore' ),
                                'desc' => __( 'Only for "Use shortcode" wislist position', 'xstore' ),
                                'options' => array (
                                    'icon' => __( 'Icon', 'xstore' ),
                                    'icon-text' => __( 'Icon + text', 'xstore' ),
                                ),
                                'default' => 'icon'
                            );
                            break;
                        case 'single_wishlist_position':
                            $options = array (
                                'id' => 'single_wishlist_position',
                                'type' => 'select',
                                'title' => __( 'Wishlist position', 'xstore' ),
                                'desc' => __( 'Only for "Use shortcode" wislist position', 'xstore' ),
                                'options' => array (
                                    'after' => __( 'After "add to cart" button', 'xstore' ),
                                    'under' => __( 'Under "add to cart" button', 'xstore' ),
                                ),
                                'default' => 'after'
                            );
                            break;
                        default:
                            return $options;
                            break;
                    }
                }
                break;
            
            default:
                return $options;
                break;
        }

        return $options;
    }
endif;

if ( !function_exists('et_compare_output_function')) {
    function et_compare_output_function ($array = array(), $output = '') {
         $dir = wp_upload_dir();
        if ( is_file($dir['basedir'].'/xstore/options-style.min.css') && filesize($dir['basedir'].'/xstore/options-style.min.css') > 0 && !is_customize_preview() ){
            $array['compiler'] = $output;   
        }
        else {
           $array['output'] = $output;
           $array['compiler'] = $output;
        }
        return $array;
    }
}

if(!function_exists('etheme_redux_init')) {
    function etheme_redux_init() {
        // This is your option name where all the Redux data is stored.
        $opt_name = "et_options";

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
            // if ( preg_match('(product)', strtolower($key->post_title) ) ) {
                $product_templates[$key->ID] = $key->post_title;
            // }
        }

        /**
         * ---> SET ARGUMENTS
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */

        $theme = wp_get_theme(); // For use with some settings. Not necessary.

        $activated_data = get_option( 'etheme_activated_data' );
        $activated_data = ( isset( $activated_data['purchase'] ) && ! empty( $activated_data['purchase'] ) ) ? $activated_data['purchase'] : '';
        $args = array(
            // TYPICAL -> Change these values as you need/desire
            'opt_name'             => $opt_name,
            // This is where your data is stored in the database and also becomes your global variable name.
            'display_name'         => ETHEME_THEME_NAME . ' <span class="et_purchase-code">' . esc_html__('Theme Activated', 'xstore') . ' - <small>' . $activated_data .'</small></span><span class="et_theme-deactivator">Deactivate theme</span>',
            // Name that appears at the top of your panel
            'display_version'      => $theme->get( 'Version' ),
            // Version that appears at the top of your panel
            'menu_type'            => 'submenu',
            //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
            'allow_sub_menu'       => false,
            // Show the sections below the admin menu item or not
            'menu_title'           => esc_html__( 'Theme Options', 'xstore' ),
            'page_title'           => esc_html__( 'Theme Options', 'xstore' ),
            // You will need to generate a Google API key to use this feature.
            // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
            'google_api_key'       => '',
            // Set it you want google fonts to update weekly. A google_api_key value is required.
            'google_update_weekly' => false,
            // Must be defined to add google fonts to the typography module
            'async_typography'     => false,
            // Use a asynchronous font on the front end or font string
            //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
            'admin_bar'            => false,
            // Show the panel pages on the admin bar
            'admin_bar_icon'       => 'dashicons-portfolio',
            // Choose an icon for the admin bar menu
            'admin_bar_priority'   => 50,
            // Choose an priority for the admin bar menu
            'global_variable'      => '',
            // Set a different name for your global variable other than the opt_name
            'dev_mode'             => false,
            // Show the time the page took to load, etc
            'update_notice'        => true,
            // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
            'customizer'           => true,
            // Enable basic customizer support
            //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
            //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

            // OPTIONAL -> Give you extra features
            'page_priority'        => 63,
            // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
            'page_parent'          => 'themes.php',
            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
            'page_permissions'     => 'manage_options',
            // Permissions needed to access the options panel.
            'menu_icon'            => ETHEME_CODE_IMAGES . 'icon-etheme.png',
            // Specify a custom URL to an icon
            'last_tab'             => '',
            // Force your panel to always open to a specific tab (by id)
            'page_icon'            => 'icon-themes',
            // Icon displayed in the admin panel next to your menu_title
            'page_slug'            => '_options',
            // Page slug used to denote the panel
            'save_defaults'        => true,
            // On load save the defaults to DB before user clicks save or not
            'default_show'         => false,
            // If true, shows the default value next to each field that is not the default value.
            'default_mark'         => '',
            // What to print by the field's title if the value shown is default. Suggested: *
            'show_import_export'   => true,
            // Shows the Import/Export panel when not used as a field.

            // CAREFUL -> These options are for advanced use only
            'transient_time'       => 60 * MINUTE_IN_SECONDS,
            'output'               => true,
            // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
            'output_tag'           => true,
            // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
            'footer_credit'     => '8theme',                   // Disable the footer credit of Redux. Please leave if you can help it.


            'templates_path' => ETHEME_BASE . ETHEME_CODE_3D . 'options-framework/et-templates/',

            // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
            'database'             => '',
            // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
            'system_info'          => false,

            'show_options_object'  => false
        );


        // **************************************************************************************************** //
        // ! Custom fonts
        // **************************************************************************************************** //

        // ! Get standard redux font list
        $std_fonts = array(
            "Arial, Helvetica, sans-serif"                         => "Arial, Helvetica, sans-serif",
            "'Arial Black', Gadget, sans-serif"                    => "'Arial Black', Gadget, sans-serif",
            "'Bookman Old Style', serif"                           => "'Bookman Old Style', serif",
            "'Comic Sans MS', cursive"                             => "'Comic Sans MS', cursive",
            "Courier, monospace"                                   => "Courier, monospace",
            "Garamond, serif"                                      => "Garamond, serif",
            "Georgia, serif"                                       => "Georgia, serif",
            "Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif",
            "'Lucida Console', Monaco, monospace"                  => "'Lucida Console', Monaco, monospace",
            "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
            "'MS Sans Serif', Geneva, sans-serif"                  => "'MS Sans Serif', Geneva, sans-serif",
            "'MS Serif', 'New York', sans-serif"                   => "'MS Serif', 'New York', sans-serif",
            "'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
            "Tahoma,Geneva, sans-serif"                            => "Tahoma, Geneva, sans-serif",
            "'Times New Roman', Times,serif"                       => "'Times New Roman', Times, serif",
            "'Trebuchet MS', Helvetica, sans-serif"                => "'Trebuchet MS', Helvetica, sans-serif",
            "Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif",
        );

        // ! Get custom fonts list
        $fonts = get_option( 'etheme-fonts', false );

        if ( $fonts ) {
            $valid_fonts = array();
            foreach ( $fonts as $value ) {
                $valid_fonts[$value['name']] = $value['name'];
            }
            $fonts_list = array_merge( $std_fonts, $valid_fonts );
        } else {
            $fonts_list = '';
        }

        // ! support text
        if ( ! etheme_support_date() ) {
            $support = sprintf( esc_html__( '
                Chat allows you to contact 8theme support team directly via Dashboard if you need help. Seems your support license has expired. Extend support period on %s and then you\'ll be able to contact us again.', 'xstore' ), '<a href="https://help.market.envato.com/hc/en-us/articles/207886473-Extending-and-Renewing-Item-Support" target="_blank">' . esc_html__( 'ThemeForest', 'xstore' ) . '</a>' );
        } else {
            $support = esc_html__( 'Chat allows you to contact 8theme support team directly via Dashboard if you need help. Find online chat form at the right bottom to get help from 8theme support team.', 'xstore' );
        }


        Redux::setArgs( $opt_name, $args );

        /*
         * ---> END ARGUMENTS
         */

        // -> START Basic Fields

        Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'General / Layout', 'xstore' ),
            'id'     => 'general',
            'icon'   => 'et-admin-icon et-general',
            'fields' => array (
                array (
                    'id'       => 'main_layout',
                    'type'     => 'select',
                    'operator' => 'and',
                    'title'    => esc_html__( 'Site Layout', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the type of layout you want your site to display.', 'xstore' ),
                    'options'  => array (
                        'wide'     => esc_html__( 'Wide layout', 'xstore' ),
                        'boxed'    => esc_html__( 'Boxed', 'xstore' ),
                        'framed'   => esc_html__( 'Framed', 'xstore' ),
                        'bordered' => esc_html__( 'Bordered', 'xstore' ),
                    ),
                    'default'  => 'wide'
                ),
                array (
                    'id'        => 'site_width',
                    'type'      => 'slider',
                    'title'     => esc_html__( 'Site width', 'xstore' ),
                    'subtitle'  => esc_html__( 'Controls the content width. In pixels, default: 1170px.', 'xstore' ),
                    "default"   => 1170,
                    "min"       => 970,
                    "step"      => 1,
                    "max"       => 3000,
                    'display_value' => 'text',
                    'compiler' => true
                ),
                array (
                    'id' => 'site_preloader',
                    'type' => 'switch',
                    'title' => esc_html__( 'Site preloader', 'xstore' ),
                    'subtitle' => esc_html__( 'Enable nice loading effect while your site or page is in loading mode.', 'xstore' ),
                    'default' => false,
                ),
                array (
                    'id' => 'preloader_img',
                    'type' => 'media',
                    'title' => esc_html__( 'Preloader image', 'xstore' ),
                    'subtitle' => esc_html__( 'Upload an interesting png, jpg or gif file to make the waiting time less of a hassle for site visitors.', 'xstore' ),
                ),
                array (
                    'id' => 'support_chat',
                    'type' => 'switch',
                    'title' => esc_html__( 'Support chat', 'xstore' ),
                    'subtitle' => $support,
                    'default' => true,
                ),
                array (
                    'id' => 'static_blocks',
                    'type' => 'switch',
                    'title' => esc_html__( 'Static blocks', 'xstore' ),
                    'subtitle' => esc_html__( 'Enable this option if you want to use static blocks functionality to create an advanced content of footer, newsletter, mega menu etc.', 'xstore' ),
                    'default' => true,
                ),
                array (
                    'id' => 'testimonials_type',
                    'type' => 'switch',
                    'title' => esc_html__( 'Testimonials', 'xstore' ),
                    'subtitle' => esc_html__( 'Enable this option if you collect written recommendations from customers, clients and want to display them on your site in different ways.', 'xstore' ),
                    'default' => true,
                ),
            )
        ) );


        Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Header', 'xstore' ),
            'id'     => 'header',
            'icon'   => 'et-admin-icon et-header',
        ) );

        Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Logo', 'xstore' ),
            'id'     => 'logo',
            'subsection' => true,
            // 'icon'   => 'el-icon-home',
            'fields' => array (
                array (
                    'id'    => 'logo',
                    'type'  => 'media',
                    'title' => esc_html__( 'Logo image', 'xstore' ),
                    'subtitle' => esc_html__( 'Upload logo image for the main header area.', 'xstore' ),
                ),
                array (
                    'id'    => 'logo_fixed',
                    'type'  => 'media',
                    'title' => esc_html__( 'Logo image for fixed header', 'xstore' ),
                    'subtitle' => esc_html__( 'Upload logo image for the fixed header.', 'xstore' ),
                ),
                array (
                    'id'        => 'logo_width',
                    'type'      => 'slider',
                    'title'     => esc_html__( 'Logo max width', 'xstore' ),
                    'subtitle'  => esc_html__( 'Controls the max width of the logo. In pixels.', 'xstore' ),
                    "default"   => 200,
                    "min"       => 50,
                    "step"      => 1,
                    "max"       => 500,
                    'display_value' => 'text',
                    'compiler'  => true
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Header layout', 'xstore' ),            
            'id'         => 'header-content',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'      => 'header_type',
                    'type'    => 'image_select',
                    'title'   => esc_html__( 'Header Type', 'xstore' ),
                    'subtitle'   => esc_html__( 'Choose the most suitable header design for you. Some of the headers have Custom area where you can use HTML or static block shortcode to display custom content in the header. The position of the Custom HTML area depends on header design.', 'xstore' ),
                    'options' => array (
                        'xstore' => array (
                            'title' => esc_html__( 'Variant xstore', 'xstore' ),
                            'img'   => ETHEME_CODE_IMAGES . 'headers/xstore.jpg',
                        ),
                        'xstore2' => array (
                            'title' => esc_html__( 'Variant xstore2', 'xstore' ),
                            'img'   => ETHEME_CODE_IMAGES . 'headers/xstore2.jpg',
                        ),
                        'center2' => array (
                            'title' => esc_html__( 'Variant center 2', 'xstore' ),
                            'img'   => ETHEME_CODE_IMAGES . 'headers/center2.jpg',
                        ),
                        'center3' => array (
                            'title' => esc_html__( 'Variant center 3', 'xstore' ),
                            'img'   => ETHEME_CODE_IMAGES . 'headers/center3.jpg',
                        ),
                        'standard' => array (
                            'title' => esc_html__( 'Variant standard', 'xstore' ),
                            'img'   => ETHEME_CODE_IMAGES . 'headers/standard.jpg',
                        ),
                        'double-menu' => array (
                            'title' => esc_html__( 'Double menu', 'xstore' ),
                            'img'   => ETHEME_CODE_IMAGES . 'headers/double-menu.jpg',
                        ),
                        'advanced' => array (
                            'title' => esc_html__( 'Advanced', 'xstore' ),
                            'img'   => ETHEME_CODE_IMAGES . 'headers/advanced.jpg',
                        ),
                        'hamburger-icon' => array (
                            'title' => esc_html__( 'Variant hamburger', 'xstore' ),
                            'img'   => ETHEME_CODE_IMAGES . 'headers/hamburger-icon.jpg',
                        ),
                        'vertical' => array (
                            'title' => esc_html__( 'Variant vertical', 'xstore' ),
                            'img'   => ETHEME_CODE_IMAGES . 'headers/vertical-icon.jpg',
                        ),
                        'vertical2' => array (
                            'title' => esc_html__( 'Variant vertical 2', 'xstore' ),
                            'img'   => ETHEME_CODE_IMAGES . 'headers/vertical-icon-2.jpg',
                        ),
                    ),
                    'default' => 'xstore'
                ),
                array (
                    'id'       => 'header_custom_block',
                    'type'     => 'editor',
                    'title'    => esc_html__( 'Header custom HTML', 'xstore' ),
                    'subtitle' => esc_html__(' You can add text, HTML or static block shortcode to display additional content in the header. The position of the Custom HTML depends on header design. Do not include JS in the field.', 'xstore'),
                    'required' => array(
                        array( 'header_type', 'equals', array( 'standard', 'advanced', 'double-menu' ) )
                    )
                ),
                array (
                    'id'       => 'header_banner_pos',
                    'type'     => 'select',
                    'subtitle' => esc_html__( 'Controls position of the Header banner widget area where you can add some promo information.', 'xstore' ),
                    'title'    => esc_html__( 'Header banner position', 'xstore' ),
                    'options'  => array (
                        'top'    => esc_html__( 'Above header', 'xstore' ),
                        'bottom' => esc_html__( 'Under header', 'xstore' ),
                        'disable' => esc_html__( 'Disable', 'xstore' ),
                    ),
                    'default'  => 'disable',
                    'required' => array(
                        array( 'header_type', '!=', 'vertical' ),
                    )
                ),
                array (
                    'id'       => 'cart_widget',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Cart widget position ', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the area where you want to display cart widget in header or disable it at all.', 'xstore' ),
                    'options'  => array (
                            'header'   => esc_html__( 'Header', 'xstore' ),
                            'tb-left'  => esc_html__( 'Top bar left', 'xstore' ),
                            'tb-right' => esc_html__( 'Top bar right', 'xstore' ),
                            false      => esc_html__( 'Disable', 'xstore' ),
                        ),
                    'default'  => 'header',
                ),
                array (
                    'id'       => 'shopping_cart_icon',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Shopping cart icon', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the icon that you like to use for the cart widget in your header.', 'xstore' ),
                    'options'  => array (
                        1 => array (
                            'img' => ETHEME_CODE_IMAGES . 'cart/shopping-bag.png',
                        ),
                        5 => array (
                            'img' => ETHEME_CODE_IMAGES . 'cart/shopping-bag-o.png',
                        ),
                        2 => array (
                            'img' => ETHEME_CODE_IMAGES . 'cart/shopping-cart.png',
                        ),
                        3 => array (
                            'img' => ETHEME_CODE_IMAGES . 'cart/shopping-cart-2.png',
                        ),
                        4 => array (
                            'img' => ETHEME_CODE_IMAGES . 'cart/shopping-basket.png',
                        ),

                    ),
                    'default'  => 1,
                    'required' => array(
                        array( 'cart_widget', '!=', false ),
                    )
                ),
                array (
                    'id'       => 'mini-cart-items-count',
                    'type'     => 'spinner',
                    'title'    => esc_html__( 'Number of products in mini cart', 'xstore' ),
                    'subtitle' => esc_html__( 'Limit the number of product positions that will be displayed in the cart widget drop-down. All the other products could be checked by visiting the cart page. By default - 3.', 'xstore' ),
                    'default'  => '3',
                    'min'      => '1',
                    'step'     => '1',
                    'max'      => '15',
                    'required' => array(
                        array( 'cart_widget', '!=', false ),
                    )
                ),
                array (
                    'id'       => 'cart_popup_banner',
                    'type'     => 'editor',
                    'title'    => esc_html__( 'Mini cart banner content', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls content that appears at the bottom of the cart widget drop-down. Do not include JS in the field.', 'xstore' ),
                    'default'  => '<i class="et-icon et-internet"></i> Free standard shipping on orders over $50',
                    'required' => array(
                        array( 'cart_widget', '!=', false ),
                    )
                ),
                array (
                    'id'       => 'shopping_cart_total',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show cart total', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the cart total amount next to the cart icon.', 'xstore' ),
                    'default'  => false,
                    'required' => array(
                        array( 'cart_widget', '!=', false ),
                    )
                ),
                array (
                    'id'       => 'favicon_label_zero',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show zero number of cart items on label', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show label with zero when the cart is empty.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'cart_widget', '!=', false ),
                    )
                ),
                array (
                    'id'       => 'cart_icon_label',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Label position', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the position of the label with number of the items in the cart.', 'xstore' ),
                    'options'  => array (
                        'top'    => esc_html__( 'Top', 'xstore' ),
                        'bottom' => esc_html__( 'Bottom', 'xstore' ),
                        'right'  => esc_html__('Right', 'xstore' ),
                    ),
                    'default'  => 'top',
                    'required' => array(
                        array( 'cart_widget', '!=', false ),
                    )
                ),
                et_compare_output_function ( 
                    array (
                        'id'       => 'cart_badge_color',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Color for cart number label', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the text color  of the label with the number of items in the cart.', 'xstore' ),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                        'required' => array(
                            array( 'cart_widget', '!=', false ),
                        )
                    ),
                    array(
                        'color' => '.navbar-header .shopping-container .cart-bag .badge-number, .navbar-header .et-wishlist-widget .wishlist-count'
                    )
                ),
                et_compare_output_function ( 
                    array (
                        'id'       => 'cart_badge_bg',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Background color of the cart number label', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the background color of the label with the number of items in the cart.', 'xstore' ),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                        'required' => array(
                            array( 'cart_widget', '!=', false ),
                        )
                    ),
                    array(
                        'background-color' => '.navbar-header .shopping-container .cart-bag .badge-number, .navbar-header .et-wishlist-widget .wishlist-count'
                    )
                ),
                array (
                    'id'       => 'top_wishlist_widget',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Wishlist icon position', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the area where you want to display wishlist icon in the header or disable it at all. Works only if YITH Wishlist plugin is enabled.', 'xstore' ),
                    'options'      => array (
                        'header'   => esc_html__( 'Header', 'xstore' ),
                        'tb-left'  => esc_html__( 'Top bar left', 'xstore' ),
                        'tb-right' => esc_html__( 'Top bar right', 'xstore' ),
                        false      => esc_html__( 'Disable', 'xstore' ),
                    ),
                    'default' => 'header',
                ),
                array (
                    'id'       => 'top_links',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Sign In link position', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the area where you want to display “Sign In” in the header or disable it at all.', 'xstore' ),
                    'default'  => 'tb-right',
                    'options'  => array (
                        'header'   => esc_html__( 'Header', 'xstore' ),
                        'tb-left'  => esc_html__( 'Top bar left', 'xstore' ),
                        'tb-right' => esc_html__( 'Top bar right', 'xstore' ),
                        'menu'     => esc_html__( 'Menu', 'xstore' ),
                        false      => esc_html__( 'Disable', 'xstore' ),
                    ),
                ),

                array (
                    'id'       => 'sign_in_type',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Sign In type', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls type of the Sign In.', 'xstore' ),
                    'default'  => 'text',
                    'options'  => array (
                        'text'      => esc_html__( 'Text', 'xstore' ),
                        'text_icon' => esc_html__( 'Icon with text', 'xstore' ),
                        'icon'      => esc_html__( 'Icon', 'xstore' ),
                    ),
                    'required' => array (
                        array( 'top_links', '!=', false ),
                    ),
                ),
                array(
                    'id'       => 'sign_in_text',
                    'type'     => 'text',
                    'title'    => esc_html__('Custom text for sign in', 'xstore'),
                    'subtitle' => esc_html__( 'Text to display instead of the default one for the Sign In link. Default - "Sign In or create an account". Visible only if a user is not logged in. For logged in users the text is changed to "My Account" by default.', 'xstore' ),
                    'required' => array (
                        array( 'top_links', '!=', false ),
                        array( 'sign_in_type', '!=', 'icon' ),
                    ),
                ),
            )
        ) );        
        
        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Header styles', 'xstore' ),
            'id'         => 'header-styles',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'header_full_width',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Header wide', 'xstore' ),
                    'subtitle' => esc_html__( 'Stretches the header container to full width.', 'xstore' ),
                    'default'  => false,
                ),
                array (
                    'id'            => 'header_width',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Header max-width', 'xstore' ),
                    'subtitle'      => esc_html__( 'Limits the width of the header container. In pixels.', 'xstore' ),
                    'default'       => 1600,
                    'min'           => 1170,
                    'step'          => 1,
                    'max'           => 3000,
                    'display_value' => 'text',
                    'compiler'      => true,
                    'required'      => array(
                        array( 'header_full_width', 'equals', true)
                    )
                ),
                array (
                    'id'             => 'header_padding',
                    'type'           => 'spacing',
                    'title'          => esc_html__( 'Header paddings', 'xstore' ),
                    'subtitle'       => esc_html__( 'Controls the paddings of the main header area. Choose also the valid CSS unit from the drop-down.', 'xstore' ),
                    'units'          => array ( 'em', 'px', '%', 'vh', 'vw' ),
                    'units_extended' => 'false',
                    'default'        => '',
                    'compiler'       => true
                ),
                array (
                    'id'            => 'header_margin_bottom',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Header margin bottom', 'xstore' ),
                    'subtitle'      => esc_html__( 'Controls the bottom margin of the header to page content when breadcrumbs are disabled. In pixels.', 'xstore' ),
                    "default"       => 30,
                    "min"           => 0,
                    "step"          => 5,
                    "max"           => 100,
                    'display_value' => 'text',
                    'compiler'      => true
                ),
                array (
                    'id'       => 'header_border_bottom',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Header border bottom', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the header border line.', 'xstore' ),
                    'default'  => false,
                ),
                et_compare_output_function(
                    array (
                        'id' => 'header_border_color',
                        'title' => 'Header border color',
                        'subtitle' => esc_html__( 'Controls the header border line color.', 'xstore' ),
                        'type' => 'color_rgba',
                        'options' => array (
                            'show_buttons' => false,
                        ),
                        'required' => array (
                            array( 'header_border_bottom', 'equals', true ),
                        ),
                    ),
                    array( 'border-color' => '.header-wrapper .et-hr')
                ),
                array (
                    'id'       => 'header_overlap',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Header over the content', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn it on if you want to have absolute header position and show it over the breadcrumbs and content.', 'xstore' ),
                    'default'  => false,
                ),
                array (
                    'id'       => 'header_color',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Header text color', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the header text/icons color scheme.', 'xstore' ),
                    'options'  => array (
                        'dark'  => esc_html__( 'Dark', 'xstore' ),
                        'white' => esc_html__( 'White', 'xstore' ),
                    ),
                    'default'  => 'dark'
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'header_bg',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Header background', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the header background.', 'xstore' ),
                    ),
                    array( '.header-bg-block, .header-vertical .container-wrapper, .header-vertical .menu-main-container, .header-vertical .nav-sublist-dropdown, .header-vertical .menu .nav-sublist-dropdown ul > li ul, .header-vertical .nav-sublist-dropdown ul > li .nav-sublist ul' )
                ),
                array (
                    'id'            => 'header_bg_opacity',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Header background opacity', 'xstore' ),
                    'subtitle'      => esc_html__( 'Controls the header background opacity.', 'xstore' ),
                    'default'       => 1.0,
                    'min'           => 0,
                    'step'          => .1,
                    'max'           => 1,
                    'resolution'    => 0.1,
                    'display_value' => 'text',
                    'compiler'      => true
                ),
                
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Top bar', 'xstore' ),
            'id'         => 'top-bar',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'top_bar',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable top bar', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the top bar.', 'xstore' ),
                    'default'  => true,
                ),                
                et_compare_output_function (
                    array (
                        'id'       => 'top_bar_bg',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Top bar background', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the top bar background.', 'xstore' ),
                        'required' => array (
                            array( 'top_bar', 'equals', true ),
                        ),
                    ),
                    array('.top-bar')
                ),
                array (
                    'id'            => 'top_bar_bg_opacity',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Top bar background opacity', 'xstore' ),
                    'subtitle'      => esc_html__( 'Controls the top bar background opacity.', 'xstore' ),
                    'default'       => 1.0,
                    'min'           => 0,
                    'step'          => .1,
                    'max'           => 1,
                    'resolution'    => 0.1,
                    'display_value' => 'text',
                    'required'      => array (
                        array( 'top_bar', 'equals', true ),
                    ),
                    'compiler'      => true
                ),
                array (
                    'id'       => 'top_bar_color',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Top bar text color', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the top text color scheme.', 'xstore' ),
                    'options'  => array (
                        'dark'  => esc_html__( 'Dark', 'xstore' ),
                        'white' => esc_html__( 'White', 'xstore' ),
                    ),
                    'default'  => 'dark',
                    'required' => array (
                        array( 'top_bar', 'equals', true ),
                    ),
                ),
                array (
                    'id'       => 'top_panel',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable top panel', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the top panel opened by click on an arrow at the middle of the top bar. You can add the Top panel content at the Appearance > Widgets > Top panel.', 'xstore' ),
                    'default'  => true,
                    'required' => array (
                        array( 'top_bar', 'equals', true ),
                    ),
                ),
            )
        ) );
        
        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Search', 'xstore' ),
            'id'         => 'search',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'search_form',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Search widget position', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the area where you want to display Search widget in the header or disable it at all. Design of the search widget depends on the header type.', 'xstore' ),
                    'options'  => array (
                        'header'   => esc_html__( 'Header', 'xstore' ),
                        'tb-left'  => esc_html__( 'Top bar left', 'xstore' ),
                        'tb-right' => esc_html__( 'Top bar right', 'xstore' ),
                        'menu'     => esc_html__( 'Menu', 'xstore' ),
                        false      => esc_html__( 'Disable', 'xstore' ),
                    ),
                    'default' => 'header',
                ),
                array (
                    'id'       => 'search_ajax',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'AJAX Search', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to deliver users instant and changing results in the dropdown as they type in the search field. Users can click through from the dropdown to the ‘View All’ search page', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'search_form', 'equals', array( 'header', 'tb-left', 'tb-right', 'menu' ) )
                    )
                ),
                array (
                    'id'       => 'search_ajax_post',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Search by posts', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to include posts in the search results.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'search_ajax', 'equals', true)
                    )
                ),
                array (
                    'id'       => 'search_ajax_page',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Search by pages', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to include pages in the search results.', 'xstore' ),
                    'default'  => false,
                    'required' => array(
                        array( 'search_ajax', 'equals', true),
                        array( 'search_ajax_post', 'equals', true)
                    )
                ),
                array (
                    'id'       => 'search_ajax_product',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Search by products', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to include products in the search results.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'search_ajax', 'equals', true)
                    )
                ),
                array (
                    'id'       => 'search_by_sku',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Search by SKU', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to search products by SKU.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'search_form', 'equals', array( 'header', 'tb-left', 'tb-right', 'menu' ) ) 
                    )
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Fixed Header', 'xstore' ),
            'id'         => 'fixed-header',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'fixed_header',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Fixed header type', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the type of the fixed header appearance or disable it. Fixed - display fixed header once you scroll down, Smart - display fixed header once you scroll up.', 'xstore' ),
                    'options'  => array (
                        'fixed' => esc_html__( 'Fixed', 'xstore' ),
                        'smart' => esc_html__( 'Smart', 'xstore' ),
                        ''      => esc_html__( 'Disable', 'xstore' ),
                    ),
                    'default'  => ''
                ),
                array (
                    'id'       => 'fixed_header_color',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Fixed header text color', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the fixed header text/icons color scheme.', 'xstore' ),
                    'options'  => array (
                        'dark'  => esc_html__( 'Dark', 'xstore' ),
                        'white' => esc_html__( 'White', 'xstore' ),
                    ),
                    'default'  => 'dark'
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'fixed_header_bg',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Fixed header background', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the fixed header background.', 'xstore' ),
                    ),
                    array('.fixed-header')
                ),
                array (
                    'id'            => 'fixed_header_bg_opacity',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Fixed header background opacity', 'xstore' ),
                    'subtitle'      => esc_html__( 'Controls the fixed header background opacity.', 'xstore' ),
                    'default'       => 1.0,
                    'min'           => 0,
                    'step'          => .1,
                    'max'           => 1,
                    'resolution'    => 0.1,
                    'display_value' => 'text',
                    'compiler'      => true
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Mobile Header', 'xstore' ),
            'id'         => 'mobile-header',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'mobile_header_color',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Mobile header text color', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the mobile header text/icons color scheme.', 'xstore' ),
                    'options'  => array (
                        'dark'  => esc_html__( 'Dark', 'xstore' ),
                        'white' => esc_html__( 'White', 'xstore' ),
                    ),
                    'default'  => 'dark'
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'mobile_header_bg',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Mobile header background', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the mobile header background.', 'xstore' ),
                    ),
                    array( '.mobile-device .header-bg-block' )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'mobile_header_padding',
                        'type'     => 'spacing',
                        'title'    => esc_html__( 'Mobile header paddings', 'xstore' ),
                        'subtitle' => esc_html__( 'PControls the paddings of the mobile header area. Choose, also the valid CSS unit from the drop-down.', 'xstore' ),
                        'units'          => array ( 'em', 'px', '%', 'vh', 'vw' ),
                        'units_extended' => 'false',
                        'default'  => '',
                    ),
                    array( '.mobile-device .header-wrapper header .container-wrapper, .mobile-device .header-wrapper.header-center2 .top-bar' )
                ),
                array (
                    'id'       => 'mobile_account',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'My account in mobile menu', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show my account link in the mobile menu area below the mobile menu links.', 'xstore' ),
                    'default'  => true
                ),
                array (
                    'id'       => 'mobile_menu_logo_switcher',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Logo in mobile menu', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show site logo in the mobile menu area above the mobile menu links.', 'xstore' ),
                    'default'  => true
                ),
                array (
                    'id'    => 'mobile_menu_logo',
                    'type'  => 'media',
                    'title' => esc_html__( 'Logo image', 'xstore' ),
                    'subtitle' => esc_html__( 'Upload logo image for the mobile menu header area.', 'xstore' ),
                    'required' => array('mobile_menu_logo_switcher', 'equals', true)
                ),
                array (
                    'id'       => 'mobile_promo_popup',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Promo popup in mobile menu', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show my Promo popup link in the mobile menu area below the mobile menu links.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'promo_popup', 'equals', true ),
                    ),
                ),
            )
        ) );


        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Menu', 'xstore' ),
            'id'         => 'section-menu',
            'subsection' => false,
            'icon'       => 'et-admin-icon et-menu',
            'fields'     => array (
                
            )
        ) );


        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Menu options', 'xstore' ),
            'id'         => 'menu-options',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                 array (
                    'id'       => 'smart_header_menu',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Smart menu', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the appearance of the toggle icon instead of the last menu items when there is no space to show the links in one line. Do not use if your menu is not too long.', 'xstore' ),
                    'default'  => false,
                    'required' => array(
                        array( 'header_type', '!=', 'hamburger-icon' ),
                        array( 'header_type', '!=', 'vertical' ),
                        array( 'header_type', '!=', 'vertical2' )
                    )
                ),
                array (
                    'id'       => 'menu_full_width',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Mega menu full width', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to make the mega menu wrapper full width and keep mega menu columns container in the middle of the screen.', 'xstore' ),
                    'default'  => false,
                    'required' => array (
                        array( 'header_type','!=', 'hamburger-icon' ),
                        array( 'header_type', '!=', 'vertical' ),
                        array( 'header_type', '!=', 'vertical2' )
                    ),
                ),
                array (
                    'id'       => 'secondary_menu',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Secondary menu', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the additional vertical menu before the first menu item.', 'xstore' ),
                    'default'  => false,
                ),
                array (
                    'id'       => 'secondary_menu_visibility',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Secondary menu visibility', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the way to show the secondary menu.', 'xstore' ),
                    'options'  => array (
                        'opened' => esc_html__( 'Opened', 'xstore' ),
                        'on_click' => esc_html__( 'Opened by click', 'xstore' ),
                        'on_hover' => esc_html__( 'Opened on hover', 'xstore' ),
                    ),
                    'default'  => 'on_hover',
                    'required' => array(
                        array( 'secondary_menu', 'equals', true )
                    )
                ),
                array (
                    'id'       => 'secondary_menu_home',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'For home page only', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to keep the secondary menu opened only for the home page.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'secondary_menu_visibility', 'equals', 'opened')
                    )
                ),
                array (
                    'id'       => 'secondary_menu_darkening',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Darkening', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the semi-transparent dark veil over the content and highlight the menu only.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'secondary_menu_visibility', 'equals', array( 'on_click', 'on_hover' ) )
                    )
                ),
                array (
                    'id'       => 'all_departments_text',
                    'type'     => 'text',
                    'title'    => esc_html__( 'All departments text', 'xstore' ),
                    'subtitle' => esc_html__( 'This text will be displayed instead of the default "All departments" title for the secondary menu.', 'xstore' ),
                    'default'  => esc_html__( 'All departments', 'xstore' ),
                    'required' => array(
                        array( 'secondary_menu', 'equals', true )
                    )
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Menu styling', 'xstore' ),
            'id'         => 'menu-styling',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'menu_align',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Menu links align', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the alignment of the menu.', 'xstore' ),
                    'options'  => array (
                        'center' => esc_html__( 'Center', 'xstore' ),
                        'left'   => esc_html__( 'Left', 'xstore' ),
                        'right'  => esc_html__( 'Right', 'xstore' ),
                    ),
                    'default'    => 'center'
                ),
                et_compare_output_function( 
                    array (
                        'id'       => 'nav-menu-bg',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__('Menu background color', 'xstore'),
                        'subtitle' => esc_html__( 'Controls the background color of the menu.', 'xstore' ),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                        'required' => array(
                            array( 'header_type','equals', array( 'center3', 'standard', 'advanced' ) ),
                        ),
                    ),
                    array (
                        'background-color' => '.header-wrapper .navigation-wrapper, .header-wrapper.header-center3 .navigation-wrapper,  .header-wrapper.header-advanced .navigation-wrapper, .header-advanced .navigation-wrapper:before',
                        'border-color'     => '.header-wrapper.header-center3 .navigation-wrapper .menu-inner, .header-wrapper.header-center3.header-color-white .navigation-wrapper .menu-inner, .header-wrapper .navigation-wrapper .menu-inner'
                    )
                ),

                array (
                    'id' => 'menu-links-customize-container',
                    'title' => 'Main menu links',
                    'type' => 'table_closer',
                    'subtitle' => esc_html__( 'Controls  the background color, border width, style, color, radius, paddings of the links of the main menu (1st menu level) and background color, border width, style, color for the hover state.', 'xstore' ),
                    'add_info' => 'Text styles you can adjust from Typography -> Navigation',
                    'columns' => 2,
                    'text' => 'Customize'
                ),
                    array (
                        'id' => 'menu-links-styles',
                        'title' => '',
                        'type' => 'custom_column_opener',
                        'column_title' => __('Menu links', 'xstore'),
                    ),
                    et_compare_output_function(
                        array (
                            'id' => 'menu-background',
                            'title' => 'Background color',
                            'type' => 'color_rgba',
                            'options' => array (
                                'show_buttons' => false,
                            ),
                        ),
                        array( 'background-color' => '.menu-wrapper > .menu-main-container > .menu > li, .fullscreen-menu .menu > li, .fullscreen-menu .menu > li')
                    ),
                    array (
                        'id' => 'menu-border-width',
                        'title' => 'Border width',
                        'type' => 'border',
                        'color' => false,
                        'all' => false,
                        'style' => false,
                    ),
                     array (
                        'id' => 'menu-border-style',
                        'title' => 'Border style',
                        'type' => 'border',
                        'color' => false,
                        'all' => false,
                        'left' => false,
                        'right' => false,
                        'top' => false,
                        'bottom' => false,
                        'default' => array (
                            'border-style' => 'none'
                        ),
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'menu-border-color',
                            'title' => 'Border color',
                            'type' => 'color_rgba',
                            'options' => array (
                                'show_buttons' => false,
                            ),
                        ),
                        array( 'border-color' => '.menu-wrapper > .menu-main-container > .menu > li, .fullscreen-menu .menu > li, .fullscreen-menu .menu > li')
                    ),
                    array (
                        'id' => 'menu-links-border-radius',
                        'title' => 'Border radius',
                        'type' => 'border',
                        'color' => false,
                        'all' => false,
                        'style' => false,
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'menu-links-padding',
                            'title' => 'Paddings',
                            'type' => 'spacing',
                            'units' => array ( 'px', '%', 'em' ),
                        ),
                        array ('.menu-wrapper > .menu-main-container > .menu > li > a, .menu-inner .menu-wrapper > .menu-main-container .menu > li > a, .menu-wrapper .header-search')
                    ),
                    array (
                        'id' => 'menu-links-styles-closer',
                        'title' => false,
                        'type' => 'custom_column_closer',
                    ),

                    array (
                        'id' => 'menu-links-styles_hover',
                        'title' => '',
                        'type' => 'custom_column_opener',
                        'column_title' => __('Menu links on hover', 'xstore'),
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'menu-background-hover',
                            'title' => 'Background color',
                            'type' => 'color_rgba',
                            'options' => array (
                                'show_buttons' => false,
                            ),
                        ),
                        array( 'background-color' => '.menu-wrapper > .menu-main-container > .menu > li:hover, .fullscreen-menu .menu > li:hover, .fullscreen-menu .menu > li:hover, .menu-wrapper .menu .header-search:hover')
                    ),
                    array (
                        'id' => 'menu-border-width-hover',
                        'title' => 'Border width',
                        'type' => 'border',
                        'color' => false,
                        'all' => false,
                        'style' => false,
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'menu-border-style-hover',
                            'title' => 'Border style',
                            'type' => 'border',
                            'color' => false,
                            'all' => false,
                            'left' => false,
                            'right' => false,
                            'top' => false,
                            'bottom' => false,
                            'default' => array (
                                'border-style' => 'none',
                            ),
                        ),
                        array ('.menu-wrapper > .menu-main-container > .menu > li:hover, .fullscreen-menu .menu > li:hover, .fullscreen-menu .menu > li:hover, .menu-wrapper .menu .header-search:hover')
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'menu-border-color-hover',
                            'title' => 'Border color',
                            'type' => 'color_rgba',
                            'options' => array (
                                'show_buttons' => false,
                            ),
                        ),
                        array( 'border-color' => '.menu-wrapper > .menu-main-container > .menu > li:hover, .fullscreen-menu .menu > li:hover, .fullscreen-menu .menu > li:hover, .menu-wrapper .menu .header-search:hover')
                    ),
                    array (
                        'id' => 'menu-links-styles_hover_closer',
                        'title' => false,
                        'type' => 'custom_column_closer',
                    ),
                array (
                    'id' => 'menu-links-container-closer',
                    'type' => 'table_opener',
                ),

                array (
                    'id' => 'menu-links-customize-container_f',
                    'title' => __('Fixed menu links', 'xstore'),
                    'type' => 'table_closer',
                    'subtitle' => esc_html__( 'Controls the background and border color of the drop down and also radius, paddings of the links of the fixed menu (1st menu level) and background color, border width, style, color for the hover state.', 'xstore' ),
                    'add_info' => __('Text styles you can adjust from Typography -> Navigation', 'xstore'),
                    'columns' => 2,
                    'text' => __('Customize', 'xstore'),
                ),
                    array (
                        'id' => 'f_menu-links-styles',
                        'title' => '',
                        'type' => 'custom_column_opener',
                        'column_title' => __('Menu links', 'xstore'),
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'f_menu-background',
                            'title' => __('Background color', 'xstore'),
                            'type' => 'color_rgba',
                            'options' => array (
                                'show_buttons' => false,
                            ),
                        ),
                        array( 'background-color' => '.fixed-header .menu-wrapper .menu > li, .fixed-header .menu-wrapper .header-search')
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'f_menu-border-width',
                            'title' => __('Border width', 'xstore'),
                            'type' => 'border',
                            'color' => false,
                            'all' => false,
                            'style' => false,
                        ),
                        array('.fixed-header .menu-wrapper .menu > li, .fixed-header .menu-wrapper .header-search')
                    ),
                     array (
                        'id' => 'f_menu-border-style_s',
                        'title' => __('Border style', 'xstore'),
                        'type' => 'border',
                        'color' => false,
                        'all' => false,
                        'left' => false,
                        'right' => false,
                        'top' => false,
                        'bottom' => false,
                        'default' => array (
                            'border-style' => 'none'
                        ),
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'f_menu-border-color',
                            'title' => __('Border color', 'xstore'),
                            'type' => 'color_rgba',
                            'options' => array (
                                'show_buttons' => false,
                            ),
                        ),
                        array( 'border-color' => '.fixed-header .menu-wrapper .menu > li, .fixed-header .menu-wrapper .header-search')
                    ),
                    array (
                        'id' => 'f_menu-links-border-radius',
                        'title' => __('Border radius', 'xstore'),
                        'type' => 'border',
                        'color' => false,
                        'all' => false,
                        'style' => false,
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'f_menu-links-padding',
                            'title' => __('Padding', 'xstore'),
                            'type' => 'spacing',
                            'units' => array ( 'px', '%', 'em' ),
                        ),
                        array ('.fixed-header .menu-wrapper > .menu-main-container > .menu > li > a, .menu-wrapper .header-search')
                    ),
                    array (
                        'id' => 'f_menu-links-styles-closer',
                        'title' => false,
                        'type' => 'custom_column_closer',
                    ),

                    array (
                        'id' => 'f_menu-links-styles_hover',
                        'title' => '',
                        'type' => 'custom_column_opener',
                        'column_title' => __('Menu links on hover', 'xstore'),
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'f_menu-background-hover',
                            'title' => __('Background color', 'xstore'),
                            'type' => 'color_rgba',
                            'options' => array (
                                'show_buttons' => false,
                            ),
                        ),
                        array( 'background-color' => '.fixed-header .menu-wrapper .menu > li:hover, fixed-header .menu-wrapper .header-search')
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'f_menu-border-width-hover',
                            'title' => __('Border width', 'xstore'),
                            'type' => 'border',
                            'color' => false,
                            'all' => false,
                            'style' => false,
                        ),
                        array('.fixed-header .menu-wrapper .menu > li:hover, .fixed-header .menu-wrapper .header-search:hover')
                    ),
                    et_compare_output_function ( 
                        array (
                            'id' => 'f_menu-border-style-hover',
                            'title' => __('Border style', 'xstore'),
                            'type' => 'border',
                            'color' => false,
                            'all' => false,
                            'left' => false,
                            'right' => false,
                            'top' => false,
                            'bottom' => false,
                            'default' => array (
                                'border-style' => 'none',
                            ),
                        ), 
                        array('.fixed-header .menu-wrapper .menu > li:hover, .fixed-header .menu-wrapper .header-search:hover')
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'f_menu-border-color-hover',
                            'title' => __('Border color', 'xstore'),
                            'type' => 'color_rgba',
                            'options' => array (
                                'show_buttons' => false,
                            ),
                        ),
                        array( 'border-color' => '.fixed-header .menu-wrapper .menu > li:hover, .fixed-header .menu-wrapper .header-search')
                    ),
                    array (
                        'id' => 'f_menu-links-styles_hover_closer',
                        'title' => false,
                        'type' => 'custom_column_closer',
                    ),
                array (
                    'id' => 'menu-links-container-closer_f',
                    'type' => 'table_opener',
                ),

                array (
                    'id' => 'dropdown-links-customize-container',
                    'title' => __('Dropdown options', 'xstore'),
                    'type' => 'table_closer',
                    'columns' => 2,
                    'subtitle' => esc_html__( 'Controls the background color and border (color, width, style) of the dropdown and mega menu. Here you can also manage dropdown and mega menu links background for default and hover states, color of dividers, paddings.', 'xstore' ),
                    'add_info' => __('Text styles you can adjust from Typography -> Navigation', 'xstore'),
                    'text' => __('Customize', 'xstore'),
                    'container_title' => __('Menu dropdown (Mega menu)', 'xstore'),
                ),
                array (
                    'id' => 'dropdown-links-styles',
                    'title' => '',
                    'type' => 'custom_column_opener',
                    'column_title' => false,
                ),
                    et_compare_output_function (
                        array (
                            'id' => 'menu_dropdown_bg',
                            'type' => 'color_rgba',
                            'title' => __('Dropdown background', 'xstore'),
                            'options' => array (
                                'show_buttons'=> false,
                            ),
                        ),
                        array ( 'background-color' => '.nav-sublist-dropdown, .item-design-dropdown .nav-sublist-dropdown ul > li .nav-sublist ul')
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'menu_dropdown_border_color',
                            'type' => 'color_rgba',
                            'title' => __('Dropdown border color', 'xstore'),
                            'options' => array (
                                'show_buttons'=> false,
                            ),
                        ),
                        array ( 'border-color' => '.nav-sublist-dropdown, .secondary-menu-wrapper .nav-sublist-dropdown, .secondary-menu-wrapper .menu' )
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'menu_dropdown_links_bg',
                            'type' => 'color_rgba',
                            'title' => __('Dropdown links background', 'xstore'),
                            'options' => array (
                                'show_buttons'=> false,
                            ),
                        ),
                        array ( 'background-color' => '.item-design-mega-menu .nav-sublist-dropdown .nav-sublist li, .item-design-dropdown .nav-sublist-dropdown ul > li, .header-vertical .item-design-mega-menu .nav-sublist-dropdown ul > li')
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'menu_dropdown_links_bg_hover',
                            'type' => 'color_rgba',
                            'title' => __('Dropdown links background on hover', 'xstore'),
                            'options' => array (
                                'show_buttons'=> false,
                            ),
                        ),
                        array ( 'background-color' => '.item-design-mega-menu .nav-sublist-dropdown .nav-sublist li:hover, .item-design-dropdown .nav-sublist-dropdown ul > li:hover, .header-vertical .item-design-mega-menu .nav-sublist-dropdown ul > li:hover')
                    ),
                    et_compare_output_function (
                        array (
                            'id' => 'menu_dropdown_divider',
                            'type' => 'color_rgba',
                            'title' => __('Divider color', 'xstore'),
                            'options' => array (
                                'show_buttons'=> false,
                            ),
                        ),
                        array ( 'border-color' => '.item-design-mega-menu .nav-sublist-dropdown .item-level-1.menu-item-has-children')
                    ),
                array (
                    'id' => 'dropdown-links-styles-closer',
                    'title' => false,
                    'type' => 'custom_column_closer',
                ),

                array (
                    'id' => 'dropdown-links-styles_hover',
                    'title' => '',
                    'type' => 'custom_column_opener',
                    'column_title' => '',
                ),  
                    et_compare_output_function (
                        array (
                            'id' => 'menu_dropdown_links_padding',
                            'title' => __('Paddings', 'xstore'),
                            'type' => 'spacing',
                            'units' => array ( 'px', '%', 'em' ),
                        ),
                        array ('.item-design-mega-menu .nav-sublist-dropdown > .container > ul')
                    ),
                    array (
                        'id' => 'menu_dropdown_border',
                        'type' => 'border',
                        'color' => false,
                        'all' => false,
                        'style' => false,
                        'title' => __('Dropdown border width', 'xstore'),
                    ),
                    array (
                        'id' => 'menu_dropdown_border_style',
                        'type' => 'border',
                        'color' => false,
                        'all' => false,
                        'left' => false,
                        'right' => false,
                        'top' => false,
                        'bottom' => false,
                        'default' => array (
                            'border-style' => 'solid',
                        ),
                        'title' => __('Dropdown border style', 'xstore'),
                    ),
                array (
                    'id' => 'dropdown-links-styles_hover_closer',
                    'title' => false,
                    'type' => 'custom_column_closer',
                ),
                array (
                'id' => 'dropdown-container-closer',
                'type' => 'table_opener',
                ),
                array (
                    'id' => 'mobile-links-customize-container',
                    'title' => __('Mobile menu links', 'xstore'),
                    'type' => 'table_closer',
                    'subtitle' => esc_html__( 'Controls the elements color in the mobile menu.', 'xstore' ),
                    'add_info' => __('Text styles you can adjust from Typography -> Navigation', 'xstore'),
                    'container_title' => __('Mobile menu', 'xstore'),
                    'columns' => 2,
                    'text' => __('Customize', 'xstore'),
                ),
                    array (
                        'id' => 'mobile-links-styles',
                        'title' => '',
                        'type' => 'custom_column_opener',
                        'column_title' => false,
                    ),  
                        et_compare_output_function (
                            array (
                                'id' => 'mobile_bg',
                                'title' => __('Background color', 'xstore'),
                                'type' => 'color_rgba',
                                'options' => array (
                                    'show_buttons' => false,
                                ),
                            ),
                            array ( 'background-color' => '.mobile-menu-wrapper, .mobile-menu-wrapper .menu > li .sub-menu' )
                        ),
                        et_compare_output_function (
                            array (
                                'id' => 'mobile_search_input_bg',
                                'title' => __('Background color for search input', 'xstore'),
                                'type' => 'color_rgba',
                                'options' => array (
                                    'show_buttons' => false,
                                ),
                            ),
                            array ( 'background-color' => '.mobile-menu-wrapper .header-search.act-default .search-btn' )
                        ),
                        et_compare_output_function (
                            array (
                                'id' => 'mobile_search_input_active_bg',
                                'title' => __('Background color for search input', 'xstore'),
                                'type' => 'color_rgba',
                                'options' => array (
                                    'show_buttons' => false,
                                ),
                            ), 
                            array ( 'background-color' => '.mobile-menu-wrapper .header-search.act-default input[type="text"]' )
                        ),
                    array (
                        'id' => 'mobile-links-styles_closer',
                        'title' => '',
                        'type' => 'custom_column_closer',
                    ),
                    array (
                        'id' => 'mobile-links-styles2',
                        'title' => '',
                        'type' => 'custom_column_opener',
                    ),
                        et_compare_output_function (
                            array (
                                'id' => 'mobile_search_input_border_width',
                                'title' => __('Border width for search input', 'xstore'),
                                'type' => 'border',
                                'all' => false,
                                'color' => false,
                                'default' => array (
                                    'border-style' => 'none',
                                ),
                            ), 
                            array( 'border-width' => '.mobile-menu-wrapper .header-search.act-default .search-btn, .mobile-menu-wrapper .header-search.act-default input[type="text"]', 
                                                'border-style' => '.mobile-menu-wrapper .header-search.act-default .search-btn, .mobile-menu-wrapper .header-search.act-default input[type="text"]')
                        ),
                        et_compare_output_function (
                            array (
                                'id' => 'mobile_search_input_border_color',
                                'title' => __('Border color for search input ', 'xstore'),
                                'type' => 'color_rgba',
                                'options' => array (
                                    'show_buttons' => false,
                                ),
                            ),
                            array( 'border-color' => '.mobile-menu-wrapper .header-search.act-default .search-btn, .mobile-menu-wrapper .header-search.act-default input[type="text"]')
                        ),
                        et_compare_output_function (
                            array (
                                'id' => 'mobile_divider_bg',
                                'title' => __('Divider color', 'xstore'),
                                'type' => 'color_rgba',
                                'options' => array (
                                    'show_buttons' => false,
                                ),
                            ),
                            array ( 'border-color' => '.mobile-menu-wrapper .menu .menu-back a')
                        ),
                    array (
                        'id' => 'mobile-links-styles2_closer',
                        'title' => '',
                        'type' => 'custom_column_closer',
                    ),
                array (
                    'id' => 'mobile-links-customize-container_closer',
                    'title' => false,
                    'type' => 'table_opener',
                ),
                array (
                    'id' => 'secondary-menu-customize-container',
                    'title' => __('Secondary menu links', 'xstore'),
                    'type' => 'table_closer',
                    'subtitle' => esc_html__( 'Controls the styles of the secondary menu title and links.', 'xstore' ),
                    'add_info' => __('Text styles you can adjust from Typography -> Navigation', 'xstore'),
                    'text' => __('Customize', 'xstore'),
                    'columns' => 3
                ),

                    array (
                        'id' => 'secondary-menu-styles',
                        'title' => '',
                        'type' => 'custom_column_opener',
                        'column_title' => __('Secondary menu styles', 'xstore'),
                    ),  

                        et_compare_output_function (
                            array (
                                'id' => 'secondary-title-background-color',
                                'title' => __('Title background color (default active color)', 'xstore'),
                                'type' => 'color',
                                ),
                            array( 'background-color' => '.secondary-menu-wrapper .secondary-title')
                        ),

                        et_compare_output_function (
                            array (
                                'id' => 'secondary-title-border-color',
                                'title' => __('Title border color (default active color)', 'xstore'),
                                'type' => 'color',
                                ),
                            array( 'border-color' => '.secondary-menu-wrapper .secondary-title')
                        ),

                        et_compare_output_function (
                            array (
                                'id' => 'secondary-menu-background-color',
                                'title' => __('Background color', 'xstore'),
                                'type' => 'color',
                                ),
                            array( 'background-color' => '.secondary-menu-wrapper .menu')
                        ),

                        et_compare_output_function (
                            array (
                                'id' => 'secondary-menu-background-image',
                                'title' => __('Background image', 'xstore'),
                                'type' => 'background',
                                'background-color' => false,
                                'transparent' => false,
                                ),
                            array('.secondary-menu-wrapper .menu')
                        ),

                        array (
                            'id' => 'secondary-menu-border-width',
                            'title' => __('Border width (px)', 'xstore'),
                            'type' => 'border',
                            'color' => false,
                            'all' => false,
                            'style' => false
                        ),
                         array (
                            'id' => 'secondary-menu-border-style',
                            'title' => __('Border style', 'xstore'),
                            'type' => 'border',
                            'color' => false,
                            'all' => false,
                            'left' => false,
                            'right' => false,
                            'top' => false,
                            'bottom' => false,
                            'default' => array (
                                'border-style' => 'solid'
                            ),
                        ),
                        array (
                            'id' => 'secondary-menu-border-color',
                            'title' => __('Border color', 'xstore'),
                            'type' => 'color_rgba',
                            'options' => array (
                                'show_buttons' => false,
                            ),
                        ),

                        et_compare_output_function (
                            array (
                                'id' => 'secondary-menu-padding',
                                'title' => __('Paddings', 'xstore'),
                                'type' => 'spacing',
                                'all' => false,
                                'units' => array ( 'px', '%', 'em' ),
                            ),
                            array ('.secondary-menu-wrapper .menu')
                        ),

                    array (
                        'id' => 'secondary-menu-styles_closer',
                        'title' => '',
                        'type' => 'custom_column_closer',
                    ),

                    array (
                        'id' => 'secondary-links-styles',
                        'title' => '',
                        'type' => 'custom_column_opener',
                        'column_title' => __('Secondary links', 'xstore'),
                    ),  
                        et_compare_output_function (
                            array (
                                'id' => 'secondary-links-background',
                                'title' => __('Background color', 'xstore'),
                                'type' => 'color_rgba',
                                'options' => array (
                                    'show_buttons' => false,
                                ),
                            ), 
                            array( 'background-color' => '.secondary-menu-wrapper .menu > li')
                        ),
                        array (
                            'id' => 'secondary-links-border-width',
                            'title' => __('Border width', 'xstore'),
                            'type' => 'slider',
                            'default' => 0,
                            'step' => 1,
                            'max' => 5,
                            'resolution' => 1,
                        ),
                         array (
                            'id' => 'secondary-links-border-style',
                            'title' => __('Border style', 'xstore'),
                            'type' => 'border',
                            'color' => false,
                            'all' => false,
                            'left' => false,
                            'right' => false,
                            'top' => false,
                            'bottom' => false,
                        ),
                        et_compare_output_function (
                            array (
                                'id' => 'secondary-links-border-color',
                                'title' => __('Border color', 'xstore'),
                                'type' => 'color_rgba',
                                'options' => array (
                                    'show_buttons' => false,
                                ),
                            ), 
                            array( 'border-bottom-color' => '.secondary-menu-wrapper .menu > li > a')
                        ),
                        et_compare_output_function (
                            array (
                                'id' => 'secondary-links-padding',
                                'title' => __('Paddings', 'xstore'),
                                'type' => 'spacing',
                                'all' => false,
                                'left' => false,
                                'right' => false,
                                'units' => array ( 'px', '%', 'em' ),
                            ),
                            array('.secondary-menu-wrapper .menu > li > a')
                        ),
                    array (
                        'id' => 'secondary-links-styles_closer',
                        'title' => '',
                        'type' => 'custom_column_closer',
                    ),

                    array (
                        'id' => 'secondary-links-styles-hover',
                        'title' => '',
                        'type' => 'custom_column_opener',
                        'column_title' => __('Secondary links (hover)', 'xstore'),
                    ),
                        et_compare_output_function (
                            array (
                                'id' => 'secondary-links-background-hover',
                                'title' => __('Background color', 'xstore'),
                                'type' => 'color_rgba',
                                'options' => array (
                                    'show_buttons' => false,
                                ),
                            ), 
                            array( 'background-color' => '.secondary-menu-wrapper .menu > li:hover')
                        ),
                        et_compare_output_function (
                            array (
                                'id' => 'secondary-links-border-color-hover',
                                'title' => __('Border color', 'xstore'),
                                'type' => 'color_rgba',
                                'options' => array (
                                    'show_buttons' => false,
                                ),
                            ),
                            array( 'border-bottom-color' => '.secondary-menu-wrapper .menu > li:hover > a')
                        ),
                    array (
                        'id' => 'secondary-links-styles-hover_closer',
                        'title' => '',
                        'type' => 'custom_column_closer',
                    ),

                array (
                    'id' => 'secondary-menu-customize-container_closer',
                    'title' => false,
                    'type' => 'table_opener',
                ),

            )
        ) );
        
        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Breadcrumbs', 'xstore' ),
            'id'         => 'breadcrumbs',
            'subsection' => false,
            'icon'       => 'et-admin-icon et-breadcrumbs',
            'fields'     => array (
                array (
                    'id'       => 'breadcrumb_type',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Breadcrumbs Style', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the breadcrumbs style or disable them.', 'xstore' ),
                    'options'  => array (
                        'left2'   => esc_html__( 'Left inline', 'xstore' ),
                        'default' => esc_html__( 'Align center', 'xstore' ),
                        'left'    => esc_html__( 'Align left', 'xstore' ),
                        'disable' => esc_html__( 'Disable', 'xstore' ),
                    ),
                    'default'  => 'left2'
                ),
                array (
                    'id'       => 'cart_special_breadcrumbs',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Special breadrumbs on cart, checkout, order page', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show step by step breadcrumbs on cart, checkout and order page.', 'xstore' ),
                    'default'  => true,
                ),
                et_compare_output_function(
                    array (
                        'id'       => 'breadcrumb_bg',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Breadcrumbs background', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the background style of breadcrumbs area.', 'xstore' ),
                        'default'  => array(
                            'background-color' => '',
                            'background-image' => ''
                        ),
                    ),
                    array('.page-heading')
                ),
                array (
                    'id'       => 'breadcrumb_color',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Breadcrumbs text color', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the breadcrumbs text color scheme.', 'xstore' ),
                    'options'  => array (
                        'dark'  => esc_html__( 'Dark', 'xstore' ),
                        'white' => esc_html__( 'White', 'xstore' ),
                    ),
                    'default'  => 'dark',
                ),
                array (
                    'id'       => 'breadcrumb_effect',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Breadcrumbs effect', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the animation for the breadcrumbs area.', 'xstore' ),
                    'options'  => array (
                        'none'        => esc_html__( 'None', 'xstore' ),
                        'mouse'       => esc_html__( 'Parallax on mouse move', 'xstore' ),
                        'text-scroll' => esc_html__( 'Text animation on scroll', 'xstore' ),
                    ),
                    'default'  => 'mouse',
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'breadcrumb_padding',
                        'type'           => 'spacing',
                        'title'          => esc_html__( 'Breadcrumbs paddings', 'xstore' ),
                        'units'          => array ( 'em', 'px', '%', 'vh', 'vw' ),
                        'subtitle'       => esc_html__( 'Controls the paddings for the breadcrumbs area. Leave empty to use default values.', 'xstore' ),
                        'units_extended' => 'false',
                        'default'        => '',
                    ),
                    array( '.page-heading, .et-header-overlap .page-heading, .woocommerce-wishlist.et-header-overlap .page-heading, .woocommerce-account.et-header-overlap .page-heading' )
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'bc_breadcrumbs_font',
                        'type'           => 'typography',
                        'fonts'          => $fonts_list,
                        'title'          => esc_html__( 'Breadcrumbs font', 'xstore' ),
                        'subtitle'       => esc_html__( 'Use to change font family and font styles for the breadcrumbs links.', 'xstore' ),
                        'text-align'     => false,
                        'text-transform' => true,
                        'letter-spacing' => true,
                    ),
                    array (
                        '.page-heading .breadcrumbs',
                        '.page-heading .woocommerce-breadcrumb', 
                        '.page-heading .bbp-breadcrumb',
                        '.page-heading .a-center',
                        '.page-heading .title',
                        '.page-heading a',
                        '.page-heading .span-title',
                        '[class*=" paged-"] .page-heading.bc-type-left2 .span-title',
                        '.bbp-breadcrumb-current',
                        '.page-heading .breadcrumbs a',
                        '.page-heading .woocommerce-breadcrumb a',
                        '.page-heading .bbp-breadcrumb a'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'bc_title_font',
                        'type'           => 'typography',
                        'fonts'          => $fonts_list,
                        'title'          => esc_html__( 'Breadcrumbs title font', 'xstore' ),
                        'subtitle'       => esc_html__( 'Use to change font family and font styles for the title in the breadcrumbs.', 'xstore' ),
                        'text-align'     => false,
                        'text-transform' => true,
                        'letter-spacing' => true,
                    ),
                    array(
                        '.page-heading.bc-type-left2 .title',
                        '.page-heading.bc-type-left .title',
                        '.page-heading.bc-type-default .title',
                        '[class*=" paged-"] .page-heading .span-title:last-of-type',
                        '[class*=" paged-"] .page-heading.bc-type-left2 .span-title:last-of-type',
                        '.single-post .page-heading.bc-type-left2 #breadcrumb a:last-of-type',
                        '.bbp-breadcrumb-current'
                    )
                ),
                array (
                    'id'       => 'return_to_previous',
                    'type'     => 'switch',
                    'title'    => esc_html__( '"Return to previous page" link', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show Return to previous page link.', 'xstore' ),
                    'default'  => true,
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'bc_return_font',
                        'type'           => 'typography',
                        'fonts'          => $fonts_list,
                        'title'          => esc_html__( '"Return to previous page" font', 'xstore' ),
                        'subtitle'       => esc_html__( 'Use to change font family and font styles for the "return to previous page" link.', 'xstore' ),
                        'text-align'     => false,
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'required' => array (
                            array('return_to_previous', 'equals', true),
                        ),
                    ),
                    array('.page-heading .back-history', '.page-heading .breadcrumbs .back-history', '.page-heading .woocommerce-breadcrumb .back-history', '.page-heading .bbp-breadcrumb .back-history', '.single-post .page-heading.bc-type-left2 #breadcrumb a:last-of-type')
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Footer', 'xstore' ),
            'id'         => 'footer',
            'subsection' => false,
            'icon'       => 'et-admin-icon et-footer',
            'fields'     => array (
                
            )
        ) );


        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Footer layout', 'xstore' ),
            'id'         => 'footer-layoutr',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'footer_columns',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Footer columns', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the number of columns in footer. You can add footer content at Appearance > Widgets. You can use static blocks widgets in footer to create custom layout.', 'xstore' ),
                    'options'  => array (
                        1 => esc_html__( '1 Column', 'xstore' ),
                        2 => esc_html__( '2 Columns', 'xstore' ),
                        3 => esc_html__( '3 Columns', 'xstore' ),
                        4 => esc_html__( '4 Columns', 'xstore' ),
                    ),
                    'default'  => 4
                ),
                array (
                    'id'       => 'footer_demo',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show footer demo blocks', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn off to hide default demo content of the footer.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'footer_fixed',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Footer fixed', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to get sliding effect for the footer (footer appears under the content during scroll).', 'xstore' ),
                    'default'  => false,
                ),
            )
        ) );


        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Footer styling', 'xstore' ),
            'id'         => 'footer-styling',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'footer_color',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Footer text color scheme', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose footer text color scheme.', 'xstore' ),
                    'options'  => array (
                        'light' => esc_html__( 'Light', 'xstore' ),
                        'dark'  => esc_html__( 'Dark', 'xstore' ),
                    ),
                    'default'  => 'light'
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'footer-links',
                        'type'     => 'link_color',
                        'title'    => esc_html__( 'Footer Links', 'xstore' ),
                        'subtitle' => esc_html__( 'Choose footer links color.', 'xstore' ),
                    ),
                    array(
                        '.template-container .template-content .footer a',
                        '.template-container .template-content .footer .vc_wp_posts .widget_recent_entries li a'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'footer_bg_color',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer Background Color', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the the footer background color.', 'xstore' ),
                       ), 
                    array( 'background' => 'footer.footer' )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'footer_border',
                        'type'     => 'border',
                        'all'      => false,
                        'left' => false,
                        'right' => false,
                        'top' => false,
                        'default' => array (
                            'border-style' => 'solid',
                            'border-bottom-width' => '1',
                            'border-bottom-color' => '#e1e1e1'
                        ),
                        'title'    => esc_html__( 'Footer Border', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the the footer border.', 'xstore' ),
                       ), 
                    array( 'border' => 'footer.footer:after' )
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'footer_padding',
                        'type'           => 'spacing',
                        'title'          => esc_html__( 'Footer paddings', 'xstore' ),
                        'subtitle'       => esc_html__( 'Controls the paddings of the footer.', 'xstore' ),
                        'units'          => array ( 'em', 'px', '%', 'vh', 'vw' ),
                        'units_extended' => 'false',
                        'default'        => ''
                    ),
                    array( '.footer' )
                ),
                
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Copyrights styling', 'xstore' ),
            'id'         => 'copyright-styling',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'           => 'copyrights_color',
                    'type'         => 'select',
                    'title'        => esc_html__( 'Copyrights text color scheme', 'xstore' ),
                        'subtitle' => esc_html__( 'Choose copyrights text color scheme.', 'xstore' ),
                    'options'      => array (
                        'light' => esc_html__( 'Light', 'xstore' ),
                        'dark'  => esc_html__( 'Dark', 'xstore' ),
                    ),
                    'default'      => 'light'
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'copyrights-links',
                        'type'     => 'link_color',
                        'title'    => esc_html__( 'Copyrights Links', 'xstore' ),
                        'subtitle' => esc_html__( 'Choose copyrights links color.', 'xstore' ),
                    ),
                    array( '.footer-bottom a' )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'copyrights_bg_color',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Copyrights Background Color', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the background color of the copyrights area.', 'xstore' ),
                    ),
                    array( 'background' => '.footer-bottom')
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'copyrights_padding',
                        'type'           => 'spacing',
                        'title'          => esc_html__( 'Copyrights paddings', 'xstore' ),
                        'subtitle'       => esc_html__( 'Controls the paddings of the copyrights.', 'xstore' ),
                        'units'          => array ('em', 'px', '%', 'vh', 'vw'),
                        'units_extended' => 'false',
                        'default'        => ''
                    ),
                    array( '.footer-bottom' )
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Back to top button', 'xstore' ),
            'id'         => 'back-2-top',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'to_top',
                    'type'     => 'switch',
                    'title'    => esc_html__( '"Back To Top" button', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to have back to top button at the right bottom of the page.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'to_top_mobile',
                    'type'     => 'switch',
                    'title'    => esc_html__( '"Back To Top" button on mobile', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to have back to top button on mobile.', 'xstore' ),
                    'default'  => true,
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Styling', 'xstore' ),
            'id'         => 'style',
            'icon'       => 'et-admin-icon et-styling',
            'subsection' => false,
            'fields'     => array (
                array (
                    'id'       => 'dark_styles',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Dark version', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to switch site to dark styles.', 'xstore' ),
                ),
                array (
                    'id'       => 'activecol',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Main Color', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the main color for the site (color of links, active buttons and elements like pagination, sale price, portfolio project mask, blog image mask etc).', 'xstore' ),
                    'default'  => '#c62828',
                    'compiler' => true
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'background_img',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Site Background', 'xstore' ),
                        'subtitle' => esc_html__( 'Choose the background of the site. Visible if boxed layout is enabled.', 'xstore' ),
                    ),
                    array(
                        'background' => 'body',
                        'background-color' => '.swipers-couple-wrapper .swiper-wrapper img, .compare.button .blockOverlay:after'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'container_bg',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Container Background Color', 'xstore' ),
                        'subtitle' => esc_html__( 'Choose the background color of the template container. Template container covers the whole visible area if wide layout is enabled.', 'xstore' ),
                        'options'  => array (
                            'show_buttons' => false,
                        )
                    ),
                    array('background-color' =>'article.content-timeline2 .timeline-content, .select2-results, .select2-drop, .select2-container .select2-choice, .form-control, .page-wrapper, .compare.button .blockOverlay:after,  .cart-popup-container, .emodal, #searchModal, .quick-view-popup, #etheme-popup, .et-wishlist-widget .wishlist-dropdown, .swipers-couple-wrapper .swiper-wrapper img')
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'forms_inputs_bg',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Inputs background color', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the background color of the all the inputs.', 'xstore' ),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                    ),
                    array('background-color' =>'.select2-results, .select2-drop, .select2-container .select2-choice, .form-control, select, .select2.select2-container--default .select2-selection--single, .quantity input[type="number"], .emodal, input[type="text"], input[type="email"], input[type="password"], input[type="tel"], input[type="url"], textarea, textarea.form-control, textarea, input[type="search"], .select2-container--default .select2-selection--single, .header-search.act-default input[type="text"], .header-wrapper.header-advanced .header-search.act-default input[type="text"], .header-wrapper.header-advanced .header-search.act-default div.fancy-select div.trigger')
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'forms_inputs_br',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Inputs border color', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the border color of all the inputs.', 'xstore' ),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                    ),
                    array('border-color' =>'.select2-results, .select2-drop, .select2-container .select2-choice, .form-control, select, .quantity input[type="number"], div.quantity span, td.quantity span, .emodal, input[type="text"], input[type="email"], input[type="password"], input[type="tel"], input[type="url"], textarea, textarea.form-control, textarea, .header-search.act-default input[type="text"], .header-wrapper.header-advanced .header-search.act-default input[type="text"], .header-wrapper.header-advanced .header-search.act-default div.fancy-select div.trigger, .header-wrapper.header-advanced .search-form-wrapper, .select2-container--default .select2-selection--single'
                    )
                ),
                array (
                    'id'       => 'buttons-customize-container',
                    'title'    => esc_html__( 'Customize buttons', 'xstore' ),
                    'subtitle' => esc_html__( 'Manage styles of 3 types of the default buttons used on the site (active, light, dark).', 'xstore' ),
                    'type'     => 'table_closer',
                    'columns'  => 3,
                    'text'     => esc_html__('Customize', 'xstore'),
                ),
                array (
                    'id'           => 'light-buttons-column',
                    'title'        => '',
                    'type'         => 'custom_column_opener',
                    'column_title' => esc_html__( 'Light buttons options', 'xstore' ),
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'light_buttons_bg',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__('Background color', 'xstore'),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                    ),
                    array( 'background-color' => 'input[type="submit"], .content-product .product-details .button, .woocommerce table.wishlist_table td.product-add-to-cart a, .woocommerce-Button, .et_load-posts .btn' )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'light_buttons_color',
                        'type'     => 'link_color',
                        'title'    => esc_html__( 'Buttons text colors', 'xstore' ),
                        'hover'    => false,
                    ),
                    array(
                        'input[type="submit"]',
                        '.content-product .product-details .button',
                        '.woocommerce table.wishlist_table td.product-add-to-cart a',
                        '.woocommerce-Button',
                        '.et_load-posts .btn a'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'light_buttons_border',
                        'type'     => 'border',
                        'title'    => esc_html__('Buttons border', 'xstore'),
                        'all'      => false,
                        'default' => array (
                            'border-style' => 'solid',
                            'border-color' => '#f2f2f2'
                        ),
                    ),
                    array ( 'input[type="submit"], .content-product .product-details .button, .woocommerce table.wishlist_table td.product-add-to-cart a, .woocommerce-Button, .et_load-posts .btn' )
                ),
                array (
                    'id'       => 'light_buttons_border_radius',
                    'title'    => esc_html__('Buttons border radius', 'xstore'),
                    'type'     => 'border',
                    'all'      => false,
                    'style'    => false,
                    'color'    => false,
                    'default'  => array (
                        'border-top'    => '0px', 
                        'border-right'  => '0px', 
                        'border-bottom' => '0px', 
                        'border-left'   => '0px'
                    ),
                ),
                array (
                    'id'    => 'light-buttons-column-closer',
                    'title' => false,
                    'type'  => 'custom_column_closer',
                ),

                array (
                    'id'           => 'dark-buttons-column',
                    'title'        => false,
                    'type'         => 'custom_column_opener',
                    'column_title' => esc_html__('Dark buttons options', 'xstore'),
                ),
                et_compare_output_function (
                     array (
                        'id'       => 'dark_buttons_bg',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Background color', 'xstore' ),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                    ),
                    array( 'background-color' => ' .et-wishlist-widget .wishlist-dropdown .buttons .btn-view-wishlist, .before-checkout-form .button, .checkout-button, .shipping-calculator-form .button, .single_add_to_cart_button.button, .btn-checkout, .product_list_widget .buttons a, form.login .button, form.register .button, .empty-cart-block .btn, .form-submit input[type="submit"]' )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'dark_buttons_color',
                        'type'     => 'link_color',
                        'title'    => esc_html__('Buttons text colors', 'xstore'),
                        'hover'    => false,
                    ),
                    array(
                        '.et-wishlist-widget .wishlist-dropdown .buttons .btn-view-wishlist',
                        '.before-checkout-form .button',
                        '.checkout-button',
                        '.shipping-calculator-form .button',
                        '.single_add_to_cart_button.button',
                        '.single_add_to_cart_button.button:focus',
                        '.btn-checkout',
                        '.product_list_widget .buttons a',
                        'form.login .button',
                        'form.register .button',
                        '.empty-cart-block .btn',
                        '.form-submit input[type="submit"]',
                        '.form-submit input[type="submit"]:focus'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'dark_buttons_border',
                        'type'     => 'border',
                        'title'    => esc_html__('Buttons border', 'xstore'),
                        'all'      => false,
                        'default'  => array (
                            'border-style' => 'solid',
                            'border-color' => '#222'
                        ),
                    ),
                    array('.et-wishlist-widget .wishlist-dropdown .buttons .btn-view-wishlist, .before-checkout-form .button, .checkout-button, .shipping-calculator-form .button, .single_add_to_cart_button.button, .btn-checkout, .product_list_widget .buttons a, form.login .button, form.register .button, .empty-cart-block .btn, .form-submit input[type="submit"]')
                ),
                array (
                    'id'       => 'dark_buttons_border_radius',
                    'title'    => esc_html__( 'Buttons border radius', 'xstore' ),
                    'type'     => 'border',
                    'all'      => false,
                    'style'    => false,
                    'color'    => false,
                    'default' => array (
                        'border-top'    => '0px', 
                        'border-right'  => '0px', 
                        'border-bottom' => '0px', 
                        'border-left'   => '0px'
                    ),
                ),
                array (
                    'id'    => 'dark-buttons-column-closer',
                    'title' => '',
                    'type'  => 'custom_column_closer',
                ),
                array (
                    'id'           => 'active-buttons-column',
                    'title'        => false,
                    'type'         => 'custom_column_opener',
                    'column_title' => esc_html__( 'Active buttons options', 'xstore' ),
                ),  
                et_compare_output_function (
                    array (
                        'id'       => 'active_buttons_bg',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Background color', 'xstore' ),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                    ),
                    array( 'background-color' => '.form-row.place-order .button' )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'active_buttons_color',
                        'type'     => 'link_color',
                        'title'    => esc_html__('Buttons text colors', 'xstore'),
                        'hover'    => false,
                    ),
                    array( '.form-row.place-order .button' )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'active_buttons_border',
                        'type'     => 'border',
                        'title'    => esc_html__('Buttons border', 'xstore'),
                        'all'      => false,
                        'default' => array (
                            'border-style' => 'solid',
                            'border-color' => '#f2f2f2'
                        ),
                    ),
                    array( '.form-row.place-order .button' )
                ),
                array (
                    'id'       => 'active_buttons_border_radius',
                    'title'    => esc_html__( 'Buttons border radius', 'xstore' ),
                    'type'     => 'border',
                    'all'      => false,
                    'style'    => false,
                    'color'    => false,
                    'default' => array (
                        'border-top'    => '0px', 
                        'border-right'  => '0px', 
                        'border-bottom' => '0px', 
                        'border-left'   => '0px'
                    ),
                ),  
                array (
                    'id'    => 'active-buttons-column-closer',
                    'title' => '',
                    'type'  => 'custom_column_closer',
                ),

                array (
                    'id'   => 'buttons-container-closer',
                    'type' => 'table_opener',
                ),

                array (
                    'id'       => 'buttons-hoverCustomize-container',
                    'title'    => esc_html__( 'Customize buttons on hover state', 'xstore' ),
                    'subtitle' => esc_html__( 'Manage hover styles of 3 types of the default buttons used on the site (active, light, dark).', 'xstore' ),
                    'type'     => 'table_closer',
                    'columns'  => 3,
                    'text'     => esc_html__( 'Customize', 'xstore' ),
                ),
                array (
                    'id'           => 'light-buttons-hover-column',
                    'title'        => false,
                    'type'         => 'custom_column_opener',
                    'column_title' => esc_html__('Light buttons options (hover)', 'xstore'),
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'light_buttons_bg_hover',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__('Background color', 'xstore'),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                    ),
                    array( 'background-color' => 'input[type="submit"]:hover, .content-product .product-details .button:hover, .woocommerce table.wishlist_table td.product-add-to-cart a:hover, .woocommerce-Button:hover, .et_load-posts .btn:hover' )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'light_buttons_color_hover',
                        'type'     => 'link_color',
                        'title'    => esc_html__( 'Buttons text colors', 'xstore' ),
                        'regular'  => false,
                        'active'   => false,
                    ),
                    array(
                        'input[type="submit"]',
                        '.content-product .product-details .button',
                        '.woocommerce table.wishlist_table td.product-add-to-cart a',
                        '.woocommerce-Button',
                        '.et_load-posts .btn a'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'light_buttons_border_hover',
                        'type'     => 'border',
                        'title'    => esc_html__('Buttons border', 'xstore'),
                        'all'      => false,
                        'default' => array (
                            'border-style' => 'solid',
                        ),
                    ),
                    array('input[type="submit"]:hover, .content-product .product-details .button:hover, .woocommerce table.wishlist_table td.product-add-to-cart a:hover, .woocommerce-Button:hover, .et_load-posts .btn:hover')
                ),
                array (
                    'id'    => 'light-buttons-hover-column-closed',
                    'title' => '',
                    'type'  => 'custom_column_closer',
                ),
                array (
                    'id'           => 'dark-buttons-hover-column',
                    'title'        => '',
                    'type'         => 'custom_column_opener',
                    'column_title' => esc_html__('Dark buttons options (hover)', 'xstore'),
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'dark_buttons_bg_hover',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Background color', 'xstore' ),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                    ),
                    array( 'background-color' => ' .et-wishlist-widget .wishlist-dropdown .buttons .btn-view-wishlist:hover, .before-checkout-form .button:hover, a.checkout-button:hover, .shipping-calculator-form .button:hover, .single_add_to_cart_button.button:hover, .btn-checkout:hover, .product_list_widget .buttons a:hover, .form-row.place-order .button:hover, form.login .button:hover, form.register .button:hover, .empty-cart-block .btn:hover, .form-submit input[type="submit"]:hover' )
                ),
                 
                et_compare_output_function (
                    array (
                        'id'       => 'dark_buttons_color_hover',
                        'type'     => 'link_color',
                        'title'    => esc_html__( 'Buttons text colors', 'xstore' ),
                        'regular'  => false,
                        'active'  => false,
                    ),
                    array(
                        '.et-wishlist-widget .wishlist-dropdown .buttons .btn-view-wishlist',
                        '.before-checkout-form .button',
                        '.checkout-button',
                        '.shipping-calculator-form .button',
                        '.single_add_to_cart_button.button',
                        '.single_add_to_cart_button.button:focus',
                        '.btn-checkout',
                        '.product_list_widget .buttons a',
                        'form.login .button',
                        'form.register .button',
                        '.empty-cart-block .btn',
                        '.form-submit input[type="submit"]',
                        '.form-submit input[type="submit"]:focus'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'dark_buttons_border_hover',
                        'type'     => 'border',
                        'title'    => esc_html__('Buttons border', 'xstore'),
                        'all'      => false,
                        'default'  => array (
                            'border-style' => 'solid',
                        ),
                    ),
                    array('.et-wishlist-widget .wishlist-dropdown .buttons .btn-view-wishlist:hover, .before-checkout-form .button:hover, a.checkout-button:hover, .shipping-calculator-form .button:hover, .single_add_to_cart_button.button:hover, .btn-checkout:hover, .product_list_widget .buttons a:hover, .form-row.place-order .button:hover, form.login .button:hover, form.register .button:hover, .empty-cart-block .btn:hover, .form-submit input[type="submit"]:hover')
                ),
                array (
                    'id'    => 'dark-buttons-hover-column-closed',
                    'title' => '',
                    'type'  => 'custom_column_closer',
                ),
                array (
                    'id'           => 'active-buttons-hover-column',
                    'title'        => '',
                    'type'         => 'custom_column_opener',
                    'column_title' => esc_html__( 'Active buttons options (hover)', 'xstore' ),
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'active_buttons_bg_hover',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__('Background color', 'xstore'),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                    ),
                    array( 'background-color' => '.form-row.place-order .button:hover' )
                ),
               et_compare_output_function (
                    array (
                        'id'       => 'active_buttons_color_hover',
                        'type'     => 'link_color',
                        'title'    => esc_html__( 'Buttons text colors', 'xstore' ),
                        'regular'  => false,
                        'active'   => false,
                    ),
                    array( '.form-row.place-order .button' )
                ),
                   et_compare_output_function (
                        array (
                            'id'       => 'active_buttons_border_hover',
                            'type'     => 'border',
                            'title'    => esc_html__('Buttons border', 'xstore'),
                            'all'      => false,
                            'default'  => array (
                                'border-style' => 'solid',
                            ),
                        ),
                        array( '.form-row.place-order .button:hover' )
                    ),
                array (
                    'id'    => 'active-buttons-hover-column-closed',
                    'title' => '',
                    'type'  => 'custom_column_closer',
                ),
                array (
                    'id'    => 'buttons-hoverCustomize-container-closed',
                    'title' => '',
                    'type'  => 'table_opener',
                ),
                array (
                    'id'       => 'slider_arrows_colors',
                    'type'     => 'select',
                    'options'    => array (
                        'transparent' => esc_html__('Transparent', 'xstore'),
                        'custom' => esc_html__('Custom', 'xstore'),
                    ),
                    'title'    => esc_html__( 'Make all slider\'s arrows without background or with your custom color', 'xstore' ),
                    'subtitle' => esc_html__( 'Style sliders arrows', 'xstore' ),
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'slider_arrows_bg_color',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__('Slider arrows background color', 'xstore'),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                        'required' => array (
                            array ('slider_arrows_colors', 'equals', 'custom'),
                        )
                    ),
                    array( 'background-color' => '.swiper-custom-right, .swiper-custom-left, .swiper-custom-right:hover, .swiper-custom-left:hover' )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'slider_arrows_color',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__('Slider arrows color', 'xstore'),
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                    ),
                    array( 'color' => '.swiper-custom-right:before, .swiper-custom-left:before, .swiper-custom-right:hover:before, .swiper-custom-left:hover:before' )
                ),
                array (
                    'id'       => 'bold_icons',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Bold weight for icons', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to make all the default icons (cart, search, wishlist, arrows etc) bold.', 'xstore' ),
                ),
            ),
        ));


        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Typography', 'xstore' ),
            'id'         => 'typography',
            'subsection' => false,
            'icon'       => 'et-admin-icon et-typography',
            'fields'     => array (
                
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Content', 'xstore' ),
            'id'         => 'typography-content',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                et_compare_output_function (
                    array (
                        'id'             => 'sfont',
                        'type'           => 'typography',
                        'fonts'          => $fonts_list,
                        'title'          => esc_html__( 'Body Font', 'xstore' ),
                        'subtitle'       => esc_html__( 'Controls the font of the body.', 'xstore' ),
                        'text-align'     => false,
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'        => array (
                            "font-family" => "Lato",
                            "font-weight" => "400",
                            "color"       => "#555"
                        ),
                    ),
                    array (
                        'body',
                        '.quantity input[type="number"]',
                        '.page-wrapper',
                        'p'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'headings',
                        'type'           => 'typography',
                        'fonts'          => $fonts_list,
                        'title'          => esc_html__( 'Headings', 'xstore' ),
                        'subtitle'       => esc_html__( 'Controls the font of the headings.', 'xstore' ),
                        'text-align'     => false,
                        'font-size'      => false,
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'        => array (
                            "font-family" => "Lato",
                            "font-weight" => "400",
                        ),
                    ),
                    array (
                        'h1',
                        'h2',
                        'h3',
                        'h4',
                        'h5',
                        'h6',
                        '.title h3',
                        'blockquote',
                        '.share-post .share-title',
                        '.sidebar-widget .tabs .tab-title',
                        '.widget-title',
                        '.related-posts .title span',
                        '.content-product .product-title a',
                        '.results-ajax-list .ajax-item-title',
                        'table.cart .product-details .product-title',
                        '.product_list_widget li .product-title a',
                        '.woocommerce table.wishlist_table .product-name a',
                        '.comment-reply-title',
                        '.et-tabs .vc_tta-title-text',
                        '.single-product-right .product-information-inner .product_title',
                        '.single-product-right .product-information-inner h1.title',
                        '.post-heading h2 a',
                        '.sidebar .recent-posts-widget .post-widget-item h4 a',
                        '.et-tabs-wrapper .tabs .accordion-title span',
                        '.products-title'
                    )
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Menu', 'xstore' ),
            'id'         => 'menu',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                et_compare_output_function (
                    array (
                        'id'             => 'menu_level_1',
                        'type'           => 'typography',
                        'fonts'          => $fonts_list,
                        'title'          => esc_html__( 'Menu 1 level', 'xstore' ),
                        'subtitle'       => esc_html__( 'Controls the font of the first level of the main menu.', 'xstore' ),
                        'text-align'     => false,
                        'text-transform' => true,
                        'letter-spacing' => true,
                    ),
                    array (
                        '.menu-wrapper > .menu-main-container .menu > li > a',
                        '.mobile-menu-wrapper .menu > li > a',
                        '.mobile-menu-wrapper .links li a',
                        '.secondary-title',
                        '.header-vertical .menu-wrapper > .menu-main-container .menu > li > a',
                        '.fullscreen-menu .menu > li > a',
                        '.fullscreen-menu .menu > li .inside > a',
                        '.menu-wrapper .menu > .header-search a',
                        '.mobile-menu-wrapper .my-account-link > a', 
                        '.mobile-menu-wrapper .login-link > a'
                    )
                ),
                et_compare_output_function (
                     array (
                        'id'       => 'menu_level_1_hover',
                        'type'     => 'color_rgba',
                        'options'  => array (
                            'show_buttons' => false,
                            'show_alpha'   => false,
                        ),
                        'title'    => esc_html__( 'Menu 1 level (hover)', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the hover color of the links of the first menu level.', 'xstore' ),
                    ),
                    array (
                        '.menu-wrapper .menu > li:hover > a',
                        '.header-vertical .menu-wrapper > .menu-main-container .menu > li:hover > a',
                        '.mobile-menu-wrapper .menu > li:hover > a',
                        '.mobile-menu-wrapper .links li:hover a',
                        '.fullscreen-menu .menu > li:hover > a',
                        '.fullscreen-menu .menu > li .inside > a:hover',
                        '.menu-wrapper .menu > .header-search:hover > a',
                        '.mobile-menu-wrapper .my-account-link:hover > a', 
                        '.mobile-menu-wrapper .login-link:hover > a'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'f_menu_level_1',
                        'type'     => 'color_rgba',
                        'options'  => array (
                            'show_buttons' => false,
                            'show_alpha'   => false,
                        ),
                        'title'    => esc_html__( 'Fixed menu links colors', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the font of the first level of the fixed menu.', 'xstore' ),
                    ),
                    array (
                        '.fixed-header .menu-wrapper .menu > li > a',
                        'fixed-header .menu-wrapper .menu > .header-search a'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'f_menu_level_1_hover',
                        'type'     => 'color_rgba',
                        'options'  => array (
                            'show_buttons' => false,
                            'show_alpha'   => false,
                        ),
                        'title'    => esc_html__( 'Fixed menu links colors (hover)', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the hover color of the fixed menu links.', 'xstore' ),
                    ),
                    array (
                        '.fixed-header .menu-wrapper .menu > li > a:hover',
                        'fixed-header .menu-wrapper .menu > .header-search a'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'menu_level_2',
                        'type'           => 'typography',
                        'fonts'          => $fonts_list,
                        'title'          => esc_html__( 'Menu 2 level', 'xstore' ),
                        'subtitle'       => esc_html__( 'Controls the font of the second level of the main menu.', 'xstore' ),
                        'text-align'     => false,
                        'text-transform' => true,
                        'letter-spacing' => true,
                    ),
                    array (
                        '.menu-item-has-children .nav-sublist-dropdown .item-level-1 > a',
                        '.fullscreen-menu .menu-item-has-children .nav-sublist-dropdown li a',
                        '.secondary-menu-wrapper .item-design-dropdown.menu-item-has-children ul .item-level-1 a',
                        '.header-vertical .menu-wrapper .menu-main-container ul .item-level-1 > a'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'menu_level_2_hover',
                        'type'     => 'color_rgba',
                        'options'  => array (
                            'show_buttons' => false,
                            'show_alpha'   => false,
                        ),
                        'title'    => esc_html__( 'Menu 2 level (hover)', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the hover color of the of the second menu level links.', 'xstore' ),
                    ),
                    array (
                        '.menu-item-has-children .nav-sublist-dropdown .item-level-1 > a:hover',
                        '.fullscreen-menu .menu-item-has-children .nav-sublist-dropdown li a:hover',
                        '.secondary-menu-wrapper .item-design-dropdown.menu-item-has-children ul .item-level-1 a:hover',
                        '.header-vertical .menu-wrapper .menu-main-container ul .item-level-1:hover > a'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'menu_level_3',
                        'type'           => 'typography',
                        'fonts'          => $fonts_list,
                        'title'          => esc_html__( 'Menu 3 level and drop-downs', 'xstore' ),
                        'subtitle'       => esc_html__( 'Controls the font of the third level of the main menu and drop-downs.', 'xstore' ),
                        'text-align'     => false,
                        'text-transform' => true,
                        'letter-spacing' => true,
                    ),
                    array (
                        '.menu-item-has-children .nav-sublist-dropdown .item-level-2 > a',
                        '.fullscreen-menu .menu-item-has-children .nav-sublist-dropdown .item-level-2 a',
                        '.header-vertical .menu-wrapper .menu-main-container ul .item-level-2 > a'
                    )
                ),
                et_compare_output_function (
                     array (
                        'id'       => 'menu_level_3_hover',
                        'type'     => 'color_rgba',
                        'options'  => array (
                            'show_buttons' => false,
                            'show_alpha'   => false,
                        ),
                        'title'    => esc_html__('Menu 3 level and drop-downs hover (active)', 'xstore'),
                        'subtitle' => esc_html__( 'Controls the hover and active color of the links of the third menu level and drop-downs.', 'xstore' ),
                    ),
                    array (
                        '.menu-item-has-children .nav-sublist-dropdown .item-level-2 > a:hover',
                        '.fullscreen-menu .menu-item-has-children .nav-sublist-dropdown .item-level-2 a:hover',
                        '.header-vertical .menu-wrapper .menu-main-container ul .item-level-2:hover > a'
                    )
                ),

                // ! option start/ close table
                array (
                    'id'       => 'mobile-menu-colors',
                    'title'    => esc_html__( 'Customize mobile menu links', 'xstore' ),
                    'type'     => 'table_closer',
                    'columns'  => 2,
                    'text'     => esc_html__( 'Customize', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the text color of the mobile menu elements.', 'xstore' ),

                ),
                // ! open column
                array (
                    'id'           => 'mobile-colors',
                    'title'        => false,
                    'type'         => 'custom_column_opener',
                    'column_title' => esc_html__( 'Mobile menu links', 'xstore' ),
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'mobile-links-fonts',
                        'type'           => 'typography',
                        'title'          => esc_html__( 'Typography for mobile links', 'xstore' ),
                        'fonts'          => $fonts_list,
                        'color'          => false,
                        'text-align'     => false,
                        'text-transform' => true,
                        'letter-spacing' => true,
                    ),
                    array (
                        '.mobile-menu-wrapper .menu > li > a',
                        '.mobile-menu-wrapper .menu > li .sub-menu li a',
                        '.mobile-menu-wrapper .links li a',
                        '.mobile-menu-wrapper .my-account-link > a', 
                        '.mobile-menu-wrapper .login-link > a'
                    )
                ),

                // ! close collumn
                array (
                    'id'   => 'mobile-colors-closer',
                    'type' => 'custom_column_closer',
                ),

                // ! open collumn
                array (
                    'id'           => 'mobile-title-colors',
                    'title'        => false,
                    'type'         => 'custom_column_opener',
                    'column_title' => esc_html__( 'Colors', 'xstore' ),
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'mobile-links-colors-regular',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Mobile links regular color', 'xstore' ),
                        'hover'    => false,
                        'active'   => false,
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                    ),
                    array ( '.mobile-menu-wrapper .menu > li > a, 
                        .mobile-menu-wrapper .menu > li > .open-child, 
                        .mobile-menu-wrapper .menu > li .sub-menu li a, 
                        .mobile-menu-wrapper .links li a, 
                        .mobile-menu-wrapper .menu-back a,
                        .mobile-menu-wrapper .mobile-sidebar-widget.etheme_widget_socials a, 
                        .mobile-menu-wrapper .menu > li .open-child:before, 
                        .mobile-menu-wrapper .menu > li .sub-menu .menu-show-all a,
                        .mobile-menu-wrapper .my-account-link > a, 
                        .mobile-menu-wrapper .login-link > a' )
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'mobile-links-colors-hover',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Mobile links color (hover, active states)', 'xstore' ),
                        'regular'  => false,
                        'active'   => false,
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                    ),
                    array ('.mobile-menu-wrapper .container .menu > li > a:hover, 
                        .mobile-menu-wrapper .container .menu > li:hover > .open-child, 
                        .mobile-menu-wrapper .container .menu > li .sub-menu li a:hover, 
                        .mobile-menu-wrapper .container .links li a:hover, 
                        .mobile-menu-wrapper .container .menu-back a:hover,
                        .mobile-menu-wrapper .mobile-sidebar-widget.etheme_widget_socials a:hover,
                        .mobile-menu-wrapper .menu > li.current_page_item > a, 
                        .mobile-menu-wrapper .menu > li .sub-menu li.current_page_item a, 
                        .mobile-menu-wrapper .links li.current_page_item a, 
                        .mobile-menu-wrapper .menu li.current_page_item > .open-child:before, 
                        .mobile-menu-wrapper .menu .current-menu-item > a, 
                        .mobile-menu-wrapper .menu > li .sub-menu .current-menu-item > a,
                        .mobile-menu-wrapper .my-account-link:hover > a, 
                        .mobile-menu-wrapper .login-link:hover > a')
                ),
                et_compare_output_function (
                    array (
                        'id'          => 'mobile-search-colors',
                        'type'        => 'color_rgba',
                        'options'     => array (
                            'show_buttons' => false,
                            'show_alpha'   => false,
                        ),
                        'title'       => esc_html__( 'Search color', 'xstore' ),
                        'transparent' => false,
                    ),
                    array ( '.mobile-menu-wrapper .header-search.act-default .search-btn,
                        .mobile-menu-wrapper .header-search [role="searchform"] .btn,
                        .mobile-menu-wrapper .header-search.act-default input[type="text"],
                        .mobile-menu-wrapper .header-search.act-default input[type="text"]::-webkit-input-placeholder' )
                ),

                // ! close collumn 
                array (
                    'id'   => 'mobile-title-colors-closer',
                    'type' => 'custom_column_closer',
                ),

                // ! option end/open table again
                 array (
                    'id'   => 'mobile-menu-colors-closer',
                    'type' => 'table_opener',
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Secondary menu', 'xstore' ),
            'id'         => 'secondary-menu',
            'subsection' => true,
            // 'icon'       => 'el-icon-cog',
            'fields'     => array (
                et_compare_output_function (
                     array (
                        'id'       => 'secondary_title',
                        'type'     => 'color_rgba',
                        'options'  => array (
                            'show_buttons' => false,
                            'show_alpha'   => false,
                        ),
                        'title'    => esc_html__( 'Secondary title color', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls the font of the secondary menu title.', 'xstore' ),
                    ),
                    array ( '.secondary-menu-wrapper .secondary-title' )
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'secondary-menu_level_1',
                        'type'           => 'typography',
                        'fonts'          => $fonts_list,
                        'title'          => esc_html__( 'Menu first level font', 'xstore' ),
                        'subtitle'       => esc_html__( 'Controls the font of the first level of the secondary menu.', 'xstore' ),
                        'text-align'     => false,
                        'text-transform' => true,
                        'letter-spacing' => true,
                    ),
                    array (
                        '.secondary-menu-wrapper .menu > li > a'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'secondary-menu_level_2',
                        'type'           => 'typography',
                        'fonts'          => $fonts_list,
                        'title'          => esc_html__( 'Menu second level', 'xstore' ),
                        'subtitle'       => esc_html__( 'Controls the font of the second level of the secondary menu.', 'xstore' ),
                        'text-align'     => false,
                        'text-transform' => true,
                        'letter-spacing' => true,
                    ),
                    array (
                        'body .secondary-menu-wrapper .item-design-mega-menu .nav-sublist-dropdown .item-level-1 > a',
                        'body .secondary-menu-wrapper .nav-sublist-dropdown .menu-item-has-children.item-level-1 > a',
                        'body .secondary-menu-wrapper .nav-sublist-dropdown .menu-widgets .widget-title',
                        'body .secondary-menu-wrapper .fullscreen-menu .menu-item-has-children .nav-sublist-dropdown li a',
                        'body .secondary-menu-wrapper .item-design-mega-menu .nav-sublist-dropdown > .container > ul .item-level-1 > a'
                    )
                ),
                et_compare_output_function (
                    array (
                        'id'             => 'secondary-menu_level_3',
                        'type'           => 'typography',
                        'fonts'          => $fonts_list,
                        'title'          => esc_html__( 'Menu third level', 'xstore' ),
                        'subtitle'       => esc_html__( 'Controls the font of the third level of the secondary menu.', 'xstore' ),
                        'text-align'     => false,
                        'text-transform' => true,
                        'letter-spacing' => true,
                    ),
                    array (
                        'body .secondary-menu-wrapper .item-design-dropdown .nav-sublist-dropdown ul > li > a',
                        'body .secondary-menu-wrapper .item-design-mega-menu .nav-sublist-dropdown .item-link',
                        'body .secondary-menu-wrapper .nav-sublist-dropdown .menu-item-has-children .nav-sublist ul > li > a',
                        'body .secondary-menu-wrapper .item-design-mega-menu .nav-sublist-dropdown .nav-sublist a',
                        'body .secondary-menu-wrapper .fullscreen-menu .menu-item-has-children .nav-sublist-dropdown ul > li > a'
                    )
                ),
                
            ),
        ) );


        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Upload custom font', 'xstore' ),
            'id'         => 'fonts-uploader',
            'subsection' => true,
            'desc'       => esc_html__( 'Upload the custom font to use throughout the site. For full browser support it\'s recommended to upload all formats. You can upload as many custom fonts as you need. The font you upload here will be available in the font-family drop-downs at the Typography options.', 'xstore' ),
            // 'icon'       => 'el-icon-inbox',
            'class'      => 'et_fonts-section',
            'fields'     => array (
                array(
                    'id'    => 'fonts-uploader',
                    'type'  => 'fonts_uploader',
                    'title' => false
                ),
            )
        ));



if( current_theme_supports('woocommerce') && class_exists('woocommerce') ) {

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Shop', 'xstore' ),
            'id'         => 'shop',
            'subsection' => false,
            'icon'       => 'et-admin-icon et-shop',
            'fields'     => array (
                
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Shop page Layout', 'xstore' ),
            'id'         => 'shop-page',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                        'id'       => 'products_per_page',
                        'type'     => 'spinner',
                        'title'    => esc_html__( 'Products per page', 'xstore' ),
                        'subtitle' => esc_html__( 'Add the number of products to show per page before pagination appears. Use -1 to show "All"', 'xstore' ),
                        'default'  => '12',
                        'min'      => '-1',
                        'step'     => '1',
                        'max'      => '100',
                ),
                array (
                'id'       => 'et_ppp_options',
                'type'     => 'text',
                'title'    => esc_html__( 'Per page variants separated by commas', 'xstore' ),
                'subtitle' => esc_html__( 'Add variants and allow the customer to choose the products quantity shown per page. For ex.: 9,12,24,36,-1. Use -1 to show "All".', 'xstore' ),
                'default'  => esc_html__( '12,24,36,-1', 'xstore' ),
                ),
                array (
                    'id'       => 'grid_sidebar',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Sidebar position', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the position of the sidebar for the shop page and product categories.', 'xstore' ),
                    'options'  => array (
                        'without' => array (
                            'alt' => esc_html__( 'full width', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'layout/full-width.png',
                        ),
                        'left' => array (
                            'alt' => esc_html__( 'Left Sidebar', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'layout/left-sidebar.png',
                        ),
                        'right' => array (
                            'alt' => esc_html__( 'Right Sidebar', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'layout/right-sidebar.png',
                        ),
                    ),
                    'default'  => 'left'
                ),
                array (
                    'id'       => 'category_sidebar',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Sidebar position on category page', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the position of the sidebar for the product category page.', 'xstore' ),
                    'options'  => array (
                        'without' => array (
                            'alt' => esc_html__( 'full width', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'layout/full-width.png',
                        ),
                        'left' => array (
                            'alt' => esc_html__( 'Left Sidebar', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'layout/left-sidebar.png',
                        ),
                        'right' => array (
                            'alt' => esc_html__( 'Right Sidebar', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'layout/right-sidebar.png',
                        ),
                    ),
                    'default'  => 'left'
                ),
                array (
                    'id'       => 'category_page_columns',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Products per row on category page', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the number of product per row on category pages or inherit it from the WooCommerce options for the shop page (Appearance > Customize > WooCommerce > Product catalog).', 'xstore' ),
                    'options'  => array (
                        'inherit'    => esc_html__( 'Inherit from shop settings', 'xstore' ),
                        1 => 1,
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        5 => 5,
                        6 => 6,
                    ),
                    'default' => 'inherit'
                ),
                array (
                    'id'       => 'shop_sticky_sidebar',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable sticky sidebar', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to make the sidebar permanently visible while scrolling at the shop page.', 'xstore' ),
                    'default'  => false,
                ),
                array (
                    'id'       => 'sidebar_for_mobile',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Sidebar position for mobile', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the sidebar position for the mobile devices.', 'xstore' ),
                    'options'  => array (
                        'top'    => esc_html__( 'Top', 'xstore' ),
                        'bottom' => esc_html__( 'Bottom', 'xstore' ),
                    ),
                    'default'  => 'top',
                ),
                array (
                    'id'       => 'shop_sidebar_hide_mobile',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Hide sidebar for mobile devices', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to hide sidebar on the mobile devices.', 'xstore' ),
                ),
                array (
                    'id'      => 'sidebar_widgets_scroll',
                    'type'    => 'switch',
                    'title'   => esc_html__( 'Sidebar widgets with scrollable content', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to limit height of the sidebar widgets', 'xstore' ),
                    'default' => false,
                ),
                array(
                    'id'        => 'sidebar_widgets_height',
                    'type'      => 'slider',
                    'title'     => esc_html__('Sidebar widgets height', 'xstore'),
                    'subtitle' => esc_html__( 'Add the max-height of the sidebar widgets before scroll appears. In pixels.', 'xstore' ),
                    "default"   => 250,
                    "min"       => 50,
                    "step"      => 1,
                    "max"       => 800,
                    'compiler'  => true,
                    'display_value' => 'text',
                    'required' => array(
                        array('sidebar_widgets_scroll', 'equals', true),
                    )
                ),
                array (
                    'id'      => 'sidebar_widgets_open_close',
                    'type'    => 'switch',
                    'title'   => esc_html__( 'Sidebar widgets toggle', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to enable toggle for the sidebar widget title to open/close widget content.', 'xstore' ),
                    'default' => false,
                ),
                array (
                    'id'       => 'shop_full_width',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Full width', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to stretch shop page container.', 'xstore' ),
                ),
                array (
                    'id'       => 'products_masonry',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Products masonry', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on placing products in optimal position based on available vertical space.', 'xstore' ),
                    'default'  => false,
                ),
                array (
                    'id'       => 'view_mode',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Products view mode', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the view mode for the shop page.', 'xstore' ),
                    'options'  => array (
                        'grid_list' => esc_html__( 'Grid/List', 'xstore' ),
                        'list_grid' => esc_html__( 'List/Grid', 'xstore' ),
                        'grid'      => esc_html__( 'Only Grid', 'xstore' ),
                        'list'      => esc_html__( 'Only List', 'xstore' ),
                    ),
                    'default'  => 'grid_list'
                ),
                array (
                    'id'       => 'product_bage_banner_pos',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Shop Page Banner position', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the position of the shop page banner.', 'xstore' ),
                    'options'  => array (
                        1 => esc_html__( 'At the top of the page', 'xstore' ),
                        2 => esc_html__( 'At the bottom of the page', 'xstore' ),
                        3 => esc_html__( 'Above all the shop content', 'xstore' ),
                        4 => esc_html__( 'Above all the shop content (full-width)', 'xstore' ),
                        0 => esc_html__( 'Disable', 'xstore' ),
                    ),
                    'default'  => 1,
                ),
                array (
                    'id'       => 'product_bage_banner',
                    'type'     => 'editor',
                    'title'    => esc_html__( 'Shop Page Banner content', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the shop page banner content. Use HTML, static block or slider shortcode. Do not include JS in the field.', 'xstore' ),
                    'required' => array(
                        array( 'product_bage_banner_pos', '!=', 0),
                    ),
                ),
                array (
                    'id'       => 'top_toolbar',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show products toolbar on the shop page', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to display toolbar with sorting selector, number of products per page, view switcher above the shop page content.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'filter_opened',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Open filter by default', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on if you use filters widget area to display "Filters" button in the shop toolbar and want to keep this area opened at start.', 'xstore' ),
                    'default'  => false,
                ),

                array (
                    'id'       => 'filters_columns',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Widgets columns for filters area', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the number of columns for the filters widget area content.', 'xstore' ),
                    'options'  => array (
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                    ),
                    'default'  => 3
                ),
                array (
                    'id'       => 'ajax_product_filter',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Ajax product filters', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to use Ajax for product filters.', 'xstore' ),
                    'default'  => false,
                ),
                array (
                    'id'       => 'ajax_product_pagination',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Ajax product pagination', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to use Ajax for product pagination.', 'xstore' ),
                    'default'  => false,
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Products style', 'xstore' ),
            'id'         => 'products-style',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'product_view',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Product content effect', 'xstore' ),
                    'subtitle' => esc_html__('Choose the design type for the products on the shop page. Custom type allows you to choose the design created using', 'xstore' ) . ' <a href="https://kb.wpbakery.com/docs/learning-more/grid-builder/" target="blank">' . esc_html__( 'WPBakery Grid builder', 'xstore' ) . '</a>',
                    'options'  => array (
                        'disable' => esc_html__( 'Disable', 'xstore' ),
                        'default' => esc_html__( 'Default', 'xstore' ),
                        'mask3'   => esc_html__( 'Buttons on hover middle', 'xstore' ),
                        'mask'    => esc_html__( 'Buttons on hover bottom', 'xstore' ),
                        'mask2'   => esc_html__( 'Buttons on hover right', 'xstore' ),
                        'info'    => esc_html__( 'Information mask', 'xstore' ),
                        'booking' => esc_html__( 'Booking', 'xstore' ),
                        'light'   => esc_html__( 'Light', 'xstore' ),
                        'custom'  => esc_html__( 'Custom', 'xstore' )
                    ),
                    'default'  => 'disable',
                ),
                array (
                    'id'      => 'custom_product_template',
                    'type'    => 'select',
                    'title'   => esc_html__( 'Custom product template', 'xstore' ),
                    'subtitle' =>  sprintf( esc_html__( '
                    Choose the design created using %1s. Find the Video tutorials for builder usage %2s', 'xstore' ), '<a href="https://wpbakery.com/video-academy/category/grid/" target="_blank">' . esc_html__( 'WPBakery Grid builder', 'xstore' ) . '</a>', '<a href="https://wpbakery.com/video-academy/category/grid/" target="_blank">' . esc_html__( 'here', 'xstore' ) . '</a>' ),

                    'data'    => 'posts',
                    'options' => $product_templates,
                    'default' => 'Create products template to use them',
                    'required' => array(
                        array('product_view', 'equals', 'custom'),
                    ), 
                ),
                array (
                    'id'       => 'product_view_color',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Hover Color Scheme', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the color scheme for the product design with buttons on hover.', 'xstore' ),
                    'options'  => array (
                        'white'       => esc_html__( 'White', 'xstore' ),
                        'dark'        => esc_html__( 'Dark', 'xstore' ),
                        'transparent' => esc_html__( 'Transparent', 'xstore' )
                    ),
                    'default'  => 'white',
                    'required' => array(
                        array( 'product_view', 'equals', array( 'default', 'info', 'mask', 'mask2', 'mask3' ) ),
                    )
                ),
                array (
                    'id'       => 'product_img_hover',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Image hover effect', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the type of the hover effect for the image or disable it at all.', 'xstore' ),
                    'options'  => array (
                        'disable' => esc_html__( 'Disable', 'xstore' ),
                        'swap'    => esc_html__( 'Swap', 'xstore' ),
                        'slider'  => esc_html__( 'Images Slider', 'xstore' ),
                    ),
                    'default'  => 'slider',
                    'required' => array (
                        array( 'product_view', '!=', 'custom' ),
                    )
                ),
                array(
                    'id'       => 'product_title_limit',
                    'type'     => 'spinner',
                    'title'    => esc_html__( 'Product title chars limit', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the length of the product title for the products at grid/list, related products, prev/next product navigation.', 'xstore' ),
                    'default'  => '0',
                    'min'      => '0',
                    'step'     => '1',
                    'max'      => '100',
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'star-rating-color',
                        'title'    => esc_html__( 'Star rating color', 'xstore' ),
                        'subtitle' => esc_html__( 'Choose the color of the stars for the product rating.', 'xstore' ),
                        'type'     => 'color_rgba',
                        'options'  => array (
                            'show_buttons' => false,
                        ),
                        'default'  => '#fdd835',
                    ), 
                    array( 'color' => '.star-rating span:before, #review_form .stars a.active:before, #review_form .stars a:hover:before')
                ),
                array(
                    'id'       => 'product_page_switchers',
                    'type'     => 'sorter',
                    'title'    => esc_html__( 'Product content elements', 'xstore' ),
                    'subtitle' => esc_html__( 'Enable/disable element that you do/do not want to show at grid/list.', 'xstore' ),
                    'options'  => array(
                        'enabled'  => array(
                            'product_page_productname' => esc_html__( 'Product name', 'xstore' ),
                            'product_page_cats'        => esc_html__( 'Product categories', 'xstore' ),
                            'product_page_price'       => esc_html__( 'Price', 'xstore' ),
                            'product_page_addtocart'   => esc_html__( '"Add to cart" button', 'xstore' ),
                            'hide_buttons_mobile' => esc_html__( 'Hover buttons on mobile', 'xstore' ),
                        ),
                        'disabled' => array(
                            
                        ),
                    ),
                    'required'  => array ( array( 'product_view', '!=', 'custom' ) )
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Catalog Mode', 'xstore' ),
            'id'         => 'catalog-mode',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'just_catalog',
                    'type'     => 'switch',
                    'subtitle' => esc_html__( 'Turn on to disable ability to buy products via removing "Add to Cart" buttons.', 'xstore' ),
                    'title'    => esc_html__( 'Just Catalog', 'xstore' ),
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Empty cart content', 'xstore' ),
            'id'         => 'empty-cart',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'empty_cart_content',
                    'type'     => 'editor',
                    'title'    => esc_html__( 'Text for empty cart', 'xstore' ),
                    'subtitle' => esc_html__( 'Add the content you need to display on the empty part page instead of the default content.', 'xstore' ),
                    'default'  => '<h1 style="text-align: center;">YOUR SHOPPING CART IS EMPTY</h1><p style="text-align: center;">We invite you to get acquainted with an assortment of our shop.Surely you can find something for yourself!</p> ',
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Single Product Page', 'xstore' ),
            'id'         => 'single-product-page',
            'subsection' => false,
            'icon'       => 'et-admin-icon et-shop',
            'fields'     => array (
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Page Layout', 'xstore' ),
            'id'         => 'single-product-page-layout',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'single_layout',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Page Layout', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the layout type for the single product page.', 'xstore' ),
                    'options'  => array (
                        'small' => array (
                            'alt' => 'product-small',
                            'img' => ETHEME_CODE_IMAGES . 'layout/product-small.png',
                        ),
                        'default' => array (
                            'alt' => 'product-medium',
                            'img' => ETHEME_CODE_IMAGES . 'layout/product-medium.png',
                        ),
                        'xsmall' => array (
                            'alt' => 'product-thin',
                            'img' => ETHEME_CODE_IMAGES . 'layout/product-thin.png',
                        ),
                        'large' => array (
                            'alt' => 'product-large',
                            'img' => ETHEME_CODE_IMAGES . 'layout/product-large.png',
                        ),
                        'fixed' => array (
                            'alt' => 'product-fixed',
                            'img' => ETHEME_CODE_IMAGES . 'layout/product-fixed.png',
                        ),
                        'center' => array (
                            'alt' => 'product-center',
                            'img' => ETHEME_CODE_IMAGES . 'layout/product-center.png',
                        ),
                        'wide' => array (
                            'alt' => 'product-wide',
                            'img' => ETHEME_CODE_IMAGES . 'layout/product-wide.png',
                        ),
                        'right' => array (
                            'alt' => 'product-right',
                            'img' => ETHEME_CODE_IMAGES . 'layout/product-right.png',
                        ),
                        'booking' => array (
                            'alt' => 'product-booking',
                            'img' => ETHEME_CODE_IMAGES . 'layout/product-booking.png',
                        ),
                    ),
                    'default'  => 'default'
                ),
                array (
                    'id'       => 'single_sidebar',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Sidebar position', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the position of the sidebar for the single product page.', 'xstore' ),
                    'options'  => array (
                        'without' => array (
                            'alt' => 'full-width',
                            'img' => ETHEME_CODE_IMAGES . 'layout/full-width.png',
                        ),
                        'left' => array (
                            'alt' => 'left-sidebar',
                            'img' => ETHEME_CODE_IMAGES . 'layout/left-sidebar.png',
                        ),
                        'right' => array (
                            'alt' => 'right-sidebar',
                            'img' => ETHEME_CODE_IMAGES . 'layout/right-sidebar.png',
                        ),
                    ),
                    'default'  => 'without'
                ),
                array (
                    'id'       => 'single_product_hide_sidebar',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Hide sidebar on mobile', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to hide sidebar on the mobile devices.', 'xstore' ),
                    'default'  => false
                ),
                array (
                    'id'       => 'fixed_images',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Fixed product image', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to make the product image sticky and content - scrollable. If the fixed product content option is enabled then keep this option disabled.', 'xstore' ),
                    'default'  => false,
                    'required' => array(
                        array( 'single_layout', 'equals', array( 'small', 'default', 'xsmall', 'wide', 'right' ) ),
                    )
                ),
                array (
                    'id'       => 'fixed_content',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Fixed product content', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to make the product content sticky and image - scrollable. If the fixed product image option is enabled then keep this option disabled.', 'xstore' ),
                    'default'  => false,
                    'required' => array(
                        array( 'single_layout', 'equals', array( 'small', 'default', 'xsmall', 'wide', 'right' ) ),
                    )
                ),
                array (
                    'id'       => 'product_name_signle',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Move product name in breadcrumbs', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the product title in breadcrumbs only and remove from the single product content.', 'xstore' ),
                    'default'  => false,
                ),
                array (
                    'id'       => 'share_icons',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show share buttons', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the share buttons.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'ajax_add_to_cart',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'AJAX add to cart for simple products', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to enable adding to cart without page refresh for the simple products. Important: Variable products do not use AJAX add to cart.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'product_zoom',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Zoom for product images', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to enable the WooCommerce zoom feature. Important: Every product image you use must be larger than the image container for zoom to work correctly.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'thumbs_slider',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Product gallery slider', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to display slider for the product gallery images.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id' => 'thumbs_autoheight',
                    'type' => 'switch',
                    'title' => __( 'Product gallery slider auto-height', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to enable auto-height for the slider of the product gallery images.', 'xstore' ),
                    'default' => true,
                    'required' => array (
                        array('thumbs_slider', 'equals', true),
                    ),
                ),
                 array (
                    'id'       => 'stretch_product_slider',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Stretch main slider', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to enable slider stretch. Enabling stretch will display full with carousel and parts of previous and next gallery images on carousel sides.  If "On" then thumbnails won\'t be shown.', 'xstore' ),
                    'default'  => true,
                    'required' => array (
                        array( 'single_layout', 'equals', array('large') ),
                    ),
                ),
                array (
                    'id'       => 'thumbs_slider_vertical',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Thumbnails', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the direction of the gallery thumbnails or disable them at all.', 'xstore' ),
                    'default'  => 'Horizontal',
                    'options'  => array(
                        'horizontal' => esc_html__( 'Horizontal', 'xstore' ),
                        'vertical' => esc_html__( 'Vertical', 'xstore' ),
                        'disable' => esc_html__('Disable', 'xstore')
                    ),
                    'required' => array (
                        array( 'thumbs_slider', 'equals', true ),
                    ),
                ),
                array (
                    'id'       => 'count_slides',
                    'type'     => 'spinner',
                    'title'    => esc_html__( 'Number of slides per view', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the number of slides.', 'xstore' ),
                    'min'      => '1',
                    'step'     => '1',
                    'max'      => '12',
                    'default'  => '4',
                    'required' => array (
                        array( 'thumbs_slider_vertical', '!=', 'disable' ),
                    ),
                ),
                array (
                    'id'       => 'upsell_location',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Location of upsell products', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the location of the up-sell products slider. If use "Sidebar" be sure that sidebar is enabled for the single product page.', 'xstore' ),
                    'options'  => array (
                        'sidebar'       => esc_html__( 'Sidebar', 'xstore' ),
                        'after_content' => esc_html__( 'After content', 'xstore' ),
                    ),
                ),
                array (
                    'id'       => 'product_posts_links',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Next/Previous product navigation', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the navigation to next and previous product.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'size_guide_img',
                    'type'     => 'media',
                    'title'    => esc_html__( 'Size guide image', 'xstore' ),
                    'subtitle' => esc_html__( 'Upload size guide image to show size guide link and size guide image in lightbox after click.', 'xstore' ),
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Tabs Settings ', 'xstore' ),
            'id'         => 'tabs-settings',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'tabs_type',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Tabs type', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the design type of the tabs.', 'xstore' ),
                    'options'  => array (
                        'tabs-default' => esc_html__( 'Default', 'xstore' ),
                        'left-bar'     => esc_html__( 'Left Bar', 'xstore' ),
                        'accordion'    => esc_html__( 'Accordion', 'xstore' ),
                        'disable'      => esc_html__( 'Disable', 'xstore' ),
                    ),
                    'default'  => 'tabs-default'
                ),
                array(
                    'id'       => 'first_tab_closed',
                    'title'    => esc_html__( 'Close first tab by default', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on if you want to keep the first tab closed.', 'xstore' ),
                    'type'     => 'switch',
                    'default'  => false,
                    'required' => array(
                        array( 'tabs_type', '!=', 'disable' ),
                    ),
                ),
                array (
                    'id'       => 'tabs_scroll',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Tabs content scroll', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to add height for the tab content and enable scroll if content is higher.', 'xstore' ),
                    'default'  => false,
                    'required' => array(
                        array( 'tabs_type', 'equals', 'accordion' ),
                    )
                ),
                array(
                    'id'            => 'tab_height',
                    'type'          => 'slider',
                    'title'         => esc_html__('Tab content height', 'xstore'),
                    'subtitle'      => esc_html__( 'Add the max height of the tab content. In pixels.', 'xstore' ),
                    'default'       => 250,
                    'min'           => 50,
                    'step'          => 1,
                    'max'           => 800,
                    'compiler'      => true,
                    'display_value' => 'text',
                    'required'      => array(
                        array( 'tabs_type', 'equals', 'accordion' ),
                        array( 'tabs_scroll', 'equals', true ),
                    )
                ),
                array (
                    'id'       => 'tabs_location',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Location of product tabs', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the location of the product tabs.', 'xstore' ),
                    'options'  => array (
                        'after_image'   => esc_html__( 'Next to image', 'xstore' ),
                        'after_content' => esc_html__( 'Under content', 'xstore' ),
                    ),
                    'default'  => 'after_content',
                    'required' => array(
                        array( 'tabs_type','!=', 'disable' ),
                    )
                ),
                array (
                    'id'       => 'reviews_position',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Reviews position', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the position of the reviews tab.', 'xstore' ),
                    'options'  => array (
                        'tabs'    => esc_html__( 'Tabs', 'xstore' ),
                        'outside' => esc_html__( 'Next to tabs', 'xstore' ),
                    ),
                    'default'  => 'tabs',
                    'required' => array(
                        array( 'tabs_type','!=', 'disable' ),
                    )
                ),
                array (
                    'id'       => 'custom_tab_title',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Custom Tab Title', 'xstore' ),
                    'subtitle' => esc_html__( 'Add the title to use custom tab.', 'xstore' ),
                    'required' => array(
                        array('tabs_type','!=', 'disable'),
                    ),
                ),
                array (
                    'id'       => 'custom_tab',
                    'type'     => 'editor',
                    'title'    => esc_html__( 'Custom tab content', 'xstore' ),
                    'subtitle' => esc_html__( 'Add custom tab content. Use HTML, static block shortcode. Do not use JS, PHP code.', 'xstore' ),
                    'required' => array(
                        array( 'tabs_type', '!=', 'disable' ),
                    ),
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Related Products', 'xstore' ),
            'id'         => 'shop-related-products',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'show_related',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Display related products', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to display related products on  the single product page.', 'xstore' ),
                    'default'  => true,
                ),

                array (
                    'id'       => 'related_type',
                    'type'     => 'select',
                    'title'    => esc_html__('Related products type', 'xstore'),
                    'subtitle' => esc_html__( 'Choose the design type of the related products.', 'xstore' ),
                    'default'  => 'slider',
                    'options'  => array (
                        'slider' => 'Slider',
                        'grid'   => 'Grid',
                    ),
                    'required' => array(
                        array( 'show_related', 'equals', true ),
                    )
                ),                
                array (
                    'id'            => 'related_slides',
                    'type'          => 'spacing',
                    'title'         => esc_html__('Related products per view', 'xstore'),
                    'subtitle'      => esc_html__( 'Controls the number of related products per view for every device.', 'xstore' ),
                    'display_units' => false,
                    'class'         => 'et-text-spacing et-device-spacing',
                    'required'      => array(
                        array( 'show_related', 'equals', true ),
                        array( 'related_type', 'equals', 'slider' ),
                    )
                ),
                array (
                    'id'    => 'related_columns',
                    'type'  => 'select',
                    'title' => esc_html__('Related products columns', 'xstore'),
                    'subtitle'      => esc_html__( 'Controls the number of columns of the related products.', 'xstore' ),
                    'default' => 4,
                    'options' => array (
                        '2' => 2,
                        '3' => 3,
                        '4' => 4,
                        '5' => 5,
                        '6' => 6,
                    ),
                    'required' => array(
                        array( 'show_related', 'equals', true ),
                        array( 'related_type', 'equals', 'grid' ),
                    )
                ),
                array (
                    'id'       => 'related_limit',
                    'type'     => 'spinner',
                    'title'    => esc_html__( 'Related products limit', 'xstore' ),
                    'subtitle' => esc_html__( 'Limits the number of the related products.', 'xstore' ),
                    'default'  => '10',
                    'min'      => '1',
                    'step'     => '1',
                    'max'      => '30',
                    'required' => array(
                        array( 'show_related', 'equals', true ),
                    )
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Shop elements', 'xstore' ),
            'id'         => 'shop-elements',
            'subsection' => false,
            'icon'       => 'et-admin-icon et-shop',
            'fields'     => array (
                
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Categories', 'xstore' ),
            'id'         => 'shop-categories',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'cats_accordion',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable Accordion for the product categories widget', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to enable toggle for the categories with subcategories for the Products Categories WC widget.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'first_catItem_opened',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Open product categories widget by default', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to keep first-level categories opened by default.', 'xstore' ),
                    'default'  => true,
                    'required' => array (
                        array( 'cats_accordion', 'equals', true ),
                    )
                ),
                array (
                    'id'       => 'cat_style',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Categories style', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the design for the categories if they are chosen to be displayed on the main shop page in the WooCommerce settings.', 'xstore' ),
                    'options'  => array (
                        'default'  => esc_html__( 'Default', 'xstore' ),
                        'with-bg'  => esc_html__( 'Title with background', 'xstore' ),
                        'zoom'     => esc_html__( 'Zoom', 'xstore' ) ,
                        'diagonal' => esc_html__( 'Diagonal', 'xstore' ),
                        'classic'  => esc_html__( 'Classic', 'xstore' ),
                    ),
                    'default'  => 'default'
                ),
                array (
                    'id'       => 'cat_text_color',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Categories text color', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the title color scheme for the categories if they are chosen tobe displayed on the main shop page in the WooCommerce settings.', 'xstore' ),
                    'options'  => array (
                        'dark'  => esc_html__( 'Dark', 'xstore' ),
                        'white' => esc_html__( 'Light', 'xstore' ),
                    ),
                    'default'  => 'dark'
                ),
                array (
                    'id'       => 'cat_valign',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Text vertical align', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the alignment of the title for the categories if they are chosen to be displayed on the main shop page in the WooCommerce settings.', 'xstore' ),
                    'options'  => array (
                        'center' => esc_html__( 'Center', 'xstore' ),
                        'top'    => esc_html__( 'Top', 'xstore' ),
                        'bottom' => esc_html__( 'Bottom', 'xstore' ),
                    ),
                    'default'  => 'center'
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Sale & Out of Stock', 'xstore' ),
            'id'         => 'shop-icons',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'out_of_icon',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable "Out of stock" label', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the "Out of stock" label.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'sale_icon',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable "Sale" label', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the "Sale" label.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'sale_icon_text',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Sale label text', 'xstore' ),
                    'subtitle' => esc_html__( 'Use to change the sale text.', 'xstore' ),
                    'default'  => esc_html__( 'Sale', 'xstore' ),
                    'required' => array(
                        array( 'sale_icon','equals', true ),
                    ),
                ),
                array (
                    'id'       => 'sale_icon_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Sale label text color', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the sale label text color.', 'xstore' ),
                    'default'  => '#fffff',
                    'required' => array(
                        array( 'sale_icon','equals', true ),
                    ),
                    'compiler' => true
                ),
                array (
                    'id'       => 'sale_icon_bg_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Sale label background color', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the sale label background color.', 'xstore' ),
                    'default'  => '#c62828',
                    'required' => array(
                        array( 'sale_icon', 'equals', true ),
                    ),
                    'compiler' => true
                ),
                array (
                    'id'            => 'sale_br_radius',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Sale label border radius', 'xstore' ),
                    'subtitle'      => esc_html__( 'Controls the border radius of the sale label. In percents.', 'xstore' ),
                    'default'       => 0,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 50,
                    'display_value' => 'text',
                    'required'      => array(
                        array( 'sale_icon', 'equals', true ),
                    ),
                    'compiler'      => true
                ),
                array (
                    'id'       => 'sale_icon_size',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Sale label size', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the size of the sale label. In em, for example, 3.75x3.75.', 'xstore' ),
                    'required' => array(
                        array( 'sale_icon', 'equals', true ),
                    ),
                    'compiler' => true
                ),
                array (
                    'id'       => 'sale_percentage',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show sale percentage', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to calculate the percentage discount for the simple products. Variable products do not have this option.', 'xstore' ),
                    'default'  => false,
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Quick view', 'xstore' ),
            'id'         => 'shop-quick-view',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'quick_view',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable quick view', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to allow customers a quick preview of the product right from its respective category listing.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'quick_dimentions',
                    'type'     => 'dimensions',
                    'title'    => esc_html__( 'Quick view dimentions (width and height)', 'xstore' ),
                    'subtitle' => esc_html__( 'Set height and width of the quick view lightbox.', 'xstore' ),
                    'units'    => array('em','px','%'),
                    'default'  => array(
                        'Width'   => 'auto', 
                        'Height'  => '550'
                    ),
                    'required' => array(
                        array( 'quick_view','equals', true ),
                    ),
                    'compiler' => true
                ),
                array (
                    'id'       => 'quick_images',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Product images', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the way to display product image in the quick view window.', 'xstore' ),
                    'options'  => array (
                        'slider' => esc_html__( 'Slider', 'xstore' ),
                        'single' => esc_html__( 'Single', 'xstore' ),
                    ),
                    'default'  => 'slider',
                    'required' => array(
                        array( 'quick_view', 'equals', true ),
                    )
                ),
                array (
                    'id'       => 'quick_view_layout',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Quick view layout', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the design of the quick view window.', 'xstore' ),
                    'options'  => array (
                        'default' => esc_html__( 'Default', 'xstore' ),
                        'centered' => esc_html__( 'Centered', 'xstore' ),
                    ),
                    'default'  => 'default',
                    'required' => array(
                        array( 'quick_view', 'equals', true ),
                    )
                ),
                array(
                    'id'       => 'quick_view_switcher',
                    'type'     => 'sorter',
                    'title'    => esc_html__( 'Quick view content ', 'xstore' ),
                    'subtitle' => esc_html__( 'Enable elements that you want to display in quick view window.', 'xstore' ),
                    'options'  => array(
                        'enabled'  => array(
                            'quick_product_name' => esc_html__( 'Product name', 'xstore' ),
                            'quick_price'        => esc_html__( 'Price', 'xstore' ),
                            'quick_rating'       => esc_html__( 'Product star rating', 'xstore' ),
                            'quick_short_descr'  => esc_html__( 'Product short description', 'xstore' ),
                            'quick_add_to_cart'  => esc_html__( 'Add to cart', 'xstore' ),                            
                            'quick_categories'   => esc_html__( 'Product categories', 'xstore' ),
                            'quick_share'        => esc_html__( 'Share icons', 'xstore' ),
                            'product_link'       => esc_html__( 'Details link', 'xstore' ),
                    ),
                    'disabled' => array(),
                    ),
                    'required' => array(
                        array( 'quick_view', 'equals', true ),
                    ),
                ),

                array (
                    'id'       => 'quick_descr',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Product details toggle', 'xstore' ),
                    'subtitle' => esc_html__( 'Enable details toggle for product', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'quick_view', 'equals', true ),
                    ),
                ),

                array (
                    'id'       => 'quick_descr_length',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Details length', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the length of the product details', 'xstore' ),
                    'default'  => 120,
                    'required' => array(
                        array( 'quick_descr', 'equals', true ),
                    ),
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Variation swatches', 'xstore' ),
            'id'         => 'shop-color-swatches',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'       => 'enable_swatch',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Variation swatches', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to use style (color, image or label) for each product attribute.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'swatch_position_shop',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Swatch position', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose swatches position to display on the shop page.', 'xstore' ),
                    'options'  => array (
                        'before' => esc_html__( 'Before Product Title', 'xstore' ),
                        'after'  => esc_html__( 'After Product Title', 'xstore' ),
                    ),
                    'default' => 'before',
                    'required' => array (
                        array('enable_swatch', 'equals', true)
                    ),
                ),
                array (
                    'id'       => 'swatch_layout_shop',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Swatch style', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose swatch style to display on the shop page.', 'xstore' ),
                    'options'  => array (
                        'default' => esc_html__( 'Default', 'xstore' ),
                        'popup'   => esc_html__( 'Popup', 'xstore' ),
                    ),
                    'default'  => 'before',
                    'required' => array (
                        array('enable_swatch', 'equals', true)
                    ),
                ),
                et_compare_output_function ( 
                    array (
                        'id'      => 'swatch_border',
                        'type'    => 'color_rgba',
                        'title'   => esc_html__( 'Swatches border color', 'xstore' ),
                        'subtitle' => esc_html__( 'Choose the border color for the attribute term.', 'xstore' ),
                        'options' => array (
                            'show_buttons' => false,
                        ),
                        'required' => array (
                            array('enable_swatch', 'equals', true)
                        ),
                    ),
                    array(
                        'border-color' => 'ul.st-swatch-preview li, .st-swatch-preview li.selected'
                    )
                ),
                et_compare_output_function ( 
                    array (
                        'id'      => 'swatch_border_active',
                        'type'    => 'color_rgba',
                        'title'   => esc_html__( 'Hover/active swatches border color', 'xstore' ),
                        'subtitle' => esc_html__( 'Choose the border color for the hover/active attribute term.', 'xstore' ),
                        'options' => array (
                            'show_buttons' => false,
                        ),
                        'required' => array (
                            array('enable_swatch', 'equals', true)
                        ),
                    ),
                    array(
                        'border-color' => 'ul.st-swatch-preview li:hover, .products-grid .content-product .st-swatch-in-loop > .et_st-default-holder .type-color:hover, .products-grid .content-product .st-swatch-in-loop > .et_st-default-holder .type-image:hover, .st-swatch-preview li.selected'
                    )
                ),
                // array (
                //     'id'       => 'swatch_size_shop',
                //     'type'     => 'select',
                //     'title'    => esc_html__( 'Swatch size (shop)', 'xstore' ),
                //     'subtitle' => esc_html__( 'Choose what size of swatch to display on the shop page.', 'xstore' ),
                //     'options'  => array (
                //         'small'  => esc_html__( 'Small', 'xstore' ),
                //         'normal' => esc_html__( 'Normal', 'xstore' ),
                //         'large'  => esc_html__( 'Large', 'xstore' ),
                //     ),
                //     'default'  => 'small',
                //         'required' => array (
                //             array('enable_swatch', 'equals', true)
                //         ),
                // ),
                // array (
                //     'id'       => 'swatch_shape_shop',
                //     'type'     => 'select',
                //     'title'    => esc_html__( 'Swatch shape (shop)', 'xstore' ),
                //     'subtitle' => esc_html__( 'Choose what shape of swatch to display on the shop page.', 'xstore' ),
                //     'options'  => array (
                //         'circle'         => esc_html__( 'Circle', 'xstore' ),
                //         'square'         => esc_html__( 'Square', 'xstore' ),
                //         'rounded-square' => esc_html__( 'Rounded Square', 'xstore' ),
                //     ),
                //     'default'  => 'circle',
                //     'required' => array (
                //         array('enable_swatch', 'equals', true)
                //     ),
                // ),
                // et_compare_output_function ( 
                //     array (
                //         'id'      => 'swatch_border_shop',
                //         'type'    => 'color_rgba',
                //         'title'   => esc_html__( 'Swatch border color (shop)', 'xstore' ),
                //         'options' => array (
                //             'show_buttons' => false,
                //         ),
                //         'required' => array (
                //             array('enable_swatch', 'equals', true)
                //         ),
                //     ),
                //     array(
                //         'border-color' => 'body.post-type-archive-product ul.st-swatch-preview li'
                //     )
                // ),
                // et_compare_output_function ( 
                //     array (
                //         'id'      => 'swatch_border_active_shop',
                //         'type'    => 'color_rgba',
                //         'title'   => esc_html__( 'Swatch active border color (shop)', 'xstore' ),
                //         'options' => array (
                //             'show_buttons' => false,
                //         ),
                //         'required' => array (
                //             array('enable_swatch', 'equals', true)
                //         ),
                //     ),
                //     array(
                //         'border-color' => 'body.post-type-archive-product ul.st-swatch-preview li.selected'
                //     )
                // ),
                // array (
                //     'id'       => 'swatch_size_single',
                //     'type'     => 'select',
                //     'title'    => esc_html__( 'Swatch size (single)', 'xstore' ),
                //     'subtitle' => esc_html__( 'Choose what size of swatch to display on the shop page.', 'xstore' ),
                //     'options'  => array (
                //         'small'  => esc_html__( 'Small', 'xstore' ),
                //         'normal' => esc_html__( 'Normal', 'xstore' ),
                //         'large'  => esc_html__( 'Large', 'xstore' ),
                //     ),
                //     'default'  => 'normal',
                //     'required' => array (
                //         array('enable_swatch', 'equals', true)
                //     ),
                // ),
                // array (
                //     'id'       => 'swatch_shape_single',
                //     'type'     => 'select',
                //     'title'    => esc_html__( 'Swatch shape (single)', 'xstore' ),
                //     'subtitle' => esc_html__( 'Choose what shape of swatch to display on the shop page.', 'xstore' ),
                //     'options'  => array (
                //         'circle'         => esc_html__( 'Circle', 'xstore' ),
                //         'square'         => esc_html__( 'Square', 'xstore' ),
                //         'rounded-square' => esc_html__( 'Rounded Square', 'xstore' ),
                //     ),
                //     'default'  => 'circle',
                //     'required' => array (
                //         array('enable_swatch', 'equals', true)
                //     ),
                // ),
                // et_compare_output_function ( 
                //     array (
                //         'id'      => 'swatch_border_single',
                //         'type'    => 'color_rgba',
                //         'title'   => esc_html__( 'Swatch border color (single)', 'xstore' ),
                //         'options' => array (
                //             'show_buttons' => false,
                //         ),
                //         'required' => array (
                //             array('enable_swatch', 'equals', true)
                //         ),
                //     ),
                //     array(
                //         'border-color' => 'body.single-product form.variations_form ul.st-swatch-preview li'
                //     )
                // ),
                // et_compare_output_function ( 
                //     array (
                //         'id'      => 'swatch_border_active_single',
                //         'type'    => 'color_rgba',
                //         'title'   => esc_html__( 'Swatch active border color (single)', 'xstore' ),
                //         'options' => array (
                //             'show_buttons' => false,
                //         ),
                //         'required' => array (
                //             array('enable_swatch', 'equals', true)
                //         ),
                //     ),
                //     array(
                //         'border-color' => 'body.single-product form.variations_form ul.st-swatch-preview li.selected'
                //     )
                // ),
                // array (
                //     'id'       => 'swatch_size_cart',
                //     'type'     => 'select',
                //     'title'    => esc_html__( 'Swatch size (cart)', 'xstore' ),
                //     'subtitle' => esc_html__( 'Choose what size of swatch to display on the shop page.', 'xstore' ),
                //     'options'  => array (
                //         'small'  => esc_html__( 'Small', 'xstore' ),
                //         'normal' => esc_html__( 'Normal', 'xstore' ),
                //         'large'  => esc_html__( 'Large', 'xstore' ),
                //     ),
                //     'default'  => 'small',
                //     'required' => array (
                //         array('enable_swatch', 'equals', true)
                //     ),
                // ),
                // array (
                //     'id'       => 'swatch_shape_cart',
                //     'type'     => 'select',
                //     'title'    => esc_html__( 'Swatch shape (cart)', 'xstore' ),
                //     'subtitle' => esc_html__( 'Choose what shape of swatch to display on the shop page.', 'xstore' ),
                //     'options'  => array (
                //         'circle'         => esc_html__( 'Circle', 'xstore' ),
                //         'square'         => esc_html__( 'Square', 'xstore' ),
                //         'rounded-square' => esc_html__( 'Rounded Square', 'xstore' ),
                //     ),
                //     'default'  => 'circle',
                //     'required' => array (
                //         array('enable_swatch', 'equals', true)
                //     ),
                // ),
                // et_compare_output_function ( 
                //     array (
                //         'id'      => 'swatch_border_cart',
                //         'type'    => 'color_rgba',
                //         'title'   => esc_html__( 'Swatch border color (cart)', 'xstore' ),
                //         'options' => array (
                //             'show_buttons' => false,
                //         ), 
                //         'required' => array (
                //             array('enable_swatch', 'equals', true)
                //         ),
                //     ),
                //     array(
                //         'border-color' => 'body.st-swatch-apply-border span.st-swatch-preview'
                //     )
                // ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Brands', 'xstore' ),
            'id'         => 'shop-brands',
            'subsection' => true,
            // 'icon'       => 'el-icon-home',
            'fields'     => array (
                array (
                    'id'      => 'enable_brands',
                    'type'    => 'switch',
                    'title'   => esc_html__( 'Brands', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to use brands for the products.', 'xstore' ),
                    'default' => true,
                ),
                array (
                    'id'       => 'product_page_brands',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show product brands on grid/list', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to display brand title for the product at the grid/list.', 'xstore' ),
                    'required' => array(
                        array( 'enable_brands', 'equals', true ),
                        array( 'product_view', '!=', 'custom' )
                    )
                ),
                array (
                    'id'       => 'show_brand',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show product brands on single product page', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to enable brand on the single product page.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array('enable_brands','equals', true),
                    )
                ),
                array (
                    'id'       => 'brands_location',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Choose the location for brands', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose brands position on the single product page.', 'xstore' ),
                    'default'  => 'sidebar',
                    'options'  => array (
                        'sidebar' => esc_html__( 'Sidebar', 'xstore' ),
                        'content' => esc_html__( 'Above short description', 'xstore' ),
                        'under_content' => esc_html__( 'In product meta', 'xstore' ),
                    ),
                    'required' => array(
                        array('show_brand','equals', true),
                    )
                ),
                array (
                    'id'       => 'show_brand_image',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show brand image', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show brand image on the single product page. Choose brand image by uploading thumbnails for the brand while create/edit brand.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'show_brand', 'equals', true ),
                        array( 'brands_location', 'equals', 'sidebar' ),
                    )
                ),
                array (
                    'id'       => 'show_brand_title',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show brand title', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show brand title on the single product page.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'show_brand', 'equals', true ),
                        array( 'brands_location', 'equals', 'sidebar' ),
                    )
                ),
                array (
                    'id'       => 'show_brand_desc',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show brand description', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show brand description on the single product page.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'show_brand', 'equals', true ),
                        array( 'brands_location', 'equals', 'sidebar' ),
                    )
                ),
                array (
                    'id'       => 'brand_title',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show \'Brand\' word', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show \'Brand\' word before the brand image.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'show_brand', 'equals', true ),
                        array( 'brands_location', '!=', 'sidebar' ),
                    )
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Promo Popup', 'xstore' ),
            'id'         => 'shop-promo-popup',
            'subsection' => false,
            'icon'       => 'et-admin-icon et-promo',
            'fields'     => array (
                array (
                    'id'       => 'promo_popup',
                    'type'     => 'switch',
                    'operator' => 'and',
                    'title'    => esc_html__( 'Enable promo popup', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to enable promo popup.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'promo_auto_open',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Open popup on enter', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the promo popup when visitor just opened the site.', 'xstore' ),
                    'required' => array(
                        array( 'promo_popup', 'equals', true ),
                    ),
                ),                
                array (
                    'id'       => 'promo_open_scroll',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Open when scrolled to the bottom of the page', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the promo popup only when visitor scrolled to the bottom of the page.', 'xstore' ),
                    'required' => array(
                        array( 'promo_auto_open', 'equals', true ),
                    ),
                ),
                array (
                    'id'       => 'pp_delay',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Popup delay', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the delay before popup appears. In ms. For example, 1000.', 'xstore' ),
                    'required' => array(
                        array( 'promo_popup', 'equals', true ),
                        array( 'promo_auto_open', 'equals', true )
                    ),
                ),     
                array (
                    'id'       => 'promo_link',
                    'type'     => 'switch',
                    'operator' => 'and',
                    'title'    => esc_html__( 'Show link in the top bar', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the link to open promo popup at the top bar.', 'xstore' ),
                    'default'  => true,
                    'required' => array(
                        array( 'promo_popup', 'equals', true ),
                    ),
                ),           
                array (
                    'id'       => 'promo-link-text',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Promo link text', 'xstore' ),
                    'subtitle' => esc_html__( 'The text will be displayed if promo popup link in the top bar is enabled.', 'xstore' ),
                    'default'  => '<i class="et-icon et-message"></i> ' . esc_html__( 'Newsletter', 'xstore' ),
                    'required' => array(
                        array( 'promo_popup', 'equals', true ),
                    ),
                ),
                array (
                    'id'       => 'pp_content',
                    'type'     => 'editor',
                    'operator' => 'and',
                    'title'    => esc_html__( 'Popup content', 'xstore' ),
                    'subtitle' => esc_html__( 'Add the content to be shown in the promo popup. You can use HTML or static block shortcode here. Do not include JS, PHP code.', 'xstore' ),
                    'default'  => '<p style="font-size: 1.14rem; color: #fff;">You can add any HTML here (admin -&gt; Theme Options -&gt; E-Commerce -&gt; Promo Popup).<br /> We suggest you create a static block and put it here using shortcode</p>',
                    'required' => array(
                        array( 'promo_popup', 'equals', true ),
                    ),
                ),
                array (
                    'id'       => 'pp_width',
                    'type'     => 'text',
                    'operator' => 'and',
                    'title'    => esc_html__( 'Popup width', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the width of the popup. In pixels.', 'xstore' ),
                    'required' => array(
                        array( 'promo_popup', 'equals', true ),
                    ),
                ),
                array (
                    'id'       => 'pp_height',
                    'type'     => 'text',
                    'operator' => 'and',
                    'title'    => esc_html__( 'Popup height', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the height of the popup. If popup content is higher than this height then you will get the vertical scroll for the popup content. In pixels.', 'xstore' ),
                    'required' => array(
                        array( 'promo_popup', 'equals', true ),
                    ),
                ),
                et_compare_output_function (
                    array (
                        'id'       => 'pp_spacing',
                        'type'     => 'spacing',
                        'title'    => esc_html__( 'Popup paddings', 'xstore' ),
                        'subtitle' => esc_html__( 'Controls paddings of the popup content.', 'xstore' ),
                        'all'      => false,
                        'units'    => array ( 'px', '%', 'em' ),
                        'required' => array(
                            array( 'promo_popup', 'equals', true ),
                        ),
                    ),
                    array ( '#etheme-popup' )
                ),                
                array (
                    'id'       => 'pp_bg',
                    'type'     => 'background',
                    'title'    => esc_html__( 'Popup background', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the promo popup background.', 'xstore' ),
                    'required' => array(
                        array( 'promo_popup', 'equals', true ),
                    ),
                ),
                
            )
        ) );

}

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Blog', 'xstore' ),
            'id'         => 'blog',
            'subsection' => false,
            'icon'       => 'et-admin-icon et-blog',
            'fields'     => array (
                
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title' => __( 'Blog Layout', 'xstore' ),            
            'id' => 'blog-blog_page',
            'subsection' => true,
            // 'icon' => 'el-icon-wordpress',
            'fields' => array (
                array (
                    'id' => 'blog_layout',
                    'type' => 'image_select',
                    'title' => __( 'Blog Layout', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the type of the layout for the blog page.', 'xstore' ),
                    'options' => array(
                        'default' => array(
                            'title' => __( 'Default', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/posts1-1.png',
                        ),
                        'center' => array(
                            'title' => __( 'Center', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/posts-center.png',
                        ),
                        'grid' => array(
                            'title' => __( 'Grid', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/posts2-1.png',
                        ),
                        'grid2' => array(
                            'title' => __( 'Grid 2', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/posts2-2.png',
                        ),
                        'timeline' => array(
                            'title' => __( 'Timeline', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/posts5-1.png',
                        ),
                        'timeline2' => array(
                            'title' => __( 'Timeline 2', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/timeline2.png',
                        ),
                        'small' => array(
                            'title' => __( 'List', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/posts3-1.png',
                        ),
                        'chess' => array(
                            'title' => __( 'Chess', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/posts-chess.png',
                        ),
                        'framed' => array(
                            'title' => __( 'Framed', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/posts-framed.png',
                        ),
                        'with-author' => array(
                            'title' => __( 'With author', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/posts-with-author.png',
                        ),
                    ),
                    'default' => 'default',
                ),
                array (
                    'id' => 'blog_columns',
                    'type' => 'select',
                    'title' => __( 'Columns', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the number of columns for the posts at the blog page.', 'xstore' ),
                    'options' => array (
                        2 => '2',
                        3 => '3',
                        4 => '4',
                    ),
                    'default' => 3,
                    'required' => array(
                        array( 'blog_layout','equals', array( 'grid', 'grid2' ) ),
                    ),
                ),
                array (
                    'id' => 'blog_full_width',
                    'type' => 'switch',
                    'title' => __( 'Full width', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to stretch blog page container.', 'xstore' ),
                    'required' => array(
                        array( 'blog_layout','equals', array( 'grid', 'grid2' ) ),
                    ),
                ),
                array (
                    'id' => 'blog_masonry',
                    'type' => 'switch',
                    'title' => __( 'Masonry', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on placing posts in optimal position based on available vertical space.', 'xstore' ),
                    'required' => array(
                        array( 'blog_layout','equals', array( 'grid', 'grid2' ) ),
                    ),
                    'default' => true,
                ),
                array (
                    'id' => 'blog_sidebar',
                    'type' => 'image_select',
                    'title' => __( 'Sidebar position', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the position of the sidebar for the blog page, posts and simple pages. Every page has also an individual option to change the position of the sidebar.', 'xstore' ),
                    'options' => array (
                        'without' => array (
                            'alt' => __( 'Without Sidebar', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'layout/full-width.png',
                        ),
                        'left' => array (
                            'alt' => __( 'Left Sidebar', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'layout/left-sidebar.png',
                        ),
                        'right' => array (
                            'alt' => __( 'Right Sidebar', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'layout/right-sidebar.png',
                        ),
                    ),
                    'default' => 'right'
                ),
                array (
                    'id' => 'only_blog_sidebar',
                    'type' => 'switch',
                    'title' => __( 'Show sidebar only on blog page', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the sidebar on blog page only and keep it disabled for the simple pages.', 'xstore' ),
                    'default' => false,
                ),
                array (
                    'id' => 'sticky_sidebar',
                    'type' => 'switch',
                    'title' => __( 'Enable sticky sidebar', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to make the sidebar permanently visible while scrolling at the blog page.', 'xstore' ),
                    'default' => false,
                ),
                array (
                        'id' => 'blog_sidebar_for_mobile',
                        'type' => 'select',
                        'title' => __( 'Sidebar position for mobile', 'xstore' ),
                        'subtitle' => esc_html__( 'Choose the sidebar position for the mobile devices.', 'xstore' ),
                        'options' => array (
                            'top' => __( 'Top', 'xstore' ),
                            'bottom' => __( 'Bottom', 'xstore' ),
                        ),
                        'default' => 'bottom',
                    ),
                array (
                    'id' => 'blog_hover',
                    'type' => 'select',
                    'title' => __( 'Blog image hover', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the design type for the image at the blog page.', 'xstore' ),
                    'options' => array (
                        'zoom' => __( 'Default', 'xstore' ),
                        'default' => __( 'Mask hover', 'xstore' ),
                        'animated' => __( 'Animated', 'xstore' ),
                    ),
                    'default' => 'zoom',
                ),

                array (
                    'id' => 'blog_byline',
                    'type' => 'switch',
                    'title' => __( 'Show "byline" on the blog', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show the date of post creation, the name of the writer, number of comments and views.', 'xstore' ),
                    'default' => true,
                ),                
                array (
                    'id' => 'excerpt_length',
                    'type' => 'spinner',
                    'title' => __( 'Excerpt length (words)', 'xstore' ),
                    'subtitle' => esc_html__( 'Controls the number of words in the post summary with a link to the whole entry. Important: Does not work for post content created using WPBakery Page builder.', 'xstore' ),
                    'default' => '25',
                    'step' => '1',
                    'min' => '0',
                    'max' => '100'
                ),
                array (
                    'id' => 'excerpt_words',
                    'type' => 'text',
                    'title' => __( 'Excerpt symbols', 'xstore' ),
                    'subtitle' => esc_html__( 'Add a symbol that you want to display at the end of the post excerpt.', 'xstore' ),
                    'default' => '...',
                ),
                array (
                    'id' => 'read_more',
                    'type' => 'select',
                    'title' => __( 'Continue reading type', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the design type of the continue reading text.', 'xstore' ),
                    'options' => array (
                        'link' => 'Link',
                        'btn' => 'Button',
                        'off' => 'Disable',
                    ),
                    'default' => 'link',
                ),
                array (
                    'id' => 'views_counter',
                    'type' => 'switch',
                    'title' => __( 'Enable views counter', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to enable the post views counter.', 'xstore' ),
                    'default' => true,
                ),
                
                
                array (
                    'id' => 'blog_navigation_type',
                    'type' => 'select',
                    'title' => __( 'Navigation type', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the type of the navigation at the blog page.', 'xstore' ),
                    'options' => array (
                        'pagination' => __( 'Pagination', 'xstore' ),
                        'button' => __( 'More Button', 'xstore' ),
                        'lazy' => __( 'Lazy Loading', 'xstore' ),
                    ),
                    'default' => 'pagination'
                ),
                array (
                    'id' => 'blog_pagination_align',
                    'type' => 'select',
                    'title' => __( 'Pagination align', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the alignment of the pagination.', 'xstore' ),
                    'options' => array (
                        'left' => __( 'Left', 'xstore' ),
                        'center' => __( 'Center', 'xstore' ),
                        'right' => __( 'Right', 'xstore' ),
                    ),
                    'default' => 'right',
                    'required' => array(
                        array( 'blog_navigation_type','equals', 'pagination' ),
                    ),
                ),
                array (
                    'id' => 'blog_pagination_prev_next',
                    'type' => 'switch',
                    'title' => __( 'Enable prev/next pagination links', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to enable the previous and next links.', 'xstore' ),
                    'default' => false,
                    'required' => array(
                        array( 'blog_navigation_type','equals', 'pagination' ),
                    ),
                ),               

                array (
                    'id' => 'blog_images_size',
                    'type' => 'text',
                    'title' => __( 'Images sizes for blog', 'xstore' ),
                    'subtitle' => __( ' Controls the size of the post featured image at the blog page. Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels Example: 200x100 (Width x Height).', 'xstore' ),
                    'default' => 'large',
                ),
                array (
                    'id' => 'blog_related_images_size',
                    'type' => 'text',
                    'title' => __( 'Images sizes for related articles', 'xstore' ),
                    'subtitle' => __( 'Controls the size of the featured image of the related posts at the single post page. Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels Example: 200x100 (Width x Height).', 'xstore' ),
                    'default' => 'medium',
                ),
            ),
        ));


    Redux::setSection( $opt_name, array(
            'title' => __( 'Single post', 'xstore' ),
            'id' => 'blog-single-post',
            'subsection' => true,
            // 'icon' => 'el-icon-wordpress',
            'fields' => array (
                array (
                    'id' => 'post_template',
                    'type' => 'image_select',
                    'title' => __( 'Post template', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose layout of the post template. Header displays over the post featured image for the "Large", "Full width", "Full width centred" layouts.', 'xstore' ),
                    'options' => array (
                        'default' => array(
                            'title' => __( 'Default', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/3.png',
                        ),
                        'full-width' => array(
                            'title' => __( 'Large', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/2.png',
                        ),
                        'large' => array(
                            'title' => __( 'Full width', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/1.png',
                        ),
                        'large2' => array(
                            'title' => __( 'Full width centered', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/5.png',
                        ),
                        'framed' => array(
                            'title' => __( 'Framed', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'blog/6.png',
                        ),
                    ),
                    'default' => 'default'
                ),
                array (
                    'id' => 'post_sidebar',
                    'type' => 'image_select',
                    'title' => __( 'Sidebar position', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the position of the sidebar for the single post. Every post has also an individual option to change the position of the sidebar.', 'xstore' ),
                    'options' => array (
                        'without' => array (
                            'alt' => __( 'Without Sidebar', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'layout/full-width.png',
                        ),
                        'left' => array (
                            'alt' => __( 'Left Sidebar', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'layout/left-sidebar.png',
                        ),
                        'right' => array (
                            'alt' => __( 'Right Sidebar', 'xstore' ),
                            'img' => ETHEME_CODE_IMAGES . 'layout/right-sidebar.png',
                        ),
                    ),
                    'default' => 'right'
                ),
                array (
                    'id' => 'blog_featured_image',
                    'type' => 'switch',
                    'title' => __( 'Display featured image on single post', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to display featured image at the single post page.', 'xstore' ),
                    'default' => true,
                ),
                array (
                    'id' => 'single_post_title',
                    'type' => 'switch',
                    'title' => __( 'Display Title/Meta on single post', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show post title and post meta on the single post page. You can use post meta shortcode [etheme_post_meta time="true" time_details="true" author="true" comments="true" count="true" class="" ] in post content as an alternative of this option.', 'xstore' ),
                    'default' => true,
                ),
                array (
                    'id' => 'post_share',
                    'type' => 'switch',
                    'operator' => 'and',
                    'title' => __( 'Show share buttons', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to display share buttons on the post page.', 'xstore' ),
                    'default' => true,
                ),
                array (
                    'id' => 'about_author',
                    'type' => 'switch',
                    'operator' => 'and',
                    'title' => __( 'Show about author block', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to display the name of the writer on the post page.', 'xstore' ),
                    'default' => false,
                ),
                array (
                    'id' => 'posts_links',
                    'type' => 'switch',
                    'title' => __( 'Posts previous/next buttons', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show navigation to previous and next posts.', 'xstore' ),
                    'default' => true,
                ),
                array (
                    'id' => 'post_related',
                    'type' => 'switch',
                    'operator' => 'and',
                    'title' => __( 'Show Related posts', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to display related posts on the single post.', 'xstore' ),
                    'default' => true,
                ),
                array (
                    'id' => 'related_query',
                    'type' => 'select',
                    'title' => __( 'Related query type', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the type of the related product query.', 'xstore' ),
                    'options' => array (
                        'categories' => __( 'Categories', 'xstore' ),
                        'tags' => __( 'Tags', 'xstore' ),
                    ),
                    'default' => 'categories',
                    'required' => array(
                        array('post_related','equals', true),
                    ),
                ),

            ),
        ));



      




        Redux::setSection( $opt_name, array(
            'title' => __( 'Portfolio', 'xstore' ),
            'id' => 'blog-portfolioo',
            'subsection' => false,
            'icon' => 'et-admin-icon et-portfolio',
            'fields' => array (
                array (
                    'id' => 'portfolio_projects',
                    'type' => 'switch',
                    'title' => __( 'Portfolio projects', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to enable portfolio projects post type.', 'xstore' ),
                    'default' => true,
                ),
                array(
                    'id'       => 'portfolio_page',
                    'type'     => 'select',
                    'data'     => 'pages',
                    'args'  => array(
                        'posts_per_page' => -1,
                    ),
                    'title'    => esc_html__( 'Portfolio page', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the portfolio page.', 'xstore' ),
                    'required' => array ( array( 'portfolio_projects', 'equals', true ) ),
                ),
                array (
                    'id' => 'portfolio_style',
                    'type' => 'select',
                    'title' => __( 'Portfolio grid style', 'xstore' ),
                    'subtitle' => esc_html__( 'Control the portfolio projects design on the portfolio page.', 'xstore' ),
                    'options' => array (
                        'default' => __( 'With title', 'xstore' ),
                        'classic' => __( 'On hover', 'xstore' ),
                    ),
                    'required' => array ( array( 'portfolio_projects', 'equals', true ) ),
                    'default' => 'default'
                ),
                array (
                    'id' => 'portfolio_fullwidth',
                    'type' => 'switch',
                    'title' => __( 'Full width portfolio', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to stretch portfolio page.', 'xstore' ),
                    'required' => array ( array( 'portfolio_projects', 'equals', true ) ),
                    'default' => false
                ),
                array (
                    'id' => 'port_first_wide',
                    'type' => 'switch',
                    'title' => __( 'Make first project wide', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to make the first portfolio project on the portfolio page in double size.', 'xstore' ),
                    'required' => array ( array( 'portfolio_projects', 'equals', true ) ),
                    'default' => false
                ),
                array (
                    'id' => 'portfolio_masonry',
                    'type' => 'switch',
                    'title' => __( 'Masonry', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on placing projects in optimal position based on available vertical space.', 'xstore' ),
                    'required' => array ( array( 'portfolio_projects', 'equals', true ) ),
                    'default' => true,
                ),
                array (
                    'id' => 'portfolio_columns',
                    'type' => 'select',
                    'title' => __( 'Columns', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the number of columns for the portfolio projects.', 'xstore' ),
                    'options' => array (
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                        6 => '6',
                    ),
                    'required' => array ( array( 'portfolio_projects', 'equals', true ) ),
                    'default' => 3
                ),
                array (
                    'id' => 'portfolio_margin',
                    'type' => 'select',
                    'title' => __( 'Portfolio item spacing', 'xstore' ),
                    'subtitle' => esc_html__( 'Set the space between portfolio projects on the portfolio page.', 'xstore' ),
                    'options' => array (
                        1 => '0',
                        5 => '5',
                        10 => '10',
                        15 => '15',
                        20 => '20',
                        30 => '30',
                    ),
                    'required' => array ( array( 'portfolio_projects', 'equals', true ) ),
                    'default' => 15
                ),
                array (
                    'id' => 'portfolio_count',
                    'type' => 'text',
                    'desc' => __( 'Use -1 to show all items', 'xstore' ),
                    'title' => __( 'Items per page', 'xstore' ),
                    'subtitle' => esc_html__( 'Set the number of projects to show on the portfolio page before pagination appears.', 'xstore' ),
                    'required' => array ( array( 'portfolio_projects', 'equals', true ) ),
                ),
                array (
                    'id' => 'port_single_nav',
                    'type' => 'switch',
                    'title' => __( 'Show next/previous projects navigation', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to show next/prev project navigation on the single project page.', 'xstore' ),
                    'required' => array ( array( 'portfolio_projects', 'equals', true ) ),
                    'default' => false
                ),
                array (
                    'id' => 'portfolio_images_size',
                    'type' => 'text',
                    'title' => __( 'Images sizes for portfolio', 'xstore' ),
                    'subtitle' => __( 'Choose the most suitable size for the project images on the portfolio page. Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height).', 'xstore' ),
                    'required' => array ( array( 'portfolio_projects', 'equals', true ) ),
                    'default' => 'large',
                ),
                array (
                    'id' => 'portfolio_order',
                    'type' => 'select',
                    'title' => __( 'Portfolio order way', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the method of collation for the portfolio projects on the portfolio page.', 'xstore' ),
                    'options' => array (
                        'DESC' => 'Descending',
                        'ASC' => 'Ascending',
                    ),
                    'required' => array ( array( 'portfolio_projects', 'equals', true ) ),
                    'default' => 'DESC'
                ),
                array (
                    'id' => 'portfolio_orderby',
                    'type' => 'select',
                    'title' => __( 'Portfolio order by', 'xstore' ),
                    'subtitle' => esc_html__( 'Choose the ascending or descending order for the portfolio projects.', 'xstore' ),
                    'options' => array (
                        'title' => 'Title',
                        'date' => 'Date',
                        'ID' => 'ID',
                    ),
                    'required' => array ( array( 'portfolio_projects', 'equals', true ) ),
                    'default' => 'title'
                ),

            ),
        ));

        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Social Sharing', 'xstore' ),
            'id'         => 'social-sharing',
            'subsection' => false,
            'icon'       => 'et-admin-icon et-social',
            'fields'     => array (
                array (
                    'id' => 'socials',
                    'type' => 'sorter',
                    'title' => __('Select socials you want to show', 'xstore'),
                    'subtitle' => esc_html__( 'Turn on share buttons you need to show on the single product and post pages.', 'xstore' ),
                    'options' => array (
                        'enabled' => array (
                            'share_twitter' => __( 'Share twitter', 'xstore' ),
                            'share_facebook' => __( 'Share facebook', 'xstore' ),
                            'share_vk' => __( 'Share vk', 'xstore' ),
                            'share_pinterest' => __( 'Share pinterest', 'xstore' ),
                            'share_google' => __( 'Share google', 'xstore' ),
                            'share_mail' => __( 'Share mail', 'xstore' ),
                            'share_linkedin' => __( 'Share linkedin', 'xstore' ),
                            'share_whatsapp' => __( 'Share whatsapp', 'xstore' ),
                            'share_skype' => __( 'Share skype', 'xstore' ),
                        ),
                        'disabled' => array (
                        ),
                    ),
                ),
            )
        ) );


        Redux::setSection( $opt_name, array(
            'title' => __( 'Facebook Login', 'xstore' ),
            'desc' => sprintf (esc_html__( 'To create FaceBook APP ID follow the instructions %1s Check theme documentation if it does not work for you %2s', 'xstore' ), '<a href="https://developers.facebook.com/docs/apps/register" target="blank">https://developers.facebook.com/docs/apps/register</a>', '<a href="https://xstore.helpscoutdocs.com/article/87-facebook-login" target="blank">https://xstore.helpscoutdocs.com/article/87-facebook-login</a>' ), 
            'id' => 'general-facebook',
            'subsection' => false,
            'icon' => 'et-admin-icon et-account',
            'fields' => array (
                array (
                    'id' => 'facebook_app_id',
                    'type' => 'text',
                    'title' => __( 'Facebook APP ID', 'xstore' )
                ),
                array (
                    'id' => 'facebook_app_secret',
                    'type' => 'text',
                    'title' => __( 'Facebook APP SECRET', 'xstore' )
                ),
            ),
        ));

        Redux::setSection( $opt_name, array(
            'title' => __( '404 page', 'xstore' ),
            'id' => 'general-page-not-found',
            'subsection' => false,
            'icon' => 'et-admin-icon et-page',
            'fields' => array (
                array (
                    'id' => '404_text',
                    'type' => 'editor',
                    'title' => __( '404 page content', 'xstore' ),
                    'subtitle' => esc_html__( 'Use it to change the content of the 404 page. Use HTML. Do not include JS.', 'xstore' )
                ),
            ),
        ));

        Redux::setSection( $opt_name, array(
            'title' => __( 'Custom CSS', 'xstore' ),
            'desc' => esc_html__( 'Once you\'ve isolated a part of theme that you\'d like to change, enter your CSS code to the fields below. Do not add JS or HTML to the fields. Custom CSS, entered here, will override a theme CSS. In some cases, the !important tag may be needed.', 'xstore' ),
            'id' => 'style-custom_css',
            'icon' => 'et-admin-icon et-css',
            'subsection' => false,
            'fields' => array (
                array (
                    'id' => 'custom_css',
                    'type' => 'ace_editor',
                    'mode' => 'css',
                    'title' => __( 'Global Custom CSS', 'xstore' ),
                    'compiler' => true
                ),
                array (
                    'id' => 'custom_css_desktop',
                    'type' => 'ace_editor',
                    'mode' => 'css',
                    'title' => __( 'Custom CSS for desktop (992px+)', 'xstore' ),
                    'compiler' => true
                ),
                array (
                    'id' => 'custom_css_tablet',
                    'type' => 'ace_editor',
                    'mode' => 'css',
                    'title' => __( 'Custom CSS for tablet (768px - 991px)', 'xstore' ),
                    'compiler' => true
                ),
                array (
                    'id' => 'custom_css_wide_mobile',
                    'type' => 'ace_editor',
                    'mode' => 'css',
                    'title' => __( 'Custom CSS for mobile landscape (481px - 767px)', 'xstore' ),
                    'compiler' => true
                ),
                array (
                    'id' => 'custom_css_mobile',
                    'type' => 'ace_editor',
                    'mode' => 'css',
                    'title' => __( 'Custom CSS for mobile (0 - 480px)', 'xstore' ),
                    'compiler' => true
                ),
            ),
        ));


         Redux::setSection( $opt_name, array(
            'title' => __( 'Speed Optimization ', 'xstore' ),
            'id' => 'general-optimization',
            'subsection' => false,
            'icon' => 'et-admin-icon et-speed',
            'fields' => array (
                array (
                    'id' => 'et_optimize_js',
                    'type' => 'switch',
                    'title' => esc_html__( 'Old browser support', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to load additional JS library to support old browsers.', 'xstore' ),
                    'default' => false,
                ),
                array (
                    'id' => 'et_optimize_css',
                    'type' => 'switch',
                    'title' => esc_html__( 'Optimize frontend CSS', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to load optimized CSS. Read our documentation to do it in a properly way if you are using child theme installed before 5.0 theme release.', 'xstore' ),
                    'default' => false,
                ),
                array (
                    'id' => 'global_masonry',
                    'type' => 'switch',
                    'title' => esc_html__( 'Masonry scripts', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to load masonry scripts to all pages. Enable this option if you plan to use WPBakery Brands list, 8theme Product Looks elements.', 'xstore' ),
                    'desc' => esc_html__( 'Loads masonry scripts needed to work for masonry elements (115kb of page size)', 'xstore' ),
                    'default' => false,
                ),
                array (
                    'id' => 'fa_icons',
                    'type' => 'switch',
                    'title' => esc_html__( 'FontAwesome support', 'xstore' ),
                    'subtitle' => esc_html__( 'Turn on to load FontAwesom 4.7 icons font and scripts.', 'xstore' ),
                    'desc' => esc_html__( 'Running FontAwesome scripts and styles needed to work for some elements that use those icons, e.g. menu subitem item icons (41kb of page size)', 'xstore' ),
                    'default' => false,
                ),
                array (
                    'id'       => 'menu_cache',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Menu cache', 'xstore' ),
                    'subtitle' => esc_html__( 'Enable object cache for menu.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'static_block_cache',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Static Blocks cache', 'xstore' ),
                    'subtitle' => esc_html__( 'Enable object cache for Static Blocks.', 'xstore' ),
                    'default'  => true,
                ),
                array (
                    'id'       => 'cssjs_ver',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Remove query strings from theme static resources', 'xstore' ),
                    'subtitle' => esc_html__( 'Enable to remove the version query string from static resources to improve the Remove query strings from static resources grade on GT Metrix. Don\'t enable if you use cache plugin where this option is also enabled', 'xstore' ),
                    'default'  => false,
                ),
                array (
                    'id'       => 'disable_emoji',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Disable emoji', 'xstore' ),
                    'subtitle' => esc_html__( 'It generates an additional HTTP request on your WordPress site to load the wp-emoji-release.min.js file. ', 'xstore' ),
                    'default'  => false,
                ),
            ),
        ));

        Redux::setSection( $opt_name, array(
            'title' => __( 'Import / Export', 'xstore' ),
            'id' => 'import',
            'icon'   => 'et-admin-icon et-import-export',
        ));

        Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Options', 'xstore' ),
            'desc'   => esc_html__( 'Import and Export your theme settings from file, text or URL.', 'xstore' ),
            'id' => 'import-export',
            'subsection' => true,
            // 'icon'   => 'el-icon-refresh',
            'fields' => array(
                array(
                    'id'         => 'opt-import-export',
                    'type'       => 'import_export',
                    'title'      => __( 'Import Export', 'xstore' ),
                    'subtitle'   => __( 'Save and restore your theme options.', 'xstore' ),
                    'full_width' => false,
                ),
            ),
        ));

        /*
         * <--- END SECTIONS
         */
    }

    add_action( 'after_setup_theme', 'etheme_redux_init', 1 );
}

add_filter('redux/options/et_options/compiler', 'compiler_action', 10, 3);
if ( ! function_exists( 'compiler_action' ) ) {
    function compiler_action( $options, $css, $changed_values ) {
        ini_set( 'max_execution_time', 900 );

        global $wp_filesystem;

        if ( empty( $wp_filesystem ) ) {
            require_once ( ABSPATH . '/wp-admin/includes/file.php' );
            WP_Filesystem();
        }

        $dir = wp_upload_dir();
        $options_css = $css;
        $css .= et_custom_styles();
        $css .= $options_css;
        $css .= et_custom_styles_responsive();
        $filename = $dir['basedir'].'/xstore/options-style.min.css';

        if ( !is_dir($dir['basedir'].'/xstore') ) {
            wp_mkdir_p($dir['basedir'].'/xstore/');
            // $wp_filesystem->put_contents( $filename, $css, 0755 );
            file_put_contents($filename, $css); 
        } else {
            // $wp_filesystem->put_contents( $filename, $css, 0755 );
            file_put_contents($filename, $css); 
        }
    }
}

// If Redux is running as a plugin, this will remove the demo notice and links
add_action( 'redux/loaded', 'remove_demo' );

// Remove the demo link and the notice of integrated demo from the redux-framework plugin

if ( ! function_exists( 'remove_demo' ) ) {
    function remove_demo() {
        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            remove_filter( 'plugin_row_meta', array(
                ReduxFrameworkPlugin::instance(),
                'plugin_metalinks'
            ), null, 2 );

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
        }
    }
}


