<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************// 
// ! Load complicated shortcodes
// **********************************************************************// 
etheme_load_shortcode('banner');
etheme_load_shortcode('title');
etheme_load_shortcode('images-carousel');
etheme_load_shortcode('carousel');
etheme_load_shortcode('icon-box');
etheme_load_shortcode('tabs');
etheme_load_shortcode('team-member');
etheme_load_shortcode('testimonials');
etheme_load_shortcode('twitter');
etheme_load_shortcode('instagram');
etheme_load_shortcode('blog');
etheme_load_shortcode('follow');
etheme_load_shortcode('countdown');

etheme_load_shortcode('category');
etheme_load_shortcode('categories');
etheme_load_shortcode('categories-lists');
etheme_load_shortcode('products');
etheme_load_shortcode('special-offer');
etheme_load_shortcode('brands');
etheme_load_shortcode('brands_list');
etheme_load_shortcode('looks');
etheme_load_shortcode('the-look');
etheme_load_shortcode('menu-list');
etheme_load_shortcode('menu-list-item');
etheme_load_shortcode('custom-tabs');
etheme_load_shortcode('menu');
etheme_load_shortcode('post-meta');
etheme_load_shortcode('et-slider');
etheme_load_shortcode('et-slider-item');

etheme_load_shortcode('scroll-text');
etheme_load_shortcode('scroll-text-item');

// Add shortcodes to MCE
if( ! function_exists('etheme_add_mce_button') ) {
    add_action('admin_head', 'etheme_add_mce_button');
    function etheme_add_mce_button() {
        if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
            return;
        }
        if ( 'true' == get_user_option( 'rich_editing' ) ) {
            add_filter( 'mce_external_plugins', 'etheme_add_tinymce_plugin');
            add_filter( 'mce_buttons', 'etheme_register_mce_button');
        }
    }

}

if( ! function_exists('etheme_add_tinymce_plugin') ) {
    // Declare script for new button
    function etheme_add_tinymce_plugin($plugin_array ) {
        $plugin_array['et_mce_button'] = ETHEME_CODE_JS . 'mce.js';
        return $plugin_array;
    }
}

if( ! function_exists('etheme_register_mce_button') ) {
    // Register new button in the editor
    function etheme_register_mce_button($buttons ) {
        array_push( $buttons, 'et_mce_button' );
        return $buttons;
    }
}

// **********************************************************************// 
// ! Shortcodes
// **********************************************************************// 

if ( ! function_exists('etheme_quick_view_shortcodes') ) :
    function etheme_quick_view_shortcodes($atts, $content=null){
        extract(shortcode_atts(array( 
            'id' => '',
            'class' => ''
        ), $atts));
        
        
        return '<div class="show-quickly-btn '.$class.'" data-prodid="'.$id.'">'. do_shortcode($content) .'</div>';

    }
endif;

// **********************************************************************// 
// ! Buttons
// **********************************************************************// 

if ( ! function_exists('etheme_btn_shortcode') ) :
    function etheme_btn_shortcode($atts){
        $a = shortcode_atts( array(
           'title' => 'Button',
           'url' => '#',
           'icon' => '',
           'size' => '',
           'style' => '',
           'et_class' => '',
           'type' => '',
           'target' => ''
       ), $atts );
        $icon = $class = '';
        if($a['icon'] != '') {
            $icon = '<i class="et-icon et-'.$a['icon'].'" style="vertical-align: middle;"></i>';
        }
        if($a['style'] != '') {
            $class .= ' '.$a['style'];
        }
        if($a['type'] != '') {
            $class .= ' '.$a['type'];
        }
        if($a['size'] != '') {
            $class .= ' '.$a['size'];
        }
        if($a['size'] != '') {
            $class .= ' '.$a['size'];
        }
        if($a['et_class'] != '') {
            $class .= ' '.$a['et_class'];
        }
        return '<a target="' . $a['target'] . '" class="btn'. $class .'" href="' . $a['url'] . '"><span>'. $icon . ' ' . $a['title'] . '</span></a>';
    }
endif;

// **********************************************************************// 
// ! Animated counter
// **********************************************************************//

if ( ! function_exists('etheme_counter_shortcode') ) :
    function etheme_counter_shortcode($atts, $content = null) {
        $a = shortcode_atts( array(
            'init_value' => 1,
            'final_value' => 100,
            'class' => ''
        ), $atts);

        return '<span id="animatedCounter" class="animated-counter '.$a['class'].'" data-value='.$a['final_value'].'>'.$a['init_value'].'</span>';
    }
endif;

// **********************************************************************// 
// ! Dropcap
// **********************************************************************// 

