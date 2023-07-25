<?php

namespace DvojkaT\Forumkit\Services\Abstracts;

use DvojkaT\Forumkit\Exceptions\LikeAlreadyExistsHttpException;
use DvojkaT\Forumkit\Exceptions\LikeDoNotExistHttpException;
use DvojkaT\Forumkit\Models\Thread;
use DvojkaT\Forumkit\Models\ThreadCommentary;

interface ThreadLikeServiceInterface
{
    /**
     * Привязка лайка к треду
     *
     * @param int $thread_id
     * @param int $user_id
     * @return Thread
     * @throws LikeAlreadyExistsHttpException
     */
    public function setLikeToThread(int $thread_id, int $user_id): Thread;

    /**
     * Привязка лайка к комментарию
     *
     * @param int $commentary_id
     * @param int $user_id
     * @return ThreadCommentary
     * @throws LikeAlreadyExistsHttpException
     */
    public function setLikeToCommentary(int $commentary_id, int $user_id): ThreadCommentary;

    /**
     * Отвязка лайка от треда
     *
     * @param int $thread_id
     * @param int $user_id
     * @return Thread
     * @throws LikeDoNotExistHttpException
     */
    public function unsetThreadLike(int $thread_id, int $user_id): Thread;

    /**
     * Отвязка лайка от комментария
     *
     * @param int $commentary_id
     * @param int $user_id
     * @return ThreadCommentary
     * @throws LikeDoNotExistHttpException
     */
    public function unsetCommentaryLike(int $commentary_id, int $user_id): ThreadCommentary;
}
