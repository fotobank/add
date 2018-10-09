<?php
       /**
        * Created by PhpStorm.
        * User: Jurii
        * Date: 05.10.2018
        * Time: 9:54
        */

       namespace Framework\Zip\CreateZipRuntimeException;
       use Throwable;

       class CreateZipRuntimeException extends \RuntimeException{


              public function __construct(string $message = '', int $code = 0, Throwable $previous = NULL) {
                     parent::__construct($message, $code, $previous);
              }

       }
