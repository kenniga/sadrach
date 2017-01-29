<?php

add_action('init', 'LUCILLE_SWP_create_events_post', 11);
function LUCILLE_SWP_create_events_post() 
{
	$slug = LUCILLE_SWP_JPT_get_plugin_option("event");
	if ("" == $slug) {
		$slug = "js_events";
	}
	
	register_post_type('js_events',
		array(
			'labels' => array(
				'name' =>  esc_html__('Events', 'lucille-music-core') ,
				'singular_name' =>  esc_html__('Events', 'lucille-music-core') ,
				'add_new' => esc_html__('Add New Event', 'lucille-music-core'),
				'add_new_item' => esc_html__('Add New Event', 'lucille-music-core'),
				'edit' => esc_html__('Edit', 'lucille-music-core'),
				'edit_item' => esc_html__('Edit Event', 'lucille-music-core'),
				'new_item' => esc_html__('New Event', 'lucille-music-core'),
				'view' => esc_html__('View', 'lucille-music-core'),
				'view_item' => esc_html__('View Event', 'lucille-music-core'),
				'search_items' => esc_html__('Search Events', 'lucille-music-core'),
				'not_found' => esc_html__('No Event Found','lucille-music-core'),
				'not_found_in_trash' => esc_html__('No Event Found in Trash','lucille-music-core'),
				'parent' => esc_html__('Parent Event','lucille-music-core')
			),
		'public' => true,
		'rewrite' => array(
			'slug' => $slug,
			'with_front' => false
			),		
	/*	'has_archive' => true,*/
		'supports' => array('title', 'editor', 'comments', 'thumbnail'),
		'menu_icon' => 'dashicons-calendar',
		)
	); 
}

/*
	Add metabox
*/

add_action('admin_init', 'LUCILLE_SWP_events_admin_init');
function LUCILLE_SWP_events_admin_init() 
{
	/* album information */
    add_meta_box('events_meta_box', 			/*the required HTML id attribute*/
        esc_html__('Event Settings','lucille-music-core'), 		/*text visible in the heading of meta box section*/
        'LUCILLE_SWP_display_events_meta_box',				/* callback FUNCTION which renders the contents of the meta box*/
        'js_events', 							/*the name of the custom post type where the meta box will be displayed*/
		'normal', 								/*defines the part of the page where the edit screen section should be shown*/
		'high' 									/*defines the priority within the context where the boxes should show*/
   );
}

