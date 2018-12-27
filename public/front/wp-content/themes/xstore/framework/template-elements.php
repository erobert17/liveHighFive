<?php  if ( ! defined('ABSPATH')) exit('No direct script access allowed');
// **********************************************************************//
// ! Page heading
// **********************************************************************//
if(!function_exists('etheme_page_heading')) {

	add_action('etheme_page_heading', 'etheme_page_heading', 10);

	function etheme_page_heading() {

		$l = etheme_page_config();

		if ($l['breadcrumb'] !== 'disable' && !$l['slider']): ?>

			<div class="page-heading bc-type-<?php echo esc_attr( $l['breadcrumb'] ); ?> bc-effect-<?php echo esc_attr( $l['bc_effect'] ); ?> bc-color-<?php echo esc_attr( $l['bc_color'] ); ?>">
				<div class="container">
					<div class="row">
						<div class="col-md-12 a-center">
							<?php etheme_breadcrumbs(); ?>
						</div>
					</div>
				</div>
			</div>

		<?php endif;

		if($l['slider']): ?>
			<div class="page-heading-slider">
				<?php echo do_shortcode('[rev_slider_vc alias="'.$l['slider'].'"]'); ?>
			</div>
		<?php endif;
	}
}

// **********************************************************************//
// ! Get logo
// **********************************************************************//
if ( ! function_exists( 'etheme_logo' ) ) {
    function etheme_logo($echo = true) {
    	$logo = etheme_get_logo_data();

    	$out = '<a href="' . esc_url( home_url( '/' ) ) . '">';
    		$out .= '<img src="' . $logo['logo']['src'] . '" alt="' . $logo['logo']['alt'] . '" width="' . $logo['logo']['width'] . '" height="' . $logo['logo']['height'] .'" class="logo-default" />';
    		$out .= '<img src="' . $logo['fixed_logo']['src'] . '" alt="' . $logo['fixed_logo']['alt'] . '" width="' . $logo['fixed_logo']['width'] . '" height="' . $logo['fixed_logo']['height'] .'" class="logo-fixed" />';
    	$out .= '</a>';

    	if ( $echo ) {
			echo $out;
		} else {
			return $out;
		}
    }
}

// **********************************************************************//
// ! Get top links
// **********************************************************************//
if( ! function_exists( 'etheme_top_links' ) ) {
	function etheme_top_links($args = array(), $account = false, $pp = true) {
		extract(shortcode_atts(array(
			'short'  => false,
		), $args));

		$popup = $out = '';

		if( etheme_get_option( 'promo_popup' ) && $pp) {
			$popup = array(
				'class' 	 => 'popup_link',
				'link_class' => 'etheme-popup',
				'href' 		 => '#etheme-popup-holder',
				'title' 	 => etheme_get_option( 'promo-link-text' ),
			);

			if( ! etheme_get_option( 'promo_link' ) ) $popup['class'] .= ' hidden';
			if( etheme_get_option( 'promo_auto_open' ) ) $popup['link_class'] .= ' open-click';
		}

		if ( $popup ){
			$out .= sprintf(
				'<li class="%s"><a href="%s" class="%s">%s</a>%s</li>',
				$popup['class'],
				$popup['href'],
				$popup['link_class'],
				$popup['title'],
				( isset( $popup['submenu'] ) ) ? $popup['submenu'] : ''
			);
		}
		if ( $account ){
			$account = etheme_sign_link( '', $short );
			$out .= sprintf(
				'<li class="%s"><a href="%s" class="%s">%s</a>%s</li>',
				$account['class'],
				$account['href'],
				$account['link_class'],
				$account['title'],
				( isset( $account['submenu'] ) ) ? $account['submenu'] : ''
			);
		}

		if ( $out ) echo '<ul class="links">' . $out . '</ul>';
    }
}


// **********************************************************************//
// ! Post content image
// **********************************************************************//

if( ! function_exists( 'etheme_post_thumb' ) ) {
	function etheme_post_thumb( $args = array() ) {
		global $et_loop;

		$defaults = array(
			'size' 		=> 'large',
			'in_slider' => false,
			'link' 		=> true,
		);

		$args 		 = wp_parse_args( $args, $defaults );
		$post_format = get_post_format();

		?>
		<?php if( $post_format == 'gallery' && ! $args['in_slider'] ): ?>
			<?php $gallery_filter = etheme_gallery_from_content( get_the_content() ); ?>

            <?php if( count( $gallery_filter['ids'] ) > 0 ): ?>
                <div class="swiper-entry et_post-slider arrows-effect-static">
	                <div class="swiper-container slider_id-<?php echo rand( 100, 10000 ); ?>" data-autoheight="1">
	                    <div class="swiper-wrapper">
							<?php 
								foreach ( $gallery_filter['ids'] as $attach_id ) {
									echo '<div class="swiper-slide">' . etheme_get_image( $attach_id, $args['size'] ) . '</div>';
								}
							?>
	                    </div>
	                    <div class="swiper-pagination"></div>
	                    <div class="swiper-custom-left"></div>
	                	<div class="swiper-custom-right"></div>
	                </div>
	            </div>
            <?php endif; ?>

		<?php elseif( $post_format == 'video' ): ?>
			<?php etheme_the_post_field( 'video' ); ?>

		<?php elseif( $post_format == 'audio' ): ?>
			<?php etheme_the_post_field( 'audio' ); ?>

		<?php elseif( has_post_thumbnail() ): ?>
			<?php
				$location = ( $args['in_slider'] ) ? 'slider' : '';
				$hover 	  = ( ! empty( $et_loop['blog_hover'] ) ) ? $et_loop['blog_hover'] : etheme_get_option( 'blog_hover' );
			?>

			<div class="wp-picture blog-hover-<?php echo esc_attr( $hover ); ?>">

				<?php if ( $args['link']): ?>
					<a href="<?php the_permalink(); ?>">
						<?php echo etheme_get_image( get_post_thumbnail_id(), $args['size'], $location ); ?>
						<?php if ( $location == 'slider' ) etheme_loader( true, 'swiper-lazy-preloader' ); ?>
					</a>
				<?php else: ?>
					<?php echo etheme_get_image( get_post_thumbnail_id(), $args['size'], $location ); ?>
					<?php if ( $location == 'slider' ) etheme_loader( true, 'swiper-lazy-preloader' ); ?>
				<?php endif ?>

	            <?php etheme_primary_category(true); ?>

	            <?php if ( ! is_single() || $args['in_slider'] ): ?>
	            	<div class="blog-mask">
	            		<?php if( $post_format != 'quote' ): ?>
	            		<div class="blog-mask-inner">
							<div class="svg-wrapper">
								<svg height="40" width="150" xmlns="http://www.w3.org/2000/svg">
									<rect class="shape" height="40" width="150" />
								</svg>
								<a href="<?php the_permalink(); ?>" class="btn btn-read-more"><?php esc_html_e( 'Read more', 'xstore' ); ?></a>
							</div>
	            		</div>
	            		<?php endif; ?>
	            	</div>
	            <?php endif ?>

                <?php if( $post_format == 'quote' ): ?>
                    <div class="featured-quote">
                        <div class="quote-content">
                            <?php etheme_the_post_field( 'quote' ); ?>
                        </div>
                    </div>
                <?php endif; ?>
			</div>
		<?php endif; ?>
		<?php
	}
}

