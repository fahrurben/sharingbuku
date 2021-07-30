<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'desc' => $this->desc,
            'author' => $this->author,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->category),
            'isbn' => $this->isbn,
            'image' => $this->image,
            'is_available' => $this->is_available,
            'is_logged_in_user_owned' => $this->is_logged_in_user_owned,
        ];
    }
}
