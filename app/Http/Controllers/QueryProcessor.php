<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentWord;
use App\Models\Word;
use Symfony\Component\VarDumper\VarDumper;

class QueryProcessor
{
    protected $tokenizer;
    protected $removalStopWords;
    protected $stemmer;

    public function __construct()
    {
        set_time_limit(60 * 10);
        // ini_set("max_execution_time", 1000 * 10 * 24);
        ini_set("memory_limit", "-1");

        $this->tokenizer   = new Tokenizer();
        $this->removalStopWords = new StopWords();
        $this->stemmer = new Stemmer();
    }



    public function indexingQuery($query)
    {

        $content = $query;
        $tokens = $this->tokenizer->tokenize($content);
        $tokensWithOutStopWords =  $this->removalStopWords->removeStopWords($tokens);
        $stemmedTokens = $this->stemmer->stem($tokensWithOutStopWords);

        //calcuate TF weight of word
        $tfArray = [];
        $maxFreq = 0;
        foreach ($stemmedTokens as $token) {
            if (!isset($tfArray[$token]))
                $tfArray[$token] = 1;
            else
                $tfArray[$token]++;
            $maxFreq = max($maxFreq, $tfArray[$token]);
        }

        foreach ($tfArray as $token => $freq) {
            $tfArray[$token] /= $maxFreq;
        }

        $weightsQuery = $this->getQueryWeights($tfArray);
        $queryLength = $this->queryLength($weightsQuery);
        $simArray = $this->setSimalirty($weightsQuery, $queryLength);
        $array = collect($simArray)->sortBy('sim')->reverse()->toArray();
        return $array;
    }

    public function getQueryWeights($tfArray): array
    {
        foreach ($tfArray as $token => $tf) {

            $word = Word::where('name', $token)->first();
            if ($word)
                $tfArray[$token] = $word->idf * $tf;
            else
                $tfArray[$token] = 0;
        }
        return $tfArray;
    }




    public function queryLength($queryWeights)
    {
        $sum = 0;
        foreach ($queryWeights as $token => $weight) {
            $sum +=  ($weight * $weight);
        }
        return sqrt($sum);
    }

    public function setSimalirty($queryWeights, $queryLength)
    {
        $result = [];
        $documents = $this->getDocuments();
        foreach ($documents as $doc) {
            $docLength = $doc->length;
            $baset = $this->innerproduct($queryWeights, $doc);
            $under = $docLength * $queryLength;
            if ($under != 0) {
                $sim = $baset / $under;
                if ($sim > 0) {
                    $data = ["doc" => $doc, "sim" => $sim];
                    array_push($result, $data);
                }
            }
        }
        return $result;
    }

    public function innerproduct($queryWeights, $doc)
    {
        $based  = 0;
        foreach ($queryWeights as $token => $weight) {
            $word = $this->querDocumentsToken($doc, $token);
            if ($word)
                $based += $weight * $word->weight;
        }

        return $based;
    }

    public function querDocumentsToken($doc, $token)
    {
        $word = DocumentWord::with('word')
            ->whereHas('word', function ($q) use ($token) {
                $q->where('name', $token);
            })
            ->where('document_id', $doc->id)
            ->first();
        return $word;
    }

    public function getDocuments()
    {
        $documents = Document::all();
        return $documents;
    }
}
