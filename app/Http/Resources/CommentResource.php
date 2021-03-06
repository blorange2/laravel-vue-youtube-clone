<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request                                        $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'body' => $this->body,
            'created_at' => $this->created_at->toDateTimeString(),
            'created_at_human' => $this->created_at->diffForHumans(),
            'channel' => (new ChannelResource($this->commentable->channel)),
            'replies' => CommentResource::collection($this->replies)

        ];
    }
}
