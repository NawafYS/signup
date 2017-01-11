<?php
require_once('ReviewData.php');
require_once('Database.php');

class ReviewDataSet
{
    protected $_dbHandle, $_dbInstance;
    var $_userEmail;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function postComment($userID, $bookID, $comment, $useremail)
    {
        if ($comment != null) {
            $sqlQuery = "INSERT INTO book_reviews (user_id, book_id, comment, userEmail)
                      VALUES  ('$userID', '$bookID', '$comment', '$useremail')";

            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement

        }
    }

    public function fetchAllReviews($bookID)
    {
        $sqlQuery = "SELECT * FROM book_reviews WHERE book_id=$bookID ORDER BY review_id DESC ";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new ReviewData($row);
        }
        return $dataSet;
    }
}