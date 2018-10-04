<?php
/**
 * This file contains the Database class.
 * 
 * @author Gonzalo Chumillas <gonzalo@soloproyectos.com>
 * @package database
 */

require_once dirname(__DIR__) . "/database/db-query.php";
require_once dirname(__DIR__) . "/database/exceptions/db-exception.php";

/**
 * class Database
 * 
 * Connects to a dabase.
 * 
 * @package database
 */
class Database {
    private $conn;
    
    /**
     * @param string $database = NULL
     * @param string $username = NULL
     * @param string $password = NULL
     * @param string $server = 'localhost'
     */
    public function __construct($database = NULL, $username = NULL, $password = NULL, $server = "localhost") {
        if (strlen($database) > 0) {
            $this->connect($server, $username, $password);
            $this->select($database);
        }
    }
    
    /**
     * Connects to a database engine.
     * @param string $server
     * @param string $username = NULL
     * @param string $password = NULL
     */
    public function connect($server, $username = NULL, $password = NULL) {
        $this->conn = @mysqli_connect($server, $username, $password);
        
        if ($this->conn === FALSE) {
            throw new DBException("Failed to connect to $server");
        }
    }
    
    /**
     * Selects a database.
     * @param string $database
     */
    public function select($database) {
        $result = mysqli_select_db($this->conn, $database);
        if ($result === FALSE) {
            throw new DBException("Failed to connect to the database $database");
        }
    }
    
    /**
     * Magic '_invoke' function.
     * Executes indirectly the 'query' method when trying to call an object as a function.
     * 
     * Example:
     * <code>
     * // executes a select statement and prints the result
     * $db = new Database($database_name, $username, $password);
     * // calls the 'query' method indirectly
     * $rows = $db("select id, name from my_table");
     * foreach ($rows as $row) {
     *      echo $row->id . ": " . $row->name . "\n";
     * }
     * go\DB\Storage::getInstance()->get()->close();
     * </code>
     * 
     * @param string $sql
     * @param mixed $p0 not required
     * @param mixed $p1 not required
     * @return DBQuery|int
     */
    public function __invoke($sql, $p0 = NULL, $p1 = NULL) {
        // call a function with a variable number of arguments
        return call_user_func_array(array($this, "query"), func_get_args());
    }
    
    /**
     * Executes an SQL statement.
     * 
     * If the statement is a command returns the number of affected rows.
     * Otherwise returns a DBQuery object.
     * 
     * Example:
     * <code>
     * // deletes all 'Andrew' rows and prints the number of the deleted items
     * $affected_rows = go\DB\query("delete from my_table where name = 'Andrew'");
     * echo "Number of rows deleted: " . $affected_rows;
     * 
     * // selects rows from a table and prints the result
     * $rows = $db("select id, name from my_table");
     * foreach ($rows as $row) {
     *      echo $row->id . ": " . $row->name . "\n";
     * }
     * </code>
     * 
     * @param string $sql
     * @param array $args = array()
     * @return DBQuery|int
     */
    public function query($sql, $args = array()) {
        $ret = NULL;
        // call an instace with a variable number of arguments
        $class = new ReflectionClass("DBQuery");
        $q = $class->newInstanceArgs(array_merge(array($this), func_get_args()));
        if ($q->isCommand()) {
            $ret = count($q);
        } else {
            $ret = $q;
        }
        return $ret;
    }
    
    /**
     * Executes an sql sentence.
     * @param string $sql
     * @return boolean|mysqli_result
     */
    public function execute($sql) {
        $ret = mysqli_query($this->conn, $sql);
        if ($ret === FALSE) {
            $errno = mysqli_errno($this->conn);
            $error = mysqli_error($this->conn);
            throw new DBException("#$errno $error");
        }
        return $ret;
    }
    
    /**
     * Gets the id generated in the last query.
     * 
     * @param string
     * @return string
     */
    public function getInsertId() {
        return mysqli_insert_id($this->conn);
    }
    
    /**
     * Escapes an identifier and adds quotation marks.
     * 
     * This function prepares an identifier to be used in a SQL statement.
     * This function protects the statements against SQL injections.
     * 
     * Example:
     * <code>
     * // the variable $tablename may contain an unpredictable value
     * $sql = "select * from " . $db->quotename($tablename);
     * $rows = $db($sql);
     * </code>
     * 
     * @param string $name
     * @return string
     */
    public static function quotename($name) {
        return "`" . preg_replace("/[^\w]/", NULL, $name) . "`";
    }
    
    /**
     * Escapes a value and adds quotation marks.
     * 
     * This function prepares a value to be used in a SQL statement.
     * This function protects the statements against SQL injections.
     * 
     * Example:
     * <code>
     * // the variable $id may contain an unpredictable value
     * $sql = "select * from my_table where id = " . $db->quote($id);
     * $rows = $db($sql);
     * </code>
     * 
     * @param string $value
     * @return string
     */
    public function quote($value) {
        if ($value === NULL || is_string($value) && strlen($value) == 0) {
            $ret = 'NULL';
        } else {
            $ret = '"' . mysqli_real_escape_string($this->conn, $value) . '"';
        }
        return $ret;
    }
    
    /**
     * Gets current connection resource.
     * @return resource
     */
    public function getConnection() {
        return $this->conn;
    }
    
    /**
     * Closes the current connection.
     */
    public function close() {
        if (is_object($this->conn)) {
            mysqli_close($this->conn);
            $this->conn = NULL;
        }
    }
}
