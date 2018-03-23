<?php

namespace Qubit\Bundle\UtilsBundle\Exception;

use Qubit\Bundle\UtilsBundle\Exception\CustomException;


class ContextNotAuthorizedException extends CustomException
{
    protected $code = 1001;
    protected $message = "Context Not Authorized";
    protected $statusCode = "500";
}
