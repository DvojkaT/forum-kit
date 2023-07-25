<?php

namespace DvojkaT\Forumkit\Services;

use App\Models\User;
use DvojkaT\Forumkit\DTO\ThreadDTO;
use DvojkaT\Forumkit\Models\Thread;
use DvojkaT\Forumkit\Repositories\Abstracts\ThreadRepositoryInterface;
use DvojkaT\Forumkit\Services\Abstracts\ThreadServiceInterface;
use Illuminate\Support\Collection;

class ThreadServiceEloquent implements ThreadServiceInterface
{
    private ThreadRepositoryInterface $repository;

    public function __construct(ThreadRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function getThreadsByCategory(int $category_id): Collection
    {
        return $this->repository->findWhere(['category_id' => $category_id]);
    }

    /**
     * @inheritDoc
     */
    public function store(array $fields): Thread
    {
        return $this->repository->create($fields);
    }

    /**
     * @inheritDoc
     */
    public function destroy(int $thread_id): int
    {
        return $this->repository->delete($thread_id);
    }

    /**
     * @inheritDoc
     */
    public function show(int $thread_id): Thread
    {
        return $this->repository->find($thread_id);

    }

    /**
     * @inheritDoc
     */
    public function update(int $thread_id, array $attributes): Thread
    {
        return $this->repository->update($attributes, $thread_id);
    }

    /**
     * @inheritDoc
     */
    public function isLiked(Collection|Thread $object, User $user): ThreadDTO|Collection
    {
        if($object instanceof Collection) {
            return $object->map(function (Thread $thread) use ($user) {
                return $this->checkIsLiked($thread, $user);
            });
        } else {
            return $this->checkIsLiked($object, $user);
        }
    }

    /**
     * Преобразование треда в ThreadDTO с булевым значением, лайкал данный пользователь это или нет
     *
     * @param Thread $thread
     * @param User $user
     * @return ThreadDTO
     */
    private function checkIsLiked(Thread $thread, User $user): ThreadDTO
    {
        $likedThreads = $user->threadsLikes->pluck('likable_id');
        if ($likedThreads->contains($thread->id)) {
            $isLiked = true;
        } else {
            $isLiked = false;
        }
        return new ThreadDTO($thread, $isLiked);
    }
}
