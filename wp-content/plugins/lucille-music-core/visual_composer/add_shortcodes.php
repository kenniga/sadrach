<?php

/*
	Gallery - ok
*/
add_shortcode('js_swp_gallery', 'LUCILLE_SWP_js_gallery');
function LUCILLE_SWP_js_gallery($atts) {
	$defaults = array(
	  /*'title' => 'Featured Images',*/
	  'rowheight' => '',
	  'viewallmessage' => '',
	  'photosurl' => '',
	  'images' => ''
	);
	extract(shortcode_atts($defaults, $atts));

	/*$output = '<h2 class="short_title">'.$title.'</h2>';*/
	if ('' == $images){
		return $output;
	}
	
	if ( empty($rowheight) || !is_numeric($rowheight)) {
		$rowheight = 180;
	}
	if ( empty($viewallmessage)) {
		$viewallmessage = "View All Images";
	}
	$output = '<div class="lc_swp_justified_gallery" data-rheight="'.$rowheight.'">';
	
	$photoAlbumUnique = "photoAlbum".rand();
	$images = explode( ',', $images );
	foreach($images as $imageId) {
	
		$singleImgTag = wp_get_attachment_image( $imageId, 'full' );
		$imageAttributes = wp_get_attachment_image_src($imageId, "medium");
		
		$output .= '<div class="img_box">';
		$output .= '<div class="gallery_brick_overlay"></div>';
		$output .= '<a href="'.wp_get_attachment_url($imageId).'" data-lightbox="'.$photoAlbumUnique.'">';
		$output .= $singleImgTag;
		$output .= '</a></div>';
	}
	$output .= "</div>";
	
	$output .= '<div class="lc_view_more view_more_justified_gallery lc_swp_boxed"><a href="'.$photosurl.'">'.$viewallmessage.'</a></div>';
	return $output;
}

/*
	Latest Album - ok
*/
add_shortcode('js_swp_last_album', 'LUCILLE_SWP_js_swp_last_album');
function LUCILLE_SWP_js_swp_last_album($atts) {
	$defaults = array(
		'album_id' => '',
		'album_promo'	=> ''
	);
	extract(shortcode_atts($defaults, $atts));
	
	$my_album 		= get_post($album_id);
	$my_post_id 	= $my_album->ID;
	$my_post_title 	= $my_album->post_title;
	
	$album_artist = esc_html(get_post_meta($my_post_id, 'album_artist', true));
	$album_SC =  get_post_meta($my_post_id, 'album_SC', true );	
	
	$album_buy_message1 = esc_html(get_post_meta($my_post_id, 'album_buy_message1', true)); 			
	$album_buy_link1 = esc_html(get_post_meta($my_post_id, 'album_buy_link1', true)); 			
	$album_buy_message2 = esc_html(get_post_meta($my_post_id, 'album_buy_message2', true)); 			
	$album_buy_link2 = esc_html(get_post_meta($my_post_id, 'album_buy_link2', true)); 			
	$album_buy_message3 = esc_html(get_post_meta($my_post_id, 'album_buy_message3', true)); 			
	$album_buy_link3 = esc_html(get_post_meta($my_post_id, 'album_buy_link3', true));
	$album_buy_message4 = esc_html(get_post_meta($my_post_id, 'album_buy_message4', true)); 			
	$album_buy_link4 = esc_html(get_post_meta($my_post_id, 'album_buy_link4', true));
	$album_buy_message5 = esc_html(get_post_meta($my_post_id, 'album_buy_message5', true)); 			
	$album_buy_link5 = esc_html(get_post_meta($my_post_id, 'album_buy_link5', true));
	$album_buy_message6 = esc_html(get_post_meta($my_post_id, 'album_buy_message6', true)); 			
	$album_buy_link6 = esc_html(get_post_meta($my_post_id, 'album_buy_link6', true));	
	
	ob_start();
?>
	<div class="lc_swp_boxed clearfix">
		<div class="album_left vc_elem_album">
			<?php echo get_the_post_thumbnail($my_post_id); ?>
		</div>
		
		<div class="album_right vc_elem_album">
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
				$tracks = get_attached_media('audio', $my_post_id);
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
			}
			
			echo '<div class="small_content_padding">'.$album_promo.'</div>';
			?>
			<div class="lc_event_entry text_left">
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
		
	</div>
