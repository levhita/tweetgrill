<?php
	define(WEBROOT, './');
	include(WEBROOT . "includes/bootstrap.php");
	include(WEBROOT . "includes/header_external.php");
?>
<?php $scripts[]='/js/index.js'; ?>

<div class="starter-template">
	<h1>Bocety</h1>
	<p class="lead">
		<strong>Bocety</strong> it's streamlined content creation workflow for digital makerting strategists,
		community managers and digital agencies.
	</p>

	<p class="lead">
		You can go from creation, approval up to automatic scheduled publications, be efficient, keep your clients happy, <a href="http://i.imgur.com/dcOBuVk.gif">be Awesome!</a>
	</p>
	
	<p>
		<a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#signupModal">Try Bocety Now!</a>
	</p>
</div>

<div class="row marketing">
	<div class="col-sm-4 text-center">
		<img class="" src="/images/edit.png" alt="Generic placeholder image" width="140" height="140">
		<h2>Create content</h2>
		<p>Generate and manage all your social content in one place.</p>
		<p>We store your images and give you accurate previews of the content for the leading social media platforms.</p>
	</div>
	<div class="col-sm-4 text-center">
		<img class="" src="/images/collab.png" alt="Generic placeholder image" width="140" height="140">
		<h2>Collaborate</h2>
		<p>
			The designer can add the images to the image manager, while the community manager starts to work in the texts.
		</p>
		<p>
			All while the digital strategist keep an eye on the work done without interrumpting the team.
		</p>
	</div>
	<div class="col-sm-4 text-center">
		<img class="" src="/images/deliver.png" alt="Generic placeholder image" width="140" height="140">
		<h2>Deliver</h2>
		<p>
			The client can review and approve the content in a frieldy interface, and then just let us publish it at the scheduled times for the leadibng social media platforms.
		</p>
	</div>
</div>

<?php include(WEBROOT . "includes/footer.php") ?>