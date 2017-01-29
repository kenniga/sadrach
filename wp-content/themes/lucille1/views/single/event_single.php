<?php

	$event_date = esc_html(get_post_meta(get_the_ID(), 'event_date', true));
	$event_time = esc_html(get_post_meta(get_the_ID(), 'event_time', true));
	
	$event_venue = esc_html(get_post_meta(get_the_ID(), 'event_venue', true));
	$event_venue_url = esc_html(get_post_meta(get_the_ID(), 'event_venue_url', true));
	
	$event_location = esc_html(get_post_meta(get_the_ID(), 'event_location', true));
	
	$event_buy_tickets_message = esc_html(get_post_meta(get_the_ID(), 'event_buy_tickets_message', true));
	$event_buy_tickets_url = esc_html(get_post_meta(get_the_ID(), 'event_buy_tickets_url', true));
	
	$event_fb_message = esc_html(get_post_meta(get_the_ID(), 'event_fb_message', true));
	$event_fb_url  = esc_html(get_post_meta(get_the_ID(), 'event_fb_url', true));
	
	$event_map_url  = get_post_meta(get_the_ID(), 'event_map_url', true);
	
	
	$event_videos_link  = esc_html(get_post_meta(get_the_ID(), 'event_videos_link', true));			
	$event_gallery_link  = esc_html(get_post_meta(get_the_ID(), 'event_gallery_link', true));

	/*data processing*/
	@$event_date = str_replace("/","-", $event_date);
	@$dateObject = new DateTime($event_date);
	$output_date = date_i18n(get_option('date_format'), $dateObject->format('U'));

	$output_time = '';
	if ($event_time != '') {
		$build_time = $event_date." ".$event_time.":00";
		if (strtotime($build_time)) {
			$time_obj =  new DateTime($build_time);
			$output_time = $time_obj->format(get_option('time_format'));
		} else {
			$output_time = $event_time;
		}		
	}

	$left_class = 'event_left';
	if (!has_post_thumbnail()) {
		$left_class = 'event_left_full';
	}

	/*if buy tickets message is empty - give it a default value*/
	if (empty($event_buy_tickets_message) && !empty($event_buy_tickets_url)) {
		$event_buy_tickets_message = esc_html__('Tickets', 'lucille');
	}

	if (empty($event_fb_message) && !empty($event_fb_url)) {
		$event_fb_message = esc_html__('Facebook Event ', 'lucille');	
	}
	

?>

<div class="lc_content_full lc_swp_boxed lc_basic_content_padding">
	<div class="<?php echo esc_attr($left_class); ?>">
		<div class="lc_event_entry">
			<i class="fa fa-calendar" aria-hidden="true"></i>
			<?php echo esc_html($output_date); ?>
		</div>

		<?php if ($output_time != '') { ?>
		<div class="lc_event_entry">
			<i class="fa fa-clock-o" aria-hidden="true"></i>
			<?php echo esc_html($output_time); ?>
		</div>
		<?php }?>

		<?php if ($event_location != '') { ?>
		<div class="lc_event_entry">
			<i class="fa fa-map-marker" aria-hidden="true"></i>
			<?php echo esc_html($event_location); ?>
		</div>
		<?php } ?>

		<?php if ($event_venue) { ?>
		<div class="lc_event_entry">
			<i class="fa fa-map-pin" aria-hidden="true"></i>
			<a href="<?php echo esc_url($event_venue_url); ?>">
				<?php echo esc_html($event_venue); ?>
			</a>
		</div>
		<?php } ?>


		<div class="small_content_padding">
			<?php if (!empty($event_buy_tickets_url)) { ?>
			<div class="lc_event_entry">
				<div class="lc_button">
					<a href="<?php echo esc_url($event_buy_tickets_url); ?>">
						<?php echo esc_html($event_buy_tickets_message); ?>
					</a>
				</div>

				<?php if (!empty($event_fb_url)) { ?>
					<div class="lc_button">
						<a href="<?php echo esc_url($event_fb_url); ?>">
							<?php echo esc_html($event_fb_message); ?>
						</a>
					</div>
				<?php } ?>					
			</div>
			<?php } ?>



			<?php the_content(); ?>
		</div>
	</div>

	<?php if (has_post_thumbnail()) { ?>
	<div class="event_right">
		<?php the_post_thumbnail('large'); ?>
	</div>
	<?php } ?>

	<div class="clearfix"></div>



</div>

<div class="lc_swp_boxed">
	<?php if (!empty($event_map_url)) { ?>
	<div class="lc_content_full gmap_container event_gmap">
		<?php 
			$allowedTags = array(
					'iframe'	=> array(
							'src'			=> array(),
							'width'			=> array(),
							'height'		=> array(),
							'frameborder'	=> array(),
							'style'			=> array()
						)
				);
			echo wp_kses($event_map_url, $allowedTags); 
		?>
	</div>
	<?php } ?>
</div>