// **********************************************************************//
// ! Meta data block (byline)
// **********************************************************************//
if( ! function_exists( 'etheme_byline' ) ) {
	function etheme_byline($atts = array() ) {
		if( ! etheme_get_option( 'blog_byline' ) ) return;

        extract( shortcode_atts( array(
            'author' => 0,
            'time' => 0,
            'slide_view' => 0,
        ), $atts ) );
        
        $blog_layout 		   = etheme_get_option( 'blog_layout' );

		?>
        <div class="meta-post">
	        <?php if( ! in_array( $blog_layout , array( 'timeline', 'timeline2', 'grid2' ) ) ): ?>
				<time class="entry-date published updated" datetime="<?php the_time('F j, Y'); ?>"><?php the_time(get_option('date_format')); ?></time>
				
				<?php if ( $time ): ?>
					<?php esc_html_e( 'at', 'xstore' );?>
					<?php the_time( get_option( 'time_format' ) ); ?>
				<?php endif; ?>
				
				<?php if ( $author ): ?>
					<?php esc_html_e( 'by', 'xstore' );?> <?php the_author_posts_link(); ?>
				<?php endif; ?>

			<?php elseif( $slide_view == 'timeline2' ) : ?>
				<?php esc_html_e( 'Posted by', 'xstore' );?> <?php the_author_posts_link(); ?>
	        <?php endif; ?>

         	<?php if ( etheme_get_option( 'views_counter' ) ): ?>
         		<span class="meta-divider">/</span>
            	<?php etheme_get_views( '', true ) ?>
     		<?php endif; ?>
        	<?php
                if(comments_open() && ! post_password_required() ) { ?>
                <span class="meta-divider">/</span> 
                <?php comments_popup_link('<span>0</span>','<span>1</span>','<span>%</span>','post-comments-count');
                }
         	?>
        </div>
        <?php
	}
}
// **********************************************************************//
// ! ET loader HTML
// **********************************************************************//
if (!function_exists('etheme_loader')) {
	function etheme_loader($echo = true, $class="") {
		$img = etheme_get_option( 'preloader_img' );

		$html = '';

		$html .= '<div class="et-loader '.$class.'">';
			if ( ! empty( $img['url'] ) ){
				$html .= '<img class="et-loader-img" src="' . $img['url'] . '" alt="et-loader">';
			} else {
				$html .= '<svg class="loader-circular" viewBox="25 25 50 50"><circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg>';
			}
		$html .= '</div>';

		if ($echo) {
			echo $html;
		} else {
			return $html;
		}
	}
}

add_action( 'et_after_body', 'etheme_loader', 100, 1);


// **********************************************************************//
// ! Show navigation
// **********************************************************************//
function etheme_menu( $menu_id = 'main-menu', $type = 'custom_nav' ){
    $custom_menu   = etheme_get_custom_field( $type );
    $one_page_menu = ( etheme_get_custom_field( 'one_page' ) ) ? ' one-page-menu' : '';
    $cache         = etheme_get_option( 'menu_cache' );

	if ( $menu_id == 'mobile-menu' ) {
        $custom_menu_args = array(
            'menu' => $custom_menu,
            'before' => '',
            'container_class' => 'menu-mobile-container' . $one_page_menu,
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'depth' => 4,
            'fallback_cb' => false,
            'walker' => new ETheme_Navigation_Mobile
        );
        $menu_args = array(
            'container_class' => $one_page_menu,
            'theme_location' => 'mobile-menu',
            'walker' => new ETheme_Navigation_Mobile
        );
    } else {
        $custom_menu_args = array(
            'menu' => $custom_menu,
            'before' => '',
            'container_class' => 'menu-main-container' . $one_page_menu,
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'depth' => 100,
            'fallback_cb' => false,
            'walker' => new ETheme_Navigation
        );
        $menu_args = array(
            'theme_location' => $menu_id,
            'before' => '',
            'container_class' => 'menu-main-container',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'depth' => 100,
            'fallback_cb' => false,
            'walker' => new ETheme_Navigation
        );
    }

    if( ! empty( $custom_menu ) && $custom_menu != '' ) {
        etheme_nav_menu( $custom_menu_args, $cache, $menu_id );
    } elseif ( has_nav_menu( $menu_id ) ) {
        etheme_nav_menu( $menu_args, $cache, $menu_id );
	} else {
        printf(
            '<h4 class="a-center">%s <em>%s</em></h4>',
            esc_html__( 'Set your menu in', 'xstore' ),
            esc_html__( 'Appearance &gt; Menus', 'xstore' )
        );
	}
}

function etheme_nav_menu($args, $cache, $menu_id){
    if ( $cache ) {
        $output = false;
        $output = wp_cache_get( $menu_id, 'etheme_' . $menu_id );
        if ( ! $output ) {
            ob_start();
                wp_nav_menu( $args );
                $output = ob_get_contents();
            ob_end_clean();
            wp_cache_add( $menu_id, $output, 'etheme_' . $menu_id );
        }
        echo $output;
    } else {
        wp_nav_menu( $args );
    }
}

// **********************************************************************// 
// ! Pagination links
// **********************************************************************// 
if(!function_exists('etheme_pagination')) {
	function etheme_pagination($args = array()) {
		extract( shortcode_atts( array(
			'pages'  => 1,
			'paged'  => 1,
			'range'  => 2,
			'class'  => '',
			'before' => '',
			'after'  => '',
			'prev_next' => true,
			'prev_text' => '<i class="et-icon et-left-arrow"></i>',
			'next_text' => '<i class="et-icon et-right-arrow"></i>'
        ), $args ) );

	    if( $pages != 1 ){
	    	$showitems = ( $range * 2 )+1;
	    	$out = '';

	    	if( $prev_next && $paged > 1  ){
			 	$out .= '<li><a href="' . get_pagenum_link($paged-1) . '" class="prev page-numbers">' . $prev_text . '</a></li>';
			}

			for ( $i=1; $i <= $pages; $i++ ){
				if ( $pages != 1 &&( ! ( $i >= $paged+$range+1 || $i <= $paged-$range-1 ) || $pages <= $showitems ) ){
					if ( $paged == $i ) {
						$out .= '<li><span class="page-numbers current">' . $i . '</span></li>';
					} else {
						$out .= '<li><a href="' . get_pagenum_link($i) . '" class="inactive">' . $i . '</a></li>';
					}
				}
			}
			
			if ( $prev_next && $paged < $pages ){
				$out .= '<li><a href="' . get_pagenum_link($paged + 1) . '" class="next page-numbers">' . $next_text . '</a></li>';
			}
	        echo '
				<div class="etheme-pagination ' . $class . '">
				' . $before . '
				<nav class="pagination-cubic"><ul class="page-numbers">' . $out . '</ul></nav>
				' . $after . '
				</div>
	        ';
     	}
	}
}

