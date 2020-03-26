<?php

namespace Bitaac\Guild\Http\Requests\Guilds;

use Bitaac\Traits\Overwriteable;
use Bitaac\Core\Rules\OwnsCharacter;
use Bitaac\Core\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name'   => ['required', 'alpha_space', 'max_words:3', 'unique:guilds,name'],
            'leader' => ['required', new OwnsCharacter, 'guildless'],
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
