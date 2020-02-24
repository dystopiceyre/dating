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
$f3->route('GET|POST /profile', function ($f3) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $selectedSeeking = array();
        $email = $_POST['email'];
        $selectedState = $_POST['state'];
        $bio = $_POST['bio'];
        if (!empty($_POST['seeking'])) {
            $selectedSeeking = $_POST['seeking'];
        }

        $f3->set('email', $email);
        $f3->set('selectedState', $selectedState);
        $f3->set('seeking', $selectedSeeking);

        if (validForm()) {
            //Write data to Session
            $_SESSION['email'] = $email;
            $_SESSION['state'] = $selectedState;
            $_SESSION['seeking'] = $selectedSeeking;
            $_SESSION['bio'] = $bio;

            //Redirect to Interests
            $f3->reroute('/interests');
        }
    }

    $view = new Template();
    echo $view->render('view/profile.html');
});

//define an interests route
$f3->route('GET|POST /interests', function ($f3) {
    $selectedIndoor = array();
    $selectedOutdoor = array();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['indoorInterests'])) {
            $selectedIndoor = $_POST['indoorInterests'];
        }
        if (!empty($_POST['outdoorInterests'])) {
            $selectedOutdoor = $_POST['outdoorInterests'];
        }

        $f3->set('indoorInterests', $selectedIndoor);
        $f3->set('outdoorInterests', $selectedOutdoor);


        if (validForm()) {
            //Write data to Session
            $_SESSION['indoorInterests'] = $selectedIndoor;
            $_SESSION['outdoorInterests'] = $selectedOutdoor;

            //Redirect to Summary
            $f3->reroute('/summary');
        }
    }

    $view = new Template();
    echo $view->render('view/interests.html');
});

//define a summary route
$f3->route('GET|POST /summary', function () {
    $view = new Template();
    echo $view->render('view/summary.html');
});

$f3->run();