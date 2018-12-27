<?php  if ( ! defined('ABSPATH')) exit('No direct script access allowed');

// **********************************************************************// 
// ! Static block Widget
// **********************************************************************// 
class ETheme_StatickBlock_Widget extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'etheme_widget_satick_block', 'description' => esc_html__( "Insert a static block", 'xstore') );
        parent::__construct('etheme-static-block', '8theme - '.__('Static Block', 'xstore'), $widget_ops);
        $this->alt_option_name = 'etheme_widget_satick_block';
    }

    function widget($args, $instance) {
        extract($args);

        $title = empty($instance['title']) ? false : $instance['title'];
        $block_id = $instance['block_id'];

        echo $before_widget;
        
        if ( $title ) echo $before_title . $title . $after_title;

        if ( function_exists( 'etheme_static_block' ) ) {
            etheme_static_block( $block_id, true );
        }

        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['block_id'] = $new_instance['block_id'];

        return $instance;
    }

    function form( $instance ) {
        $block_id = 0;
        $title = isset($instance['title']) ? $instance['title'] : '';
        $sb    = array();
        $sb    = etheme_get_static_blocks();
        if(!empty($instance['block_id']))
            $block_id = esc_attr($instance['block_id']); 
        ?>
        <?php etheme_widget_input_text(__('Widget title:', 'xstore'), $this->get_field_id('title'),$this->get_field_name('title'), $title); ?>
        <p><label for="<?php echo $this->get_field_id('block_id'); ?>"><?php esc_html_e('Block name:', 'xstore'); ?></label>
            <select name="<?php echo $this->get_field_name('block_id'); ?>" id="<?php echo $this->get_field_id('block_id'); ?>">
                <option>--Select--</option>
                <?php if ( count( $sb ) > 0 ): ?>
                    <?php foreach ($sb as $key): ?>
                        <option value="<?php echo $key['value']; ?>" <?php selected( $block_id, $key['value'] ); ?>><?php echo $key['label'] ?></option>
                    <?php endforeach ?>
                <?php endif ?>
            </select>
        </p>
<?php
    }
}