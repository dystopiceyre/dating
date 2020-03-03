<?php

/*
 * Class DatingController
 */

class DatingController
{
    private $_f3;
    private $_validation;

    /**
     * DatingController constructor.
     */
    public function __construct()
    {
        $this->_f3 = Base::instance();
        $this->_validation = new DatingValidation();

        $this->_f3->set('DEBUG', 3);

        //define arrays
        $this->_f3->set('states', array('AL', 'AK', 'AR', 'AZ', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL',
            'GA', 'HI', 'IA', 'ID', 'IL', 'IN', 'KS', 'KY', 'LA', 'MA', 'MD', 'ME',
            'MI', 'MN', 'MO', 'MS', 'MT', 'NC', 'NE', 'NH', 'NJ', 'NM', 'NV', 'NY',
            'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT',
            'VA', 'WA', 'WI', 'WV', 'WY'));
        $this->_f3->set('genders', array(1 => 'male', 2 => 'female', 3 => 'nonbinary', 4 => 'genderqueer'));
        $this->_f3->set('indoor', array(1 => 'reading', 2 => 'writing-letters', 3 => 'playing-instrument', 4 => 'singing', 5 => 'sewing', 6 => 'cooking'));
        $this->_f3->set('outdoor', array(7 => 'horseback-riding', 8 => 'fencing', 9 => 'walking', 10 => 'picknicking', 11 => 'gardening', 12 => 'swimming'));
    }

    public function home()
    {
        $view = new Template();
        echo $view->render('view/home.html');
    }

    public function personal()
    {
        //If form has been submitted, validate
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $isValid = true;

            $first = $_POST['firstName'];
            if ($this->_validation->validName($first)) {
                $_SESSION['firstName'] = $first;
            } else {
                $this->_f3->set("errors['firstName']", "Please enter a first name.");
                $isValid = false;
            }
            $last = $_POST['lastName'];
            if ($this->_validation->validName($last)) {
                $_SESSION['lastName'] = $last;
            } else {
                $this->_f3->set("errors['lastName']", "Please enter a last name.");
                $isValid = false;
            }
            $age = $_POST['age'];
            if ($this->_validation->validAge($age)) {
                $_SESSION['age'] = $age;
            } else {
                $this->_f3->set("errors['age']", "Please enter an age between 18 and 118.");
                $isValid = false;
            }
            $gender = $_POST['gender'];
            if (in_array($gender, $this->_f3->get("genders"))) {
                $_SESSION['gender'] = $gender;
            } else {
                $this->_f3->set("errors['gender']", "Please enter a valid gender.");
                $isValid = false;
            }
            $phone = $_POST['phoneNumber'];
            if ($this->_validation->validPhone($phone)) {
                $_SESSION['phoneNumber'] = $phone;
            } else {
                $this->_f3->set("errors['phoneNumber']", "Please enter a phone number with only numbers and dashes.");
                $isValid = false;
            }
            //check for premium membership
            if (isset($_POST["premiumMembership"])) {
                $_SESSION["premiumMembership"] = true;
            } else {
                $_SESSION["premiumMembership"] = false;
            }
            //Redirect to Profile
            if ($isValid) {
                $this->_f3->reroute('/profile');
            }
        }
        //display form
        $view = new Template();
        echo $view->render('view/personal.html');
    }

    public function profile()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $isValid = true;
            $email = $_POST['email'];
            if ($this->_validation->validEmail($email)) {
                $_SESSION['email'] = $email;
            } else {
                $this->_f3->set("errors['email']", "Please enter a valid email address.");
                $isValid = false;
            }
            $selectedState = $_POST['state'];
            if ($this->_validation->validState($selectedState, $this->_f3)) {
                $_SESSION['state'] = $selectedState;
            } else {
                $this->_f3->set("errors['state]", "Please enter a valid state.");
                $isValid = false;
            }
            if (!empty($_POST['seeking'])) {
                $selectedSeeking = $_POST['seeking'];
                if ($this->_validation->validSeeking($selectedSeeking, $this->_f3)) {
                    $_SESSION['seeking'] = $selectedSeeking;
                }
            }
            $bio = $_POST['bio'];
            if (isset($bio)) {
                $_SESSION['bio'] = $bio;
            }
            if ($isValid) {
//                //if the user is a premium member, redirect to interests page
                if ($_SESSION['premiumMembership']) {
                    $this->_f3->reroute('/interests');
                } else {
//                    //non-members go straight to the profile summary
                    $this->_f3->reroute('/summary');
                }
            }
        }
        $view = new Template();
        echo $view->render('view/profile.html');
    }

    public function interests()
    {
        $isValid = true;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['indoorInterests'])) {
                $selectedIndoor = $_POST['indoorInterests'];
                if ($this->_validation->validIndoor($selectedIndoor, $this->_f3)) {
                    $_SESSION['indoorInterests'] = $selectedIndoor;
                } else {
                    $isValid = false;
                }
            }
            if (!empty($_POST['outdoorInterests'])) {
                $selectedOutdoor = $_POST['outdoorInterests'];
                if ($this->_validation->validOutdoor($selectedOutdoor, $this->_f3)) {
                    $_SESSION['outdoorInterests'] = $selectedOutdoor;
                } else {
                    $isValid = false;
                }
            }
            if ($isValid) {
//                Redirect to Summary
                $this->_f3->reroute('/summary');
            }
        }
        $view = new Template();
        echo $view->render('view/interests.html');
    }

    public function summary()
    {
        $user = new Member($_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['age'], $_SESSION['gender'],
            $_SESSION['phoneNumber'], $_SESSION['email'], $_SESSION['state'], $_SESSION['seeking'],
            $_SESSION['bio']);
        $_SESSION['user'] = $user;
//        add base member to db and get id
        $id = $GLOBALS['db']->createMember($user);
        //add seeking info to db
        foreach ($_SESSION['seeking'] as $index => $seeking) {
            $seeking_id = array_search($seeking, $this->_f3->get('genders'));
            $GLOBALS['db']->addSeeking($id, $seeking_id);
        }
        if ($_SESSION["premiumMembership"] == true) {
            $premiumUser = new PremiumMember($_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['age'],
                $_SESSION['gender'], $_SESSION['phoneNumber'], $_SESSION['email'], $_SESSION['state'],
                $_SESSION['seeking'], $_SESSION['bio'], $_SESSION['indoorInterests'], $_SESSION['outdoorInterests']);
            $_SESSION['user'] = $premiumUser;
            //update base member with premium info
            $GLOBALS['db']->premiumMember($premiumUser, $id);
            //add interest info to db
            foreach ($_SESSION['indoorInterests'] as $index => $indoor) {
                $interest_id = array_search($indoor, $this->_f3->get('indoor'));
                $GLOBALS['db']->addInterests($id, $interest_id);
            }
            foreach ($_SESSION['outdoorInterests'] as $index => $outdoor) {
                $interest_id = array_search($outdoor, $this->_f3->get('outdoor'));
                $GLOBALS['db']->addInterests($id, $interest_id);
            }
        }
        $view = new Template();
        echo $view->render('view/summary.html');
    }

    public function admin()
    {
        $members = $GLOBALS['db']->getMembers();
        $this->_f3->set('members', $members);
        $view = new Template();
        echo $view->render('view/admin.html');
    }

    public
    function getValidation()
    {
        return $this->_validation;
    }

    public
    function getF3()
    {
        return $this->_f3;
    }

}