<?php
require_once("bootstrap.php");
require_once("models/Bocety.php");

if ( !isset($_GET['bocety']) || !isset($_GET['secret']) || empty($_GET['bocety']) || empty($_GET['secret']) ){
	header("Location: /");
	die();
}

try {
	$Bocety = new Bocety($_GET['bocety']);
} catch (Exception $e) {
	header("Location: /");
	die();
} 

if ( !$Bocety->validate_secret($_GET['secret']) ) {
	header("Location: /");
	die();
}

$scripts[] = "js/edit.js";
$scripts[] = "js/twitter-text-1.12.0.min.js";

include("header.php");

?>
<div class="text-right pull-right" style="margin-top:18px;margin-bottom:0px;">
	<div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Edit <span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li><a href="#" id="edit_name">Name</a></li>
			<li><a href="#" id="edit_description">Description</a></li>
			<li role="separator" class="divider"></li>
			<li><a href="#" id="delete_bocety">Delete</a></li>
		</ul>
	</div>	
	<a href="#" id="toggle_published" class="btn <?php echo ($Bocety->published=='0')?'btn-primary':'btn-default';?>"><?php echo ($Bocety->published=='0')?'Publish':'Unpublish';?></a>
	<a id="public_link" target="_blank" href="view.php?bocety=<?php echo $Bocety->unique_id;?>" class="btn btn-primary">Public Link &nbsp;<span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a>
</div>
<div class="clearfix visible-xs"></div>
<h2 class="text-left" id="name"><?php echo htmlspecialchars($Bocety->name)?></h2>
<div class="row">
	<div class="col-sm-12" id="description"><?php echo htmlspecialchars($Bocety->description)?></div>
</div>
<hr/>
<div class="row">
	<div class="col-sm-12">
		<form id="new_tweet">
			<div class="form-group">
				<label for="tweet">Create a new Content:</label>
				<p><textarea name="text" class="form-control" rows="2" placeholder="Follow @levhita for some awesome updates #FF"></textarea></p>
				<p class="pull-right">
					<span class="counter text-muted">140</span>&nbsp;
					<button type="button" class="add btn btn-primary">Save</button>
				</p>
				<input type="hidden" name="bocety" value="<?php echo $Bocety->unique_id;?>"/>
				<input type="hidden" name="secret" value="<?php echo $Bocety->secret;?>"/>
			</div>
		</form>
	</div>
</div>
<hr/>
<div id="tweets" class="row">
	<?php foreach($Bocety->tweets as $Content): ?>
		
		<form id="tweet_<?php echo $Content->id_tweet; ?>">
			<div class="col-sm-12">
				<div class="form-group">
					<p><textarea name="text" class="form-control" rows="3"><?php echo htmlspecialchars($Content->text)?></textarea></p>
					<p class="pull-right">
						<span class="counter text-muted">140</span>&nbsp;
						<button type="button" class="delete btn btn-default"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
						<button type="button" class="tweet btn btn-default">Content</button>
						<button type="button" style="display:none" class="update btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>

					</p>
					<input type="hidden" name="original_text" value="<?php echo htmlspecialchars($Content->text)?>"/>
					<input type="hidden" name="bocety" value="<?php echo $Bocety->unique_id;?>"/>
					<input type="hidden" name="secret" value="<?php echo $Bocety->secret;?>"/>
					<input type="hidden" name="id_tweet" value="<?php echo $Content->id_tweet;?>"/>
				</div>
				<div class="clearfix"></div>
				<br>
			</div>
		</form>
	<?php endforeach;?>
</div>


<form id="bocety_form">
	<input type="hidden" name="bocety" value="<?php echo $Bocety->unique_id;?>"/>
	<input type="hidden" name="secret" value="<?php echo $Bocety->secret;?>"/>
</form>

<?php include("footer.php") ?>