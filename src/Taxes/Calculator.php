<?php

namespace App\Taxes;

Class Calculator
{
    public function calcul(float $prix) : float
    {
        return $prix * (20 /100);
    }
}