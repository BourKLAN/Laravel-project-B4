<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowSharePostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'users_share' => $this->user ? $this->user->name : 'Unknown',
            'comment_on_share' => ShowCommentShareResource::collection($this->commentShare),
            'count_comment' => $this->commentShare->count(), // Count comments
            'user_like' => ShowlikeShareResource::collection($this->likeShare),
            'count_like' => $this->likeShare->count(), // Count likes
        ];}
}
