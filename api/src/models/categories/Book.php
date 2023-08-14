<?php

namespace testassignment;

/*
    This class contains the particularities of the Book product type 
*/

class Book extends Product
{
    public static $category = "Book";
    public static $attrName = "Weight";
    public static $mUnits = "KG";

    public function __construct(DatabaseConnection $dbconn)
    {   
        parent::__construct($dbconn);
    }

    public function insert()
    {
        $this->dbconn->executeInsertStatement(Product::TABLE,["sku"=>$this->getSku(),"name"=>$this->getName(),"price"=>$this->getPrice(),"attribute"=>$this->getAttribute(),"category"=>Book::$category]);
    }
}

?>