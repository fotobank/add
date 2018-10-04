<?php
/**
 * This file contains the DBQuery class.
 * 
 * @author Gonzalo Chumillas <gonzalo@soloproyectos.com>
 * @package database
 */

require_once dirname(__DIR__) . "/library/util.php";
require_once dirname(__DIR__) . "/database/database.php";
require_once dirname(__DIR__) . "/database/db-column.php";
require_once dirname(__DIR__) . "/database/db-table.php";
require_once dirname(__DIR__) . "/database/db-parser.php";
require_once dirname(__DIR__) . "/database/exceptions/db-exception.php";
require_once dirname(__DIR__) . "/database/exceptions/ambiguous-column-db-exception.php";
require_once dirname(__DIR__) . "/database/exceptions/column-not-found-db-exception.php";
require_once dirname(__DIR__) . "/database/exceptions/query-not-editable-db-exception.php";

/**
 * class DBQuery
 * 
 * This class lets you to work with SQL statements in a natural way.
 * 
 * @package database
 */
class DBQuery implements Countable, Iterator, ArrayAccess {   
    /**
     * Database connection.
     * @var Database
     */
    private $db;
    
    /**
     * Tables.
     * @var array[DBTable]
     */
    private $tables;
    
    /**
     * Columns.
     * @var array[DBColumn]
     */
    private $columns;
    
    /**
     * Result set.
     * @var array[string]
     */
    private $rows;
    
    /**
     * Main table.
     * @var DBTable
     */
    private $main_table;
    
    /**
     * Is the mysql sentence a command?
     * @var boolean
     */
    private $is_command;
    
    /**
     * Is the mysql sentence editable?
     * @var boolean
     */
    private $is_editable;
    
    /**
     * Gets the number of affected rows.
     * @var int
     */
    private $affected_rows;
    
    /**
     * SQL Sentence.
     * @var string
     */
    private $sql;
    
    /**
     * Debug mode.
     * @var boolean
     */
    private $debug_mode = FALSE;
    
    /**
     * Creates an instance of DBQuery.
     * @param Database $db
     * @param string $sql
     * @param array $args = array()
     */
    public function __construct($db, $sql, $args = array()) {
        $this->db = $db;
        $this->tables = array();
        $this->columns = array();
        $this->rows = array();
        $this->is_command = FALSE;
        $this->is_editable = FALSE;
        $this->affected_rows = 0;
        
        if ($db instanceof DBQuery && is_array($sql)) {
            // internal use only
            $query = $db;
            $rows = $sql;
            $this->rows = $rows;
            $this->db = $query->db;
            $this->tables = $query->tables;
            $this->columns = $query->columns;
            $this->is_command = $query->is_command;
            $this->is_editable = $query->is_editable;
            $this->affected_rows = $query->affected_rows;
        } else {
            $conn = $this->db->getConnection();
            $this->sql = $this->replaceArgs($this->removeComments($sql), $args);
            $result = $this->db->execute($this->sql);
            $this->is_command = !is_object($result);
            
            if (!$this->is_command) {
                $result = mysqli_query($conn, $this->sql);
                $len = mysqli_num_fields($result);
                
                for ($i = 0; $i < $len; $i++) {
                    // gets field info
                    $info = mysqli_fetch_field_direct($result, $i);
                    $table = $info->table;
                    $name = $info->orgname;
                    $alias = $info->name;
                    $flags = $info->flags;
                    $primary_key = (2 & $flags) > 0;
                    
                    // registers a new column
                    $column = $this->registerColumn($table, $name);
                    $column->setPrimaryKey($primary_key);
                    $column->registerAlias($alias);
                    $column->setAccessible(TRUE);
                }
                
                // gets rows
                while ($row = mysqli_fetch_row($result)) {
                    array_push($this->rows, $row);
                }
                
                mysqli_free_result($result);
                
                // is the query editable?
                // TODO: Si la clave primaria es nula, quizás no debería ser editable
                $p = new DBParser($this, $sql);
                try {
                    $this->is_editable = $p->parse();
                } catch(ParserException $e) {
                    $this->is_editable = FALSE;
                }
            } else {
                $this->affected_rows = mysqli_affected_rows($conn);
            }
        }
    }
    