function LUCILLE_SWP_display_events_meta_box($eventObject) 
{
    // Retrieve current name of the custom fields album ID
    $event_date = esc_html(get_post_meta($eventObject->ID, 'event_date', true));
	$event_time = esc_html(get_post_meta($eventObject->ID, 'event_time', true));
	$event_venue = esc_html(get_post_meta($eventObject->ID, 'event_venue', true));
	$event_venue_url = esc_url(get_post_meta($eventObject->ID, 'event_venue_url', true));	
	$event_location = esc_html(get_post_meta($eventObject->ID, 'event_location', true));	
	$event_buy_tickets_message = esc_html(get_post_meta($eventObject->ID, 'event_buy_tickets_message', true));		
	$event_buy_tickets_url = esc_url(get_post_meta($eventObject->ID, 'event_buy_tickets_url', true));			
	$event_fb_message = esc_html(get_post_meta($eventObject->ID, 'event_fb_message', true));
	$event_fb_url  = esc_url(get_post_meta($eventObject->ID, 'event_fb_url', true));
	$event_map_url  = esc_html(get_post_meta($eventObject->ID, 'event_map_url', true));
	$event_youtube_url  = esc_url(get_post_meta($eventObject->ID, 'event_youtube_url', true));	
	$event_vimeo_url  = esc_url(get_post_meta($eventObject->ID, 'event_vimeo_url', true));		
?>

    <table style= "width: 100%;">
       <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Event Date','lucille-music-core');?></td>
			<td ><input id="datepicker" style="width: 100%;  display: block;" type="text" name="event_date" value="<?php echo esc_attr($event_date); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('The Date for Event YYYY/MM/DD','lucille-music-core'); ?></div>
			</td>
        </tr>	
        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Event Time','lucille-music-core');?></td>
            <td ><input id="timepicker" style="width: 100%;  display: block;" type="text" name="event_time" value="<?php echo esc_attr($event_time); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('Event Time hh:mm','lucille-music-core'); ?></div>
			</td>
        </tr>
        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Event Venue','lucille-music-core');?></td>
            <td ><input style="width: 100%;  display: block;" type="text" name="event_venue" value="<?php echo esc_attr($event_venue); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('Venue ex. Glastonbury Festival','lucille-music-core'); ?></div>
			</td>
        </tr>
        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Venue URL','lucille-music-core');?></td>
            <td ><input style="width: 100%;  display: block;" type="text" name="event_venue_url" value="<?php echo esc_attr($event_venue_url); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('Venue URL ex. http://www.glastonburyfestivals.co.uk/','lucille-music-core'); ?></div>
			</td>
        </tr>		

        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Location','lucille-music-core');?></td>
            <td ><input style="width: 100%;  display: block;" type="text" name="event_location" value="<?php echo esc_attr($event_location); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('Event Location ex. Worthy Farm, Pilton GB','lucille-music-core'); ?></div>
			</td>
        </tr>		

        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Buy Tickets Message','lucille-music-core');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_buy_tickets_message" value="<?php echo esc_attr($event_buy_tickets_message); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('ex. Buy Tickets From ...','lucille-music-core'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Buy Tickets URL','lucille-music-core');?></td>
            <td ><input style="width: 100%;  display: block;" type="text" name="event_buy_tickets_url" value="<?php echo esc_attr($event_buy_tickets_url); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('ex. http://www.ticketmaster.com/','lucille-music-core'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Facebook Event Message','lucille-music-core');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_fb_message" value="<?php echo esc_attr($event_fb_message); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('ex. Check event on Facebook','lucille-music-core'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Facebook Event URL','lucille-music-core');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_fb_url" value="<?php echo esc_attr($event_fb_url); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('URL to Facebook Event Page','lucille-music-core'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Google Map Embed Code','lucille-music-core');?></td>
            <td >
            <?php
				$allowed_html = array(
					'iframe' => array(
						'width' => array(),
						'height' => array(),
						'scrolling' => array(),
						'frameborder' => array(),
						'src' => array()
					)
				);
            ?>
            	<input  style="width: 100%;  display: block;" type="text" name="event_map_url" value="<?php echo wp_kses($event_map_url, $allowed_html); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('Embedded code ex. &lt;iframe src="https://www.google.com/maps/embed?pb=.." &gt;&lt;/iframe&gt;','lucille-music-core'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Youtube URL','lucille-music-core');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_youtube_url" value="<?php echo esc_attr($event_youtube_url); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('URL to Promo Video on Youtube','lucille-music-core'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo esc_html__('Vimeo URL','lucille-music-core');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_vimeo_url" value="<?php echo esc_attr($event_vimeo_url); ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo esc_html__('URL to Promo Video on Vimeo','lucille-music-core'); ?></div>
			</td>
        </tr>	
	</table>
	
<?php
}

/* register save post function */
add_action('save_post', 'LUCILLE_SWP_save_event_fields', 10, 2);

