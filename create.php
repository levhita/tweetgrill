<?php
require_once("bootstrap.php");
require_once("Grill.php");

$Grill = new Grill();

header("Location: /edit.php?grill={$Grill->unique_id}&secret={$Grill->secret}");
die();