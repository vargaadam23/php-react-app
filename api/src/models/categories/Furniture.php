<?php

namespace testassignment;

/*
    This class contains the particularities of the Furniture product type 
*/

class Furniture extends Product
{
    public static $category = "Furniture";
    public static $attrName = "Dimensions";

    public function __construct(DatabaseConnection $dbconn)
    {   
        parent::__construct($dbconn);
    }

    public function insert()
    {
        $this->dbconn->executeInsertStatement(Product::TABLE,["sku"=>$this->getSku(),"name"=>$this->getName(),"price"=>$this->getPrice(),"attribute"=>$this->getAttribute(),"category"=>Furniture::$category]);
    }
}

?>