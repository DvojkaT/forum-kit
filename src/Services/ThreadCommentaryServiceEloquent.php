<?php

namespace DvojkaT\Forumkit\Services;

use App\Models\User;
use DvojkaT\Forumkit\DTO\ThreadCommentaryDTO;
use DvojkaT\Forumkit\Models\Thread;
use DvojkaT\Forumkit\Models\ThreadCommentary;
use DvojkaT\Forumkit\Notifications\NewCommentaryOrLikeNotification;
use DvojkaT\Forumkit\Repositories\Abstracts\ThreadCommentaryRepositoryInterface;
use DvojkaT\Forumkit\Repositories\Abstracts\ThreadRepositoryInterface;
use DvojkaT\Forumkit\Services\Abstracts\ThreadCommentaryServiceInterface;
use Illuminate\Support\Collection;

class ThreadCommentaryServiceEloquent implements ThreadCommentaryServiceInterface
{
    private ThreadCommentaryRepositoryInterface $repository;
    private ThreadRepositoryInterface $threadRepository;

    public function __construct(
        ThreadCommentaryRepositoryInterface $repository,
        ThreadRepositoryInterface $threadRepository
    )
    {
        $this->repository = $repository;
        $this->threadRepository = $threadRepository;
    }

    /**
     * @inheritDoc
     */
    public function storeForThread(array $fields, int $user_id): ThreadCommentary
    {
        $thread = $this->threadRepository->find($fields['thread_id']);
        $thread->author->notify(new NewCommentaryOrLikeNotification(ThreadCommentary::class, Thread::class, $fields['thread_id']));

        return $this->repository->create([
            'text' => $fields['text'],
            'commentable_id' => $fields['thread_id'],
            'commentable_type' => Thread::class,
            'user_id' => $user_id
        ]);
    }

    /**
     * @inheritDoc
     */
    public function storeForCommentary(array $fields, int $user_id): ThreadCommentary
    {
        $commentary = $this->repository->find($fields['commentary_id']);
        $commentary->author->notify(new NewCommentaryOrLikeNotification(ThreadCommentary::class, ThreadCommentary::class, $fields['commentary_id']));

        return $this->repository->create([
            'text' => $fields['text'],
            'commentable_id' => $fields['commentary_id'],
            'commentable_type' => ThreadCommentary::class,
            'user_id' => $user_id
        ]);
    }

    /**
     * @inheritDoc
     */
    public function show(int $id): ThreadCommentary
    {
        return $this->repository->find($id);
    }

    /**
     * @inheritDoc
     */
    public function transformCommentariesToHTML(Collection $commentaries): Collection
    {
        return $commentaries->transform(function (ThreadCommentary $commentary) {
            $commentary->text = $this->commentaryParser($commentary->text);
            return $commentary;
        });
    }

    /**
     * @inheritDoc
     */
    public function checkForLike(Collection $commentaries, User $user): Collection
    {
        $likedComments = $user->commentariesLikes->pluck('likable_id');
        return $commentaries->map(function (ThreadCommentary $commentary) use ($likedComments) {
            if($likedComments->contains($commentary->id)) {
                $isLiked = true;
            } else {
                $isLiked = false;
            }
            return new ThreadCommentaryDTO($commentary, $isLiked);
        });
    }

    /**
     * Преобразование текста по тегам
     *
     * @param string $comment
     * @return string
     */
    private function commentaryParser(string $comment): string
    {
        $patterns = [
            "((\<(.*?)\>))" => function (array $matches) {
                return "<code>$matches[2]</code>";
            },
            "(\*(.*?)\*)" => function (array $matches) {
                return str_replace($matches[0], '<u>'.$matches[1].'</u>', $matches[0]);
            },
            "((http|ftp|https):\/\/([\w_-]+(?:(?:\.[\w_-]+)+))([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]))" => function (array $matches) {
                return "<a href='$matches[0]'>".$matches[0]."</a>";
            },
            '((\|(.*?)\|)([^\s,.;:"]+))' => function (array $matches) {
                return "<a href='$matches[2]'>".$matches[3]."</a>";
            },
        ];

        return preg_replace_callback_array($patterns, $comment);
    }
}
