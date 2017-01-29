<?php
/*
	Template Name: Page Photo Gallery
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
		'post_type'        => 'js_photo_albums',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true
	);	
	$keep_old_wp_query = $wp_query;

	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);

	$container_class = 'lc_content_full lc_blog_masonry_container blog_container';
	$single_item_template = "views/archive/post_item_masonry";

	set_query_var('lc_masonry_brick_class', 'lc_blog_masonry_brick brick3');
	set_query_var('is_cpt_archive', true);

	if ($wp_query->have_posts()) {
	?>	
		<div class="<?php echo esc_attr($container_class); ?>">
			<div class="blog-brick-size brick3"></div>
			<?php
			while ($wp_query->have_posts()) : the_post();
				get_template_part($single_item_template);
			endwhile;
			?>
		</div>
	<?php
	}
	$wp_query = null; $wp_query = $keep_old_wp_query;
?>


<?php get_footer(); ?>