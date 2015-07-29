<?php
require_once("bootstrap.php");
require_once("Grill.php");

if ( !isset($_GET['grill']) || empty($_GET['grill']) ){
	header("Location: /");
	die();
}

try {
	$Grill = new Grill($_GET['grill']);
} catch (Exception $e) {
	header("Location: /");
	die();
} 

$scripts[] = "js/view.js";
$scripts[] = "js/twitter-text-1.12.0.min.js";

include("header.php");

?>

<h2><?php echo htmlspecialchars($Grill->name)?></h2>

<div id="tweets">
	<?php foreach($Grill->tweets as $Tweet): ?>
		<div class="panel panel-default">
			<div class="tweet panel-body">
				<?php echo htmlspecialchars($Tweet->text)?>
			</div>
		</div>
		<p class="pull-right" style="margin-top:-10px;margin-bottom:10px;">
			<a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode($Tweet->text)?>" class="btn btn-primary">Tweet Now!</a>
		</p>
		<div class="clearfix"></div>
	<?php endforeach;?>
</div>

<?php include("footer.php") ?>