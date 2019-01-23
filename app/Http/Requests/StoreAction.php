<?php

namespace App\Http\Requests;

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
            'idea_id' => 'required|integer',
            'title' => 'required|min:3|max:100',
            'intro' => 'required|min:3|max:199',
            'description' => 'required|min:5',
            'active' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'idea_id.required' => __('action.request.idea_id_required'),
            'idea_id.integer' => __('action.request.idea_id_required'),
            'title.required' => __('action.request.title_required'),
            'title.min' => __('action.request.title_min'),
            'title.max' => __('action.request.title_max'),
        ];
    }
}
