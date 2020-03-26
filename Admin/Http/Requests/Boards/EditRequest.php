<?php

namespace Bitaac\Admin\Http\Requests\Boards;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
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
            'title'       => ['required', 'max:50'],
            'order'       => ['digits_between:0,2'],
            'description' => ['max:150'],
        ];
    }
}
