<?php

namespace DvojkaT\Forumkit\Exceptions;

class LikeAlreadyExistsHttpException extends BaseHttpException
{
    /** @var string  */
    protected $message = 'Лайк на данной сущности уже поставлен';

    /** @var int  */
    protected $code = 409;
}
