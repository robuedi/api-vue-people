<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class PersonStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'    => 'required|max:255|min:1',
            'last_name'     => 'required|max:255|min:1',
            'phone'         => 'required|max:255|min:1',
            'email'         => 'required|max:255|min:1',
            'city'          => 'required|max:255|min:1'
        ];
    }
}
