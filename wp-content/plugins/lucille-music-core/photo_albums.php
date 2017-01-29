<?php

add_action( 'init', 'LUCILLE_SWP_create_photo_albums_post', 11);
function LUCILLE_SWP_create_photo_albums_post() 
{
	$slug = LUCILLE_SWP_JPT_get_plugin_option("photo_album");
	if ( "" == $slug) {
		$slug = "js_photo_albums";
	}
	
	register_post_type( 'js_photo_albums',
		array(
			'labels' => array(
				'name' =>  esc_html__('Photo Albums', 'lucille-music-core') ,
				'singular_name' =>  esc_html__('Photo Album', 'lucille-music-core') ,
				'add_new' => esc_html__('Add New Photo Album', 'lucille-music-core'),
				'add_new_item' => esc_html__('Add New Photo Album', 'lucille-music-core'),
				'edit' => esc_html__('Edit', 'lucille-music-core'),
				'edit_item' => esc_html__('Edit Photo Album', 'lucille-music-core'),
				'new_item' => esc_html__('New Photo Album', 'lucille-music-core'),
				'view' => esc_html__('View', 'lucille-music-core'),
				'view_item' => esc_html__('View Photo Album', 'lucille-music-core'),
				'search_items' => esc_html__('Search Photo Albums', 'lucille-music-core'),
				'not_found' => esc_html__('No Photo Albums found','lucille-music-core'),
				'not_found_in_trash' => esc_html__('No Photo Albums Found in Trash','lucille-music-core'),
				'parent' => esc_html__('Parent Photo Album','lucille-music-core')
			),
		'public' => true,
		'rewrite' => array(
			'slug' => $slug,
			'with_front' => false
			),			
		'supports' => array( 'title', 'editor', 'comments', 'thumbnail'),
		'menu_icon' => 'dashicons-camera'
		)
	); 
}


/*
	admin section - add meta box to edit post
*/
add_action( 'admin_init', 'LUCILLE_SWP_photo_albums_admin_init');
function LUCILLE_SWP_photo_albums_admin_init() 
{
    add_meta_box( 'photo_albums_meta_box', 	/*the required HTML id attribute*/
        esc_html__('Image Gallery','lucille-music-core'), 	/*text visible in the heading of meta box section*/
        'LUCILLE_SWP_display_photo_albums_meta_box',	/* callback FUNCTION which renders the contents of the meta box*/
        'js_photo_albums', 					/*the name of the custom post type where the meta box will be displayed*/
		'normal', 							/*defines the part of the page where the edit screen section should be shown*/
		'high' 								/*defines the priority within the context where the boxes should show*/
   );
}


/*
	callback FUNCTION which renders the contents of the meta box
	$photoAlbumObject
*/
function LUCILLE_SWP_display_photo_albums_meta_box($photoAlbumObject)
{
	$js_swp_gallery_images = esc_html(get_post_meta($photoAlbumObject->ID, 'js_swp_gallery_images', true));
	$js_swp_gallery_images_id = esc_html(get_post_meta($photoAlbumObject->ID, 'js_swp_gallery_images_id', true));
	
	/*compatibility reasons - with versions smaller than 2.4.2*/
	$js_swp_gallery_compatibility242 = esc_html(get_post_meta($photoAlbumObject->ID, 'js_swp_gallery_compatibility242', true));
	$js_swp_gallery_compatibility243 = esc_html(get_post_meta($photoAlbumObject->ID, 'js_swp_gallery_compatibility243', true));
	
	/*
		put attachment images only if this was not done already
		$js_swp_gallery_compatibility242 will be set to 'OK' 
			and will be different than '' after the first save
		this was done for compatibility reasons with older than 2.4.2 versions
	*/
	/*
		UPDATE 2.4.3
		if js_swp_gallery_compatibility242 is empty (photos not saved using new functionality)
		put ids to js_swp_gallery_images_id 
	*/
	if (('' == trim($js_swp_gallery_images)) && ('' == $js_swp_gallery_compatibility242)) {
		/*get images as comma separated URLs - [url to image 1],[url to image 2]*/
		//$js_swp_gallery_images = LUCILLE_SWP_get_old_style_images_attached($photoAlbumObject->ID);
		$js_swp_gallery_images_id = LUCILLE_SWP_get_old_style_images_attached($photoAlbumObject->ID);
	}
	
	/*
		1st change is active, apply the 2nd one
		get the images from js_swp_gallery_images and turn them to ids to js_swp_gallery_images_id
	
	*/
	if (('' != trim($js_swp_gallery_images)) && ('' != $js_swp_gallery_compatibility242) && ('' == $js_swp_gallery_compatibility243)) {
		$js_swp_gallery_images_id = LUCILLE_SWP_get_ids_from_js_swp_gallery_images($js_swp_gallery_images);
	}
	
	?>
	
	<div id="js_swp_cpt_gallery_container">
		<div id="js_swp_gallery_content">
			<?php LUCILLE_SWP_fill_preview_container($js_swp_gallery_images_id); ?>
		</div>
		
		<div id="js_swp_add_image_container">
			<input type="button" id="js_swp_add_image_gallery_cpt" class="button button-primary" value="<?php echo esc_html__('Add Images To Gallery', 'lucille-music-core'); ?>" />
		</div>
		
		<input type="text" name="js_swp_gallery_images" id="js_swp_gallery_images" value="<?php echo esc_attr($js_swp_gallery_images); ?>" />
		<input type="text" name="js_swp_gallery_images_id" id="js_swp_gallery_images_id" value="<?php echo esc_attr($js_swp_gallery_images_id); ?>" />
		
		<input type="text" name="js_swp_gallery_compatibility242" id="js_swp_gallery_compatibility242" value="<?php echo esc_attr($js_swp_gallery_compatibility242); ?>" />
		<input type="text" name="js_swp_gallery_compatibility243" id="js_swp_gallery_compatibility243" value="<?php echo esc_attr($js_swp_gallery_compatibility243); ?>" />
	</div>

	<?php
}

