<?php

namespace Mparaiso\SilexPress\Core\Model {

    use ArrayObject;

    abstract class Base extends ArrayObject
    {

        function __get($attr)
        {
            if (isset($this[$attr])) {
                return $this[$attr];
            }
        }

        function __set($attr, $val)
        {
            $this[$attr] = $val;
        }

        function __toString()
        {
            return $this->_id;
        }


    }
}