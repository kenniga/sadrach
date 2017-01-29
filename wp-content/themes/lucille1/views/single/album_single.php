<?php

	$album_buy_message1 = esc_html(get_post_meta(get_the_ID(), 'album_buy_message1', true)); 			
	$album_buy_link1 = esc_html(get_post_meta(get_the_ID(), 'album_buy_link1', true)); 			

	$album_buy_message2 = esc_html(get_post_meta(get_the_ID(), 'album_buy_message2', true)); 			
	$album_buy_link2 = esc_html(get_post_meta(get_the_ID(), 'album_buy_link2', true)); 			

	$album_buy_message3 = esc_html(get_post_meta(get_the_ID(), 'album_buy_message3', true)); 			
	$album_buy_link3 = esc_html(get_post_meta(get_the_ID(), 'album_buy_link3', true));
	
	$album_buy_message4 = esc_html(get_post_meta(get_the_ID(), 'album_buy_message4', true)); 			
	$album_buy_link4 = esc_html(get_post_meta(get_the_ID(), 'album_buy_link4', true));
	
	$album_buy_message5 = esc_html(get_post_meta(get_the_ID(), 'album_buy_message5', true)); 			
	$album_buy_link5 = esc_html(get_post_meta(get_the_ID(), 'album_buy_link5', true));
	
	$album_buy_message6 = esc_html(get_post_meta(get_the_ID(), 'album_buy_message6', true)); 			
	$album_buy_link6 = esc_html(get_post_meta(get_the_ID(), 'album_buy_link6', true));

	$album_artist = esc_html(get_post_meta(get_the_ID(), 'album_artist', true));
	$album_release_date = esc_html(get_post_meta(get_the_ID(), 'album_release_date', true));
	$album_no_disc = esc_html(get_post_meta(get_the_ID(), 'album_no_disc', true)); 
	$album_label = esc_html(get_post_meta(get_the_ID(), 'album_label', true)); 	
	$album_producer	= esc_html(get_post_meta(get_the_ID(), 'album_producer', true)); 
	$album_cat_no	= esc_html(get_post_meta(get_the_ID(), 'album_catalogue_number', true));

	$album_youtube = esc_html(get_post_meta(get_the_ID(), 'album_youtube', true ) ); 			
	$album_vimeo = esc_html(get_post_meta(get_the_ID(), 'album_vimeo', true ) );
	$website_protocol = is_ssl() ? 'https' : 'http';

	$album_SC =  get_post_meta( get_the_ID(), 'album_SC', true );

	/*data processing*/
	@$album_release_date = str_replace("/","-", $album_release_date);
	try {
		@$output_date = new DateTime($album_release_date);	
	} catch(Exception $e) {
		@$output_date = new DateTime('NOW');
	}	

?>

<div class="lc_content_full lc_swp_boxed lc_basic_content_padding">
	<div class="album_left">
		<?php the_post_thumbnail('large'); ?>

		<div class="lc_event_entry after_album_cover">
			<i class="fa fa-calendar" aria-hidden="true"></i>
			<?php echo date_i18n(get_option('date_format'), $output_date->format('U')); ?>
		</div>

		<div class="lc_event_entry">
			<i class="fa fa-music" aria-hidden="true"></i>
			<?php echo esc_html($album_artist); ?>
		</div>

		<?php if (!empty($album_label)) { ?>
		<div class="lc_event_entry">
			<i class="fa fa-tag" aria-hidden="true"></i>
			<?php echo esc_html($album_label); ?>
		</div>
		<?php } ?>

		<?php if (!empty($album_producer)) { ?>
		<div class="lc_event_entry">
			<span class="album_detail_name"><?php echo esc_html__('Producer:', 'lucille'); ?></span>
			<?php echo esc_html($album_producer); ?>
		</div>
		<?php } ?>

		
		<?php if (!empty($album_no_disc)) { ?>
		<div class="lc_event_entry">
			<span class="album_detail_name"><?php echo esc_html__('Number of discs:', 'lucille'); ?></span>
			<?php echo esc_html($album_no_disc); ?>
		</div>
		<?php } ?>

		<div class="lc_event_entry small_content_padding">
			<?php if (!empty($album_buy_message1)) { ?>
				<div class="lc_button album_buy_from">
					<a href="<?php echo esc_url($album_buy_link1); ?>">
						<?php echo esc_html($album_buy_message1); ?>
					</a>
				</div>
			<?php } ?>

			<?php if (!empty($album_buy_message2)) { ?>
				<div class="lc_button album_buy_from">
					<a href="<?php echo esc_url($album_buy_link2); ?>">
						<?php echo esc_html($album_buy_message2); ?>
					</a>
				</div>
			<?php } ?>

			<?php if (!empty($album_buy_message3)) { ?>
				<div class="lc_button album_buy_from">
					<a href="<?php echo esc_url($album_buy_link3); ?>">
						<?php echo esc_html($album_buy_message3); ?>
					</a>
				</div>
			<?php } ?>

			<?php if (!empty($album_buy_message4)) { ?>
				<div class="lc_button album_buy_from">
					<a href="<?php echo esc_url($album_buy_link4); ?>">
						<?php echo esc_html($album_buy_message4); ?>
					</a>
				</div>
			<?php } ?>

			<?php if (!empty($album_buy_message5)) { ?>
				<div class="lc_button album_buy_from">
					<a href="<?php echo esc_url($album_buy_link5); ?>">
						<?php echo esc_html($album_buy_message5); ?>
					</a>
				</div>
			<?php } ?>

			<?php if (!empty($album_buy_message6)) { ?>
				<div class="lc_button album_buy_from">
					<a href="<?php echo esc_url($album_buy_link6); ?>">
						<?php echo esc_html($album_buy_message6); ?>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>


	<div class="album_right">
		<?php
		if (!empty($album_SC)) {
				$allowed_html = array(
					'iframe' => array(
						'width' => array(),
						'height' => array(),
						'scrolling' => array(),
						'frameborder' => array(),
						'src' => array()
					)
				);
				echo wp_kses($album_SC, $allowed_html);
		} else {
			$tracks = get_attached_media( 'audio', get_the_ID() );
			$track_order = 1;

			echo '<div class="album_tracks>">';
			foreach ($tracks as $track)
			{
				echo '<div class="single_track">';
				echo '<div class="track_name"><span class="track_order">'.$track_order.".</span>".$track->post_title."</div>";
			
				$attr = array(
					'src'      => wp_get_attachment_url($track->ID),
					'loop'     => '',
					'autoplay' => '',
					'preload' => 'none'
				);
				echo wp_audio_shortcode($attr);
				echo '</div>';
				$track_order++;
			}
			echo '</div>';
		} ?>

		<?php the_content(); ?>

		<div class="lc_embed_video_container_full">
			<?php
			if ($album_youtube != "") {
			?>	
				<iframe src="<?php echo esc_attr($website_protocol); ?>://www.youtube.com/embed/<?php echo LUCILLE_SWP_getIDFromShortURL(esc_url($album_youtube)); ?>?autoplay=0&amp;enablejsapi=1&amp;wmode=transparent" allowfullscreen></iframe>
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
	</div>

	<div class="clearfix"></div>
</div>