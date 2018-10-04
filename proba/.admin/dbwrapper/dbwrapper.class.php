<?php
/**
 * Database wrapper class
 *
 * This file contains the MySQL database wrapper class.
 *
 * @package  ADirectRide
 * @access   public
 * @author   Vagharshak Tozalakyan <vagh@tozalakyan.com>
 */


/**
 * No debugging
 */
define('DBW_NO_DEBUG', 0);

/**
 * Generate debug warnings
 */
define('DBW_WARNINGS', 1);

/**
 * Generate debug errors
 */
define('DBW_ERRORS',   2);


/**
 * Fetch as associative array
 */
define('DBW_FETCH_ASSOC',   0);

/**
 * Fetch as ordered array
 */
define('DBW_FETCH_ORDERED', 1);

/**
 * Fetch as object
 */
define('DBW_FETCH_OBJECT',  2);


/**
 * MySQL database wrapper class
 *
 * This class is a simple object-oriented wrapper of PHP's MySQL functions.
 *
 * @package  ADirectRide
 * @version  1.0
 * @access   public
 * @author   Vagharshak Tozalakyan <vagh@tozalakyan.com>
 */
class DBWrapper
{
    /**
     * Total number of executed queries
     *
     * @var     int
     * @access  public
     */
    var $numQueries = 0;

    /**
     * Debugging mode
     *
     * DBW_NO_DEBUG - not in debugging mode (default);
     * DBW_WARNINGS - generate debug warnings;
     * DBW_ERRORS - generate debug errors.
     *
     * @var     int
     * @access  public
     */
    var $debugMode = DBW_NO_DEBUG;

    /**
     * Database connection ID
     *
     * @var     mixed
     * @access  private
     */
    var $_linkID = false;

    /**
     * SQL query result ID
     *
     * @var     mixed
     * @access  private
     */
    var $_queryResult = false;


    /**
     * Connect the database server and select a database on it
     *
     * @access  public
     * @param   string   $server       Database hostname.
     * @param   string   $username     Database connection username.
     * @param   string   $password     Database connection password.
     * @param   string   $database     Database name.
     * @param   bool     $persistency  Create a persistant connection?
     * @return  resource               A Valid connection ID or false.
     */
    function connect($server, $username, $password, $database, $persistency = false)
    {
        if (!$persistency) {
            $this->_linkID = @mysql_connect($server, $username, $password);
        } else {
            $this->_linkID = @mysql_pconnect($server, $username, $password);
        }
        if (!$this->_linkID) {
            $this->_debug();
            return false;
        }
        if (!empty($database)) {
            if (!@mysql_select_db($database, $this->_linkID)) {
                $this->_debug();
                return false;
            }
        }
        return $this->_linkID;
    }


    /**
     * Close database connection
     *
     * @access public
     * @return bool
     */
    function disconnect()
    {
        $result = @mysql_close($this->_linkID);
        if (!$result) {
            $this->_debug('Unable to disconnect');
            return false;
        }
        return $result;
    }


    /**
     * Escape unescaped string to use in SQL statement
     *
     * @access  public
     * @param   string  $str  Unescaped string.
     * @return  string        Escaped string.
     */
    function escape($str)
    {
        return mysql_escape_string($str);
    }


    /**
     * Execute SQL statement
     *
     * @access  public
     * @param   string  $sql     SQL statement.
     * @return  bool
     */
    function query($sql)
    {
        $this->_queryResult = @mysql_query($sql, $this->_linkID);
        if (!$this->_queryResult) {
            $this->_debug();
            return false;
        }
        $this->numQueries++;
        return true;
    }


    /**
     * Get number of affected rows in previous operation
     *
     * @access  public
     * @return  int     Number of affected rows, -1 if the last query failed
     *                  or false if the function failed.
     */
    function affectedRows()
    {
        $affectedRows = @mysql_affected_rows($this->_linkID);
        if (NULL === $affectedRows) {
            $this->_debug('Unable to get the number of affected rows');
            return false;
        }
        return $affectedRows;
    }


    /**
     * Get number of rows in result
     *
     * @access  public
     * @return  int     Number of rows in result or false if the function failed.
     */
    function numRows()
    {
        $numRows = @mysql_num_rows($this->_queryResult);
        if (NULL === $numRows) {
            $this->_debug('Unable to get the number of rows in result');
            return false;
        }
        return $numRows;
    }


    /**
     * Get number of fields in result
     *
     * @access  public
     * @return  int     Number of fields in result or false if the function failed.
     */
    function numFields()
    {
        $numFields = @mysql_num_fields($this->_queryResult);
        if (NULL === $numFields) {
            $this->_debug('Unable to get the number of fields in result');
            return false;
        }
        return $numFields;
    }


