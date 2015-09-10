<?php
if(isset($_POST['reviews'])) {
	$response = array('status' => '', 'errors'=>array());
	
	foreach($_POST['reviews'] as $key => $value) {
		if($value == '') {
			$response['errors'][$key.'-error'] = 'error'; 
		}
	}
	if(empty($response['errors'])) {
		$response['status'] = 'ok';
	} else {
		$response['status'] = 'error';
	}
	echo json_encode($response);
}
?>