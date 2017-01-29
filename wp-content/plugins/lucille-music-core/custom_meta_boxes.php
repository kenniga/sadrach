<?php
/* 
|--------------------------------------------------------------------------
| ADD META BOXES
|--------------------------------------------------------------------------
*/
function LUCILLE_SWP_custom_bg_meta() {
	/* CUSTOM BACKGROUND IMAGE*/
	$custom_bg_image_support = array('post', 'page', 'js_albums', 'js_events', 'js_photo_albums', 'js_videos');
	foreach($custom_bg_image_support as $post_type) {
		add_meta_box( 
			'js_swp_custom_bg_meta', 
			esc_html__("Page Settings", 'lucille-music-core'),
			'LUCILLE_SWP_custom_bg_meta_callback',  
			$post_type
		);
		add_meta_box(
			'js_swp_custom_header_meta', 
			esc_html__("Header Settings", 'lucille-music-core'), 
			'LUCILLE_SWP_custom_header_meta_callback',
			$post_type
		);
	}
	
	/*add custom meta to archives and blog page templates only*/
	global $post;
	$post_id = $post->ID;
	$page_template = get_post_meta($post_id,'_wp_page_template', TRUE);
	if (LUCILLE_SWP_is_archive_like($page_template)) {
		add_meta_box(
			"js_swp_blog_settings_meta", 
			esc_html__("Archive And Blog Settings", 'lucille-music-core'), 
			"LUCILLE_SWP_blog_settings_cbk", 
			"page");
	}
}
add_action( 'add_meta_boxes', 'LUCILLE_SWP_custom_bg_meta');


/* 
|--------------------------------------------------------------------------
| CALLBACK FUNCTION THAT RENDERS META
|--------------------------------------------------------------------------
*/
/*custom page background*/
function LUCILLE_SWP_custom_bg_meta_callback($post) {
	
    $js_swp_stored_meta = get_post_meta($post->ID);
	$meta_bg = '';
	$page_overlay_color = '';
	$remove_footer_widgets = '';
	if (isset($js_swp_stored_meta['js_swp_meta_bg_image'])) {
		$meta_bg = $js_swp_stored_meta['js_swp_meta_bg_image'][0];
	}
	if (isset($js_swp_stored_meta['lc_swp_meta_page_overlay_color'])) {
		$page_overlay_color = $js_swp_stored_meta['lc_swp_meta_page_overlay_color'][0];
	}
	if (isset($js_swp_stored_meta['lc_swp_meta_page_remove_footer'])) {
		$remove_footer_widgets = $js_swp_stored_meta['lc_swp_meta_page_remove_footer'][0];
	}
	

	wp_nonce_field( basename( __FILE__ ), 'js_swp_nonce' );
	ob_start();
?>	
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Choose custom page background image:', 'lucille-music-core'); ?>
		</span>
		<input type="text" style="width:100%; margin-bottom: 5px;" name="js_swp_meta_bg_image" id="js_swp_meta_bg_image" value="<?php echo esc_attr($meta_bg); ?>" />
		<div class="js_swp_meta_bg_image_buttons">
			<input type="button" id="js_swp_meta_bg_image-button" class="button" value="<?php echo esc_html__('Choose Image', 'lucille-music-core'); ?>" />
			<input type="button" id="js_swp_meta_bg_image-buttondelete" class="button" value="<?php echo esc_html__('Remove Image', 'lucille-music-core'); ?>" />
		</div>
	</div>
	<div id="custom_bg_meta_preview">
		<img style="max-width:100%;" src="<?php echo esc_url($meta_bg); ?>" />
    </div>
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Page background color overlay:', 'lucille-music-core'); ?>
		</span>
		<input type="text" class="lc_swp_option alpha-color-picker" name="lc_swp_meta_page_overlay_color" value="<?php echo esc_attr($page_overlay_color); ?>" data-default-color="rgba(0,0,0,0)" data-show-opacity="true" />
	</div>
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Remove footer widgets area for this page:', 'lucille-music-core'); ?>
		</span>
		<input name="lc_swp_meta_page_remove_footer" type="checkbox" value="1" <?php checked("1", $remove_footer_widgets); ?>>
	</div>
<?php
	$output = ob_get_clean();
	
	echo $output;
}

