<?php

namespace Bitaac\Auth\Http\Requests;

use Bitaac\Traits\Overwriteable;
use Bitaac\Core\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'account'  => ['required'],
            'password' => ['required'],
        ];
    }
}
