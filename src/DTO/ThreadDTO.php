<?php

namespace DvojkaT\Forumkit\DTO;

use DvojkaT\Forumkit\Models\Thread;
use Illuminate\Support\Collection;

/**
 * @property Thread $thread
 * @property null|bool $isLiked
 * @property Collection<ThreadCommentaryDTO> $commentaries
 */
class ThreadDTO
{
    public function __construct(
        public readonly Thread $thread,
        public readonly ?bool $isLiked,
        public readonly ?Collection $commentaries
    )
    {
    }
}
