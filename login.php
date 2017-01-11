<?php
session_start();
require_once('Models/UserDataSet.php');
require_once('Models/Database.php');


$view = new stdClass();
$view->pageTitle = 'LogIn';
$userDataSet = new UserDataSet();

if (isset($_SESSION['user_id'])) {
    header('location: index.php');
}
if (isset($_POST['logInSubmitBtn'])) {
    $userDataSet->logIn();
}
if (isset($_POST['signUpSubmitBtn'])) {
    $userDataSet->signUp();
    header("Location: login.php");
}
if (isset($_POST['forgotPassSubmitBtn'])) {
    $email = htmlspecialchars($_POST['forgotEmail']);
    $userDataSet->resetPasswordEmail($email);
    header("refresh:0;url=index.php");
}
require_once('Views/login.phtml');




