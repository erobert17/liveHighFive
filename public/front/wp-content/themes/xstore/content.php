<?php
global $et_loop;

$post_format    = get_post_format();
$layout         = etheme_get_option('blog_layout');

if( ! empty( $et_loop['blog_layout'] ) ) {
    $layout = $et_loop['blog_layout'];
}

$excerpt_length = etheme_get_option('excerpt_length');

$postClass      = etheme_post_class( $layout );
$size           = etheme_get_option( 'blog_images_size' );

if( ! empty( $et_loop['size'] ) ) {
    $size = $et_loop['size'];
}

?>

<article <?php post_class($postClass); ?> id="post-<?php the_ID(); ?>" >
    <div>

        <?php if ( $layout != 'with-author'): ?>
            <?php etheme_post_thumb( array( 'size' => $size ) ); ?>
        <?php endif ?>
    
        <div class="post-data">
            <div class="post-heading">
                <?php
                    if ( is_sticky() && is_home() && ! is_paged() && $layout != 'with-author' ) {
                        printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'xstore' ) );
                    }
                ?>
                <?php if( $layout == 'with-author' ): //etheme_get_option('about_author') && $layout == 'title-left' ||  ?>
                    <div class="author-info">
                        <?php echo get_avatar( get_the_author_meta('email') , 40 ); ?>
                        <?php the_author_link(); ?>
                    </div>
                <?php endif; ?>
                <div class="post-heading-inner">
                    <?php 
                        if ( is_sticky() && is_home() && ! is_paged() && $layout == 'with-author' ) {
                            printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'xstore' ) );
                        }
                    ?>
                    <?php if ( $layout != 'with-author' ): ?>
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                    <?php endif ?>
                    <?php
                    $author = 1;
                    $time = 0;
                    if($layout == 'small' || $layout == 'title-left') $author = 0;
                    if($layout == 'title-left') $time = 1;
                    etheme_byline( array( 'author' => $author, 'time' => $time ) );
                    ?>
                    <?php if ( $layout == 'with-author' ): ?>
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                    <?php endif ?>
                </div>
            </div>

            <?php if ( $layout == 'with-author'): ?>
                <?php etheme_post_thumb( array( 'size' => $size ) ); ?>
            <?php endif ?>

            <div class="content-article entry-content">
                <?php if ( $excerpt_length > 0 ) the_excerpt();  ?>
                <?php etheme_read_more( get_the_permalink(), true ) ?>
            </div>

            <?php if(etheme_get_option('about_author') && $layout != 'title-left' ): ?>
                <div class="author-info">
                    <?php echo get_avatar( get_the_author_meta('email') , 40 ); ?>
                    <?php the_author_link(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if($layout == 'timeline' || $layout == 'timeline2' ): ?>

        <?php if ( $layout == 'timeline2' || $layout == 'timeline' ): ?>
            <div class="timeline-content">
        <?php endif; ?>
        <div class="meta-post-timeline">
            <span class="time-day"><?php the_time('d'); ?></span>
            <span class="time-mon"><?php the_time('M'); ?></span>
        </div>
        <?php if ( $layout == 'timeline2' || $layout == 'timeline' ): ?>
            </div><!-- .timeline-content -->
        <?php endif; ?>
    <?php endif; ?>
</article>











