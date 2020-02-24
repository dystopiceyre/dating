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
        $this->_f3 = Base::instance();;
        $this->_validation = new DatingValidation();

        $this->_f3->set('DEBUG', 3);

        //define arrays
        $this->_f3->set('states', array('AL', 'AK', 'AR', 'AZ', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL',
            'GA', 'HI', 'IA', 'ID', 'IL', 'IN', 'KS', 'KY', 'LA', 'MA', 'MD', 'ME',
            'MI', 'MN', 'MO', 'MS', 'MT', 'NC', 'NE', 'NH', 'NJ', 'NM', 'NV', 'NY',
            'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT',
            'VA', 'WA', 'WI', 'WV', 'WY'));
        $this->_f3->set('genders', array('male', 'female', 'nonbinary', 'genderqueer', 'other'));
        $this->_f3->set('indoor', array('reading', 'writing-letters', 'playing-instrument', 'singing', 'sewing', 'cooking'));
        $this->_f3->set('outdoor', array('horseback-riding', 'fencing', 'walking', 'picknicking', 'gardening', 'swimming'));
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

            $first = $_POST['first'];
            if ($this->_validation->validFirstName($first)) {
                $this->_f3->set('firstName', $first);
            } else {
                $this->_f3->set("errors['firstName']", "Please enter a first name.");
                $isValid = false;
            }
            $last = $_POST['last'];
            if ($this->_validation->validLastName($last)) {
                $this->_f3->set('lastName', $last);
            } else {
                $this->_f3->set("errors['lastName']", "Please enter a last name.");
                $isValid = false;
            }
            $age = $_POST['age'];
            if ($this->_validation->validAge($age)) {
                $this->_f3->set('age', $age);
            } else {
                $this->_f3->set("errors['age']", "Please enter an age between 18 and 118.");
                $isValid = false;
            }
            $gender = $_POST['gender'];
            if (in_array($gender, $this->_f3->get("genders"))) {
                $this->_f3->set('selectedGender', $gender);
            } else {
                $this->_f3->set("errors['gender']", "Please enter a valid gender.");
                $isValid = false;
            }
            $phone = $_POST['phone'];
            if ($this->_validation->validPhone($phone)) {
                $this->_f3->set('phone', $phone);
            } else {
                $this->_f3->set("errors['phone']", "Please enter a phone number with only numbers and dashes.");
                $isValid = false;
            }
            //check for premium membership
            if (isset($_POST['premium'])) {
                $this->_f3->set('premium', true);
            }
            $_SESSION["premium"] = (isset($_POST["premium"]) ? true : false);

            //Redirect to Profile
            if ($isValid) {
                if ($_SESSION['premium']) {
                    $user = new PremiumMember($_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['age'],
                        $_SESSION['gender'], $_SESSION['phoneNumber']);
                } else {
                    $user = new Member($_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['age'],
                        $_SESSION['gender'], $_SESSION['phoneNumber']);
                }
                $this->_f3->set("user", $user);
                $_SESSION["user"] = $user;
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
            $selectedSeeking = array();
            $email = $_POST['email'];
            if ($this->_validation->validEmail($email)) {
                $this->_f3->set('email', $email);
            } else {
                $this->_f3->set("errors['email']", "Please enter a valid email address.");
                $isValid = false;
            }
            $selectedState = $_POST['state'];
            if (in_array($selectedState, $this->_f3->get("states"))) {
                $this->_f3->set('state', $selectedState);
            } else {
                $this->_f3->set("errors['state]", "Please enter a valid state.");
                $isValid = false;
            }
            $bio = $_POST['bio'];
            if (isset($bio)) {
                $this->_f3->set('bio', $bio);
            }
            if (!empty($_POST['seeking'])) {
                $selectedSeeking = $_POST['seeking'];
                if (in_array($selectedSeeking, $this->_f3->get("genders"))) {
                    $this->_f3->set('seeking', $selectedSeeking);
                }
            }

            $this->_f3->set('email', $email);
            $this->_f3->set('selectedState', $selectedState);
            $this->_f3->set('seeking', $selectedSeeking);

            if ($isValid) {
                //Write data to Session
                $_SESSION['email'] = $email;
                $_SESSION['state'] = $selectedState;
                $_SESSION['seeking'] = $selectedSeeking;
                $_SESSION['bio'] = $bio;

                //if the user is a premium member, redirect to interests page
                if (is_a($_SESSION["user"], "PremiumMember")) {
                    $this->_f3->reroute('/interests-form');
                } else {
                    //non-members go straight to the profile summary
                    $this->_f3->reroute('/profile-summary');
                }
            }
        }

        $view = new Template();
        echo $view->render('view/profile.html');
    }

    public function interests()
    {
        $isValid = true;
        $selectedIndoor = array();
        $selectedOutdoor = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['indoorInterests'])) {
                $selectedIndoor = $_POST['indoorInterests'];
                if ($this->_validation->validIndoor($selectedIndoor)) {
                    $this->_f3->set('indoor', $selectedIndoor);
                } else {
                    $isValid = false;
                }
            }
            if (!empty($_POST['outdoorInterests'])) {
                $selectedOutdoor = $_POST['outdoorInterests'];
                if ($this->_validation->validOutdoor($selectedOutdoor)) {
                    $this->_f3->set('outdoor', $selectedOutdoor);
                } else {
                    $isValid = false;
                }
            }

            $this->_f3->set('indoorInterests', $selectedIndoor);
            $this->_f3->set('outdoorInterests', $selectedOutdoor);


            if ($isValid) {
                //Write data to Session
                $_SESSION['indoorInterests'] = $selectedIndoor;
                $_SESSION['outdoorInterests'] = $selectedOutdoor;

                //Redirect to Summary
                $this->_f3->reroute('/summary');
            }
        }

        $view = new Template();
        echo $view->render('view/interests.html');
    }

    public function summary()
    {
        $view = new Template();
        echo $view->render('view/summary.html');
    }

    public function getValidation()
    {
        return $this->_validation;
    }

    public function getF3()
    {
        return $this->_f3;
    }

}