<?php

namespace App\Http\Controllers;

use markfullmer\porter2\Porter2;

class Stemmer
{
    public function stem(array $tokens): array
    {

        $result =  array();
        foreach ($tokens as $token) {
            $stemmedToken = Porter2::stem($token);
            array_push($result, $stemmedToken);
        }
        return $result;
    }
}