<?php

	$output = ob_get_clean();
	
	return $output;
}


add_shortcode('js_swp_latest_albums', 'LUCILLE_SWP_js_swp_latest_albums_scd');
function LUCILLE_SWP_js_swp_latest_albums_scd($atts) {
	$defaults = array(
		'discographypageurl' => '',
		'viewallmessage' => 'View More',
		'albumsnumber' => '3'
	);
	extract(shortcode_atts($defaults, $atts));

	$args = array(
		'numberposts'	=> $albumsnumber,
		'posts_per_page'   => $albumsnumber,
		'offset'           => 0,
		'category'         => '',
		'orderby'          => 'meta_value',
		'meta_key'         => 'album_release_date',		
		'order'            => 'DESC',
		'post_type'        => 'js_albums',
		'post_status'      => 'publish',
		'suppress_filters' => true
	); 
	
	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);



	if ( $wp_query->have_posts()) {
		$container_class = 'lc_content_full lc_swp_boxed lc_basic_content_padding';
		$items_on_row = 3;
		$item_count = 0;

		?>
		<div class="<?php echo esc_attr($container_class); ?>">
			<div class="albums_container clearfix">
				<?php
				while ($wp_query->have_posts()) {
					$wp_query->the_post();
					$item_count++;

					$has_right_padding = (0 == $item_count % $items_on_row) ? '' : ' has_right_padding';
					$bg_img_url = "";
					if (has_post_thumbnail()) {
						$bg_img_url = get_the_post_thumbnail_url('', 'full');
					}
					$album_artist = get_post_meta(get_the_ID(), 'album_artist', true);

					?>

					<div class="single_album_item<?php echo esc_attr($has_right_padding); ?>">
						<a href="<?php the_permalink();?>">
							<div class="album_image_container lc_swp_background_image" data-bgimage="<?php echo esc_url($bg_img_url); ?>">
							</div>
							<div class="album_overlay transition3"></div>
							<h3 class="album_title album_heading transition4"> <?php the_title(); ?> </h3>
							<h3 class="album_artist album_heading transition4"> <?php echo esc_html($album_artist); ?> </h3>
						</a>
					</div>

				<?php
				}
				?>
			</div>
		</div>

		<?php if (strlen($discographypageurl)) { ?>
			<div class="lc_view_more discography_view_more lc_swp_boxed">
				<a href="<?php echo esc_url($discographypageurl); ?>">
					<?php echo esc_html($viewallmessage); ?>
				</a>
			</div>
		<?php }	
	}
}

/*
	Latest Videos - ok
*/
add_shortcode('js_swp_last_videos', 'LUCILLE_SWP_js_swp_last_videos');
function LUCILLE_SWP_js_swp_last_videos($atts) {
	$defaults = array(
		'video_id' => ''
	);
	extract(shortcode_atts($defaults, $atts));

	$my_video = get_post($video_id);
	
	$videos_youtube = $videos_vimeo = array();
	$my_post_id = $my_video->ID;
	
	$video_youtube = esc_html(get_post_meta($my_post_id, 'video_youtube_url', true)); 			
	$video_vimeo = esc_html(get_post_meta($my_post_id, 'video_vimeo_url', true));
	
	if ( empty($video_youtube) && empty($video_vimeo)) {
		return "";
	}
	
	ob_start();
	?>
	
	<div class="lc_swp_boxed vc_video_container">
		<div class="lc_embed_video_container_full">
			<?php
			$website_protocol = is_ssl() ? 'https' : 'http';
			if ($video_youtube != "") {
				?>
					<iframe src="<?php echo esc_attr($website_protocol); ?>://www.youtube.com/embed/<?php echo LUCILLE_SWP_getIDFromShortURL(esc_url($video_youtube)); ?>?autoplay=0&amp;enablejsapi=1&amp;wmode=transparent&amp;rel=0&amp;showinfo=0" allowfullscreen></iframe>';
				<?php
			} else {
				if ($video_vimeo != "") {
					?>
					<iframe  src="<?php echo esc_attr($website_protocol); ?>://player.vimeo.com/video/<?php echo LUCILLE_SWP_getIDFromShortURL(esc_url($video_vimeo)); ?>?autoplay=0&amp;byline=0&amp;title=0&amp;portrait=0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
					<?php
				}
			}
			?>
		</div>
	</div>
	
	<?php
	$output = ob_get_clean();
	
	return $output;
}

