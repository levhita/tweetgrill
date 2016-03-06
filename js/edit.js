$(document).ready(function(){
	$('#contents').delegate('button.update', 'click', function(){
		var form = $(this).closest('form');
		var data ={
			'text' : $(form).find('textarea[name="text"]').val(),
			'bocety' : $(form).find('input[name="bocety"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
			'id_content' : $(form).find('input[name="id_content"]').val(),
		}
		$.ajax({
			method: "POST",
			url: "/api/update_content.php",
			data: data,
			dataType: 'json'
		}).done(function(response) {
			if(typeof response.error !== 'undefined'){
				alert(response.error);
			} else {
				$(form).find("input[name='original_text']").val($(form).find('textarea[name="text"]').val());
				$(form).find('button.update').hide('fast');
			}
		});
	});

	$('#contents').delegate('button.delete', 'click', function(){
		var form = $(this).closest('form');
		var data ={
			'bocety' : $(form).find('input[name="bocety"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
			'id_content' : $(form).find('input[name="id_content"]').val(),
		}

		if (confirm("Do you really want to delete this content?")) {
			$.ajax({
				method: "POST",
				url: "/api/delete.php",
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
	
	$('#contents').delegate('button.content', 'click', function(){
		var form = $(this).closest('form');
		var text = $(form).find('textarea[name="text"]').val();
		window.open("https://twitter.com/intent/content?text="+encodeURIComponent(text), '_blank');
	});

	$('#contents').delegate('textarea', 'keyup', function(){
		var form = $(this).closest('form');
		var original = $(form).find("input[name='original_text']").val();
		if(this.value !== original){
			if($(form).find('button.update').css('display') == 'none') {
				$(form).find('button.update').show('fast');
			}
		} else {
			if($(form).find('button.update').css('display') == 'inline-block') {
				$(form).find('button.update').hide('fast');
			}
		}
		if(this.value.length > 500) {this.value = this.value.substr(0, 500);}
		update_counter(this);
	});
	$('#new_content textarea').on('keyup', function(){
		if(this.value.length > 500) {this.value = this.value.substr(0, 500);}
		update_counter(this);
	});

	$('#edit_name').on('click', function(){
		var new_name = prompt("Please enter the new name", $("#name").text());
		if (new_name == '' || new_name == null) {
 			return false;
		}
		var form = $("#bocety_form");
		var data ={
			'name' : new_name,
			'bocety' : $(form).find('input[name="bocety"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
		}
		$.ajax({
			method: "POST",
			url: "/api/update_bocety.php",
			data: data,
			dataType: 'json'
		}).done(function(response) {
			if(typeof response.error !== 'undefined'){
				alert(response.error);
			} else {
				$("#name").html(response.name.substring(0, 22));
				document.title = 'Bocety : '+response.name.substring(0, 22);
			}
		});
		return false;
	});
	$('#toggle_published').on('click', function(){
		var new_published = ($(this).text()=='Publish')?'1':'0';
			
		var form = $("#bocety_form");
		var data ={
			'published' : new_published,
			'bocety' : $(form).find('input[name="bocety"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
		}
		$.ajax({
			method: "POST",
			url: "/api/update_bocety.php",
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
		var form = $("#bocety_form");
		var data ={
			'description' : new_description,
			'bocety' : $(form).find('input[name="bocety"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
		}
		$.ajax({
			method: "POST",
			url: "/api/update_bocety.php",
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

	$('#delete_bocety').on('click', function() {
		if (confirm("Do you really want to delete this bocety?")) {
			var form = $("#bocety_form");
			var bocety 	= $(form).find('input[name="bocety"]').val();
			var secret = $(form).find('input[name="secret"]').val();
			window.location = 'delete_bocety.php?bocety='+bocety+'&secret='+secret;
		}
		return false;
	});

	$('#contents textarea').each(function(){
		update_counter(this);
	});

	$('#new_content button.add').on('click', function(){
		var form = $(this).closest('form');
		var data ={
			'text' : $(form).find('textarea[name="text"]').val(),
			'bocety' : $(form).find('input[name="bocety"]').val(),
			'secret' : $(form).find('input[name="secret"]').val(),
		}
		$.ajax({
			method: "POST",
			url: "/api/add.php",
			data: data,
			dataType: 'json'
		}).done(function(response) {
			if(typeof response.error !== 'undefined'){
				alert(response.error);
			} else {
				var content = response.content;
				var new_content = '';
				new_content += '<form style="display:none" id="content_'+content.id_content+'">';
				new_content += '<div class="col-sm-12">';
				new_content += '	<div class="form-group">';
				new_content += '		<p><textarea name="text" class="form-control" rows="3">'+content.text+'</textarea></p>';
				new_content += '		<p class="pull-right">';
				new_content += '			<span class="counter text-muted">140</span>&nbsp;';
				new_content += '			<button type="button" class="delete btn btn-default"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>';
				new_content += '			<button type="button" class="content btn btn-default">Content</button>';
				new_content += '			<button type="button" style="display:none" class="update btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>';
				new_content += '		</p>';
				new_content += '<input type="hidden" name="original_text" value="'+content.text+'"/>';
				new_content += '		<input type="hidden" name="bocety" value="'+content.unique_id+'"/>';
				new_content += '		<input type="hidden" name="secret" value="'+content.secret+'"/>';
				new_content += '		<input type="hidden" name="id_content" value="'+content.id_content+'"/>';
				new_content += '	</div>';
				new_content += '<div class="clearfix"></div>';
				new_content += '<br>';
				new_content += '</div>';
				new_content += '</form>';
				
				
				$('#contents').append(new_content);
				$("#contents form").last().show('fast');
				$('#contents textarea').each(function(){
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
	var left = 140 - twttr.txt.getContentLength(text);

	if(left < 15){
		$(element).closest('.form-group').find('.counter').addClass('text-danger');
	} else {
		$(element).closest('.form-group').find('.counter').removeClass('text-danger');
	}
	$(element).closest('.form-group').find('.counter').html(left);
}
