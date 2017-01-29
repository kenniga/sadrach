<?php get_header(); ?>

<?php
	$container_class = 'lc_content_full lc_swp_boxed lc_basic_content_padding';
	$single_item_template = "views/archive/video_item";
	$items_on_row = 2;
	$item_count = 0;

	if (have_posts()) {
	?>	
		<div class="<?php echo esc_attr($container_class); ?>">
			<div class="videos_container clearfix">
				<?php
				while (have_posts()) : the_post();
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
?>

<?php get_footer(); ?>