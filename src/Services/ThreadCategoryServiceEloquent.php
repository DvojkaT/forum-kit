<?php

namespace DvojkaT\Forumkit\Services;

use DvojkaT\Forumkit\Repositories\Abstracts\ThreadCategoryRepositoryInterface;
use DvojkaT\Forumkit\Services\Abstracts\ThreadCategoryServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ThreadCategoryServiceEloquent implements ThreadCategoryServiceInterface
{
    private ThreadCategoryRepositoryInterface $repository;

    public function __construct(ThreadCategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function getCategories(): Collection
    {
        return $this->repository->all();
    }
}
