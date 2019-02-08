<?php

class ManagerException extends Exception
{
    protected $errorCode;
    public function __construct($message, $errorCode = "")
    {
        $this->errorCode = $errorCode;
        parent::__construct($message);
    }
    public function getErrorCode()
    {
        return $this->errorCode;
    }
}
