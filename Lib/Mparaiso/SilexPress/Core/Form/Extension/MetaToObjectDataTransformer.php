<?php

namespace Mparaiso\SilexPress\Core\Form\Extension;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class StringToArraydDataTransformer
 * @package Mparaiso\SilexPress\Core\Form\Extension
 * {key:value} to {name:key,value:value}
 */
class MetaToObjectDataTransformer implements DataTransformerInterface
{


    public function transform($input)
    {
        $result = array();
        if (!$input || !is_array($input)) return;
        foreach ($input as $key => $value) {
            $o = array();
            $o['name'] = $key;
            $o['value'] = $value;
            $result[$key] = $o;
        }
        return $result;
    }

    public function reverseTransform($input)
    {
        if (!$input) return;
        $result = array();
        foreach ($input as $value) {
            $result[$value['name']] = $value["value"];
        }
        return $result;

    }
}
