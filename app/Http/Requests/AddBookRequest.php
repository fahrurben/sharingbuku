<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_new' => 'required',
            'book_id' => 'required_if:is_new,false|nullable',
            'title' => 'required_if:is_new,true|nullable',
            'author' => 'required_if:is_new,true|nullable',
            'category_id' => 'required_if:is_new,true|nullable',
            'isbn' => 'required_if:is_new,true|nullable',
        ];
    }
}
