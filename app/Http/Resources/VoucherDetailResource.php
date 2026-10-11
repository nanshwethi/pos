<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherDetailResource extends JsonResource
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
            'date' => $this->date,
            'total' => $this->total,
            'tax' => $this->tax,
            'net_total' => $this->net_total,
            'cash' => $this->cash,
            'change' => $this->change,
            'voucher_items_count' => $this->voucher_items_count,
            'user_id' => $this->user_id,
            'user' => $this->user,
            'type' => $this->type,
            'voucher_items' => VoucherItemResource::collection($this->voucherItems),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
