<?php

namespace Mparaiso\SilexPress\Core\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class StringToArraydDataTransformer
 * @package Mparaiso\SilexPress\Core\Form\Extension
 * Transform a string separated with commas into an array of strings
 */
class StringToHashdDataTransformer implements DataTransformerInterface
{


    public function transform($value)
    {
        if (!$value) return;
        return json_encode($value);
    }


    public function reverseTransform($value)
    {
        if (!$value) return;
        return json_decode($value, true);

    }
}
