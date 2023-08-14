<?php

namespace testassignment;

require_once(__DIR__."/Controller.php");
require_once(__DIR__."/../utils/ProductFactory.php");
require_once(__DIR__."/../utils/HttpResponseMessage.php");

use testassignment\HttpOkResponse;
use testassignment\HttpCreatedResponse;
use testassignment\HttpUnprocessableResponse;

use testassignment\ProductFactory;

use testassignment\Controller;

class ProductController extends Controller{
    private $dbconn;
    public function __construct(DatabaseConnection $dbConn)
    {
        $this->dbconn=$dbConn;
    }

    //This function sends a response with all the products

    private function getAll()
    {
        $rows = Product::getAll($this->dbconn);

        $reponse = new HttpOkResponse($rows);
    }

    //This function checks the validity of the category

    private function categoryCheck($category)
    {
        $categories = Category::getCategories();

        $validCategory = false;
        if(isset($category)){
            foreach($categories as $cat){
                if(in_array($category,$cat)){
                    $validCategory = true;
                }
            }
        }
        return $validCategory;    
    }

    //This function validates the request data and saves a new product if the data is valid

    private function insert()
    {
        $input = (array) json_decode(file_get_contents('php://input'), true);

        $validCategory = $this->categoryCheck($input["category"]); 

        if($validCategory){

            /*
                If the supplied category is valid, 
                the product factory will create an instance of the selected product type and its validator
            */

            $factory = new ProductFactory($input,$this->dbconn);
            $product = $factory->getProduct();
            $validator = $factory->getValidator();
    
            $validator -> validateInput();
            $validationMessage = $validator -> getValidationStatus();

            /*
                If the validation failed, e.g. the status is invalid,
                we send a 422 response with the validation data
            */

            if($validationMessage["status"]==="invalid"){
                $response = new HttpUnprocessableResponse($validationMessage);
            }else{

                /*
                    If the validation is successful, e.g. the status is valid,
                    we create a new product by setting its parameters to the validated data and we send a 201 response
                */

                if($validationMessage["status"]==="valid"){
                    
                    $validatedInput = $validator->getValidatedInput();
    
                    $product->setSku($validatedInput["sku"]);
                    $product->setName($validatedInput["name"]);
                    $product->setPrice($validatedInput["price"]);
                    $product->setAttribute($validatedInput["attribute"]);
    
                    $product->insert();
                    $response = new HttpCreatedResponse($validationMessage);
                }
            }
        }else{
            $response = new HttpUnprocessableResponse(["status"=>"invalid","category"=>"Category not found"]);
        }
        
    }

    /*
        This function validates the request data and deletes all the products with id's in the request data
    */

    private function delete()
    {
        $input = (array) json_decode(file_get_contents('php://input'), true);
        $error = false;
        foreach($input as $id){
            if(!is_numeric($id)){
                $error = true;
            }
        }
        if($error){
            $response = new HttpUnprocessableResponse(["status"=>"failed","message"=>"Non number encountered"]);
        }else{
            Product::massDelete($this->dbconn,$input);
            $response = new HttpOKResponse(["status"=>"success","message"=>"Deleted"]);
        }
    }

    //Override

    public function handleGet()
    {
        
        $this->getAll();
    }
    public function handlePost()
    {
        $this->insert();
    }
    public function handleDelete()
    {
        $this->delete();
    }
}

?>
