<?php

namespace App\Http\Resources\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Event $this */
        return [
            'id' => $this->id,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'user' => new UserResource($this->whenLoaded('user')),
            'Attendees' => AttendeesResource::collection(
               $this->whenLoaded('attendees')),
        ];
    }
}
