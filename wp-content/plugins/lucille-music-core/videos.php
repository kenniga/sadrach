<?php

add_action( 'init', 'LUCILLE_SWP_create_videos_post', 11);
function LUCILLE_SWP_create_videos_post()
{
	$slug = LUCILLE_SWP_JPT_get_plugin_option("video");
	if ( "" == $slug) {
		$slug = "js_videos";
	}
	
	register_post_type( 'js_videos',
		array(
			'labels' => array(
				'name' =>  esc_html__('Videos', 'lucille-music-core'),
				'singular_name' =>  esc_html__('Video', 'lucille-music-core'),
				'add_new' => esc_html__('Add New Video', 'lucille-music-core'),
				'add_new_item' => esc_html__('Add New Video', 'lucille-music-core'),
				'edit' => esc_html__('Edit', 'lucille-music-core'),
				'edit_item' => esc_html__('Edit Video', 'lucille-music-core'),
				'new_item' => esc_html__('New Video', 'lucille-music-core'),
				'view' => esc_html__('View', 'lucille-music-core'),
				'view_item' => esc_html__('View Video', 'lucille-music-core'),
				'search_items' => esc_html__('Search Videos', 'lucille-music-core'),
				'not_found' => esc_html__('No Videos Found','lucille-music-core'),
				'not_found_in_trash' => esc_html__('No Videos Found in Trash','lucille-music-core'),
				'parent' => esc_html__('Parent Video','lucille-music-core')
			),
		'public' => true,
		'rewrite' => array(
			'slug' => $slug,
			'with_front' => false
			),			
/*		'has_archive' => true,*/
		'supports' => array( 'title', 'editor', 'comments', 'thumbnail'),
		'menu_icon' => 'dashicons-video-alt2'
		)
	); 
}

/*
	Admin section
*/

add_action( 'admin_init', 'LUCILLE_SWP_videos_admin_init');
function LUCILLE_SWP_videos_admin_init() 
{
    add_meta_box( 'video_meta_box', 		/*the required HTML id attribute*/
        esc_html__('Video Custom Settings','lucille-music-core'), 	/*text visible in the heading of meta box section*/
        'LUCILLE_SWP_display_videos_meta_box',			/* callback FUNCTION which renders the contents of the meta box*/
        'js_videos', 						/* the name of the custom post type where the meta box will be displayed*/
		'normal', 							/*defines the part of the page where the edit screen section should be shown*/
		'high' 								/*defines the priority within the context where the boxes should show*/
   );
}

/*
	callback FUNCTION which renders the contents of the meta box
	$slideObject
*/
function LUCILLE_SWP_display_videos_meta_box( $videoObject) 
{

    // Retrieve current name of the youtube and vimeo based on js_video id
	$youtube_url = esc_html( get_post_meta( $videoObject->ID, 'video_youtube_url', true)); 	
	$vimeo_url = esc_html( get_post_meta( $videoObject->ID, 'video_vimeo_url', true)); 		
	
    ?>
    <table style= "width: 100%;">
        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Youtube URL','lucille-music-core');?></td>
			<td ><input style="width: 100%; display: block;"  type="text"  name="js_video_youtube_url" value="<?php echo esc_url($youtube_url); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('Youtube short url like - http://youtu.be/jUk-5nsGedM .','lucille-music-core'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Vimeo URL','lucille-music-core');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="js_video_vimeo_url" value="<?php echo esc_url($vimeo_url); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo esc_html__('Vimeo short url like - http://vimeo.com/8119784 .','lucille-music-core'); ?></div>
			</td>
        </tr>				
    </table>
    <?php
}



/* 
	register save custom post (js_video) function 
*/
add_action( 'save_post', 'LUCILLE_SWP_save_video_fields', 10, 2);

/*
	save post function - triggered on save 
	$js_video_id
	$js_videoObject
*/
function LUCILLE_SWP_save_video_fields($js_video_id, $js_video) 
{
    if ( $js_video->post_type != 'js_videos') {
		return;
	}
	
	// Store data in post meta table if present in post data
	if ( isset( $_POST['js_video_youtube_url'])) {
		update_post_meta( $js_video_id, 'video_youtube_url', $_POST['js_video_youtube_url']);
	}		
	if ( isset( $_POST['js_video_vimeo_url'])) {
		update_post_meta( $js_video_id, 'video_vimeo_url', $_POST['js_video_vimeo_url']);
	}				
}

/*adding custom columns to admin menu using filter  [manage_edit-{post_type}_columns]*/
add_filter('manage_edit-js_videos_columns', 'LUCILLE_SWP_videos_admin_columns_func');

function LUCILLE_SWP_videos_admin_columns_func($columns)
{
	$columns = array(
		'title' => esc_html__('Video Title', 'lucille-music-core'),
		'video_youtube_url'	=>	__('Youtube URL', 'lucille-music-core'),		
		'video_vimeo_url'	=>	__('Vimeo URL', 'lucille-music-core'),
		'author'	=> esc_html__('Author', 'lucille-music-core'),
		'date'		=> esc_html__('Date', 'lucille-music-core')		
		
	);
	
	return $columns;
}


/*
	fill the custom columns on admin 	manage_{post_type}_posts_custom_column
*/

add_action( 'manage_js_videos_posts_custom_column', 'LUCILLE_SWP_manage_js_videos_columns_func', 10, 2);

function LUCILLE_SWP_manage_js_videos_columns_func($column, $js_video_id)
{
	global $post;
	
	switch( $column) {
		case 'video_youtube_url' :
			$youtube_url = esc_html(get_post_meta($js_video_id, 'video_youtube_url', true));
			echo esc_html($youtube_url);
			break;
		case 'video_vimeo_url':
			$vimeo_url = esc_html( get_post_meta($js_video_id, 'video_vimeo_url', true));
			echo esc_html($vimeo_url);
			break;
		default:
			break;
	}
}


/* making custom columns SORTABLE*/
add_filter( 'manage_edit-js_videos_sortable_columns', 'LUCILLE_SWP_videos_sortable_columns');

function LUCILLE_SWP_videos_sortable_columns( $columns) 
{
	$columns['video_youtube_url'] = 'video_youtube_url';
	$columns['video_vimeo_url'] = 'video_vimeo_url';
	$columns['author'] = 'author';

	return $columns;
}


/*
	Create Category for Videos
*/
add_action( 'init', 'LUCILLE_SWP_create_video_category', 11);

function LUCILLE_SWP_create_video_category()
{
	$slug = LUCILLE_SWP_JPT_get_plugin_option("video_tax");
	if ( "" == $slug) {
		$slug = "video_category";
	}

	register_taxonomy(
			'video_category',
			'js_videos',
			array(
				'labels' => array(
					'name' => esc_html__('Video Categories', 'lucille-music-core'),
					'singular_name'     => esc_html__( 'Video Category', 'lucille-music-core'),
					'search_items'      => esc_html__( 'Search Video Categories', 'lucille-music-core' ),
					'all_items'         => esc_html__( 'All Video Categories', 'lucille-music-core' ),
					'parent_item'       => esc_html__( 'Parent Video Category', 'lucille-music-core' ),
					'parent_item_colon' => esc_html__( 'Parent Video Category:', 'lucille-music-core' ),
					'edit_item'         => esc_html__( 'Edit Video Category', 'lucille-music-core' ),
					'update_item'       => esc_html__( 'Update Video Category', 'lucille-music-core' ),
					'add_new_item' 		=> esc_html__('Add New Video Category', 'lucille-music-core'),
					'new_item_name' 	=> esc_html__('New Video Category', 'lucille-music-core'),
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

?>