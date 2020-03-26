<?php

namespace Bitaac\Guild\Http\Requests\Guild;

use Bitaac\Traits\Overwriteable;
use Bitaac\Core\Foundation\Http\FormRequest;

class DisbandRequest extends FormRequest
{
    use Overwriteable;
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => ['required'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
