<?php
session_start();
$_SESSION['hello'] = 'Lindsay';
$_SESSION['anything'] = ' Lorum impsum';
$_SESSION['msg'] = array(
  array('msg' => 'Hello, World',
    'sev' => 'bg-success'),
  array('msg' => 'Will Robinson',
    'sev' => 'bg-danger'),
);
header('Location: sess2.php');
