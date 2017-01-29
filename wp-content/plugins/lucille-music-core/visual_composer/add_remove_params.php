<?php
/*
	Add new params to vc row
*/

if (function_exists('vc_add_param'))
{
	vc_add_param( "vc_row", array(
		"type"			=> "colorpicker",
		"class"			=> "",
		"heading"		=> esc_html__("Color Overlay", "lucille-music-core"),
		"param_name"	=> "js_color_overlay",
		"value"			=> "",
		"description"	=> esc_html__("Use a color overlay over the background image", "lucille-music-core")
	));
	
	vc_add_param( "vc_row", array(
		"type"			=> "dropdown",
		"class"			=> "",
		"heading"		=> esc_html__("Color Scheme", "lucille"),
		"param_name"	=> "lc_swp_row_color_scheme",
		"value"			=> array(
						esc_html__("Theme Settings Default", "lucille-music-core")	=> "theme_default",
						esc_html__("White On Black", "lucille-music-core")			=> "white_on_black",
						esc_html__("Black On White", "lucille-music-core")			=> "black_on_white"
						),
		"description"	=> esc_html__("Add a custom color scheme that will overwrite the option in Appearance - Lucille Settings - General. This is an option added by Lucille theme", "lucille-music-core")
	));	
}

?>