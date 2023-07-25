<?php

namespace DvojkaT\Forumkit\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property string $likable_type
 * @property int $likeable_id
 */
class ThreadLike extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'likable_type',
        'likable_id'
    ];
}
