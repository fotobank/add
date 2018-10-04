<?php

require_once dirname(dirname(__DIR__)) . "/database/exceptions/db-exception.php";

/**
 * class ColumnNotEditableDBException
 */
class ColumnNotEditableDBException extends DBException {
    const PK_MISSING = 1;
    const PK_NOT_EDITABLE = 2;
    const LINK_NOT_EDITABLE = 3;
    const COMPUTED = 4;
    
    private $errors = array(
        "The column `%s` is not editable",
        "The column `%s` is not editable because the primary key of the table `%s` is missing",
        "The column `%s` is not editable because the primary key of the table `%s` is not editable",
        "The column `%s` is not editable because it is linked with a non-editable column",
        "The column `%s` is not editable because it is a computed field"
    );
    
    /**
     * @param DBColumn $column
     * @param int $code = 0
     * @param Exception $previous = NULL
     */
    public function __construct($column, $code = 0, $previous = NULL) {
        $table = $column->getTable();
        $column_name = $column->getFullName();
        $table_alias = $table != NULL? $table->getAlias() : "";
        $message = sprintf($this->errors[$code], $column_name, $table_alias);
        parent::__construct($message, $code, $previous);
    }
}
