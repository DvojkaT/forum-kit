<?php

namespace DvojkaT\Forumkit\Http\Controllers;

use App\Http\Controllers\Controller;
use DvojkaT\Forumkit\Http\Resources\ThreadCategoryResource;
use DvojkaT\Forumkit\Services\Abstracts\ThreadCategoryServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ThreadCategoryController extends Controller
{
    private ThreadCategoryServiceInterface $service;

    public function __construct(ThreadCategoryServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Получение всех категорий
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ThreadCategoryResource::collection($this->service->getCategories());
    }
}
