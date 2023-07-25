<?php

namespace DvojkaT\Forumkit\DTO;

use DvojkaT\Forumkit\Models\ThreadCommentary;

/**
 * @property ThreadCommentary $commentary
 * @property bool $isLiked
 */
class ThreadCommentaryDTO
{
    public function __construct(
        public readonly ThreadCommentary $commentary,
        public readonly bool $isLiked
    )
    {
    }
}
