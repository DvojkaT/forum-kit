<?php

namespace DvojkaT\Forumkit\Http\Resources;

use DvojkaT\Forumkit\DTO\ThreadDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ThreadDTO
 */
class ThreadDTOFullResource extends JsonResource
{

    public function __construct(ThreadDTO $resource)
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
            'id' => $this->thread->id,
            'title' => $this->thread->title,
            'content' => $this->thread->content,
            'author' => $this->thread->author->name,
            'category' => $this->thread->category?->title,
            'likes' => $this->thread->likes->count(),
            'is_liked' => $this->isLiked,
            'commentaries' => ThreadCommentaryDTOResource::collection($this->thread->commentaries),
        ];
    }
}
