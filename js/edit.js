$(document).ready(function(){
	$('#tweets').delegate('button.update', 'click', function(){
		var form = $(this).closest('form');
		var data ={
			'text' : $(form).find('textarea[name="text"]').val(),
			'grill' : $(form).find('input[name="grill"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
			'id_tweet' : $(form).find('input[name="id_tweet"]').val(),
		}
		$.ajax({
			method: "POST",
			url: "update.php",
			data: data,
			dataType: 'json'
		}).done(function(response) {
			if(typeof response.error !== 'undefined'){
				alert(response.error);
			} else {
				alert('Updated Tweet.');
			}
		});
	});

	$('#tweets').delegate('button.delete', 'click', function(){
		var form = $(this).closest('form');
		var data ={
			'grill' : $(form).find('input[name="grill"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
			'id_tweet' : $(form).find('input[name="id_tweet"]').val(),
		}
	
		if (confirm("Are you sure?")) {
    			$.ajax({
				method: "POST",
				url: "delete.php",
				data: data,
				dataType: 'json'
			}).done(function(response) {
				if(typeof response.error !== 'undefined'){
					alert(response.error);
				} else {
					$(form).remove();
				}
			});
		}

	});

	$('#new_tweet button.add').on('click', function(){
		var form = $(this).closest('form');
		var data ={
			'text' : $(form).find('textarea[name="text"]').val(),
			'grill' : $(form).find('input[name="grill"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
		}
		$.ajax({
			method: "POST",
			url: "add.php",
			data: data,
			dataType: 'json'
		}).done(function(response) {
			if(typeof response.error !== 'undefined'){
				alert(response.error);
			} else {
				var tweet = response.tweet;
				var new_tweet = '';
				new_tweet += '<form id="tweet_'+tweet.id_tweet+'">';
				new_tweet += '	<div class="form-group">';
				new_tweet += '		<p><textarea name="text" class="form-control" rows="2">'+tweet.text+'</textarea></p>';
				new_tweet += '		<p class="pull-right">';
				new_tweet += '			<button type="button" class="delete btn btn-default">Delete</button>';
				new_tweet += '			<button type="button" class="update btn btn-primary">Update</button>';
				new_tweet += '		</p>';
				new_tweet += '		<input type="hidden" name="grill" value="'+tweet.unique_id+'"/>';
				new_tweet += '		<input type="hidden" name="secret" value="'+tweet.secret+'"/>';
				new_tweet += '		<input type="hidden" name="id_tweet" value="'+tweet.id_tweet+'"/>';
				new_tweet += '	</div>';
				new_tweet += '</form>';
				$('#tweets').append(new_tweet);
				$(form).find('textarea[name="text"]').val('');
			}
		});
	});

	$('#edit_name').on('click', function(){
		var new_name = prompt("Please enter the new name", $("#name").text());
		var form = $("#grill_form");
		var data ={
			'name' : new_name,
			'grill' : $(form).find('input[name="grill"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
		}
		$.ajax({
			method: "POST",
			url: "update_name.php",
			data: data,
			dataType: 'json'
		}).done(function(response) {
			if(typeof response.error !== 'undefined'){
				alert(response.error);
			} else {
				$("#name").html(response.name);
			}
		});
	});

	$('#delete_grill').on('click', function(){
		if (confirm("Are you sure?")) {
			var form = $("#grill_form");
			var grill 	= $(form).find('input[name="grill"]').val();
			var secret = $(form).find('input[name="secret"]').val();
			window.location = 'delete_grill.php?grill='+grill+'&secret='+secret;
		}
		
	});

});