<?php
/**
 * Shop breadcrumb
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $wp_query;

$l = etheme_page_config();
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );

if ($l['breadcrumb'] !== 'disable' && !$l['slider']):
?>
<div class="page-heading bc-type-<?php echo esc_attr( $l['breadcrumb'] ); ?> bc-effect-<?php echo esc_attr( $l['bc_effect'] ); ?> bc-color-<?php echo esc_attr( $l['bc_color'] ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12 a-center">
				
				<?php do_action('etheme_before_breadcrumbs'); ?>

				<?php if ( $breadcrumb ) : ?>

					<?php echo wp_specialchars_decode($wrap_before); ?>

					<?php foreach ( $breadcrumb as $key => $crumb ) : ?>

						<?php echo wp_specialchars_decode($before); ?>

						<?php if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) : ?>
							<?php echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>'; ?>
						<?php elseif ( ($l['breadcrumb'] == 'default' && !is_shop()) || ( (is_product_category() || is_shop()) && $current > 1) ) : ?>
							<?php echo '<span class="span-title">'.esc_html( $crumb[0] ).'</span>'; ?>
						<?php endif; ?>

						<?php echo wp_specialchars_decode($after); ?>

						<?php if ( sizeof( $breadcrumb ) !== $key + 1 ) : ?>
							<?php echo '<span class="delimeter"><i class="et-icon et-right-arrow"></i></span>'; ?>
						<?php endif; ?>

					<?php endforeach; ?>

				<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                    <?php if( etheme_get_option('product_name_signle') && is_single() && ! is_attachment() ): ?>
                    	<h1 class="title">
                        	<?php echo get_the_title(); ?>
                        </h1>
                    <?php elseif( ! is_single()): ?>
                    	<h1 class="title">
                        	<?php woocommerce_page_title(); ?>
                        </h1>
                    <?php endif; ?>
				<?php endif; ?>

				<?php echo wp_specialchars_decode($wrap_after); ?>

				<?php endif; ?>
				
				<?php if( etheme_get_option('return_to_previous') ) etheme_back_to_page(); ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<?php if($l['slider']): ?>
	<div class="page-heading-slider">
		<?php  echo do_shortcode('[rev_slider_vc alias="'.$l['slider'].'"]'); ?>
	</div>
<?php endif; ?>