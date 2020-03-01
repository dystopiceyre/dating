<?php

class PremiumMember extends Member
{
    private $_indoorInterests;
    private $_outdoorInterests;
    private $_image;

    /*
     * PremiumMember constructor calls it's parent class' constructor
     */
    public function __construct($fname, $lname, $age, $gender, $phone, $indoorInterests, $outdoorInterests, $image = NULL)
    {
        parent::__construct($fname, $lname, $age, $gender, $phone);
        $this->_indoorInterests = $indoorInterests;
        $this->_outdoorInterests = $outdoorInterests;
        $this->_image = $image;
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

    /**
     * @return null
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * @param null $image
     */
    public function setImage($image)
    {
        $this->_image = $image;
    }
}