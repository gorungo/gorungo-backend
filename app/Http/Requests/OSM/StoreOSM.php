<?php

namespace App\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;

class StoreOSM extends FormRequest
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
        return [];
    }
    public function messages()
    {
        return [
            'relationships.coordinates.array' => __('action.request.idea_id_required'),
            'relationships.address_id.integer' => __('action.request.idea_id_required'),
            'relationships.placeType.id.required' => __('action.request.place_type_id_required'),

        ];
    }
}