if ( ! function_exists('etheme_dropcap_shortcode') ) :
    function etheme_dropcap_shortcode($atts,$content=null) {
        $a = shortcode_atts( array(
           'style' => '',
           'color' => '',
        ), $atts );

        $style = '';
        if( ! empty( $a['color'] ) ) {
            $style = 'style="color:' . $a['color'] . ';"';
        }
       
        return '<span class="dropcap ' . $a['style'] . '" ' . $style . '>' . $content . '</span>';
    }
endif;

// **********************************************************************// 
// ! Mark
// **********************************************************************// 

if ( ! function_exists('etheme_mark_shortcode') ) :
    function etheme_mark_shortcode($atts,$content=null) {
        $a = shortcode_atts( array(
           'style' => '',
           'color' => '',
        ), $atts );

        $style = '';

        if( ! empty( $a['color'] ) ) {
            $style = 'style="background-color:' . $a['color'] . ';"';
        }

        if( ! empty( $a['color'] ) && $a['style'] == 'paragraph' ) {
            $style = 'style="color:' . $a['color'] . ';"';
        }
       
        return '<span class="mark-text ' . $a['style'] . '" ' . $style . '>' . $content . '</span>';
    }
endif;

// **********************************************************************// 
// ! Blockquote
// **********************************************************************// 

if ( ! function_exists('etheme_blockquote_shortcode') ) :
    function etheme_blockquote_shortcode($atts, $content = null) {
        $a = shortcode_atts( array(
            'align' => 'left',
            'class' => ''
        ), $atts);
        switch($a['align']) {

            case 'right':
                $align = 'fl-r';
            break;
            case 'center':
                $align = 'fl-none';
            break;
            default:
                $align = 'fl-l';        
        }
        $content = wpautop(trim($content));
        return '<blockquote class="' . $align .' '. $a['class'] . '">' . $content . '</blockquote>';
    }
endif;

// **********************************************************************// 
// ! Checklist
// **********************************************************************// 

if ( ! function_exists('etheme_checklist_shortcode') ) :
    function etheme_checklist_shortcode($atts, $content = null) {
        $a = shortcode_atts( array(
            'style' => 'arrow'
        ), $atts);
        switch($a['style']) {
            case 'arrow':
                $class = 'arrow';
            break;
            case 'circle':
                $class = 'circle';
            break;
            case 'star':
                $class = 'star';
            break;
            case 'square':
                $class = 'square';
            break;
            case 'dash':
                $class = 'dash';
            break;
            default:
                $class = 'arrow';
        }
        return '<div class="list list-' . $class . '">' . do_shortcode($content) . '</div   >';
    }
endif;

// **********************************************************************// 
// ! QR Code
// **********************************************************************// 

if ( ! function_exists('etheme_qrcode_shortcode') ) :
    function etheme_qrcode_shortcode($atts, $content = null) {
    $a = shortcode_atts(array(
            'size' => '128',
            'self_link' => 0,
            'title' => 'QR Code',
            'lightbox' => 0,
            'class' => ''
        ), $atts);

        return etheme_qr_code($content,$a['title'],$a['size'],$a['class'],$a['self_link'],$a['lightbox']);
    }
endif;

// **********************************************************************// 
// ! Visibility of next/prev pruduct
// **********************************************************************//

if ( ! function_exists('et_visible_pruduct') ) :
    function et_visible_pruduct( $id, $valid ){
        $product = wc_get_product( $id );

        // updated for woocommerce v3.0
        $visibility = $product->get_catalog_visibility();
        $stock = $product->is_in_stock();

        if (  $visibility  != 'hidden' &&  $visibility  != 'search' && $stock ) {
            return get_post( $id );
        }

        $the_query = new WP_Query( array( 'post_type' => 'product', 'p' => $id ) );

        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $valid_post = ( $valid == 'next' ) ? get_adjacent_post( 1, '', 0, 'product_cat' ) : get_adjacent_post( 1, '', 1, 'product_cat' );
                if ( empty( $valid_post ) ) return;
                $next_post_id = $valid_post->ID;
                $visibility = wc_get_product( $next_post_id );
                $stock = $visibility->is_in_stock();
                $visibility = $visibility->get_catalog_visibility();

            }
            // Restore original Post Data
            wp_reset_postdata();
        }

        if ( $visibility == 'visible' || $visibility == 'catalog' && $stock ) {
            return $valid_post;
        } else {
            return et_visible_pruduct( $next_post_id, $valid );
        }
            
    }
endif;

// **********************************************************************// 
// ! Project links
// **********************************************************************//

