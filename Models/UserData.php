<?php

class UserData
{
    protected $_id, $_Email, $_PhoneNo, $_HouseNo, $_StreetName, $_city, $_country, $_postCode, $_password, $_admin;

    public function __construct($dbRow)
    {
        $this->_id = $dbRow['user_id'];
        $this->_Email = $dbRow['eMail'];
        $this->_PhoneNo = $dbRow['phoneNumber'];
        $this->_HouseNo = $dbRow['houseNumber'];
        $this->_StreetName = $dbRow['streetName'];
        $this->_city = $dbRow['city'];
        $this->_country = $dbRow['country'];
        $this->_postCode = $dbRow['postCode'];
        $this->_password = $dbRow['password'];
        $this->_admin = $dbRow['isAdmin'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_Email;
    }

    /**
     * @param mixed $Email
     */
    public function setEmail($Email)
    {
        $this->_Email = $Email;
    }

    /**
     * @return mixed
     */
    public function getPhoneNo()
    {
        return $this->_PhoneNo;
    }

    /**
     * @param mixed $PhoneNo
     */
    public function setPhoneNo($PhoneNo)
    {
        $this->_PhoneNo = $PhoneNo;
    }

    /**
     * @return mixed
     */
    public function getHouseNo()
    {
        return $this->_HouseNo;
    }

    /**
     * @param mixed $HouseNo
     */
    public function setHouseNo($HouseNo)
    {
        $this->_HouseNo = $HouseNo;
    }

    /**
     * @return mixed
     */
    public function getStreetName()
    {
        return $this->_StreetName;
    }

    /**
     * @param mixed $StreetName
     */
    public function setStreetName($StreetName)
    {
        $this->_StreetName = $StreetName;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->_city = $city;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->_country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->_country = $country;
    }

    /**
     * @return mixed
     */
    public function getPostCode()
    {
        return $this->_postCode;
    }

    /**
     * @param mixed $postCode
     */
    public function setPostCode($postCode)
    {
        $this->_postCode = $postCode;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->_admin;
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin)
    {
        $this->_admin = $admin;
    }
}