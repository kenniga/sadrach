<?php 

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('LC_SWP_Import')) {
	class LC_SWP_Import {
		public function __construct() {
		
		}
		
		public function import_content($file) {
			$returnVal = array(
				'status' 	=> '',
				'message'	=> ''
			);
		
			if (!defined('WP_LOAD_IMPORTERS')) {
				define('WP_LOAD_IMPORTERS', true);
			}

	        require_once ABSPATH . 'wp-admin/includes/import.php';

	        $importer_error = false;
			$error_message = '';

			/*get WP_Importer from wordpress*/
	        if ( !class_exists('WP_Importer')) {

	            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	            if (file_exists( $class_wp_importer)) {
	                require_once($class_wp_importer);
	            } else {
	                $importer_error = true;
					$error_message = "Could not locate class WP_Importer.<br>";
	            }
	        }

			/*get WP_Import*/
	        if (!class_exists( 'WP_Import' )) {
				require_once(get_template_directory()."/import/lib/wordpress-importer.php");				
	        }

	        if($importer_error){
				$returnVal['status'] = 'IMPORT_ERROR';
				$returnVal['message'] = $error_message;
				return $returnVal;
	        }
			
			if(!is_file($file)){
				$errorLoc = "The XML file containing the dummy content located at: <br>".$file." <br>is not available or could not be read.<br>";
				$errorLoc .= " You might want to try to set the file permission to chmod 755.<br>";
				
				$returnVal['status'] = 'IMPORT_ERROR';
				$returnVal['message'] = $errorLoc;
				
				return $returnVal;
			} else {
				/*import content - print error messages*/
				set_time_limit(0);
				ob_start();
				$wp_import = new WP_Import();
				$wp_import->fetch_attachments = true;
				$wp_import->import( $file );
				$this->flag_as_imported['content'] = true;
				$returnVal['message'] = ob_get_clean();
			}
			$returnVal['status'] = "IMPORT_SUCCESS";
			
			return $returnVal;
		}
	}/*class LC_SWP_Import*/
}
 
 ?>