<?php

namespace Qubit\Bundle\UtilsBundle\Exception;

use Qubit\Bundle\UtilsBundle\Exception\CustomException;


class ContextNotInitializedException extends CustomException
{
    protected $code = 1000;
    protected $message = "Context Not Initialized";
    protected $statusCode = "500";
}
