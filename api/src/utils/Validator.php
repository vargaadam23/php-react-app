<?php

namespace testassignment;

interface TAInputValidator{
   public function validateInput();
}

abstract class ProductValidator implements TAInputValidator
{
    protected $input;
    protected $dbconn;
    protected $validatedInput;
    protected $validationStatus;

    public function __construct($input, DatabaseConnection $dbconn)
    {
        $this->input["sku"]="";
        $this->input["name"]="";
        $this->input["price"]="";
        $this->input["attribute"]="";
        
        $this->input = array_merge($this->input,$input);
        $this ->dbconn=$dbconn;
    }

    public function getValidatedInput()
    {
        return $this->validatedInput;
    }

    public function getValidationStatus()
    {
        return $this->validationStatus;
    }

    public function validateInput()
    {
        $validation = array();
        $error = false;
        
        //Validation of sku

        $auxiliar = $this->validateTextField($this->input["sku"],["maxsize"=>50,"minsize"=>2,"unique"=>true,"fieldname"=>"sku"]);
        if(!empty($auxiliar)){
            $validation["sku"]=$auxiliar;
            $error = true;
        }else{
            $this->validatedInput["sku"] = $this->input["sku"];
        }

         //Validation of name

        $auxiliar = $this->validateTextField($this->input["name"]);
        if(!empty($auxiliar)){
            $validation["name"]=$auxiliar;
            $error = true;
        }else{
            $this->validatedInput["name"] = $this->input["name"];
        }

         //Validation of price

        $auxiliar = $this->validateNumericField($this->input["price"]);
        if(!empty($auxiliar)){
            $validation["price"]=$auxiliar;
            $error = true;
        }else{
            $this->validatedInput["price"] = $this->input["price"];
        }

         //Validation of attribute, the validateAttribute method will be overriden by the children of this class

        $auxiliar = $this->validateAttribute();
        if(!empty($auxiliar)){
            $validation["attribute"]=$auxiliar;
            $error = true;
        }else{
            $this->validatedInput["attribute"] = $this->input["attribute"];
        }

        //Checking if there were any validation errors and setting the validation response array

        if($error){
            $validation["status"]="invalid";
            $this->validationStatus = $validation;
        }else{
            $this->validationStatus = ["status"=>"valid"];
        }
    }

    // Abstract function to be implemented by the product type validators

    abstract protected function validateAttribute();

    // Validation of a simple text field

    protected function validateTextField($field,$options = ["maxsize"=>50,"minsize"=>1,"unique"=>false]){
        $validation = array();
        if($options["unique"]&&isset($options["fieldname"])){
            if($this->validateUnique($options["fieldname"],$field)){
                $validation["unique"]="$field already exists";
            }
        }
        if($field===""){
            $validation["notset"]="Field not set";
        }
       if(strlen($field)>$options["maxsize"]){
        $validation["maxsize"]="Size can't be bigger than ".$options["maxsize"]." characters";
       }
       if(strlen($field)<$options["minsize"]){
        $validation["minsize"]="Size can't be smaller than ".$options["minsize"]." characters";
       }
       return $validation;
    }

    // Validation of a simple numeric field

    protected function validateNumericField($field,$options = ["maxsize"=>10,"minsize"=>1, "unique"=>false]){
        $validation = array();
        $validation = $this->validateTextField($field,$options);
        if(!is_numeric($field)){
        $validation["numeric"]="Field must be numeric";
       }
       return $validation;
    }
    
    // Validation of uniqueness, checks database of the 

    protected function validateUnique($dbcol,$field){
        $unique = $this->dbconn->executeGetOne(Product::TABLE,$field,$dbcol);
        return $unique -> fetchColumn();
    }
}

class DVDValidator extends ProductValidator{
    //Override
    public function __construct($input, DatabaseConnection $dbconn)
    {
        $this->input["size"]="";
        parent::__construct($input,$dbconn);
    }

    protected function validateAttribute(){
        $this->input["attribute"] = $this->input["size"];
        return $this->validateNumericField($this->input["size"],["maxsize"=>10,"minsize"=>1,"unique" => false]);
    }
}
class BookValidator extends ProductValidator{
    //Override
   
    public function __construct($input, DatabaseConnection $dbconn)
    {
        $this->input["weight"]="";
        parent::__construct($input,$dbconn);
    }

    protected function validateAttribute(){
        $this->input["attribute"] = $this->input["weight"];
        return $this->validateNumericField($this->input["weight"],["maxsize"=>10,"minsize"=>1,"unique" => false]);
    }
}
class FurnitureValidator extends ProductValidator{
    //Override
    
    public function __construct($input, DatabaseConnection $dbconn)
    {
        $this->input["length"]="";
        $this->input["width"]="";
        $this->input["height"]="";
        parent::__construct($input,$dbconn);
    }
    protected function validateAttribute(){
        $validation = array();
        
        $length = $this->validateNumericField($this->input["length"],["maxsize"=>10,"minsize"=>1,"unique" => false]);
        $width = $this->validateNumericField($this->input["width"],["maxsize"=>10,"minsize"=>1,"unique" => false]);
        $height = $this->validateNumericField($this->input["height"],["maxsize"=>10,"minsize"=>1,"unique" => false]);
        $this->input["attribute"] = $this->input["length"].'x'.$this->input["width"].'x'.$this->input["height"];
        if(!empty($length)){
            $validation["length"]= $length;
        }
        if(!empty($width)){
            $validation["width"]= $width;
        }
        if(!empty($height)){
            $validation["height"]= $height;
        }
        return $validation;
    }
}
