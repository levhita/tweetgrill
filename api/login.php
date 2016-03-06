<?php
define(WEBROOT, '../');
require_once(WEBROOT . "includes/bootstrap.php");

if ( !isset($_POST['email'])|| !isset($_POST['password']) || empty($_POST['email'])||empty($_POST['password']) ){
	echo json_encode(array('error'=>'Missing Parameters'));
	die();
}

try {
	$User = UserModel::get_by_email($_POST['email']);
} catch (Exception $e) {
	echo json_encode(array('error'=>'Wrong username or password.'));
	die();
}

if(!$User->validate_password($_POST['password'])) {
	echo json_encode(array('error'=>'Wrong password or username.'));
	die();	
}

$_SESSION['id_user'] = $User->id_user;

echo json_encode(array('msg'=>'Sucess', 'user'=> $User->getData()));