function LUCILLE_SWP_fill_preview_container($image_ids) 
{
	$idsArray = explode(',', $image_ids);
	$idsArray = array_filter($idsArray);
	if (empty($idsArray)) {
		return;
	}

	$allowed_html = array(
		'img'	=> array(
			'width'		=> array(),
			'height'	=> array(),
			'src'		=> array(),
			'class'		=> array(),
			'alt'		=> array(),
			'srcset'	=> array(),
			'sizes'		=> array()
		)
	);	
	
	echo '<ul class="js_swp_gallery_cpt_preview ui-sortable" id="js_gallery_admin">';
	foreach($idsArray as $imgID) {
		$imgTag = wp_get_attachment_image($imgID, 'small');
		?>
		<li class="image_cell ui-sortable-handle" id="<?php echo esc_attr($imgID); ?>">
			<?php echo wp_kses($imgTag, $allowed_html); ?>
			<div class="image_action remove_gallery_cpt_image" data-imid="<?php echo esc_attr($imgID); ?>">Remove</div>
		</li>
		<?php
	}
	echo '</ul>';
}

/*
	get images as comma separated strings:
	["url to image 1","url to image 2"]
	UPDATE 2.4.3 - 
	get image id's as comma separated values
	[1485,2009,2010,1545,2004,1720,1729,1726,1951,1546,2003,1722,1673]
*/
function LUCILLE_SWP_get_old_style_images_attached($photo_album_ID) {
	$args = array(
		'post_type'         => 'attachment',
		'post_status'       => 'inherit',
		'post_parent'       => $photo_album_ID,
		'post_mime_type'    => 'image',
		'posts_per_page'    => -1,
		'order'             => 'ASC',
		'orderby'           => 'menu_order'		
	);
	$loop = get_posts( $args);
	if( empty($loop)) {
		return '';
	}
	
	$commaSeparatedImages = '';
	foreach($loop as $image) {
		if ($commaSeparatedImages != '') {
			$commaSeparatedImages .= ',';
		}
		$commaSeparatedImages .= $image->ID;
	}
	
	return $commaSeparatedImages;
}

/*
	input param looks like: 
	[url to image],[url to image]
	returns comma separated ids
*/

function LUCILLE_SWP_get_ids_from_js_swp_gallery_images($images_URLs) {
	$commaSeparatedIds = "";
	
	$imgArray = explode(',', $images_URLs);
	$imgArray = array_filter($imgArray);
	
	if (empty($imgArray)) {
		return "";
	}
	
	echo '<br><br><br>';
	foreach($imgArray as $imageURL) {
		/*remove [] at the beginning and end of the url*/
		$imageURL = substr($imageURL, 1, -1); 
		$imgId = LUCILLE_SWP_get_attachment_id_from_url_jpt($imageURL);

		if ('' == $imgId) {
			continue;
		}
		
		if ('' != $commaSeparatedIds) {
			$commaSeparatedIds .= ",";
		}
		$commaSeparatedIds .= $imgId;
	}

	return $commaSeparatedIds;
}


