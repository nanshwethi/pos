<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => [
                'nullable',
                'integer',
                'exists:customers,id',
            ],

            'voucher_number' => [
                'required',
                'min:5',
                'unique:vouchers'
            ],

            'date' => [
                'required',
                'date',
            ],

            'cash' => [
                'required',
                'integer',
                'min:0',
            ],
            'change' => [
                'required',
                'integer',
                'min:0',
            ],
            'type' => [
                'required',
                Rule::in(config('base.sale_type')),
            ],

            'voucher_items' => [
                'required',
                'array',
                'min:1',
            ],

            'voucher_items.*.menu_id' => [
                'required',
                'integer',
                'exists:menus,id',
            ],
            'voucher_items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }
}
