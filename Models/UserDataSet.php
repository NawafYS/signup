<?php
require_once('UserData.php');
require_once('Database.php');

class UserDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function signUp()
    {
        $email = htmlspecialchars($_POST['signupEmail']);
        $phoneNo = htmlspecialchars($_POST['phoneNo']);
        $houseNo = htmlspecialchars($_POST['houseNo']);
        $streetName = htmlspecialchars($_POST['stName']);
        $city = htmlspecialchars($_POST['city']);
        $country = htmlspecialchars($_POST['country']);
        $postCode = htmlspecialchars($_POST['postcode']);
        $password = htmlspecialchars($_POST['password']);
        $conPassword = htmlspecialchars($_POST['conPassword']);

        if (!is_numeric($phoneNo) || strlen($phoneNo) < 9 || strlen($phoneNo) > 15) {
            echo "<script>alert('Not a valid Phone Number');</script>";
        } else if (!is_numeric($houseNo)) {
            echo "<script>alert('Not a valid House Number');</script>";
        } else if (preg_match('/[0-9]/', $streetName)) {
            echo "<script>alert('Not a valid Street Name');</script>";
        } else if (preg_match('/[0-9]/', $city)) {
            echo "<script>alert('Not a valid City Name');</script>";
        } else if (preg_match('/[0-9]/', $country)) {
            echo "<script>alert('Not a valid Country Name');</script>";
        } else if (strlen($postCode) < 6 || strlen($postCode) > 8) {
            echo "<script>alert('Not a valid Post Code');</script>";
        } else if (strlen($password) < 8 || !preg_match('/[0-9]/', $password) || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password)) {
            echo "<script>alert('Not a valid Password: Needs To be At least 8 characters long and contains at least one number, capital letter and small letter.');</script>";
        } else if ($conPassword != $password) {
            echo "<script>alert('The Entered Passwords do not Match');</script>";
        } else if ($this->checkEmail($email) == true) {
            echo "<script>alert('The Entered Email Has Been Used Before!');</script>";
        } elseif ($this->checkPhoneNo($phoneNo) == true) {
            echo "<script>alert('The Entered Phone Number Has Been Used Before!');</script>";
        } else {

            $salt = "ca34ff6ghh7ggs0hmn112dfg'";
            $password = $password . $salt;
            $password = sha1($password);


            $sqlQuery = "INSERT INTO Users (eMail, phoneNumber, houseNumber, streetName, city, country, postCode, password) 
                         VALUES ('$email', '$phoneNo', '$houseNo', '$streetName', '$city', '$country', '$postCode', '$password')";
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement

            $to = $email;
            $subject = "iRead Sign Up Confirmation";
            $from = "iRead@store.com";
            $loginLink = 'http://stc408.edu.csesalford.com/login.php';
            $body = "Welcome To iRead. Your Registration has been Confirmed. To Login: http://stc408.edu.csesalford.com/login.php ";
            $headers = "From: " . $from;
            mail($to, $subject, $body, $headers);

        }
    }

    public function fetchAllUsers()
    {
        $sqlQuery = 'SELECT * FROM users ';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new userData($row);
        }
        return $dataSet;
    }

    public function checkEmail($enteredEmail)
    {
        $sqlQuery = "SELECT eMail FROM Users Where eMail = '$enteredEmail'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        if ($statement->rowCount() > 0) {

            return true;
        }
    }

    public function checkPhoneNo($enteredPhoneNo)
    {
        $sqlQuery = "SELECT phoneNumber FROM Users Where phoneNumber = '$enteredPhoneNo'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return true;
        }
    }

    public function logIn()
    {
        $user = null;
        $email = $_POST['loginEmail'];
        $password = htmlspecialchars($_POST['loginPassword']);
        if (strlen($password) < 8 || !preg_match('/[0-9]/', $password) || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password)) {
            echo "<script>alert('Not a valid Password');</script>";
        } else {
            $salt = "ca34ff6ghh7ggs0hmn112dfg'";
            $password = $password . $salt;
            $password = sha1($password);


            $sqlQuery = "SELECT * FROM Users WHERE eMail='$email' AND password='$password'";
            $statement = $this->_dbHandle->prepare($sqlQuery);
            $statement->execute();
            $count = $statement->rowCount();


            if ($count > 0) {
                $row = $statement->fetch();
                $user = new UserData($row);
                $userId = $user->getId();
                $_SESSION['user_id'] = $userId;
                header('location: index.php');
            } else {
                echo '<script>window.alert("Try Again!")</script>';
            }
        }
    }

    public function fetchSingleUser($id)
    {
        $sqlQuery = "SELECT * FROM Users WHERE user_id='$id'";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row);
        }
        return $dataSet;
    }

    public function resetPasswordEmail($email)
    {
        $sqlQuery = "SELECT * FROM Users WHERE eMail='$email'";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
        $user = new UserData($statement->fetch(0));
        $userID = $user->getId();
        if ($userID != null) {
            $to = $email;
            $subject = "iRead: Reset Password";
            $from = "iRead@store.com";
            $body = "You Can Reset Your Password Through This Page: http://stc408.edu.csesalford.com/resetPassword.php ";
            $headers = "From: " . $from;
            mail($to, $subject, $body, $headers);
            echo '<script>window.alert("Please Check your Email and Follow the Attached Instruction")</script>';
        } else {
            echo '<script>window.alert("The Entered Email has NOT been Found!")</script>';
        }
    }

    public function resetPassword($email, $password)
    {
        $sqlQuery = "SELECT * FROM Users WHERE eMail='$email'";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
        $user = new UserData($statement->fetch(0));
        $userID = $user->getId();
        $salt = "ca34ff6ghh7ggs0hmn112dfg'";
        $password = $password . $salt;
        $password = sha1($password);

        if ($userID != null) {
            $sqlQuery = "UPDATE Users SET password='$password' WHERE user_id=$userID";
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement
            echo '<script>window.alert("Your Password has Successfully been Changed")</script>';
            header("location: login.php");
        } else {
            echo '<script>window.alert("The Entered Email has NOT been Found!")</script>';
        }
    }

    public function sendRequest($name, $email, $phoneNo, $comment)
    {
        $to = 'n.y.alsuwailem@edu.salford.ac.uk';
        $subject = $name . ' : ' . $phoneNo;
        $from = $email;
        $body = $comment;
        $headers = "From: " . $from;
        mail($to, $subject, $body, $headers);
        echo '<script>window.alert("Your Request has been sent Successfully")</script>';
        header("location: index.php");
    }

    public function changeEmail($newEmail, $userID)
    {
        $sqlQuery = "UPDATE Users SET eMail='$newEmail' WHERE user_id=$userID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    public function changePhoneNo($newPhoneNo, $userID)
    {
        $sqlQuery = "SELECT * FROM Users WHERE phoneNumber='$newPhoneNo'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $result = $statement->fetch(0);

        if (sizeof($result) > 1) {
            echo '<script>window.alert("The Number You have Entered has been Used Before, Please Try Again!")</script>';
        } else {
            $sqlQuery = "UPDATE Users SET phoneNumber='$newPhoneNo' WHERE user_id=$userID";
            $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement
        }
    }

    public function changeHouseNo($newHouseNo, $userID)
    {
        $sqlQuery = "UPDATE Users SET houseNumber='$newHouseNo' WHERE user_id=$userID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    public function changeStName($newStName, $userID)
    {
        $sqlQuery = "UPDATE Users SET streetName='$newStName' WHERE user_id=$userID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    public function changeCity($newCity, $userID)
    {
        $sqlQuery = "UPDATE Users SET city='$newCity' WHERE user_id=$userID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    public function changeCountry($newCountry, $userID)
    {
        $sqlQuery = "UPDATE Users SET country='$newCountry' WHERE user_id=$userID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    public function changePostCode($newPostCode, $userID)
    {
        $sqlQuery = "UPDATE Users SET postCode='$newPostCode' WHERE user_id=$userID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    public function changePassword($newPassword, $userID)
    {
        $sqlQuery = "UPDATE Users SET password='$newPassword' WHERE user_id=$userID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }
}