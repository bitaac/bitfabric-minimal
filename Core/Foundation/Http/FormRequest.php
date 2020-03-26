<?php

namespace Bitaac\Core\Foundation\Http;

use Bitaac;
use Bitaac\Traits\Overwriteable;
use Illuminate\Foundation\Http\FormRequest as Base;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class FormRequest extends Base
{
    /**
     * Overide and/or add new validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'in_config_key'  => 'in_config_key validation error',
            'in_config'      => 'in_config validation error',
        ];
    }

    /**
     * Create the default validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Factory  $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createDefaultValidator(ValidationFactory $factory)
    {
        if (isset(class_uses($this)['Bitaac\Traits\Overwriteable']) && Bitaac::hasRules($this)) {
            $rules = Bitaac::getRules($this);
        } else {
            $rules = $this->container->call([$this, 'rules']);
        }

        return $factory->make(
            $this->validationData(), $rules,
            $this->messages(), $this->attributes()
        );
    }
}
