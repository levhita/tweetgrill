<?php
require_once("bootstrap.php");
require_once("Grill.php");

if ( !isset($_GET['grill']) || !isset($_GET['secret']) || empty($_GET['grill']) || empty($_GET['secret']) ){
	header("Location: /");
	die();
}

try {
	$Grill = new Grill($_GET['grill']);
} catch (Exception $e) {
	header("Location: /");
	die();
} 

if ( !$Grill->validate_secret($_GET['secret']) ) {
	header("Location: /");
	die();
}

$scripts[] = "js/edit.js";
$scripts[] = "js/twitter-text-1.12.0.min.js";

include("header.php");

?>


<h2 class="pull-left text-left" id="name"><?php echo htmlspecialchars($Grill->name)?></h2>
<div class="clearfix visible-xs"></div>
<div class="text-right" style="margin-top:18px;margin-bottom:0px;">
	<div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Edit <span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li><a href="#" id="edit_name">Name</a></li>
			<li><a href="#" id="edit_description">Description</a></li>
			<li role="separator" class="divider"></li>
			<li><a href="#" id="delete_grill">Delete</a></li>
		</ul>
	</div>	
	<a href="view.php?grill=<?php echo $Grill->unique_id;?>" class="btn btn-primary">Public Link &nbsp;<span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a>
</div>
<div class="clearfix visible-xs"></div>
<br/>
<div class="row">
	<div class="col-sm-12" id="description"><?php echo htmlspecialchars($Grill->description)?></div>
</div>
<hr/>
<div id="tweets" class="row">
	<?php foreach($Grill->tweets as $Tweet): ?>
		
		<form id="tweet_<?php echo $Tweet->id_tweet; ?>">
			<div class="col-sm-12">
				<div class="form-group">
					<p><textarea name="text" class="form-control" rows="3"><?php echo htmlspecialchars($Tweet->text)?></textarea></p>
					<p class="pull-right">
						<span class="counter text-muted">140</span>&nbsp;
						<button type="button" class="delete btn btn-default"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
						<button type="button" class="tweet btn btn-default">Tweet</button>
						<button type="button" class="update btn btn-primary">Update</button>

					</p>
					<input type="hidden" name="grill" value="<?php echo $Grill->unique_id;?>"/>
					<input type="hidden" name="secret" value="<?php echo $Grill->secret;?>"/>
					<input type="hidden" name="id_tweet" value="<?php echo $Tweet->id_tweet;?>"/>
				</div>
				<div class="clearfix"></div>
				<hr>
			</div>
		</form>
	<?php endforeach;?>
</div>
<div class="row">
	<div class="col-sm-12">
		<form id="new_tweet">
			<div class="form-group">
				<label for="tweet">Create a new Tweet:</label>
				<p><textarea name="text" class="form-control" rows="2" placeholder="Follow @levhita for some awesome updates #FF"></textarea></p>
				<p class="pull-right">
					<span class="counter text-muted">140</span>&nbsp;
					<button type="button" class="add btn btn-primary">Save</button>
				</p>
				<input type="hidden" name="grill" value="<?php echo $Grill->unique_id;?>"/>
				<input type="hidden" name="secret" value="<?php echo $Grill->secret;?>"/>
			</div>
		</form>
	</div>
</div>

<form id="grill_form">
	<input type="hidden" name="grill" value="<?php echo $Grill->unique_id;?>"/>
	<input type="hidden" name="secret" value="<?php echo $Grill->secret;?>"/>
</form>

<?php include("footer.php") ?>