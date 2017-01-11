<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Gallery';
require_once('Views/gallery.phtml');
