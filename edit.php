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
include("header.php");

?>

<h1><span id="name"><?php echo htmlspecialchars($Grill->name)?></span>
	<div class="pull-right">
		<button id="delete_grill" type="button" class="btn btn-danger">Delete</button>
		<button id="edit_name" type="button" class="btn btn-default">Edit Name</button>
		<a href="view.php?grill=<?php echo $Grill->unique_id;?>" class="btn btn-primary">Public Link</a>
	</div>
</h1>
<div id="tweets">
	<?php foreach($Grill->tweets as $Tweet): ?>
		<form id="tweet_<?php echo $Tweet->id_tweet; ?>">
			<div class="form-group">
				<p><textarea name="text" class="form-control" rows="2"><?php echo htmlspecialchars($Tweet->text)?></textarea></p>
				<p class="pull-right">
					<button type="button" class="delete btn btn-default">Delete</button>
					<button type="button" class="update btn btn-primary">Update</button>
				</p>
				<input type="hidden" name="grill" value="<?php echo $Grill->unique_id;?>"/>
				<input type="hidden" name="secret" value="<?php echo $Grill->secret;?>"/>
				<input type="hidden" name="id_tweet" value="<?php echo $Tweet->id_tweet;?>"/>
			</div>
		</form>
	<?php endforeach;?>
</div>
<div class="clearfix"></div>
<form id="new_tweet">
	<div class="form-group">
		<label for="tweet">New Tweet:</label>
		<p><textarea name="text" class="form-control" rows="2" placeholder="Example Tweet"></textarea></p>
		<p class="pull-right"><button type="button" class="add btn btn-primary">Add New</button></p>
		<input type="hidden" name="grill" value="<?php echo $Grill->unique_id;?>"/>
		<input type="hidden" name="secret" value="<?php echo $Grill->secret;?>"/>
	</div>
</form>

<form id="grill_form">
	<input type="hidden" name="grill" value="<?php echo $Grill->unique_id;?>"/>
	<input type="hidden" name="secret" value="<?php echo $Grill->secret;?>"/>
</form>

<?php include("footer.php") ?>