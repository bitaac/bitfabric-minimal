<?php

namespace Bitaac\Guild\Http\Requests\Guild\Rank;

use Bitaac\Traits\Overwriteable;
use Bitaac\Core\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'name' => ['required', 'between:3,15', 'rankname'],
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
