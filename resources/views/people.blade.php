<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/css/app.css">
        <link rel="icon" href="data:;base64,=">
    </head>
    <body class="py-20">
        <div id="app">
            <people-component :team = "{{ $team }}"></people-component>
        </div> 
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>