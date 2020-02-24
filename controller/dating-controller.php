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
        $this->_f3->set('seeking', array('male', 'female', 'nonbinary', 'genderqueer', 'other'));
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
            //Get data from form
            $first = $_POST['first-name'];
            $last = $_POST['last-name'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];

            //Add data to hive
            $this->_f3->set('firstName', $first);
            $this->_f3->set('lastName', $last);
            $this->_f3->set('age', $age);
            $this->_f3->set('selectedGender', $gender);
            $this->_f3->set('phoneNumber', $phone);

            //If data is valid
            if (validForm()) {
                //Write data to Session
                $_SESSION['firstName'] = $first;
                $_SESSION['lastName'] = $last;
                $_SESSION['age'] = $age;
                $_SESSION['gender'] = $gender;
                $_SESSION['phoneNumber'] = $phone;

                //Redirect to Profile
                $this->_f3->reroute('/profile');
            }
        }

        //display form
        $view = new Template();
        echo $view->render('view/personal.html');
    }

    public function profile()
    {

    }

    public function interests()
    {

    }

    public function summary()
    {

    }

    public function getValidation() {
        return $this->_validation;
    }

    public function getF3()
    {
        return $this->_f3;
    }

}