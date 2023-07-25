<?php

namespace DvojkaT\Forumkit\Services\Abstracts;

use App\Models\User;
use DvojkaT\Forumkit\Models\ThreadCommentary;
use Illuminate\Support\Collection;

interface ThreadCommentaryServiceInterface
{
    /**
     * Создание комментария к треду
     *
     * @param array<string, string> $fields
     * @param int $user_id
     * @return ThreadCommentary
     */
    public function storeForThread(array $fields, int $user_id): ThreadCommentary;

    /**
     * Создание комментария к комментарию
     *
     * @param array<string, string> $fields
     * @param int $user_id
     * @return ThreadCommentary
     */
    public function storeForCommentary(array $fields, int $user_id): ThreadCommentary;

    /**
     * Получение комментария по id
     *
     * @param int $id
     * @return ThreadCommentary
     */
    public function show(int $id): ThreadCommentary;

    /**
     * Преобразование комментариев к html виду
     *
     * @param Collection $commentaries
     * @return Collection
     */
    public function transformCommentariesToHTML(Collection $commentaries): Collection;

    /**
     * @param Collection $commentaries
     * @param User $user
     * @return Collection
     */
    public function checkForLike(Collection $commentaries, User $user): Collection;
}
