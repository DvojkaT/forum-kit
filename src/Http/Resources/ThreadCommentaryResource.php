<?php

namespace DvojkaT\Forumkit\Http\Resources;

use DvojkaT\Forumkit\Models\ThreadCommentary;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ThreadCommentary
 */
class ThreadCommentaryResource extends JsonResource
{

    public function __construct(ThreadCommentary $resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
        ];
    }
}
