<?php
session_start();

require_once('Models/BookDataSet.php');
require_once('Models/Database.php');
require_once('Models/BasketDataSet.php');
require_once('Models/UserDataSet.php');
require_once('Models/UserData.php');
require_once('Models/ReviewDataSet.php');
require_once('Models/ReviewData.php');

$view = new stdClass();
$view->pageTitle = 'iBook';
$bookDataSet = new BookDataSet();
$userDataSet = new UserDataSet();
$reviewDataSet = new ReviewDataSet();


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $view->bookDataSet = $bookDataSet->fetchSingleBook($id)[0];
    $view->reviewDataSet = $reviewDataSet->fetchAllReviews($id);
}

if (isset($_POST)) {
    $basketDataSet = new BasketDataSet();
    $basketDataSet->addToBasket($_SESSION['user_id'], $_POST['id'], $_POST['quantity']);
}

if (isset($_POST['bookPageAddBasketBtn'])) {
    header('location: shop.php');
}
if (isset($_POST['postReviewButton'])) {
    $userID = $_SESSION['user_id'];
    $bookID = $_POST['bookID'];
    $comment = htmlspecialchars($_POST['comment']);
    $userData = $userDataSet->fetchSingleUser($userID)[0];
    $userEmail = $userData->getEmail();
    $reviewDataSet->postComment($userID, $bookID, $comment, $userEmail);
    header("Location: bookPage.php?id=" . $bookID);
}

require_once('Views/bookPage.phtml');