/*
	Social Profiles
*/
add_shortcode('js_swp_social_profiles_icons', 'LUCILLE_SWP_social_profiles_icons');
function LUCILLE_SWP_social_profiles_icons($atts) {
	$defaults = array(
		'center_icons' => 'text_center'
	);
	extract(shortcode_atts($defaults, $atts));	
	
	$centeringClass = "text_center";
	switch ($center_icons) {
		case "text_left":
			$centeringClass = "text_left";
			break;
		case "text_right":
			$centeringClass = "text_right";
			break;
	}
	
	$user_profiles = array();
	if (function_exists('LUCILLE_SWP_get_available_social_profiles')) {
		$user_profiles = LUCILLE_SWP_get_available_social_profiles();
	}

	ob_start();
	?> <div class="social_profiles_vc_elt <?php echo esc_attr($centeringClass); ?>"> <?php
	foreach ($user_profiles as $social_profile) {
		?>
		<div class="lc_social_profile">
			<a href="<?php echo esc_url($social_profile['url']); ?>" target="_blank">
				<i class="fa fa-<?php echo esc_attr($social_profile['icon']); ?>"></i>
			</a>
		</div>
		<?php
	}
	?> </div> <?php

	$output = ob_get_clean();
	
	return $output;
}

/*
	Latest Events - ok
*/
add_shortcode('js_swp_last_events', 'LUCILLE_SWP_js_swp_last_events');
function LUCILLE_SWP_js_swp_last_events($atts) {
	$defaults = array(
		/*'title' => 'Next Events',*/
		'eventspageurl' => '',
		'viewallmessage' => 'View All Events',
		'eventsnumber' => '5'
	);
	extract(shortcode_atts($defaults, $atts));

	$args = array(
		'numberposts'	=> $eventsnumber,
		'posts_per_page'   => $eventsnumber,
		'offset'           => 0,
		'category'         => '',
		'orderby'          => 'meta_value',
		'order'            => 'ASC',
		'meta_key'         => 'event_date',
		'post_type'        => 'js_events',
		'post_status'      => 'publish',
		'suppress_filters' => true,
		'meta_query' => array(
				array(
				   'key' => 'event_date',
				   'value' => date('Y/m/d',time()),
				   'compare' => '>='
				)
		)
	); 
	
	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);
	
	/*$output = '<h2 class="short_title">'.$title.'</h2>';*/
	ob_start();
	
	if ( $wp_query->have_posts()) {
		$event_count = 0;
		?>
		<div class="lc_swp_boxed">
			<ul class="events_list vc_events_element">
				<?php
				while ($wp_query->have_posts()) {
					$wp_query->the_post();
					
					$emphasize_class =  (0 == $event_count) ? " emphasize_first"	: "";
					$event_count++;
					?>
					<li class="single_event_list clearfix <?php echo esc_attr($emphasize_class); ?>">
						<a href="<?php echo get_the_permalink(); ?>">
							<div class="event_list_entry event_date">
								<?php
								$event_date = esc_html(get_post_meta(get_the_ID(), 'event_date', true));
								if ( $event_date != "") {
									@$event_date = str_replace("/","-", $event_date);
									@$dateObject = new DateTime($event_date);
								}
								
								if ("" != $emphasize_class) {
									$el_day = $dateObject->format('d');
									$el_month = $dateObject->format('F');
									$el_year = $dateObject->format('Y');
									?>

									<span class="eventlist_day"><?php echo esc_html($el_day); ?></span>
									<span class="eventlist_month"><?php echo esc_html($el_month); ?></span>
									<span class="eventlist_year"><?php echo esc_html($el_year); ?></span>

									<?php
								} else {
									echo date_i18n(get_option('date_format'), $dateObject->format('U'));
								}
								?>							
							</div>
							
							<div class="event_list_entry event_location">
								<?php
								$event_location = get_post_meta( get_the_ID(), 'event_location', true );
								echo esc_html($event_location);
								?>
							</div>
							
							<div class="event_list_entry event_venue">
								<?php
								$event_venue = get_post_meta( get_the_ID(), 'event_venue', true);
								echo esc_html($event_venue);
								?>
							</div>
							
							<div class="event_list_entry event_buy">
								<?php
								$event_buy_tickets_url = esc_html(get_post_meta(get_the_ID(), 'event_buy_tickets_url', true ));
								$event_buy_tickets_message = esc_html(get_post_meta( get_the_ID(), 'event_buy_tickets_message', true));
								$tickets_buy_html = "";
								if (empty($event_buy_tickets_message)) {
									$event_buy_tickets_message = esc_html__('Tickets', 'jamsession');
								}
								if (empty($event_buy_tickets_url)) {
									$tickets_buy_html = esc_html__('Coming Soon', 'jamsession');
								} else {
									$tickets_buy_html = '<div class="lc_js_link" data-href="'.esc_url($event_buy_tickets_url).'" data-target="_blank">'.esc_html($event_buy_tickets_message).'</div>';
								}

								$allowed_html = array(
									'div'	=> array(
										'class'			=> array(),
										'data-href'		=> array(),
										'data-target'	=> array()
										)
									);
								echo wp_kses($tickets_buy_html, $allowed_html);
								?>
							</div>
						</a>
					</li>
				<?php	
				} /*while*/
				?>
			</ul>
			
			<?php
			if (!empty($eventspageurl)) {
			?>	
				<div class="lc_view_more vc_events_more lc_swp_boxed">
					<a href="<?php echo esc_url($eventspageurl); ?>"><?php echo esc_html($viewallmessage); ?></a>
				</div>
			<?php	
			}
			?>
		</div>
		<?php
	}
	/* Reset main query loop */
	wp_reset_query ();
	wp_reset_postdata ();	
	
	$output = ob_get_clean();
	
	return $output;
}


