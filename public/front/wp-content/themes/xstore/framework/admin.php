<?php  if ( ! defined('ETHEME_FW')) exit('No direct script access allowed');

// **********************************************************************// 
// ! Add admin styles and scripts
// **********************************************************************// 

if(!function_exists('etheme_load_admin_styles')) {
	add_action( 'admin_enqueue_scripts', 'etheme_load_admin_styles', 150 );
	function etheme_load_admin_styles() {
		global $pagenow;
		
	    wp_enqueue_style('farbtastic');
	    $depends = '';
	    if(class_exists('Redux') && $pagenow == 'admin.php' &&  isset( $_GET['page'] ) && $_GET['page'] == '_options') {
	    	$depends = array('redux-admin-css', 'select2-css');
	    	wp_dequeue_style( 'woocommerce_admin_styles' );
	    }
	    wp_enqueue_style('etheme_admin_css', ETHEME_CODE_CSS.'admin.css', $depends);
	    if ( is_rtl() ) {
	    	wp_enqueue_style('etheme_admin_rtl_css', ETHEME_CODE_CSS.'admin-rtl.css', $depends);
	    }
	    wp_enqueue_style('xstore-icons', ETHEME_CODE_CSS.'xstore-admin-icons.css');
	    wp_enqueue_style("font-awesome", get_template_directory_uri().'/css/font-awesome.min.css');
	}
}

if(!function_exists('etheme_add_admin_script')) {
	add_action('admin_init','etheme_add_admin_script', 1130);
	function etheme_add_admin_script(){
		global $pagenow;
	    add_thickbox();

		$depends = array();
		if( $pagenow == 'widgets.php' ) {
			$depends = array();
		}
	    wp_enqueue_script('theme-preview');
	    wp_enqueue_script('common');
	    wp_enqueue_script('wp-lists');
	    wp_enqueue_script('postbox');
	    wp_enqueue_script('farbtastic');
	    //wp_enqueue_script('et_masonry', get_template_directory_uri().'/js/jquery.masonry.min.js',array(),false,true);
	    wp_enqueue_script('etheme_admin_js', ETHEME_CODE_JS.'admin.js', $depends, false,true);
	}
}

// **********************************************************************// 
// ! Notice "Plugin version"
// **********************************************************************// 
add_action( 'admin_notices', 'etheme_required_core_notice', 50 );

function etheme_required_core_notice(){
	$file = ABSPATH . 'wp-content/plugins/et-core-plugin/et-core-plugin.php';

	if ( ! file_exists($file) ) return;

	$plugin = get_plugin_data( $file, false, false );

	if ( version_compare( '1.1.5', $plugin['Version'], '>' ) ) {
		echo '
		<div class="et-message et-error">
			<p>This theme version requires the following plugin <strong>8theme Core</strong> to be updated up to 1.1.5 version</p>
		</div>
	';
	}
}

// **********************************************************************// 
// ! Notice "extra notice" dismiss
// **********************************************************************// 
//add_action( 'wp_ajax_et_close_extra_notice', 'et_close_extra_notice' ); 
function et_close_extra_notice(){
	update_option( 'etheme_extra_notice_show', false );
}

// **********************************************************************// 
// ! Notice "extra notice from remote"
// **********************************************************************// 
//add_action( 'admin_notices', 'etheme_extra_notice', 50 );
function etheme_extra_notice(){
	$show = get_option( 'etheme_extra_notice_show', false );

	if ( get_transient( 'etheme_extra_notice' ) ) {
		if ( $show ) {
			echo wp_specialchars_decode(get_transient( 'etheme_extra_notice' ));
		}
		return;
	}

	$headers    = array( 'type'=>'Type', 'notice' => 'Notice' );
	$notice     = wp_remote_get( 'https://xstore.8theme.com/et-notice.txt' );
	$notice     = wp_remote_retrieve_body( $notice );
	$old_notice = get_option( 'etheme_extra_notice_data', false );

	if ( ! $show && $old_notice == $notice ) return;

	$file_data = str_replace( "\r", "\n", $notice );

	foreach ( $headers as $field => $regex ) {
		if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] ){
			$headers[ $field ] = _cleanup_header_comment( $match[1] );
		}
	}

	if ( ! in_array( $headers['type'] , array( 'success', 'info', 'error' ) ) ) {
		return;
	}

	if ( ! isset( $headers['notice'] ) || empty( $headers['notice'] ) ) return;

	$out = '
		<div class="et-extra-message et-message et-' . $headers['type'] . '">
			' . $headers['notice'] . '
			<button type="button" class="notice-dismiss close-btn"></button>
		</div>
	';

	update_option( 'etheme_extra_notice_show', true );
	update_option( 'etheme_extra_notice_data', $notice );
	set_transient( 'etheme_extra_notice', $out, DAY_IN_SECONDS*2 );

	echo wp_specialchars_decode($out);
}