    /**
     * Gets database connection.
     * @return Database
     */
    public function getDatabase() {
        return $this->db;
    }
    
    /**
     * Magic '__get' method.
     * Calls the 'get' method when trying to access to an inaccessible property.
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        return $this->get($name);
    }
    
    /**
     * Magic '__set' method.
     * Calls the 'set' method when trying to set up an inaccessible property.
     * @param string $name
     * @return mixed
     */
    public function __set($name, $value) {
        $this->set($name, $value);
    }
    
    /**
     * Magic '__isset' method
     * Checks whether a column exists.
     * @param string $name
     */
    public function __isset($name) {
        try {
            $column = $this->searchColumn($name);
        } catch (ColumnNotFoundDBException $e) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    /**
     * Magic '__unset' method
     * Unset a column.
     * @param string $name
     */
    public function __unset($name) {
        $column = $this->searchColumn($name);
        $column->setAccessible(FALSE);
    }
    
    /**
     * Gets the value for a specified column name.
     * @param string $name
     * @return mixed
     */
    public function get($name) {
        $column = $this->searchColumn($name);
        return $column->getValue();
    }
    
    /**
     * Sets the value for a specified column name.
     * @param string $name
     * @param mixed $value
     * @throws QueryNotEditableDBException if the column is not editable.
     */
    public function set($name, $value) {
        $column = $this->searchColumn($name);
        
        if (!$this->is_editable) {
            throw new QueryNotEditableDBException();
        }
        
        $column->setValue($value);
    }
    
    /**
     * Gets debug mode status.
     * @return boolean
     */
    public function isDebugMode() {
        return $this->debug_mode;
    }
    
    /**
     * Sets debug mode status.
     * @param boolean $value
     */
    public function setDebugMode($value) {
        $this->debug_mode = $value;
    }
    
    /**
     * Gets accessible columns.
     * @return array[DBColumn]
     */
    public function getColumns() {
        $ret = array();
        
        foreach ($this->columns as $column) {
            if ($column->isAccessible()) {
                array_push($ret, $column);
            }
        }
        
        return $ret;
    }
    
    /**
     * Gets tables.
     * @return array[DBTable]
     */
    public function getTables() {
        return $this->tables;
    }
    
    /**
     * Gets main table.
     * @return DBTable
     */
    public function getMainTable() {
        return $this->main_table;
    }
    
    /**
     * Sets main table.
     * @param DBTable $table
     */
    public function setMainTable($table) {
        $this->main_table = $table;
    }
    
    /**
     * Has column value?
     * @param DBColumn $column
     * @return boolean
     */
    public function hasOriginalValue($column) {
        $ret = FALSE;
        $row = current($this->rows);
        
        if ($row !== FALSE) {
            $index = array_search($column, $this->columns, TRUE);
            $ret = array_key_exists($index, $row);
        }
        
        return $ret;
    }
    
    /**
     * Gets column value.
     * @param DBColumn $column
     * @return string
     */
    public function getOriginalValue($column) {
        $ret = "";
        $row = current($this->rows);
        
        if ($row !== FALSE) {
            $index = array_search($column, $this->columns, TRUE);
            
            if (array_key_exists($index, $row)) {
                $ret = $row[$index];
            }
        }
        
        return $ret;
    }
    
    /**
     * Sets column value.
     * @param DBColumn $column
     * @param string $value
     */
    public function setOriginalValue($column, $value) {
        $index = array_search($column, $this->columns, TRUE);
        $pos = key($this->rows);
        
        if ($pos !== NULL && array_key_exists($index, $this->rows[$pos])) {
            $this->rows[$pos][$index] = $value;
        }
    }
    
    /**
     * Gets an slice from the query.
     * @param integer $offset
     * @param integer $length = NULL
     * @throws DBException if the column is not a result set.
     * @return DBQuery
     */
    public function getSlice($offset, $length = NULL) {
        if ($this->isCommand()) {
            throw new DBException("The query is not a resultset");
        }
        
        $rows = array_slice($this->rows, $offset, $length);
        return new DBQuery($this, $rows);
    }
    
    /**
     * Registers a column.
     * @param string $table
     * @param string $name
     * @throws DBException if the class can not determine the table of the column.
     * @return DBColumn
     */
    public function registerColumn($table, $name) {
        try {
            $ret = $this->searchColumn("`$table`.`$name`", FALSE);
        } catch (ColumnNotFoundDBException $e) {
            $ret = new DBColumn($this, $table, $name);
            array_push($this->columns, $ret);
        }
        
        return $ret;
    }
    
    /**
     * Registers a table.
     * @param string $alias Table alias.
     * @param boolean $move_top Moves = FALSE the table to the top.
     * @return DBTable
     */
    public function registerTable($alias, $move_top = FALSE) {
        $ret = $this->searchTable($alias);
        
        // creates a new table
        if ($ret == NULL) {
            $ret = new DBTable($this, $alias);
            array_push($this->tables, $ret);
        }
        
        // moves table to the beggining
        if ($move_top) {
            $offset = array_search($ret, $this->tables, TRUE);
            $slice = array_splice($this->tables, $offset, 1);
            array_splice($this->tables, 0, 0, $slice);
        }
        
        return $ret;
    }
    
    /**
     * Checks whether the query is a command.
     * @return boolean
     */
    public function isCommand() {
        return $this->is_command;
    }
    
    /**
     * Checks whether the query is editable.
     * @return boolean
     */
    public function isEditable() {
        return $this->is_editable;
    }
    
    /**
     * Deletes the current record.
     * @throws QueryNotEditableDBException if the query is not editable.
     */
    public function delete($recursive = FALSE) {
        if (!$this->is_editable) {
            throw new QueryNotEditableDBException();
        }
        
        if ($recursive) {
            $tables = $this->tables;
        } else {
            $tables = array($this->main_table);
        }
        
        // delete records
        foreach ($tables as $table) {
            $pk = $table->getPrimaryKey();
            if ($pk == NULL) {
                continue;
            }
            
            $table_name = $table->getName();
            $pk_name = $pk->getName();
            $pk_value = $pk->getOriginalValue();
            
            if (!util::isEmpty($pk_value)) {
                $sql =
                    "delete" .
                    " from " . $this->db->quotename($table_name) .
                    " where " . $this->db->quotename($pk_name) . " = " . $this->db->quote($pk_value);
                
                if ($this->debug_mode) {
                    echo "$sql\n";
                }
                
                $this->db->execute($sql);
            }
        }
    }
    
    /**
     * Refreshes the query result set.
     * @throws QueryNotEditableDBException if the query is not editable.
     * @throws DBException if the record were not found.
     */
    public function refresh() {
        if (!$this->is_editable) {
            throw new QueryNotEditableDBException();
        }
        
        // builds the select query
        $pk = $this->main_table->getPrimaryKey();
        $pk_name = $pk->getFullName();  // TODO: qué pasa si la clave primaria es nula?
        $pk_value = $pk->getOriginalValue();
        $t = new Tokenizer($this->sql);
        $condition = "";
        
        if ($t->match("where\s+", $matches, Tokenizer::SEARCH_ANYWHERE)) {
            $condition = "and $pk_name = " . $this->db->quote($pk_value);
        } else {
            $condition = "where $pk_name = " . $this->db->quote($pk_value);
        }
        
        if ($t->match("(group|having|order|limit|union)\s+", $matches, Tokenizer::SEARCH_ANYWHERE|Tokenizer::OFFSET_CAPTURE)) {
            $offset = $matches[0][1];
        } else {
            $offset = strlen($this->sql);
        }
        
        $sql = util::concat("\n", substr($this->sql, 0, $offset), $condition, substr($this->sql, $offset));
        // ..
        
        // gets the row and fills the columns
        if ($this->debug_mode) {
            echo "$sql\n";
        }
        
        $result = $this->db->execute($sql);
        $row = mysqli_fetch_row($result);
        
        if ($row) {
            foreach ($row as $i => $value) {
                $column = $this->columns[$i];
                $column->delValue();
                $column->setOriginalValue($value);
            }
        }
        // ..
    }
    
    /**
     * Saves the changes.
     * @param boolean $insert_mode Inserts a new record on empty result set.
     * @throws QueryNotEditableDBException if the query is not editable.
     * @throws DBException if the primary key of a table is not present and the table must be saved.
     */
    public function save($insert_mode = FALSE) {
        if (!$this->is_editable) {
            throw new QueryNotEditableDBException();
        }
        
        if (!$insert_mode && count($this->rows) == 0) {
            return;
        }
        
        foreach ($this->tables as $table) {
            $table_join_type = $table->getJoinType();
            $table_has_changed = $table->hasChanged();
            $table_pk = $table->getPrimaryKey();
            
            if ($table_pk == NULL && $table_join_type == DBTable::INNER_JOIN) {
                throw new DBException("The primary key of the table `" . $table->getAlias() . "` must be present");
            }
            
            if ($table_pk != null) {
                $pk_value = $table_pk->getOriginalValue();
                
                if ($table_has_changed && !util::isEmpty($pk_value)) {
                    // UPDATE
                    $this->registerDateColumns($table);
                    $sql = $this->getUpdateSentence($table);
                    
                    if ($this->debug_mode) {
                        echo "$sql\n";
                    }
                    
                    $this->db->execute($sql);
                } else
                if ($table_has_changed || util::isEmpty($pk_value) && $table_join_type == DBTable::INNER_JOIN) {
                    // INSERT
                    $this->registerDateColumns($table);
                    $sql = $this->getInsertSentence($table);
                    
                    if ($this->debug_mode) {
                        echo "$sql\n";
                    }
                    
                    $this->db->execute($sql);
                    $table_pk->setValue($this->db->getInsertId());
                }
            }
        }
        
        foreach ($this->columns as $column) {
            if ($column->hasChanged()) {
                $column->setOriginalValue($column->getValue());
            }
            
            $column->delValue();
        }
    }
    
    public function insert() {
        $this->save(TRUE);
    }
    
    /**
     * Removes comments from the sql sentence.
     * @param string $sql
     * @return string
     */
    private function removeComments($sql) {
        return trim(preg_replace(array("!/\*.*?\*/!s", "/--.*\n?/", "/#.*\n?/"), array(NULL, NULL, NULL), $sql));
    }
    
    /**
     * Replaces arguments.
     * @param string $sql
     * @param array $args = array()
     * @throws a DBException if a parameter were not found.
     */
    private function replaceArgs($sql, $args = array()) {
        if (preg_match_all("/%(\w+)/", $sql, $matches)) {
            $params = $matches[1];
            $items = array();
            $values = array();
            
            foreach ($params as $param) {
                $index = is_numeric($param)? $param - 1 : $param;
                $param_name = "%$param";
                
                if (!isset($args[$index])) {
                    throw new DBException("The parameter `$param_name` were not found");
                }
                
                array_push($items, $param_name);
                array_push($values, $this->db->quote($args[$index]));
            }
            
            $sql = str_replace($items, $values, $sql);
        }
        
        return $sql;
    }
    
    /**
     * @param DBTable $table
     */
    private function registerDateColumns($table) {
        $date_columns = array();
        $created_on = $table->getColumnByName("created_on");
        $updated_on = $table->getColumnByName("updated_on");
        
        if ($created_on == NULL) {
            array_push($date_columns, $this->db->quote("created_on"));
        }
        
        if ($updated_on == NULL) {
            array_push($date_columns, $this->db->quote("updated_on"));
        }
        
        if (count($date_columns) > 0) {
            $sql = "show columns from " . $this->db->quotename($table->getName()) . " where Field in (" . implode(", ", $date_columns). ")";
            $rows = $this->db->query($sql);
            
            foreach ($rows as $row) {
                $this->registerColumn($table->getAlias(), $row->Field);
            }
        }
    }
    
    /**
     * Gets current date in MySQL format.
     * @return string
     */
    private function getCurrentDate() {
        return date("Y-m-d H:i:s", time());
    }
    
    /**
     * Gets update sentence.
     * @param DBTable $table
     * @return string
     */
    private function getUpdateSentence($table) {
        $this->getCurrentDate();
        $table_name = $table->getName();
        $table_columns = $table->getColumns();
        $table_pk = $table->getPrimaryKey();
        $pk_name = $table_pk->getName();
        $pk_value = $table_pk->getOriginalValue();
        $column_list = "";

        foreach ($table_columns as $column) {
            $column_name = $column->getName();
            
            if ($column_name == "updated_on" && !$column->hasChanged()) {
                $column->setValue($this->getCurrentDate());
            }
            
            if ($column->hasChanged()) {
                $column_value = $column->getValue();
                $column_list = util::concat(", ", $column_list, $this->db->quotename($column_name) . " = " . $this->db->quote($column_value));
            }
        }
        
        return "update " . $this->db->quotename($table_name) . " set $column_list where " . $this->db->quotename($pk_name) . " = " . $this->db->quote($pk_value);
    }
    
    /**
     * Gets insert sentence.
     * @param DBTable $table
     * @return string
     */
    private function getInsertSentence($table) {
        $now = date("Y-m-d H:i:s", time());
        $table_name = $table->getName();
        $table_columns = $table->getColumns();
        $table_pk = $table->getPrimaryKey();
        $column_list = "";
        $value_list = "";
        
        foreach ($table_columns as $column) {
            $column_name = $column->getName();
            
            if (($column_name == "created_on" || $column_name == "updated_on") && !$column->hasChanged()) {
                $column->setValue($this->getCurrentDate());
            }
            
            if ($column->hasChanged() || $column->hasDefaultValue()) {
                $column_value = $column->hasChanged()? $column->getValue() : $column->getDefaultValue();
                $column_list = util::concat(", ", $column_list, $this->db->quotename($column_name));
                $value_list = util::concat(", ", $value_list, $this->db->quote($column_value));
            }
        }
        
        return "insert into " . $this->db->quotename($table_name) . "($column_list) values($value_list)";
    }
    
    /**
     * Searchs a table by alias.
     * Return NULL if not found.
     * @param string $name
     * @return integer
     */
    private function searchTable($name) {
        $ret = NULL;
        
        foreach ($this->tables as $table) {
            $table_alias = $table->getAlias();
            
            if ($table_alias == $name) {
                $ret = $table;
                break;
            }
        }
        
        return $ret;
    }
    
    /**
     * Searchs a column by name.
     * Throws an exception when not found
     * @param integer|string $index_or_column Index or 'table.name'
     * @param string $accessible_filter = TRUE Searches only the accessible columns
     * @throws AmbiguousColumnDBException if the column name is ambiguous.
     * @throws ColumnNotFoundDBException if the column were not found.
     * @return integer
     */
    private function searchColumn($index_or_column, $accessible_filter = TRUE) {
        $ret = NULL;
        $table = NULL;
        $column = NULL;
        $index = -1;
        
        // splits name into table and column
        if (is_numeric($index_or_column)) {
            $index = $index_or_column;
        } else
        if (preg_match("/^(`?(\w*)`?\s*\.\s*)?`?(\w+)`?$/", $index_or_column, $matches)) {
            $table = trim($matches[2]);
            $column = trim($matches[3]);
        }
        
        // searches column by index
        if (isset($this->columns[$index])) {
            $ret = $this->columns[$index];
        } else
        // searches by alias or name
        if (util::isEmpty($table)) {
            // searches by alias
            foreach ($this->columns as $col) {
                if ((!$accessible_filter || $col->isAccessible()) && $col->isAlias($column)) {
                    if ($ret != NULL) {
                        throw new AmbiguousColumnDBException($column);
                    }
                    
                    $ret = $col;
                }
            }
            
            if ($ret == NULL) {
                // searches by name
                foreach ($this->columns as $col) {
                    $colname = $col->getName();
                    
                    if ((!$accessible_filter || $col->isAccessible()) && $colname == $column) {
                        if ($ret != NULL) {
                            throw new AmbiguousColumnDBException($column);
                        }
                        
                        $ret = $col;
                    }
                }
            }
        } else
        // searches by table and column
        {
            foreach ($this->columns as $col) {
                if ($col->isComputed()) {
                    continue;
                }
                
                $colname = $col->getName();
                $coltable = $col->getTable();
                $colalias = $coltable? $coltable->getAlias() : "";
                
                if ((!$accessible_filter || $col->isAccessible()) && $colalias == $table && $colname == $column) {
                    if ($ret != NULL) {
                        throw new AmbiguousColumnDBException($column);
                    }
                    
                    $ret = $col;
                }
            }
        }
        
        if ($ret == NULL) {
            throw new ColumnNotFoundDBException($column);
        }
        
        return $ret;
    }
    
    /**
     * Resets columns.
     */
    private function reset() {
        foreach ($this->columns as $column) {
            $column->delValue();
        }
    }
    
    /***************************
     * Iterator implementation *
     ***************************/

    /**
     * Gets the current record.
     * @return DBQuery
     */
    public function current() {
        $ret = FALSE;
        $row = current($this->rows);
        
        if ($row !== FALSE) {
            $ret = $this;
        }
        
        return $ret;
    }

    /**
     * Moves forward to next record.
     * @return DBQuery
     */
    public function next() {
        $ret = FALSE;
        $row = next($this->rows);
        
        if ($row !== FALSE) {
            $this->reset();
            $ret = $this;
        }
        
        return $ret;
    }

    /**
     * Gets the internal pointer.
     * @return integer
     */
    public function key() {
        return key($this->rows);
    }

    /**
     * Rewinds the internal pointer.
     */
    public function rewind() {
        reset($this->rows);
    }

    /**
     * Check if current index is valid.
     * @return bool
     */
    public function valid() {
        return key($this->rows) !== NULL;
    }
    
    /******************************
     * ArrayAccess implementation *
     ******************************/

    /**
     * Whether or not an offset exists.
     * @param string $name
     * @return boolean
     */
    public function offsetExists($name) {
        try {
            $column = $this->searchColumn($name);
        } catch (ColumnNotFoundDBException $e) {
            return FALSE;
        }
        
        return TRUE;
    }

    /**
     * Get the value at specified column name.
     * @param string $name
     * @return mixed
     */
    public function offsetGet($name) {
        return $this->get($name);
    }

    /**
     * Assign a value to the specified column name.
     * @param string $name
     * @param mixed $value
     */
    public function offsetSet($name, $value) {
        $this->set($name, $value);
    }

    /**
     * Unset an offset.
     * @param string $name
     */
    public function offsetUnset($name) {
        $column = $this->searchColumn($name);
        $column->setAccessible(FALSE);
    }
    
    /****************************
     * Countable implementation *
     ****************************/
     
     /**
      * Gets the number of records or affected rows.
      * @return integer
      */
    public function count() {
        return $this->isCommand()? $this->affected_rows: count($this->rows);
    }
}
