<?php

$GLOB_IMPORT_DEMOS = array(
	array(
		'name'	=> 'Creative',
		'import_name'	=> 'creative',
		'img' => 'creative.png'
	),
	array(
		'name'	=> 'Classic',
		'import_name'	=> 'classic',
		'img'=> 'classic.png'
	),
	array(
		'name'	=> 'White',
		'import_name'	=> 'white',
		'img' => 'white.png'
	)
);

/*
	Static front page name for each demo
	'import_name' => 'static front page name'
	'import_name' = xml file name
*/
$GLOB_FRONT_PAGES = array(
	'creative' 	=> 	'Main Page',
	'classic' 	=> 	'Main Page',
	'white' 	=>	'Main Page'
);

/*
	use the image title for: - logo_upload_value
							 - bgimage_upload_value
*/

$GLOB_IMPORT_THEME_SETTINGS = array(
	'creative'	=> '{
			"lc_custom_logo":"/wp-content/uploads/2016/11/logo.png",
			"lc_custom_favicon":"",
			"lc_custom_innner_bg_image":"",
			"lc_menu_style":"creative_menu",
			"lc_header_footer_width":"full",
			"lc_default_color_scheme":"white_on_black",
			"lc_enable_sticky_menu":"enabled",
			"lc_back_to_top":"disabled"
		}',
	'classic'	=> '{
			"lc_custom_logo":"/wp-content/uploads/2016/11/logo-1.png",
			"lc_custom_favicon":"",
			"lc_custom_innner_bg_image":"",
			"lc_menu_style":"classic_menu",
			"lc_header_footer_width":"full",
			"lc_default_color_scheme":"white_on_black",
			"lc_enable_sticky_menu":"enabled",
			"lc_back_to_top":"disabled"
		}',
	'white'	=> '{
			"lc_custom_logo":"/wp-content/uploads/2016/12/logo_black.png",
			"lc_custom_favicon":"",
			"lc_custom_innner_bg_image":"",
			"lc_menu_style":"centered_menu",
			"lc_header_footer_width":"full",
			"lc_default_color_scheme":"black_on_white",
			"lc_enable_sticky_menu":"enabled",
			"lc_back_to_top":"disabled"
		}'
);

if (!isset($lc_customize['lc_second_color'])) {
			$lc_customize['lc_second_color'] = '#18aebf';
		}
		if (!isset($lc_customize['menu_bar_bg_color'])) {
			$lc_customize['menu_bar_bg_color'] = 'rgba(255, 255, 255, 0)';
		}
		if (!isset($lc_customize['menu_sticky_bar_bg_color'])) {
			$lc_customize['menu_sticky_bar_bg_color'] = 'rgba(35, 35, 35, 1)';
		}
		if (!isset($lc_customize['menu_text_color'])) {
			$lc_customize['menu_text_color'] = '#ffffff';
		}
		if (!isset($lc_customize['menu_text_hover_color'])) {
			$lc_customize['menu_text_hover_color'] = '#18aebf';
		}

		if (!isset($lc_customize['submenu_text_color'])) {
			$lc_customize['submenu_text_color'] = '#828282';
		}
		if (!isset($lc_customize['submenu_text_hover_color'])) {
			$lc_customize['submenu_text_hover_color'] = '#d2d2d2';
		}
		if (!isset($lc_customize['submenu_bg_color'])) {
			$lc_customize['submenu_bg_color'] = 'rgba(255, 255, 255, 0)';
		}
		if (!isset($lc_customize['creative_menu_overlay_bg'])) {
			$lc_customize['creative_menu_overlay_bg'] = 'rgba(0, 0, 0, 0.9)';
		}
		if (!isset($lc_customize['creative_icons_color'])) {
			$lc_customize['creative_icons_color'] = '#ffffff';
		}
		if (!isset($lc_customize['menu_mobile_bg_color'])) {
			$lc_customize['menu_mobile_bg_color'] = "rgba(35, 35, 35, 1)";
		}
		if (!isset($lc_customize['mobile_border_bottom_color'])) {
			$lc_customize['mobile_border_bottom_color'] = '#333333';
		}
		if (!isset($lc_customize['current_menu_item_text_color'])) {
			$lc_customize['current_menu_item_text_color'] = '#18aebf';	
		}

$GLOB_IMPORT_THEME_CUSTOMIZER = array(
	'creative'	=>	'{
			"lc_second_color":"#18aebf",
			"menu_bar_bg_color":"rgba(255, 255, 255, 0)",
			"menu_sticky_bar_bg_color":"rgba(35, 35, 35, 1)",
			"menu_text_color":"#ffffff",
			"menu_text_hover_color":"#18aebf",
			"submenu_text_color":"#828282",
			"submenu_text_hover_color":"#d2d2d2",
			"submenu_bg_color":"rgba(255, 255, 255, 0)",
			"creative_menu_overlay_bg":"rgba(0, 0, 0, 0.9)",
			"creative_icons_color":"#ffffff",
			"menu_mobile_bg_color":"rgba(35, 35, 35, 1)",
			"mobile_border_bottom_color":"#333333",
			"current_menu_item_text_color":"#18aebf"
		}',
	'classic'	=>	'{
			"lc_second_color":"#18aebf",
			"menu_bar_bg_color":"rgba(21,21,21,0.35)",
			"menu_sticky_bar_bg_color":"rgba(35, 35, 35, 1)",
			"menu_text_color":"#ffffff",
			"menu_text_hover_color":"#ffffff",
			"submenu_text_color":"#828282",
			"submenu_text_hover_color":"#18aebf",
			"submenu_bg_color":"#252525",
			"creative_menu_overlay_bg":"rgba(0, 0, 0, 0.9)",
			"creative_icons_color":"#ffffff",
			"menu_mobile_bg_color":"rgba(35, 35, 35, 1)",
			"mobile_border_bottom_color":"#333333",
			"current_menu_item_text_color":"#18aebf"
		}',
	'white'	=>	'{
			"lc_second_color":"#f5034a",
			"menu_bar_bg_color":"rgba(255,255,255,0.9)",
			"menu_sticky_bar_bg_color":"#ffffff",
			"menu_text_color":"#000000",
			"menu_text_hover_color":"#f5034a",
			"submenu_text_color":"#0c0c0c",
			"submenu_text_hover_color":"#f5034a",
			"submenu_bg_color":"#ffffff",
			"creative_menu_overlay_bg":"rgba(255,255,255,0.9)",
			"creative_icons_color":"#0c0c0c",
			"menu_mobile_bg_color":"#ffffff",
			"mobile_border_bottom_color":"rgba(51, 51, 51, 1)",
			"current_menu_item_text_color":"#f5034a"
		}'
);

?>