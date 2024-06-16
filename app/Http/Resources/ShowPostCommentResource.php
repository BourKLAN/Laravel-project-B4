<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowPostCommentResource extends JsonResource
{
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
            'comment' => ShowCommentResource::collection($this->comments),
            'total_comments' => $this->comments->count(),
            'userLikes' => ShowLikeResource::collection($this->likes),
            'total_likes' => $this->likes->count(),
            'user_shares'=>ShowUserShareResource::collection($this->shares),
            'total_shares' => $this->shares->count(),
        ];
    }
}
