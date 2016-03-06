<?php
define("WEBROOT", '../');
require_once(WEBROOT . "includes/bootstrap.php");

$Bocety = new BocetyModel::create();

header("Location: /edit.php?bocety={$Bocety->id_bocety}");

die();