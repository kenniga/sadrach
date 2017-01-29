<?php
class LUCILLE_SWP_recent_posts_with_images extends WP_Widget {
	/* Sets up the widgets name etc */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget widget_lucille_recent_posts widget_recent_entries',
			'description' => esc_html__('Recent Posts With Images', 'lucille-music-core'),
		);
		parent::__construct('LUCILLE_SWP_recent_posts_with_images', 'Lucille Recent Posts', $widget_ops);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance) {
		$allowed_html = array(
			'div'	=> array(
				'id'	=> array(),
				'class'	=> array()
			),
			'li'	=> array(
				'id'	=> array(),
				'class'	=> array()
			),
			'h3'	=> array(
				'id'	=> array(),
				'class'	=> array()
			)
		);

		echo wp_kses($args['before_widget'], $allowed_html);
		if (!empty($instance['title'])) {
			echo wp_kses($args['before_title'], $allowed_html) . apply_filters('widget_title', $instance['title']) . wp_kses($args['after_title'], $allowed_html);
		}
		
		$number_of_posts = intval($instance['number_of_posts']);
		$query_args = array(
			'post_type' 	=> 'post',
			'post_status'   => 'publish',
			'numberposts'	=> $number_of_posts,
			'posts_per_page'=> $number_of_posts,
			'orderby'       => 'post_date',
			'order'         => 'DESC'
		);
		
		$my_query = new WP_Query($query_args);
		if ($my_query->have_posts()) {
			echo '<ul>';
			while ($my_query->have_posts()) {
				$my_query->the_post();
				?>
				<li class="clearfix">
					<?php 
					if(has_post_thumbnail()) {
						the_post_thumbnail();
					} else {
						/*add default*/
						?>
						<div class="lnwidtget_no_featured_img">
							<?php bloginfo('name'); ?>
						</div>
						<?php
					}
					?>
					<a href="<?php esc_url(the_permalink()); ?>">
					<?php echo esc_html(get_the_title()); ?>
					</a>
					<span class="post-date"><?php echo esc_html(get_the_date()); ?></span>
				</li>
				<?php
			}
			echo '</ul>';
			/* Restore original Post Data */
			wp_reset_postdata();
		}
		echo wp_kses($args['after_widget'], $allowed_html);
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form($instance) {
		// outputs the options form on admin
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('Latest News', 'lucille-music-core');
		$number_of_posts = !empty($instance['number_of_posts']) ? intval($instance['number_of_posts']) : '5';
		?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'lucille-music-core'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
			
			<label for="<?php echo esc_attr($this->get_field_id('number_of_posts')); ?>"><?php esc_attr_e('Number of posts:', 'lucille-music-core'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('number_of_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('number_of_posts')); ?>" type="text" value="<?php echo esc_attr(intval($number_of_posts)); ?>">
		</p>
		
		<?php 		
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : 'Latest News';
		$instance['number_of_posts'] = (!empty($new_instance['number_of_posts'])) ? intval(($new_instance['number_of_posts'])) : '5';

		return $instance;
	}
}

add_action('widgets_init', function(){
	register_widget('LUCILLE_SWP_recent_posts_with_images');
});

class LUCILLE_SWP_next_events extends WP_Widget {
	/* Sets up the widgets name etc */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget widget_lucille_next_events widget_recent_entries',
			'description' => esc_html__('Shows The Next Events', 'lucille-music-core'),
		);
		parent::__construct('LUCILLE_SWP_next_events', 'Lucille Next Events', $widget_ops);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance) {
		$allowed_html = array(
			'div'	=> array(
				'id'	=> array(),
				'class'	=> array()
			),
			'li'	=> array(
				'id'	=> array(),
				'class'	=> array()
			),
			'h3'	=> array(
				'id'	=> array(),
				'class'	=> array()
			)
		);
		echo wp_kses($args['before_widget'], $allowed_html);
		if (!empty($instance['title'])) {
			echo wp_kses($args['before_title'], $allowed_html) . apply_filters('widget_title', $instance['title']) . wp_kses($args['after_title'], $allowed_html);
		}
		
		$number_of_posts = intval($instance['number_of_posts']);
		$query_args = array(
			'numberposts'	=> $number_of_posts,
			'posts_per_page'   => $number_of_posts,
			'offset'           => 0,
			'category'         => '',
			'orderby'          => array('event_date' => 'ASC', 'event_time' => 'ASC'),
			'order'            => 'ASC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => 'event_date',
			'meta_value'       => '',
			'post_type'        => 'js_events',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => 'publish',
			'meta_query' => array(
				'relation' => 'AND',
				'event_date' => array(
				   'key' => 'event_date',
				   'value' => date('Y/m/d',current_time('timestamp')),
				   'compare' => '>='
				),
				'event_time' => array(
				   'key' => 'event_time'
				)				
			),
			'suppress_filters' => true
		);
		
		$my_query = new WP_Query($query_args);
		if ($my_query->have_posts()) {
			echo '<ul>';
			while ($my_query->have_posts()) {
				$my_query->the_post();
				
				$post_id = get_the_ID();
				$event_date = esc_html(get_post_meta($post_id, 'event_date', true));
				 if ($event_date != "") {
					@$event_date = str_replace("/","-", $event_date);
					@$dateObject = new DateTime($event_date);
				}
				$el_day = $dateObject->format('d');
				$el_month = $dateObject->format('F');

				?>
				<li class="clearfix">
					<div class="wg_event_date">
						<span class="eventlist_day"><?php echo esc_html($el_day); ?></span>
						<span class="eventlist_month"><?php echo esc_html($el_month); ?></span>
					</div>
					
					<a href="<?php esc_url(the_permalink()); ?>">
						<?php echo esc_html(get_the_title()); ?>
					</a>
				</li>
				<?php
			}
			echo '</ul>';
			/* Restore original Post Data */
			wp_reset_postdata();
		}
		echo wp_kses($args['after_widget'], $allowed_html);
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form($instance) {
		// outputs the options form on admin
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('Upcoming Events', 'lucille-music-core');
		$number_of_posts = !empty($instance['number_of_posts']) ? intval($instance['number_of_posts']) : '5';
		?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'lucille-music-core'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
			
			<label for="<?php echo esc_attr($this->get_field_id('number_of_posts')); ?>"><?php esc_attr_e('Number of posts:', 'lucille-music-core'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('number_of_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('number_of_posts')); ?>" type="text" value="<?php echo esc_attr(intval($number_of_posts)); ?>">
		</p>
		
		<?php 		
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : 'Upcoming Events';
		$instance['number_of_posts'] = (!empty($new_instance['number_of_posts'])) ? intval(($new_instance['number_of_posts'])) : '5';

		return $instance;
	}
}

add_action('widgets_init', function(){
	register_widget('LUCILLE_SWP_next_events');
});

?>