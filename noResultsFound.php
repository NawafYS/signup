<?php
session_start();

require_once('Models/BookDataSet.php');
$view = new stdClass();
$view->pageTitle = 'Shop';
$bookDataSet = new BookDataSet();

require_once('Views/noResultsFound.phtml');