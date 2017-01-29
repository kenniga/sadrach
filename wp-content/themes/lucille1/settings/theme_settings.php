<?php

define("LC_SWP_PRINT_SETTINGS", false);

function LUCILLE_SWP_setup_admin_menus()
{

	add_theme_page(
        'Lucille Theme Settings', /* page title*/
		'Lucille Settings',  /* menu title */
		'administrator',    /*capability*/
        'lucille_menu_page',  /*menu_slug*/
		'LUCILLE_SWP_option_page_settings'  /*function */
		);		
}
add_action("admin_menu", "LUCILLE_SWP_setup_admin_menus");


function LUCILLE_SWP_option_page_settings()
{
?>  
	<!-- Create a header in the default WordPress 'wrap' container -->  
    <div class="wrap">  
        <div id="icon-themes" class="icon32"></div>  
        <h2>Lucille Theme Settings</h2>  
  
        <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->  
        <?php settings_errors(); ?> 
		
		<?php  
		if(isset($_GET['tab'])) {
			$active_tab = $_GET['tab'];  
		} else {
		    $active_tab = 'general_options';
		}
		?>  		
		
		<h2 class="nav-tab-wrapper">
			<?php
				$general_options_class = $active_tab == 'general_options' ? 'nav-tab-active' : '';
				$social_options_class = $active_tab == 'social_options' ? 'nav-tab-active' : '';
				$footer_options_class = $active_tab == 'footer_options' ? 'nav-tab-active' : '';
				$contact_options_class = $active_tab == 'contact_options' ? 'nav-tab-active' : '';
			?>
			<a href="?page=lucille_menu_page&tab=general_options" class="nav-tab <?php echo esc_attr($general_options_class); ?>">General Options</a>
			<a href="?page=lucille_menu_page&tab=social_options" class="nav-tab <?php echo esc_attr($social_options_class); ?>">Social Options</a>  
			<a href="?page=lucille_menu_page&tab=footer_options" class="nav-tab <?php echo esc_attr($footer_options_class); ?>">Footer Options</a>  
			<a href="?page=lucille_menu_page&tab=contact_options" class="nav-tab <?php echo esc_attr($contact_options_class); ?>">Contact Data</a>  
		</h2> 		
  
        <!-- Create the form that will be used to render our options -->  
        <form method="post" action="options.php"> 
			<?php
				if ($active_tab == 'general_options') {
					settings_fields( 'lucille_theme_general_options'); 
					do_settings_sections( 'lucille_theme_general_options');
				} elseif ($active_tab == 'social_options') {
					settings_fields( 'lucille_theme_social_options'); 
					do_settings_sections( 'lucille_theme_social_options');
				} elseif ($active_tab == 'footer_options') {
					settings_fields( 'lucille_theme_footer_options'); 
					do_settings_sections( 'lucille_theme_footer_options');
				} elseif ($active_tab == 'contact_options') {
					settings_fields( 'lucille_theme_contact_options'); 
					do_settings_sections( 'lucille_theme_contact_options');
				}
				submit_button(); 
			?>  
        </form>  
  
    </div><!-- /.wrap -->  
<?php 
}



