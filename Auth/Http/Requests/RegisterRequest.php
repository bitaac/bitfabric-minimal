<?php

namespace Bitaac\Auth\Http\Requests;

use Bitaac\Traits\Overwriteable;
use Bitaac\Core\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    use Overwriteable;

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
            'name'     => ['required', 'between:4,23', 'alpha_num', 'unique:accounts,name'],
            'email'    => ['required', 'email', 'unique:accounts'],
            'password' => ['required', 'confirmed', 'min:6', 'max:255'],
            'terms'    => ['accepted'],
        ];
    }
}
