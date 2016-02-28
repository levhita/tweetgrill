<?php
require_once("bootstrap.php");
require_once("models/User.php");

if ( !isset($_POST['email'])|| !isset($_POST['password']) || empty($_POST['email'])||empty($_POST['password']) ){
	echo json_encode(array('error'=>'Missing Parameters'));
	die();
}

try {
	$User = User::create($_POST['email'], $_POST['password']);
} catch (Exception $e) {
	echo json_encode(array('error'=>'User already registered'));
	die();
}

echo json_encode(array('msg'=>'Sucess', 'user'=> $User->getData()));