/*
	Contact Form - ok
*/
add_shortcode('js_swp_ajax_contact_form', 'LUCILLE_SWP_js_swp_ajax_contact_form');
function LUCILLE_SWP_js_swp_ajax_contact_form($atts) {
	$defaults = array(
		'input_styling' => ''
	);
	extract(shortcode_atts($defaults, $atts));
	
	$additional_input_class = "three_on_row" == $input_styling ? " three_on_row three_on_row_layout" : "";
	
	ob_start();
	?>
	<div class="lc_swp_boxed">
		<div class="lucille_contactform vc_lc_contactform">
			<form class="lucille_contactform">						
				<ul class="contactform_fields">

					<li class="comment-form-author vc_lc_element lucille_cf_entry<?php echo esc_attr($additional_input_class); ?>">
						<input type="text" placeholder="<?php echo esc_html__('Name ', 'lucille'); ?>" name="contactName" id="contactName" class="lucille_cf_input required requiredField contactNameInput" />
						<div class="lucille_cf_error"><?php echo esc_html__('Please enter your name', 'lucille'); ?></div>
					</li>

					<li class="comment-form-email vc_lc_element lucille_cf_entry<?php echo esc_attr($additional_input_class); ?>">
						<input type="text" placeholder="<?php echo esc_html__('Email ', 'lucille'); ?>" name="email" id="contactemail" class="lucille_cf_input required requiredField email" />
						<div class="lucille_cf_error"><?php echo esc_html__('Please enter a correct email address', 'lucille'); ?></div>
					</li>

					<li class="comment-form-url vc_lc_element lucille_cf_entry<?php echo esc_attr($additional_input_class); ?>">
						<input type="text" placeholder="<?php echo esc_html__('Phone ', 'lucille'); ?>" name="phone" id="phone" class="lucille_cf_input" />
					</li>

					<li class="comment-form-comment vc_lc_element lucille_cf_entry">
						<textarea name="comments" placeholder="<?php echo esc_html__('Message ', 'lucille'); ?>" id="commentsText" rows="10" cols="30" class="lucille_cf_input required requiredField contactMessageInput"></textarea>
						<div class="lucille_cf_error"><?php echo esc_html__('Please enter a message', 'lucille'); ?></div>
					</li>
					<?php
					/*
					//TODO: add recaptcha error here
					<li class="captcha_error">
						<span class="error"><?php echo esc_html__('Incorrect reCaptcha. Please enter reCaptcha challenge;', 'lucille'); ?></span>
					</li>
					*/
					?>
					<li class="wp_mail_error">
						<div class="lucille_cf_error"><?php echo esc_html__('Cannot send mail, an error occurred while delivering this message. Please try again later.', 'lucille'); ?></div>
					</li>	

					<li class="formResultOK">
						<div class="lucille_cf_error"><?php echo esc_html__('Your message was sent successfully. Thanks!', 'lucille'); ?></div>
					</li>
					<?php /*TODO: add recaptcha */?>
					<li>
						<input name="Button1" type="submit" id="submit" class="lc_button" value="<?php echo esc_html__('Send Email', 'lucille'); ?>" >
						<?php /*<div class="progressAction"><img src="<?php echo get_template_directory_uri()."/images/progress.gif"; ?>"></div> */ ?>
					</li>

				</ul>
				<input type="hidden" name="action" value="lucillecontactform_action" />
				<?php wp_nonce_field('lucillecontactform_action', 'contactform_nonce'); /*wp_nonce_field('lucillecontactform_action', 'contactform_nonce', true, false); */?>
			</form>
		</div>
	</div>
	<?php
	$output = ob_get_clean();
	
	return $output;
}

