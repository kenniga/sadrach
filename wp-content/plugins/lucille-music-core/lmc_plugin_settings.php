<?php

/*
	Create menu entry
*/
function LUCILLE_SWP_LMC_menu_entry() {    
	add_options_page("Lucille Music Core Settings", "Lucille Music Core Settings", "manage_options", "Lucille-Post-Types-Settings", "LUCILLE_SWP_LMC_output_content");
}
add_action('admin_menu', 'LUCILLE_SWP_LMC_menu_entry');


/*
	Callback renders options content
*/
function LUCILLE_SWP_LMC_output_content()
{
?> 
	<!-- Create a header in the default WordPress 'wrap' container -->      
	<div class="wrap">
		<!-- Add the icon to the page -->          
		<h2>Lucille Music Core Plugin Settings</h2>				 
		
		<!-- Make a call to the WordPress function for rendering errors when settings are saved. -->          
		<?php settings_errors(); ?> 				       
		
		<!-- Create the form that will be used to render our options -->
		<form method="post" action="options.php"> 			
			<?php   			
			settings_fields( 'LMC_plugin_options' );  		
			do_settings_sections( 'LMC_plugin_options' );						
			submit_button(); 			
			?>        
		</form>  
	
	</div>
 <?php
	/* very important call*/
	flush_rewrite_rules();
 }
 
 add_action('admin_init', 'LUCILLE_SWP_LMC_initialize_lmc_options');
 
 function LUCILLE_SWP_LMC_initialize_lmc_options()
 {	
	/* 
		Create plugin options 
	*/
	if( false == get_option( 'LMC_plugin_options')) {		
		add_option( 'LMC_plugin_options' );	
	}
	 
	/* 
		Create settings section	
	*/
	 add_settings_section(  		
		 'LMC_plugin_section',          	/* ID used to identify this section and with which to register options  */		
		 esc_html__('Lucille Plugin Settings', 'lucille-music-core'),                   /* Title to be displayed on the administration page   */		
		 'LMC_plugin_options_callback',  	/* Callback used to render the description of the section */		
		 'LMC_plugin_options'      			/* Page on which to add this section of options  */	
	 );	
	 
	register_setting(  
		'LMC_plugin_options',  		//option group - A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
		'LMC_plugin_options',  		// option_name -  The name of an option to sanitize and save. 
		'LMC_sanitize_plugin_options'  	//  $sanitize_callback (callback) (optional) A callback function that sanitizes the option's value
	);	

 	 
	/*
		Settings fields
	*/
	 add_settings_field(           
		 'events_slug',          								/* ID used to identify the field throughout the theme                */      
		 esc_html__('Event Post Type Slug', 'lucille-music-core'),                				/* The label to the left of the option interface element   */             
		 'LMC_plugin_options_event_slug_callback', 				/* The name of the function responsible for rendering the option interface */     
		 'LMC_plugin_options',   								/* The page on which this option will be displayed   */      
		 'LMC_plugin_section'    								/* The name of the section to which this field belongs   */    
	 ); 

	 add_settings_field(           
		 'photo_albums_slug',
		 esc_html__('Photo Album Post Type Slug', 'lucille-music-core'),
		 'LMC_plugin_options_photo_album_slug_callback',
		 'LMC_plugin_options',
		 'LMC_plugin_section'
	 ); 

	 add_settings_field(           
		 'videos_slug',
		 esc_html__('Video Post Type Slug', 'lucille-music-core'),
		 'LMC_plugin_options_video_slug_callback',
		 'LMC_plugin_options',
		 'LMC_plugin_section'
	 ); 

	 add_settings_field(           
		 'albums_slug',
		 esc_html__('Audio Post Type Slug', 'lucille-music-core'),
		 'LMC_plugin_options_album_slug_callback',
		 'LMC_plugin_options',
		 'LMC_plugin_section'
	 );
	
	/*
		Custom Post Types TAXONOMY slug
	*/
	add_settings_field(           
		'events_tax_slug',
		esc_html__('Event Category Slug', 'lucille-music-core'),
		'LMC_plugin_options_event_tax_slug_callback',
		'LMC_plugin_options',
		'LMC_plugin_section'
	);
	
	add_settings_field(           
		'photo_albums_tax_slug',
		esc_html__('Photo Album Category Slug', 'lucille-music-core'),
		'LMC_plugin_options_photo_album_tax_slug_callback',
		'LMC_plugin_options',
		'LMC_plugin_section'
	);
	
	add_settings_field(           
		'video_tax_slug',
		esc_html__('Video Category Slug', 'lucille-music-core'),
		'LMC_plugin_options_video_tax_slug_callback',
		'LMC_plugin_options',
		'LMC_plugin_section'
	);

	add_settings_field(           
		'album_tax_slug',
		esc_html__('Album Category Slug', 'lucille-music-core'),
		'LMC_plugin_options_album_tax_slug_callback',
		'LMC_plugin_options',
		'LMC_plugin_section'
	);

	add_settings_field(           
		'lc_mc_contact_form_email',
		esc_html__('Contact Form E-mail', 'lucille-music-core'),
		'LMC_plugin_options_contact_form_email_callback',
		'LMC_plugin_options',
		'LMC_plugin_section'
	);	
 }
 
 
 /* 
|--------------------------------------------------------------------------
| CALLBACK FUNCTIONS
|--------------------------------------------------------------------------
*/
function LMC_plugin_options_callback()
{
	echo esc_html__('Set up the slugs for custom post types and the contact form recipiend email address.', 'lucille-music-core');
}
 
