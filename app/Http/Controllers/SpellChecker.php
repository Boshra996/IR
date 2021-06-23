<?php

namespace App\Http\Controllers;

use  PhpSpellcheck\Spellchecker\Aspell;

class SpellChecker
{

    public function spellCheck(string $query)
    {
        $newQueryHtml =  $query;
        $newQuery =  $query;

        $aspell = Aspell::create('C:\Program Files (x86)\Aspell\bin\aspell');
        $misspellings = $aspell->check($query, ['en_US'], ['from' => 'aspell spellchecker']);
        $misspellings =  iterator_to_array($misspellings);
        $limit = str_word_count($query) == 1 ? 5 : 1;
        if (count($misspellings) > 0) {
            foreach ($misspellings as $misspelling) {

                if ($limit == 1) {
                    $misspellingSuggestion = $misspelling->getSuggestions()[0];
                    $misspellingSuggestionHtml = $this->styleMisspelling($misspelling->getSuggestions()[0]);
                    $newQueryHtml = str_replace($misspelling->getWord(), $misspellingSuggestionHtml, $newQueryHtml);
                    $newQuery = str_replace($misspelling->getWord(), $misspellingSuggestion, $newQuery);
                } else {
                    $suggestions =  array_slice($misspelling->getSuggestions(), 0, $limit);
                    $result =  [];
                    foreach ($suggestions as $suggestion) {
                        array_push($result, [
                            "new_query" => $suggestion,
                            "new_query_html" => $this->styleMisspelling($suggestion)
                        ]);
                    }
                    return $result;
                }
                // print_r([
                //     $misspelling->getWord(), // 'mispell'
                //     // // $misspelling->getLineNumber(), // '1'
                //     // $misspelling->getOffset(), // '0'
                //     array_slice($misspelling->getSuggestions(), 0, $limit), // ['misspell', ...]
                //     // $misspelling->getContext(), // ['from' => 'aspell spellchecker']
                // ]);
                // print('----');

            }
            return [[
                "new_query" => $newQuery,
                "new_query_html" => $newQueryHtml
            ]];
        }
        return null;
    }

    function styleMisspelling($misspelling)
    {
        // return  $style = "<strong style='font-style:italic'>$misspelling</strong>";
        return  $style = "<b><i>$misspelling</b></i>";
    }
}
