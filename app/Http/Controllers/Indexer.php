<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentWord;
use App\Models\Word;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;

class Indexer
{
    protected $tokenizer;
    protected $removalStopWords;
    protected $stemmer;
    protected $limmatizer;


    public function __construct()
    {
        set_time_limit(60 * 30);
        // ini_set("max_execution_time", 1000 * 10 * 24);
        ini_set("memory_limit", "-1");

        $this->tokenizer   = new Tokenizer();
        $this->removalStopWords = new StopWords();
        $this->stemmer = new Stemmer();
        $this->limmatizer = new  Lemmatizer() ;
    }

    public function initDB()
    {
        DB::statement('set foreign_key_checks = 0 ;');
        Document::truncate();
        Word::truncate();
        DocumentWord::truncate();
        DB::statement('set foreign_key_checks = 1 ;');
    }

    public function indexingDocuments()
    {
        $this->initDB();

        $path = public_path('corpus');
        $files = FacadesFile::allFiles($path);

        foreach ($files  as $file) {
            $fileName = $file->getFilename();
            $filePath = $file->getRealPath();
            $doc = Document::where("name", $fileName)->first();
            if (!$doc)
                $this->indexingDocument($filePath, $fileName);
        }
        $this->setIdfs();
    }

    public function indexingDocument($filePath, $fileName)
    {
        $content = file_get_contents($filePath);
        $tokens = $this->tokenizer->tokenize($content);
        $tokensWithOutStopWords =  $this->removalStopWords->removeStopWords($tokens);
        $lemmatizeToken = $this->limmatizer->Lemmatize($tokensWithOutStopWords);
        $stemmedTokens = $this->stemmer->stem($lemmatizeToken);


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
        $this->saveFileInfo($fileName, $tfArray);
        // var_dump($tfArray);
        // var_dump($maxFreq);
        // die;
    }

    public function saveFileInfo($fileName, $tfArray)
    {
        $document = Document::create(
            [
                "name" => $fileName,
                "length" => 0,
            ]
        );

        foreach ($tfArray as $token => $tf) {
            $word = Word::firstOrCreate(
                [
                    "name" => $token,
                    "idf" => 0,
                ]
            );
            DocumentWord::create(
                [
                    "tf" => $tf,
                    "document_id" => $document->id,
                    "word_id" =>  $word->id,
                    "weight" =>  0,
                ]
            );
        }
    }

    public function setIdfs()
    {
        $documnets = $this->getDocuments();
        $tokens = $this->getTokens();
        $documnentsCount = count($documnets);

        foreach ($tokens as $name => $word) {
            $tokenDocumentsCount = count($word->documents);
            $word->idf = log($documnentsCount / $tokenDocumentsCount, 2);
            DB::update("update document_words  set weight = $word->idf * tf where word_id = $word->id ;");
            $word->save();
        }

        $this->setLength($documnets);
    }

    public function getTokens()
    {
        $words = Word::with('documents')->get()->keyBy("name");
        return $words;
    }
    public function getDocuments()
    {
        $documents = Document::all();
        return $documents;
    }

    public function setLength($documents)
    {
        foreach ($documents as $doc) {
            $result = DB::select("SELECT sqrt(sum( weight * weight)) as length from document_words where document_id = $doc->id");
            $doc->length = $result[0]->length ?? 0;
            $doc->save();
        }
    }
}
