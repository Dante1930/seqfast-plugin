<?php 
/**
 * This function displays the validation messages, the success message, the container of the validation messages, and the
 * contact form.
 */

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 use PHPMailer\PHPMailer\SMTP;

 function send_smtp_email( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = '2b2b971600e13a';
    $phpmailer->Password = '531b825f3f488f';
    $phpmailer->From       = 'qa.seqfast@gmail.com';
    $phpmailer->FromName   = 'From Name';
    $phpmailer->addReplyTo('info@example.com', 'Information');
}

function set_my_mail_content_type() {
    return "text/html";
}

function display_contact_form() {

	$validation_messages = [];
	$success_message = '';
	

	if ( isset( $_POST['contact_form'] ) ) {

		//Sanitize the data
		$full_name = isset( $_POST['full_name'] ) ? sanitize_text_field( $_POST['full_name'] ) : '';
		$email     = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
		$message   = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

		//Validate the data
		if ( strlen( $full_name ) === 0 ) {
			$validation_messages[] = esc_html__( 'Please enter a valid name.', 'Divi' );
		}

		if ( strlen( $email ) === 0 or
		     ! is_email( $email ) ) {
			$validation_messages[] = esc_html__( 'Please enter a valid email address.', 'Divi' );
		}

		if ( strlen( $message ) === 0 ) {
			$validation_messages[] = esc_html__( 'Please enter a valid message.', 'Divi' );
		}



		//Send an email to the WordPress administrator if there are no validation errors
		if ( empty( $validation_messages ) ) {
            global $wpdb,$table_prefix;
            $wp_emp = $table_prefix.'contactForm';


            $data= array(
                'name'=>$full_name,
                'email'=>$email,
                'message'=>$message,
                'status'=> 0,
                'created_at'=>date("Y-m-d H:i:s")
            );

            //die(print_r($data));
        
            $wpdb->insert($wp_emp,$data);
        

            // add_filter( 'wp_mail_content_type','set_my_mail_content_type' );
            // add_action( 'phpmailer_init', 'send_smtp_email' );
			// // $mail    = get_option( 'admin_email' );
            // if (defined('WP_CLI')) {
            //     WP_CLI::add_wp_hook('wp_mail_from', function () {
            //         return 'qa.seqfast@gmail.com';
            //     });
            // } else {
            //     add_filter('wp_mail_from', function () {
            //         return 'qa.seqfast@gmail.com';
            //     });
            // }
     
            // $mail    = 'qa.seqfast@gmail.com';
			// $subject = 'New message from ' . $full_name;
			// $message = $message . ' - The email address of the customer is: ' . $email;
            // $headers = 'From: '.$full_name.' <'.$mail.'>' . "\r\n" . 'Reply-To: ' . $email;





			// $send_mail  = wp_mail( $mail, $subject, $message);
            // remove_filter( 'wp_mail_content_type','set_my_mail_content_type' )
            // remove_action( 'phpmailer_init', 'send_smtp_email' );
        

            // if(!$send_mail){
            //     var_dump($GLOBALS['phpmailer']->ErrorInfo);
            // }



			$success_message = esc_html__( 'Your message has been successfully sent.', 'Divi' );

		}

	}

    ob_start();

	//Display the validation errors
	if ( ! empty( $validation_messages ) ) {
		foreach ( $validation_messages as $validation_message ) {
			echo '<div class="validation-message">' . esc_html( $validation_message ) . '</div>';
		}
	}

	//Display the success message
	if ( strlen( $success_message ) > 0 ) {
		echo '<div class="success-message">' . esc_html( $success_message ) . '</div>';
	}
	
	

	?> 
    <form id="contact-form" action="<?php echo esc_url( get_permalink() ); ?>"
          method="post">

        <input type="hidden" name="contact_form">

        <input name="form_nonce" type="hidden" value="<?=wp_create_nonce('test-nonce')?>" />

        <div class="form-section">
            <label for="full-name"><?php echo esc_html( 'Full Name', 'Divi' ); ?> *</label>
            <input type="text" id="full-name" name="full_name">
        </div>

        <div class="form-section">
            <label for="email"><?php echo esc_html( 'Email', 'Divi' ); ?> *</label>
            <input type="text" id="email" name="email">
        </div>

        <div class="form-section">
            <label for="message"><?php echo esc_html( 'Message', 'Divi' ); ?> *</label>
            <textarea id="message" name="message" rows="3"></textarea>
        </div>
		
        <input type="submit" id="contact-form-submit" value="<?php echo esc_attr( 'Submit', 'Divi' ); ?>">

    </form>
		<div id="validation-messages-container"></div>			

	<?php
	return ob_get_clean();
}

add_shortcode( 'custom-contact-form', 'display_contact_form' );
?>