<?php

class BasketData
{
    protected $_id, $_userID, $_bookID, $_quantity;

    public function __construct($dbRow)
    {
        $this->_id = $dbRow['basket_id'];
        $this->_userID = $dbRow['user_id'];
        $this->_bookID = $dbRow['book_id'];
        $this->_quantity = $dbRow['quantity'];
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getUserID()
    {
        return $this->_userID;
    }

    public function setUserID($userID)
    {
        $this->_userID = $userID;
    }

    public function getBookID()
    {
        return $this->_bookID;
    }

    public function setBookID($bookID)
    {
        $this->_bookID = $bookID;
    }

    public function getQuantity()
    {
        return $this->_quantity;
    }

    public function setQuantity($quantity)
    {
        $this->_quantity = $quantity;
    }
}