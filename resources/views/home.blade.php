<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}"/>
</head>
<body>
<div id="app">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="mt-3">CSV Generator</h1>
            </div>
        </div>
    </div>
    <c-s-v-generator></c-s-v-generator>
</div>

<script src="{{ mix('/js/app.js') }}" type="text/javascript"></script>
</body>
</html>
