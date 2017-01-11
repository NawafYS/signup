<?php
session_start();
require_once('Models/UserDataSet.php');
require_once('Models/Database.php');


$view = new stdClass();
$view->pageTitle = 'Reset Password';
$userDataSet = new UserDataSet();

if (isset($_POST['resetSubmitBtn'])) {
    $userEmail = htmlspecialchars($_POST['resetEmail']);
    $newPassword = htmlspecialchars($_POST['resetPassword']);
    $newConPassword = htmlspecialchars($_POST['resetConPassword']);
    if (strlen($newPassword) < 8 || !preg_match('/[0-9]/', $newPassword) || !preg_match('/[A-Z]/', $newPassword) || !preg_match('/[a-z]/', $newPassword)) {
            echo "<script>alert('Not a valid Password: Needs To be At least 8 characters long and contains at least one number, capital letter and small letter.');</script>";
    }
    else if ($newPassword != $newConPassword){
        echo "<script>window.alert('The Entered Passwords do NOT Match!')</script>";
    }
    else{
        $userDataSet->resetPassword($userEmail, $newConPassword);
    }
}
require_once('Views/resetPassword.phtml');




