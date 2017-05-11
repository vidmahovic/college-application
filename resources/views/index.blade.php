<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}

    <title>College Application</title>

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="college-app">
        <h3>Loading...</h3>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
</body>
</html>
