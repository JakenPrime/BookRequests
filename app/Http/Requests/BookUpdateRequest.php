<?php

namespace App\Http\Requests;

use App\Models\Books;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class   BookUpdateRequest extends FormRequest
{
     /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'author' => ['string', 'max:255'],
            'isbn' => ['required', 'string', 'max:255', Rule::unique(Books::class)->ignore($this->user()->id)],
        ];
    }
}