<?php 

if (!function_exists('LUCILLE_SWP_setup')) {
	function LUCILLE_SWP_setup()
	{
		//theme textdomain for translation/localization support - load_theme_textdomain( $domain, $path )
		$domain = 'lucille';
		// wp-content/languages/lucille/de_DE.mo
		if (!load_theme_textdomain( $domain, trailingslashit(WP_LANG_DIR).$domain)) {
			// wp-content/themes/lucille/languages
			load_theme_textdomain('lucille', get_template_directory().'/languages');
		}

		// add editor style
		add_editor_style('custom-editor-style.css');
		
		// enables post and comment RSS feed links to head
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');
	 
		// enable support for Post Thumbnails, 
		add_theme_support('post-thumbnails');
		
		// register Menu
		register_nav_menus(
			array(
			  'main-menu' => esc_html__('Main Menu', 'lucille'),
			)
		);
		
		// custom background support
		global $wp_version;
		if (version_compare( $wp_version, '3.4', '>=')) {
			$defaults = array(
				'default-color'          => '151515',
				'default-image'          => '',
				'wp-head-callback'       => 'LUCILLE_SWP_custom_background_cb',
				'admin-head-callback'    => '',
				'admin-preview-callback' => ''
			);
			
			add_theme_support('custom-background',  $defaults); 
		}	

	}
}
add_action( 'after_setup_theme', 'LUCILLE_SWP_setup' );


function LUCILLE_SWP_custom_background_cb()
{
        $background = get_background_image();  
        $color = get_background_color();  
      
        if (!$background && !$color) {
        	return;
        }
      
        $style = $color ? "background-color: #$color;" : '';  
      
        if ( $background ) {  
            $image = " background-image: url('$background');";  
      
            $repeat = get_theme_mod( 'background_repeat', 'repeat' );  
      
            if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )  
                $repeat = 'repeat';  
      
            $repeat = " background-repeat: $repeat;";  
      
            $position = get_theme_mod( 'background_position_x', 'left' );  
      
            if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )  
                $position = 'left';  
      
            $position = " background-position: top $position;";  
      
            $attachment = get_theme_mod( 'background_attachment', 'scroll' );  
      
            if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )  
                $attachment = 'scroll';  
      
            $attachment = " background-attachment: $attachment;";  
      
            $style .= $image . $repeat . $position . $attachment;  
        }

		?>  
		<style type="text/css">  
			body, .woocommerce .woocommerce-ordering select option { <?php echo trim($style); ?> }  
		</style>  
		<?php  	
}

/*
	Load the main stylesheet - style.css
*/
if (!function_exists( 'LUCILLE_SWP_load_main_stylesheet')) {
	function LUCILLE_SWP_load_main_stylesheet()
	{
		wp_enqueue_style( 'style', get_stylesheet_uri() );
	}
}
add_action( 'wp_enqueue_scripts', 'LUCILLE_SWP_load_main_stylesheet' );



/*
	Load Needed Google Fonts
*/
if ( !function_exists('LUCILLE_SWP_load_google_fonts') ) {
	function LUCILLE_SWP_load_google_fonts()
	{
		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'jamsession-opensans-oswald', $protocol."://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800|Oswald:300,400,700&subset=latin,latin-ext" );
	}
}
add_action( 'wp_enqueue_scripts', 'LUCILLE_SWP_load_google_fonts' );


/*
	Control Excerpt Length
*/
if (!function_exists('LUCILLE_SWP_excerpt_length')) {
	function LUCILLE_SWP_excerpt_length($length)
	{
		return 40;
	}
}
add_filter( 'excerpt_length', 'LUCILLE_SWP_excerpt_length', 999);


/*
	Remove [...] string from excerpt
*/
if ( ! function_exists( 'LUCILLE_SWP_excerpt_more' ) ) {
	function LUCILLE_SWP_excerpt_more($more) {
		return '...';
	}
}
add_filter('excerpt_more', 'LUCILLE_SWP_excerpt_more');


/*
	Make Sure Content Width is Set
*/
if (!isset($content_width)) {
	$content_width = 900;
}

?>