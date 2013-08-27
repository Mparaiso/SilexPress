<?php

namespace Mparaiso\SilexPress\Core\Form\Extension;

use Mparaiso\SilexPress\Core\Form\Type\MongoChoiceType;
use Symfony\Component\Form\AbstractExtension;

class SilexPressExtension extends AbstractExtension
{
    protected $mongoDB;

    function __construct(\MongoDB $mongoDB)
    {
        $this->mongoDB = $mongoDB;
    }

    function loadTypes()
    {
        return array(
            new MongoChoiceType($this->mongoDB),
        );
    }

    /*
    function loadTypeExtensions()
    {
        return array(
            new MongoChoiceTypeExtension($this->mongoDB),
        );
    }
    */
}
