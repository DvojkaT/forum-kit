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

/**
 * @property int $id
 * @property string $text
 * @property string $commentable_type
 * @property int $commentable_id
 * @property int $user_id
 * @property int $image_id
 * @property Collection<ThreadCommentary> $commentaries
 * @property Collection<ThreadLike> $likes
 * @property User $author
 * @property Attachment $image
 */
class ThreadCommentary extends Model
{
    use Attachable;
    /**
     * @var string[]
     */
    protected $fillable = [
        'commentable_type',
        'commentable_id',
        'text',
        'user_id',
        'image_id'
    ];

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
