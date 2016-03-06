<?php
define("WEBROOT", '../../');
require_once(WEBROOT . "includes/bootstrap.php");

if ( !isset($_GET['bocety']) || !isset($_GET['secret']) || empty($_GET['bocety']) || empty($_GET['secret'])){
	echo json_encode(array('error'=>'Missing Parameters'));
	die();
}

try {
	$Bocety = new BocetyModel($_GET['bocety']);
} catch (Exception $e) {
	echo json_encode(array('error'=>'Bocety Not Found'));
	die();
}

if (!$Bocety->validate_secret($_GET['secret'])) {
	echo json_encode(array('error'=>'Invalid Secret'));
	die();
}

$Bocety->delete();

header("Location: /");
die();
