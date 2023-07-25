<?php

namespace DvojkaT\Forumkit\Exceptions;

class LikeDoNotExistHttpException extends BaseHttpException
{
    /** @var string  */
    protected $message = 'Лайка на данной сущности не существует';

    /** @var int  */
    protected $code = 404;
}