/*
	Initialize theme options
*/
add_action('admin_init', 'LUCILLE_SWP_initialize_theme_options');
function LUCILLE_SWP_initialize_theme_options() 
{
	$lc_swp_available_theme_options = array (
		array (
			'option_name'		=> 'lucille_theme_general_options',
			'section_id'		=> 'lucille_general_settings_section',
			'title'				=> esc_html__('General Options', 'lucille'),
			'callback'			=> 'LUCILLE_SWP_general_options_callback',
			'sanitize_callback'	=> 'LUCILLE_SWP_sanitize_general_options'
		),
		array (
			'option_name'		=> 'lucille_theme_social_options',
			'section_id'		=> 'lucille_social_settings_section',
			'title'				=> esc_html__('Social Options', 'lucille'),
			'callback'			=> 'LUCILLE_SWP_social_options_callback',
			'sanitize_callback'	=> 'LUCILLE_SWP_sanitize_social_options'
		),
		array (
			'option_name'		=> 'lucille_theme_footer_options',
			'section_id'		=> 'lucille_footer_settings_section',
			'title'				=> esc_html__('Footer Options', 'lucille'),
			'callback'			=> 'LUCILLE_SWP_footer_options_callback',
			'sanitize_callback'	=> 'LUCILLE_SWP_sanitize_footer_options'
		),
		array (
			'option_name'		=> 'lucille_theme_contact_options',
			'section_id'		=> 'lucille_contact_settings_section',
			'title'				=> esc_html__('Contact Options', 'lucille'),
			'callback'			=> 'LUCILLE_SWP_contact_options_callback',
			'sanitize_callback'	=> 'LUCILLE_SWP_sanitize_contact_options'
		)
	);

	foreach($lc_swp_available_theme_options as $theme_option) {
		/*
			Add available options
		*/
		if (false == get_option($theme_option['option_name'])) {
			add_option($theme_option['option_name']);
		}

		/*
			Add setting sections
		*/
		add_settings_section (
			$theme_option['section_id'],		// ID used to identify this section and with which to register options
			$theme_option['title'],				// Title to be displayed on the administration page
			$theme_option['callback'],			// Callback used to render the description of the section
			$theme_option['option_name']		// Page on which to add this section of options
		);
	}

	/*
		call add_settings_field to add theme options
	*/
	LUCILLE_SWP_add_settings_fields();

	/*
		Register settings
	*/
	foreach($lc_swp_available_theme_options as $theme_option) {
		register_setting(
			//option group - A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
			$theme_option['option_name'],
			// option_name -  The name of an option to sanitize and save. 
			$theme_option['option_name'],
			//  $sanitize_callback (callback) (optional) A callback function that sanitizes the option's value
			$theme_option['sanitize_callback']  	
		);
	}
}

/*
	Callbacks that render the description for each tab
*/
function LUCILLE_SWP_general_options_callback() {
?>
	<p>
		<?php echo esc_html__('Setup custom logo and favicon.', 'lucille'); ?>
	</p>
<?php	
	/*print theme settings*/
	if (LC_SWP_PRINT_SETTINGS) {
		$general = get_option('lucille_theme_general_options');
		
		?>
		<pre>lucille_theme_general_options:
			<?php echo (json_encode($general)); ?>
		</pre>
		<?php
	}
}
 
function LUCILLE_SWP_social_options_callback() {
	?>
	<p>
		<?php echo esc_html__('Provide the URL to the social profiles you would like to display.', 'lucille'); ?>
	</p>
	<?php	
}

function LUCILLE_SWP_footer_options_callback() {
	?>
	<p>
		<?php echo esc_html__('Setup footer text for the copyright area, footer text URL and analytics code. Also setup the footer widget area.', 'lucille'); ?>
	</p>
	<?php
}

function LUCILLE_SWP_contact_options_callback() {
	?>
	<p>
		<?php echo esc_html__('Please insert your contact information.', 'lucille'); ?>
	</p>
	<?php
}


