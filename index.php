<?php
session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require once the autoload file
require_once('vendor/autoload.php');
require_once('model/validation.php');

//Create instance of base class
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//define arrays
$f3->set('seeking', array('male', 'female', 'nonbinary', 'genderqueer', 'other'));
$f3->set('indoor', array('reading', 'writing-letters', 'playing-instrument', 'singing', 'sewing', 'cooking'));
$f3->set('outdoor', array('horseback-riding', 'fencing', 'walking', 'picknicking', 'gardening', 'swimming'));

//define default route
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('view/home.html');
});

//define a personal route
$f3->route('GET|POST /personal', function ($f3) {
    //If form has been submitted, validate
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $gender = array('male', 'female', 'nonbinary', 'genderqueer', 'other');
        //Get data from form
        $first = $_POST['firstName'];
        $last = $_POST['lastName'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $phone = $_POST['phoneNumber'];

        //Add data to hive
        $f3->set('firstName', $first);
        $f3->set('lastName', $last);
        $f3->set('age', $age);
        $f3->set('selectedGender', $gender);
        $f3->set('phoneNumber', $phone);

        //If data is valid
        if (validForm()) {
            //Write data to Session
            $_SESSION['firstName'] = $first;
            $_SESSION['lastName'] = $last;
            $_SESSION['age'] = $age;
            $_SESSION['gender'] = $gender;
            $_SESSION['phoneNumber'] = $phone;

            //Redirect to Profile
            $f3->reroute('/profile');
        }
    }

    //display form
    $view = new Template();
    echo $view->render('view/personal.html');
});

//define a profile route
$f3->route('GET|POST /profile', function ($f3) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $selectedSeeking = array();
        $email = $_POST['email'];
        $state = $_POST['state'];
        $bio = $_POST['bio'];
        if (!empty($_POST['seeking'])) {
            $selectedSeeking = $_POST['seeking'];
        }

        $f3->set('email', $email);
        $f3->set('state', $state);
        $f3->set('seeking', $selectedSeeking);


        if (validForm()) {
            //Write data to Session
            $_SESSION['email'] = $email;
            $_SESSION['state'] = $state;
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