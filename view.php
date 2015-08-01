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

if($Grill->published=='0'){
	header("Location: /");
	die();
}

$scripts[] = "js/view.js";
$scripts[] = "js/twitter-text-1.12.0.min.js";

include("header.php");

?>

<div class="row">
	<div class="col-sm-6">
		<h2><?php echo htmlspecialchars($Grill->name)?></h2>
	</div>
	<div class="col-sm-6 text-right">
		<div class="addthis_custom_sharing"></div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12" id="description">
		<?php echo nl2br(htmlspecialchars($Grill->description))?>
	</div>
</div>
<hr/>
<div id="tweets">
	<?php foreach($Grill->tweets as $Tweet): ?>
		<div class="panel panel-default">
			<div class="tweet panel-body"><?php echo nl2br(htmlspecialchars($Tweet->text))?></div>
		</div>
		<p class="pull-right" style="margin-top:-10px;margin-bottom:10px;">
			<a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode($Tweet->text)?>" class="btn btn-primary">Tweet Now!</a>
		</p>
		<div class="clearfix"></div>
		<hr>
	<?php endforeach;?>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55bd3b758b697113" async="async"></script>

<?php include("footer.php") ?>