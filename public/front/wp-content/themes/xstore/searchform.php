<?php
/**
 * The template for displaying search forms
 *
 */
?>
<div class="widget_search">
	<form action="<?php echo home_url( '/' ); ?>" role="searchform" class="hide-input" method="get">
		<div class="input-row">
			<input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e( 'Search...', 'xstore' ); ?>" />
			<input type="hidden" name="post_type" value="post" />
			<button type="submit" class="btn medium-btn btn-black"><i class="et-icon et-zoom"></i><?php esc_html_e( 'Search', 'xstore' ); ?></button>
		</div>
	</form>
</div>