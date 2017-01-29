<?php
/*
	Template Name: Page Contact
*/
?>

<?php get_header(); ?>

<div class="lc_content_full lc_swp_boxed lc_basic_content_padding">
	<div class="event_left contact_left">
		<h3 class="contact_section_head"><?php echo esc_html__("Send us a message", "lucille"); ?></h3>
		<?php get_template_part('views/utils/ajax_contact_form'); ?>
	</div>
	
	<div class="event_right contact_right">
		<h3 class="contact_section_head"><?php echo esc_html__("Where to find us", "lucille"); ?></h3>

		<?php
			$contact_address = LUCILLE_SWP_get_contact_address();
			$contact_email = LUCILLE_SWP_get_contact_email();
			$contact_phone = LUCILLE_SWP_get_contact_phone();
			$contact_fax = LUCILLE_SWP_get_contact_fax();
		?>

		<?php if (!empty($contact_address)) { ?>
		<div class="contact_address_entry">
			<i class="fa fa-map-marker" aria-hidden="true"></i>
			<?php echo esc_html($contact_address); ?>
		</div>
		<?php }?>

		<?php if (!empty($contact_email)) { ?>
		<div class="contact_address_entry">
			<i class="fa fa-envelope-o" aria-hidden="true"></i>
			<?php echo esc_html(sanitize_email($contact_email)); ?>
		</div>
		<?php } ?>

		<?php if (!empty($contact_phone)) { ?>
		<div class="contact_address_entry">
			<i class="fa fa-phone" aria-hidden="true"></i>
			<?php echo esc_html($contact_phone); ?>
		</div>
		<?php } ?>

		<?php if (!empty($contact_fax)) { ?>
		<div class="contact_address_entry">
			<i class="fa fa-fax" aria-hidden="true"></i>
			<?php echo esc_html($contact_fax); ?>
		</div>
		<?php } ?>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="lc_basic_content_padding">
				<?php the_content(); ?>
			</div>
		<?php endwhile; endif; ?>

		<div class="lc_social_profiles contact_page_profiles">
			<?php get_template_part('views/utils/social_profiles'); ?>
		</div>
	</div>

	<div class="clearfix"></div>
</div>

<?php get_footer(); ?>