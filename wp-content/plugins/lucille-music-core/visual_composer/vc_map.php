<?php
/*
	Map existing shortcodes to Visual Composer
	Shortcodes already defined in add_shortcodes.php
*/
if (function_exists('vc_map')) {
	/*
		Gallery shortcode - ok
	*/
	if (shortcode_exists('js_swp_gallery')) {
	
		add_action( 'vc_before_init', 'LUCILLE_SWP_map_js_swp_gallery' );
		function LUCILLE_SWP_map_js_swp_gallery() {
			vc_map( array(
				  "name" => esc_html__("Gallery", "lucille-music-core"),
				  "base" => "js_swp_gallery",
				  "class" => "",
				  "category" => esc_html__("Lucille Elements", "lucille-music-core"),
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__( "Row height in pixels", "lucille-music-core"),
						"param_name" => "rowheight",
						"value" => "",
						"description" => esc_html__("Row height in pixels. Digits only. Default value: 180", "lucille-music-core")
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__( "View all text message", "lucille-music-core"),
						"param_name" => "viewallmessage",
						"value" => "",
						"description" => esc_html__("View all text message. If empty, default value is: View All Images", "lucille-music-core")
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__( "Gallery Page URL", "lucille-music-core"),
						"param_name" => "photosurl",
						"value" => "",
						"description" => esc_html__("URL to all Photo Gallery page.", "lucille-music-core")
					),						
					array(
						"type" => "attach_images",
						"class" => "",
						"heading" => esc_html__( "Add images", "lucille-music-core"),
						"param_name" => "images",
						"value" => "",
						"description" => esc_html__("Add your images here", "lucille-music-core")
					)
				  )
			));
		}
	}
	
	/*
		Featured Album Ahortcode - ok
	*/
	if (shortcode_exists('js_swp_last_album')) {
	
		add_action( 'vc_before_init', 'LUCILLE_SWP_map_js_swp_last_album' );
		function LUCILLE_SWP_map_js_swp_last_album() {
			$args = array(
				'numberposts'		=> 	100,
				'posts_per_page'   => 100,
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'post_type'        => 'js_albums',
				'post_status'      => 'publish',
				'suppress_filters' => true
			);
			$album_posts = get_posts($args);
			
			$albums_dropdown = array(); /*key(post_id)	=> value(post_name)*/
			foreach($album_posts as $single_album) {
					$my_post_id = $single_album->ID;
					$my_post_name = $single_album->post_title;
					
					$albums_dropdown[$my_post_name] = $my_post_id;
			}
			wp_reset_postdata();
			
			vc_map( array(
				  "name" => esc_html__("Featured Music Album", "lucille-music-core"),
				  "base" => "js_swp_last_album",
				  "class" => "",
				  "category" => esc_html__("Lucille Elements", "lucille-music-core"),
				  "params" => array(
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__( "Select Album", "lucille-music-core"),
						"param_name" => "album_id",
						"value" => $albums_dropdown,
						"description" => esc_html__("Select The Album You Want To Promote", "lucille-music-core")
					),
					array(
						"type" => "textarea_html",
						"class" => "",
						"heading" => esc_html__( "Short Album Description", "lucille-music-core"),
						"param_name" => "album_promo",
						"value" => '',
						"description" => esc_html__("Please add the album description.", "lucille-music-core")
					)
				  )
			));
		}
	}

	/*
		Latest Albums
	*/
	if (shortcode_exists('js_swp_latest_albums')) {
		add_action( 'vc_before_init', 'LUCILLE_SWP_map_js_swp_latest_albums');
		function LUCILLE_SWP_map_js_swp_latest_albums() {
			vc_map( array(
				  "name" => esc_html__("Latest Music Albums", "lucille-music-core"),
				  "base" => "js_swp_latest_albums",
				  "class" => "",
				  "category" => esc_html__("Lucille Elements", "lucille-music-core"),
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__( "View more text message", "lucille-music-core"),
						"param_name" => "viewallmessage",
						"value" => "",
						"description" => esc_html__("View all text message. If empty, default value is: View More", "lucille-music-core")
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__( "Discography Page URL", "lucille-music-core"),
						"param_name" => "discographypageurl",
						"value" => "",
						"description" => esc_html__("URL to Discography page.", "lucille-music-core")
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__( "Number of Albums To Show", "lucille-music-core"),
						"param_name" => "albumsnumber",
						"value" => "",
						"description" => esc_html__("Number of Albums Displayed. Default value: 3.", "lucille-music-core")
					)					
				  )
			));
		}
	}
	
	/*
		Latest Videos Shortcode - ok
	*/
	if (shortcode_exists('js_swp_last_videos')) {
	
		add_action( 'vc_before_init', 'LUCILLE_SWP_map_js_swp_last_videos' );
		function LUCILLE_SWP_map_js_swp_last_videos() {
			$args = array(
					'numberposts'		=> 	10,
					'posts_per_page'   => 10,
					'category'         => '',
					'orderby'          => 'post_date',
					'order'            => 'DESC',
					'include'          => '',
					'exclude'          => '',
					'meta_key'         => '',
					'meta_value'       => '',
					'post_type'        => 'js_videos',
					'post_mime_type'   => '',
					'post_parent'      => '',
					'post_status'      => 'publish',
					'suppress_filters' => true
				);	
			$video_posts = get_posts($args);
			
			$video_dropdown = array(); /*key(post_id)	=> value(post_name)*/
			foreach($video_posts as $single_video) {
					$my_post_id = $single_video->ID;
					$my_post_name = $single_video->post_title;
					
					$video_dropdown[$my_post_name] = $my_post_id;
			}
			wp_reset_postdata();
			
			vc_map( array(
				  "name" => esc_html__("Featured Video", "lucille-music-core"),
				  "base" => "js_swp_last_videos",
				  "class" => "",
				  "category" => esc_html__("Lucille Elements", "lucille-music-core"),
				  "params" => array(
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__( "Choose Video", "lucille-music-core"),
						"param_name" => "video_id",
						"value" => $video_dropdown,
						"description" => esc_html__("Choose Featured Video", "lucille-music-core")
					)
				  )
			));
		}
	}
	
	/*
		Upcoming Events Shortcode - ok
	*/
	if (shortcode_exists('js_swp_last_events')) {
	
		add_action( 'vc_before_init', 'LUCILLE_SWP_map_js_swp_last_events_shortcode' );
		function LUCILLE_SWP_map_js_swp_last_events_shortcode() {
			vc_map( array(
				  "name" => esc_html__("Next Events", "lucille-music-core"),
				  "base" => "js_swp_last_events",
				  "class" => "",
				  "category" => esc_html__("Lucille Elements", "lucille-music-core"),
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__( "View all text message", "lucille-music-core"),
						"param_name" => "viewallmessage",
						"value" => "",
						"description" => esc_html__("View all text message. If empty, default value is: View All Events", "lucille-music-core")
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__( "Events Page URL", "lucille-music-core"),
						"param_name" => "eventspageurl",
						"value" => "",
						"description" => esc_html__("URL to Events page.", "lucille-music-core")
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__( "Number of Events", "lucille-music-core"),
						"param_name" => "eventsnumber",
						"value" => "",
						"description" => esc_html__("Number of Events Displayed. Default value: 5.", "lucille-music-core")
					)					
				  )
			));
		}
	}
	
	/*
		Contact Form Shortcode - ok
	*/
	if (shortcode_exists('js_swp_ajax_contact_form')) {
	
		add_action( 'vc_before_init', 'LUCILLE_SWP_js_swp_ajax_contact_shortcode' );
		function LUCILLE_SWP_js_swp_ajax_contact_shortcode() {
			vc_map( array(
				  "name" => esc_html__("Ajax Contact Form", "lucille-music-core"),
				  "base" => "js_swp_ajax_contact_form",
				  "class" => "",
				  "category" => esc_html__("Lucille Elements", "lucille-music-core"),
				  "params" => array(
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__( "Input Styling", "lucille-music-core"),
						"param_name" => "input_styling",
						"value" =>  array( 
										"One on Row" => "one_on_row",
										"Three on Row" => "three_on_row"
									),
						"description" => esc_html__("Choose how to render the input fields", "lucille-music-core")
					)
				  )
			));
		}
	}
	
	/*
		Section Heading - ok
	*/
	if (shortcode_exists('js_swp_row_heading')) {
	
		add_action( 'vc_before_init', 'LUCILLE_SWP_js_swp_row_heading_shortcode' );

		function LUCILLE_SWP_js_swp_row_heading_shortcode() {
			vc_map( array(
				  "name" => esc_html__("Section Heading", "lucille-music-core"),
				  "base" => "js_swp_row_heading",
				  "class" => "",
				  "category" => esc_html__("Lucille Elements", "lucille-music-core"),
				  "params" => array(
					array(
						"type" => "textarea_raw_html",
						"class" => "",
						"heading" => esc_html__( "Title", "lucille-music-core"),
						"param_name" => "title",
						"value" => "",
						"description" => esc_html__("Section title - use &lt;span class=&quot;lc_vibrant_color&quot;&gt;some colored text&lt;/span&gt; to color one or more words in vibrant color.", "lucille-music-core")
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__( "Title transform" ),
						"param_name" => "title_transform",
						"value" => array(
							"No transform"	=> "no_transform",
							"Uppercase"		=> "text_uppercase"
						),
						"description" => esc_html__("Make section title uppercase", "lucille-music-core")
					),
					array(
						"type" => "textarea_raw_html",
						"class" => "",
						"heading" => esc_html__( "Subtitle", "lucille-music-core"),
						"param_name" => "subtitle",
						"value" => "",
						"description" => esc_html__("Section subtitle (optional) - use &lt;span class=&quot;lc_vibrant_color&quot;&gt;some colored text&lt;/span&gt; to color one or more words in vibrant color.", "lucille-music-core")
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__( "Subtitle transform", "lucille-music-core"),
						"param_name" => "subtitle_transform",
						"value" => array(
							"No transform"	=> "no_transform",
							"Uppercase"		=> "text_uppercase"
						),
						"description" => esc_html__("Make section subtitle uppercase", "lucille-music-core")
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__( "Text align", "lucille-music-core"),
						"param_name" => "text_align",
						"value" => array(
							"Center"	=> "text_center",
							"Left"		=> "text_left",
							"Rigth"		=> "text_right"
						),
						"description" => esc_html__("Make section subtitle uppercase", "lucille-music-core")
					)
				  )
			));
		}
	}
	
	/*
		Lucille Button - ok
	*/
	if (shortcode_exists('js_swp_theme_button')) {
	
		add_action( 'vc_before_init', 'LUCILLE_SWP_js_swp_theme_button_map' );
		function LUCILLE_SWP_js_swp_theme_button_map() {
			vc_map( array(
				  "name" => esc_html__("Lucille Button", "lucille-music-core"),
				  "base" => "js_swp_theme_button",
				  "class" => "",
				  "category" => esc_html__("Lucille Elements", "lucille-music-core"),
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__( "Button Text", "lucille-music-core"),
						"param_name" => "button_text",
						"value" => "",
						"description" => esc_html__("Text shown on Button", "lucille-music-core")
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__( "Button URL", "lucille-music-core"),
						"param_name" => "button_url",
						"value" => "",
						"description" => esc_html__("URL for this button", "lucille-music-core")
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__( "Button Align", "lucille-music-core"),
						"param_name" => "button_align",
						"value"		=> array( 
										"Left" => "button_left",
										"Center" => "button_center",
										"Right" => "button_right"
									),
						"description" => esc_html__("Button alignment", "lucille-music-core")
					)
				  )
			));
		}
	}

	/*
		User Review - ok
	*/
	if (shortcode_exists('lc_swp_user_review')) {
		add_action( 'vc_before_init', 'LUCILLE_SWP_lc_swp_user_review_map' );
		function LUCILLE_SWP_lc_swp_user_review_map()
		{
			vc_map(array(
				  "name" => esc_html__("User Review", "lucille-music-core"),
				  "base" => "lc_swp_user_review",
				   "content_element" => true,
				  "class" => "",
				  "as_child" => array('only' => 'lc_review_slider'),
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__("Reviewer Name", "lucille-music-core"),
						"param_name" => "reviewer_name",
						"value" => "",
						"description" => esc_html__("Reviewer Name", "lucille-music-core")
					),
					array(
						"type" => "attach_image",
						"class" => "",
						"heading" => esc_html__( "Reviewer Image", "lucille-music-core"),
						"param_name" => "reviewer_image",
						"value" => "",
						"description" => esc_html__("Image for the review author", "lucille-music-core")
					),
					array(
						"type" => "textarea",
						"class" => "",
						"heading" => esc_html__( "Review Content", "lucille-music-core"),
						"param_name" => "review_content",
						"value"		=> "",
						"description" => esc_html__("Review Content", "lucille-music-core")
					)
				  )
			));
		}
	}
	
	if (shortcode_exists('lc_review_slider')) {
		add_action( 'vc_before_init', 'LUCILLE_SWP_lc_review_slider_map' );
		function LUCILLE_SWP_lc_review_slider_map()
		{
			vc_map( array(
				"name" => esc_html__("User Reviews Slider", "lucille-music-core"),
				"base" => "lc_review_slider",
				"category" => esc_html__("Lucille Elements", "lucille-music-core"),
				"as_parent" => array('only' => 'lc_swp_user_review'), /* Use only|except attributes to limit child shortcodes (separate multiple values with comma)*/
				"content_element" => true,
				"show_settings_on_create" => false,
				"is_container" => true,
				"js_view" => 'VcColumnView'
			));
		}
		
		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			class WPBakeryShortCode_lc_review_slider extends WPBakeryShortCodesContainer {
			}
		}
	}

	/*
		Blog Shortcode - ok
	*/
	if (shortcode_exists('js_swp_blog_shortcode')) {
		add_action( 'vc_before_init', 'LUCILLE_SWP_blog_shortcode_map' );
		function LUCILLE_SWP_blog_shortcode_map()
		{
			vc_map(array(
				  "name" => esc_html__("Blog Posts", "lucille-music-core"),
				  "base" => "js_swp_blog_shortcode",
				  "class" => "",
				  "category" => esc_html__("Lucille Elements", "lucille-music-core"),
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__("Number Of Oosts", "lucille-music-core"),
						"param_name" => "postsnumber",
						"value" => "",
						"description" => esc_html__("Number of posts to show. Default value: 3", "lucille-music-core")
					)
				  )
			));
		}
	}

	/*
		Social Profiles Shortcode - ok
	*/
	if (shortcode_exists('js_swp_social_profiles_icons')) {
		add_action( 'vc_before_init', 'LUCILLE_SWP_social_profiles_shortcode_map' );
		function LUCILLE_SWP_social_profiles_shortcode_map() {
			vc_map(array(
				  "name" => esc_html__("Social Profiles", "lucille-music-core"),
				  "base" => "js_swp_social_profiles_icons",
				  "class" => "",
				  "category" => esc_html__("Lucille Elements", "lucille-music-core"),
				  "params" => array(
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__( "Align Icons", "lucille-music-core"),
						"param_name" => "center_icons",
						"value" =>  array( 
							"Center" => "text_center",
							"Left" => "text_left",
							"Right" => "text_right",
						),
						"description" => esc_html__("Align icons center, left or right. Icons are selected automatically for the social networks filled in Lucille Settings - Social Options.", "lucille-music-core")
					)
				  )
			));
		}
	}	


} /*function_exists('vc_map')*/

?>