<?php

class UserHistoryData
{
    protected $_id, $_userID, $_bookID, $_purchaseDate;

    public function __construct($dbRow)
    {
        $this->_id = $dbRow['history_id'];
        $this->_userID = $dbRow['user_id'];
        $this->_bookID = $dbRow['book_id'];
        $this->_purchaseDate = $dbRow['purchase_date'];
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
    public function getUserID()
    {
        return $this->_userID;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID)
    {
        $this->_userID = $userID;
    }

    /**
     * @return mixed
     */
    public function getBookID()
    {
        return $this->_bookID;
    }

    /**
     * @param mixed $bookID
     */
    public function setBookID($bookID)
    {
        $this->_bookID = $bookID;
    }

    /**
     * @return mixed
     */
    public function getPurchaseDate()
    {
        return $this->_purchaseDate;
    }

    /**
     * @param mixed $purchaseDate
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->_purchaseDate = $purchaseDate;
    }

}