<?php

namespace DvojkaT\Forumkit\Http\Controllers;

use App\Http\Controllers\Controller;
use DvojkaT\Forumkit\Http\Resources\ThreadCommentaryResource;
use DvojkaT\Forumkit\Http\Resources\ThreadShortResource;
use DvojkaT\Forumkit\Services\Abstracts\ThreadLikeServiceInterface;
use Illuminate\Support\Facades\Auth;

class ThreadLikeController extends Controller
{
    private ThreadLikeServiceInterface $service;

    public function __construct(ThreadLikeServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Привязка лайка к треду
     *
     * @param int $thread_id
     * @return ThreadShortResource
     */
    public function setLikeToThread(int $thread_id)
    {
        $thread = $this->service->setLikeToThread($thread_id, Auth::id());
        return new ThreadShortResource($thread);
    }

    /**
     * Привязка лайка к комментарию
     *
     * @param int $commentary_id
     * @return ThreadCommentaryResource
     */
    public function setLikeToCommentary(int $commentary_id)
    {
        $commentary = $this->service->setLikeToCommentary($commentary_id, Auth::id());
        return new ThreadCommentaryResource($commentary);
    }

    /**
     * Отвязка лайка от треда
     *
     * @param int $thread_id
     * @return ThreadShortResource
     */
    public function unsetThreadLike(int $thread_id)
    {
        $thread = $this->service->unsetThreadLike($thread_id, Auth::id());
        return new ThreadShortResource($thread);
    }

    /**
     * Отвязка лайка от комментария
     *
     * @param int $commentary_id
     * @return ThreadCommentaryResource
     */
    public function unsetCommentaryLike(int $commentary_id)
    {
        $commentary = $this->service->unsetCommentaryLike($commentary_id, Auth::id());
        return new ThreadCommentaryResource($commentary);
    }
}
