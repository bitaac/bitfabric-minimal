<?php

namespace Bitaac\Core;

use Closure;

class Bitaac
{
    /**
     * Holding all the extended class methods.
     *
     * @var array
     */
    protected static $extended = [];

    /**
     * Holding the account name field.
     *
     * @var string
     */
    protected $accountNameField = 'name';

    /**
     * Holding the account password field.
     *
     * @var string
     */
    protected $accountPasswordField = 'password';

    /**
     * Holding the account creation field.
     *
     * @var string
     */
    protected $accountCreationField = 'creation';

    /**
     * Holding all overwritten rules.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Extend given class method.
     *
     * @param  string   $namespace
     * @param  closure  $callback
     * @return void
     */
    public static function extend($namespace, Closure $callback)
    {
        static::$extended[$namespace] = $callback;
    }

    /**
     * Get all the extended class methods.
     *
     * @param  null|string  $namespace
     * @return array
     */
    public static function extended($namespace = null)
    {
        return is_null($namespace) ? static::$extended : static::$extended[$namespace];
    }

    /**
     * Set the account name field.
     *
     * @return string
     */
    public function setAccountNameField($field)
    {
        $this->accountNameField = $field;
    }

    /**
     * Get the account name field.
     *
     * @return string
     */
    public function getAccountNameField()
    {
        return $this->accountNameField;
    }

    /**
     * Set the account password field.
     *
     * @return string
     */
    public function setAccountPasswordField($field)
    {
        $this->accountPasswordField = $field;
    }

    /**
     * Get the account password field.
     *
     * @return string
     */
    public function getAccountPasswordField()
    {
        return $this->accountPasswordField;
    }

    /**
     * Set the account creation field.
     *
     * @return string
     */
    public function setAccountCreationField($field)
    {
        $this->accountCreationField = $field;
    }

    /**
     * Get the account creation field.
     *
     * @return string
     */
    public function getAccountCreationField()
    {
        return $this->accountCreationField;
    }

    /**
     * Get the two factor authentication configurator instance.
     *
     * @return \Bitaac\Core\Configurations\TwoFactorAuthConfiguration
     */
    public function twofa()
    {
        return resolve(\Bitaac\Core\Configurations\TwoFactorAuthConfiguration::class);
    }

    /**
     * Overwrite validation rules to given request.
     *
     * @return void
     */
    public function rules($request, $closure)
    {
        $this->rules[$request] = $closure;
    }

    /**
     * Determine if given request rules has been overwritten.
     *
     * @return true
     */
    public function hasRules($request)
    {
        $class = get_class($request);

        return isset($this->rules[$class]);
    }

    /**
     * Get the given requeest overwritten rules.
     *
     * @return true
     */
    public function getRules($request)
    {
        $class = get_class($request);

        return $this->hasRules($request) ? call_user_func_array($this->rules[$class], [$request]) : [];
    }

    /**
     * Get given database field value.
     *
     * @param  string  $field
     * @return mixed
     */
    public function get($field)
    {
        return \Bitaac\Core\Models\Bitaac::firstOrCreate([
            'id' => 1,
        ])->{$field};
    }

    /**
     * Set given database fields value.
     *
     * @param  array  $fields
     * @return void
     */
    public function set($fields)
    {
        \Bitaac\Core\Models\Bitaac::firstOrCreate([
            'id' => 1,
        ])->update($fields);
    }
}
