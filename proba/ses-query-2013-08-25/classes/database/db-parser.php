<?php
/**
 * This file contains the DBParser class.
 * 
 * @author Gonzalo Chumillas <gonzalo@soloproyectos.com>
 * @package database
 */

require_once dirname(__DIR__) . "/database/db-query.php";
require_once dirname(__DIR__) . "/database/db-column.php";
require_once dirname(__DIR__) . "/parser/parser.php";

/**
 * class DBParser
 * 
 * This class parses an SQL sentence.
 * 
 * @package database
 */
class DBParser extends Parser {
    /**
     * A subset of reserved words
     * @var array
     */
    private $reserved_words = array(
        "from", "where", "on", "group", "having", "order", "limit", "union", "inner", "left", "right", "join", "and"
    );
    
    /**
     * @var DBQuery
     */
    private $query;
    
    /**
     * @param DBQuery $query
     * @param string $sql
     */
    public function __construct($query, $sql) {
        $this->query = $query;
        parent::__construct($sql, Parser::UNGREEDY);
    }
    
    /**
     * Is a reserved word?
     * @param string $word
     * @return string
     */
    private function isReservedWord($str) {
        $str = strtolower(trim($str));
        return array_search($str, $this->reserved_words) !== FALSE;
    }
    
    /**
     * Parses conditions individually.
     * @param int $offset0
     * @param int $offset1
     */
    private function parseConditions($offset0, $offset1) {
        $str = trim(substr($this->string, $offset0, $offset1 - $offset0));
        $conditions = preg_split("/\s+and\s+/i", $str);
        
        foreach ($conditions as $condition) {
            $terms = explode("=", $condition);
            if (count($terms) != 2) {
                continue;
            }
            
            // parse columns
            $columns = array();
            foreach ($terms as $term) {
                $t = new Tokenizer($term);
                if ( (list($value) = $t->str()) || (list($value) = $t->number()) ) {
                    array_push($columns, $value);
                } else
                if ($t->match("(`?(\w+)`?\s*\.\s*)?`?(\w+)`?", $matches)) {
                    $table_name = trim($matches[2]);
                    $column_name = trim($matches[3]);
                    $column = $this->query->registerColumn($table_name, $column_name);
                    array_push($columns, $column);
                }
            }
            
            // links columns
            foreach ($columns as $i => $column0) {
                $column1 = $columns[($i + 1) % 2];
                if ($column0 instanceof DBColumn) {
                    if ($column1 instanceof DBColumn) {
                        $column0->registerLink($column1);
                        $column1->registerLink($column0);
                    } else {
                        $column0->setDefaultValue($column1);
                    }
                    
                    break;
                }
            }
        }
    }
    
    /**
     * Is the next an identifier?
     * @return array|boolean
     */
    protected function identifier() {
        if ($this->match("`([^`]+)`", $matches)) {
            return array($matches[2]);
        } else {
            $offset = $this->offset;
            
            if (list($name) = $this->match("\w+")) {
                if ($this->isReservedWord($name)) {
                    $this->offset = $offset;
                } else {
                    return array($name);
                }
            }
        }
        
        return FALSE;
    }
    
    /**
     * Is the next a join clause?
     * @throws ParserError
     * @return array|boolean
     */
    protected function join() {
        // gets join type
        if (!list($str) = $this->match("((inner|(left(\s+outer)?))\s+)?join\s+", $matches, Tokenizer::SEARCH_ANYWHERE|Tokenizer::OFFSET_CAPTURE)) {
            return FALSE;
        }
        $join_type = stripos($str, "inner") !== FALSE? DBTable::INNER_JOIN : DBTable::LEFT_JOIN;
        $offset = $matches[0][1];
        
        // gets table name
        if (!list($table_name) = $this->is("identifier")) {
            throw new ParserException($this, "Table name expected");
        }
        
        // gets table alias
        $table_alias = $table_name;
        if ($this->eq("as")) {
            if (!list($table_alias) = $this->is("identifier")) {
                throw new ParserException($this, "Table alias expected");
            }
        } else
        if (list($str) = $this->is("identifier")) {
            $table_alias = $str;
        }
        
        // register table
        $table = $this->query->registerTable($table_alias, TRUE);
        $table->setName($table_name);
        $table->setJoinType($join_type);
        
        // optional "on"
        $this->eq("on");
        
        return array($offset);
    }
    
    /**
     * Is the next a where clause?
     * @return array|boolean
     */
    protected function where() {
        if (!$this->match("where\s+", $matches, Tokenizer::SEARCH_ANYWHERE|Tokenizer::OFFSET_CAPTURE)) {
            return FALSE;
        }
        $offset = $matches[0][1];
        
        return array($offset);
    }
    
    /**
     * Is the next whatever?
     * @return array|boolean
     */
    protected function whatever() {
        if ($this->match("(group|having|order|limit|union)\s+", $matches, Tokenizer::SEARCH_ANYWHERE|Tokenizer::OFFSET_CAPTURE)) {
            return array($matches[0][1]);
        }
        
        return array(strlen($this->string));
    }
    
    /**
     * Is the next a select?
     * @throws ParserError
     * @return array|boolean
     */
    protected function select() {
        $main_table = NULL;
        
        if ($this->match("select.*from")) {
            // gets table name
            if (!list($table_name) = $this->is("identifier")) {
                throw new ParserException($this, "Table name expected");
            }
            
            // gets table alias
            $table_alias = $table_name;
            if ($this->eq("as")) {
                if (!list($table_alias) = $this->is("identifier")) {
                    throw new ParserException($this, "Table alias expected");
                }
            } else
            if (list($str) = $this->is("identifier")) {
                $table_alias = $str;
            }
            
            // register main table
            $main_table = $this->query->registerTable($table_alias, TRUE);
            $main_table->setName($table_name);
            $this->query->setMainTable($main_table);
            
            // join clauses
            $offset0 = $this->offset;
            while (list($offset1) = $this->is("join")) {
                $this->parseConditions($offset0, $offset1);
                $offset0 = $this->offset;
            }
            
            // where clause
            if (list($offset1) = $this->is("where")) {
                $this->parseConditions($offset0, $offset1);
                $offset0 = $this->offset;
            }
            
            // whatever else
            if (list($offset1) = $this->is("whatever")) {
                $this->parseConditions($offset0, $offset1);
            }
        }
        
        return $main_table != NULL && $main_table->getPrimaryKey() != NULL;
    }
    
    /**
     * Parses the sql sentence.
     * @return array|boolean
     */
    public function _parse() {
        return $this->is("select");
    }
}
