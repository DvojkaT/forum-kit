<?php

namespace DvojkaT\Forumkit\DTO;

use DvojkaT\Forumkit\Models\Thread;

/**
 * @property Thread $thread
 * @property bool $isLiked
 */
class ThreadDTO
{
    public function __construct(
        public Thread $thread,
        public bool $isLiked
    )
    {
    }
}
