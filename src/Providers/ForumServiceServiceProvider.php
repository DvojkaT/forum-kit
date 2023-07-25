<?php

namespace DvojkaT\Forumkit\Providers;

use DvojkaT\Forumkit\Services\Abstracts\ThreadCategoryServiceInterface;
use DvojkaT\Forumkit\Services\Abstracts\ThreadCommentaryServiceInterface;
use DvojkaT\Forumkit\Services\Abstracts\ThreadLikeServiceInterface;
use DvojkaT\Forumkit\Services\Abstracts\ThreadServiceInterface;
use DvojkaT\Forumkit\Services\ThreadCategoryServiceEloquent;
use DvojkaT\Forumkit\Services\ThreadCommentaryServiceEloquent;
use DvojkaT\Forumkit\Services\ThreadLikeServiceEloquent;
use DvojkaT\Forumkit\Services\ThreadServiceEloquent;
use Illuminate\Support\ServiceProvider;

class ForumServiceServiceProvider extends ServiceProvider
{
    /** @var array<string, string> */
    protected array $mappings = [
        ThreadServiceInterface::class => ThreadServiceEloquent::class,
        ThreadCategoryServiceInterface::class => ThreadCategoryServiceEloquent::class,
        ThreadCommentaryServiceInterface::class => ThreadCommentaryServiceEloquent::class,
        ThreadLikeServiceInterface::class => ThreadLikeServiceEloquent::class
    ];

    public function register(): void
    {
        foreach ($this->mappings as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }
}
