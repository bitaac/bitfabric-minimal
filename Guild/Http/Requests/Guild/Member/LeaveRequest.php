<?php

namespace Bitaac\Guild\Http\Requests\Guild\Member;

use Bitaac\Traits\Overwriteable;
use Bitaac\Core\Rules\OwnsCharacter;
use Bitaac\Core\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
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
            'character' => ['required', 'integer', new OwnsCharacter],
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