if ( ! function_exists('etheme_project_links') ) :
    function etheme_project_links( $atts, $content = null ) {

        global $post;
        $is_product = false;

        if ( $post->post_type == 'product' ) {
            $is_product = true;

            $next_post = get_adjacent_post( 1, '', 0, 'product_cat' );
            $prev_post = get_adjacent_post( 1, '', 1, 'product_cat' );

            if ( ! empty( $next_post ) && $next_post->post_type == 'product' ) {
                $next_post = et_visible_pruduct( $next_post->ID, 'next' );
            }

            if ( ! empty( $prev_post ) && $prev_post->post_type == 'product' ) {
                $prev_post = et_visible_pruduct( $prev_post->ID, 'prev' );
            }

        } else {
            $next_post = get_next_post();
            $prev_post = get_previous_post();
        }
        ?>
           <div class="posts-navigation">
                <?php if(!empty($prev_post)) : 
                if ( function_exists('mb_strlen') ) {
                    $prev_symbols = (mb_strlen(get_the_title($prev_post->ID)) > 30) ? '...' : ''; 
                    $title = mb_substr(get_the_title($prev_post->ID),0,30) . $prev_symbols;
                } 
                else {
                    $prev_symbols = (strlen(get_the_title($prev_post->ID)) > 30) ? '...' : ''; 
                    $title = substr(get_the_title($prev_post->ID),0,30) . $prev_symbols;
                }?>
                    <div class="posts-nav-btn prev-post">
                        <div class="post-info">
                            <div class="post-details">
                                 <a href="<?php echo get_permalink($prev_post->ID); ?>" class="post-title">
                                    <?php echo esc_html($title); ?>
                                </a>
                                <?php if ( $is_product ) {
                                    $p = wc_get_product($prev_post);
                                        echo '<p class="price">'.$p->get_price_html().'</p>';
                                    } ?>
                            </div>
                            <a href="<?php echo get_permalink($prev_post->ID); ?>">
                                <?php $img = get_the_post_thumbnail( $prev_post->ID, array(90, 90));
                                echo (!empty($img) ) ? $img : '<img src="'.ETHEME_BASE_URI.'images/placeholder.jpg">';  ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(!empty($next_post)) : 
                 if ( function_exists('mb_strlen') ) {
                    $next_symbols = (mb_strlen(get_the_title($next_post->ID)) > 30) ? '...' : ''; 
                    $title = mb_substr(get_the_title($next_post->ID),0,30) . $next_symbols;
                } 
                else {
                    $next_symbols = (strlen(get_the_title($next_post->ID)) > 30) ? '...' : ''; 
                    $title = substr(get_the_title($next_post->ID),0,30) . $next_symbols;
                    } ?>
                    <div class="posts-nav-btn next-post">
                            <div class="post-info">
                                <a href="<?php echo get_permalink($next_post->ID); ?>">
                                    <?php $img = get_the_post_thumbnail( $next_post->ID, array(90, 90));
                                    echo (!empty($img) ) ? $img : '<img src="'.ETHEME_BASE_URI.'images/placeholder.jpg">';  ?>
                                </a>
                                <div class="post-details">
                                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="post-title">   
                                        <?php echo esc_html($title); ?>
                                    </a>
                                     <?php if ( $is_product ) {
                                        $p = wc_get_product($next_post);
                                       echo '<p class="price">'.$p->get_price_html().'</p>';
                                    } ?>
                                </div>
                            </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php wp_reset_query();
    }
endif;

// **********************************************************************// 
// ! Tooltip
// **********************************************************************// 

if ( ! function_exists('etheme_tooltip_shortcode') ) :
    function etheme_tooltip_shortcode($atts,$content=null){
        $a = shortcode_atts( array(
           'position' => 'top',
           'text' => '',
           'class' => ''
       ), $atts );
       
        return '<div class="et-tooltip '.$a['class'].'" rel="tooltip" data-placement="'.$a['position'].'" data-original-title="'.$a['text'].'"><div><div>'.$content.'</div></div></div>';
    }
endif;

// **********************************************************************// 
// ! Share This Product
// **********************************************************************// 