// **********************************************************************//
// ! Display quantity of posts on the page.
// **********************************************************************//
if ( ! function_exists( 'etheme_count_posts' ) ) {

    function etheme_count_posts( $args = array() ) {
        $args = shortcode_atts( array(
            'skip_query'  => false,
            'total'       => 1,
            'first'       => '',
            'last'        => '',
            'echo'        => true
        ), $args );

        if ( $args['skip_query'] ) {
            $total = $args['total'];
            $first = $args['first'];
            $last = $args['last'];
            $out = sprintf(
                esc_html_x(
                    ' %1$d&ndash;%2$d %4$s %3$d posts',
                    '%1$d = first, %2$d = last, %3$d = total',
                    'xstore'
                ),
                $first,
                $last,
                $total,
                esc_html__( 'of', 'xstore' )
            );
        } else {
            global $wp_query;

            $paged    = max( 1, $wp_query->get( 'paged' ) );
            $per_page = $wp_query->get( 'posts_per_page' );
            $total    = $wp_query->found_posts;
            $first    = ( $per_page * $paged ) - $per_page + 1;
            $last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );

            if ( $total == 1 ) {
                $out = esc_html__( 'the single result', 'xstore' );
            } elseif ( $total <= $per_page || -1 === $per_page ) {
                $out = sprintf( '%1$s %2$d %3$s' , esc_html__( 'all', 'xstore' ), $total, esc_html__( 'posts', 'xstore' ) );
            } else {
                 $out = sprintf(
                    esc_html_x(
                        ' %1$d&ndash;%2$d %4$s %3$d posts',
                        '%1$d = first, %2$d = last, %3$d = total',
                        'xstore'
                    ),
                    $first,
                    $last,
                    $total,
                    esc_html__( 'of', 'xstore' )
                );
            }
        }

        if ( $args['echo'] ) {
            return printf( '<p class="et_count-posts">%1$s %2$s</p>', esc_html__( 'Showing', 'xstore' ), $out );
        } else {
            return sprintf( '<p class="et_count-posts">%1$s %2$s</p>', esc_html__( 'Showing', 'xstore' ), $out );
        }
    }
};

// **********************************************************************//
// ! Show Search form
// **********************************************************************//
if(!function_exists('etheme_search_form')) {
    function etheme_search_form( $args = array() ) {
    	extract( wp_parse_args( $args, array(
    		'action' => 'full-width'
    	) ));

    	$class = '';
    	$class = ' act-' . $action;
        ?>
            <div class="header-search<?php echo esc_attr( $class ); ?>">
                <a href="#" class="search-btn"><i class="et-icon et-zoom"></i> <span><?php esc_html_e('Search', 'xstore'); ?></span></a>
               	<div class="search-form-wrapper">
	                <?php get_template_part('woosearchform'); ?>
               	</div>
            </div>
        <?php
    }
}

// **********************************************************************//
// ! Function to display comments
// **********************************************************************//
if(!function_exists('etheme_comments')) {
    function etheme_comments($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        if( get_comment_type() == 'pingback' || get_comment_type() == 'trackback' ) : ?>
            <li id="comment-<?php comment_ID(); ?>" class="pingback">
                <div class="comment-block row">
                    <div class="col-md-12">
                        <div class="author-link"><?php esc_html_e('Pingback:', 'xstore') ?></div>
                        <div class="comment-reply"> <?php edit_comment_link(); ?></div>
                        <?php comment_author_link(); ?>
                    </div>
                </div>
				<div class="media">
					<h4 class="media-heading"><?php esc_html_e('Pingback:', 'xstore') ?></h4>
	                <?php comment_author_link(); ?>
					<?php edit_comment_link(); ?>
				</div>
       	<?php elseif(get_comment_type() == 'comment') :
    		$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) ); ?>

			<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<div class="media">
					<div class="pull-left"><?php echo get_avatar($comment, 80); ?></div>

					<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>
						<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( esc_html__( 'Rated %d out of 5', 'xstore' ), $rating ) ?>">
							<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%">
								<strong itemprop="ratingValue"><?php echo intval( $rating ); ?></strong> <?php esc_html_e( 'out of 5', 'xstore' ); ?>
							</span>
						</div>
					<?php endif; ?>

					<div class="media-body">
						<h4 class="media-heading"><?php comment_author_link(); ?></h4>
						<div class="meta-comm"><?php comment_date(); ?> - <?php comment_time(); ?></div>

                        <?php if ($comment->comment_approved == '0'): ?>
                            <p class="awaiting-moderation"><?php esc_html__('Your comment is awaiting moderation.', 'xstore') ?></p>
                        <?php endif ?>

                        <?php comment_text(); ?>
                        <?php
                        	comment_reply_link(array_merge(
                    			$args, array('reply_text' => esc_html__('Reply to comment', 'xstore'),
                    			'depth' => $depth, 'max_depth' => $args['max_depth'])
                    		));
                        ?>
					</div>
				</div>
        <?php endif;
    }
}

// **********************************************************************// 
// ! Create products grid by args
// **********************************************************************//
if(!function_exists('etheme_products')) {
    function etheme_products($args,$title = false, $columns = 4, $extra = array() ){
        global $wpdb, $woocommerce_loop;
        $output = '';

        if ( isset($woocommerce_loop['view_mode']) && $woocommerce_loop['view_mode'] == 'list' && $columns > 3) { $columns = 3; }

		if ( isset( $extra['navigation'] ) && $extra['navigation'] != 'off' ){
			$args['no_found_rows'] = false;
			$args['posts_per_page'] = $extra['per-page'];
		} 

        $products = new WP_Query( $args );
        $class = '';

       

        wc_setup_loop( array(
			'columns'      => $columns,
			'name'         => 'product',
			'is_shortcode' => true,
			'total'        => $args['posts_per_page'],
		) );

        if ( $products->have_posts() ) :  
        	if ( wc_get_loop_prop( 'total' ) ) { 
        		if ( $title != '' ) {
		        	echo '<h2 class="products-title"><span>' . esc_html( $title ) . '</span></h2>';
		        }
        	?>
            <?php woocommerce_product_loop_start(); ?>

                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                   <?php $output .= wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>
                
            <?php woocommerce_product_loop_end(); ?>
            <?php } ?>
        <?php endif;

        wp_reset_postdata();
        wc_reset_loop();

        // ! Do it for load more button
		if ( isset( $extra['navigation'] ) && $extra['navigation'] != 'off' ) {
			if ( $products->max_num_pages > 1 && $extra['limit'] > $extra['per-page'] ) {
				$attr = 'paged="1"';
				$attr .= ' max-paged="' . $products->max_num_pages . '"';

				if ( isset( $extra['limit'] ) && $extra['limit'] != -1 ) {
					$attr .= ' limit="' . $extra['limit'] . '"';
				}

				$ajax_nonce = wp_create_nonce( 'etheme_products' );

				$attr .= ' nonce="' . $ajax_nonce . '"';

				$loader = etheme_loader(false);
				$type = ( $extra['navigation'] == 'lazy' ) ? 'lazy-loading' : 'button-loading';

		        $output .= '
		        <div class="et-load-block text-center et_load-products ' . $type . '">
		        	' . $loader . '
		        	<span class="btn">
		        		<a ' . $attr . '>' . esc_html__( 'Load More', 'xstore' ) . '</a>
		        	</span>
		        </div>';
			}
		}
		return $output;
    }
}



