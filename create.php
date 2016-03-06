<?php
require_once("includes/bootstrap.php");
require_once("models/Bocety.php");

$Bocety = new BocetyModel();

header("Location: /edit.php?bocety={$Bocety->unique_id}&secret={$Bocety->secret}");
die();