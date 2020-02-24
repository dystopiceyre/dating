<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require once the autoload file
require_once('vendor/autoload.php');
session_start();

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
$controller->getF3()->route('GET|POST /profile', function (){
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

$controller->getF3()->run();