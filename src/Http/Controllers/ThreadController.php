<?php

namespace DvojkaT\Forumkit\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use DvojkaT\Forumkit\Exceptions\ThreadNotFoundHttpException;
use DvojkaT\Forumkit\Http\Requests\StoreThreadRequest;
use DvojkaT\Forumkit\Http\Resources\ThreadDTOFullResource;
use DvojkaT\Forumkit\Http\Resources\ThreadFullResource;
use DvojkaT\Forumkit\Http\Resources\ThreadShortResource;
use DvojkaT\Forumkit\Models\Thread;
use DvojkaT\Forumkit\Services\Abstracts\ThreadCommentaryServiceInterface;
use DvojkaT\Forumkit\Services\Abstracts\ThreadServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    private ThreadServiceInterface $service;
    private ThreadCommentaryServiceInterface $commentaryService;

    public function __construct(ThreadServiceInterface $service, ThreadCommentaryServiceInterface $commentaryService)
    {
        $this->service = $service;
        $this->commentaryService = $commentaryService;
    }

    /**
     * Получение тредов по категории
     *
     * @param int $category_id
     * @return AnonymousResourceCollection
     */
    public function index(int $category_id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ThreadShortResource::collection($this->service->getThreadsByCategory($category_id));
    }

    /**
     * Создание треда
     *
     * @return ThreadFullResource
     */
    public function store(StoreThreadRequest $request)
    {
        $data = $request->validated();
        $data['author_id'] = Auth::id();
        return new ThreadFullResource($this->service->store($data));
    }

    /**
     * Удаление треда
     *
     * @param int $thread_id
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function destroy(int $thread_id)
    {
        try {
            $this->service->destroy($thread_id);
        } catch (\Exception $e) {
            throw new ThreadNotFoundHttpException();
        }

        return response('deleted!', 200);
    }

    /**
     * Получение одного конкретного треда
     *
     * @param int $thread_id
     * @return ThreadDTOFullResource
     */
    public function show(int $thread_id)
    {
        /** @var User $user */
        $user = Auth::user();
        $thread = $this->service->show($thread_id);
        $commentaries = $this->commentaryService->transformCommentariesToHTML($thread->allCommentaries());
        $thread->commentaries = $this->commentaryService->checkForLike($commentaries, $user);
        $thread = $this->service->isLiked($thread, $user);

        return new ThreadDTOFullResource($thread);
    }

    /**
     * Обновление треда
     *
     * @param int $thread_id
     * @param StoreThreadRequest $request
     * @return ThreadFullResource
     */
    public function update(int $thread_id, StoreThreadRequest $request)
    {
        return new ThreadFullResource($this->service->update($thread_id, $request->validated()));
    }
}
