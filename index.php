<?php
//Start a session
session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require once the autoload file
require_once('vendor/autoload.php');

//Create instance of base class
$f3 = Base::instance();

//Run fat free
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('views/home.html');
});

//define a personal route

//define a profile route

//define an interests route
$f3->run();