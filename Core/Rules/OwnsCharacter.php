<?php

namespace Bitaac\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class OwnsCharacter implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $characters = auth()->user()->characters();

        return $characters->where(function ($query) use ($value) {
            $query->where('id', $value)->orWhere('name', $value);
        })->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected character do not belongs to your account.';
    }
}
