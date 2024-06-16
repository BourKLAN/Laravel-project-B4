<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FriendRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'request_id' => $this->id,
            'receiver' => $this->reciever ? $this->reciever->name : 'Unknown',
            'status' => $this->status,
            'request_date' => $this->created_at->format('d-m-Y'),
        ];
    }
}
