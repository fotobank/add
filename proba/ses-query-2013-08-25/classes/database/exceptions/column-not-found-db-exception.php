<?php

require_once dirname(dirname(__DIR__)) . "/database/exceptions/db-exception.php";

/**
 * class ColumnNotFoundDBException
 */
class ColumnNotFoundDBException extends Exception {
    
    /**
     * @param string $column
     * @param int $code = 0
     * @param Exception $previous = NULL
     */
    public function __construct($column, $code = 0, $previous = NULL) {
        $message = "The column `$column` were not found";
        parent::__construct($message, $code, $previous);
    }
}
