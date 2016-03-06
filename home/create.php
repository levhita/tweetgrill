<?php
define(WEBROOT, '../');
require_once(WEBROOT . "includes/bootstrap.php");

$Bocety = new BocetyModel();

header("Location: /edit.php?bocety={$Bocety->unique_id}&secret={$Bocety->secret}");
die();