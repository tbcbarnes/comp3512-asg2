<?php
/**
 * Handles all SQL queries and transactions. Data Access Layer
 * 
 * Static instance variable holds the PDO Object. Constructor builds
 * the PDO Object from the db_constants file. Modify the constants
 * if database credentials change.
 */
 
class DataAccess {
    private $pdo;
    
    public function __construct() {
        require 'db_constants.inc.php';
        $this->pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    /**
     * Execute SQL Queries expecting multiple records returned. For retrieving
     * a single record, use getByID().
     * @param String $cols - specific columns or *
     * @param String $table - specify table
     * @param String $params - specify WHERE,ORDER BY, etc. or "" if no params
     * @param Array $vars - pass in variables to bind to prepared statements, or
     * "" if no variables; must be passed as array in order of ? in SQL statement
     * @return Non-associative array of results
     */
    public function exSelect($cols,$table,$params,$vars) {
        $sql="SELECT $cols FROM $table";
        if($params) {
            $sql.=" $params";
        }
        $result = $this->pdo->prepare($sql.";");
        if($vars) {
            $result->execute($vars);
        }
        else {
            $result->execute();
        }
        $records = [];
        while($row = $result->fetch()) {
            array_push($records,$row);
        }
        return $records;
    }
    
    /**
     * Execute a query expecting a single record back by passing a unique
     * identifier.
     * @param String $table - specify a table name
     * @param String $idColName - specify which column contains the unique value
     * @param String $uniqueID - the identifier of the unique record
     * @return Associate Array containing matching record or null if no match.
     */
    public function getByID($table,$idColName,$uniqueID) {
        $result = $this->exSelect("*",$table,"WHERE ".$idColName."=?",array($uniqueID));
        $record = $result[0]; //takes only first record
        return $record;
    }
    
    public function exInsert($table,$cols,$vals) {
        # insertion commands here
    }
    
    public function comChanges() {
        # commit changes here
    }

}