if( wp_doing_ajax() ){
	add_action( 'wp_ajax_etheme_ajax_products', 'etheme_ajax_products');
	add_action( 'wp_ajax_nopriv_etheme_ajax_products', 'etheme_ajax_products');
}

if(!function_exists('etheme_ajax_products')) {
    function etheme_ajax_products( $args = array() ){
    	if( isset( $_POST['_wpnonce'] ) ) return;
    	if( $_POST['context'] !== 'frontend' ) return;

    	global $wpdb, $woocommerce_loop;

    	$attr = array();
    	$attr = $_POST['attr'];
        $output = '';
        $args = Array(
		    'post_type' => 'product',
		    'ignore_sticky_posts' => 1,
		    'no_found_rows' => 1,
		    'posts_per_page' => $attr['per-page'],
		    'paged' => $attr['paged'],
		    'orderby' =>'', 
		    'order' => 'ASC',
		);

        if ( $attr['orderby'] ) {
    		$args['orderby'] = $attr['orderby'];
    	} else {
    		$args['orderby'] = '';
    	}

    	if ( $attr['order'] ) {
    		$args['order'] = $attr['order'];
    	} else {
    		$args['order'] = 'ASC';
    	}

    	if ( isset( $attr['stock'] ) ) {
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

        if (  isset( $attr['type'] ) ) {
        	switch ($attr['type']) {
	        	case 'featured':
			          	$args['tax_query'][] = array(
			              'taxonomy' => 'product_visibility',
			              'field'    => 'name',
			              'terms'    => 'featured',
			              'operator' => 'IN',
			          );
	        		break;
	        	case 'bestsellings':
			          	$args['meta_key'] = 'total_sales';
	            		$args['orderby'] = 'meta_value_num';
	        		break;
	        	default:

	        		break;
	        }
        }

        if ($attr['orderby'] == 'price') {
            $args['meta_key'] = '_price';
            $args['orderby'] = 'meta_value_num';
        }

    	if ( isset($attr['ids']) ) {
    		$ids = explode( ',', $attr['ids'] );
    		$ids = array_map('trim', $ids);
    		$args['post__in'] = $ids;
    	}

    	// Narrow by categories
        if( ! empty( $attr['taxonomies'] ) ) {
            $taxonomy_names = get_object_taxonomies( 'product' );
            $terms = get_terms( $taxonomy_names, array(
                'orderby' => 'name',
                'include' => $attr['taxonomies']
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

        $products = new WP_Query( $args );
        $class = '';

        wc_setup_loop( array(
			'columns'      => $attr['columns'],
			'name'         => 'product',
			'is_shortcode' => true,
			'total'        => $args['posts_per_page'],
		) );

		if ( isset( $attr['limit'] ) ) {
			$_i = 0;
		}

		$woocommerce_loop['loading_class'] = 'productAnimated product-fade';

        if ( $products->have_posts() ) :  
        	if ( wc_get_loop_prop( 'total' ) ) { 

        	?>
            <?php woocommerce_product_loop_start(false); ?>

                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                	<?php
                	if ( isset( $attr['limit'] ) ) {
                		if ( $_i >= $attr['limit'] ) {
                			break;
                		}
                		$_i++;
                	}
                	?>

                   <?php $output .= wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>
                
            <?php woocommerce_product_loop_end(false); ?>
            <?php } ?>
        <?php endif;

        unset($woocommerce_loop['loading_class']);

        wp_reset_postdata();
        wc_reset_loop();

        echo $output;

		die();
    }
}

if( ! function_exists( 'etheme_fullscreen_products' ) ) {
	function etheme_fullscreen_products( $args, $slider_args = array() ) {
		global $woocommerce_loop;

		extract($slider_args);

		ob_start();

		$products = new WP_Query( $args );

		$images_slider_items = array();

		if ( $products->have_posts() ) : ?>

			<div class="et-full-screen-products <?php echo $class; ?>">
				<div class="et-products-info-slider swiper-container">
					<div class="swiper-wrapper">
						<?php while ( $products->have_posts() ) : $products->the_post(); ?>
							<div class="et-product-info-slide swiper-slide swiper-no-swiping">
								<div class="product-info-wrapper">
									<p class="product-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</p>

									<?php

										woocommerce_template_single_rating();

										woocommerce_template_single_price();

										woocommerce_template_single_excerpt();

										woocommerce_template_loop_add_to_cart();

										if( get_option('yith_wcwl_button_position') == 'shortcode' ) {
											etheme_wishlist_btn();
										}

										woocommerce_template_single_meta();

										if(etheme_get_option('share_icons')): ?>
											<div class="product-share">
												<?php echo do_shortcode('[share title="'.__('Share: ', 'xstore').'" text="'.get_the_title().'"]'); ?>
											</div>
										<?php endif;?>
								</div>
							</div>

							<?php
								$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
								$images_slider_items[] = '<div class="et-product-image-slide swiper-slide swiper-no-swiping" style="background-image: url(' . $image[0] . ');"></div>';
							?>

						<?php endwhile; // end of the loop. ?>
					</div>
				</div>
				<div class="et-products-images-slider swiper-container">
					<div class="swiper-wrapper">
						<?php echo implode( '', array_reverse( $images_slider_items) ); ?>
					</div>
					<div class="et-products-navigation">
						<div class="et-swiper-next">
							<span class="swiper-nav-title"></span>
							<span class="swiper-nav-price"></span>
							<span class="swiper-nav-arrow et-icon et-up-arrow"></span>
						</div>
						<div class="et-swiper-prev">
							<span class="swiper-nav-arrow et-icon et-down-arrow"></span>
							<span class="swiper-nav-title"></span>
							<span class="swiper-nav-price"></span>
						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					var slidesCount = $('.et-product-info-slide').length;

					var infoSwiper = new Swiper('.et-products-info-slider', {
						paginationClickable: true,
						direction: 'vertical',
						slidesPerView: 1,
						initialSlide: slidesCount,
						simulateTouch: false,
						noSwiping: true,
						loop: true,
						onInit: function(swiper) {
							updateNavigation();
						}
					});

					var imagesSwiper = new Swiper('.et-products-images-slider', {
						paginationClickable: true,
						direction: 'vertical',
						slidesPerView: 1,
						loop: true,
						simulateTouch: false,
						noSwiping: true,
						prevButton: '.et-products-navigation .et-swiper-prev',
						nextButton: '.et-products-navigation .et-swiper-next',
						onSlideNextStart: function(swiper) {
							infoSwiper.slidePrev();
							updateNavigation();
						},
						onSlidePrevStart: function(swiper) {
							infoSwiper.slideNext();
							updateNavigation();
						}
					});

					function updateNavigation() {
						var $nextBtn = $('.et-products-navigation .et-swiper-next'),
							$prevBtn = $('.et-products-navigation .et-swiper-prev'),
							currentIndex = $('.et-product-info-slide.swiper-slide-active').data('swiper-slide-index'),
							prevIndex = ( currentIndex >= slidesCount - 1 ) ? 0 : currentIndex + 1,
							nextIndex = ( currentIndex <= 0 ) ? slidesCount - 1 : currentIndex - 1,
							$nextProduct = $('.et-product-info-slide[data-swiper-slide-index="' + nextIndex + '"]'),
							nextTitle = $nextProduct.find('.product-title a').first().text(),
							nextPrice = $nextProduct.find('.price').html(),
							$prevProduct = $('.et-product-info-slide[data-swiper-slide-index="' + prevIndex + '"]'),
							prevTitle = $prevProduct.find('.product-title a').first().text(),
							prevPrice = $prevProduct.find('.price').html();

						$nextBtn.find('.swiper-nav-title').text(nextTitle);
						$nextBtn.find('.swiper-nav-price').html(nextPrice);

						$prevBtn.find('.swiper-nav-title').text(prevTitle);
						$prevBtn.find('.swiper-nav-price').html(prevPrice);
					}
				});
			</script>

		<?php endif;
		wp_reset_postdata();
		return ob_get_clean();
	}
}

// **********************************************************************//
// ! Site breadcrumbs
// **********************************************************************//
if(!function_exists('etheme_breadcrumbs')) {
    function etheme_breadcrumbs() {
        global $post;

		if( function_exists( 'is_bbpress' ) && is_bbpress() ) {
			bbp_breadcrumb();
			return;
		}

        $args = array(
            'delimiter'   => '<span class="delimeter"><i class="et-icon et-right-arrow"></i></span>',
            'home'        => esc_html__( 'Home', 'xstore' ),
            'showCurrent' => 0,
            'before'      => '<span class="current">',
            'after'       => '</span>',
        );

        $post_page    = get_option( 'page_for_posts' );
        $title_at_end = '<a href="' . get_permalink( $post_page ) . '">' . esc_html__( 'Blog', 'xstore' ) . '</a>';
        $homeLink     = home_url();
        $title        = '';
        $html         = '';

        if( is_home() ) {
            if( empty( $post_page ) && ! is_single() && ! is_page() ) $title = esc_html__( 'Blog', 'xstore' );
            $title = get_the_title( $post_page );
        }

        if ( is_front_page() ) {
            $title = '';
        } else if ( class_exists( 'bbPress' ) && is_bbpress() ) {
            $title    = esc_html__( 'Forums', 'xstore' );
            $bbp_args = array(
                'before' => '<div class="breadcrumbs" id="breadcrumb">',
                'after'  => '</div>'
            );
            bbp_breadcrumb($bbp_args);
        } else {
            $html .= '<div class="breadcrumbs">';
            $html .= '<div id="breadcrumb">';
            $html .= '<a href="' . $homeLink . '">' . $args['home'] . '</a> ' . $args['delimiter'] . ' ';

            if ( is_category() ) {
                $title        = esc_html__( 'Category: ', 'xstore' ) . single_cat_title( '', false );
                $title_at_end = '';
            	$thisCat      = get_category( get_query_var( 'cat' ), false );
                $cat_id       = get_cat_ID( single_cat_title( '', false ) );

                if ( $thisCat->parent != 0 ){
                    $html .= get_category_parents( $thisCat->parent, true, ' ' . $args['delimiter'] . ' ' );
                }

                $html .= sprintf( 
                    '<a class="current" href="%s">%s%s "%s"%s</a>',
                    get_category_link( $cat_id ),
                    $args['before'],
                    esc_html__( 'Archive by category', 'xstore' ),
                    single_cat_title( '', false ),
                    $args['after']
                );
            } elseif ( is_search() ) {
                $title = esc_html__( 'Search Results for: ', 'xstore' ) . get_search_query();
            } elseif ( is_day() ) {
                $title        = esc_html__( 'Daily Archives: ', 'xstore' ) . get_the_date();
            	$title_at_end = '';

                $html .= sprintf( 
                    '<a href="%s">%s</a> %s',
                    get_year_link( get_the_time( 'Y' ) ),
                    get_the_time( 'Y' ),
                    $args['delimiter']
                );
                $html .= sprintf( 
                    '<a href="%s">%s</a> %s',
                    get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
                    get_the_time( 'F' ),
                    $args['delimiter']
                );
                $html .= sprintf( 
                    '<a class="current" href="%s">%s%s%s</a>',
                    get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'j' ) ),
                    $args['before'],
                    get_the_time( 'd' ),
                    $args['after']
                );
            } elseif ( is_month() ) {
                $title        = esc_html__( 'Monthly Archives: ', 'xstore') . get_the_date( _x( 'F Y', 'monthly archives date format', 'xstore' ) );
        		$title_at_end = '';

                $html .= sprintf( 
                    '<a href="%s">%s</a> %s',
                    get_year_link( get_the_time( 'Y' ) ),
                    get_the_time( 'Y' ),
                    $args['delimiter']
                );
                $html .= sprintf( 
                    '<a class="current" href="%s">%s%s%s</a>',
                    get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
                    $args['before'],
                    get_the_time( 'F' ),
                    $args['after']
                );
            } elseif ( is_year() ) {
                $title        = esc_html__( 'Yearly Archives: ', 'xstore' ) . get_the_date( _x( 'Y', 'yearly archives date format', 'xstore' ) );
                $title_at_end = '';

                $html .= sprintf( 
                    '<a class="current" href="%s">%s%s%s</a>',
                    get_year_link( get_the_time( 'Y' ) ),
                    $args['before'],
                    get_the_time( 'Y' ),
                    $args['after']
                );
            } elseif ( is_single() && ! is_attachment() ) {
                $title = get_the_title();
                if ( get_post_type() == 'etheme_portfolio' ) {
                    $portfolioId   = etheme_get_option( 'portfolio_page' );
                    $portfolioLink = get_permalink( $portfolioId );
                    $post_type     = get_post_type_object( get_post_type() );
                    $page          = get_page( $portfolioId );
                    $slug          = $post_type->rewrite;
                    $title_at_end  = $page->post_title;

                    $html .= '<a href="' . $portfolioLink . '">' . $title_at_end . '</a>';
                    $title_at_end = '<a href="' . $portfolioLink . '">' . $title_at_end . '</a>';

                    if ( $args['showCurrent'] == 1 ){
                        $html .= ' ' . $args['delimiter'] . ' ' . $args['before'] . get_the_title() . $args['after'];
                    }
                } elseif ( get_post_type() != 'post' ) {
                    $post_type    = get_post_type_object( get_post_type() );
                    $slug         = $post_type->rewrite;
             	    $title_at_end = $post_type->labels->singular_name;
                    $title_at_end = '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $title_at_end . '</a>';

                    $html .= '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $title_at_end . '</a>';
                    if ( $args['showCurrent'] == 1 ){
                        $html .= ' ' . $args['delimiter'] . ' ' . $args['before'] . get_the_title() . $args['after'];
                    } 
                } else {
                    $cat = get_the_category();
                    if( isset( $cat[0] ) ) {
        	            $cat  = $cat[0];
        	            $cats = get_category_parents($cat, TRUE, ' ' . $args['delimiter'] . ' ');

        	            if ( $args['showCurrent'] == 0 ) {
                            $cats = $title_at_end = preg_replace("#^(.+)\s" . $args['delimiter'] . "\s$#", "$1", $cats);
                        }
        	            $html .= $cats;
                    }
                    if ( $args['showCurrent'] == 1 ) {
                        $html .= $args['before'] . get_the_title() . $args['after'];
                    } 
                }
            } elseif ( is_tax('portfolio_category') ) {
                $title         = single_term_title( '', false );
            	$portfolioId   = etheme_get_option( 'portfolio_page' );
            	$post          = get_page( $portfolioId );
            	$portfolioLink = get_permalink($portfolioId);
            	$title_at_end  = $post->post_title;

            	$html .= '<a href="' . $portfolioLink . '">' . $title_at_end . '</a>' . $args['delimiter'];
            	$title_at_end = '<a href="' . $portfolioLink . '">' . $title_at_end . '</a>' . $args['delimiter'];
    		} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
                $post_type    = get_post_type_object( get_post_type() );
                $title_at_end = $post_type->labels->singular_name;

                $html .= $args['before'] . $title_at_end . $args['after'];
            } elseif ( is_attachment() ) {
                $parent = get_post( $post->post_parent );
                $title  = get_the_title();

                if ( $args['showCurrent'] == 1 ) {
                    $title_at_end = get_the_title();
                    $html .= ' '  . $args['before'] . $title_at_end . $args['after'];
                }
            } elseif ( is_page() && ! $post->post_parent ) {
                $title = get_the_title();

                if ( $args['showCurrent'] == 1 ) {
                    $title_at_end = get_the_title();
                    $html .= $args['before'] . $title_at_end . $args['after'];
                }
            } elseif ( is_page() && $post->post_parent ) {
                $title       = get_the_title();
                $parent_id   = $post->post_parent;
                $breadcrumbs = array();

                while ( $parent_id ) {
                    $page          = get_page( $parent_id );
                    $breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>' . $args['delimiter'];
                    $parent_id     = $page->post_parent;
                }
                $breadcrumbs = array_reverse( $breadcrumbs) ;

                for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
                    $html .= $breadcrumbs[$i];
                    if ( $i != count( $breadcrumbs ) -1 ) $html .= ' ' . $args['delimiter'] . ' ';
                }
                if  ($args['showCurrent'] == 1 ) $html .= ' ' . $args['delimiter'] . ' ' . $args['before'] . get_the_title() . $args['after'];
            } elseif ( is_tag() ) {
                $title        = esc_html__( 'Tag: ', 'xstore' ) . single_tag_title( '', false );
                $title_at_end = single_tag_title( '', false );

                $html .= $args['before'] . 'Posts tagged "' . $title_at_end . '"' . $args['after'];
            } elseif ( is_author() ) {
                global $author;

                $title        = esc_html__( 'All posts by ', 'xstore' ) . get_the_author();
                $userdata     = get_userdata($author);
                $title_at_end = $userdata->display_name;

                $html .= $args['before'] . 'Articles posted by ' . $args['after'] . get_the_author_posts_link();
            } elseif ( is_404() ) {
                $title = esc_html__( 'Page not found', 'xstore' );
                $html .= $args['before'] . 'Error 404' . $args['after'];
            } elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
                $title = esc_html__( 'Asides', 'xstore' );
            } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
                $title = esc_html__( 'Videos', 'xstore' );
            } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
                $title = esc_html__( 'Audio', 'xstore' );
            } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
                $title = esc_html__( 'Quotes', 'xstore' );
            } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
                $title = esc_html__( 'Galleries', 'xstore' );
            } elseif( is_archive() ) {
                $title = esc_html__( 'Archives', 'xstore' );  
            }

            if ( get_query_var( 'paged' ) ) {
                $title = esc_html__( 'Page', 'xstore' ) . ' ' . get_query_var( 'paged' );
        		$html .= ( ! empty( $title_at_end ) ) ? $title_at_end . ' ' . $args['delimiter'] : '';
        	}

            $html .= '</div>';
                if( etheme_get_option('return_to_previous') ) $html .= etheme_back_to_page();
            $html .= '</div>';

            $html .= ' <h1 class="title"><span>' . $title . '</span></h1>';

            do_action( 'etheme_before_breadcrumbs' );
            echo $html;
            do_action( 'etheme_after_breadcrumbs' );

        }
    }
}

