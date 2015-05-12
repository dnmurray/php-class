<?php
/**
 * @file
 * Login page for admin, or anyone, really
 */
include('functions.php');

// Log out any existing session
session_start();
if (!empty($_SESSION['username'])) {
  unset($_SESSION['username']);
}

// Logging in?
$msg = '';
if (!empty($_POST['login'])) {
  $user = user_load($_POST['username']);
  if ($user) {
    if (password_verify($_POST['password'], $user['password'])) {
      // Logged in
      $_SESSION['username'] = $user['username'];
      if (!empty($_SESSION['login_redirect'])) {
        $next = $_SESSION['login_redirect'];
        unset($_SESSION['login_redirect']);
      }
      else {
        $next = "index.php";
      }
      header('Location: ' . $next);
      exit();
    }
  }
  msg_add('Invalid username or password.', 'bg-danger');
}

// @TODO implement 3-try limit, delay 5 minutes.
// hint: store what you need in the $_SESSION array (count, expiration)
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login - Bates Motel</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

	<?php print head_elements(); ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js does not work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
	 p.username, p.text-danger {
	   margin-top: 30px;
	 }
	</style>
  </head>
  <body>
	<div class="text-center">
	  <h2>Bates Motel</h2>
	  <h4>User Login</h4>
	  <?php msg_render(); ?>
	  <form method="POST" action="login.php">
		<p class="username">
		  <label for="username">Username:</label>
		  <input type="text" id="username" name="username" />
		</p>
		<p>
		  <label for="password">Password:</label>
		  <input type="password" id="password" name="password" />
		</p>
		<p>
		  <input type="submit" name="login" value="Login" />
		</p>
		<?php if (!empty($_GET['redirect'])): ?>
		  <input type="hidden" name="redirect" value="<?php print $_GET['redirect']; ?>" />
		<?php endif; ?>
	  </form>
	</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
  </body>
</html>
