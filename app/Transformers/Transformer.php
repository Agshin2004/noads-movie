<?php

namespace App\Transformers;

interface Transformer
{
    public static function transform(array $items);
}