if(!function_exists('etheme_back_to_page')) {
    function etheme_back_to_page() {
        echo '<a class="back-history" href="javascript: history.go(-1)">' . esc_html__( 'Return to previous page', 'xstore' ) . '</a>';
    }
}


// **********************************************************************//
// ! Back to top button
// **********************************************************************//
if(!function_exists('etheme_btt_button')) {
	function etheme_btt_button() {
		if (etheme_get_option('to_top')): ?>
			<div id="back-top" class="back-top <?php if(!etheme_get_option('to_top_mobile')): ?>visible-lg<?php endif; ?> backOut">
				<a href="#top">
					<span class="et-icon et-up-arrow"></span>
				</a>
			</div>
		<?php endif;
	}
}

add_action('after_page_wrapper', 'etheme_btt_button');


// **********************************************************************//
// ! Promo Popup
// **********************************************************************//
add_action('after_page_wrapper', 'etheme_promo_popup');
if(!function_exists('etheme_promo_popup')) {
    function etheme_promo_popup() {
        if(!etheme_get_option('promo_popup')) return;
        $bg = etheme_get_option('pp_bg');
        $padding = etheme_get_option('pp_padding');
        if( ! empty( $bg['background-color'] ) ){
			$bg['color-start'] = et_hex_to_rgba( $bg['background-color'], 0 );
			$bg['color-end'] = et_hex_to_rgba( $bg['background-color'], 1 );
		} else {
			$bg['color-start'] = 'rgba(255,255,255,0)';
			$bg['color-end'] = 'rgba(255,255,255,1)';
		}
        ?>	
    	<div id="etheme-popup-wrapper" class="white-popup-block mfp-hide mfp-with-anim zoom-anim-dialog  etheme-popup-wrapper">
            <div id="etheme-popup-holder" class="etheme-newsletter-popup" <?php if (etheme_get_option('promo_auto_open') && etheme_get_option('pp_delay')) { echo ' data-delay="'.etheme_get_option('pp_delay').'"';} ?>>
        		<button title="Close (Esc)" type="button" class="mfp-close">×</button>
	            <div id="etheme-popup">
	                <?php echo do_shortcode(etheme_get_option('pp_content')); ?>
	            </div>
            </div>
       </div>
            <style type="text/css">
            	#etheme-popup-holder:after {
            		content: '';
            		height: 60px;
            		position: absolute;
            		bottom: 0;
            		left: 50%;
            		transform: translateX(-50%);
            		width: <?php echo (etheme_get_option('pp_width') != '') ? etheme_get_option('pp_width') - 90 : 700 - 90 ; ?>px;
            		<?php if(!empty($bg['background-color']) && $bg['background-color'] != 'transparent'): ?>
					background: -moz-linear-gradient(top, <?php echo esc_attr($bg['color-start']); ?> 0%, <?php echo esc_attr($bg['color-end']); ?> 80%);
				    background: -webkit-linear-gradient(top, <?php echo esc_attr($bg['color-start']); ?> 0%, <?php echo esc_attr($bg['color-end']); ?> 80%);
				    background: linear-gradient(to bottom, <?php echo esc_attr($bg['color-start']); ?> 0%, <?php echo esc_attr($bg['color-end']); ?> 80%);
				    <?php endif; ?>
            	}
                #etheme-popup {
                    width: <?php echo (etheme_get_option('pp_width') != '') ? etheme_get_option('pp_width') : 700 ; ?>px;
                    height: <?php echo (etheme_get_option('pp_height') != '') ? etheme_get_option('pp_height') : 350 ; ?>px;
                    <?php if(!empty($bg['background-color'])): ?>  background-color: <?php echo esc_attr($bg['background-color']); ?>;<?php endif; ?>
                    <?php if(!empty($bg['background-image'])): ?>  background-image: url(<?php echo esc_url($bg['background-image']); ?>) ; <?php endif; ?>
                    <?php if(!empty($bg['background-attachment'])): ?>  background-attachment: <?php echo esc_attr($bg['background-attachment']); ?>;<?php endif; ?>
                    <?php if(!empty($bg['background-repeat'])): ?>  background-repeat: <?php echo esc_attr($bg['background-repeat']); ?>;<?php  endif; ?>
                    <?php if(!empty($bg['background-position'])): ?>  background-position: <?php echo esc_attr($bg['background-position']); ?>;<?php endif; ?>
                }
            </style>
        <?php
    }
}

