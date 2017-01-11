<?php

session_start();
require_once('Models/UserDataSet.php');
require_once('Models/Database.php');
$view = new stdClass();
$view->pageTitle = 'HOME';
$userDataSet = new UserDataSet();

if (isset($_POST['askusBtn'])) {
    $name = htmlspecialchars($_POST['nameTxtBox']);
    $email = htmlspecialchars($_POST['emailTxtBox']);
    $phoneNo = htmlspecialchars($_POST['phoneNumberTxtBox']);
    $request = htmlspecialchars($_POST['requestTxtArea']);
    $userDataSet->sendRequest($name, $email, $phoneNo, $request);
}

require_once('Views/index.phtml');
