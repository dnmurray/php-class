<?php
/**
 * @file
 * reserve a room
 */

$smarty = new Smarty();
// Assign variables for html.tpl
$smarty->assign('title', 'Reserve');
$smarty->assign('head', '');
$smarty->assign('body_class', 'reserve');
// Assign variables for reserve.tpl
$smarty->assign('messages', msg_render());

// Tell html.tpl to render index.tpl
$smarty->assign('render_tpl', 'reserve.tpl');
// Display the page.
$smarty->display('html.tpl');