add_action('save_post', 'LUCILLE_SWP_save_photo_album_object', 10, 2);
function LUCILLE_SWP_save_photo_album_object($gallery_id, $galleryObject) 
{
	if ($galleryObject->post_type == 'js_photo_albums') {
		if(isset( $_POST['js_swp_gallery_images'])) {
			update_post_meta($gallery_id, 'js_swp_gallery_images', $_POST['js_swp_gallery_images']);
		}
		if(isset( $_POST['js_swp_gallery_images_id'])) {
			update_post_meta($gallery_id, 'js_swp_gallery_images_id', $_POST['js_swp_gallery_images_id']);
		}
		
		if(isset( $_POST['js_swp_gallery_compatibility242'])) {
			update_post_meta($gallery_id, 'js_swp_gallery_compatibility242', 'OK');
		}
		if(isset( $_POST['js_swp_gallery_compatibility243'])) {
			update_post_meta($gallery_id, 'js_swp_gallery_compatibility243', 'OK');
		}		
	}
}



/*
	adding custom columns to admin menu using filter  [manage_edit-{post_type}_columns]
*/
add_filter('manage_edit-js_photo_albums_columns', 'LUCILLE_SWP_js_photo_albums_admin_columns_func');

function LUCILLE_SWP_js_photo_albums_admin_columns_func( $columns)
{
	$columns = array(
		'title' => esc_html__('Photo Album Title', 'lucille-music-core'),
		'author'	=> esc_html__('Author', 'lucille-music-core'),
		'date'		=> esc_html__('Date', 'lucille-music-core')		
		
	);
	
	return $columns;
}

/* 
	making custom comumns SORTABLE
*/
add_filter('manage_edit-js_photo_albums_sortable_columns', 'LUCILLE_SWP_js_photo_albums_sortable_columns');

function LUCILLE_SWP_js_photo_albums_sortable_columns($columns) 
{
	$columns['author'] = 'author';
	return $columns;
}



/*
	Create Category for Photo Albums
*/
add_action( 'init', 'LUCILLE_SWP_create_photo_album_category', 11);

function LUCILLE_SWP_create_photo_album_category()
{
	$slug = LUCILLE_SWP_JPT_get_plugin_option("photo_album_tax");
	if ("" == $slug) {
		$slug = "photo_album_category";
	}
	
	register_taxonomy(
			'photo_album_category',
			'js_photo_albums',
			array(
				'labels' => array(
					'name' => esc_html__('Photo Album Categories', 'lucille-music-core'),
					'singular_name'     => esc_html__( 'Photo Album Category', 'lucille-music-core'),
					'search_items'      => esc_html__( 'Search Photo Album Categories', 'lucille-music-core' ),
					'all_items'         => esc_html__( 'All Photo Album Categories', 'lucille-music-core' ),
					'parent_item'       => esc_html__( 'Parent Photo Album Category', 'lucille-music-core' ),
					'parent_item_colon' => esc_html__( 'Parent Photo Album Category:', 'lucille-music-core' ),
					'edit_item'         => esc_html__( 'Edit Photo Album Category' , 'lucille-music-core'),
					'update_item'       => esc_html__( 'Update Photo Album Category', 'lucille-music-core' ),
					'add_new_item' 		=> esc_html__('Add New Photo Album Category', 'lucille-music-core'),
					'new_item_name' 	=> esc_html__('New Photo Album Category', 'lucille-music-core'),
				),
				'rewrite' => array(
					'slug' => $slug,
					'with_front' => false
				),
				'show_ui' => true,
				'show_tagcloud' => false,
				'hierarchical' => true
			)
		);
}

function LUCILLE_SWP_get_attachment_id_from_url_jpt($attachment_url = '') {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ('' == $attachment_url) {
		return false;
	}
		
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'])) {
 		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url);
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
 	}
 
	return $attachment_id;
}

add_action( 'wp_ajax_LUCILLE_SWP_call_update_gallery_preview', 'LUCILLE_SWP_call_update_gallery_preview');
function LUCILLE_SWP_call_update_gallery_preview() {
	$ret['success'] = true;
	
	$imgIds = $_POST['image_ids'];

	ob_start();	
	echo '<div id="js_swp_gallery_content">';
	LUCILLE_SWP_fill_preview_container($imgIds);
	echo '</div>';
	$ret['gallery'] = ob_get_clean();
	
	echo json_encode( $ret);
	die();
}


?>