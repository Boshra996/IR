<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function __construct()
    {
        // set_time_limit(60 * 10);
        // ini_set("max_execution_time", 1000 * 10 * 24);
        // ini_set("memory_limit", "-1");
    }

    public function index()
    {
        return view('searchFile');
    }

    public function search(Request $request)
    {

        $data = [];
        $query = $request->input("query");
        $queryProcessor = new QueryProcessor();
        $result =  $queryProcessor->indexingQuery($query);
        $data["query"] = $query;
        $data["result"] =  $result;
        return Response::view('searchFile', compact("data"));
    }

    public function addDocumentForm()
    {
        return Response::view('addFile');
    }

    public function addDocument(Request $request)
    {
        $file =  $request->file("file");
        $file->move("corpus", $file->hashName());
        return Redirect::to("indexing");
    }

    public function indexing()
    {
        $executionStartTime = microtime(true);
        $indexer = new Indexer();
        $indexer->indexingDocuments();
        //return "dcdd";
        $executionEndTime = microtime(true);
        $seconds =  $executionEndTime -  $executionStartTime;
        var_dump("Excution Time is : ");
        var_dump($seconds);
    }
}
