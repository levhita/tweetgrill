<?php
define("WEBROOT", '../');
require_once(WEBROOT . "includes/bootstrap.php");

Utils::check_session();

$Bocety = BocetyModel::create($LoggedUser->id_user);

header("Location: /home/edit.php?bocety={$Bocety->id_bocety}");

die();