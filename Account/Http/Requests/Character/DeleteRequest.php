<?php

namespace Bitaac\Account\Http\Requests\Character;

use Bitaac\Traits\Overwriteable;
use Bitaac\Core\Rules\OwnsCharacter;
use Bitaac\Core\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    use Overwriteable;
    
    public function rules()
    {
        return [
            'character' => ['bail', 'required', 'exists:players,name', new OwnsCharacter],
            'password'  => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
