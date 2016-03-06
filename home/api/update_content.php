<?php
define(WEBROOT, '../../');
require_once(WEBROOT . "includes/bootstrap.php");

if ( !isset($_POST['text'])|| !isset($_POST['bocety']) || !isset($_POST['secret']) || !isset($_POST['id_content']) || empty($_POST['text'])||empty($_POST['bocety']) || empty($_POST['secret']) || empty($_POST['id_content']) ){
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

$Bocety->update_content($_POST['id_content'], $_POST['text']);

echo json_encode(array('msg'=>'Sucess'));
