<?php

namespace testassignment;

/*
    This class contains the particularities of the DVD product type 
*/

class DVD extends Product
{
    public static $category = "DVD";
    public static $attrName = "Size";
    public static $mUnits = "MB";

    public function __construct(DatabaseConnection $dbconn)
    {   
        parent::__construct($dbconn);
    }

    public function insert()
    {
        $this->dbconn->executeInsertStatement(Product::TABLE,["sku"=>$this->getSku(),"name"=>$this->getName(),"price"=>$this->getPrice(),"attribute"=>$this->getAttribute(),"category"=>DVD::$category]);
    }
}

?>