<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlace extends FormRequest
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
            'attributes.coordinates' => 'required|array',
            'relationships.address' => 'sometimes|nullable|array',

            'attributes.title' => 'required|min:3|max:100',
            'attributes.intro' => 'required|min:3|max:199',
            'attributes.description' => 'required|min:5',
        ];
    }
    public function messages()
    {
        return [
            'relationships.coordinates.array' => __('action.request.idea_id_required'),
            'relationships.address_id.integer' => __('action.request.idea_id_required'),

        ];
    }
}
