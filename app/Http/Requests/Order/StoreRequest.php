<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'return_point' => 'required | array',
            'pickup_point' => 'required | array',
            'price' => 'required | integer',
            'deliveries' => 'required | array',
            'deliveries.*.cargo' => 'required | array | min:1',
        ];
    }
}
