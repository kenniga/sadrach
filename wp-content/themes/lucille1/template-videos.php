<?php
/*
	Template Name: Videos
*/
?>

<?php get_header(); ?>

<?php
	if (get_query_var('paged')) {
		$paged = get_query_var('paged'); 
	} elseif (get_query_var('page')) { 
		$paged = get_query_var('page'); 
	} else {
		$paged = 1; 
	}

	$posts_per_page = get_option('posts_per_page');
	$offset = ($paged - 1) * $posts_per_page;

	$args = array(
		'numberposts'	=> -1,
		'posts_per_page'   => $posts_per_page,
		'paged'			   => $paged,
		'offset'           => $offset,
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
	$keep_old_wp_query = $wp_query;

	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);

	$container_class = 'lc_content_full lc_swp_boxed lc_basic_content_padding';
	$single_item_template = "views/archive/video_item";
	$items_on_row = 2;
	$item_count = 0;


	if ($wp_query->have_posts()) {
	?>	
		<div class="<?php echo esc_attr($container_class); ?>">
			<div class="videos_container clearfix">
				<?php
				while ($wp_query->have_posts()) : the_post();
					$item_count++;
					set_query_var('items_on_row', $items_on_row);
					set_query_var('item_count', $item_count);

					get_template_part($single_item_template);
				endwhile;
				?>
			</div>
		</div>
	<?php
	}
	$wp_query = null; $wp_query = $keep_old_wp_query;
?>


<?php get_footer(); ?>