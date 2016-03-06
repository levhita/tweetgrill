<?php
require_once("includes/bootstrap.php");
require_once("models/Bocety.php");

$valid_fields= array('name', 'description', 'published');

foreach ($valid_fields as $field) {
	if (isset($_POST[$field]) && $_POST[$field]!='' ) {
		//$field is left with the first valid field encoutered
		break;
	} else {
		$field='';
	}
}

if ( $field == '' || !isset($_POST['bocety']) || !isset($_POST['secret']) || empty($_POST['bocety']) || empty($_POST['secret']) ){
	echo json_encode(array('error'=>'Missing Parameters'));
	die();
}

try {
	$Bocety = new BocetyModel($_POST['bocety']);
} catch (Exception $e) {
	echo json_encode(array('error'=>'Bocety Not Found'));
	die();
}

if (!$Bocety->validate_secret($_POST['secret'])) {
	echo json_encode(array('error'=>'Invalid Secret'));
	die();
}

$Bocety->update_value($field, $_POST[$field]);

echo json_encode(array('msg'=>'Sucess', $field=>htmlentities($_POST[$field])));
