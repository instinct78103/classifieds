<?php
require_once('variables.php');
$txt = file(ROOT . '/old.txt');


foreach ($txt as $key => $item) {
    $seg = preg_split('~[\t]~u', $item);
    $newTxt[$key] = $seg;
}

$mysqli = new mysqli('localhost', 'root', '');
if (mysqli_select_db($mysqli, DB_NAME)) {
    foreach ($newTxt as $item) {
        //$sql = 'INSERT INTO classifieds.old (`code`, `message`) VALUES (' . ($item[0]) . ', ' . html_entity_decode($item[1]) . ')';

        $sql = 'INSERT INTO old (`code`, `message`)
                VALUES("' . preg_replace("/\xEF\xBB\xBF/", "", $item[0]) . '", "' . preg_replace("/\xEF\xBB\xBF/", "", $item[1]) . '")';
        $mysqli->query($sql);
        if ($mysqli->error) {
            echo $mysqli->error;
            break;
        }
    }
} else {
    echo 0;
}