<?php
/**
 * This file contains the DBColumn class.
 * 
 * @author Gonzalo Chumillas <gonzalo@soloproyectos.com>
 * @package database
 */

require_once dirname(__DIR__) . "/database/exceptions/column-not-editable-db-exception.php";
require_once dirname(__DIR__) . "/database/db-query.php";
require_once dirname(__DIR__) . "/database/db-table.php";

/**
 * class DBColumn
 * @package database
 */
class DBColumn {   
    /**
     * Query object.
     * @var DBColumn
     */
    private $query;
    
    /**
     * Column table.
     * @var DBTable
     */
    private $table = NULL;
    
    /**
     * Column name.
     * @var string
     */
    private $name = "";
    
    /**
     * Column aliases.
     * @var array[string]
     */
    private $aliases = array();
    
    /**
     * Column value.
     * @var string
     */
    private $value = "";
    
    /**
     * Column default value.
     * @var string
     */
    private $default_value = "";
    
    /**
     * Column links.
     * @var array[DBColumn]
     */
    private $links = array();
    
    /**
     * Has value changed?
     * @var boolean
     */
    private $has_changed = FALSE;
    
    /**
     * Has a default value?
     * @var boolean
     */
    private $has_default_value = FALSE;
    
    /**
     * Is accessible?
     * @var boolean
     */
    private $accessible = FALSE;
    
    /**
     * @param DBQuery $query
     * @param String $table Table alias.
     * @param String $name Column name.
     */
    public function __construct($query, $table, $name) {
        $this->query = $query;
        $this->name = $name;
        
        if (!util::isEmpty($table)) {
            $this->table = $this->query->registerTable($table);
            $this->table->registerColumn($this);
        }
    }
    
    public function reset() {
        $this->value = "";
        $this->has_changed = FALSE;
    }
    
    /**
     * Gets the column table.
     * @return DBTable
     */
    public function getTable() {
        return $this->table;
    }
    
    /**
     * Gets column name.
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Gets full name of the column.
     * The full name is composed by the 'table alias' and the 'column name' separated by a dot.
     * For example: table.field It identifies the column in the query in a unique way.
     * @return string
     */
    public function getFullName() {
        $ret = "";
        
        if ($this->isComputed()) {
            if (count($this->aliases) > 0) {
                // first alias
                $ret = $this->aliases[0];
            } else {
                // column position
                $columns = $this->query->getColumns();
                $ret = "" . array_search($this, $columns, TRUE);
            }
        } else {
            // table alias
            $table_alias = $this->table->getAlias();
            if (preg_match("/\W+/", $table_alias)) {
                $table_alias = "`$table_alias`";
            }
            
            // column name
            $column_name = $this->name;
            if (preg_match("/\W+/", $column_name)) {
                $column_name = "`$column_name`";
            }
            
            $ret = "$table_alias.$column_name";
        }
        
        return $ret;
    }
    
    /**
     * Gets value.
     * @return string
     */
    public function getValue() {
        $ret = "";
        
        if ($this->hasValue()) {
            $ret = $this->value;
        } else
        if ($this->hasOriginalValue()) {
            $ret = $this->getOriginalValue();
        }
        
        return $ret;
    }
    
    /**
     * Sets column value.
     * @param string $value
     * @throws ColumnNotEditableDBException if the column is not editable.
     */
    public function setValue($value, &$stack = array()) {
        if ($this->isComputed()) {
            throw new ColumnNotEditableDBException($this, ColumnNotEditableDBException::COMPUTED);
        }
        
        $table = $this->table;
        $pk = $table->getPrimaryKey();
        $this->value = $value;
        $this->has_changed = TRUE;
        array_push($stack, $this);
        
        if ($pk == NULL) {
            $column = $this->getFullName();
            $table = $this->table->getAlias();
            throw new ColumnNotEditableDBException($this, ColumnNotEditableDBException::PK_MISSING);
        } else {
            $pk_value = $pk->getOriginalValue();
            
            if (util::isEmpty($pk_value) && !$pk->isEditable()) {
                throw new ColumnNotEditableDBException($this, ColumnNotEditableDBException::PK_NOT_EDITABLE);
            }
        }
        
        foreach ($this->links as $link) {
            if (array_search($link, $stack, TRUE) === FALSE) {
                if (!$link->isEditable()) {
                    throw new ColumnNotEditableDBException($this, ColumnNotEditableDBException::LINK_NOT_EDITABLE);
                }
                
                $link->setValue($value, $stack);
            }
        }
    }
    
