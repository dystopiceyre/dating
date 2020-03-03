<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require once the autoload file
require_once('vendor/autoload.php');
session_start();

require('/home/oringhis/datingConfig.php');
try {
    $db = new PDO(DB_DATING_DSN, DB_DATING_USERNAME, DB_DATING_PASSWORD);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$f3 = Base::instance();
$f3->set('DEBUG', 3);
$db = new DatingDatabase();
$controller = new DatingController();

//define default route
$controller->getF3()->route('GET /', function () {
    global $controller;
    $controller->home();
});

//define a personal route
$controller->getF3()->route('GET|POST /personal', function () {
    global $controller;
    $controller->personal();
});

//define a profile route
$controller->getF3()->route('GET|POST /profile', function () {
    global $controller;
    $controller->profile();
});

//define an interests route
$controller->getF3()->route('GET|POST /interests', function () {
    global $controller;
    $controller->interests();
});

//define a summary route
$controller->getF3()->route('GET|POST /summary', function () {
    global $controller;
    $controller->summary();
});

//define admin route
$controller->getF3()->route('GET /admin', function () {
    global $controller;
    $controller->admin();
});

$controller->getF3()->run();