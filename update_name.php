<?php
require_once("bootstrap.php");
require_once("Grill.php");

if ( !isset($_POST['name'])|| !isset($_POST['grill']) || !isset($_POST['secret']) || empty($_POST['name'])||empty($_POST['grill']) || empty($_POST['secret']) ){
	echo json_encode(array('error'=>'Missing Parameters'));
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

$Grill->update_name($_POST['name']);

echo json_encode(array('msg'=>'Sucess', 'name'=>htmlentities($_POST['name'])));
