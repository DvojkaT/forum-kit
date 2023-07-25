<?php

namespace DvojkaT\Forumkit\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class BaseHttpException extends HttpException
{
    /** @var string */
    protected $message = '';

    /** @var int */
    protected int $statusCode = 500;

    public function __construct()
    {
        parent::__construct($this->statusCode, $this->message);
    }
}
