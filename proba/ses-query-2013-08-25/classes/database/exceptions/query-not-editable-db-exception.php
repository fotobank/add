<?php

require_once dirname(dirname(__DIR__)) . "/database/exceptions/db-exception.php";

/**
 * class QueryNotEditableDBException
 */
class QueryNotEditableDBException extends DBException {
    
    /**
     * @param string $message
     * @param int $code = 0
     * @param Exception $previous = NULL
     */
    public function __construct($message = NULL, $code = 0, $previous = NULL) {
        if (strlen($message) == 0) {
            $message = "The query is not editable";
        }
        
        parent::__construct($message, $code, $previous);
    }
}
