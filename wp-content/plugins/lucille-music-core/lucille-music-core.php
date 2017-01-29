<?php
/**
 * Plugin Name: Lucille Music Core
 * Plugin URI: http://www.smartwpress.com/lucille/
 * Description: This plugin adds custom post types and custom meta boxes used by Lucille wordpress theme.
 * Version: 1.1
 * Author: SmartWpress
 * Author URI: http://www.smartwpress.com
 * Text Domain: lucille
 * Domain Path: /languages
 * License: GNU General Public License version 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
 
 
 /*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/
if (!defined('CDIR_PATH')) {
	define( 'CDIR_PATH', plugin_dir_path( __FILE__ ) );
}

/* 
|--------------------------------------------------------------------------
| INCLUDE FUNCTIONALITY
|--------------------------------------------------------------------------
*/

/* 
	Plugin Settings
*/
require_once( CDIR_PATH."/lmc_plugin_settings.php");

/*
	Custom Post Types 
*/
require_once( CDIR_PATH."/videos.php");
require_once( CDIR_PATH."/photo_albums.php");
require_once( CDIR_PATH."/albums.php");
require_once( CDIR_PATH."/events.php");

/*
	Custom post meta
*/
require_once( CDIR_PATH."/custom_meta_boxes.php");
/*
	Widgets
*/
require_once( CDIR_PATH."/lucille_widgets.php");
/*
	Visual Composer Elements
*/
require_once( CDIR_PATH."/visual_composer/add_remove_params.php");	/*add remove params for some visual composer elements*/
require_once( CDIR_PATH."/visual_composer/add_shortcodes.php");		/*add new shortcodes to be used by visual composer*/
require_once( CDIR_PATH."/visual_composer/vc_map.php");				/*map existing shortcodes to vc elements*/

/*
	AJAX functions
*/
require_once( CDIR_PATH."/ajax_binding.php");

/* 
|--------------------------------------------------------------------------
| LOAD TEXT DOMAIN
|--------------------------------------------------------------------------
*/
/*
	Load text domain
*/
function LUCILLE_SWP_jamsession_post_types_init() 
{
	$domain = "lucille-music-core";
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	$trans_location = trailingslashit( WP_LANG_DIR ) . "plugins/" . $domain . '-' . $locale . '.mo';
	
	if ( $loaded = load_plugin_textdomain( $domain, FALSE, $trans_location) ) {
		return $loaded;
	} else {
		/*old location, languages dir in the plugin dir*/
		load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/');
	}
}
add_action('init', 'LUCILLE_SWP_jamsession_post_types_init');


/* 
|--------------------------------------------------------------------------
| LOAD SCRIPTS AND STYLES
|--------------------------------------------------------------------------
*/
/*
	Load scripts and styles
*/
function LUCILLE_SWP_plugin_load_scripts_and_styles() {
	/*photo gallery css*/
	wp_register_style( 'js_gallery_post_admin', plugins_url('/css/js_gallery_post_admin.css', __FILE__));
	wp_enqueue_style( 'js_gallery_post_admin');

	/*photo gallery js*/
	wp_register_script( 'handle_image_actions', plugins_url('/js/handle_image_actions.js', __FILE__), array(), '', true);
	wp_register_script( 'media_upload_assets', plugins_url('/js/media_upload_assets.js', __FILE__), array(), '', true);
	wp_enqueue_script( 'handle_image_actions');	
	wp_enqueue_script( 'media_upload_assets');	

	/*generic admin css*/
	wp_register_style( 'js_backend_css', plugins_url('/css/backend_style.css', __FILE__));
	wp_enqueue_style( 'js_backend_css');
	
	/*audio admin css*/
	wp_register_style( 'js_audio_styles',  plugins_url('/css/js_audio_styles.css', __FILE__));
	wp_enqueue_style( 'js_audio_styles');	
	/*discography js*/
	wp_register_script( 'handle_audio_actions', plugins_url('/js/handle_audio_actions.js', __FILE__), array(), '', true);
	wp_enqueue_script( 'handle_audio_actions');		
	
	/*time picker jQuery plugin css and js*/
	wp_register_style( 'jquery.ui.timepicker', plugins_url('/css/jquery.ui.timepicker.css', __FILE__ ));
	wp_enqueue_style( 'jquery.ui.timepicker');
	wp_register_script( 'jquery.ui.timepicker', plugins_url('/js/jquery.ui.timepicker.js', __FILE__), array('jquery'), '', true);
	wp_enqueue_script('jquery.ui.timepicker');	
	
	/*date picker jQuery plugin and style*/
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-style', plugins_url('/css/jquery-ui.css', __FILE__));
	/*initialise date picker*/
	wp_register_script( 'initialize_datepicker', plugins_url('/js/initialize_datepicker.js', __FILE__), array('jquery-ui-datepicker', 'jquery.ui.timepicker'), '', true);
	wp_enqueue_script( 'initialize_datepicker');
	
	/*alpha color picker*/
	wp_register_script( 'alpha_color_picker', plugins_url('/js/alpha-color-picker.js', __FILE__), array('jquery', 'wp-color-picker'), '', true);
	wp_enqueue_script( 'alpha_color_picker');
	wp_enqueue_style( 'alpha_color_picker', plugins_url('/css/alpha-color-picker.css', __FILE__ ), array('wp-color-picker'));
}
add_action( 'admin_enqueue_scripts', 'LUCILLE_SWP_plugin_load_scripts_and_styles');


function LUCILLE_SWP_plugin_load_front_scripts_and_styles() {
	/*contact form action*/
	wp_register_script('lc_swp_contact_form', plugins_url('/js/lc_swp_contact_form.js', __FILE__), array('jquery'), '', true);
	wp_enqueue_script('lc_swp_contact_form');

	/*set ajax url*/
	$ajaxurl_val = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	);
	wp_localize_script('lc_swp_contact_form', 'DATAVALUES', $ajaxurl_val);	
}
add_action('wp_enqueue_scripts', 'LUCILLE_SWP_plugin_load_front_scripts_and_styles');


/* 
|--------------------------------------------------------------------------
| FLUSH REWRITE RULES
|--------------------------------------------------------------------------
*/
/*
	Flush rewrite rules on activation/deactivation
	Needed by the functionality that renames the slug for custom post types and taxonomies for custom post types
*/
function LUCILLE_SWP_activate() {
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'LUCILLE_SWP_activate');

function LUCILLE_SWP_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'LUCILLE_SWP_deactivate');


/* 
|--------------------------------------------------------------------------
| GET PLUGIN OPTION
|--------------------------------------------------------------------------
*/
/*
	Retreive plugin option
*/
function LUCILLE_SWP_JPT_get_plugin_option($option)
{
	$options = get_option('LMC_plugin_options');
	
	if (isset($options[$option])) {
		return $options[ $option ];
	}
	
	return "";
}

function LUCILLE_SWP_LMC_get_contact_form_email() 
{
	$options = get_option('LMC_plugin_options');

	$cf_email = '';
	if (isset($options['lc_mc_contact_form_email'])) {
		$cf_email = sanitize_email($options['lc_mc_contact_form_email']);
	}

	if ("" == $cf_email) {
		$cf_email = get_option("admin_email");
	}
	
	return $cf_email;
}


?>