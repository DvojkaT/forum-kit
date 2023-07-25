<?php

namespace DvojkaT\Forumkit\Services\Abstracts;

use DvojkaT\Forumkit\Models\ThreadCategory;
use Illuminate\Database\Eloquent\Collection;

interface ThreadCategoryServiceInterface
{
    /**
     * @return Collection<array-key, ThreadCategory>
     */
    public function getCategories(): Collection;
}
