<?php

namespace testassignment;

/*
    This interface contains all the methods a database connection must implement
*/

interface DatabaseConnection
{
    public function getConnection();

    public function executeInsertStatement($table,$var);

    public function executeDeleteStatement($table,$var);

    public function executeGetAllRows($table);

    public function executeGetOne($table,$id,$field);
}

/*
    This class implements the database connection logic
    using PDO
*/

class PDODatabaseConnection implements DatabaseConnection
{
    private $conn;

    public function __construct($dbname,$dbhost,$dbuser,$dbpassword,$dbport)
    {
        try{
            $this->conn = new \PDO(
                "mysql:host=$dbhost;port=$dbport;charset=utf8mb4;dbname=$dbname",
                $dbuser,
                $dbpassword
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
        This helper function creates a string of fields or question marks from the supplied array
        The built string is used in the SQL queries
    */

    private function queryStringBuilder(array $fields,$qmarks=false)
    {
        $nr=count($fields);
        $result="";

        if($qmarks){
            for($i=0;$i<$nr;$i++){
                $result .= '?';

                if($i<$nr-1)
                    $result .=',';
            }
        }else{
            $i=0;
            while ($field = current($fields)) {
                $result .= key($fields);
                next($fields);
                if($i<$nr-1)
                    $result .=',';
                $i++;
            }
        }
        return $result;
    }

    /*
        This function implements the insert logic
    */
    
    public function executeInsertStatement($table, $var)
    {
        $qmarks = $this->queryStringBuilder($var,true);
        $cols = $this->queryStringBuilder($var,false);

        $variables = array_values($var);

        $sql = "INSERT INTO $table ($cols) VALUES ($qmarks)";

        $statement = $this->conn-> prepare($sql);

        return $statement -> execute($variables);      
    }

    /*
        This function implements the mass deletion logic
    */

    public function executeDeleteStatement($table, $var)
    {
        $qmarks = $this->queryStringBuilder($var,true);
        $variables = array_values($var);

        $sql = "DELETE FROM $table WHERE id IN ($qmarks)";

        $statement = $this->conn-> prepare($sql);

        return $statement -> execute($variables);      
    }

    /*
        This function implements getting all the records from the database
    */

    public function executeGetAllRows($table)
    {
        $sql = "SELECT * FROM $table";

        $statement = $this->conn->query($sql);

        return $statement->fetchAll($this->conn::FETCH_ASSOC);
    }

    /*
        This function implements getting one record from the database, based on the field name
    */

    public function executeGetOne($table, $value, $field)
    {
        $sql = "SELECT * FROM $table WHERE $field = ?";

        $statement = $this->conn-> prepare($sql);

        $statement -> execute([$value]);

        return $statement;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

?>