/*custom heading area*/
function LUCILLE_SWP_custom_header_meta_callback($post) {
	$stored_meta = get_post_meta($post->ID);
	
	$page_subtitle = '';
	if (isset($stored_meta['lc_swp_meta_subtitle'])) {
		$page_subtitle = $stored_meta['lc_swp_meta_subtitle'][0];
	}
	
	$color_theme = 'white_on_black';
	if (isset($stored_meta['lc_swp_meta_heading_color_theme'])) {
		$color_theme = $stored_meta['lc_swp_meta_heading_color_theme'][0];
	}
	$color_themes_support = array(
		'White On Black'	=> 'white_on_black',
		'Black On White'	=>	'black_on_white'
	);
	
	$show_page_title_as = 'title_full_color';
	if (isset($stored_meta['lc_swp_meta_heading_full_color'])) {
		$show_page_title_as = $stored_meta['lc_swp_meta_heading_full_color'][0];
	}
	$show_page_title_support = array(
		'Subtitle Under Title'		=> 'title_full_color',
		'Subtitle Over Title'	=> 'title_transparent_color'
	);
	
	$header_bg_image = '';
	if (isset($stored_meta['lc_swp_meta_heading_bg_image'])) {
		$header_bg_image = $stored_meta['lc_swp_meta_heading_bg_image'][0];
	}
	
	$overlay_color = '';
	if (isset($stored_meta['lc_swp_meta_heading_overlay_color'])) {
		$overlay_color = $stored_meta['lc_swp_meta_heading_overlay_color'][0];
	}
	
	?>
	<h4 class="swp_text_align_center"> <?php echo esc_html__('Subtitle &amp; Text Color', 'lucille-music-core'); ?> </h4>	
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Page subtitle:', 'lucille-music-core'); ?>
		</span>
		<input type="text" class="lc_swp_option" name="lc_swp_meta_subtitle" id="lc_swp_meta_subtitle" value="<?php echo esc_html($page_subtitle); ?>" />
	</div>

	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Color Scheme:', 'lucille-music-core'); ?>
		</span>
		<select id="lc_swp_meta_heading_color_theme" name="lc_swp_meta_heading_color_theme">
		<?php
			foreach($color_themes_support as $key => $value) {
				if ($value == $color_theme) {
					?>
					<option value="<?php echo esc_attr($value); ?>" selected="selected"> <?php echo esc_html($key); ?> </option>
					<?php
				} else {
					?>
					<option value="<?php echo esc_attr($value); ?>"> <?php echo esc_html($key); ?> </option>
					<?php
				}
			}
		?>
		</select>
	</div>
	
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Heading style:', 'lucille-music-core'); ?>
		</span>
		<select id="lc_swp_meta_heading_full_color" name="lc_swp_meta_heading_full_color">
		<?php
			foreach($show_page_title_support as $key => $value) {
				if ($value == $show_page_title_as) {
					?>
					<option value="<?php echo esc_attr($value); ?>" selected="selected"> <?php echo esc_html($key); ?> </option>
					<?php
				} else {
					?>
					<option value="<?php echo esc_attr($value); ?>"> <?php echo esc_html($key); ?> </option>
					<?php
				}
			}
		?>
		</select>
		<p class="description show_on_right">
			<?php echo esc_html__('If the subtitle is not present, heading style is ignored.', 'lucille'); ?>
		</p>
	</div>

	<hr>
	<h4 class="swp_text_align_center"> <?php echo esc_html__('Background', 'lucille-music-core'); ?> </h4>	
	<div class="heading_meta_option">
		<input type="text" style="width:100%;" name="lc_swp_meta_heading_bg_image" id="lc_swp_meta_heading_bg_image" value="<?php echo esc_url($header_bg_image); ?>" />
		<div class="lc_swp_meta_head_bg_image_buttons">
			<span class="lc_swp_before_option">
				<?php echo esc_html__('Background image:', 'lucille-music-core'); ?>
			</span>
			<input type="button" id="lc_swp_meta_head_bg_image-button" class="button" value="<?php echo esc_html__('Choose Image', 'lucille-music-core'); ?>" />
			<input type="button" id="lc_swp_meta_head_bg_image-buttondelete" class="button" value="<?php echo esc_html__('Remove Image', 'lucille-music-core'); ?>" />
		</div>
		
		<div id="custom_head_bg_meta_preview">
			<img style="max-width:100%;" src="<?php echo esc_url($header_bg_image); ?>" />
		</div>
	</div>
	
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Background color overlay:', 'lucille-music-core'); ?>
		</span>
		<input type="text" class="lc_swp_option alpha-color-picker" name="lc_swp_meta_heading_overlay_color" value="<?php echo esc_attr($overlay_color); ?>" data-default-color="rgba(0,0,0,0)" data-show-opacity="true" />
	</div>
	<hr>	
	
	<?php
}

/* Blog settings callback */
function LUCILLE_SWP_blog_settings_cbk($post) {
	$stored_meta = get_post_meta($post->ID);
	
	/*
		blog layout: standard, masonry, metro
		for masonry layout - try to determine post orientation using image aspect ratio and add new class (landscape - 2 x width ; portrait - 2 x height)
		add sidebar: no(default), yes
	*/
	$blog_page_layout = 'masonry';
	if (isset($stored_meta['lc_swp_meta_blog_layout'])) {
		$blog_page_layout = $stored_meta['lc_swp_meta_blog_layout'][0];
	}
	
	$blog_page_layout_support = array(
		'Standard'	=> 'standard',
		'Masonry'	=> 'masonry',
		'Grid'		=> 'grid'
	);
?>	
	<div class="blog_option heading_meta_option">
		<span class="lc_swp_before_option">Layout:</span>
		<select id="lc_swp_meta_blog_layout" name="lc_swp_meta_blog_layout">
		<?php
			foreach($blog_page_layout_support as $key => $value) {
				if ($value == $blog_page_layout) {
					?>
					<option value="<?php echo esc_attr($value); ?>" selected="selected"> <?php echo esc_html($key); ?> </option>
					<?php
				} else {
					?>
					<option value="<?php echo esc_attr($value); ?>"> <?php echo esc_html($key); ?> </option>
					<?php
				}
			}
		?>
		</select>
		<p class="description show_on_right">
			<?php echo esc_html__('Choose blog or archive page layout. Applies on the following page templates: Blog', 'lucille'); ?>
		</p>
	</div>
<?php
}

