<?php
session_start();

require_once('Models/BookDataSet.php');
require_once('Models/BasketDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Shop';
$bookDataSet = new BookDataSet();
$basketDataSet = new BasketDataSet();


if (!isset($_POST['catSubmit'])) {
    $view->bookDataSet = $bookDataSet->fetchAllBooks();
} else if (isset($_POST['catSubmit'])) {
    $value = $_POST['catSubmit'];
    $view->bookDataSet = $bookDataSet->searchBtns($value);
}


if (isset($_POST['searchbtn'])) {
    $value = htmlspecialchars($_POST['searchtxtBox']);
    $view->bookDataSet = $bookDataSet->search($value);
}

if (isset($_GET['add']) && isset($_SESSION['user_id'])) {
    $view->basketDataSet = $basketDataSet->addToBasket($_SESSION['user_id'], $_GET['add'], 1);
}


require_once('Views/shop.phtml');
