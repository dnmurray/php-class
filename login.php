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

$smarty = new Smarty();
// Assign variables for html.tpl
$smarty->assign('title', 'Login');
$smarty->assign('head', '');
$smarty->assign('body_class', 'login');
// Assign variables for login.tpl
$smarty->assign('messages', msg_render());
$smarty->assign('redirect', !empty($_GET['redirect']) ? $_GET['redirect'] : '');

// Tell html.tpl to render index.tpl
$smarty->assign('render_tpl', 'login.tpl');
// Display the page.
$smarty->display('html.tpl');
