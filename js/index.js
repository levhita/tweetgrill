(function() {
	$(document).ready(function() {
		

		$('#password').on('keyup',function(){
			checkSame();
		});

		$('#password_repeat').on('keyup',function(){
			checkSame();
		});

		$('#password').on('change',function(){
			checkSame();
			checkValid();
		});

		$('#password_repeat').on('change',function(){
			checkSame();
			checkValid();
		});


		$('#email').on('keyup',function(){
			checkEmail();
		});

		$('#email').on('change',function(){
			checkEmail();
			checkValid();
		});

		$('#signup_button').click(function(){



		});
	});

	function checkEmail(){
		var email = $('#email').val();
		if(email.length>0){
			if( /(.+)@(.+){2,}\.(.+){2,}/.test(email) ){
				$('#email').closest('.form-group').removeClass('has-error');  
				$('#email').closest('.form-group').addClass('has-success');  
				$('#email_error').html('Valid email adress.');
				$('#email_error').slideUp();
			} else {
				$('#email').closest('.form-group').removeClass('has-success');  
				$('#email').closest('.form-group').addClass('has-error');  
				$('#email_error').html('Invalid email adress.');
				$('#email_error').slideDown();
			}
		} else {
			$('#email').closest('.form-group').removeClass('has-error');  
			$('#email_error').slideUp();
		} 
	}

	function checkSame(){
		var password = $('#password').val();
		var password_repeat = $('#password_repeat').val();
		if ( password.length>0 ) {
			
			if (password.length >= 8){
				$('#password').closest('.form-group').removeClass('has-warning');
				$('#password').closest('.form-group').addClass('has-success');
				$('#password_error').html('Password Valid')
				$('#password_error').slideUp();

				if ( password!=password_repeat ) {
					$('#password_repeat').closest('.form-group').addClass('has-warning');
					$('#password_repeat').closest('.form-group').removeClass('has-success');
					$('#password_repeat_error').html('Passwords don \'t match.')
					$('#password_repeat_error').slideDown();
				} else {
					$('#password_repeat').closest('.form-group').removeClass('has-warning');
					$('#password_repeat').closest('.form-group').addClass('has-success');
					$('#password_repeat_error').html('Passwords match.')
					$('#password_repeat_error').slideUp();
				}

			} else {
				$('#password').closest('.form-group').addClass('has-warning');
				$('#password').closest('.form-group').removeClass('has-success');
				$('#password_error').html('At least 8 characters.')
				$('#password_error').slideDown();

				$('#password_repeat').closest('.form-group').removeClass('has-warning');
				$('#password_repeat').closest('.form-group').removeClass('has-success');
				$('#password_repeat_error').slideUp();
			}
		} else {
			$('#password').closest('.form-group').removeClass('has-warning');
			$('#password').closest('.form-group').removeClass('has-success');
			$('#password_error').slideUp();
			
			$('#password_repeat').closest('.form-group').removeClass('has-warning');
			$('#password_repeat').closest('.form-group').removeClass('has-success');
			$('#password_repeat_error').slideUp();
		}
	}

	function checkValid() {
		var password = $('#password').val();
		var password_repeat = $('#password_repeat').val();
		var email = $('#email').val();
		
		if (password.length>=8 &&  password==password_repeat && /(.+)@(.+){2,}\.(.+){2,}/.test(email) ) {
			$('#signup_button').removeClass('disabled');
		} else {
			$('#signup_button').addClass('disabled');
			
		}
	}
	
})();