<?php

namespace Mparaiso\SilexPress\Core\Form\Extension;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class StringToArraydDataTransformer
 * @package Mparaiso\SilexPress\Core\Form\Extension
 * Transform a string separated with commas into an array of strings
 */
class StringToArraydDataTransformer implements DataTransformerInterface
{


    public function transform($value)
    {
        if (!$value) return;
        return implode(",", $value);
    }


    public function reverseTransform($value)
    {
        if (!$value) return;
        return array_map(function ($element) {
            return trim($element);
        }, explode(",", $value));

    }
}
