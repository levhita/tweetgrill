<?php
define("WEBROOT", '../../');
require_once(WEBROOT . "includes/bootstrap.php");

Utils::check_session();

$valid_fields= array('name', 'description', 'published', 'on_review');

foreach ($valid_fields as $field) {
	if (isset($_POST[$field]) && $_POST[$field]!='' ) {
		//$field is left with the first valid field encoutered
		break;
	} else {
		$field='';
	}
}

if ( $field == '' || !isset($_POST['bocety']) || empty($_POST['bocety']) ){
	echo json_encode(array('error'=>'Missing Parameters'));
	die();
}

try {
	$Bocety = new BocetyModel($_POST['bocety']);
} catch (Exception $e) {
	echo json_encode(array('error'=>'Bocety Not Found'));
	die();
}

$Bocety->update_value($field, $_POST[$field]);

echo json_encode(array('msg'=>'Sucess', $field=>htmlentities($_POST[$field])));
