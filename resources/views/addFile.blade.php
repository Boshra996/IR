<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Add File</title>

    <!-- Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> -->



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styles.css" />

</head>

<body>

    <a href="{{ url('/') }}"
        style="border-bottom: 0px; margin:  10px;color: #c0d0d8;font-size:  18px;font-family:  serif;text-underline-position:  none;padding:  0px;/* margin-bottom:  1000px; */">Home</a>
    <a href="{{ url('/file') }}"
        style="margin:  10px;color: #c0d0d8;font-size:  18px;font-family:  serif;text-underline-position:  none;padding:  0px;/* margin-bottom:  1000px; */">Add File</a>


    <div id="page">
        <h2>Add File</h2>
        <form id="searchForm" method="POST" action="/addFile" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <fieldset>
                <div class="form-group">
                    <div class="form-input">
                        <div class="col-md-12">
                            {{ Form::file('file', ['id' => 'file-input', 'required']) }}
                            <label for="file-input" class="btn" id="uploadBTN" /> Choose file to be indexed</label>
                            <label class="Name" id=""></label>
                        </div>
                    </div>
                    <br>
                    <br>
                </div>
                <div class="col-md-12">
                    <input type="submit" value="Save" class="btn btn-secondary" />
                </div>

            </fieldset>
        </form>

    </div>
    <!-- It would be great if you leave the link back to the tutorial. Thanks! -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="js/script.js"></script>
</body>
<footer>
    Copyright © BeboSE 2020-2021
</footer>

</html>
