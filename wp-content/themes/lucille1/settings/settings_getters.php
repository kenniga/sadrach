<?php

function LUCILLE_SWP_get_inner_bg_image() {
	return LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_custom_innner_bg_image');
}

function LUCILLE_SWP_get_user_logo_img() {
	return LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_custom_logo');
}

function LUCILLE_SWP_get_user_favicon() {
	return LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_custom_favicon');
}

function LUCILLE_SWP_get_menu_style() {
	$menu_style = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_menu_style');

	/*cannot return empty value*/
	if (empty($menu_style)) {
		$menu_style = 'creative_menu';
	}

	return $menu_style;
}

function LUCILLE_SWP_get_header_footer_width() {
	$header_width = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_header_footer_width');

	/*cannot return empty value*/
	if (empty($header_width)) {
		$header_width = 'full';
	}

	return $header_width;
}

function LUCILLE_SWP_get_default_color_scheme() {
	$color_scheme = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_default_color_scheme');
	if (!empty($color_scheme)) {
		return $color_scheme;
	}

	return  'white_on_black';
}

function LUCILLE_SWP_is_sticky_menu() {
	$sticky_menu = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_enable_sticky_menu');

	if (empty($sticky_menu) || ("enabled" == $sticky_menu)) {
		return true;
	}

	return false;
}

function LUCILLE_SWP_is_back_to_top_enabled() {
	$back_to_top = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_back_to_top');

	if (empty($back_to_top) || ("disabled" == $back_to_top)) {
		return false;
	}

	return true;
}

function LUCILLE_SWP_show_search_on_menu() {
	$hide_icon = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_hide_search_icon');

	if (empty($hide_icon)) {
		return true;
	}

	return "enabled" == $hide_icon ? false : true;
}

function LUCILLE_SWP_show_event_title() {
	$show_event_title = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_show_title_event_list');

	if (empty($show_event_title)) {
		return false;
	}

	return "enabled" == $show_event_title ? true : false;
}

function LUCILLE_SWP_get_available_social_profiles() {
	$user_profiles = array();

	$available_profiles = array(
		/*'icon name'	=> 'settings name'*/
		'facebook'		=> 'lc_fb_url',	
		'twitter'		=>'lc_twitter_url',	
		'google-plus'	=>'lc_gplus_url',	
		'youtube'		=>'lc_youtube_url',	
		'soundcloud'	=>'lc_soundcloud_url',	
	/*	'myspace'		=>'lc_myspace_url',	*/
		'apple'			=>'lc_itunes_url',	
		'pinterest'		=>'lc_pinterest_url',
		'instagram'		=> 'lc_instagram_url',
		'snapchat-ghost'=> 'lc_snapchat_url',
		'play'			=> 'lc_gplay_url'
	);

	foreach ($available_profiles as $key =>	$profile) {
		$profile_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', $profile);

		if (!empty($profile_url)) {
			$single_profile = array();
			$single_profile['url'] 	= $profile_url;
			$single_profile['icon'] 	= $key;

			$user_profiles[] = $single_profile;
		}
	}

	return $user_profiles;
}

/*getters for footer options*/
function LUCILLE_SWP_get_footer_color_scheme() {
	$footer_color_scheme = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_footer_widgets_color_scheme');
	
	if (!empty($footer_color_scheme)) {
		return $footer_color_scheme;
	}

	return 'white_on_black';
}

function LUCILLE_SWP_get_footer_bg_image() {
	return LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_footer_widgets_background_image');
}

function LUCILLE_SWP_get_footer_bg_color() {
	$footer_background_color = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_footer_widgets_background_color');
	
	if (!empty($footer_background_color)) {
		return $footer_background_color;
	}

	return 'rgba(19, 19, 19, 1)';
}

function LUCILLE_SWP_get_copyrigth_text() {
	return esc_html(LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_text'));
}

function LUCILLE_SWP_get_copyrigth_url() {
	return esc_url_raw(LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_url'));
}
/*
function LUCILLE_SWP_get_analytics_code() {
	return esc_html(LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_analytics_code'));
}
*/
function LUCILLE_SWP_get_copyright_bgc() {
	$copy_bgc = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_text_bg_color');
	if (!empty($copy_bgc)) {
		return $copy_bgc;
	}

	return 'rgba(29, 29, 29, 1)';
}

function LUCILLE_SWP_get_copyrigth_color_scheme() {
	$copy_color_scheme = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_text_color');
	if (!empty($copy_color_scheme)) {
		return $copy_color_scheme;
	}

	return 'white_on_black';
}

function LUCILLE_SWP_get_post_bg_image($post_id) {
	return get_post_meta($post_id, 'js_swp_meta_bg_image', true);
}

function LUCILLE_SWP_get_post_overlay_color($post_id) {
	return get_post_meta($post_id, 'lc_swp_meta_page_overlay_color', true);
}

function LUCILLE_SWP_get_contact_address() 
{
	return esc_html(LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_address'));
}

function LUCILLE_SWP_get_contact_email() 
{
	return sanitize_email(LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_email'));
}

function LUCILLE_SWP_get_contact_phone() 
{
	return esc_html(LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_phone'));
}

function LUCILLE_SWP_get_contact_fax() 
{
	return esc_html(LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_fax'));
}

?>