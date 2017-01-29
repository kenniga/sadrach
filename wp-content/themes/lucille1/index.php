<?php get_header(); ?>

<div class="lc_content_full lc_swp_boxed">
	<div class="lc_content_with_sidebar lc_basic_content_padding">
		<?php if (have_posts()) : ?> <?php while (have_posts()) : the_post(); ?>

			<?php get_template_part('views/archive/post_item_standard');?>

		<?php endwhile; ?>
			<div class="page_navigation">
				<span class="page_nav_item">
					<?php next_posts_link('<i class="fa fa-long-arrow-left" aria-hidden="true"></i> Older posts'); ?>
				</span>
				<span class="page_nav_item">
					<?php previous_posts_link('Newer posts <i class="fa fa-long-arrow-right" aria-hidden="true"></i>'); ?>
				</span>
			</div>
		<?php else :
				if (is_search()) {
					echo '<p>'.esc_html__('Sorry, no results were found matching your search criteria. Please try something else.', 'lucille').'</p>';
				} else {
					echo '<p>'.esc_html__('Sorry, no posts matched your criteria.', 'lucille').'</p>';
				}
				
		endif; ?>

	</div>
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>