function LMC_plugin_options_event_slug_callback()
{
	$options = get_option('LMC_plugin_options');  
	  
	$slug = ''; 
	if( isset($options['event'])) { 
		$slug = $options['event']; 
	}
	 
	echo '<input type="text" size="50 id="event" name="LMC_plugin_options[event]" value="' . esc_attr($slug) . '" />';  	
}
 
function LMC_plugin_options_photo_album_slug_callback()
{
	$options = get_option( 'LMC_plugin_options' );  
	  
	$slug = ''; 
	if( isset( $options['photo_album'])) { 
		$slug = esc_html($options['photo_album']); 
	}
	 
	echo '<input type="text" size="50 id="photo_album" name="LMC_plugin_options[photo_album]" value="' . esc_attr($slug) . '" />';
}
 
function LMC_plugin_options_video_slug_callback() {
	$options = get_option('LMC_plugin_options');  
	  
	$slug = ''; 
	if(isset($options['video'])) { 
		$slug = esc_html($options['video']); 
	}
	 
	echo '<input type="text" size="50 id="video" name="LMC_plugin_options[video]" value="' . esc_attr($slug) . '" />';  		
}
 
function LMC_plugin_options_album_slug_callback()
{
	$options = get_option( 'LMC_plugin_options' );  
	  
	$slug = ''; 
	if(isset($options['album'])) { 
		$slug = esc_html($options['album']); 
	}
	 
	echo '<input type="text" size="50 id="album" name="LMC_plugin_options[album]" value="' . esc_attr($slug) . '" />';  		
}

function LMC_plugin_options_event_tax_slug_callback() 
{
	$options = get_option( 'LMC_plugin_options' );
	
	$slug = ''; 
	if( isset( $options['event_tax'])) { 
		$slug = esc_html($options['event_tax']); 
	}
	
	echo '<input type="text" size="50 id="event_tax" name="LMC_plugin_options[event_tax]" value="' . esc_attr($slug) . '" />';  			
}

function LMC_plugin_options_photo_album_tax_slug_callback() 
{
	$options = get_option( 'LMC_plugin_options' );
	
	$slug = ''; 
	if(isset($options['photo_album_tax'])) { 
		$slug = esc_html($options['photo_album_tax']); 
	}
	
	echo '<input type="text" size="50 id="photo_album_tax" name="LMC_plugin_options[photo_album_tax]" value="' . esc_attr($slug) . '" />';  			
}

function LMC_plugin_options_video_tax_slug_callback() {
	$options = get_option('LMC_plugin_options');
	
	$slug = ''; 
	if( isset( $options['video_tax'])) { 
		$slug = esc_html($options['video_tax']); 
	}
	
	echo '<input type="text" size="50 id="video_tax" name="LMC_plugin_options[video_tax]" value="' . esc_attr($slug) . '" />'; 
}

function LMC_plugin_options_album_tax_slug_callback() {
	$options = get_option( 'LMC_plugin_options' );
	
	$slug = ''; 
	if(isset( $options['album_tax'])) { 
		$slug = esc_html($options['album_tax']); 
	}
	
	echo '<input type="text" size="50 id="album_tax" name="LMC_plugin_options[album_tax]" value="' . esc_attr($slug) . '" />'; 	
}

function LMC_plugin_options_contact_form_email_callback() {
	$options = get_option('LMC_plugin_options');

	$contact_form_email = '';
	if(isset( $options['lc_mc_contact_form_email'])) { 
		$contact_form_email = sanitize_email($options['lc_mc_contact_form_email']);
	}
?>
	<input type="text" size="50" id="LMC_plugin_options" name="LMC_plugin_options[lc_mc_contact_form_email]" value="<?php echo esc_html($contact_form_email); ?>" />
	<p class="description">
		<?php
		echo esc_html__("This is the recipient email address for the contact form.", "lucille");
		?>
	</p>
<?php	
}

/* 
|--------------------------------------------------------------------------
| SANITIZE CALLBACK
|--------------------------------------------------------------------------
*/
function LMC_sanitize_plugin_options($inputOptions)
{
	// Define the array for the updated options  
	$output = array();  

	// Loop through each of the options sanitizing the data  
	foreach($inputOptions as $key => $val) {  
		if(isset($inputOptions[$key])) {
			if ("lc_mc_contact_form_email" == $key) {
				$output[$key] = sanitize_email(trim($inputOptions[$key]));
			} else {
				$output[$key] = esc_html(trim($inputOptions[$key]));  	
			}
			
		}
	}
	  
	// Return the new collection  
	return apply_filters('LMC_sanitize_plugin_options', $output, $inputOptions);
}

?>