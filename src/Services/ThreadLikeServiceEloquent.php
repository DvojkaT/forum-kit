<?php

namespace DvojkaT\Forumkit\Services;

use DvojkaT\Forumkit\Exceptions\LikeAlreadyExistsHttpException;
use DvojkaT\Forumkit\Exceptions\LikeDoNotExistHttpException;
use DvojkaT\Forumkit\Models\Thread;
use DvojkaT\Forumkit\Models\ThreadCommentary;
use DvojkaT\Forumkit\Models\ThreadLike;
use DvojkaT\Forumkit\Notifications\NewCommentaryOrLikeNotification;
use DvojkaT\Forumkit\Repositories\Abstracts\ThreadCommentaryRepositoryInterface;
use DvojkaT\Forumkit\Repositories\Abstracts\ThreadRepositoryInterface;
use DvojkaT\Forumkit\Services\Abstracts\ThreadLikeServiceInterface;

class ThreadLikeServiceEloquent implements ThreadLikeServiceInterface
{
    private ThreadCommentaryRepositoryInterface $threadCommentaryRepository;

    private ThreadRepositoryInterface $threadRepository;

    public function __construct(
        ThreadCommentaryRepositoryInterface $threadCommentaryRepository,
        ThreadRepositoryInterface           $threadRepository
    )
    {
        $this->threadCommentaryRepository = $threadCommentaryRepository;
        $this->threadRepository = $threadRepository;
    }

    /**
     * @inheritDoc
     */
    public function setLikeToThread(int $thread_id, int $user_id): Thread
    {
        $thread = $this->threadRepository->with(['likes'])->find($thread_id);

        if ($thread->likes->where('user_id', $user_id)->count() > 0) {
            throw new LikeAlreadyExistsHttpException();
        }

        $thread->author->notify(new NewCommentaryOrLikeNotification(ThreadLike::class, Thread::class, $thread_id));

        $thread->likes()->create(['user_id' => $user_id]);

        return $thread;
    }

    /**
     * @inheritDoc
     */
    public function setLikeToCommentary(int $commentary_id, int $user_id): ThreadCommentary
    {
        $commentary = $this->threadCommentaryRepository->with(['likes'])->find($commentary_id);

        if ($commentary->likes->where('user_id', $user_id)->count() > 0) {
            throw new LikeAlreadyExistsHttpException();
        }

        $commentary->author->notify(new NewCommentaryOrLikeNotification(ThreadLike::class, ThreadCommentary::class, $commentary_id));

        $commentary->likes()->create(['user_id' => $user_id]);

        return $commentary;
    }

    /**
     * @inheritDoc
     */
    public function unsetThreadLike(int $thread_id, int $user_id): Thread
    {
        $thread = $this->threadRepository->with(['likes'])->find($thread_id);

        if ($thread->likes->where('user_id', $user_id)->count() == 0) {
            throw new LikeDoNotExistHttpException();
        }

        $thread->likes()->delete(['user_id' => $user_id]);

        return $thread;
    }

    /**
     * @inheritDoc
     */
    public function unsetCommentaryLike(int $commentary_id, int $user_id): ThreadCommentary
    {
        $commentary = $this->threadCommentaryRepository->with(['likes'])->find($commentary_id);

        if($commentary->likes->where('user_id', $user_id)->count() == 0) {
            throw new LikeDoNotExistHttpException();
        }

        $commentary->likes()->delete(['user_id' => $user_id]);

        return $commentary;
    }
}
