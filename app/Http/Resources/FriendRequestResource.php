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
            'request_id'=> $this->id,
            'reciver' => $this->reciever->name,
            'status'=>$this->status,
            'Request Date'=>$this->created_at->format('d-m-Y'),
        ];
    }
}
