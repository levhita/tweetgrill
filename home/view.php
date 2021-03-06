<?php
define("WEBROOT", '../');
require_once(WEBROOT . "includes/bootstrap.php");

if ( !isset($_GET['bocety']) || empty($_GET['bocety']) ){
	header("Location: /");
	die();
}

try {
	$Bocety = new BocetyModel($_GET['bocety']);
} catch (Exception $e) {
	header("Location: /");
	die();
} 

if($Bocety->published=='0'){
	header("Location: /");
	die();
}

$scripts[] = "/js/view.js";
$scripts[] = "/js/twitter-text-1.12.0.min.js";

include(WEBROOT . "includes/header.php");

?>

<div class="pull-right" style="margin-top: 20px;">
	<div class="addthis_sharing_toolbox"></div>
</div>
<h2><?php echo htmlspecialchars($Bocety->name)?></h2>

<div class="row">
	<div class="col-sm-12" id="description">
		<?php echo nl2br(htmlspecialchars($Bocety->description))?>
	</div>
</div>
<hr/>
<div id="contents">
	<?php foreach($Bocety->contents as $Content): ?>
		<div class="panel panel-default">
			<div class="content panel-body"><?php echo nl2br(htmlspecialchars($Content->text))?></div>
		</div>
		<p class="pull-right" style="margin-top:-10px;margin-bottom:10px;">
			<a target="_blank" href="https://twitter.com/intent/content?text=<?php echo urlencode($Content->text)?>" class="btn btn-primary">Content Now!</a>
		</p>
		<div class="clearfix"></div>
		<hr>
	<?php endforeach;?>
</div>

<?php include(WEBROOT . "includes/footer.php") ?>