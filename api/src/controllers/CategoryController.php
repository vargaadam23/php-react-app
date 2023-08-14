<?php

namespace testassignment;

require_once(__DIR__.'/../models/Category.php');
require_once(__DIR__."/../utils/HttpResponseMessage.php");

use testassignment\HttpNotImplementedResponse;
use testassignment\HttpOkResponse;

use testassignment\Category;
use testassignment\Controller;

class CategoryController extends Controller{

    //Override
   
    public function handleGet()
    {
        $response = new HttpOkResponse(Category::getCategories());
    }

    public function handleDelete()
    {
        $response = new HttpNotImplementedResponse(["status"=>"failed","message"=>"Cant perform delete operation"]);
    }

    public function handlePost()
    {
        $response = new HttpNotImplementedResponse(["status"=>"failed","message"=>"Cant perform post operation"]);
    }
}

?>