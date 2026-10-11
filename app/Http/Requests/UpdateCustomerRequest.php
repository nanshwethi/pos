<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
        $customerId = $this->route('customer')?->id;

        return [
            "name" => "sometimes|string|max:255",
            "email" => "sometimes|email",
            "phone" => "sometimes|string|max:255|unique:customers,phone,$customerId",
            "address" => "sometimes|string",
            "gender" => "sometimes|in:" . implode(',', config('base.gender')),
            "date_of_birth" => "sometimes|date",
            "image" => "nullable|string"
        ];
    }
}
