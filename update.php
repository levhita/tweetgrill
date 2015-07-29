<?php
require_once("bootstrap.php");
require_once("Grill.php");

if ( !isset($_POST['text'])|| !isset($_POST['grill']) || !isset($_POST['secret']) || !isset($_POST['id_tweet']) || empty($_POST['text'])||empty($_POST['grill']) || empty($_POST['secret']) || empty($_POST['id_tweet']) ){
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

$Grill->update_tweet($_POST['id_tweet'], $_POST['text']);

echo json_encode(array('msg'=>'Sucess'));
