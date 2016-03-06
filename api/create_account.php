<?php
require_once("includes/bootstrap.php");
require_once("models/User.php");

if ( !isset($_POST['email'])|| !isset($_POST['password']) || empty($_POST['email'])||empty($_POST['password']) ){
	echo json_encode(array('error'=>'Missing Parameters'));
	die();
}

try {
	$User = UserModel::create($_POST['email'], $_POST['password']);
} catch (Exception $e) {
	echo json_encode(array('error'=>'Email adress already registered.'));
	die();
}

$_SESSION['id_user']=$User->id_user;

echo json_encode(array('msg'=>'Sucess', 'user'=> $User->getData()));