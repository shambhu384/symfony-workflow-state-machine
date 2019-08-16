<?php

namespace App\Exception;

class BadWorkflow extends \Exception{

    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

    }

    public static function orderStateCanOnlyBeSetFromWorkflow(string $callerClass)
    {
        if('' != $callerClass) {
            $callerClass = 'No caller class defined';
        }

        return new self('Symfony workflow component has to set order state!, You tried to set it from: '. $callerClass);
    }
}
