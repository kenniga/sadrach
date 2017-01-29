<?php 
function LUCILLE_SWP_setup_admin_import_menu() {
	add_theme_page(
        'Import Lucille Demos', 			/* page title*/
		'Lucille Import Demos',  			/* menu title */
		'administrator',    				/*capability*/
        'lucille_import_demo',  			/*menu_slug*/
		'LUCILLE_SWP_import_page_settings'  /*function */
	);
}
add_action("admin_menu", "LUCILLE_SWP_setup_admin_import_menu");


function LUCILLE_SWP_import_page_settings() {
	global $GLOB_IMPORT_DEMOS;
?>
	<!-- Create a header in the default WordPress 'wrap' container -->  
    <div class="wrap">  
        <div id="icon-themes" class="icon32"></div>  
        <h2 class="import_demo_title">Import Lucille Demos</h2>
			<div class="available_demos">
				<div class="import_items">
					<?php
					$demoNo = 0;
					$DEMO_ON_ROW = 3;
					$IMG_URL = get_template_directory_uri().'/import/img/';
					foreach ($GLOB_IMPORT_DEMOS as $demo) {
						if (!($demoNo % $DEMO_ON_ROW)) {
							if ($demoNo != 0) {
								echo '</div>';
							}
							
							echo '<div class="items_row">';
						}
					?>					
						<div class="items_cell">
							<img src="<?php echo $IMG_URL.$demo['img']; ?>" alt="<?php  echo $demo['name']; ?>">
							<div class="import_lucille_btn button button-primary" data-importname="<?php  echo $demo['import_name']; ?>">Import <?php  echo $demo['name']; ?> Demo</div>
						</div>
						
					<?php					
						$demoNo++;
					}
					?>
					</div>
				</div>
				
				<div class="import_spinner">
					<img src="<?php echo get_template_directory_uri().'/import/asset/spinner.gif';?>">
				</div>
			</div>
		
		
		<hr class="after_demos">
	
		<div id="import_message">
		</div>
		<div id="js_swp_import_details">
		</div>
	</div>
<?php	
}

?>