<?php
/**
 * Handles all SQL queries and transactions.
 * 
 * Static instance variable holds the PDO Object. Constructor builds
 * the PDO Object from the db_constants file. Modify the constants
 * if database credentials change.
 */
 
class db_functions {
    private static $pdo;
    
    public function __construct() {
        require 'db_constants.inc.php';
        self::$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function exSelect($cols,$table,$params,$vars) {
        $sql="SELECT $cols FROM $table";
        if($params) {
            $sql.=" $params";
        }
        $result = self::$pdo->prepare($sql.";");
        if($vars) {
            $result->execute($vars);
        }
        else {
            $result->execute();
        }
        return $result;
    }
    
    public function exInsert($table,$cols,$vals) {
        # insertion commands here
    }
    
    public function comChanges() {
        # commit changes here
    }
}