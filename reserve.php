<?php
/**
 * @file
 * reserve a room
 */
include('functions.php');

$smarty = new Smarty();
// Assign variables for html.tpl
$smarty->assign('title', 'Reserve');
$smarty->assign('head', '');
$smarty->assign('body_class', 'reserve');
// Assign variables for reserve.tpl
$smarty->assign('messages', msg_render());
$guests = array(
  '1' => '1',
  '2' => '2',
  '3' => '3',
  '4' => '4',
  '5' => '5',
  '6' => '6',
);
$reservation = array(
  'checkin' => '',
  'checkout' => '',
  'guests' => options($guests),
);
$smarty->assign('reservation', $reservation);
$smarty->assign('rooms', array());

// Tell html.tpl to render index.tpl
$smarty->assign('render_tpl', 'reserve.tpl');
// Display the page.
$smarty->display('html.tpl');
