<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Dovy Paukstys
 * @version     3.1.5
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;


// Don't duplicate me!
if( !class_exists( 'ReduxFramework_table_closer' ) ) {

    /**
     * Main ReduxFramework_dummy_content class
     *
     * @since       1.0.0
     */
    class ReduxFramework_table_closer extends ReduxFramework {
    
        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
            
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }    

            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = array(
                'options'           => array(),
                'stylesheet'        => '',
                'output'            => true,
                'enqueue'           => true,
                'enqueue_frontend'  => true,
                'columns'            => '',
                'container_title'   => '',
                'add_info' => '',
                'default' => true,
                'text' => __('Submit', 'xstore')
            );
            $this->field = wp_parse_args( $this->field, $defaults );          
        
        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {
        
            // HTML output goes here

            $out = '';

            $container_title = '';

            $out .= "<span data-id = " . $this->field['id'] . " class='et-modal-button'>". $this->field['text'] ."</span>";
            if ( !empty($this->field['container_title']) ) {
                $container_title = '<span class="container-title">' . $this->field['container_title'] . '</span>';
            }

                $out .= '</td></tr></table>';
                $out .= '<div class="et-modal-wrapper modal-closed" id="' . $this->field['id'] . '">';
                $out .= '<div class="et-modal container-flex column-width-' . $this->field['columns'] . ' "><i class="et-admin-icon et-delete et-close-modal"></i>' . $container_title . "<span class='modal-desc'><i>". $this->field['add_info'] ."</i></span>";
                echo $out;

        }
    
        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {

           // $extension = ReduxFramework_extension_dummy_content::getInstance();
        
            wp_enqueue_script(
                'redux-field-table-closer-js', 
                $this->extension_url . 'field_table_closer.js', 
                array( 'jquery' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-table-closer-css', 
                $this->extension_url . 'field_table_closer.css',
                time(),
                true
            );
        
        }
        
        /**
         * Output Function.
         *
         * Used to enqueue to the front-end
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */        
        public function output() {

            if ( $this->field['enqueue_frontend'] ) {

            }
            
        }        
        
    }
}
