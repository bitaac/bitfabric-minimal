<?php

namespace Bitaac\Guild\Http\Requests\Guild\Member;

use Bitaac\Traits\Overwriteable;
use Bitaac\Core\Foundation\Http\FormRequest;

class CancelRequest extends FormRequest
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
            'character' => ['required', 'integer'],
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
