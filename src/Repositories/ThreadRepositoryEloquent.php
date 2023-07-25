<?php

namespace DvojkaT\Forumkit\Repositories;

use DvojkaT\Forumkit\Models\Thread;
use DvojkaT\Forumkit\Repositories\Abstracts\ThreadRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class ThreadRepositoryEloquent extends BaseRepository implements ThreadRepositoryInterface
{
    public function model():string
    {
        return Thread::class;
    }


}
