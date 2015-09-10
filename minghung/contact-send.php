<?php
require_once 'inc/securimage/securimage.php';

/////////////////////////////////////
// Change this email address ////////
$email = "management@minghungcuisine.com";

/////////////////////////////////////

$required = array('name', 'email', 'subject', 'message');
$response = array('status' => 'failed', 'errors'=>array());

if(isset($_POST['contact'])) {
	foreach($_POST['contact'] as $field => $value) {
		//check required field if empty
		if($value == '' && in_array($field, $required)) {
			$response['errors'][$field] = $field;
		}
	}

	//validate email
	if(!isset($response['errors']['email'])) {
		if(!filter_var($_POST['contact']['email'], FILTER_VALIDATE_EMAIL)) {
			$response['errors']['email'] = 'email';
		}
	}
}

if(empty($response['errors'])) {
	$response['status'] = 'success';

	$data = $_POST['contact'];

	$headers = "";

	$message = $data['message'];
	$message .= "\n\n";
	$message .= " Name: " . $data['name'];
	$message .= " Email: " . $data['email'];

	$subject = 'Subject: '. $data['subject']. "\r\n";
	$headers = 'From: '. $data['email']. "\r\n" .'Reply-To: '. $data['email']. "\r\n" .'X-Mailer: PHP/' . phpversion();

	
	if (mail($email, $subject, $message, $headers)) {

	} else {
		$response['status'] = 'failed';
	}
}

echo json_encode($response);
		

?>