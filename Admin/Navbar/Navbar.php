<?php

namespace Bitaac\Admin\Navbar;

use Closure;
use Bitaac\Admin\Navbar\Link;

class Navbar
{
    /**
     * Holds the registered children.
     *
     * @var array
     */
    public $children = [];

    /**
     * Get all the registered navbar links.
     *
     * @return Array
     */
    public function getLinks()
    {
        return $this->children;
    }

    /**
     * Register a new single/dropdown navbar link.
     *
     * @param  string  $text
     * @param  text    $route
     * @return void
     */
    public function register($label, $route)
    {
        if (! ($route instanceof Closure)) {
            return array_push($this->children, new Link($label, $route));
        }

        $collection = new static;

        call_user_func_array($route, [ &$collection ]);

        array_push($this->children, new Link($label, $collection->children));
    }
}
