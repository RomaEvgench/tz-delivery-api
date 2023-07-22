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
            'return_point' => 'required',
            'return_point.address' => 'required | string | min: 1 | max: 256',
            'return_point.receiver_name' => 'required | string | min: 1 | max: 256',
            'return_point.receiver_phone' => 'required | string | min: 12 | max: 12',

            'pickup_point' => 'required',
            'pickup_point.address' => 'required | string | min: 1 | max: 256',
            'pickup_point.sender_name' => 'required | string | min: 1 | max: 256',
            'pickup_point.sender_phone' => 'required | string | min: 12 | max: 12',

            'deliveries' => 'required | array | min: 1',
            'deliveries.*.address' => 'required | string | min: 1 | max: 256',
            'deliveries.*.receiver_name' => 'required | string | min: 1 | max: 256',
            'deliveries.*.receiver_phone' => 'required | string | min: 12 | max: 12',

            'deliveries.*.cargo' => 'required | array | min: 1',
            'deliveries.*.cargo.*.name' => 'required | string | min: 1 | max: 256',
            'deliveries.*.cargo.*.weight' => 'required | integer | min: 1 | max: 1000',
            'deliveries.*.cargo.*.size' => 'required | string | min: 6 | max: 256',

            'price' => 'required | integer | min: 1 | max: 1000000',
        ];
    }
}
