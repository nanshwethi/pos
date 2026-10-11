<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MenuResource extends JsonResource
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
            'slug' => $this->slug,
            'unit' => $this->unit,
            'price' => $this->price,
            'image' => $this->image ? asset(Storage::url($this->image)) : config("base.image_placeholder"),
            'category' => $this->category,
            'category_id' => $this->category_id,
            'user_id' =>  $this->user_id,
            'user' =>  $this->user,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
