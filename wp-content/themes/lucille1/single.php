<?php get_header(); ?>


	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<?php
		switch(get_post_type(get_the_ID())) {
			case "js_albums":
				get_template_part('views/single/album_single');
				break;
			case 'js_events':
				get_template_part('views/single/event_single');
				break;
			case 'js_photo_albums':
				get_template_part('views/single/photo_album_single');
				break;
			case 'js_videos':
				get_template_part('views/single/video_single');
				break;
			default:
				get_template_part('views/single/default_single');
				break;
		}

		?>
	<?php endwhile; else : ?>
		<div class="lc_content_full lc_swp_boxed">
			<p><?php esc_html__('Sorry, no posts matched your criteria.', 'lucille'); ?></p>
		</div>
	<?php endif; ?>


<?php get_footer(); ?>