<?php
require_once("bootstrap.php");
require_once("Grill.php");

$valid_fields= array('name', 'description', 'published');

foreach ($valid_fields as $field) {
	if (isset($_POST[$field]) && !empty($_POST[$field]) ) {
		//$field is left with the first valid field encoutered
		break;
	} else {
		$field='';
	}
}

if ( $field=='' || !isset($_POST['grill']) || !isset($_POST['secret']) || empty($_POST['grill']) || empty($_POST['secret']) ){
	echo json_encode(array('error'=>'Missing Parameters'));
	die();
}

try {
	$Grill = new Grill($_POST['grill']);
} catch (Exception $e) {
	echo json_encode(array('error'=>'Grill Not Found'));
	die();
}

if (!$Grill->validate_secret($_POST['secret'])) {
	echo json_encode(array('error'=>'Invalid Secret'));
	die();
}

$Grill->update_value($field, $_POST[$field]);

echo json_encode(array('msg'=>'Sucess', $field=>htmlentities($_POST[$field])));
