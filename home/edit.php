<?php
define("WEBROOT", '../');
require_once(WEBROOT . "includes/bootstrap.php");

Utils::check_session();

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

/*if ( !$Bocety->validate_secret($_GET['secret']) ) {
	header("Location: /");
	die();
}*/

$scripts[] = "/vendor/twitter-text-1.12.0.min.js";
$scripts[] = "/js/edit.js";

include(WEBROOT . "includes/header.php");

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
	<a id="public_link" target="_blank" href="view.php?bocety=<?php echo $Bocety->id_bocety;?>" class="btn btn-primary">Public Link &nbsp;<span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a>
</div>
<div class="clearfix visible-xs"></div>
<h2 class="text-left" id="name"><?php echo htmlspecialchars($Bocety->name)?></h2>
<div class="row">
	<div class="col-sm-12" id="description"><?php echo htmlspecialchars($Bocety->description)?></div>
</div>
<hr/>
<div class="row">
	<div class="col-sm-12">
		<form id="new_content">
			<div class="form-group">
				<label for="content">Create a new Content:</label>
				<p><textarea name="text" class="form-control" rows="2" placeholder="Write some awesome content..."></textarea></p>
				<p class="pull-right">
					<span class="counter text-muted">140</span>&nbsp;
					<button type="button" class="add btn btn-primary">Save</button>
				</p>
				<input type="hidden" name="id_bocety" value="<?php echo $Bocety->id_bocety;?>"/>
			</div>
		</form>
	</div>
</div>
<hr/>
<div id="contents" class="row">
	<?php foreach($Bocety->contents as $Content): ?>
		
		<form id="content_<?php echo $Content->id_content; ?>">
			<div class="col-sm-12">
				<div class="form-group">
					<p><textarea name="text" class="form-control" rows="3"><?php echo htmlspecialchars($Content->text)?></textarea></p>
					<p class="pull-right">
						<span class="counter text-muted">140</span>&nbsp;
						<button type="button" class="delete btn btn-default"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
						<button type="button" class="content btn btn-default">Content</button>
						<button type="button" style="display:none" class="update btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>

					</p>
					<input type="hidden" name="original_text" value="<?php echo htmlspecialchars($Content->text)?>"/>
					<input type="hidden" name="id_bocety" value="<?php echo $Bocety->id_bocety;?>"/>
					<input type="hidden" name="id_content" value="<?php echo $Content->id_content;?>"/>
				</div>
				<div class="clearfix"></div>
				<br>
			</div>
		</form>
	<?php endforeach;?>
</div>


<form id="bocety_form">
	<input type="hidden" name="id_bocety" value="<?php echo $Bocety->id_bocety;?>"/>
</form>

<?php include(WEBROOT . "includes/footer.php") ?>