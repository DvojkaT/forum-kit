<?php

namespace DvojkaT\Forumkit\Providers;

use DvojkaT\Forumkit\Repositories\Abstracts\ThreadCategoryRepositoryInterface;
use DvojkaT\Forumkit\Repositories\Abstracts\ThreadCommentaryRepositoryInterface;
use DvojkaT\Forumkit\Repositories\Abstracts\ThreadRepositoryInterface;
use DvojkaT\Forumkit\Repositories\ThreadCategoryRepositoryEloquent;
use DvojkaT\Forumkit\Repositories\ThreadCommentaryRepositoryEloquent;
use DvojkaT\Forumkit\Repositories\ThreadRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class ForumRepositoryServiceProvider extends ServiceProvider
{
    /** @var array<string, string> */
    protected array $mappings = [
        ThreadRepositoryInterface::class => ThreadRepositoryEloquent::class,
        ThreadCategoryRepositoryInterface::class => ThreadCategoryRepositoryEloquent::class,
        ThreadCommentaryRepositoryInterface::class => ThreadCommentaryRepositoryEloquent::class
    ];

    public function register(): void
    {
        foreach ($this->mappings as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }
}
