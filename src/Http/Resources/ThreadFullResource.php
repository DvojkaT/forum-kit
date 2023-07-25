<?php

namespace DvojkaT\Forumkit\Http\Resources;

use DvojkaT\Forumkit\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Thread
 */
class ThreadFullResource extends JsonResource
{

    public function __construct(Thread $resource)
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
            'title' => $this->title,
            'content' => $this->content,
            'author' => $this->author->name,
            'category' => $this->category?->title,
            'likes' => $this->likes->count(),
            'commentaries' => ThreadCommentaryDTOResource::collection($this->commentaries)
        ];
    }
}