/*
	Section Heading - ok
*/
add_shortcode('js_swp_row_heading', 'LUCILLE_SWP_js_swp_row_heading');
function LUCILLE_SWP_js_swp_row_heading($atts) {
	$defaults = array(
		'title' 				=> "Section title",
		'title_transform'		=> "",
		'subtitle'				=>	"",
		'subtitle_transform'	=>	"",
		'text_align'			=> "text_center"
	);
	extract(shortcode_atts($defaults, $atts));
	
	$title = urldecode(base64_decode($title));
	$subtitle = urldecode(base64_decode($subtitle));

	$allowed_html = array(
			'span'	=> array(
					'class'	=> array()
				)
		);
	
	?>	
	<div class="lc_vc_section_title <?php echo esc_attr($text_align); ?>">
		<h2 class="section_title<?php echo " ".esc_attr($title_transform); ?>"><?php echo wp_kses($title, $allowed_html); ?></h2>
		<h4 class="section_subtitle<?php echo " ".esc_attr($subtitle_transform); ?>"><?php echo wp_kses($subtitle, $allowed_html); ?></h4>
	</div>
	
	<?php	
	ob_start();
	$output = ob_get_clean();
	
	return $output;
}

/*
	Lucille Button - ok
*/
add_shortcode('js_swp_theme_button', 'LUCILLE_SWP_js_swp_theme_button');
function LUCILLE_SWP_js_swp_theme_button($atts) {
	$defaults = array(
		'button_text' => 'button text',
		'button_url' => '',
		'button_align' => 'left'
	);
	
	extract(shortcode_atts($defaults, $atts));
	
	$centeringClass = "button_left";
	$hasClearfix = 0;
	switch ($button_align) {
		case "button_center":
			$centeringClass = "button_center";
			break;
		case "button_right":
			$centeringClass = "button_right";
			$hasClearfix = 1;
			break;
		default: 
			$centeringClass = "button_left";
			$hasClearfix = 1;
			break;		
	}
	
	
	$output = '<div class="lc_button '.$centeringClass.'"><a href="'.$button_url.'" alt="'.$button_text.'">'.$button_text.'</a></div>';
	if ($hasClearfix) {
		$output .= '<div class="clearfix"></div>';		
	}

	return $output;
}

/*
	User Review - ok
*/
add_shortcode('lc_swp_user_review', 'LUCILLE_SWP_lc_swp_user_review_scode');
function LUCILLE_SWP_lc_swp_user_review_scode($atts)
{
	$defaults = array(
		'reviewer_name' 	=> '',
		'reviewer_image'	=> '',
		'review_content' => ''
	);
	
	extract(shortcode_atts($defaults, $atts));
	
	ob_start();
?>
	<li>
		<div class="lc_swp_boxed text_center">
			<div class="lc_reviewer_image">
				<?php 
				if ("" != $reviewer_image) {
					echo wp_get_attachment_image($reviewer_image, "full");
				}
				?>
			</div>
			<h5 class="lc_reviewer_name"><?php echo esc_html($reviewer_name); ?></h5>
			<div class="lc_review_content">
				<?php echo esc_html($review_content); ?>
			</div>
		</div>
	</li>
<?php	
	$output = ob_get_clean();
	return $output;
}

/*
	User Review Container - ok
*/
add_shortcode('lc_review_slider', 'LUCILLE_SWP_lc_review_slider');
function LUCILLE_SWP_lc_review_slider($atts, $content = "")
{
	ob_start();
?>
	<div class="lc_swp_boxed lc_reviews_slider_container">
		<div class="lc_reviews_slider">
			<ul>
			<?php echo do_shortcode($content); ?>
			</ul>
		</div>	
	</div>
<?php	
	$output = ob_get_clean();
	return $output;
}

