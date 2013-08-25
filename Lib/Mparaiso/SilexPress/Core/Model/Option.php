<?php

namespace Mparaiso\SilexPress\Core\Model {


    class Option extends Base
    {
        /**
         * @param Boolean $autoload
         */
        public function setAutoload($autoload)
        {
            $this['autoload'] = $autoload;
        }

        /**
         * @return Boolean
         */
        public function getAutoload()
        {
            return $this['autoload'];
        }

        /**
         * @param string $option_name
         */
        public function setOptionName($option_name)
        {
            $this['option_name'] = $option_name;
        }

        /**
         * @return string
         */
        public function getOptionName()
        {
            return $this['option_name'];
        }

        /**
         * @param mixed $option_value
         */
        public function setOptionValue($option_value)
        {
            $this['option_value'] = $option_value;
        }

        /**
         * @return mixed
         */
        public function getOptionValue()
        {
            return $this['option_value'];
        }

        /**
         * @return string
         */
        public function getId()
        {
            return $this['_id'];
        }

        /**
         * @param string $id
         */
        public function setId($id)
        {
            $this['_id'] = $id;
        }
    }
}