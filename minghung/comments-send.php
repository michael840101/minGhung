<?php
if(isset($_POST['comments'])) {
	$response = array('status' => '', 'errors'=>array());
	
	foreach($_POST['comments'] as $key => $value) {
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