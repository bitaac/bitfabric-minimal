<?php

namespace Bitaac\Core\Configurations;

class TwoFactorAuthConfiguration
{
    /**
     * Holding the two factor authentication enalbed/disabled value.
     *
     * @var boolean
     */
    protected $enabled = false;

    /**
     * Enable account two factor authentication.
     *
     * @return void
     */
    public function enable()
    {
        $this->enabled = true;
    }

    /**
     * Disable account two factor authentication.
     *
     * @return void
     */
    public function disable()
    {
        $this->enabled = false;
    }

    /**
     * Determine if the two factor authentication is enabled.
     *
     * @return boolean
     */
    public function enabled()
    {
        return $this->enabled;
    }

    /**
     * Determine if the two factor authentication is disabled.
     *
     * @return boolean
     */
    public function disabled()
    {
        return $this->enabled === false;
    }
}
