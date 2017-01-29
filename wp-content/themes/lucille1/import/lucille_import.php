<?php

/*globals*/
require_once(get_template_directory()."/import/lucille_import_globals.php");


/*menu entry*/
require_once(get_template_directory()."/import/import_menu.php");


/*lucille import class*/
require_once(get_template_directory()."/import/class/LC_SWP_Import.php");

/*ajax calls*/
add_action('wp_ajax_LUCILLE_SWP_check_import_data', 'LUCILLE_SWP_check_import_data');
add_action('wp_ajax_LUCILLE_SWP_import_content', 'LUCILLE_SWP_import_content');
add_action('wp_ajax_LUCILLE_SWP_set_static_front_page', 'LUCILLE_SWP_set_static_front_page');
add_action('wp_ajax_LUCILLE_SWP_set_import_theme_settings', 'LUCILLE_SWP_set_import_theme_settings');


/*
	Executed at the beginning of the import process
	Deletes the main page and main menu if exists
*/
function LUCILLE_SWP_check_import_data() {
	$ret['success'] = true;
	$ret['import_error'] = '';

	/*if the main page exists, delete it*/
	$main_demo_page = get_page_by_title('Main Page');
	if (NULL != $main_demo_page) {
		wp_delete_post($main_demo_page->ID, true);	
	}

	/*if the menu exists, delete it*/
	wp_delete_nav_menu("Main Menu");

	echo json_encode($ret);
	wp_die();	
}

/*
	Import content part
*/
function LUCILLE_SWP_import_content() {
	$ret['success'] = true;
	$ret['import_error'] = '';
	
	$import_name = $_POST['demo_import'];
	$import_part = $_POST['import_part'];
	/*input is empty*/
	if ('' == $import_name) {
		$ret['success'] = false;
		$ret['import_error'] = "Import demo name is empty.[".$import_name."]";
		echo json_encode($ret);
		wp_die();
	}
	
	/*create the path to the xml file*/
	$import_file = get_template_directory().'/import/xml/'.$import_name.'/'.$import_part.'.xml';

	/*run importer*/
	$importObj = new LC_SWP_Import();
	$import_status = $importObj->import_content($import_file);


	if ("IMPORT_SUCCESS" != $import_status['status']) {
		$ret['success'] = false;
	}
	$ret['import_error'] = $import_status['message'];	

	
	if (true == $ret['success']) {
		LUCILLE_SWP_set_menu_location("Main Menu", "main-menu");
	}
	
	echo json_encode($ret);
	wp_die();
}

function LUCILLE_SWP_set_static_front_page() {
	global $GLOB_FRONT_PAGES;
	
	$ret['success'] = true;
	$ret['import_error'] = '';
	
	$importName = $_POST['demo_import'];
	
	/* check if array elem exists */
	if (!array_key_exists($importName, $GLOB_FRONT_PAGES)) {
		$ret['import_error'] = 'Incorrect demo import name when setting static front page: '.$importName;
		$ret['success'] = false;
		
		echo json_encode($ret);
		wp_die();
	}
	
	/* Use a static front page */
	$pageObj = get_page_by_title($GLOB_FRONT_PAGES[$importName]);
	update_option('page_on_front', $pageObj->ID);
	update_option('show_on_front', 'page');
	
	echo json_encode($ret);
	wp_die();
}

function LUCILLE_SWP_set_import_theme_settings() {
	global $GLOB_IMPORT_THEME_SETTINGS;
	
	$ret['success'] = true;
	$ret['import_error'] = '';
	
	$importName = $_POST['demo_import'];

	/* check if array elem exists */
	if (!array_key_exists($importName, $GLOB_IMPORT_THEME_SETTINGS)) {
		$ret['import_error'] = 'Incorrect demo import name when setting static front page: '.$importName;
		$ret['success'] = false;
		
		echo json_encode($ret);
		wp_die();
	}
	
	$themeOptionsArray = array();
	$themeOptionsArray = json_decode($GLOB_IMPORT_THEME_SETTINGS[$importName], true);
	
	/*
		Images set as file name, to be able to take the image from the own server
	*/
	if (!empty($themeOptionsArray['lc_custom_logo'])) {
		$themeOptionsArray['lc_custom_logo'] = home_url().$themeOptionsArray['lc_custom_logo'];
	}
	if (!empty($themeOptionsArray['lc_custom_innner_bg_image'])) {
		$themeOptionsArray['lc_custom_innner_bg_image'] = home_url().$themeOptionsArray['lc_custom_innner_bg_image'];;
	}	
	
	update_option('lucille_theme_general_options', $themeOptionsArray);	
	
	/*update theme customizer options*/
	$customizerImportError = LUCILLE_SWP_set_import_theme_customizer($importName);
	if ($customizerImportError != '') {
		$ret['success'] = false;
		$ret['import_error'] = $customizerImportError;
	}
	
	echo json_encode($ret);
	wp_die();	
}

function  LUCILLE_SWP_set_import_theme_customizer($importName) {
	global $GLOB_IMPORT_THEME_CUSTOMIZER;
	
	/* check if array elem exists */
	if (!array_key_exists($importName, $GLOB_IMPORT_THEME_CUSTOMIZER)) {
		return 'Incorrect demo import name when setting customizer options: '.$importName;
	}
	
	$themeCustomizerArray = array();
	$themeCustomizerArray = json_decode($GLOB_IMPORT_THEME_CUSTOMIZER[$importName], true);
	
	update_option('lc_customize', $themeCustomizerArray);

	/*set custom background colors*/
	if ("white" == $importName) {
		 set_theme_mod('background_color', '#eaeaea');
	}

	return '';
}

function LUCILLE_SWP_set_menu_location($menu_name, $menu_location) {
	$menu_object = wp_get_nav_menu_object($menu_name);
	$locations = get_theme_mod('nav_menu_locations');
	$locations[$menu_location] = $menu_object->term_id;

	set_theme_mod('nav_menu_locations', $locations);
}

/*
	enqueue import scripts
*/
function LUCILLE_SWP_enqueue_import() {
	wp_register_script( 'lucille_import_js', get_template_directory_uri(). '/import/js/lucille_import.js', array( 'jquery'), '', true);
	wp_enqueue_script( 'lucille_import_js');
	
	wp_register_style('lucille_import_admin_style', get_template_directory_uri(). '/import/css/import_demo.css');
	wp_enqueue_style('lucille_import_admin_style');
}
add_action('admin_enqueue_scripts', 'LUCILLE_SWP_enqueue_import');

?>