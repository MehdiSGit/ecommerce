<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class CentimesTransformer implements DataTransformerInterface 
{
    public function transform($value)
    {
        function ($value) {
            if($value === null) {
                return;
            }
            return $value / 100;
        };
    }

    public function reverseTransform($value)
    {
        function ($value) {
            if($value === null) {
                return;
            }
            return $value * 100;
        };
    }
}