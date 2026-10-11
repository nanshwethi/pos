<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "address" => $this->address,
            "date_of_birth" => $this->date_of_birth,
            'image' => $this->image ? asset(Storage::url($this->image)) : config("base.image_placeholder"),
            "gender" => $this->gender,
            'user_id' =>  $this->user_id,
            'user' =>  $this->user,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