if ( ! function_exists('etheme_share_shortcode') ) :
    function etheme_share_shortcode($atts, $content = null) {
        $socials = etheme_get_option('socials');
        $socials = $socials['enabled'];
        extract(shortcode_atts(array(
            'title'  => '',
            'text' => '',
            'tooltip' => 1,
            'twitter' => array_key_exists( 'share_twitter', $socials ),
            'facebook' =>  array_key_exists( 'share_facebook', $socials ),
            'vk' =>  array_key_exists( 'share_vk', $socials ),
            'pinterest' =>  array_key_exists( 'share_pinterest', $socials ),
            'google' =>  array_key_exists( 'share_google', $socials ),
            'mail' =>  array_key_exists( 'share_mail', $socials ),
            'linkedin' =>  array_key_exists( 'share_linkedin', $socials ),
            'whatsapp' =>  array_key_exists( 'share_whatsapp', $socials ),
            'skype' =>  array_key_exists( 'share_skype', $socials ),
            'class' => ''
        ), $atts));
        global $post;
        if(!isset($post->ID)) return;
        $html = '';
        $permalink = get_permalink($post->ID);
        $tooltip_class = '';
        if($tooltip) {
            $tooltip_class = 'title-toolip';
        }
        $image =  wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'small' );
        $image = $image[0];
        $post_title = rawurlencode(get_the_title($post->ID));
        $post_title = ( ! empty( $text ) ) ? $text : $post_title;
        if($title) $html .= '<span class="share-title">'.$title.'</span>';
        $html .= '
            <ul class="menu-social-icons '.$class.'">
        ';
        if($twitter == 1) {
            $html .= '
                    <li>
                        <a href="https://twitter.com/share?url='.$permalink.'&text='.$post_title.'" class="'.$tooltip_class.'" title="'.__('Twitter', 'xstore').'" target="_blank">
                            <i class="et-icon et-twitter"></i>
                        </a>
                    </li>
            ';
        }

        if($facebook == 1) {
            $html .= '
                    <li>
                        <a href="http://www.facebook.com/sharer.php?u='.$permalink.'&amp;images='.$image.'" class="'.$tooltip_class.'" title="'.__('Facebook', 'xstore').'" target="_blank">
                            <i class="et-icon et-facebook"></i>
                        </a>
                    </li>
            ';
        }

        if($vk == 1) {
            $html .= '
                    <li>
                        <a href="http://vk.com/share.php?url='.$permalink.'&image='.$image.'?&title='.$post_title.'" class="'.$tooltip_class.'" title="'.__('VK', 'xstore').'" target="_blank">
                            <i class="et-icon et-vk"></i>
                        </a>
                    </li>
            ';
        }

        if($pinterest == 1) {
            $html .= '
                    <li>
                        <a href="http://pinterest.com/pin/create/button/?url='.$permalink.'&amp;media='.$image.'&amp;description='.$post_title.'" class="'.$tooltip_class.'" title="'.__('Pinterest', 'xstore').'" target="_blank">
                            <i class="et-icon et-pinterest"></i>
                        </a>
                    </li>
            ';
        }

        if($google == 1) {
            $html .= '
                    <li>
                        <a href="http://plus.google.com/share?url='.$permalink.'&title='.$text.'" class="'.$tooltip_class.'" title="'.__('Google +', 'xstore').'" target="_blank">
                            <i class="et-icon et-google-plus"></i>
                        </a>
                    </li>
            ';
        }

        if($mail == 1) {
            $html .= '
                    <li>
                        <a href="mailto:enteryour@addresshere.com?subject='.$post_title.'&amp;body='. __('Check%20this%20out:%20', 'xstore' ) .$permalink.'" class="'.$tooltip_class.'" title="'.__('Mail to friend', 'xstore').'" target="_blank">
                            <i class="et-icon et-message"></i>
                        </a>
                    </li>
            ';
        }

        if($linkedin == 1) {
            $html .= '
                    <li>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url='.$permalink.'&title='.$text.'" class="'.$tooltip_class.'" title="'.__('linkedin', 'xstore').'" target="_blank">
                            <i class="et-icon et-linkedin"></i>
                        </a>
                    </li>
            ';
        }

        if($whatsapp == 1) {
            $html .= '
                    <li>
                        <a href="whatsapp://send?text='.$permalink.'" class="'.$tooltip_class.'" title="'.__('whatsapp', 'xstore').'" target="_blank">
                            <i class="et-icon et-whatsapp"></i>
                        </a>
                    </li>
            ';
        }

        if($skype == 1) {
            $html .= '
                    <li>
                        <a href="https://web.skype.com/share?url='.$permalink.'" title="'.__('skype', 'xstore').'" target="_blank">
                            <i class="et-icon et-skype"></i>
                        </a>
                    </li>
            ';
        }
        
        $html .= '
            </ul>
        ';
        return $html;
    }
endif;

// **********************************************************************// 
// ! Static Block Shortcode
// **********************************************************************// 
if ( ! function_exists('etheme_block_shortcode') ) :
function etheme_block_shortcode($atts) {
    $a = shortcode_atts(array(
        'class' => '',
        'id' => ''
    ),$atts);

    return etheme_static_block($a['id'], false);
}
endif;
?>
