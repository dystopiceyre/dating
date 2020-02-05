<?php
session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require once the autoload file
require_once('vendor/autoload.php');

//Create instance of base class
$f3 = Base::instance();

//define default route
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('view/home.html');
});

//define a personal route
$f3->route('GET /personal', function () {
    $view = new Template();
    echo $view->render('view/personal.html');
});

//define a profile route
$f3->route('POST /profile', function () {
    $_SESSION['firstName'] = $_POST['firstName'];
    $_SESSION['lastName'] = $_POST['lastName'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['phone-number'] = $_POST['phone-number'];
    $view = new Template();
    echo $view->render('view/profile.html');
});

//define an interests route
$f3->route('POST /interests', function () {
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['seeking'] = $_POST['seeking'];
    $_SESSION['bio'] = $_POST['bio'];
    $view = new Template();
    echo $view->render('view/interests.html');
});

//define a summary route
$f3->route('POST /summary', function () {
    $_SESSION['indoor-interests'] = $_POST['indoor-interests'];
    $_SESSION['outdoor-interests'] = $_POST['outdoor-interests'];
    var_dump($_SESSION);
    $view = new Template();
    echo $view->render('view/summary.html');
});

$f3->run();