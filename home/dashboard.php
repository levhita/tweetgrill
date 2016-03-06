<?php
	define("WEBROOT", '../');
	include(WEBROOT . "includes/bootstrap.php");
	include(WEBROOT . "includes/header.php");
?>

<?php $scripts[]='/js/dashboard.js'; ?>

<h2>Socials</h2>
<div id="socials"></div>

<h2>Bocetys</h2>
<div id="bocetys">
	
	<h4 class="text-center">You still don't have any <strong>Bocety</strong></h4>
	<p class="text-center"><a  class="btn btn-primary btn-lg" href='/home/create_bocety.php'>Start one Now!</a></p>
	

	
	<p class="text-center"><a id="what_is_a_bocety_button" class="btn btn-link btn-xs" href='#'>What is a <strong>Bocety</strong>?</a></p>
	
	<div id="what_is_a_bocety_text" class="jumbotron">
		<div class="container">
			<h3>What's a <strong>Bocety</strong>?</h3>
			<p>
				A <strong>Bocety</strong> is a grouped set of contents for you social networks. In your <strong>Bocety</strong>
				you can	create contents, receive help from your team and finally deliver it to your client for approval.
			</p>
			<p>
				The client can give his feedback right there, and once approved, we'll post it to your social networks
				automatically at the scheduled times.
			</p>

			<p>Create as many Bocetys as you need:</p>
			<ul>
				<li>A main <strong>Bocety</strong> for the contents of every month.</li>
				<li><strong>Bocetys</strong> for individual makerting campaigns.</li>
				<li>Halloween is near? create a <strong>Bocety</strong> with your concepts for the client to choose from.</li>
			</ul>

			<p>
				Each <strong>Bocety</strong> get's it's unique url that you can share with whoever you need, neither your client
				nor your team, needs to have a <strong>Bocety</strong>'s account to help you be Awesome.
			</p>
		</div>
	</div>
</div>



<?php include(WEBROOT . "includes/footer.php") ?>