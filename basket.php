<?php

session_start();

require_once('Models/BasketDataSet.php');
require_once('Models/BookDataSet.php');
require_once('Models/UserDataSet.php');
require_once('Models/Database.php');

$view = new stdClass();
$view->pageTitle = 'iBasket';
$basketDataSet = new BasketDataSet();
$userId = $_SESSION['user_id'];
$view->basketDataSet = $basketDataSet->fetchAllItems($userId);


if (!isset($_SESSION['user_id'])) {
    header('location: index.php');
}
if (isset($_POST['editQtyBtn'])) {
    $userID = $_SESSION['user_id'];
    $bookID = $_POST['bookID'];
    $quantity = htmlspecialchars($_POST['editQtyTxtBoxName']);

    if (preg_match("/[A-Za-z]/", $quantity)) {
        echo "<script>window.alert('Invalid Input!')</script>";
    } else if ($quantity == "") {
        echo "<script>window.alert('Invalid Input!')</script>";
    } else if ($quantity < 1 && $quantity > -1) {
        $basketDataSet->removeItem($userID, $bookID, $quantity);
        header("Refresh:0");
    } else if ($quantity > 0) {
        $basketDataSet->editQuantity($userID, $bookID, $quantity);
        header("Refresh:0");
    }
} else if (isset($_POST['deleteQtyBtn'])) {
    $userID = $_SESSION['user_id'];
    $bookID = $_POST['bookID'];
    $basketDataSet->removeItem($userID, $bookID);
    header("Refresh:0");
} else if (isset($_POST['purchaseQtyBtn'])) {
    $userID = $_SESSION['user_id'];
    $bookID = $_POST['bookID'];
    $basketDataSet->buyItem($userID, $bookID);
} else if (isset($_POST['purchaseAllItemsBtn'])) {
    $userID = $_SESSION['user_id'];
    $basketDataSet->buyAllItems($userID);
}
if (isset($_POST['clearBasketBtn'])) {
    $userID = $_SESSION['user_id'];
    $basketDataSet->removeAll($userID);
    header("Refresh:0");
}

require_once('Views/basket.phtml');