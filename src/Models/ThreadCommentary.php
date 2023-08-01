<?php

namespace DvojkaT\Forumkit\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $text
 * @property string $commentable_type
 * @property int $commentable_id
 * @property int $user_id
 * @property int $image_id
 * @property boolean $is_deleted
 * @property string $deletion_reason
 * @property Collection<ThreadCommentary> $commentaries
 * @property Collection<ThreadLike> $likes
 * @property User $author
 * @property Attachment $image
 * @property Thread|ThreadCommentary $commentable
 */
class ThreadCommentary extends Model
{
    use Attachable, AsSource, Filterable;
    /**
     * @var string[]
     */
    protected $fillable = [
        'commentable_type',
        'commentable_id',
        'text',
        'user_id',
        'image_id',
        'is_deleted',
        'deletion_reason'
    ];

    /**
     * Возврат форматированной причины удаления
     *
     * @return string
     */
    public function deletionReason(): string
    {
        return $this->deletion_reason ? "Удалено по причине: $this->deletion_reason" : "Удалено";
    }

    /**
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Комментарии привязанные к данному комментарию
     *
     * @return MorphMany
     */
    public function commentaries(): MorphMany
    {
        return $this->morphMany(ThreadCommentary::class, 'commentable', 'commentable_type', 'commentable_id', 'id');
    }

    /**
     * Получение лайков данного комментария
     *
     * @return MorphMany
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(ThreadLike::class, 'likable', 'likable_type');
    }

    /**
     * Получение автора
     *
     * @return HasOne
     */
    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Получение привязанной картинки
     *
     * @return HasOne
     */
    public function image(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image_id');
    }

    /**
     * Получение файлов
     *
     * @return MorphToMany
     */
    public function files(): MorphToMany
    {
        return $this->attachment('files');
    }
}
