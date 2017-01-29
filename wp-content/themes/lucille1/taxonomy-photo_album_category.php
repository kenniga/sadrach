<?php get_header(); ?>

<?php
	$container_class = 'lc_content_full lc_blog_masonry_container blog_container';
	$single_item_template = "views/archive/post_item_masonry";

	set_query_var('lc_masonry_brick_class', 'lc_blog_masonry_brick brick3');
	set_query_var('is_cpt_archive', true);

	if (have_posts()) {
	?>	
		<div class="<?php echo esc_attr($container_class); ?>">
			<div class="blog-brick-size brick3"></div>
			<?php
			while (have_posts()) : the_post();
				get_template_part($single_item_template);
			endwhile;
			?>
		</div>
	<?php
	}
?>

<?php get_footer(); ?>