<?php

namespace Bitaac\Forum\Http\Requests\Thread;

use Bitaac\Traits\Overwriteable;
use Bitaac\Core\Rules\OwnsCharacter;
use Bitaac\Core\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    use Overwriteable;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'title'   => ['required', 'between:3,60', 'forum_title'],
            'author'  => ['required', new OwnsCharacter],
            'content' => ['required', 'between:15,15000'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function authorize()
    {
        return true;
    }
}
