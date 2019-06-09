<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfile extends FormRequest
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
            'attributes.name' => 'required|min:3|max:100',
            'attributes.description' => 'required|min:5|max:500',
            'attributes.site' => 'required|min:3|max:100',
            'attributes.phone' => 'required|min:3|max:20',
            'attributes.sex' => 'required|numeric|min:0|max:3',

            'relationships.user.attributes.name' => 'required|min:3|max:20',
            'relationships.user.attributes.email' => 'required|email|min:3|max:20',

        ];
    }


}
