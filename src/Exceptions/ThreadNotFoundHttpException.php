<?php

namespace DvojkaT\Forumkit\Exceptions;

class ThreadNotFoundHttpException extends BaseHttpException
{
    /** @var string  */
    protected $message = 'Данный тред не найден';

    /** @var int  */
    protected $code = 404;
}
