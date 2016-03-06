<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="<?php
  if(isset($Bocety)){
    echo htmlspecialchars($Bocety->description);
  } else{
    echo "Cooking Contents Easily.";
  }?>">
  <meta name="author" content="@levhita">
  <link rel="icon" href="favicon.ico">

  <title>Bocety<?php if(isset($Bocety)){echo " : ".htmlspecialchars($Bocety->name);}?></title>

  <!-- Bootstrap core CSS -->
  <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/style.css" rel="stylesheet">

</head>

<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/"><strong>Bocety</strong></a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="about.php">About</a></li>
          <?php if(!$logged_in): ?>
            <li><a href="" data-toggle="modal" data-target="#signupModal">Create Account</a></li>
          <?php endif; ?>

        </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php if(!$logged_in): ?>
            <li><a href="" data-toggle="modal" data-target="#loginModal">Login</a></li>
          <?php else: ?>
            <li><?php echo $LoggedUser->email?></li>
            <li><a href="/logout.php"><?php echo $LoggedUser->email?> Logout</a></li>
          <?php endif;?>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>

  <!-- Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel2">Login</h4>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="email_login">Email Address:</label>
              <input type="email" class="form-control" id="email_login" placeholder="username@email.com">
              <p class="help-block" id="email_error_login" style="display:none"></p>
            </div>
            <div class="form-group">
              <label for="password_login">Password:</label>
              <input type="password" class="form-control" id="password_login" placeholder="******">
              <p class="help-block" id="password_error_login" style="display:none"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button id="login_button" type="button" class="btn btn-primary">Login</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Start your <strong>Bocety</strong> now!</h4>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="email">Email Address:</label>
              <input type="email" class="form-control" id="email" placeholder="username@email.com">
              <p class="help-block" id="email_error" style="display:none"></p>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" placeholder="Something long and human readable works better.">
              <p class="help-block" id="password_error" style="display:none"></p>
            </div>
            <div class="form-group">
              <label for="password_repeat">Repeat Password:</label>
              <input type="password" class="form-control" id="password_repeat" placeholder="Again, so you can be sure you type it right.">
              <p class="help-block" id="password_repeat_error" style="display:none"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button id="signup_button" type="button" class="btn btn-primary disabled">I'm Ready</button>
        </div>
      </div>
    </div>
  </div>  

  <div class="container">
