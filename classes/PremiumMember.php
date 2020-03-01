<?php

class PremiumMember extends Member
{
    private $_indoorInterests;
    private $_outdoorInterests;

    /*
     * PremiumMember constructor calls it's parent class' constructor
     */
    public function __construct($fname, $lname, $age, $gender, $phone, $email, $state, $seeking, $bio, $indoorInterests = NULL, $outdoorInterests = NULL)
    {
        parent::__construct($fname, $lname, $age, $gender, $phone, $email, $state, $seeking, $bio);
        $this->_indoorInterests = $indoorInterests;
        $this->_outdoorInterests = $outdoorInterests;
    }

    /**
     * @return mixed
     */
    public function getIndoorInterests()
    {
        return $this->_indoorInterests;
    }

    /**
     * @param mixed $indoorInterests
     */
    public function setIndoorInterests($indoorInterests)
    {
        $this->_indoorInterests = $indoorInterests;
    }

    /**
     * @return mixed
     */
    public function getOutdoorInterests()
    {
        return $this->_outdoorInterests;
    }

    /**
     * @param mixed $outdoorInterests
     */
    public function setOutdoorInterests($outdoorInterests)
    {
        $this->_outdoorInterests = $outdoorInterests;
    }
}