<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Date;

// Remove pattern + put all words in lower case
class Tokenizer
{

    protected $pattern = '/[^\p{L}\p{N}\p{Pc}\p{Pd}@]+/u';

    public function tokenize(string $text): array
    {
        $text  = mb_strtolower($text);
        $text = $this->replaceDate($text);

        $string = preg_replace('/^[ \t]*[\r\n]+/m', '', $text);
        $newString = $this->replacePunctuationMarks($string);
        $parts = explode(' ', strtolower(str_replace(array("\r", "\n"), '', $newString)));
        return $parts;
        // $text  = mb_strtolower($text);
        // $split = preg_split($this->pattern, $text, -1, PREG_SPLIT_NO_EMPTY);
        // return $split;
    }




    private function replacePunctuationMarks($string, $char = ' ')
    {
        // # to keep letters & numbers
        $string = preg_replace('/[^a-z0-9$ƒ¥£€]+/i', $char, $string); # or...
        // $string = preg_replace('/[^a-z\d]+/i', $char, $string);
        $string = trim(preg_replace('/\s\s+/', ' ', $string));
        // $string = trim(preg_replace('!\s+!', ' ', $string));
        return $string;
    }



    private function replaceDate($text): string
    {
        $daysuf = "st|nd|rd|th";
        $dd = "([0-2]?[0-9]|3[01])($daysuf)?";
        $mm = "(0?[0-9]|1[0-2])";
        $m = "(january|february|march|april|may|june|july|august|september|october|november|december|jan|feb|mar|apr|may|jun|jul|aug|sep|sept|oct|nov|dec)";
        $mmm = "($m|$mm)";
        // $y = "[0-9]{1,4}";
        $y = "[0-9]{4}";
        $space = '[-\/.]';
        $p1 = "/$dd$space$mmm$space$y/";
        $p2 = "/$y$space$mmm$space$dd/";
        $res = preg_replace_callback(
            [$p1, $p2],
            function ($matchedDate) {
                $dateStr = $matchedDate[0];

                $date = new Date($dateStr);
                $time = strtotime($dateStr);
                $month = date("F", $time);
                $year = date("Y", $time);
                $day = date("l", $time);

                return "$day $month $year";
            },
            $text,
            -1,
            $count
        );

        return $res;
    }
}
