<?php
require_once('BasketData.php');
require_once('Database.php');

class BasketDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function addToBasket($userID, $bookID, $quantity)
    {
        $sqlQuery = "SELECT * FROM user_basket WHERE user_id=$userID AND book_id=$bookID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new BasketData($row);
        }

        if (sizeof($dataSet) > 0) {
            $subSqlQuery = "UPDATE user_basket SET quantity=quantity+$quantity WHERE book_id=$bookID";
            $subStatement = $this->_dbHandle->prepare($subSqlQuery); // prepare a PDO statement
            $subStatement->execute(); // execute the PDO statement
        } else {
            $subSqlQuery2 = "INSERT INTO user_basket (user_id, book_id, quantity)
                      VALUES  ('$userID', '$bookID', '$quantity')";

            $subStatement2 = $this->_dbHandle->prepare($subSqlQuery2); // prepare a PDO statement
            $subStatement2->execute(); // execute the PDO statement
        }
    }


    public function fetchAllItems($userID)
    {
        $sqlQuery = "SELECT * FROM user_basket WHERE user_id='$userID'";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new BasketData($row);
        }
        return $dataSet;
    }

    public function editQuantity($userID, $bookID, $quantity)
    {
        $sqlQuery = "UPDATE user_basket SET quantity=$quantity WHERE user_id=$userID AND book_id=$bookID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    public function removeItem($userID, $bookID)
    {
        $sqlQuery = "DELETE FROM user_basket WHERE user_id=$userID AND book_id=$bookID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    public function buyItem($userID, $bookID)
    {
        $sqlQuery = "SELECT * FROM books WHERE book_id=$bookID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $bookData = $statement->fetch(0);
        $noInStock = $bookData[5];
        $book_id = $bookData[0];
        $userID = $_SESSION['user_id'];

        $sqlQuery = "SELECT quantity FROM user_basket WHERE user_id=$userID AND book_id=$bookID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $quantity = $statement->fetchColumn(0);

        if ($quantity <= $noInStock) {
            $sqlQuery = "INSERT INTO user_history (user_id, book_id, purchase_date)
                         VALUES ('$userID', '$book_id', CURDATE())";
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement


            $sqlQuery = "DELETE FROM user_basket WHERE user_id=$userID AND book_id=$bookID";
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement

            $sqlQuery = "UPDATE books SET noInStock=$noInStock-$quantity WHERE book_id=$bookID";
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement

            header("Refresh:0");
        } else {
            echo "<script>window.alert('The Selected Quantity is NOT Available!')</script>";
        }
    }

    public function buyAllItems($userID)
    {
        $sqlQuery = "SELECT * FROM user_basket WHERE user_id='$userID'";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $userID = $_SESSION['user_id'];
        $allItems = $statement->fetchAll();
        $item = null;
        $checks[] = null;
        for ($i = 0; $i < count($allItems); $i++) {

            $item = $allItems[$i];
            $bookID = $item[2];
            $quantity = $item[3];

            $sqlQuery = "SELECT * FROM books WHERE book_id=$bookID";
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement

            $bookData = new BookData($statement->fetch($i));
            $bookName = $bookData->getBookName();
            $noInStock = $bookData->getNoInStock();

            if ($quantity <= $noInStock) {
                $checks[$i] = true;
            } else {
                echo "<script>window.alert('The Selected Quantity for \"$bookName\" is NOT Available!')</script>";
                $checks[$i] = false;
            }
        }
        $trues = 0;
        for ($i = 0; $i < count($checks); $i++) {
            if ($checks[$i] == true) {
                $trues++;
            }
        }
        if ($trues == count($allItems)) {
            for ($i = 0; $i < count($allItems); $i++) {

                $item = $allItems[$i];
                $bookID = $item[2];
                $quantity = $item[3];

                $sqlQuery = "SELECT * FROM books WHERE book_id=$bookID";
                $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
                $statement->execute(); // execute the PDO statement

                $bookData = new BookData($statement->fetch($i));
                $noInStock = $bookData->getNoInStock();
                $book_id = $bookData->getBookID();

                $sqlQuery = "INSERT INTO user_history (user_id, book_id, purchase_date)
                         VALUES ('$userID', '$book_id',CURDATE())";
                $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
                $statement->execute(); // execute the PDO statement

                $sqlQuery = "UPDATE books SET noInStock=$noInStock-$quantity WHERE book_id=$bookID";
                $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
                $statement->execute(); // execute the PDO statement
            }
            $sqlQuery = "DELETE FROM user_basket WHERE user_id=$userID";
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement
            header("Refresh:0");
        }
    }

    public function removeAll($userID)
    {
        $sqlQuery = "DELETE FROM user_basket WHERE user_id=$userID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }
}