// **********************************************************************//
// ! QR Code generation
// **********************************************************************//
if(!function_exists('etheme_qr_code')) {
    function etheme_qr_code($text='QR Code', $title = 'QR Code', $size = 128, $class = '', $self_link = false, $lightbox = false ) {
        if( $self_link ) {
            $text = etheme_http();
            if ( $_SERVER['SERVER_PORT'] != '80' ) {
                $text .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
            } else {
                $text .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            }
        }
        $image = 'https://chart.googleapis.com/chart?chs=' . $size . 'x' . $size . '&cht=qr&chld=H|1&chl=' . $text;

        if( $lightbox ) {
            $class .= ' qr-lighbox';
            $output = '<a href="'.$image.'" rel="lightbox" class="'.$class.'"><img src="'.$image.'" /></a>';
        } else{
            $class .= ' qr-image';
            $output = '<img src="'.$image.'"  class="'.$class.'" />';
        }

        return $output;
    }
}

// **********************************************************************//
// ! Show secondary menu 
// **********************************************************************//

if ( ! function_exists('et_show_secondary_menu') ) {
	function et_show_secondary_menu () {
		if ( has_nav_menu( 'secondary' ) && etheme_get_option( 'secondary_menu' ) ): ?>
            <div class="secondary-menu-wrapper">
                <div class="secondary-title">
                    <div class="secondary-menu-toggle">
                        <span class="et-icon et-burger"></span>
                    </div>
                    <?php etheme_option('all_departments_text'); ?>
                </div>
                <?php etheme_menu( 'secondary', 'secondary' ); ?>
            </div>
       <?php endif;
	}
}

