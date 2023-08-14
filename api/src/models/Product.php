<?php

namespace testassignment;

/*
    This abstract class is responsible modelling the base product logic and the attributes
*/

abstract class Product
{
    private $id;
    private $sku;
    private $name;
    private $price;
    private $attribute;

    protected $dbconn;

    public const TABLE = "products";

    public function __construct(DatabaseConnection $conn)
    {
        $this->dbconn=$conn;
    }

    /*
        This static function is responsible for getting all the products from the database
    */

    public static function getAll(DatabaseConnection $dbconn)
    {
        return $dbconn->executeGetAllRows(Product::TABLE);
    }

    /*
        This static function is responsible for deleting the desired products from the database
    */

    public static function massDelete(DatabaseConnection $dbconn, array $idArray)
    {
       return $dbconn -> executeDeleteStatement(Product::TABLE, $idArray);
    }

    /*
        This abstract funtion has the purpose of forcing all the different product types
        to implement the insert function
    */

    abstract public function insert();

    //GETTERS

    public function getId()
    {
        return $this->id;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getCategory()
    {
        return $this->category;
    }
        
    //SETTERS

    public function setId($var)
    {
        $this->id=$var;
    }

    public function setSku($var)
    {
        $this->sku=$var;
    }

    public function setName($var)
    {
        $this->name=$var;
    }

    public function setPrice($var)
    {
        $this->price=$var;
    }

    public function setAttribute($var)
    {
        $this->attribute=$var;
    }

}

?>