/*
	save post function - triggered on save 
	$event_id
	$eventObject
*/
function LUCILLE_SWP_save_event_fields($event_id, $eventObject) 
{
	if ($eventObject->post_type != 'js_events') {
		return;
	}

	// Store data in post meta table if present in post data
	if (isset($_POST['event_date'])) {
		update_post_meta($event_id, 'event_date', $_POST['event_date']);
	}
	if (isset($_POST['event_time'])) {
		update_post_meta($event_id, 'event_time', $_POST['event_time']);
	}
	if (isset($_POST['event_venue'])) {
		update_post_meta($event_id, 'event_venue', $_POST['event_venue']);
	}
	if (isset($_POST['event_venue_url'])) {
		update_post_meta($event_id, 'event_venue_url', $_POST['event_venue_url']);
	}
	if (isset($_POST['event_location'])) {
		update_post_meta($event_id, 'event_location', $_POST['event_location']);
	}
	if (isset($_POST['event_buy_tickets_message'])) {
		update_post_meta($event_id, 'event_buy_tickets_message', $_POST['event_buy_tickets_message']);
	}
	if (isset($_POST['event_buy_tickets_url'])) {
		update_post_meta($event_id, 'event_buy_tickets_url', $_POST['event_buy_tickets_url']);
	}
	if (isset($_POST['event_fb_message'])) {
		update_post_meta($event_id, 'event_fb_message', $_POST['event_fb_message']);
	}
	if (isset($_POST['event_fb_url'])) {
		update_post_meta($event_id, 'event_fb_url', $_POST['event_fb_url']);
	}
	if (isset($_POST['event_map_url'])) {
		update_post_meta($event_id, 'event_map_url', $_POST['event_map_url']);
	}
	if (isset($_POST['event_youtube_url'])) {
		update_post_meta($event_id, 'event_youtube_url', $_POST['event_youtube_url']);
	}
	if (isset($_POST['event_vimeo_url'])) {
		update_post_meta($event_id, 'event_vimeo_url', $_POST['event_vimeo_url']);
	}
}

/*
	Adding custom columns to admin menu using filter  [manage_edit-{post_type}_columns]
*/
add_filter('manage_edit-js_events_columns', 'LUCILLE_SWP_jamsession_events_admin_columns_func');

function LUCILLE_SWP_jamsession_events_admin_columns_func($columns)
{
	$columns = array(
		'title' => esc_html__('Album Title', 'lucille-music-core'),
		'event_date'	=>	__('Date', 'lucille-music-core'),				
		'event_location' => esc_html__('Location', 'lucille-music-core'),
		'event_venue'	=>	__('Venue', 'lucille-music-core'),
		'author'	=> esc_html__('Author', 'lucille-music-core'),
		'date'		=> esc_html__('Date', 'lucille-music-core')		
	);
	
	return $columns;
}

/*
	Fill the custom columns on admin
*/

add_action('manage_js_events_posts_custom_column', 'LUCILLE_SWP_manage_js_events_columns_func', 10, 2);

function LUCILLE_SWP_manage_js_events_columns_func($column, $event_id)
{
	global $post;
	
	switch($column) {
		case 'event_date' :
			$event_date = get_post_meta($event_id, 'event_date', true);
			echo esc_html($event_date);
			break;
		case 'event_location':
			$event_location = get_post_meta($event_id, 'event_location', true);
			echo esc_html($event_location);
			break;
		case 'event_venue':
			$event_venue = get_post_meta($event_id, 'event_venue', true);
			echo esc_html($event_venue);
			break;			
		default:
			break;
	}
}


/*
	Create Category for Events
*/
add_action('init', 'LUCILLE_SWP_create_event_category', 11);

function LUCILLE_SWP_create_event_category()
{
	$slug = LUCILLE_SWP_JPT_get_plugin_option("event_tax");
	if ("" == $slug) {
		$slug = "event_category";
	}
	
	register_taxonomy(
			'event_category',
			'js_events',
			array(
				'labels' => array(
					'name' => esc_html__('Event Categories', 'lucille-music-core'),
					'singular_name'     => esc_html__('Event Category', 'lucille-music-core'),
					'search_items'      => esc_html__('Search Event Categories', 'lucille-music-core' ),
					'all_items'         => esc_html__('All Event Categories', 'lucille-music-core' ),
					'parent_item'       => esc_html__('Parent Event Category', 'lucille-music-core' ),
					'parent_item_colon' => esc_html__('Parent Event Category:', 'lucille-music-core' ),
					'edit_item'         => esc_html__('Edit Event Category', 'lucille-music-core' ),
					'update_item'       => esc_html__('Update Event Category', 'lucille-music-core' ),
					'add_new_item' 		=> esc_html__('Add New Event Category', 'lucille-music-core'),
					'new_item_name' 	=> esc_html__('New Event Category', 'lucille-music-core'),
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