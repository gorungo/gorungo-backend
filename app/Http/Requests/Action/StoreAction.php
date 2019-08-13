<?php

namespace App\Http\Requests\Action;

use Illuminate\Foundation\Http\FormRequest;

class StoreAction extends FormRequest
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
            'relationships.idea.id' => 'required|integer',
            'relationships.places' => 'array|required',

            'attributes.title' => 'required|min:3|max:100',
            'attributes.intro' => 'required|min:3|max:199',
            'attributes.description' => 'required|min:5',
            'attributes.active' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'relationships.idea.id.required' => __('action.request.idea_id_required'),
            'relationships.idea.id.integer' => __('action.request.idea_id_required'),

            'attributes.title.required' => __('action.request.title_required'),
            'attributes.title.min' => __('action.request.title_min'),
            'attributes.title.max' => __('action.request.title_max'),

            'attributes.intro.required' => __('action.request.intro_required'),
            'attributes.intro.min' => __('action.request.intro_min'),
            'attributes.intro.max' => __('action.request.intro_max'),

            'attributes.description.required' => __('action.request.description_required'),
            'attributes.description.min' => __('action.request.description_min'),
            'attributes.description.max' => __('action.request.description_max'),
        ];
    }
}
