<?php

namespace testassignment;

require_once(__DIR__.'/../config/endpoints.php');
require_once(__DIR__.'/../controllers/Controller.php');
require_once(__DIR__.'/../controllers/ProductController.php');
require_once(__DIR__.'/CategoryController.php');
require_once(__DIR__.'/../utils/HttpResponseMessage.php');

use testassignment\HttpNotImplementedResponse;
use testassignment\HttpNotFoundResponse;

use testassignment\ProductController;
use testassignment\CategoryController;

/*
    This class is responsible for choosing the appropiate controller and handling the incoming request
*/

class RequestDispatcher
{
    private $base;
    private $controller;
    private $dbconn;
    private $requestMethod;

    public function __construct(DatabaseConnection $dbconn)
    {
        $this->dbconn=$dbconn;
    }

    /*
        This function is responsible for choosing the controller that will handle the request, 
        based on the endpoint
    */

    private function assignController()
    {
        switch($this->base){
            case BASE_ENDPOINTS[0]:// if endpoint is products
                $this->controller = new ProductController($this->dbconn);
                break;
            case BASE_ENDPOINTS[1]:// if endpoint is categories
                $this->controller = new CategoryController();
                break;
            default:
                $response = new HttpNotFoundResponse(["status" => "failed", "message" => "Endpoint not found"]);
                break;
        }     
    }
    private function setRequestMethod()
    {
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
    }

    /*
        This function is responsible for handling the incoming request
    */

    public function dispatchRequest()
    {
        $url = explode( '/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->base = $url[1];

        $this->assignController();
        $this->setRequestMethod();

        switch($this->requestMethod){
            case 'GET':
                $this->controller->handleGet();
                break;
            case 'POST':
                $this->controller->handlePost();
                break;
            case 'DELETE':
                $this->controller->handleDelete();
                break;
            default:
                
                break;
        }
       
    }
}

?>