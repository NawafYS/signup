<?php

require_once('Models/Database.php');
require_once('Models/BookData.php');

class BookDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchAllBooks()
    {
        $sqlQuery = 'SELECT * FROM books ';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new BookData($row);
        }
        return $dataSet;
    }

    public function fetchSingleBook($id)
    {
        $sqlQuery = "SELECT * FROM books WHERE book_id='$id'";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new BookData($row);
        }
        return $dataSet;
    }

    public function searchBtns($value)
    {
        $sqlQuery = null;
        if ($value == 'All') {
            $sqlQuery = "SELECT * FROM books ";
        }
        if (($value == 'BestSeller' || $value == 'NewReleased' || $value == 'SalesBooks')) {
            $sqlQuery = "SELECT * FROM books WHERE advanceCategory='$value'  ";
        } else if ($value == 'book_name' || $value == 'book_price' || $value == 'book_price DESC') {
            $sqlQuery = "SELECT * FROM books ORDER BY $value ";
        } else if ($value == 'Fiction' || $value == 'Politics' || $value == 'Business' || $value == 'Biography' || $value == 'History' || $value == 'Education') {
            $sqlQuery = "SELECT * FROM books WHERE book_category ='$value'";
        }

        if ($sqlQuery != null) {
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement
            $dataSet = [];
            while ($row = $statement->fetch()) {
                $dataSet[] = new BookData($row);
            }
        }
        return $dataSet;
    }

    public function search($value)
    {
        $sqlQuery = null;
        $sqlQuery = "SELECT * FROM books WHERE CONCAT(book_name, book_author) LIKE '%" . $value . "%'  ";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new BookData($row);
        }

        if (sizeof($dataSet) == 0) {
            header('location: noResultsFound.php');
        }
        return $dataSet;
    }
}