if(!function_exists('etheme_support_chat')) {
	function etheme_support_chat() {
		if ( etheme_get_option( 'support_chat' ) && etheme_support_date() ) : ?>

			<?php
				$data            = get_option( 'etheme_activated_data' );
				$data            = $data['item'];
				$support_date    = strtotime( $data['supported_until'] );
				$current_date    = strtotime( date( "Y-m-d" ) );
				$remaining       = $support_date - $current_date;
				$days_remaining  = floor( $remaining / 86400 );
				$hours_remaining = floor( ( $remaining % 86400) / 3600 );
				$support_status  = ( etheme_support_date() ) ? 'ON' : 'OFF';
			?>

			<script>
				window.intercomSettings = {
					<?php 
						echo '
							app_id: "t84fcdk1",
							"buyer": "' . $data['buyer'] . '",
							"support": "' . $support_status . '",
							"supported_until": "' . $data['supported_until'] . '",
							"support_time_left" : "' . $days_remaining . ' days ' . $hours_remaining . ' hours",
							"theme": "Xstore"
						';
					?>
				};
			</script>	
		<?php endif; ?>

		<script data-cfasync="false">(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/t84fcdk1';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()
		</script>
	<?php	
	}
}

new EthemeUpdateSupport();

class EthemeUpdateSupport{

	private $errors = array();
	private $activated_data = array();
	
	function __construct(){
		$this->activated_data = get_option( 'etheme_activated_data' );
		add_action( 'wp_ajax_etheme_check_support', array( $this, 'etheme_check_support' ) );
	}

	// ! Check and update support date
	public function etheme_check_support(){

		if ( etheme_support_date() ) {
			echo json_encode( ['enabled' => esc_html__( 'You can use online chat at the right bottom to get help from 8theme support team', 'xstore' ), 'chat' => $this->chat_data() ] );
			die();
		}

		if ( ! $this->activated_data || ! $this->activated_data['purchase'] || empty( $this->activated_data['purchase'] ) ) {
			$this->error( esc_html__( 'Purchase code does not exist', 'xstore' ) );
		}

		$data = $this->remote_data();

		if ( ! isset( $data['supported_until'] ) ) $this->error( esc_html__( 'Can not get support period', 'xstore' ) );

		$local_date = strtotime( $this->activated_data['item']['supported_until'] );
		$envato_date = strtotime( $data['supported_until'] );

		if ( ! $local_date || ! $envato_date ) $this->error( esc_html__( 'Wrong date format of the support period', 'xstore' ) );

		if ( $local_date == $envato_date ){
			//$this->error( 'local support date same as envato' );
			//echo json_encode( ['succes' => esc_html__( 'Support data is updated', 'xstore' ) ] );
			//die();
		}

		$this->activated_data['item']['supported_until'] = $data['supported_until'];
		update_option( 'etheme_activated_data', maybe_unserialize( $this->activated_data ) );


    	$helper = sprintf( esc_html__( 'Sorry, theme support license has expired. Extend your support period on %s and then you\'ll be able to get help from 8theme support team.', 'xstore' ), '<a href="https://help.market.envato.com/hc/en-us/articles/207886473-Extending-and-Renewing-Item-Support" target="_blank">' . esc_html__( 'ThemeForest', 'xstore' ) . '</a>' );

		$text = ( etheme_support_date() ) ? esc_html__( 'Thank you. Support renewed. You can use online chat to get help from 8theme support team', 'xstore' ) : $helper;

		if ( ! etheme_support_date() ) {
			echo json_encode( ['succes' => $text, 'stop' => true ] );
		} else {
			echo json_encode( ['succes' => $text, 'chat' => $this->chat_data() ] );
		}

		die();
	}

	// ! Set chat data
	private function chat_data(){
		$support_date = strtotime( $this->activated_data['item']['supported_until'] );
		$current_date = strtotime( date( "Y-m-d" ) );
		$remaining = $support_date - $current_date;
		$days_remaining = floor( $remaining / 86400 );
		$hours_remaining = floor( ( $remaining % 86400) / 3600 );

		$array = array(
			'buyer' => $this->activated_data['item']['buyer'],
			'support' => ( etheme_support_date() ) ? 'ON' : 'OFF',
			'supported_until' => $this->activated_data['item']['supported_until'],
			'support_time_left'  => $days_remaining . ' days ' . $hours_remaining . ' hours',
		);

		return $array;
	}

	// ! Get new support date
	private function remote_data(){
		$theme_id = 15780546;
		$api_url = ETHEME_API;

		$response = wp_remote_get( $api_url . 'support/' . $this->activated_data['purchase'] . '?envato_id='. $theme_id .'&domain=' . $this->domain );
		$response_code = wp_remote_retrieve_response_code( $response );

		if( $response_code != '200' ) $this->error( esc_html__( 'Remote server did not respond. Support period was not updated', 'xstore' ) );

		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		// ! Remote error
		if( isset( $data['error'] ) ) $this->error( $data['error'] );

		return $data;
	}

	// ! Get domain
	public function domain(){
		$domain = get_option( 'siteurl' );
		$domain = str_replace( 'http://', '', $domain );
		$domain = str_replace( 'https://', '', $domain );
		$domain = str_replace( 'www', '', $domain );
		$domain = urlencode( $domain );
		return $domain;
	}

	// ! Generate error
	public function error( $error ){
		$this->errors[] = $error;
		echo json_encode( ['errors' => $this->errors ] );
		die();
	}

}


add_action('wp_ajax_etheme_deactivate_theme', 'etheme_deactivate_theme');
if( ! function_exists( 'etheme_deactivate_theme' ) ) {
	function etheme_deactivate_theme() {
		$activated_data = get_option( 'etheme_activated_data' );
		$theme_id = 15780546;
		$api_url = ETHEME_API;
		$status = '';
		$errors = array();
		$api = ( ! empty( $activated_data['api_key'] ) ) ? $activated_data['api_key'] : false;

		$domain = get_option( 'siteurl' );
	    $domain = str_replace( 'http://', '', $domain );
	    $domain = str_replace( 'https://', '', $domain );
	    $domain = str_replace( 'www', '', $domain );
	    $domain = urlencode( $domain );

		$response = wp_remote_get( $api_url . 'deactivate/' . $api . '?envato_id='. $theme_id .'&domain=' . $domain );
		$response_code = wp_remote_retrieve_response_code( $response );

        if( $response_code != '200' ) {
            $errors[] = 'API error (5)';
            echo json_encode( $errors );
            die();
        }

        $data = json_decode( wp_remote_retrieve_body( $response ), true );

        if( isset( $data['error'] ) ) {
            $errors[] = $data['error'];
            echo json_encode( $errors );
            die();
        }

		if ( isset( $data['status'] ) ) {
			$status = $data['status'];
			$data = array(
				'api_key' => 0,
				'theme' => 0,
				'purchase' => 0,
	      	);
			update_option( 'etheme_activated_data', maybe_unserialize( $data ) );

			echo json_encode( $status );
			die();
		}
	}
}

add_action( 'wp_ajax_et_update_menu_ajax', 'et_update_menu_ajax' ); 
if ( ! function_exists('et_update_menu_ajax')) {

	function et_update_menu_ajax () {

		$post = $_POST['item_menu'];

		// update_post_meta( $post['db_id'], '_menu-item-disable_titles', $post['dis_titles']);
		update_post_meta( $post['db_id'], '_menu-item-anchor', sanitize_post($post['anchor']));
		update_post_meta( $post['db_id'], '_menu-item-design', sanitize_post($post['design']));
		update_post_meta( $post['db_id'], '_menu-item-design2', sanitize_post($post['design2']));
		update_post_meta( $post['db_id'], '_menu-item-column_width', $post['column_width']);
		update_post_meta( $post['db_id'], '_menu-item-column_height', $post['column_height']);

		update_post_meta( $post['db_id'], '_menu-item-sublist_width', $post['sublist_width']);

		update_post_meta( $post['db_id'], '_menu-item-columns', $post['columns']);
		update_post_meta( $post['db_id'], '_menu-item-icon_type', sanitize_post($post['icon_type']));
		update_post_meta( $post['db_id'], '_menu-item-icon', $post['icon']);
		update_post_meta( $post['db_id'], '_menu-item-label', sanitize_post($post['item_label']));
		update_post_meta( $post['db_id'], '_menu-item-background_repeat', sanitize_post($post['background_repeat']));
		update_post_meta( $post['db_id'], '_menu-item-background_position', $post['background_position']);
		update_post_meta( $post['db_id'], '_menu-item-use_img', sanitize_post($post['use_img']));
		update_post_meta( $post['db_id'], '_menu-item-widget_area', sanitize_post($post['widget_area']));
		update_post_meta( $post['db_id'], '_menu-item-static_block', sanitize_post($post['static_block']));

		echo json_encode($post);
		die();
	}
}

add_action( 'woocommerce_product_options_general_product_data', 'et_general_product_data_time_fields' );
function et_general_product_data_time_fields() { 

	woocommerce_wp_text_input( array( 'id' => '_sale_price_time_start', 'label' => esc_html('Sale price time start', 'xstore'), 'placeholder' => esc_html( 'From&hellip; 12:00', 'xstore'), 'desc_tip' => 'true', 'description' => __( 'Only when sale price schedule is enabled', 'xstore' ) ) );
	woocommerce_wp_text_input( array( 'id' => '_sale_price_time_end', 'label' => esc_html('Sale price time end', 'xstore'), 'placeholder' => esc_html( 'To&hellip; 12:00', 'xstore' ), 'desc_tip' => 'true', 'description' => __( 'Only when sale price schedule is enabled', 'xstore' ) ) );

}

// Hook to save the data value from the custom fields 
add_action( 'woocommerce_process_product_meta', 'et_save_general_product_data_time_fields' );
function et_save_general_product_data_time_fields( $post_id ) { 
	$_sale_price_time_start = $_POST['_sale_price_time_start']; 
	update_post_meta( $post_id, '_sale_price_time_start', esc_attr( $_sale_price_time_start ) ); 
	$_sale_price_time_end = $_POST['_sale_price_time_end']; 
	update_post_meta( $post_id, '_sale_price_time_end', esc_attr( $_sale_price_time_end ) ); 
}


new EthemeAdmin;

class EthemeAdmin{

	function __construct(){
		add_action( 'admin_menu', array( $this, 'et_add_menu_page' ) );
	}

	public function et_add_menu_page(){
        add_menu_page( 
            esc_html__( 'Xstore', 'xstore' ), 
            esc_html__( 'Xstore', 'xstore' ), 
            'manage_options', 
            'et-panel-welcome',
            array( $this, 'etheme_panel_page' ),
            ETHEME_CODE_IMAGES . 'Icon-white.png',
            65
        );
        add_submenu_page(
            'et-panel-welcome',
            esc_html__( 'Dashboard', 'xstore' ),
            esc_html__( 'Dashboard', 'xstore' ),
            'manage_options',
            'et-panel-welcome',
            array( $this, 'etheme_panel_page' )
        );

		if ( ! etheme_is_activated() && ! class_exists( 'Redux' ) ) {
            add_submenu_page(
                'et-panel-welcome',
                esc_html__( 'Setup Wizard', 'xstore' ),
                esc_html__( 'Setup Wizard', 'xstore' ),
                'manage_options',
                admin_url( 'themes.php?page=xstore-setup' ),
                ''
            );
		} elseif( ! etheme_is_activated() ){

		} elseif( ! class_exists( 'Redux' ) ){
            add_submenu_page(
                'et-panel-welcome',
                esc_html__( 'Install Plugins', 'xstore' ),
                esc_html__( 'Install Plugins', 'xstore' ),
                'manage_options',
                admin_url( 'themes.php?page=install-required-plugins&plugin_status=all' ),
                ''
            );
		} else {
            add_submenu_page(
                'et-panel-welcome',
                esc_html__( 'Import Demos', 'xstore' ),
                esc_html__( 'Import Demos', 'xstore' ),
                'manage_options',
                'et-panel-demos',
                array( $this, 'etheme_panel_page' )
            );
            add_submenu_page(
                'et-panel-welcome',
                esc_html__( 'Install Plugins', 'xstore' ),
                esc_html__( 'Install Plugins', 'xstore' ),
                'manage_options',
                admin_url( 'themes.php?page=install-required-plugins&plugin_status=all' ),
                ''
            );
            add_submenu_page(
                'et-panel-welcome',
                'Theme Options',
                'Theme Options',
                'manage_options',
                admin_url( 'themes.php?page=_options' ),
                ''
            );
		}

        add_submenu_page(
            'et-panel-welcome',
            esc_html__( 'Tutorials & Support', 'xstore' ),
            esc_html__( 'Tutorials & Support', 'xstore' ),
            'manage_options',
            'et-panel-support',
            array( $this, 'etheme_panel_page' )
        );

        add_submenu_page(
            'et-panel-welcome',
            esc_html__( 'Changelog', 'xstore' ),
            esc_html__( 'Changelog', 'xstore' ),
            'manage_options',
            'et-panel-changelog',
            array( $this, 'etheme_panel_page' )
        );
    }

	public function etheme_panel_page(){
		$out = $this->etheme_page_header();

		$out .= $this->nav();

		$out .= '<div class="et-row etheme-page-content">';

			if( $_GET['page'] == 'et-panel-welcome' ){
				$out .= $this->etheme_welcome_page();
			} elseif( $_GET['page'] == 'et-panel-plugins' ){
				$out .= $this->etheme_plugins_page();
			} elseif( $_GET['page'] == 'et-panel-changelog' ){
				$out .= $this->etheme_changelog_page();
			} elseif( $_GET['page'] == 'et-panel-support' ){
				$out .= $this->etheme_support_page();
			} elseif ( $_GET['page'] == 'et-panel-demos' ){
				$out .= $this->etheme_demos_page();
			} elseif( $_GET['page']  == 'et-panel-options' ){
				$out .= $this->etheme_options_page();
			} else {
				$out .= $this->etheme_welcome_page();
			}

		$out .= '</div>';

		$out .= $this->etheme_page_footer();

		echo wp_specialchars_decode($out);
	}

	public function etheme_page_header(){
		$theme = wp_get_theme();
		$version = $theme->get('Version');
		$out = '';

		if ( etheme_is_activated() ) {
	 		$activated = '<span class="activate-note activated">' . esc_html__('Activated', 'xstore') . '</span>';
	 	} else {
	 		$activated = '<span class="activate-note">' . esc_html__('Not activated', 'xstore') . '</span>';
	 	}

	 	if ( is_child_theme() ) {
          $parent = wp_get_theme( 'xstore' );
          $parent = $parent->version;
          $out .= '<span class="theme-version">' . $parent . ' (child  ' . $version . ')</span>';
	 	} else {
	 	  $out .= '<span class="theme-version">' . $version . '</span>';
	 	}

		return '
		<div class="etheme-page-wrapper">
			<div class="etheme-page-header">
				<div class="fright text-center">
					<span class="theme-logo"><img src="' . ETHEME_BASE_URI . ETHEME_CODE .'assets/images/admin-logo.png" alt="logo"></span>
					'. $out .'
					' . $activated . '
				</div>
				<h2 class="etheme-page-title">Welcome to Xstore!</h2>
				<p>Thank you for choosing Xstore. We hope you’ll like it!<br/> To enjoy the full experience we strongly recommend to activate a theme with your purchase code.</p>
			</div>
		';
	}

	public function etheme_page_footer(){
		return '
			<div class="etheme-page-footer">
			</div>
		</div>
		';
	}

	public function nav(){
		$out = '';
		$out .= sprintf(
			'<li><a href="%s" class="et-nav%s et-nav-menu">%s</a></li>',
			admin_url( 'admin.php?page=et-panel-welcome' ),
			( ! isset( $_GET['page'] ) || $_GET['page'] == 'et-panel-welcome' ) ? ' active' : '',
			esc_html__( 'Welcome', 'xstore' )

		);

		if ( ! etheme_is_activated() ) {
			$out .= sprintf(
				'<li><a href="%s" class="et-nav%s et-nav-portfolio">%s</a></li>',
				admin_url( 'admin.php?page=et-panel-welcome' ),
				( $_GET['page'] == 'et-panel-demos' ) ? ' active' : '',
				esc_html__( 'Demos', 'xstore' )
			);
			$out .= sprintf(
				'<li><a href="%s" class="et-nav%s et-nav-speed">%s</a></li>',
				admin_url( 'admin.php?page=et-panel-welcome' ),
				( $_GET['page'] == 'et-panel-plugins' ) ? ' active' : '',
				esc_html__( 'Plugins', 'xstore' )
			);
			$out .= sprintf(
				'<li><a href="%s" class="et-nav%s et-nav-general">%s</a></li>',
				admin_url( 'admin.php?page=et-panel-welcome' ),
				( $_GET['page'] == 'et-panel-options' ) ? ' active' : '',
				esc_html__( 'Theme Options', 'xstore' )
			);
		} elseif( ! class_exists( 'Redux' ) ) {
			$out .= sprintf(
				'<li><a href="%s" class="et-nav%s et-nav-portfolio">%s</a></li>',
				admin_url( 'themes.php?page=install-required-plugins&plugin_status=all' ),
				( $_GET['page'] == 'et-panel-demos' ) ? ' active' : '',
				esc_html__( 'Demos', 'xstore' )
			);
			$out .= sprintf(
				'<li><a href="%s" class="et-nav%s et-nav-speed">%s</a></li>',
				admin_url( 'themes.php?page=install-required-plugins&plugin_status=all' ),
				( $_GET['page'] == 'et-panel-plugins' ) ? ' active' : '',
				esc_html__( 'Plugins', 'xstore' )
			);
			$out .= sprintf(
				'<li><a href="%s" class="et-nav%s et-nav-general">%s</a></li>',
				admin_url( 'themes.php?page=install-required-plugins&plugin_status=all' ),
				( $_GET['page'] == 'et-panel-options' ) ? ' active' : '',
				esc_html__( 'Theme Options', 'xstore' )
			);
		} else {
			$out .= sprintf(
				'<li><a href="%s" class="et-nav%s et-nav-portfolio">%s</a></li>',
				admin_url( 'admin.php?page=et-panel-demos' ),
				( $_GET['page'] == 'et-panel-demos' ) ? ' active' : '',
				esc_html__( 'Demos', 'xstore' )
			);
			$out .= sprintf(
				'<li><a href="%s" class="et-nav%s et-nav-speed">%s</a></li>',
				admin_url( 'themes.php?page=install-required-plugins&plugin_status=all' ),
				( $_GET['page'] == 'et-panel-plugins' ) ? ' active' : '',
				esc_html__( 'Plugins', 'xstore' )
			);
			$out .= sprintf(
				'<li><a href="%s" class="et-nav%s et-nav-general">%s</a></li>',
				admin_url( 'themes.php?page=_options' ),
				( $_GET['page'] == 'et-panel-options' ) ? ' active' : '',
				esc_html__( 'Theme Options', 'xstore' )
			);
		}
		$out .= sprintf(
			'<li><a href="%s" class="et-nav%s et-nav-support">%s</a></li>',
			admin_url( 'admin.php?page=et-panel-support' ),
			( $_GET['page'] == 'et-panel-support' ) ? ' active' : '',
			esc_html__( 'Tutorials & Support', 'xstore' )

		);

		$out .= sprintf(
			'<li><a href="%s" class="et-nav%s et-nav-documentation">%s</a></li>',
			admin_url( 'admin.php?page=et-panel-changelog' ),
			( $_GET['page'] == 'et-panel-changelog' ) ? ' active' : '',
			esc_html__( 'Changelog', 'xstore' )

		);

		return '<div class="etheme-page-nav"><ul>' . $out . '</ul></div>';
	}

	public function etheme_welcome_page(){
		$out = '';
		$et_info = '';

            $result = '';
			ob_start();
				$system = new Etheme_System_Requirements();
				$system->html();
                $result = $system->result();
			$system = ob_get_clean();

			ob_start();

				$version = new ETheme_Version_Check();
				$version->activation_page();?>

				<h4 class="text-uppercase"><?php esc_html_e('Where can I find my purchase code?', 'xstore'); ?></h4>

                <ul>
                    <li>1. <?php esc_html_e('Please enter your Envato account and find ', 'xstore'); ?> <a href="https://themeforest.net/downloads"><?php esc_html_e('Downloads tab', 'xstore'); ?></a></li>
                    <li>2. <?php esc_html_e('Find Xstore theme in the list and click on the opposite', 'xstore');?> <span><?php echo esc_html__('Download', 'xstore'); ?></span> <?php esc_html_e('button', 'xstore'); ?></li>
                    <li>3. <?php esc_html_e('Select', 'xstore'); ?> <span><?php echo esc_html__('License Certificate & Purchase code', 'xstore'); ?></span> <?php esc_html_e('for download', 'xstore'); ?></li>
                    <li>4. <?php esc_html_e('Copy the', 'xstore'); ?> <span><?php esc_html_e('Item Purchase Code', 'xstore'); ?> </span><?php esc_html_e('from the downloaded document', 'xstore'); ?></li>
                </ul>
                <br/>

				<h3><?php esc_html_e('Buy license', 'xstore'); ?></h3>

				<p><?php esc_html_e('If you don\'t have a license or need another one for a new website, click on a Buy button. Interested in multiple licenses? Contact us in a Live chat for more details about discounts for you.', 'xstore'); ?></p>

				<a href="https://themeforest.net/item/xstore-responsive-woocommerce-theme/15780546?utm_source=xstorecta?utm_source=xstorencta&ref=8theme&license=regular&open_purchase_for_item_id=15780546&purchasable=source" class="et-button et-button-green last-button no-loader"><?php esc_html_e('Purchase now', 'xstore'); ?></a>

			<?php $version = ob_get_clean();
			if ( ! class_exists( 'Redux' ) ) {
				$et_info = '<p class="et-message et-error">' . esc_html__('The following required plugin is currently inactive: ', 'xstore') . '<a href="'.admin_url( 'plugins.php' ).'" target="_blank">'.esc_html__('Redux Framework', 'xstore').'</a></p>';
			}
			if ( ! class_exists('ETheme_Import') ) {
				$et_info = '<p class="et-message et-error">' . esc_html__('The following required plugin is currently inactive: ', 'xstore') . '<a href="'.admin_url( 'plugins.php' ).'" target="_blank">'.esc_html__('Xstore Core', 'xstore').'</a></p>';
			}
		$out .= '
		<div class="et-col-7 etheme-registration">
			'.$et_info.'
			<h3>' . esc_html__( 'Theme Registration', 'xstore' ) . '</h3>
			' . $version . '
		</div>
		';
		$out .= '
			<div class="et-col-5 etheme-system et-sidebar">
				<h3>' . esc_html__( 'System Requirements', 'xstore' ) . '</h3>
				' . $system . '
				<div class="text-center"><a href="" class="et-button et-button-grey last-button">
				<span class="et-loader">
	                    <svg class="loader-circular" viewBox="25 25 50 50"><circle class="loader-path" cx="50" cy="50" r="12" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg>
	                </span>' . esc_html__( 'Check again', 'xstore' ) . '</a></div>';
				if ( ! $result ) {
					$out .= '<p class="et-message et-error">'.esc_html__( 'Your system does not meet the server requirements. For more efficient result, we strongly recommend to contact your host provider and check the necessary settings.', 'xstore' ).'<p>';
				}

		$out .= '</div>';
		return $out;
	}

    public function etheme_demos_page(){
        $out   = '';
        $class = '';
		$versions_imported = get_option('versions_imported');

        if( empty( $versions_imported ) ){
            $versions_imported = array();
        }

        if( ! in_array( 'default', $versions_imported ) ) {
            $class = ' no-default-imported';
        }

        foreach($versions_imported as $ver) {
            $class = ' imported-' . $ver;
        }

        $versions = require apply_filters('etheme_file_url', ETHEME_THEME . 'versions.php');

        $pages = array_filter($versions, function( $el ) {
            return $el['type'] == 'page';
        });

        $demos = array_filter($versions, function( $el ) {
            return $el['type'] == 'demo';
        });

        $out .= '<div class="loading-info">
            <h2>Please wait, it may take up to 2 minutes.</h2>
            <div class="et-loader">
                <svg class="loader-circular" viewBox="25 25 50 50"><circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg>
            </div>
        </div>';

        if ( !class_exists('ETheme_Import') ) {
        	$out .= '
                <p class="et-message et-error">
                   '.esc_html__('The following required plugin is currently inactive: ', 'xstore') . '<a href="'.admin_url( 'plugins.php' ).'" target="_blank">'.esc_html__('Xstore Core', 'xstore').'</a>
                </p>
            ';
            return $out;
        }
        elseif( ! in_array( 'default', $versions_imported ) ) {
            $out .= '
                <p class="et-message et-error et-default-content-info">Start working with our template by installing base demo content.</p>
                <span class="et-button button-import-default button-import-version et-button-green no-loader" data-version="default">
                    ' . esc_html__('Import base dummy content', 'xstore') . '
                </span>                
            ';
       	}
    	if (in_array( 'default', $versions_imported )) {
       		$out .= '
		        <div class="et-message et-success"><p>' . esc_html__( 'You have successfully imported our base demo content.', 'xstore' ) . '</p></div>
		        ';
       	}

        $out .= '<div class="import-demos-wrapper admin-demos">';
        $out .= '<div class="import-demos-header">';
            $out .= '<h3>' . esc_html__( 'Import demo versions', 'xstore' ) . '</h3>';
            $out .= ' <div class="etheme-search">
            <input type="text" class="etheme-versions-search form-control" placeholder="Search for versions">
            <i class="et-admin-icon et-zoom"></i>
            <span class="spinner">
            <div class="et-loader ">
                <svg class="loader-circular" viewBox="25 25 50 50">
                <circle class="loader-path" cx="50" cy="50" r="12" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                </svg>
            </div>
            </span>
        </div>';
        $out .= '</div>';
            $out .= '<div class="import-demos">';
                foreach ($demos as $key => $version){
                	if ( in_array( $key, $versions_imported ) ) {
                		$imported = 'version-imported';
                		$imported_text = esc_html__( 'Activate', 'xstore' );
                	} else {
                		$imported = 'not-imported';
                		$imported_text = esc_html__( 'Import', 'xstore' );
                	}

                    $out .= '
                    	<div class="version-preview ' . $imported . ' version-preview-' . esc_attr( $key ) . '">
                            <div class="version-screenshot">
                                <img src="https://xstore.8theme.com/dashboard-images/' . $key . '/screenshot.jpg" alt="' . $key . '">
                                <a href="' . esc_url( $version['preview_url'] ) . '" target="_blank" class="button-preview">
                                    ' . esc_html__('Live preview', 'xstore') . '
                                </a>
                                <span class="et-button button-import-version no-loader" data-version="' . esc_attr( $key ) . '">
                                    ' . $imported_text . '
                                </span>
                                <span class="installed-icon">' . esc_html__( 'Imported', 'xstore' ) . '</span>
                            </div>
                            <span class="version-title">' . esc_html( $version['title'] ) . '</span>
                    	</div>
                    ';
                }
            $out .= '</div>';
            $out .= '
                <div class="install-base-first">
                    <h1>' . esc_html__('No access!', 'xstore') . '</h1>
                    <p>' . esc_html__('Please, install Base demo content before, to access the collection of our Home Pages.', 'xstore') . '</p>
                </div>
            ';
        $out .= '</div>';

        $out .= ' <div class="import-additional-pages">';
            $out .= '
                <h3>' . esc_html__( 'Import of the additional pages', 'xstore') . '</h3>
                <div class="page-preview">
                    <img src="https://xstore.8theme.com/dashboard-images/faq/screenshot.jpg" alt="faq-screenshot">
                    <a href="' . $pages['faq']['preview_url'] . '" target="_blank" class="preview-page-button">' .esc_html__('Live preview', 'xstore') . '</a>
                </div>
            ';
            $out .= '<div class="page-selector">';

                $out .= '<select name="pages-selector" id="pages-selector" data-url="https://xstore.8theme.com/dashboard-images/">';
                    foreach ($pages as $key => $version){
                        $out .= '<option value="' . esc_attr( $key ) . '" data-preview="' . $version['preview_url'] . '">' . esc_html( $version['title'] ) . '</option>';
                    }
                $out .= '</select>';

                $out .= '
                    <a href="#" class="et-button button-import-page button-import-version et-button-green no-loader" data-version="faq">' . esc_html__( 'Import', 'xstore' ) . '</a>
                    <div class="et-message et-info">
                        <b>' . esc_html__( 'Import Additional Pages', 'xstore' ) . '</b>
                        <p>' . esc_html__( 'Please, note, these pages should be added to your menu via Appearance > Menus. All these pages are available for both Dark and Light version.', 'xstore' ) . '</p>
                    </div>
                    <div class="et-message et-error">
                        <p>' . esc_html__( 'Before additional pages import, please, do the backup of your Theme Settings: "Import / Export - Options" and your website entirely.', 'xstore' ) . '</p>
                    </div>
                ';
           $out .= '</div>';
        $out .= '</div>';
        return '<div class="etheme-import-section' . esc_attr( $class ) . '">' . $out . '</div>';
    }

	public function etheme_plugins_page(){
		$out = '';
		$out .= '<h2>Plugins</h2>';
		return $out;
	}

	public function etheme_options_page(){
		$out = '';
		$out .= '<h2>Options</h2>';
		return $out;
	}

	public function etheme_support_page(){
		$out = '';
		$out .= '
			<div class="et-col-7 etheme-support">
				<h3 class="et-title">' . esc_html__( 'Video tutorials', 'xstore' ) . '</h3>
				<div class="etheme-videos-wrapper">
					<div class="etheme-videos">
					</div>
				</div>
				<div class="text-center"><a href="https://www.youtube.com/channel/UCiZY0AJRFoKhLrkCXomrfmA" class="et-button no-loader more-videos last-button" target="_blank">' . esc_html__( 'View more videos', 'xstore' ) . '</a></div>
				<h3>' . esc_html__( 'Help and support', 'xstore' ) . '</h3>
				<p>' . esc_html__( 'If you encounter any difficulties with our product we are ready to assist you via:', 'xstore' ) . '</p>
				<ul class="support-blocks">
					<li>
						<a href="http://8theme.com/demo/xstore/previews/" target="_blank">
							<img src="' . ETHEME_BASE_URI . ETHEME_CODE .'assets/images/' . 'chat-icon.png">
							<span>' . esc_html__( 'Live Chat 24/7', 'xstore' ) . '</span>
						</a>
					</li>
					<li>
						<a href="https://www.8theme.com/forums/" target="_blank">
							<img src="' . ETHEME_BASE_URI . ETHEME_CODE .'assets/images/' . 'support-icon.png">
							<span>' . esc_html__( 'Support Forum', 'xstore' ) . '</span>
						</a>
					</li>
					<li>
						<a href="http://prntscr.com/d24xhu" target="_blank">
							<img src="' . ETHEME_BASE_URI . ETHEME_CODE .'assets/images/' . 'envato-icon.png">
							<span>' . esc_html__( 'ThemeForest profile', 'xstore' ) . '</span>
						</a>
					</li>
				</ul>
				<div class="support-includes">
					<div class="includes">
						<p>' . esc_html__( 'Item Support includes:', 'xstore' ) . '</p>
						<ul>
							<li>' . esc_html__( 'Answering technical questions', 'xstore' ) . '</li>
							<li>' . esc_html__( 'Assistance with reported bugs and issues', 'xstore' ) . '</li>
							<li>' . esc_html__( 'Help with bundled 3rd party plugins', 'xstore' ) . '</li>
						</ul>
					</div>
					<div class="excludes">
						<p>' . __( 'Item Support <span class="red-color">DOES NOT</span> Include:', 'xstore' ) . '</p>
						<ul>
							<li>' . esc_html__( 'Customization services', 'xstore' ) . '</li>
							<li>' . esc_html__( 'Installation services', 'xstore' ) . '</li>
							<li>' . esc_html__( 'Support for non-bundled 3rd party plugins.', 'xstore' ) . '</li>
						</ul>
					</div>
				</div>
			</div>
		';

		$out .= '
			<div class="et-col-5 etheme-documentation et-sidebar">
				<h3>' . esc_html__( 'Documentation', 'xstore' ) . '</h3>
				<h4>' . esc_html__( 'Theme Installation', 'xstore' ) . '</h4>
				<ul>
					<li><a href="https://xstore.helpscoutdocs.com/article/4-theme-package" target="_blank">' . esc_html__( 'XStore Theme Package', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/12-theme-installation" target="_blank">' . esc_html__( 'Theme Installation', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/32-child-theme" target="_blank">' . esc_html__( 'Child Theme', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/34-demo-content" target="_blank">' . esc_html__( 'Demo Content', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/45-8theme-page-post-layout-settings-8theme-post-options" target="_blank">' . esc_html__( '8theme Page/Post/Product Layout settings', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/42-portfolio-page" target="_blank">' . esc_html__( 'Portfolio Page', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/43-blank-page" target="_blank">' . esc_html__( 'Blank Page', 'xstore' ) . '</a></li>
				</ul>
				<h4>' . esc_html__( 'Theme Update', 'xstore' ) . '</h4>
				<ul>
					<li><a href="https://xstore.helpscoutdocs.com/article/63-theme-update" target="_blank">' . esc_html__( 'Theme Update', 'xstore' ) . '</a></li>
				</ul>
				<h4>' . esc_html__( 'Menu Set Up', 'xstore' ) . '</h4>
				<ul>
					<li><a href="https://xstore.helpscoutdocs.com/article/86-general-information" target="_blank">' . esc_html__( 'General Information', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/27-mega-menu" target="_blank">' . esc_html__( 'Mega Menu', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/88-one-page-menu" target="_blank">' . esc_html__( 'One Page menu', 'xstore' ) . '</a></li>
				</ul>
				<h4>' . esc_html__( 'Theme Translation', 'xstore' ) . '</h4>
				<ul>
					<li><a href="https://xstore.helpscoutdocs.com/article/30-base-theme-translation" target="_blank">' . esc_html__( 'Base theme translation', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/31-translation-with-wpml" target="_blank">' . esc_html__( 'Translation with WPML', 'xstore' ) . '</a></li>
				</ul>
				<h4>' . esc_html__( 'Widgets/Static Blocks', 'xstore' ) . '</h4>
				<ul>
					<li><a href="https://xstore.helpscoutdocs.com/article/48-widgets-custom-widget-areas" target="_blank">' . esc_html__( 'Widgets & Custom Widget Areas', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/47-static-blocks" target="_blank">' . esc_html__( 'Static Blocks', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/46-xstore-shortcodes" target="_blank">' . esc_html__( 'XStore Shortcodes', 'xstore' ) . '</a></li>
				</ul>
				<h4>' . esc_html__( 'WooCommerce', 'xstore' ) . '</h4>
				<ul>
					<li><a href="https://xstore.helpscoutdocs.com/article/29-general-information" target="_blank">' . esc_html__( 'General Information', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/67-shop-page" target="_blank">' . esc_html__( 'Shop page', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/68-single-product-page" target="_blank">' . esc_html__( 'Single Product page', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/89-product-images" target="_blank">' . esc_html__( 'Product Images', 'xstore' ) . '</a></li>
				</ul>
				<h4>' . esc_html__( 'Plugins', 'xstore' ) . '</h4>
				<ul>
					<li><a href="https://xstore.helpscoutdocs.com/article/35-general-info" target="_blank">' . esc_html__( 'General Info', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/36-included-plugins" target="_blank">' . esc_html__( 'Included plugins', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/37-plugins-update" target="_blank">' . esc_html__( 'Plugins Update', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/38-activation-and-purchase-codes" target="_blank">' . esc_html__( 'Activation and Purchase Codes', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/65-woocommerce-infinite-scroll-and-ajax-pagination-settings" target="_blank">' . esc_html__( 'WooCommerce Infinite Scroll and Ajax Pagination', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/91-mail-chimp-form-custom-styles" target="_blank">' . esc_html__( 'MailChimp form custom styles', 'xstore' ) . '</a></li>
				</ul>
				<h4>' . esc_html__( 'Troubleshooting', 'xstore' ) . '</h4>
				<ul>
					<li><a href="https://xstore.helpscoutdocs.com/article/64-how-to-add-custom-favicon" target="_blank">' . esc_html__( 'How to add custom favicon', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/69-how-to-add-slider-banner-in-product-category-page" target="_blank">' . esc_html__( 'How to add slider/banner on Category page', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/87-facebook-login" target="_blank">' . esc_html__( 'FaceBook login', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/41-contact-page" target="_blank">' . esc_html__( 'How to create a contact page', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/44-blog-page" target="_blank">' . esc_html__( 'How to create a blog page', 'xstore' ) . '</a></li>
					<li><a href="https://xstore.helpscoutdocs.com/article/90-how-to-find-your-themeforest-item-purchase-code" target="_blank">' . esc_html__( 'How to find your ThemeForest Item Purchase Code', 'xstore' ) . '</a></li>
				</ul>
				<h4>' . esc_html__( 'Support', 'xstore' ) . '</h4>
				<ul>
					<li><a href="https://xstore.helpscoutdocs.com/article/25-support" target="_blank">' . esc_html__( 'Support Policy', 'xstore' ) . '</a></li>
				</ul>
			</div>
		';

		return $out;
	}

	public function etheme_changelog_page(){
		$out = '';
		$out .= '<h3 class="et-title">' . esc_html__( 'Changelog', 'xstore' ) . '</h3>';

		if ( function_exists( 'wp_remote_get' ) ) {
			$response = wp_remote_get( 'https://xstore.8theme.com/change-log.php?type=panel' );
			$response = wp_remote_retrieve_body( $response );
			$response = str_replace( 'class="arrow"', '', $response );
			$response = str_replace( '<h2>', '<h4>', $response );
			$response = str_replace( '</h2>', '</h4>', $response );
			$response = str_replace( '[vc_column_text]', '', $response);
			$response = str_replace( '<div></div>', '', $response);
			$out .= $response;
		} else {
			$out .= '<p class="et-message et-error">' . esc_html__( 'Can not get changelog data', 'xstore' ) . '</p>';
		}

		return '<div class="etheme-div etheme-changelog">' . $out . '</div>';
	}
}