<?php
define("WEBROOT", '../../');
require_once(WEBROOT . "includes/bootstrap.php");

Utils::check_session();

if ( !isset($_POST['text'])|| !isset($_POST['id_bocety']) || empty($_POST['text'])||empty($_POST['id_bocety']) ){
	echo json_encode(array('error'=>'Missing Parameters'));
	die();
}

try {
	$Bocety = new BocetyModel($_POST['id_bocety']);
} catch (Exception $e) {
	echo json_encode(array('error'=>'Bocety Not Found'));
	die();
}

#$Bocety->validate_property();

$Content = $Bocety->add_content($_POST['text']);
$Content->text = htmlspecialchars($Content->text);
echo json_encode(array('msg'=>'Sucess', 'content'=> $Content));
