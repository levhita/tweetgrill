<?php
require_once("bootstrap.php");
require_once("Grill.php");

if ( !isset($_GET['grill']) || !isset($_GET['secret']) || empty($_GET['grill']) || empty($_GET['secret'])){
	echo json_encode(array('error'=>'Missing Parameters'));
	die();
}

try {
	$Grill = new Grill($_GET['grill']);
} catch (Exception $e) {
	echo json_encode(array('error'=>'Grill Not Found'));
	die();
}

if (!$Grill->validate_secret($_GET['secret'])) {
	echo json_encode(array('error'=>'Invalid Secret'));
	die();
}

$Grill->delete();

header("Location: /");
die();
