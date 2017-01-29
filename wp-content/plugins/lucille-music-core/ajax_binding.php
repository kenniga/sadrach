<?php

add_action( 'wp_ajax_lucillecontactform_action', 'LUCILLE_SWP_process_contact_form' );
add_action( 'wp_ajax_nopriv_lucillecontactform_action', 'LUCILLE_SWP_process_contact_form' );

if ( !function_exists( 'LUCILLE_SWP_process_contact_form' ) ) {
	function LUCILLE_SWP_process_contact_form()
	{
		$data = array();
		parse_str($_POST['data'], $data);
		$namedError = '';
		$ret['success'] = false;
		
		if(isset($data['contactform_nonce']) && wp_verify_nonce($data['contactform_nonce'], 'lucillecontactform_action')) {
			if (sanitize_text_field($data['contactName']) === '') {
				$hasError = true;
				$namedError = 'contactName';
			} else {
				$name = sanitize_text_field($data['contactName']);
			}

			if (trim($data['email']) === '') {
				$hasError = true;
				$namedError = 'email';
			}
			else {
				if ((!is_email($data['email']))) {
					$hasError = true;
					$namedError = 'notEmail';
				} 
				else {
					$email = trim($data['email']);
				}
			}
			
			$phone = sanitize_text_field($data['phone']);

			if(sanitize_text_field($data['comments']) === '') {
				$commentError = esc_html__('Please enter a message.', 'lucille');
				$hasError = true;
				$namedError = 'comments';
			}
			else {
				$comments = sanitize_text_field($data['comments']);
			}

			/*TODO: check recaptcha here*/

			if(!isset($hasError)) {
				$emailTo = LUCILLE_SWP_LMC_get_contact_form_email();

				$email_subject = esc_html__("New contact form message from your website ", "lucille")."[" . get_bloginfo('name') . "] ";
				$email_message = $comments;
				$email_message .= "\n\n".esc_html__("Contact Phone: ", "lucille")." ".$phone."\n";
				
				$headers  = "From: " . $name . " <" . $email . ">\n";
				$headers .= "Content-Type: text/plain; charset=UTF-8\n";
				$headers .= "Content-Transfer-Encoding: 8bit\n";
				if (!wp_mail( $emailTo, $email_subject, $email_message, $headers )) {
					$namedError = 'wp_mail_failed';
				} else {
					$ret['success'] = true;	
				}
			} 
		} else {
			$namedError = 'nonce';
		}
		
		$ret['error'] = $namedError;
		echo json_encode($ret);	
		
		/*important*/
		die();
	}
}

?>