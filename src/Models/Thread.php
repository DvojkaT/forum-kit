<?php

namespace DvojkaT\Forumkit\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use DvojkaT\Forumkit\Models\ThreadCategory;
use DvojkaT\Forumkit\Models\ThreadCommentary;
use DvojkaT\Forumkit\Models\ThreadLike;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property int $author_id
 * @property int $category_id
 * @property int $image_id
 * @property string $seo_title
 * @property User $author
 * @property ?ThreadCategory $category
 * @property Collection<ThreadCommentary> $commentaries
 * @property Collection<ThreadLike> $likes
 */
class Thread extends Model
{
    use Attachable;
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);
        });
    }
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'author_id',
        'category_id',
        'image_id',
        'seo_title'
    ];

    /**
     * @return HasOne
     */
    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    /**
     * @return HasOne
     */
    public function category(): HasOne
    {
        return $this->hasOne(ThreadCategory::class, 'id', 'category_id');
    }

    /**
     * Комментарии привязанные к треду
     *
     * @return MorphMany
     */
    public function commentaries(): MorphMany
    {
        return $this->morphMany(ThreadCommentary::class, 'commentable', 'commentable_type');
    }

    /**
     * Лайки привязанные к треду
     *
     * @return MorphMany
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(ThreadLike::class, 'likable', 'likable_type');
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
     * Привязанные файлы
     *
     * @return MorphToMany
     */
    public function files(): MorphToMany
    {
        return $this->attachment('files');
    }

    /**
     * @return Collection
     */
    public function allCommentaries(): Collection
    {
        $this->load(['commentaries']);
        $commentaries = collect();

        /** @var ThreadCommentary $commentary */
        foreach ($this->commentaries as $commentary) {

            $commentaries = $this->getChildrenCommentaries($commentary, $commentaries);
        }
        return $commentaries->sortBy('created_at');
    }

    /**
     * Рекурсивный метод для заполнения коллекции всеми комментариями принадлежащими треду
     *
     * @param \DvojkaT\Forumkit\Models\ThreadCommentary $commentary
     * @param Collection $commentaries
     * @return Collection
     */
    private function getChildrenCommentaries(ThreadCommentary $commentary, Collection $commentaries): Collection
    {
        $commentaries = $commentaries->push($commentary);
        $commentary->load(['commentaries']);

        foreach ($commentary->commentaries as $childrenCommentary) {
            $commentaries = $this->getChildrenCommentaries($childrenCommentary, $commentaries);
        }
        return $commentaries;
    }
}
