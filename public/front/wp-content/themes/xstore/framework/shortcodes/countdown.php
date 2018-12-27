<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************//
// ! Countdown
// **********************************************************************//

if( ! function_exists( 'etheme_countdown_shortcode' ) ) {
    function etheme_countdown_shortcode($atts) {
        $a = shortcode_atts(array(
            'year' => 2017,
            'month' => 'January',
            'day' => 1,
            'hour' => 00,
            'minute' => 00,
            'start_year' => date('Y'),
            'start_month' => date('M'),
            'start_day' => date('d'),
            'start_hour' => date('g'),
            'start_minute' => date('i'),
            'type' => 'type1',
            'scheme' => 'white',
            'class' => '',
        ),$atts);

        $date_final = '';

        $date_final .= $a['day'] . ' ';
        $date_final .= $a['month'] . ' ';
        $date_final .= $a['year'] . ' ';
        $date_final .= $a['hour'] . ':';
        $date_final .= $a['minute'] . ' ';

        $data_start = '';

        $data_start .= $a['start_day'] . ' ';
        $data_start .= $a['start_month'] . ' ';
        $data_start .= $a['start_year'] . ' ';
        $data_start .= $a['start_hour'] . ':';
        $data_start .= $a['start_minute'] . ' ';

        $class = ' ' . $a['scheme'] . ' ' . $a['type'];

        if (!empty($a['class'])) {
            $class .= ' ' . $a['class'];
        }

         return '<div class="et-timer'.$class.'" data-final="'.$date_final.'" data-start="'.$data_start.'">
         <div class="timer-info"></div>
            <div class="time-block">
                <div class="circle-box">
                    <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 100 100" version="1.1" height="100%" width="100%">
                        <circle r="47" cx="50" cy="50" fill="transparent" stroke-dasharray="295.3097094374406" stroke-dashoffset="0" data-max-val="365" style="stroke-dashoffset: 0px;"></circle>
                    </svg>
                </div>
                <span class="days timer-count">0</span>
                <span>' . __( 'days', 'xstore' ) . '</span>
            </div>
            <div class="time-block">
                <div class="circle-box">
                    <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 100 100" version="1.1" height="100%" width="100%">
                        <circle r="47" cx="50" cy="50" fill="transparent" stroke-dasharray="295.3097094374406" stroke-dashoffset="0" data-max-val="24" style="stroke-dashoffset: 0px;"></circle>
                    </svg>
                </div>
                <span class="hours timer-count">0</span>
                <span>' . __( 'hours', 'xstore' ) . '</span>
            </div>
            <div class="time-block">
                <div class="circle-box">
                    <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 100 100" version="1.1" height="100%" width="100%">
                        <circle r="47" cx="50" cy="50" fill="transparent" stroke-dasharray="295.3097094374406" stroke-dashoffset="0" data-max-val="60" style="stroke-dashoffset: 0px;"></circle>
                    </svg>
                </div>
                <span class="minutes timer-count">0</span>
                <span>' . __( 'mins', 'xstore' ) . '</span>
            </div>
            <div class="time-block">
                <div class="circle-box">
                    <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 100 100" version="1.1" height="100%" width="100%">
                        <circle r="47" cx="50" cy="50" fill="transparent" stroke-dasharray="295.3097094374406" stroke-dashoffset="0" data-max-val="60" style="stroke-dashoffset: 0px;"></circle>
                    </svg>
                </div>
                <span class="seconds timer-count">0</span>
                <span>' . __( 'secs', 'xstore' ) . '</span>
            </div>
        </div>';
    }
}

// **********************************************************************//
// ! Register New Element: Countdown
// **********************************************************************//
add_action( 'init', 'etheme_register_countdown');
if(!function_exists('etheme_register_countdown')) {
    function etheme_register_countdown() {
        if(!function_exists('vc_map')) return;
        $countdown_params = array(
            'name' => 'Countdown',
            'base' => 'countdown',
            'icon' => ETHEME_CODE_IMAGES . 'vc/el-counter.png',
            'category' => 'Eight Theme',
            'params' => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Year", 'xstore'),
                    "param_name" => "year"
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Month", 'xstore'),
                    "param_name" => "month",
                    "value" => array(
                        __("January", 'xstore') => 'January',
                        __("February", 'xstore') => 'February',
                        __("March", 'xstore') => 'March',
                        __("April", 'xstore') => 'April',
                        __("May", 'xstore') => 'May',
                        __("June", 'xstore') => 'June',
                        __("July", 'xstore') => 'July',
                        __("August", 'xstore') => 'August',
                        __("September", 'xstore') => 'September',
                        __("October", 'xstore') => 'October',
                        __("November", 'xstore') => 'November',
                        __("December", 'xstore') => 'December',
                    )
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Day", 'xstore'),
                    "param_name" => "day"
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Hour", 'xstore'),
                    "param_name" => "hour"
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Minutes", 'xstore'),
                    "param_name" => "minute"
                ),
                array(
                     "type" => "dropdown",
                    "heading" => __("Display type", 'xstore'),
                    "param_name" => 'type',
                    "value" => array (
                        __("Circle", 'xstore') => 'type1',
                        __("Simple", 'xstore') => 'type2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Color scheme", 'xstore'),
                    "param_name" => "scheme",
                    "value" => array(
                        __("Light", 'xstore') => "white",
                        __("Dark", 'xstore') => "dark",
                    )
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Extra Class", 'xstore'),
                    "param_name" => "class",
                    "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'xstore')
                )
            )

        );

        vc_map($countdown_params);

    }
}