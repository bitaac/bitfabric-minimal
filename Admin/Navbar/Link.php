<?php

namespace Bitaac\Admin\Navbar;

class Link
{
    /**
     * Create a new link instance.
     *
     * @param  string  $label
     * @param  string  $route
     * @return void
     */
    public function __construct($label, $route)
    {
        $this->label = $label;
        $this->route = $route;
    }

    /**
     * Get the link label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the link route.
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Determine if the link is a dropdown.
     *
     * @return boolean
     */
    public function isDropdown()
    {
        return is_array($this->route);
    }
}
