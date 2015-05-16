<?php
/**
 * @file
 * reserve a room
 */
include('functions.php');

// Find available rooms
function find() {
  $sql = <<<EOT
select rs.room_size, r.rate, r.image, r.sleeps, count(*) cnt
  from room r
  join room_size rs on rs.abbr = r.roomsize
  left outer join reservation rv
    on rv.rid = r.rid
    and rv.checkout > :checkin
    and rv.checkin < :checkout
  where rv.checkin is null
    and r.sleeps >= :sleeps
  group by r.roomsize, r.rate, r.sleeps, r.image
  order by r.rate desc;
EOT;
  // @TODO validate $_POST parameters
  // @TODO do they come in as mm/dd/yyyy?
  // Driver expects yyyy-mm-dd
  list($pdo, $cnt, $stmt) = sql_execute($sql, array(
                              ':checkin' => $_POST['checkin'],
                              ':checkout' => $_POST['checkout'],
                              ':sleeps' => $_POST['sleeps'],
                            ), 'Find Room Query');
  if ($cnt) {
    return $stmt->fetchAll();
  }
  return FALSE;
}

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

$smarty->assign('rooms', array());
if (!empty($_POST)) {
  $rooms = find();
  if ($rooms) {
    $smarty->assign('rooms', $rooms);
  }
}

$reservation = array(
  'checkin' => '',
  'checkout' => '',
  'guests' => options($guests),
);
$smarty->assign('reservation', $reservation);
$smarty->assign('messages', msg_render());

// Tell html.tpl to render index.tpl
$smarty->assign('render_tpl', 'reserve.tpl');
// Display the page.
$smarty->display('html.tpl');
