<?php

namespace Mparaiso\SilexPress\Core\Service;

/**
 * Manage Options
 * Class Option
 * @package Mparaiso\SilexPress\Core\Service
 */
class Option extends Base
{
    protected $options;

    /** get an option by name */
    function get($name)
    {
        if (!$this->options) {
            $this->options = $this->findOneBy(array());
        }
        if (isset($this->options[$name]))
            return $this->options[$name];
    }
}
