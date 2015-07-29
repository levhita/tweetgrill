<?php
require_once("bootstrap.php");
require_once("Grill.php");

if ( !isset($_POST['text'])|| !isset($_POST['grill']) || !isset($_POST['secret']) || empty($_POST['text'])||empty($_POST['grill']) || empty($_POST['secret']) ){
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

$Tweet = $Grill->add_tweet($_POST['text']);
$Tweet->text = htmlspecialchars($Tweet->text);
echo json_encode(array('msg'=>'Sucess', 'tweet'=> $Tweet));
