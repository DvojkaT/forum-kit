<?php

namespace DvojkaT\Forumkit\Http\Resources;

use DvojkaT\Forumkit\DTO\ThreadCommentaryDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ThreadCommentaryDTO
 */
class ThreadCommentaryDTOResource extends JsonResource
{
    public function __construct(ThreadCommentaryDTO $resource)
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
            'id' => $this->commentary->id,
            'text' => $this->commentary->text,
            'likes' => $this->commentary->likes->count(),
            'is_liked' => $this->isLiked,
        ];
    }
}
