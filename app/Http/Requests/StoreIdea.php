<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIdea extends FormRequest
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
            'main_category_id' => 'required|integer',
            'title' => 'required|min:3|max:100',
            'intro' => 'required|min:3|max:199',
            'description' => 'required|min:5',
            'categories' => 'required|array',
            'categories.*.id' => 'integer',

            'active' => 'required|integer',

        ];
    }
    public function messages()
    {

        return [
            'main_category_id.required' => __('category.main_category_id.required'),
            'main_category_id.integer' => __('category.main_category_id.integer'),
            'title.required' => __('category.title.required'),
            'title.min' => __('category.title.min'),
            'title.max' => __('category.title.max'),



        ];
    }
}
