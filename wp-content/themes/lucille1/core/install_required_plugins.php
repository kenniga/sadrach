<?php  

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once(get_template_directory()."/assets/class-tgm-plugin-activation.php");

add_action( 'tgmpa_register', 'LUCILLE_SWP_register_required_plugins' );
function LUCILLE_SWP_register_required_plugins()
{
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 */
	$plugins = array(

		array(
			'name'     				=> 'Lucille Music Core', // The plugin name
			'slug'     				=> 'lucille-music-core', // The plugin slug (typically the folder name)
			'source'   				=>  get_template_directory() . '/plugins/lucille-music-core.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		array(
            'name'					=> 'WPBakery Visual Composer', // The plugin name
            'slug'					=> 'js_composer', // The plugin slug (typically the folder name)
            'source'				=> get_template_directory() . '/plugins/js_composer.zip', // The plugin source
            'required'				=> true, // If false, the plugin is only 'recommended' instead of required
            'version'				=> '5.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'			=> '', // If set, overrides default API URL and points to an external URL
        ),
		array(
            'name'					=> 'Slider Revolution', // The plugin name
            'slug'					=> 'revslider', // The plugin slug (typically the folder name)
            'source'				=> get_template_directory() . '/plugins/revslider.zip', // The plugin source
            'required'				=> true, // If false, the plugin is only 'recommended' instead of required
            'version'				=> '5.3.0.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'			=> '', // If set, overrides default API URL and points to an external URL
        ),		
		array(
            'name'					=> 'Envato WordPress Toolkit', // The plugin name
            'slug'					=> 'envato-wordpress-toolkit', // The plugin slug (typically the folder name)
            'source'				=> get_template_directory() . '/plugins/envato-wordpress-toolkit.zip', // The plugin source
            'required'				=> true, // If false, the plugin is only 'recommended' instead of required
            'version'				=> '1.7.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'			=> '', // If set, overrides default API URL and points to an external URL
        )
	);

	// Change this to your theme text domain, used for internationalising strings
	//$theme_text_domain = 'lucille';

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'strings'      		=> array(
			'page_title'                      => esc_html__('Install Required Plugins', 'lucille'),
			'menu_title'                      => esc_html__('Install Plugins', 'lucille'),
			'installing'                      => esc_html__('Installing Plugin: %s', 'lucille'),
			'oops'                            => esc_html__('Something went wrong with the plugin API.', 'lucille'),
			'notice_can_install_required'     => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'lucille'),
			'notice_can_install_recommended'  => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'lucille'),
			'notice_cannot_install'  		  => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'lucille'),
			'notice_can_activate_required'    => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'lucille'),
			'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'lucille'),
			'notice_cannot_activate' 		  => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'lucille'),
			'notice_ask_to_update' 			  => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'lucille'),
			'notice_cannot_update' 			  => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'lucille'),
			'install_link' 					  => _n_noop('Begin installing plugin', 'Begin installing plugins', 'lucille'),
			'activate_link' 				  => _n_noop('Activate installed plugin', 'Activate installed plugins', 'lucille'),
			'return'                          => esc_html__('Return to Required Plugins Installer', 'lucille'),
			'plugin_activated'                => esc_html__('Plugin activated successfully.', 'lucille'),
			'complete' 						  => esc_html__('All plugins installed and activated successfully. %s', 'lucille'),
			'nag_type'						  => 'updated'		
		)
	);

	tgmpa($plugins, $config);
}


?>