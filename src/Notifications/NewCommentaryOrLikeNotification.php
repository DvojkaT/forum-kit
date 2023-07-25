<?php

namespace DvojkaT\Forumkit\Notifications;

use DvojkaT\Forumkit\Models\Thread;
use DvojkaT\Forumkit\Models\ThreadCommentary;
use DvojkaT\Forumkit\Models\ThreadLike;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewCommentaryOrLikeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public readonly string $object_action,
        public readonly string $object_type,
        public readonly int|string    $object_id,
    )
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'object_type' => $this->object_type,
            'object_id' => $this->object_id,
            'message' => $this->getMessage($this->object_action, $this->object_type)
        ];
    }

    /**
     * Получение нужного сообщения в зависимости от сущности
     *
     * @param string $objectAction
     * @param string $objectType
     * @return string
     */
    private function getMessage(string $objectAction, string $objectType): string
    {
        return match ($objectAction) {
            ThreadLike::class => match ($objectType) {
                Thread::class => "У вашего поста новый лайк!",
                ThreadCommentary::class => "У вашего комментария новый лайк!"
            },
            ThreadCommentary::class => match ($objectType) {
                Thread::class => 'У вашего поста новый комментарий!',
                ThreadCommentary::class => "У вашего комментария новый ответ!",
            },
            'default' => 'Неизвестная ошибка'
        };
    }
}
