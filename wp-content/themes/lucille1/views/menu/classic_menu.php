<?php
	$header_width = esc_attr(LUCILLE_SWP_get_header_footer_width());
	/*create class: lc_swp_full/lc_swp_boxed*/
	$header_width = 'lc_swp_'.$header_width; 

	/*sticky menu*/
	$header_class = '';
	if (LUCILLE_SWP_is_sticky_menu()) {
		$header_class = 'lc_sticky_menu';
	}	
?>

<header class="<?php echo esc_attr($header_class); ?>">
	<div class="header_inner lc_wide_menu <?php echo esc_attr($header_width); ?>">
		<div id="logo">
			<?php
				$logo_img = LUCILLE_SWP_get_user_logo_img();
				if (!empty($logo_img)) {
					?>

					<a href="<?php echo home_url(); ?>">
						<img src="<?php echo esc_url($logo_img); ?>" alt="<?php bloginfo('name'); ?>">
					</a>

					<?php
				} else {
					?>

					<a href="<?php echo home_url(); ?>"> <?php bloginfo('name'); ?></a>

					<?php
				}
			?>
		</div>

		<div class="classic_header_icons">
			<?php 
			//if (in_array( 'woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
			if (LUCILLE_SWP_is_woocommerce_active()) {
			?>

				<div class="classic_header_icon">
					<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html__('View your shopping cart', 'lucille'); ?>">
						<i class="fa fa-shopping-bag" aria-hidden="true"></i>
						<span class="cart-contents-count lc_swp_vibrant_bgc">
							<?php echo WC()->cart->get_cart_contents_count(); ?>
						</span>
					</a>
				</div>
				
			<?php
			}
			?>

			<?php if (LUCILLE_SWP_show_search_on_menu()) { ?>
			<div class="classic_header_icon lc_search trigger_global_search vibrant_hover transition4">
				<span class="lnr lnr-magnifier"></span>
			</div>
			<?php } ?>
		</div>		

		<?php
		/*render main menu*/
		wp_nav_menu(
			array(
				'theme_location'	=> 'main-menu', 
				'container'			=> 'nav',
				'container_class'	=> 'classic_menu'
			)
		);
		?>
	</div>
	<?php 
	/*mobile menu*/
	get_template_part('views/menu/mobile_menu'); 
	?>
</header>