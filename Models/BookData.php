<?php

class BookData
{

    protected $_id, $_bookName, $_bookPrice, $_bookAuthor, $_bookCategory, $_noInStock, $_photoName, $_adCategory;


    public function __construct($dbRow)
    {
        $this->_id = $dbRow['book_id'];
        $this->_bookName = $dbRow['book_name'];
        $this->_bookPrice = $dbRow['book_price'];
        $this->_bookAuthor = $dbRow['book_author'];
        $this->_bookCategory = $dbRow['book_category'];
        $this->_noInStock = $dbRow['noInStock'];
        $this->_photoName = $dbRow['photo_name'];
        $this->_adCategory = $dbRow['advanceCategory'];
    }

    public function getBookID()
    {
        return $this->_id;
    }

    public function getBookName()
    {
        return $this->_bookName;
    }

    public function getBookPrice()
    {
        return $this->_bookPrice;
    }

    public function getBookAuthor()
    {
        return $this->_bookAuthor;
    }

    public function getBookCategory()
    {
        return $this->_bookCategory;
    }

    public function getNoInStock()
    {
        return $this->_noInStock;
    }

    public function getPhotoName()
    {
        return $this->_photoName;
    }

    public function getAdCategory()
    {
        return $this->_adCategory;
    }

    public function setAdCategory($adCategory)
    {
        $this->_adCategory = $adCategory;
    }


}