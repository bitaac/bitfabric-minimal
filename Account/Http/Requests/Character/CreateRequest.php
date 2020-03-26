<?php

namespace Bitaac\Account\Http\Requests\Character;

use Bitaac\Traits\Overwriteable;
use Bitaac\Core\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name'     => ['required', 'between:3,20', 'charname', 'blacklisted', 'unique:players,name'],
            'gender'   => ['required', 'in_config:bitaac.character.create-genders'],
            'vocation' => ['required', 'in_config:bitaac.character.create-vocations'],
            'town'     => ['required', 'in_config:bitaac.character.create-towns'],
        ];
    }
}