/* 
|--------------------------------------------------------------------------
| SAVE META VALUES
|--------------------------------------------------------------------------
*/
function LUCILLE_SWP_custom_bg_meta_save($post_id) {
     // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'js_swp_nonce' ] ) && wp_verify_nonce( $_POST[ 'js_swp_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
	// Checks for input and saves if needed
	if( isset( $_POST[ 'js_swp_meta_bg_image' ] ) ) {
		update_post_meta( $post_id, 'js_swp_meta_bg_image', trim(esc_url($_POST['js_swp_meta_bg_image']))) ;
	}
	if( isset( $_POST[ 'lc_swp_meta_page_overlay_color' ] ) ) {
		update_post_meta( $post_id, 'lc_swp_meta_page_overlay_color', trim($_POST['lc_swp_meta_page_overlay_color'])) ;
	}
	if(isset($_POST[ 'lc_swp_meta_page_remove_footer' ])) {
		update_post_meta( $post_id, 'lc_swp_meta_page_remove_footer', '1');
	} else {
		update_post_meta( $post_id, 'lc_swp_meta_page_remove_footer', '0');
	}
}
add_action('save_post', 'LUCILLE_SWP_custom_bg_meta_save');

function LUCILLE_SWP_custom_header_meta_save($post_id) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
	
	if ($is_autosave || $is_revision) {
		return;
	}
	
	if(isset($_POST['lc_swp_meta_subtitle'])) {
		update_post_meta($post_id, 'lc_swp_meta_subtitle', trim($_POST['lc_swp_meta_subtitle'])) ;
	}
	if(isset($_POST['lc_swp_meta_heading_color_theme'])) {
		update_post_meta($post_id, 'lc_swp_meta_heading_color_theme', trim($_POST['lc_swp_meta_heading_color_theme'])) ;
	}
	if(isset($_POST['lc_swp_meta_heading_full_color'])) {
		update_post_meta($post_id, 'lc_swp_meta_heading_full_color', trim($_POST['lc_swp_meta_heading_full_color'])) ;
	}
	if(isset($_POST['lc_swp_meta_heading_bg_image'])) {
		update_post_meta($post_id, 'lc_swp_meta_heading_bg_image', trim(esc_url($_POST['lc_swp_meta_heading_bg_image']))) ;
	}
	if(isset($_POST['lc_swp_meta_heading_overlay_color'])) {
		update_post_meta($post_id, 'lc_swp_meta_heading_overlay_color', trim($_POST['lc_swp_meta_heading_overlay_color'])) ;
	}
}
add_action('save_post', 'LUCILLE_SWP_custom_header_meta_save');

function LUCILLE_SWP_blog_settings_meta_save($post_id) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
	
	if ($is_autosave || $is_revision) {
		return;
	}
	
	if(isset($_POST['lc_swp_meta_blog_layout'])) {
		update_post_meta($post_id, 'lc_swp_meta_blog_layout', trim($_POST['lc_swp_meta_blog_layout'])) ;
	}
}
add_action('save_post', 'LUCILLE_SWP_blog_settings_meta_save');

/* 
|--------------------------------------------------------------------------
| ENQUEUE JS SCRIPTS
| js_swp_custom_bg_meta.JS - opens media gallery
|--------------------------------------------------------------------------
*/
function LUCILLE_SWP_custom_bg_script() {
    global $typenow;
    if (($typenow == 'page') || ($typenow == 'post') || 
	($typenow == 'js_videos') || ($typenow == 'js_photo_albums') || ($typenow == 'js_events') || ($typenow == 'js_albums')) {
        wp_enqueue_media();
 
        // Registers and enqueues the required javascript.
        wp_register_script( 'js_swp_custom_bg_meta', plugin_dir_url( __FILE__ ) . '/js/js_swp_custom_bg_meta.js', array( 'jquery', 'alpha_color_picker'), null, true);
        wp_enqueue_script( 'js_swp_custom_bg_meta' );
    }
}
add_action( 'admin_enqueue_scripts', 'LUCILLE_SWP_custom_bg_script' );


/*
	UTILITIES
*/
function LUCILLE_SWP_is_archive_like($page_template) {
	if ('template-blog.php' == $page_template) {
		return true;
	}
	
	return false;
}


?>