<?php

require_once(__DIR__."/src/models/Database.php");
require_once(__DIR__."/src/models/Product.php");
require_once(__DIR__."/src/controllers/RequestDispatcher.php");
require_once(__DIR__."/src/config/dbvar.php");

use testassignment\PDODatabaseConnection;
use testassignment\RequestDispatcher;

/*
    This file is included in the index files situated in the endpoint folders
    and is used to initialize the database connection and the request dispatcher 
*/

$dbConnection = new PDODatabaseConnection(DB_NAME,DB_HOST,DB_USER,DB_PWD,DB_PORT);

$reqDispatcher = new RequestDispatcher($dbConnection);

?>