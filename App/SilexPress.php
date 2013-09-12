<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SilexPress extends \Silex\Application
{
    public function __construct(array $values = array())
    {
        parent::__construct($values);
        $this->register(new Configuration);
        $this->after(function(Request $req,Response $res){

        });
    }
}