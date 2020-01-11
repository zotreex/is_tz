<?php
include "config.php";
include "sqlsafe.php";
$db = new SafeMySQL($opts);
$routes = [
    '' => 'controllers/index.php',
    'carts' => 'controllers/carts.php',
    'load' => 'controllers/load.php',
    'repeat' => 'controllers/repeat.php',
    'together' => 'controllers/together.php'
];
if (!empty($_GET['page'])) {
    require $routes[$_GET['page']];
} else {
    require $routes[''];
}

