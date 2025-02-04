<?php

namespace App\Http\Requests;

use App\Models\Books;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class   BookRequestUpdateRequest extends FormRequest
{
     /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
       return [];
        // return [
        //     'book_id' => ['required', 'integer', 'max:255'],
        //     'order_id' => ['required', 'integer', 'max:255'],
        //     'ordered' => ['required', 'integer', 'max:255'],
        // ];
    }
}