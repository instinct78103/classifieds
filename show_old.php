<?php
require_once('variables.php');

$json = file_get_contents('php://input');
$_POST = json_decode($json, true);

searching(FILENEW, $_POST['find']);
searching(FILEOLD, $_POST['find']);