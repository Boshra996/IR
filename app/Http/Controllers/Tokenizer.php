<?php

namespace App\Http\Controllers;


class Tokenizer
{

    protected $pattern = '/[^\p{L}\p{N}\p{Pc}\p{Pd}@]+/u';

    public function tokenize(string $text): array
    {
        $text  = mb_strtolower($text);
        $split = preg_split($this->pattern, $text, -1, PREG_SPLIT_NO_EMPTY);
        return $split;
    }
}
