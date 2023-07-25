<?php

namespace DvojkaT\Forumkit\Services\Abstracts;

use App\Models\User;
use DvojkaT\Forumkit\DTO\ThreadDTO;
use DvojkaT\Forumkit\Models\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ThreadServiceInterface
{
    /**
     * Получение тредов по категории
     *
     * @param int $category_id
     * @return Collection<array-key, Model>
     */
    public function getThreadsByCategory(int $category_id): Collection;

    /**
     * @param array<string, string> $fields
     * @return Thread
     */
    public function store(array $fields): Thread;

    /**
     * @param int $thread_id
     * @return int
     */
    public function destroy(int $thread_id): int;

    /**
     * @param int $thread_id
     * @return Thread
     */
    public function show(int $thread_id): Thread;

    /**
     * @param int $thread_id
     * @param array<string, string> $attributes
     * @return Thread
     */
    public function update(int $thread_id, array $attributes): Thread;

    /**
     * Преобразование Треда|коллекции тредов в дто с доп. значением ставил ли данный пользователь лайк
     *
     * @param Collection|Thread $object
     * @param User $user
     * @return Collection<ThreadDTO>|ThreadDTO
     */
    public function isLiked(Collection|Thread $object, User $user): Collection|ThreadDTO;
}
