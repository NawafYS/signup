<?php
session_start();
require_once('Models/UserDataSet.php');
require_once('Models/UserData.php');
require_once('Models/UserDataSet.php');
require_once('Models/UserHistoryDataSet.php');
require_once('Models/BasketDataSet.php');
require_once('Models/BookDataSet.php');
$view = new stdClass();
$view->pageTitle = 'MyProfile';
$userDataSet = new UserDataSet();
$userID = $_SESSION['user_id'];
if (!isset($_SESSION['user_id'])) {
    header('location: index.php');
}
if (isset($_POST['changeEmail'])) {
    $newEmail = htmlspecialchars($_POST['newEmail']);
    $userDataSet->changeEmail($newEmail, $userID);

}
if (isset($_POST['changePhoneNo'])) {
    $newPhoneNo = htmlspecialchars($_POST['newPhoneNo']);
    $userDataSet->changePhoneNo($newPhoneNo, $userID);
}
if (isset($_POST['changeHouseNo'])) {
    $newHouseNo = htmlspecialchars($_POST['newHouseNo']);
    $userDataSet->changeHouseNo($newHouseNo, $userID);
}
if (isset($_POST['changeStName'])) {
    $newStName = htmlspecialchars($_POST['newStName']);
    $userDataSet->changeStName($newStName, $userID);
}
if (isset($_POST['changeCity'])) {
    $newCity = htmlspecialchars($_POST['newCity']);
    $userDataSet->changeCity($newCity, $userID);
}
if (isset($_POST['changeCountry'])) {
    $newCountry = htmlspecialchars($_POST['newCountry']);
    $userDataSet->changeCountry($newCountry, $userID);
}
if (isset($_POST['changePostCode'])) {
    $newPostCode = htmlspecialchars($_POST['newPostCode']);
    $userDataSet->changePostCode($newPostCode, $userID);
}
if (isset($_POST['changePassword'])) {
    $newPassword = htmlspecialchars($_POST['newPassword']);
    $newConPassword = htmlspecialchars($_POST['ConPassword']);
    if ($newPassword == $newConPassword) {
        $salt = "ca34ff6ghh7ggs0hmn112dfg'";
        $newConPassword = $newConPassword . $salt;
        $newConPassword = sha1($newConPassword);

        $userDataSet->changePassword($newConPassword, $userID);
    } else {
        echo '<script>window.alert("Tyhe Entered Passwords do NOT Match! Try Again")</script>';
    }

}

require_once('Views/profile.phtml');
