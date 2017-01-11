<?php

require_once('UserHistoryData.php');
require_once('Database.php');

class UserHistoryDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchAllHistory($userID)
    {
        $sqlQuery = "SELECT * FROM user_history WHERE user_id='$userID'";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserHistoryData($row);
        }
        return $dataSet;
    }
}