<?php 
/*
	@var 
		$events_to_show = array(
			array(
				'dateObj'	=>	DateTime()
				'event_date_computed'
				'event_location'
				'event_venue'
				'event_buy_tickets_message'
				'event_buy_tickets_url'
				'event_url'
			)
		);
		$emphasize_first - 0/1
*/
		$event_count = 0;
?>

<ul class="events_list">
	<?php

	$show_event_title = LUCILLE_SWP_show_event_title();

	foreach ($events_to_show as $event) { 
			$emphasize_class =  ((0 == $event_count) && ('1' == $emphasize_first)) ? " emphasize_first"	: "";
			$event_count++;

			/*decide what to show on 2nd and 3rd column, based on theme settings*/
			if ($show_event_title) {
				$second_col = $event['event_location'] . '&#32;&#45;&#32;' . $event['event_venue'];
				$third_col = $event['event_title'];
			} else {
				$second_col = $event['event_location'];
				$third_col = $event['event_venue'];
			}
			

	?>
		<li class="single_event_list clearfix <?php echo esc_attr($emphasize_class); ?>">
			<a href="<?php echo esc_url($event['event_url']); ?>">
				<div class="event_list_entry event_date">
					<?php 
					if ("" != $emphasize_class) {
						$el_day = $event['dateObj']->format('d');
						$el_month = $event['dateObj']->format('F');
						$el_year = $event['dateObj']->format('Y');
						?>

						<span class="eventlist_day"><?php echo esc_html($el_day); ?></span>
						<span class="eventlist_month"><?php echo esc_html($el_month); ?></span>
						<span class="eventlist_year"><?php echo esc_html($el_year); ?></span>

						<?php
					} else {
						echo esc_html($event['event_date_computed']);
					}
					?>
				</div>

				<div class="event_list_entry event_location">
					<?php echo esc_html($second_col); ?>
				</div>

				<div class="event_list_entry event_venue">
					<?php echo esc_html($third_col); ?>
				</div>

				<div class="event_list_entry event_buy">
						<div class="lc_js_link" data-href="<?php echo esc_url($event['event_buy_tickets_url']); ?>" data-target="_blank">
							<?php echo esc_html($event['event_buy_tickets_message']); ?>
						</div>
				</div>
			</a>
		</li>
	<?php 
	} 
	?>
</ul>