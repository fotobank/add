<?php
/**
 * This file contains the DBTable class.
 * 
 * @author Gonzalo Chumillas <gonzalo@soloproyectos.com>
 * @package database
 */

require_once dirname(__DIR__) . "/database/db-query.php";
require_once dirname(__DIR__) . "/database/db-column.php";

/**
 * class DBTable
 * @package database
 */
class DBTable {
    const INNER_JOIN = "inner";
    const LEFT_JOIN = "left";
    
    /**
     * Query.
     * @var DBQuery
     */
    private $query;
    
    /**
     * Table alias.
     * @var string
     */
    private $alias = "";
    
    /**
     * Table name.
     * @var string
     */
    private $name = "";
    
    /**
     * Join type.
     * @var string
     */
    private $join_type = DBTable::LEFT_JOIN;
    
    /**
     * Primary key column.
     * @var DBColumn
     */
    private $primary_key;
    
    /**
     * Table columns.
     * @var array[DBColumn]
     */
    private $columns = array();
    
    /**
     * @param DBQuery $query
     * @param string $name
     */
    public function __construct($query, $alias) {
        $this->query = $query;
        $this->alias = $alias;
    }
    
    /**
     * Gets table name.
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Sets table name.
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getJoinType() {
        return $this->join_type;
    }
    
    public function setJoinType($join_type) {
        $this->join_type = $join_type;
    }
    
    /**
     * Gets table alias.
     * @return string
     */
    public function getAlias() {
        return $this->alias;
    }
    
    /**
     * Gets the table columns.
     * @return array[DBColumn]
     */
    public function getColumns() {
        $ret = array();
        
        foreach ($this->columns as $column) {
            array_push($ret, $column);
        }
        
        return $ret;
    }
    
    /**
     * Gets column by name.
     * @param string $name
     * @return DBColumn
     */
    public function getColumnByName($name) {
        $ret = NULL;
        foreach ($this->columns as $column) {
            if ($column->getName() == $name) {
                $ret = $column;
                break;
            }
        }
        return $ret;
    }
    
    /**
     * Sets the primary key column.
     * @param DBColumn $column
     */
    public function setPrimaryKey($column) {
        $this->primary_key = $column;
    }
    
    /**
     * Gets the primary key column.
     * @return DBColumn
     */
    public function getPrimaryKey() {
        return $this->primary_key;
    }
    
    /**
     * Registers a new columns.
     * @param DBColumn $column
     */
    public function registerColumn($column) {
        $pos = array_search($column, $this->columns, TRUE);
        
        if ($pos === FALSE) {
            array_push($this->columns, $column);
        }
    }
    
    /**
     * Has the table changed?
     * @return boolean
     */
    public function hasChanged() {
        $ret = FALSE;
        
        foreach ($this->columns as $column) {
            if ($column->hasChanged()) {
                $ret = TRUE;
                break;
            }
        }
        
        return $ret;
    }
}
