<?php

namespace testassignment;

use testassignment\Book;
use testassignment\DVD;
use testassignment\Furniture;

/*
    This class contains the mapping of the classes and validators to the categories,
    and stores the attributes that are required in the front end for the displaying of inputs 
*/

class Category
{
    private static $categories = null;
    private static $classCategories = null;

    public static function getCategories()
    {
        if(self::$categories===null){
            self::$categories = array(
                array("category"=>Book::$category,"attrName"=>Book::$attrName,"mUnits"=>Book::$mUnits),
                array("category"=>DVD::$category,"attrName"=>DVD::$attrName,"mUnits"=>DVD::$mUnits),
                array("category"=>Furniture::$category,"attrName"=>Furniture::$attrName));
        }
        return self::$categories;
    }

    public static function getClassCategories()
    {
        if(self::$classCategories===null){
            self::$classCategories = array(
                Book::$category => array("className" => "Book", "validatorName" => "BookValidator","namespace" => "testassignment"),
                DVD::$category => array("className" => "DVD", "validatorName" => "DVDValidator","namespace" => "testassignment"),
                Furniture::$category => array("className" => "Furniture", "validatorName" => "FurnitureValidator","namespace" => "testassignment"));
        }
        return self::$classCategories;
    }
}

?>