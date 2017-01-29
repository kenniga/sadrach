<?php
/*
	Template Name: Events - Past
*/
?>

<?php get_header(); ?>

<?php
	$args = array(
		'numberposts'	=> 100,
		'posts_per_page'   => 100,
		'offset'           => 0,
		'category'         => '',
		'orderby'          => array('event_date' => 'DESC', 'event_time' => 'DESC'),
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => 'event_date',
		'meta_value'       => '',
		'post_type'        => 'js_events',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'meta_query' => array(
			'relation' => 'AND',
			'event_date' => array(
			   'key' => 'event_date',
			   'value' => date('Y/m/d',current_time('timestamp')),
			   'compare' => '<'
			),
			'event_time' => array(
			   'key' => 'event_time'
			)
		),
		'suppress_filters' => true
	);
	$next_events = get_posts($args);

	$events_to_show = array();
	foreach($next_events as $single_event) {
		global $post;
		$post = $single_event;
		setup_postdata($post);

		$array_entry = array();

		$post_id = get_the_ID();
		$event_date = esc_html(get_post_meta($post_id, 'event_date', true));
		 if ($event_date != "") {
			@$event_date = str_replace("/","-", $event_date);
			@$dateObject = new DateTime($event_date);
		}

		$array_entry['dateObj'] = $dateObject;
		$array_entry['event_date_computed'] = phpversion() >= "5.3" ? date_i18n(get_option('date_format'), $dateObject->getTimestamp()) : date_i18n(get_option('date_format'), $dateObject->format('U'));
		$array_entry['event_location'] = esc_html(get_post_meta($post_id, 'event_location', true));
		$array_entry['event_venue'] = esc_html(get_post_meta($post_id, 'event_venue', true));
		$array_entry['event_buy_tickets_message'] = esc_html(get_post_meta($post_id, 'event_buy_tickets_message', true));
		$array_entry['event_buy_tickets_url'] = esc_html(get_post_meta($post_id, 'event_buy_tickets_url', true));
		$array_entry['event_url'] = get_the_permalink();
		$array_entry['event_title'] = get_the_title();

		$events_to_show[] = $array_entry;
	}
?>

<div class="lc_content_full lc_swp_boxed">
	<?php 
		set_query_var('events_to_show', $events_to_show);
		set_query_var('emphasize_first', '0');
		get_template_part('views/archive/events_list'); 
	?>
</div>

<?php get_footer(); ?>