// **********************************************************************//
// ! Show shop navbar
// **********************************************************************//
if( ! function_exists( 'etheme_shop_navbar' ) ) {
    function etheme_shop_navbar( $location = 'header', $exclude = array() ) {
		ob_start();
			if ( ! in_array( 'account', $exclude ) && etheme_get_option( 'top_links' ) == $location ) {
				etheme_sign_link( '','', true );
			}
			if ( ! in_array( 'search', $exclude ) && etheme_get_option( 'search_form' ) == $location ) {
				etheme_search_form();
			}
			if ( ! in_array( 'wishlist', $exclude ) && etheme_woocommerce_installed() && etheme_get_option( 'top_wishlist_widget' ) == $location ) {
				etheme_wishlist_widget();
			}
			if ( ! in_array( 'cart', $exclude ) && etheme_woocommerce_installed() && ! etheme_get_option( 'just_catalog' ) && etheme_get_option( 'cart_widget' ) == $location ) {
				etheme_top_cart();
			}
		$html = ob_get_clean();

		if ( !empty($html) ) {

			do_action( 'etheme_before_shop_navbar' );
			echo '<div class="navbar-header show-in-' . $location . '">' . $html . '</div>';
			do_action( 'etheme_after_shop_navbar' );
    	
    	}
    }
}

if( ! function_exists( 'etheme_primary_category' ) ) {
    function etheme_primary_category( $echo = false ) {
        $primary = false;
        $cat = etheme_get_custom_field('primary_category');
        if(!empty($cat) && $cat != 'auto') {
            $primary = get_term_by( 'slug', $cat, 'category' );
        } else {
            $cats = wp_get_post_categories(get_the_ID());
            if( isset($cats[0]) ) {
                $primary = get_term_by( 'id', $cats[0], 'category' );
            }
        }
        if( $primary ) {
            $term_link = get_term_link( $primary );
            $out = '<div class="post-categories"><a href="' . esc_url( $term_link ) . '">' . $primary->name . '</a></div>';
            if ( $echo ) {
                echo $out;
            } else {
                return $out;
            }
        }
    }
}

// **********************************************************************// 
// ! Bordered layout
// **********************************************************************//
if(!function_exists('etheme_bordered_layout')) {
    function etheme_bordered_layout() {

        if(etheme_get_option('main_layout') != 'bordered') return;

        ?>
            <div class="body-border-left"></div>
            <div class="body-border-top"></div>
            <div class="body-border-right"></div>
            <div class="body-border-bottom"></div>
        <?php
    }
    add_action('et_after_body', 'etheme_bordered_layout');
}

// **********************************************************************// 
// ! Hook photoswipe tempalate to the footer
// **********************************************************************// 
add_action('after_page_wrapper', 'etheme_photoswipe_template', 30);
if( ! function_exists( 'etheme_photoswipe_template' ) ) {
    function etheme_photoswipe_template() {
        if ( class_exists( 'WooCommerce' ) && is_product() ) : ?>
            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="pswp__bg"></div>
                <div class="pswp__scroll-wrap">
                    <div class="pswp__container">
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                    </div>
                    <div class="pswp__ui pswp__ui--hidden">
                        <div class="pswp__top-bar">
                            <div class="pswp__counter"></div>
                            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                            <div class="pswp__preloader">
                                <div class="pswp__preloader__icn">
                                  <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut"></div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                            <div class="pswp__share-tooltip"></div>
                        </div>
                        <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                        <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                        <div class="pswp__caption">
                            <div class="pswp__caption__center"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;
    }
}

// **********************************************************************//
// ! WC Marketplace fix
// **********************************************************************//
if ( class_exists( 'WCMp_Ajax' ) ) add_action( 'wp_head', 'single_product_multiple_vendor_class' );
if ( ! function_exists( 'single_product_multiple_vendor_class' ) ) :
   function single_product_multiple_vendor_class(){
        ?>
        <script type="text/javascript">
            var themeSingleProductMultivendor = '#content_tab_singleproductmultivendor';
        </script>
        <?php
    }
endif;


if( ! function_exists( 'etheme_the_post_field' ) ) {
	function etheme_the_post_field( $field = false ){
		if ( ! $field ) return;

		$data = etheme_get_custom_field( 'post_' . $field );

		if ( empty( $data ) ) return;

		$out = '';

		switch ( $field ) {
			case 'video':
				$embed =  VideoUrlParser::get_url_embed( $data );
				if( ! empty( $embed ) ){
					$out .= '
						<div class="featured-' . $field . '">
							<iframe width="100%" height="560" src="' . $embed . '" frameborder="0" allowfullscreen></iframe>
						</div>
					';
				} 
				break;
			case 'audio':
				$out .= '<div class="featured-' . $field . '">' . do_shortcode( $data ) . '</div>';
				break;
			case 'quote':
				$out .= do_shortcode( $data );
				break;
			default:
				return;
				break;
		}
		echo $out;
	}
}

