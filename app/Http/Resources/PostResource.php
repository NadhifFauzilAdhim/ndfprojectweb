<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'slug' => $this->slug,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category' => [
                'name' => $this->category->name,
                'slug' => $this->category->slug,
                'image' => $this->category->image
            ],
            'author' => [
                'name' => $this->author->name,
                'username' => $this->author->username,
                'avatar' => $this->author->avatar,
            ],
        ];
    }
}
