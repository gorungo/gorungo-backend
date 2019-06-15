<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Auth;
use App\User;

class SetNewPassword extends FormRequest
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
            //'old_password' => 'required',
            'password'     => 'required|min:6|confirmed',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if(!Gate::forUser(Auth()->user())->allows('edit-all')){
                if(!request()->has('old_password') || request()->old_password == ''){
                    $validator->errors()->add('old_password', $this->messages()['old_password.required']);
                }
            }

            if ( !Auth::attempt( [
                    'email'    => request()->email,
                    'password' => request()->old_password,
                ] )) {

                if(!Gate::forUser(Auth()->user())->allows('edit-all')){
                    $validator->errors()->add('old_password', $this->messages()['old_password.bad_credentials']);
                }
            }



        });

    }

    public function messages()
    {

        return [
            'old_password.required' => 'укажите ваш старый пароль',
            'password.required'     => 'укажите новый пароль',
            'password.min'          => 'Минимальная длина пароля 6 символов',
            'password.confirmed'    => 'пароли должны совпадать',
            'old_password.bad_credentials' => 'вы ввели неправильный старый пароль'

        ];
    }
}