/*
	Add setting fields
*/
function LUCILLE_SWP_add_settings_fields() {
	/*general options array*/
	$general_settings = array (
		array (
			'id'		=> 'lc_custom_logo',
			'label'		=> esc_html__('Upload logo image', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_logo_select_cbk'
		),
		array (
			'id'		=> 'lc_custom_favicon',
			'label'		=> esc_html__('Upload custom favicon', 'lucille'),
			'callback'	=> 'Lucille_SWP_favicon_select_cbk'
		),
		array (
			'id'		=> 'lc_custom_innner_bg_image',
			'label'		=> esc_html__('Upload custom background image', 'lucille'),
			'callback'	=> 'Lucille_SWP_innner_bg_image_select_cbk'
		),
		array (
			'id'		=> 'lc_menu_style',
			'label'		=> esc_html__('Choose menu style', 'lucille'),
			'callback'	=> 'Lucille_SWP_menu_style_cbk'
		),
		array (
			'id'		=> 'lc_header_footer_width',
			'label'		=> esc_html__('Choose header/footer width', 'lucille'),
			'callback'	=> 'Lucille_SWP_header_footer_width_cbk'
		),
		array (
			'id'		=> 'lc_default_color_scheme',
			'label'		=> esc_html__('Choose default color scheme', 'lucille'),
			'callback'	=> 'Lucille_SWP_default_colorscheme_cbk'
		),
		array (
			'id'		=> 'lc_enable_sticky_menu',
			'label'		=> esc_html__('Enable sticky menu', 'lucille'),
			'callback'	=> 'Lucille_SWP_enable_sticky_menu_cbk'
		),
		array (
			'id'		=> 'lc_back_to_top',
			'label'		=> esc_html__('Enable back to top button', 'lucille'),
			'callback'	=> 'Lucille_SWP_back_to_top_cbk'
		),
		array (
			'id'		=> 'lc_hide_search_icon',
			'label'		=> esc_html__('Hide search icon', 'lucille'),
			'callback'	=> 'Lucille_SWP_hide_search_icon_cbk'
		),
		array (
			'id'		=> 'lc_show_title_event_list',
			'label'		=> esc_html__('Show event title on list', 'lucille'),
			'callback'	=> 'Lucille_SWP_show_title_event_list_cbk'
		)		
	);

	foreach($general_settings as $general_setting) {
	    add_settings_field(   
	        $general_setting['id'],         		// ID used to identify the field throughout the theme                
	        $general_setting['label'],              // The label to the left of the option interface element            
	        $general_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'lucille_theme_general_options',   		// The page on which this option will be displayed  
	        'lucille_general_settings_section'    	// The name of the section to which this field belongs  
	    );
	}

	/*social options array*/
	$social_settings = array(
		array (
			'id'		=> 'lc_fb_url',
			'label'		=> esc_html__('Facebook URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_fb_url_cbk'			
		),
		array (
			'id'		=> 'lc_twitter_url',
			'label'		=> esc_html__('Twitter URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_twitter_url_cbk'			
		),
		/*Google+, YouTube, Vimeo, SoundCloud, Myspace, Pinterest, iTunes*/
		array (
			'id'		=> 'lc_gplus_url',
			'label'		=> esc_html__('Google+ URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_gplus_url_cbk'			
		),
		array (
			'id'		=> 'lc_youtube_url',
			'label'		=> esc_html__('YouTube URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_youtube_url_cbk'			
		),
		array (
			'id'		=> 'lc_soundcloud_url',
			'label'		=> esc_html__('SoundCloud URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_soundcloud_url_cbk'			
		),
		/*no font awesome icon for myspace*/
		array (
			'id'		=> 'lc_itunes_url',
			'label'		=> esc_html__('iTunes URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_itunes_url_cbk'			
		),
		array (
			'id'		=> 'lc_pinterest_url',
			'label'		=> esc_html__('Pinterest URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_pinterest_url_cbk'			
		),
		array (
			'id'		=> 'lc_instagram_url',
			'label'		=> esc_html__('Instagram URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_instagram_url_cbk'			
		),
		array (
			'id'		=> 'lc_snapchat_url',
			'label'		=> esc_html__('Snapchat URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_snapchat_url_cbk'			
		),
		array (
			'id'		=> 'lc_gplay_url',
			'label'		=> esc_html__('Google Play URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_gplay_url_cbk'			
		)
	);

	foreach($social_settings as $social_setting) {
	    add_settings_field(   
	        $social_setting['id'],         		// ID used to identify the field throughout the theme                
	        $social_setting['label'],              // The label to the left of the option interface element            
	        $social_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'lucille_theme_social_options',   		// The page on which this option will be displayed  
	        'lucille_social_settings_section'    	// The name of the section to which this field belongs  
	    );
	}

	/*footer options array*/
	$footer_settings = array(
		array(
			'id'		=> 'lc_footer_widgets_color_scheme',
			'label'		=> esc_html__('Footer widgets color scheme', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_footer_widget_cs_cbk'		
		),
		array(
			'id'		=> 'lc_footer_widgets_background_image',
			'label'		=> esc_html__('Footer widgets Background Image', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_footer_widget_bgimg_cbk'		
		),
		array(
			'id'		=> 'lc_footer_widgets_background_color',
			'label'		=> esc_html__('Footer widgets color overlay', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_footer_widget_bgcolor_cbk'		
		),		
		array(
			'id'		=> 'lc_copyright_text',
			'label'		=> esc_html__('Copyright text', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_copyright_text_cbk'		
		),
		array(
			'id'		=> 'lc_copyright_url',
			'label'		=> esc_html__('Copyrigth URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_copyright_url_cbk'		
		),
		array(
			'id'		=> 'lc_copyright_text_color',
			'label'		=> esc_html__('Copyrigth Text Color Scheme', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_copyright_cs_cbk'		
		),
		array(
			'id'		=> 'lc_copyright_text_bg_color',
			'label'		=> esc_html__('Copyrigth Text Background Color', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_copyright_bgc_cbk'		
		)
	);
	foreach($footer_settings as $footer_setting) {
	    add_settings_field(   
	        $footer_setting['id'],         		// ID used to identify the field throughout the theme                
	        $footer_setting['label'],              // The label to the left of the option interface element            
	        $footer_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'lucille_theme_footer_options',   		// The page on which this option will be displayed  
	        'lucille_footer_settings_section'    	// The name of the section to which this field belongs  
	    );
	}

	/*contact options array*/
	$contact_settings = array(
		array(
			'id'		=> 'lc_contact_address',
			'label'		=> esc_html__('Contact address', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_lc_contact_address_cbk'		
		),
		array(
			'id'		=> 'lc_contact_phone',
			'label'		=> esc_html__('Contact phones', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_lc_contact_phone_cbk'		
		),
		array(
			'id'		=> 'lc_contact_fax',
			'label'		=> esc_html__('Contact Fax Number', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_lc_contact_fax_cbk'		
		),
		array(
			'id'		=> 'lc_contact_email',
			'label'		=> esc_html__('Contact E-mail', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_lc_contact_email_cbk'		
		)	
	);

	foreach($contact_settings as $contact_setting) {
	    add_settings_field(   
	        $contact_setting['id'],         		// ID used to identify the field throughout the theme                
	        $contact_setting['label'],              // The label to the left of the option interface element            
	        $contact_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'lucille_theme_contact_options',   		// The page on which this option will be displayed  
	        'lucille_contact_settings_section'    	// The name of the section to which this field belongs  
	    );
	}	
}

/*
	Sanitize Functions
*/
function  LUCILLE_SWP_sanitize_general_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			if (($key == 'lc_custom_favicon') || 
				($key == 'lc_custom_logo')) {
				$output[$key] = esc_url_raw(trim( $input[$key] ) );
			} else {
				$output[$key] =  esc_html(trim($input[$key])) ;	
			}
		}
	}

	return apply_filters('LUCILLE_SWP_sanitize_general_options', $output, $input);
}

function LUCILLE_SWP_sanitize_social_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			$output[$key] =  esc_url_raw(trim($input[$key])) ;
		}
	}

	return apply_filters('LUCILLE_SWP_sanitize_social_options', $output, $input);
}

function LUCILLE_SWP_sanitize_footer_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			switch($key) {
				case 'lc_copyright_url':
				case 'lc_footer_widgets_background_image':
					$output[$key] =  esc_url_raw(trim($input[$key]));
					break;
				default:
					$output[$key] =  esc_html(trim($input[$key]));
					break;
			}
		}
	}

	return apply_filters('LUCILLE_SWP_sanitize_footer_options', $output, $input);
}

function LUCILLE_SWP_sanitize_contact_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			if ($key == 'lc_contact_email') {
				$output[$key] = sanitize_email(trim($input[$key]));	
			} else {
				$output[$key] =  esc_html(trim($input[$key]));	
			}
		}
	}

	return apply_filters('LUCILLE_SWP_sanitize_contact_options', $output, $input);
}

/*
	CALLBACKS FOR SETTINGS FIELDS
*/
function LUCILLE_SWP_logo_select_cbk() {
	$logo_url = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_custom_logo');

?>
	<input id="lc_swp_logo_upload_value" type="text" name="lucille_theme_general_options[lc_custom_logo]" size="150" value="<?php echo esc_url($logo_url); ?>"/>
	<input id="lc_swp_upload_logo_button" type="button" class="button" value="<?php echo esc_html__('Upload Logo', 'lucille'); ?>" />
	<input id="lc_swp_remove_logo_button" type="button" class="button" value="<?php echo esc_html__('Remove Logo', 'lucille'); ?>" />
	<p class="description">
		<?php echo esc_html__('Upload a custom logo image.', 'lucille'); ?>
	</p>

	<div id="lc_logo_image_preview">
		<img class="lc_swp_setting_preview_logo" src="<?php echo esc_url($logo_url); ?>">
	</div>

<?php
}

function Lucille_SWP_favicon_select_cbk() {
	$favicon_url = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_custom_favicon');

	if (function_exists('wp_site_icon')) {
?>
	<p class="description notice notice-success">
		<?php echo esc_html__('Hi, your WordPress version is higher than 4.3 and allows you to use the built in WordPress functionality related to custom favicon.', 'lucille'); ?>
		<br>
		<?php echo esc_html__('Please go to Appearance - Customize - Site Identity and choose the favicon from that place.', 'lucille'); ?>
		<br>
		<?php echo esc_html__('For your WordPress version, the Upload custom favicon option will be ignored, the one from customizer will be used.', 'lucille'); ?>
		<br>
		<?php echo esc_html__('This option exists only for backward compatibility reasons.', 'lucille'); ?>
	</p>
<?php
	}
?>

	<input id="lc_swp_favicon_upload_value" type="text" name="lucille_theme_general_options[lc_custom_favicon]" size="150" value="<?php echo esc_url($favicon_url); ?>"/>
	<input id="lc_swp_upload_favicon_button" type="button" class="button" value="<?php echo esc_html__('Upload Favicon', 'lucille'); ?>" />
	<input id="lc_swp_remove_favicon_button" type="button" class="button" value="<?php echo esc_html__('Remove Favicon', 'lucille'); ?>" />
	<p class="description">
		<?php echo esc_html__('Upload a custom favicon image.', 'lucille'); ?>
	</p>

	<div id="lc_favicon_image_preview">
		<img class="lc_swp_setting_preview_favicon" src="<?php echo esc_url($favicon_url); ?>">
	</div>
<?php
}

function Lucille_SWP_innner_bg_image_select_cbk() {
	$inner_bg_img_url = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_custom_innner_bg_image');
?>

	<input id="lc_swp_innner_bg_image_upload_value" type="text" name="lucille_theme_general_options[lc_custom_innner_bg_image]" size="150" value="<?php echo esc_url($inner_bg_img_url); ?>"/>
	<input id="lc_swp_upload_innner_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Upload Image', 'lucille'); ?>" />
	<input id="lc_swp_remove_innner_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Remove Image', 'lucille'); ?>" />
	<p class="description">
		<?php echo esc_html__('Upload a custom background image for inner pages.', 'lucille'); ?>
	</p>

	<div id="lc_innner_bg_image_preview">
		<img class="lc_swp_setting_preview_favicon" src="<?php echo esc_url($inner_bg_img_url); ?>">
	</div>	
<?php	
}

function Lucille_SWP_menu_style_cbk() {
	$menu_style = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_menu_style');
	if (empty($menu_style)) {
		$menu_style = 'creative_menu';
	}

	$menu_options = array(
		esc_html__('Creative Menu', 'lucille')	=> 'creative_menu',
		esc_html__('Classic Menu', 'lucille')	=> 'classic_menu',		
		esc_html__('Centered Menu', 'lucille')	=> 'centered_menu'
	);
?>

	<select id="lc_menu_style" name="lucille_theme_general_options[lc_menu_style]">
		<?php LUCILLE_SWP_render_select_options($menu_options, $menu_style); ?>
	</select>
<?php	
}

function Lucille_SWP_header_footer_width_cbk() {
	$header_width = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_header_footer_width');
	if (empty($header_width)) {
		$header_width = 'full';
	}

	$width_options = array(
		'Full Width'	=> 'full',
		'Boxed Width'	=> 'boxed'
	);
?>
	<select id="lc_header_footer_width" name="lucille_theme_general_options[lc_header_footer_width]">
		<?php LUCILLE_SWP_render_select_options($width_options, $header_width); ?>
	</select>
<?php
}

function Lucille_SWP_default_colorscheme_cbk() {
	$color_scheme = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_default_color_scheme');
	if (empty($color_scheme)) {
		$color_scheme = 'white_on_black';
	}

	$color_schemes = array(
		esc_html__('White On Black', 'lucille')	=> 'white_on_black',
		esc_html__('Black on White', 'lucille')	=> 'black_on_white'
	);
?>

	<select id="lc_default_color_scheme" name="lucille_theme_general_options[lc_default_color_scheme]">
		<?php LUCILLE_SWP_render_select_options($color_schemes, $color_scheme); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Default color scheme used for the website content.', 'lucille').'<br>'; ?>
		<?php echo esc_html__('Black On White - black text on white background.', 'lucille'); ?>
		<?php echo esc_html__('White On Black - white text on black background.', 'lucille').'<br>'; ?>
		<?php echo esc_html__('If you change this value, you might need to change the background color or image for your website according to the color scheme.', 'lucille'); ?>
		<?php echo esc_html__('You can change the background color for your website from Appearance - Customize - Colors.', 'lucille'); ?>
	</p>
<?php	
}

function LUCILLE_SWP_enable_sticky_menu_cbk() {
	$sticky_menu = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_enable_sticky_menu');

	if (empty($sticky_menu)) {
		$sticky_menu = 'enabled';
	}

	$sticky_options = array(
		esc_html__('Enabled', 'lucille')	=> 'enabled',
		esc_html__('Disabled', 'lucille')	=> 'disabled'
	);
?>
	<select id="lc_enable_sticky_menu" name="lucille_theme_general_options[lc_enable_sticky_menu]">
		<?php LUCILLE_SWP_render_select_options($sticky_options, $sticky_menu); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Enable or disable sticky menu bar. If enabled, menu will stay on top whyle the user moves the scrollbar.', 'lucille'); ?>
	</p>
<?php
}


function Lucille_SWP_back_to_top_cbk() {
	$back_to_top = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_back_to_top');

	if (empty($back_to_top)) {
		$back_to_top = 'disabled';
	}

	$sticky_options = array(
		esc_html__('Enabled', 'lucille')	=> 'enabled',
		esc_html__('Disabled', 'lucille')	=> 'disabled'
	);
?>
	<select id="lc_back_to_top" name="lucille_theme_general_options[lc_back_to_top]">
		<?php LUCILLE_SWP_render_select_options($sticky_options, $back_to_top); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Enable or disable back to top button.', 'lucille'); ?>
	</p>
<?php
}

function Lucille_SWP_hide_search_icon_cbk() {
	$hide_icon = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_hide_search_icon');

	if (empty($hide_icon)) {
		$hide_icon = 'disabled';
	}

	$hide_options = array(
		esc_html__('Enabled - Hide Icon', 'lucille')	=> 'enabled',
		esc_html__('Disabled - Keep Icon', 'lucille')	=> 'disabled'
	);
?>
	<select id="lc_hide_search_icon" name="lucille_theme_general_options[lc_hide_search_icon]">
		<?php LUCILLE_SWP_render_select_options($hide_options, $hide_icon); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Hide search icon on menu.', 'lucille'); ?>
	</p>
<?php
}

function Lucille_SWP_show_title_event_list_cbk() {
	$show_event_title = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_show_title_event_list');

	if (empty($show_event_title)) {
		$show_event_title = 'disabled';
	}

	$show_title_options = array(
		esc_html__('Enabled - Show Event Title', 'lucille')	=> 'enabled',
		esc_html__('Disabled - Do Not Show Event Title', 'lucille')	=> 'disabled'
	);
?>
	<select id="lc_show_title_event_list" name="lucille_theme_general_options[lc_show_title_event_list]">
		<?php LUCILLE_SWP_render_select_options($show_title_options, $show_event_title); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Show event title on event list pages - Events - Past Events - All Events.', 'lucille'); ?>
		<?php echo esc_html__('By default, only event date, location and venue are shown.', 'lucille'); ?>
	</p>
<?php	
}

/*
	Social Options
*/
function LUCILLE_SWP_fb_url_cbk() {
	$fb_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_fb_url');

?>
	<input id="lc_fb_url" type="text" name="lucille_theme_social_options[lc_fb_url]" size="150" value="<?php echo esc_url($fb_url); ?>"/>
<?php
}

function LUCILLE_SWP_twitter_url_cbk() {
	$twitter_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_twitter_url');

?>
	<input id="lc_twitter_url" type="text" name="lucille_theme_social_options[lc_twitter_url]" size="150" value="<?php echo esc_url($twitter_url); ?>"/>
<?php
}

function LUCILLE_SWP_gplus_url_cbk() {
	$gplus_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_gplus_url');

?>
	<input id="lc_gplus_url" type="text" name="lucille_theme_social_options[lc_gplus_url]" size="150" value="<?php echo esc_url($gplus_url); ?>"/>
<?php
}

function LUCILLE_SWP_youtube_url_cbk() {
	$youtube_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_youtube_url');

?>
	<input id="lc_youtube_url" type="text" name="lucille_theme_social_options[lc_youtube_url]" size="150" value="<?php echo esc_url($youtube_url); ?>"/>
<?php
}

function LUCILLE_SWP_soundcloud_url_cbk() {
	$soundcloud_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_soundcloud_url');

?>
	<input id="lc_soundcloud_url" type="text" name="lucille_theme_social_options[lc_soundcloud_url]" size="150" value="<?php echo esc_url($soundcloud_url); ?>"/>
<?php
}

function LUCILLE_SWP_myspace_url_cbk() {
	$myspace_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_myspace_url');

?>
	<input id="lc_myspace_url" type="text" name="lucille_theme_social_options[lc_myspace_url]" size="150" value="<?php echo esc_url($myspace_url); ?>"/>
<?php
}

function LUCILLE_SWP_itunes_url_cbk() {
	$itunes_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_itunes_url');

?>
	<input id="lc_itunes_url" type="text" name="lucille_theme_social_options[lc_itunes_url]" size="150" value="<?php echo esc_url($itunes_url); ?>"/>
<?php
}

function LUCILLE_SWP_pinterest_url_cbk() {
	$pinterest_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_pinterest_url');

?>
	<input id="lc_pinterest_url" type="text" name="lucille_theme_social_options[lc_pinterest_url]" size="150" value="<?php echo esc_url($pinterest_url); ?>"/>
<?php
}

function LUCILLE_SWP_instagram_url_cbk() {
	$instagram_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_instagram_url');

?>
	<input id="lc_instagram_url" type="text" name="lucille_theme_social_options[lc_instagram_url]" size="150" value="<?php echo esc_url($instagram_url); ?>"/>
<?php
}

function LUCILLE_SWP_snapchat_url_cbk() {
	$snapchat_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_snapchat_url');

?>
	<input id="lc_snapchat_url" type="text" name="lucille_theme_social_options[lc_snapchat_url]" size="150" value="<?php echo esc_url($snapchat_url); ?>"/>
<?php
}

function LUCILLE_SWP_gplay_url_cbk() {
	$gplay_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_gplay_url');

?>
	<input id="lc_gplay_url" type="text" name="lucille_theme_social_options[lc_gplay_url]" size="150" value="<?php echo esc_url($gplay_url); ?>"/>
<?php
}


/*
	Footer Options
*/

function LUCILLE_SWP_footer_widget_cs_cbk() {
	$footer_color_scheme = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_footer_widgets_color_scheme');
	if (empty($footer_color_scheme)) {
		$footer_color_scheme = 'white_on_black';
	}

	$footer_color_schemes = array(
		esc_html__('White On Black', 'lucille')	=> 'white_on_black',
		esc_html__('Black on White', 'lucille')	=> 'black_on_white'
	);
?>

	<select id="lc_footer_widgets_color_scheme" name="lucille_theme_footer_options[lc_footer_widgets_color_scheme]">
		<?php LUCILLE_SWP_render_select_options($footer_color_schemes, $footer_color_scheme); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Color scheme used for footer widgets text.', 'lucille'); ?>
	</p>
<?php
}

function LUCILLE_SWP_footer_widget_bgimg_cbk() {
	$footer_bg_image = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_footer_widgets_background_image');

?>
	<input id="lc_swp_footer_bg_image_upload_value" type="text" name="lucille_theme_footer_options[lc_footer_widgets_background_image]" size="150" value="<?php echo esc_url($footer_bg_image); ?>"/>
	<input id="lc_swp_upload_footer_widgets_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Upload Image', 'lucille'); ?>" />
	<input id="lc_swp_remove_footer_widgets_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Remove Image', 'lucille'); ?>" />
	<p class="description">
		<?php echo esc_html__('Upload a custom background image for the footer widgets area.', 'lucille'); ?>
	</p>

	<div id="lc_footer_widgets_bg_image_preview">
		<img class="lc_swp_setting_preview_favicon" src="<?php echo esc_url($footer_bg_image); ?>">
	</div>
<?php
}

function LUCILLE_SWP_footer_widget_bgcolor_cbk() {
	$footer_background_color = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_footer_widgets_background_color');
	$default_bg_color = 'rgba(19, 19, 19, 1)';

	if ('' == $footer_background_color) {
		$footer_background_color = $default_bg_color;
	}
?>

	<input type="text" id="lc_footer_widgets_background_color" class="alpha-color-picker-settings" name="lucille_theme_footer_options[lc_footer_widgets_background_color]" value="<?php echo esc_attr($footer_background_color); ?>" data-default-color="rgba(19, 19, 19, 1)" data-show-opacity="true" />

	<p class="description">
		<?php echo esc_html__('Color overlay for the footer widgets area. Can be used as background color or as color over the background image.', 'lucille'); ?>
	</p>
<?php	
}

function LUCILLE_SWP_copyright_text_cbk() {
	$copyright_text = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_text');
?>
	<textarea  cols="147" rows="10" id="lc_copyright_text" name="lucille_theme_footer_options[lc_copyright_text]" ><?php echo esc_html($copyright_text); ?></textarea>;
<?php
}

function LUCILLE_SWP_copyright_url_cbk() {
	$copyright_url = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_url');
?>
	<input type="text" size="147" id="lc_copyright_url" name="lucille_theme_footer_options[lc_copyright_url]" value="<?php echo esc_url_raw($copyright_url)?>"/>
<?php
}
/*
function LUCILLE_SWP_analytics_code_cbk() {
	$analytics_code = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_analytics_code');

?>
	<textarea  cols="147" rows="10" id="analytics_code" name="lucille_theme_footer_options[lc_analytics_code]" ><?php echo esc_html($analytics_code); ?></textarea>
<?php
}
*/

function LUCILLE_SWP_copyright_cs_cbk() {
	$copy_color_scheme = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_text_color');
	if (empty($copy_color_scheme)) {
		$copy_color_scheme = 'white_on_black';
	}

	$copy_color_schemes = array(
		esc_html__('White On Black', 'lucille')	=> 'white_on_black',
		esc_html__('Black on White', 'lucille')	=> 'black_on_white'
	);
?>

	<select id="lc_copyright_text_color" name="lucille_theme_footer_options[lc_copyright_text_color]">
		<?php LUCILLE_SWP_render_select_options($copy_color_schemes, $copy_color_scheme); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Color scheme used for footer copyrigth text.', 'lucille'); ?>
	</p>
<?php
}

function LUCILLE_SWP_copyright_bgc_cbk() {
	$copy_bgc = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_text_bg_color');
	$default_copy_bgc = 'rgba(29, 29, 29, 1)';

	if ('' == $copy_bgc) {
		$copy_bgc = $default_copy_bgc;
	}
?>

	<input type="text" id="lc_copyright_text_bg_color" class="alpha-color-picker-settings" name="lucille_theme_footer_options[lc_copyright_text_bg_color]" value="<?php echo esc_html($copy_bgc); ?>" data-default-color="rgba(29, 29, 29, 1)" data-show-opacity="true" />

	<p class="description">
		<?php echo esc_html__('Background color for the copyright text area.', 'lucille'); ?>
	</p>
<?php	
}

/*
	Contact Options
*/
function LUCILLE_SWP_lc_contact_address_cbk() {
	$contact_address = LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_address');
?>
	<input type="text" size="200" id="lc_contact_address" name="lucille_theme_contact_options[lc_contact_address]" value="<?php echo esc_attr($contact_address); ?>" />
<?php
}

function LUCILLE_SWP_lc_contact_phone_cbk() {
	$contact_phone = LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_phone');
?>
	<input type="text" size="50" id="lc_contact_phone" name="lucille_theme_contact_options[lc_contact_phone]" value="<?php echo esc_attr($contact_phone); ?>" />
<?php	
}

function LUCILLE_SWP_lc_contact_fax_cbk() {
	$contact_fax = LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_fax');
?>
	<input type="text" size="50" id="lc_contact_fax" name="lucille_theme_contact_options[lc_contact_fax]" value="<?php echo esc_attr($contact_fax); ?>" />
<?php
}

function LUCILLE_SWP_lc_contact_email_cbk() {
	$contact_email = sanitize_email(LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_email'));
?>
	<input type="text" size="50" id="lc_contact_email" name="lucille_theme_contact_options[lc_contact_email]" value="<?php echo esc_attr($contact_email); ?>" />
	<p class="description">
		<?php
		echo esc_html__("This is the email address shown on contact page.", "lucille");
		?> <br> <?php
		echo esc_html__("To set the recipient email for the contact form, please go to Settings - Lucille Music Core Settings.", "lucille");
		?>
	</p>
<?php
}


/*
	UTILS FOR THEME SETTINGS
*/
function LUCILLE_SWP_get_theme_option($option_group, $option_name) 
{
	$options = get_option($option_group);

	if (isset($options[$option_name])) {
		return $options[$option_name];
	}

	return '';
}

function LUCILLE_SWP_render_select_options($options, $selected) {
	if (empty($selected)) {
		return;
	}

	foreach($options as $key => $value) {
		if ($value == $selected) {
			?>
			<option value="<?php echo esc_attr($value); ?>" selected="selected"> <?php echo esc_attr($key); ?> </option>
			<?php
		} else {
			?>
			<option value="<?php echo esc_attr($value); ?>"> <?php echo esc_attr($key); ?> </option>
			<?php
		}
	}
}

?>