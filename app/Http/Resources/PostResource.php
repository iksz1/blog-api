<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PostResource extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => htmlspecialchars($this->title),
            // 'teaser' => $this->teaser,
            'body' => htmlspecialchars($this->body),
            'author' => new UserResource($this->user),
            'category' => new CategoryResource($this->category),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'deleted' => $this->deleted_at ? true : false,
            'link' => route('article', ['id' => $this->id]),
        ];
    }
}