<?php

namespace DvojkaT\Forumkit\Http\Controllers;

use App\Http\Controllers\Controller;
use DvojkaT\Forumkit\Http\Requests\StoreThreadCommentaryForCommentaryRequest;
use DvojkaT\Forumkit\Http\Requests\StoreThreadCommentaryForThreadRequest;
use DvojkaT\Forumkit\Http\Resources\ThreadCommentaryResource;
use DvojkaT\Forumkit\Models\ThreadCommentary;
use DvojkaT\Forumkit\Services\Abstracts\ThreadCommentaryServiceInterface;
use Illuminate\Support\Facades\Auth;

class ThreadCommentaryController extends Controller
{
    private ThreadCommentaryServiceInterface $service;

    public function __construct(ThreadCommentaryServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Создание комментария к треду
     *
     * @param StoreThreadCommentaryForThreadRequest $request
     * @return ThreadCommentaryResource
     */
    public function storeForThread(StoreThreadCommentaryForThreadRequest $request): ThreadCommentaryResource
    {
        return new ThreadCommentaryResource($this->service->storeForThread($request->validated(), Auth::id()));
    }

    /**
     * Создание комментария к комментарию
     *
     * @param StoreThreadCommentaryForCommentaryRequest $request
     * @return ThreadCommentaryResource
     */
    public function storeForCommentary(StoreThreadCommentaryForCommentaryRequest $request): ThreadCommentaryResource
    {
        return new ThreadCommentaryResource($this->service->storeForCommentary($request->validated(), Auth::id()));
    }

    /**
     * Вывод комментария по его id
     *
     * @param int $id
     * @return ThreadCommentary
     */
    public function show(int $id)
    {
        return $this->service->show($id);
    }


}
