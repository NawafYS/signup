<?php

class ReviewData
{
    protected $_id, $_userID, $_bookID, $_comment, $_userEmail;

    public function __construct($dbRow)
    {
        $this->_id = $dbRow['review_id'];
        $this->_userID = $dbRow['user_id'];
        $this->_bookID = $dbRow['book_id'];
        $this->_comment = $dbRow['comment'];
        $this->_userEmail = $dbRow['userEmail'];
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
    public function getComment()
    {
        return $this->_comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->_comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->_userEmail;
    }

    /**
     * @param mixed $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->_userEmail = $userEmail;
    }
}