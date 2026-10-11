<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
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
            'voucher_number' => $this->voucher_number,
            'customer_id' => $this->customer_id,
            'customer' => $this->customer,
            'type' => $this->type,
            'voucher_items' => $this->voucherItems->pluck('menu.title'),
            'quantity' => $this->voucher_items_count,
            'total' => $this->total,
            'served_by' => $this->user->name,
            'date' => $this->date,
            'user_id' =>  $this->user_id,
            'user' =>  $this->user,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
