<?php
/**
 * @file
 * Homepage
 */

include('functions.php');

$options = array(
  array(
    'href' => 'roomlist.php',
    'desc' => 'Room List (admin)',
  ),
  array(
    'href' => 'reserve.php',
    'desc' => 'Reserve a Room',
  ),
);
$smarty = new Smarty();
// Assign variables for html.tpl
$smarty->assign('title', 'Homepage');
$smarty->assign('head', '');
$smarty->assign('body_class', 'homepage');
// Assign variables for index.tpl
$smarty->assign('options', $options);
// Tell html.tpl to render index.tpl
$smarty->assign('render_tpl', 'index.tpl');
// Display the page.
$smarty->display('html.tpl');
