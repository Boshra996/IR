<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IR</title>

    <!-- Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styles.css" />

</head>

<body>
    <a href="{{ url('/') }}"
        style="margin:  10px;color: #c0d0d8;font-size:  18px;font-family:  serif;text-underline-position:  none;padding:  0px;/* margin-bottom:  1000px; */">Home</a>
    <a href="{{ url('/file') }}"
        style="border-bottom: 0px; margin:  10px;color: #c0d0d8;font-size:  18px;font-family:  serif;text-underline-position:  none;padding:  0px;/* margin-bottom:  1000px; */">Add
        File</a>

    <div id="page">

        <h2>Information Retrieval</h2>
        <div class="row">
            <form id="searchForm" method="GET" action="/search">
                <fieldset>
                    <div class="form-group col-md-12">
                        <label for="query" class="col-form-label">Search</label>
                        <input id="searchField" class="form-control" type="text" name="query"
                            value="{{ isset($data['query']) ? $data['query'] : '' }}"
                            placeholder="Writy your query here" />
                        @isset($data['suggestedQuery'])
                            <div style="margin-top: 10px">
                                <span style="color: red">Did you mean</span>

                                @foreach ($data['suggestedQuery'] as $suggestion)

                                    <a href="/search?query={!! $suggestion['new_query'] !!}" style="color: white">
                                        {!! $suggestion['new_query_html'] !!}</a>
                                @endforeach
                            </div>
                        @endisset
                    </div>

                    <div class="col-md-12">
                        <input type="submit" value="Search" class="btn btn-secondary" />
                    </div>
                </fieldset>
            </form>
        </div>

        @isset($data['result'])
            <div id="resultsDiv">
                @foreach ($data['result'] as $obj)
                    <div class="row">
                        <div class="webResult">
                            <h2><a href="corpus/{{ $obj['doc']['name'] }}" , target="_blank"> Document :
                                    {{ $obj['doc']['name'] }}</a>
                            </h2>
                            <p>Weight : {{ $obj['sim'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            @empty($data['result'])
                <div id="emptyDiv" class="row">
                    <div class="text-center col-md-12 has-error">
                        <h2 class="help-block"> No data found</h2>
                    </div>
                </div>
            @endempty

        @endisset

    </div>


    </ <!-- It would be great if you leave the link back to the tutorial. Thanks! -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="js/script.js"></script>
</body>
<footer>
    Copyright © BeboSE 2020-2021
</footer>

</html>
