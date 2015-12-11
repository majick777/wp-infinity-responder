<?php

// SMTP PHPMailer Prototype
// ----------------------

if (get_option('inf_resp_mailer') == 'wp_mail') {
	if (get_option('inf_resp_smtp') == 'yes') {
		add_action( 'phpmailer_init', 'inf_resp_configure_smtp' );
	}
}

function inf_resp_configure_smtp( PHPMailer $phpmailer ) {

	// Host: mail.mydomain.com
	// Port: 25
	// Username: email@emailaddress.com
	// Password: somepassword
	$vsmtphost = get_option('inf_resp_smtp_host');
	$vsmtpport = get_option('inf_resp_smtp_port');
	$vusername = get_option('inf_resp_smtp_username');
	$vpassword = get_option('inf_resp_smtp_password');

	$phpmailer->isSMTP(); 
	$phpmailer->Host = $vsmtphost;
	$phpmailer->SMTPAuth = true;
	$phpmailer->Port = $vport;
	$phpmailer->Username = $vusername;
	$phpmailer->Password = $vpassword;
	$phpmailer->SMTPSecure = false;
	// $phpmailer->From = 'sender@yourdomain.com';
	// $phpmailer->FromName='Sender Name';
}
		
// if(!$phpmailer ->Send()) {
//    echo 'Message could not be sent.';
//    echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
// }
	
?>