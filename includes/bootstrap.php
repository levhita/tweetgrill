<?php
session_start();

include(WEBROOT . "includes/config.php");
require_once(WEBROOT . "includes/Autoloader.php");
require_once(WEBROOT . "includes/Utils.php");
Autoloader::register_autoload();

$Db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", "{$db_username}", "$db_password");

$scripts=array();

$logged_in=isset($_SESSION['id_user']);
if($logged_in){
	$LoggedUser = new UserModel($_SESSION['id_user']);
}