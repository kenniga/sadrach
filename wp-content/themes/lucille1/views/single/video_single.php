<?php
	$album_youtube = esc_html(get_post_meta(get_the_ID(), 'video_youtube_url', true)); 			
	$album_vimeo = esc_html(get_post_meta(get_the_ID(), 'video_vimeo_url', true));
	$website_protocol = is_ssl() ? 'https' : 'http';
?>

<div class="lc_content_full lc_swp_boxed lc_basic_content_padding">
	<div class="lc_embed_video_container_full">
	<?php
		if ($album_youtube != "") {
			?>
				<iframe src="<?php echo esc_attr($website_protocol); ?>://www.youtube.com/embed/<?php echo LUCILLE_SWP_getIDFromShortURL(esc_url($album_youtube)); ?>?autoplay=0&amp;enablejsapi=1&amp;wmode=transparent&amp;rel=0&amp;showinfo=0" allowfullscreen></iframe>';
			<?php
		} else {
			if ($album_vimeo != "") {
				?>
				<iframe src="<?php echo esc_attr($website_protocol); ?>://player.vimeo.com/video/<?php echo LUCILLE_SWP_getIDFromShortURL(esc_url($album_vimeo)); ?>?autoplay=0&amp;byline=0&amp;title=0&amp;portrait=0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				<?php
			}
		}
	?>
	</div>

	<?php the_content(); ?>

	<?php get_template_part('views/utils/sharing_icons'); ?>
	<?php get_template_part('views/utils/post_tags'); ?>
</div>