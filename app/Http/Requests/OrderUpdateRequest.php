<?php

namespace App\Http\Requests;

use App\Models\Orders;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class   OrderUpdateRequest extends FormRequest
{
     /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'book_id' => ['required', 'integer', 'max:255'],
            // 'order_id' => ['required', 'integer', 'max:255'],
            // 'quantity' => ['required','integer', 'max:255'],            
         ];
    }
}