<?php

namespace App\Http\Controllers;

use writecrow\Lemmatizer\Lemmatizer as LemmatizerLemmatizer;

class Lemmatizer extends Controller
{
    public function Lemmatize(array $stemmedTokens): array
    {

        $result =  array();

        foreach ($stemmedTokens as $token) {
            $lemmatizerToken = LemmatizerLemmatizer::getLemma($token);
            array_push($result, $lemmatizerToken);
        }

        return $result;
    }
}
