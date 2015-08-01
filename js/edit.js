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
			url: "update_tweet.php",
			data: data,
			dataType: 'json'
		}).done(function(response) {
			if(typeof response.error !== 'undefined'){
				alert(response.error);
			} else {
				/** TODO: change relation **/
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

		if (confirm("Do you really want to delete this tweet?")) {
			$.ajax({
				method: "POST",
				url: "delete.php",
				data: data,
				dataType: 'json'
			}).done(function(response) {
				if(typeof response.error !== 'undefined'){
					alert(response.error);
				} else {
					$(form).hide('fast', function() {
						$(form).remove();
					});
				}
			});
		}
		return false;
	});
	
	$('#tweets').delegate('button.tweet', 'click', function(){
		var form = $(this).closest('form');
		var text = $(form).find('textarea[name="text"]').val();
		window.open("https://twitter.com/intent/tweet?text="+encodeURIComponent(text), '_blank');
	});

	$('#tweets').delegate('textarea', 'keyup', function(){
		if(this.value.length > 500) {this.value = this.value.substr(0, 500);}
		update_counter(this);
	});
	$('#new_tweet textarea').on('keyup', function(){
		if(this.value.length > 500) {this.value = this.value.substr(0, 500);}
		update_counter(this);
	});

	$('#edit_name').on('click', function(){
		var new_name = prompt("Please enter the new name", $("#name").text());
		if (new_name == '' || new_name == null) {
 			return false;
		}
		var form = $("#grill_form");
		var data ={
			'name' : new_name,
			'grill' : $(form).find('input[name="grill"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
		}
		$.ajax({
			method: "POST",
			url: "update_grill.php",
			data: data,
			dataType: 'json'
		}).done(function(response) {
			if(typeof response.error !== 'undefined'){
				alert(response.error);
			} else {
				$("#name").html(response.name.substring(0, 22));
			}
		});
		return false;
	});
	$('#toggle_published').on('click', function(){
		var new_published = ($(this).text()=='Publish')?'1':'0';
			
		var form = $("#grill_form");
		var data ={
			'published' : new_published,
			'grill' : $(form).find('input[name="grill"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
		}
		$.ajax({
			method: "POST",
			url: "update_grill.php",
			data: data,
			dataType: 'json'
		}).done(function(response) {
			if(typeof response.error !== 'undefined'){
				alert(response.error);
			} else {
				if (new_published==1) {
					$("#toggle_published").html('Unpublish');
					$("#toggle_published").removeClass('btn-primary');
					$("#toggle_published").addClass('btn-default');
					$("#public_link").show('fast');
				} else {
					$("#toggle_published").html('Publish');
					$("#toggle_published").removeClass('btn-default');
					$("#toggle_published").addClass('btn-primary');
					$("#public_link").hide('fast');
				}
			}
		});
		return false;
	});
	
	if ($("#toggle_published").text()=='Publish'){
		$("#public_link").hide();
	}
	
	$('#edit_description').on('click', function(){
		var new_description = prompt("Please enter the new description", $("#description").text());
		if (new_description == '' || new_description == null) {
 			return false;
		}
		var form = $("#grill_form");
		var data ={
			'description' : new_description,
			'grill' : $(form).find('input[name="grill"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
		}
		$.ajax({
			method: "POST",
			url: "update_grill.php",
			data: data,
			dataType: 'json'
		}).done(function(response) {
			if(typeof response.error !== 'undefined'){
				alert(response.error);
			} else {
				$("#description").html(response.description.substring(0, 255));
			}
		});
	});

	$('#delete_grill').on('click', function() {
		if (confirm("Do you really want to delete this grill?")) {
			var form = $("#grill_form");
			var grill 	= $(form).find('input[name="grill"]').val();
			var secret = $(form).find('input[name="secret"]').val();
			window.location = 'delete_grill.php?grill='+grill+'&secret='+secret;
		}
		return false;
	});

	$('#tweets textarea').each(function(){
		update_counter(this);
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
				new_tweet += '<form style="display:none" id="tweet_'+tweet.id_tweet+'">';
				new_tweet += '<div class="col-sm-12">';
				new_tweet += '	<div class="form-group">';
				new_tweet += '		<p><textarea name="text" class="form-control" rows="3">'+tweet.text+'</textarea></p>';
				new_tweet += '		<p class="pull-right">';
				new_tweet += '			<span class="counter text-muted">140</span>&nbsp;';
				new_tweet += '			<button type="button" class="delete btn btn-default"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>';
				new_tweet += '			<button type="button" class="tweet btn btn-default">Tweet</button>';
				new_tweet += '			<button type="button" class="update btn btn-primary">Update</button>';
				new_tweet += '		</p>';
				new_tweet += '		<input type="hidden" name="grill" value="'+tweet.unique_id+'"/>';
				new_tweet += '		<input type="hidden" name="secret" value="'+tweet.secret+'"/>';
				new_tweet += '		<input type="hidden" name="id_tweet" value="'+tweet.id_tweet+'"/>';
				new_tweet += '	</div>';
				new_tweet += '<div class="clearfix"></div>';
				new_tweet += '<br>';
				new_tweet += '</div>';
				new_tweet += '</form>';
				
				
				$('#tweets').append(new_tweet);
				$("#tweets form").last().show('fast');
				$('#tweets textarea').each(function(){
					update_counter(this);
				});
				$(form).find('textarea[name="text"]').val('');
				$(form).find('textarea[name="text"]').focus();
				$(form).find('.counter').html(140);
				$(form).find('.counter').removeClass('text-danger');
			}
		});
		return false;
	});
});

function update_counter(element) {
	var text =  $(element).val();
	var left = 140 - twttr.txt.getTweetLength(text);

	if(left < 15){
		$(element).closest('.form-group').find('.counter').addClass('text-danger');
	} else {
		$(element).closest('.form-group').find('.counter').removeClass('text-danger');
	}
	$(element).closest('.form-group').find('.counter').html(left);
}
