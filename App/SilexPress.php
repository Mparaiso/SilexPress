<?php

class SilexPress extends \Silex\Application
{
    public function __construct(array $values = array())
    {
        parent::__construct($values);
        $this->register(new Configuration);
    }
}