    /**
     * Deletes column value.
     */
    public function delValue() {
        $this->value = "";
        $this->has_changed = FALSE;
    }
    
    /**
     * Gets default value.
     * @return string
     */
    public function getDefaultValue() {
        return $this->default_value;
    }
    
    /**
     * Sets default value.
     * @param string $value
     */
    public function setDefaultValue($value) {
        $this->default_value = $value;
        $this->has_default_value = TRUE;
    }
    
    /**
     * Gets original value.
     * @return string
     */
    public function getOriginalValue() {
        return $this->query->getOriginalValue($this);
    }
    
    /**
     * Sets original column value.
     * @param string $value
     */
    public function setOriginalValue($value) {
        $this->query->setOriginalValue($this, $value);
    }
    
    /**
     * Adds a column link.
     * @param DBColumn $column
     */
    public function registerLink($column) {
        if (array_search($column, $this->links, TRUE) === FALSE) {
            array_push($this->links, $column);
        }
    }
    
    /**
     * Is column accessible?
     * @return boolean
     */
    public function isAccessible() {
        return $this->accessible;
    }
    
    /**
     * Sets column accessibility.
     * @param boolean $accessible
     */
    public function setAccessible($accessible) {
        $this->accessible = $accessible;
    }
    
    /**
     * Is the column editable?
     * A column is editable when:
     *      2. it is not a constant (it hasn't a default value)
     *      3. its parent table has primary key
     *      4. all its linked columns are editable
     * @param object $column
     * @return boolean
     */
    public function isEditable(&$stack = array()) {
        $ret = !$this->isComputed() && $this->table->getPrimaryKey() != NULL;
        
        if ($ret) {
            array_push($stack, $this);
            
            foreach ($this->links as $link) {
                if (array_search($link, $stack, TRUE) === FALSE) {
                    if (!$link->isEditable($stack)) {
                        $ret = FALSE;
                        break;
                    }
                }
            }
        }
        
        return $ret;
    }
    
    /**
     * Is primary key?
     * @param boolean
     */
    public function isPrimaryKey() {
        return $this->is_primary_key;
    }
    
    /**
     * Is a computed column?
     */
    public function isComputed() {
        return $this->table == NULL;
    }
    
    /**
     * Marks as primary key.
     * @param boolean $value
     */
    public function setPrimaryKey($value) {
        $this->is_primary_key = $value;
        
        if (!$this->isComputed() && $this->is_primary_key) {
            $this->table->setPrimaryKey($this);
        }
    }
    
    /**
     * Has changed the value?
     * @return boolean
     */
    public function hasChanged() {
        return $this->has_changed;
    }
    
    /**
     * Has a value?
     * @return boolean
     */
    public function hasValue() {
        return $this->hasChanged();
    }
    
    /**
     * Has a default value?
     * @return boolean
     */
    public function hasDefaultValue() {
        return $this->has_default_value;
    }
    
    /**
     * Has an original value?
     * @return boolean
     */
    public function hasOriginalValue() {
        return $this->query->hasOriginalValue($this);
    }
    
    /**
     * Adds an alias.
     * @param string $alias
     */
    public function registerAlias($alias) {
        $alias = trim($alias);
        
        if (strlen($alias) > 0 && array_search($alias, $this->aliases) === FALSE) {
            array_push($this->aliases, $alias);
        }
    }
    
    /**
     * Checks if it has an alias.
     * @param string $alias
     * @return boolean
     */
    public function isAlias($alias) {
        return array_search($alias, $this->aliases) !== FALSE;
    }
    
    /**
     * String representation of the column.
     * @return string
     */
    public function __toString() {
        return $this->getFullName();
    }
}
