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
				alert(response.msg);
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


	});
});