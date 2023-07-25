<?php

namespace DvojkaT\Forumkit\Repositories;

use DvojkaT\Forumkit\Models\ThreadCommentary;
use DvojkaT\Forumkit\Repositories\Abstracts\ThreadCommentaryRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class ThreadCommentaryRepositoryEloquent extends BaseRepository implements ThreadCommentaryRepositoryInterface
{
    public function model(): string
    {
        return ThreadCommentary::class;
    }
}
