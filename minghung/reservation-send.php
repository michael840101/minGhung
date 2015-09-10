<?php
require_once 'inc/securimage/securimage.php';

/////////////////////////////////////
// Change this email address ////////
$email = "CHANGE_THIS_ADDRESS@gmail.com";

/////////////////////////////////////

$required = array('day', 'month', 'year', 'hour', 'minutes', 'ampm', 'name', 'email', 'captcha', 'phone', 'amount');
$response = array('status' => 'failed', 'errors'=>array());

if(isset($_POST['reservation'])) {
	foreach($_POST['reservation'] as $field => $value) {
		//check required field if empty
		if($value == '' && in_array($field, $required)) {
			$response['errors'][$field] = $field;
		}
	}

	//validate email
	if(!isset($response['errors']['email'])) {
		if(!filter_var($_POST['reservation']['email'], FILTER_VALIDATE_EMAIL)) {
			$response['errors']['email'] = 'email';
		}
	}

	//validate captcha
	if(!isset($response['errors']['captcha'])) {
		$securimage = new Securimage();
		if ($securimage->check($_POST['reservation']['captcha']) == false) {
			$response['errors']['captcha'] = 'captcha';
		}
	}

}

if(empty($response['errors'])) {
	$response['status'] = 'success';

	$data = $_POST['reservation'];

	$headers = "";

	$message = $data['message'];
	$message .= "\n\n";
	$message .= " Phone: " . $data['phone'];
	$message .= " Type: " . $data['booking-type'];
	$message .= " People amount: " . $data['amount'];
	$message .= " Email: " . $data['email'];

	$message .= "\n\n";
	$message .= " Day: " . $data['day'];
	$message .= " Month: " . $data['month'];
	$message .= " Year: " . $data['year'];
	$message .= " Time: " . $data['hour'] . " " . $data['minutes'] . " " . $data['ampm'];

	$subject = 'Restaurant Reservation details';
	$headers = 'From: '. $data['email']. "\r\n" .'Reply-To: '. $data['email']. "\r\n" .'X-Mailer: PHP/' . phpversion();

	
	// if (mail($email, $subject, $message, $headers)) {

	// } else {
	// 	$response['status'] = 'failed';
	// }
}


echo json_encode($response); 