    /**
     * Get the name of the specified field in a result
     *
     * @access  public
     * @param   string  $index  Field_index starts at 0.
     * @return  string          Name of the specified field or false if the
     *                          function failed.
     */
    function fieldName($index)
    {
        $fieldName = @mysql_field_name($this->_queryResult, $index);
        if (!$fieldName) {
            $this->_debug('Unable to get the name of the specified field');
            return false;
        }
        return $fieldName;
    }


    /**
     * Get the type of the specified field in a result
     *
     * @access  public
     * @param   string  $index  Field_index starts at 0.
     * @return  string          Type of the specified field or false if the
     *                          function failed.
     */
    function fieldType($index)
    {
        $fieldType = @mysql_field_type($this->_queryResult, $index);
        if (!$fieldType) {
            $this->_debug('Unable to get the type of the specified field');
            return false;
        }
        return $fieldType;
    }


    /**
     * Fetch a result row
     *
     * @access  public
     * @param   int     $fetchType  DBW_FETCH_ASSOC - fetch an associative array,
     *                              DBW_FETCH_ORDERED - fetch an enumerated array,
     *                              DBW_FETCH_OBJECT - fetch object.
     * @return  mixed               Fetched array or object.
     */
    function fetchRow($fetchType = DBW_FETCH_ASSOC)
    {
        $fetchedRow = array();
        if ($fetchType == DBW_FETCH_ASSOC) {
            $fetchedRow = @mysql_fetch_assoc($this->_queryResult);
        } elseif ($fetchType == DBW_FETCH_ORDERED) {
            $fetchedRow = @mysql_fetch_row($this->_queryResult);
        } else {
            $fetchedRow = @mysql_fetch_object($this->_queryResult);
        }
        return $fetchedRow;
    }


    /**
     * Fetch a set of result rows
     *
     * @access  public
     * @param   int     $fetchType  DBW_FETCH_ASSOC - fetch rows as associative arrays,
     *                              DBW_FETCH_ORDERED - fetch rows as enumerated arrays,
     *                              DBW_FETCH_OBJECT - fetch rows as objects
     * @return  mixed               Enumerated array of fetched row arrays or objects
     */
    function fetchRows($fetchType = DBW_FETCH_ASSOC)
    {
        $fetchedRows = array();
        while ($fetchedRow = $this->fetchRow($fetchType)) {
            $fetchedRows[] = $fetchedRow;
        }
        return $fetchedRows;
    }


    /**
     * Get result data
     *
     * @access  public
     * @param   int    $row    Row index.
     * @param   mixed  $field  Field name or index.
     * @return  mixed          Result data or Enumerated array of fetched row
     *                         arrays or objects.
     */
    function fetchResult($row, $field)
    {
        $fetchedValue = @mysql_result($this->_queryResult, $row, $field);
        if (false === $fetchedValue) {
            $this->_debug('Unable to fetch the field');
        }
        return $fetchedValue;
    }

    /**
     * Move internal result pointer
     *
     * @access  public
     * @param   int     $row  Row_number starts at 0.
     * @return  bool          False if failed to move the pointer.
     */
    function seekRow($row)
    {
        $result = @mysql_data_seek($this->_queryResult, $row);
        if (!$result) {
            $this->_debug('Unable to move internal pointer');
        }
        return $result;
    }


    /**
     * Get the ID generated from the previous INSERT operation
     *
     * @access  public
     * @return  int     0 if the previous query does not generate an AUTO_INCREMENT value.
     */
    function insertID()
    {
        return @mysql_insert_id($this->_linkID);
    }


    /**
     * Free result memory
     *
     * @access  public
     * @return  bool    False if the function failed.
     */
    function freeResult()
    {
        $result = @mysql_free_result($this->_queryResult);
        if (!$result) {
            $this->_debug('Unable to free result');
        }
        return $result;
    }


    /**
     * Returns the text and code of the error message from previous operation
     *
     * @access  public
     * @return  array   [0]=>string $errorMsg, [1]=>int $errorCode.
     */
    function getError()
    {
        $errorMsg = @mysql_error($this->_linkID);
        $errorCode = @mysql_errno($this->_linkID);
        return array($errorMsg, $errorCode);
    }


    /**
     * Returns the text and code of the error message from previous operation
     *
     * @access  private
     * @param   string   $errMsg
     */
    function _debug($errMsg = '')
    {
        if ($this->debugMode == DBW_NO_DEBUG) {
            return true;
        }
        $errType = ($this->debugMode == DBW_WARNINGS ? E_USER_WARNING : E_USER_ERROR);
        if (empty($errMsg)) {
            $errMsg = ($this->_linkID ? @mysql_error($this->_linkID) : @mysql_error());
        }
        trigger_error($errMsg, $errType);
    }
}
?>