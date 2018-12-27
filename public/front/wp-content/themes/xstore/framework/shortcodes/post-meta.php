<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************//
// ! Post Meta
// **********************************************************************//

if ( ! function_exists( 'etheme_post_meta_shortcode' ) ) {
    function etheme_post_meta_shortcode($atts) {
        extract(shortcode_atts(array(
            'time' => true,
            'time_details' => true,
            'author'  => true,
            'comments' => true,
            'count' => true,
            'class' => '',
        ), $atts));

        $class = ( ! empty( $class ) ) ? $class . ' ' : '';
        $comment_link_template = '<span>%s</span> <span>%s</span>';

        ob_start();

        ?>

            <div class="<?php echo esc_attr($class); ?>meta-post et-shortcode">

                <?php if ( $time == 'true' ): ?>
                    <time class="entry-date published updated" datetime="<?php the_time('F j, Y'); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time>
                <?php endif ?>

                <?php if ( $time_details == 'true' ): ?>
                    <?php esc_html_e( 'at', 'xstore' );?>
                    <?php the_time( get_option( 'time_format' ) ); ?>
                <?php endif ?>

                <?php if ( $author == 'true' ): ?>
                    <?php esc_html_e( 'by', 'xstore' );?> <?php the_author_posts_link(); ?>
                <?php endif ?>
                        
                <?php if ( $count == 'true' ): ?>
                    <span class="meta-divider">/</span>
                     <?php etheme_get_views('', true) ?>
                <?php endif ?>
      
                <?php 
                    // Display Comments
                    if( $comments == 'true' && comments_open() && !post_password_required()) { ?>
                        <span class="meta-divider">/</span>
                        <?php comments_popup_link('<span>0</span>','<span>1</span>','<span>%</span>','post-comments-count');
                    }
                ?>
                   
            </div>
        <?php
        return ob_get_clean();
    }
}