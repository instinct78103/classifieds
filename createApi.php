<?php

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Router.php');

function pre($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

$router = new Router();
$router->run();

exit;