// **********************************************************************//
// ! etheme slider
// **********************************************************************//
if( ! function_exists( 'etheme_slider' ) ) {
	function etheme_slider( $args, $type = 'post', $atts = array() ) {
	    // ! Slider args
	    $slider_atts = array(
	        'title'              => false,
	        'before'             => '',
	        'after'              => '',
	        'class'              => '',
	        'attr'               => '',
	        'echo'               => false,
	        'large'              => 4,
	        'notebook'           => 4,
	        'tablet_land'        => 3,
	        'tablet_portrait'    => 2,
	        'mobile'             => 2,
	        'slider_autoplay'    => 'no',
	        'slider_speed'       => 300,
	        'slider_interval'    => 1000,
	        'slider_loop'        => false,
	        'autoheight'         => true,
	        'pagination_type'    => 'hide',
	        'default_color'      => '#e6e6e6',
	        'active_color'       => '#b3a089',
	        'hide_fo'            => '',
	        'hide_buttons'       => false,
	        'size'               => 'shop_catalog',
	        'per_move'           => 1,
	        // ! blog args
	        'slide_view'         => '',
	        'blog_align'         => '',
	        // ! Products args 
	        'block_id'           => false,
	        'style'              => 'default',
	        'product_view'       => '',
	        'product_view_color' => '',
	        'no_spacing'         => '',
	        'shop_link'          => false,
	        'slider_type'        => false,
	        'from_first'         => '',
	        'widget'             => false
	    );

	    extract( shortcode_atts( $slider_atts, $atts ) );

	    $box_id      = rand( 1000, 10000 );
	    $multislides = new WP_Query( $args );
	    $loop = $slide_class = $html = '';

	    if ( $type == 'post' ) {
	        global $et_loop;
	        $et_loop['slider']      = true;
	        $et_loop['blog_layout'] = 'default';
	        $et_loop['size']        = $size;
	        $et_loop['slide_view']  = $slide_view;
	        $et_loop['blog_align']  = $blog_align;
	        $class .= ' posts-slider';
	    } else {
	        if( ! class_exists( 'Woocommerce' ) ) return;
	        global $woocommerce_loop;
	        $woocommerce_loop['size'] = $size;

	        if( ! $slider_type ) {
	            $woocommerce_loop['lazy-load'] = true;
	            $woocommerce_loop['style'] = $style;
	        }

	        $block = '';
	        $class .= ' products-slider';
	        $slide_class .= ' slide-item product-slide ';
	        $slide_class .= $slider_type . '-slide';

	        if( $no_spacing == 'yes' ) $slide_class .= ' item-no-space';

	        if( $block_id && $block_id != '' && etheme_static_block( $block_id, false ) != '' ) {
	            ob_start();
	                echo '<div class="slide-item '.$slider_type.'-slide">';
	                    etheme_static_block($block_id, true);
	                echo '</div><!-- slide-item -->';
	            $block = ob_get_contents();
	            ob_end_clean();
	        }
	    }

	    if ( $multislides->have_posts() ) {
	        $autoheight = ( $autoheight ) ? 'data-autoheight="1"' : '';
	        $lines = ( $pagination_type == 'lines' ) ? 'swiper-pagination-lines' : '';
	        $slider_speed = ( $slider_speed ) ? 'data-speed="' . $slider_speed . '"' : '';
	        
	        if ( $slider_autoplay ) $slider_autoplay = $slider_interval;
	        if ( $autoheight ) $autoheight = 'data-autoheight="1"';
	        if ( $slider_loop ) $loop = ' data-loop="true"';
	       
	        $html .= '<div class="swiper-entry">';
	            $html .= $before;

	            $html .= ( $title ) ? '<h3 class="title"><span>' . $title . '</span></h3>' : '';

	            $html .='
	                <div
	                    class="swiper-container carousel-area ' . $class . ' slider-' . $box_id . ' ' . $lines . '"
	                    data-breakpoints="1"
	                    data-xs-slides="' . esc_js( $mobile ) . '"
	                    data-sm-slides="' . esc_js( $tablet_land ) . '"
	                    data-md-slides="' . esc_js( $notebook ) . '"
	                    data-lt-slides="' . esc_js( $large ) . '"
	                    data-slides-per-view="' . esc_js( $large ) . '"
	                    ' . $autoheight . '
	                    data-slides-per-group="' . esc_attr( $per_move ). '"
	                    data-autoplay="' . esc_attr( $slider_autoplay ) . '"
	                    ' . $slider_speed . ' ' . $loop . ' ' . $attr . '
	                >
	            ';

	                $html .= '<div class="swiper-wrapper">';
	                    $_i=0;

	                    while ( $multislides->have_posts() ) : $multislides->the_post();
	                        $_i++;
	                        ob_start();

	                        if ( $type == 'product' ) {
	                            global $product;

	                            if( ( $from_first == 'no' && $_i ==  2) || ( $from_first != 'no' && $_i == 1 ) ) {
	                                echo $block;
	                            }
	                            
	                            if ( ! $product->is_visible() ) continue;

	                            if ( $widget ) {
	                                wc_get_template_part( 'content', 'widget-product-slider' );
	                            } else {
	                                echo '<div class="swiper-slide' . esc_attr( $slide_class ) . '">';
	                                    wc_get_template_part( 'content', 'product-slider' );
	                                echo '</div>';
	                            }
	 
	                        } else {
	                            echo '<div class="swiper-slide' . esc_attr( $slide_class ) . '">';
	                                get_template_part( 'content', 'grid' );
	                            echo '</div>';
	                        }

	                        $html .= ob_get_clean();
	                    endwhile;
	                $html .= '</div><!-- slider wrapper-->';

	                if ( $pagination_type != 'hide' ) {
	                    $html .= '
	                    <div class="swiper-pagination etheme-css"
	                        data-css="
	                            .slider-'.$box_id.' .swiper-pagination-bullet{background-color:'.$default_color.'; '. $lines.';}
	                            .slider-'.$box_id.' .swiper-pagination-bullet:hover{ background-color:'.$active_color.'; }
	                            .slider-'.$box_id.' .swiper-pagination-bullet-active{ background-color:'.$active_color.'; }
	                        "
	                    >
	                    </div>';
	                }
	            $html .= '</div><!-- slider container-->';

	            if ( ! $hide_buttons ) {
	                $html .= '
	                    <div class="swiper-button-prev swiper-custom-left"></div>
	                    <div class="swiper-button-next swiper-custom-right"></div>
	                ';
	            }

	            $html .= $after;
	        $html .= '</div><div class="clear"></div><!-- slider-entry -->';
	    };

	    if ( $type == 'post' ) {
	        unset( $et_loop );
	        wp_reset_postdata();
	    } else {
	        wp_reset_query();
	        unset( $woocommerce_loop['lazy-load'] );
	        unset( $woocommerce_loop['style'] );
	    }


	    if ( $echo ) {
	        echo $html;
	    } else {
	        return $html;
	    }
	}
}