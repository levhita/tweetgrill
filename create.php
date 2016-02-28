<?php
require_once("bootstrap.php");
require_once("models/Bocety.php");

$Bocety = new Bocety();

header("Location: /edit.php?bocety={$Bocety->unique_id}&secret={$Bocety->secret}");
die();