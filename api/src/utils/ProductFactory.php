<?php

namespace testassignment;

require_once(__DIR__ . "/../models/categories/Book.php");
require_once(__DIR__ . "/../models/categories/DVD.php");
require_once(__DIR__ . "/../models/categories/Furniture.php");
require_once(__DIR__ . "/./Validator.php");

/*
    This class has the role of a factory, it creates the desired product and its validator for the controller
*/

class ProductFactory
{
    private $product;
    private $validator;

    public function __construct($input, $dbconn)
    {
        $classCategories = Category::getClassCategories();

        if(isset($classCategories[$input["category"]])){
            $namespace = $classCategories[$input["category"]]["namespace"];
            $className = $namespace.'\\'.$classCategories[$input["category"]]["className"];
            $validatorName = $namespace.'\\'.$classCategories[$input["category"]]["validatorName"];

            $this->product = new $className($dbconn);
            $this->validator = new $validatorName($input, $dbconn);
        }
    }
    public function getProduct()
    {
        return $this->product;
    }
    public function getValidator()
    {
        return $this->validator;
    }
}