add_shortcode('js_swp_blog_shortcode', 'LUCILLE_SWP_js_swp_blog_shortcode');
function LUCILLE_SWP_js_swp_blog_shortcode($atts) {
	$defaults = array(
		'postsnumber' => '3'
	);
	extract(shortcode_atts($defaults, $atts));

	$args = array(
		'numberposts'	=> $postsnumber,
		'posts_per_page'   => $postsnumber,
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'post_type'        => 'post',
		'post_status'      => 'publish',
		'suppress_filters' => true
	); 	
	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);
	
	/*generic values for view*/

	$masonry_excerpt_length = 15;
	$taxonomy_type = 'category';
	$button_text = esc_html__("Read more", "lucille");	
	$grid_container_class = 'lc_swp_boxed lc_blog_masonry_container grid_container blog_container';
	
	ob_start();
	if ($wp_query->have_posts()) {
		?>
		<div class="<?php echo esc_attr($grid_container_class); ?>">
			<div class="brick3 blog-brick-size"></div>
			<?php
			while ($wp_query->have_posts()) {
				$wp_query->the_post();
				
				$post_classes = 'post_item lc_blog_masonry_brick';
				$item_details_thumb_class = '';
				if (has_post_thumbnail()) {
					$post_classes .= ' has_thumbnail';
				} else {
					$post_classes .= ' no_thumbnail';
					$item_details_thumb_class .= ' no_thumbnail vc_element';
				}				
				?>
				<article <?php post_class($post_classes);?>>
					<?php if (has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail('full', array('class' => 'lc_masonry_thumbnail_image')); ?>
						</a>

						<div class="brick_cover_bg_image transition4"></div>
						<div class="brick_bg_overlay"></div>
					<?php } ?>

					<div class="post_item_details<?php echo esc_attr($item_details_thumb_class); ?>">
						<a href="<?php the_permalink(); ?>">
							<h2 class="lc_post_title transition4 masonry_post_title">
								<?php the_title(); ?>
							</h2>
						</a>

						<div class="post_item_meta lc_post_meta masonry_post_meta">
							<?php echo get_the_date(get_option('date_format')); ?>
							<?php echo esc_html__('by', 'lucille'); ?>
							<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
								<?php the_author(); ?>
							</a>
							<?php


							if (has_term('', $taxonomy_type)) {
								echo esc_html__('in&nbsp;', 'lucille');
								the_terms('', $taxonomy_type, '', ' &#8901; ', '');
							}
							?>
						</div>


						<div class="lc_post_excerpt">
							<?php
								$default_excerpt = get_the_excerpt();
								echo "<p>".wp_trim_words($default_excerpt, $masonry_excerpt_length)."</p>";
							?>
						</div>

						<div class="lc_button">
							<a href="<?php the_permalink(); ?>">
								<?php echo esc_html($button_text); ?>
							</a>
						</div>
					</div>
				</article>
			<?php
		} /*if*/
		?>
		</div>
		<?php
	} /*while*/

	$output = ob_get_clean();
	
	/* Reset main query loop */
	wp_reset_query ();
	wp_reset_postdata ();		

	return $output;
}

/*
	Utilities
*/
function LUCILLE_SWP_put_embedded_video($youtube, $vimeo) {
	if (!function_exists('LUCILLE_SWP_getIDToEmbed')) {
		return;
	}
	
	$output = '';
	$website_protocol = is_ssl() ? 'https' : 'http';
	if ( $youtube != "") {
		$output .= '<iframe src="'.$website_protocol.'://www.youtube.com/embed/'.LUCILLE_SWP_getIDToEmbed(esc_url($youtube)).'?autoplay=0&amp;enablejsapi=1&amp;wmode=transparent&amp;showinfo=0&amp;controls=2&amp;rel=0" allowfullscreen></iframe>';
	}
	else {
		if ( $vimeo != "") {
			$output .= '<iframe src="'.$website_protocol.'://player.vimeo.com/video/'.LUCILLE_SWP_getIDToEmbed(esc_url($vimeo)).'?autoplay=0&amp;byline=0&amp;title=0&amp;portrait=0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		}
	}
	return $output;
}

?>