<?php

namespace DvojkaT\Forumkit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $seo_title
 * @property string $seo_description
 */
class ThreadCategory extends Model
{
    use Filterable, AsSource;

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);
        });
    }

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'slug',
        'seo_title',
        'seo_description'
    ];

    /**
     * @var string[]
     */
    protected $allowedFilters = [
        'title' => Like::class
    ];

    /**
     *
     * @var string[]
     */
    protected $allowedSorts = [
        'id',
        'title'
    ];
}
