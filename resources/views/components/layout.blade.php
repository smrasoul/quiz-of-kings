<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Home</title>
</head>
<body dir="rtl" class="bg-secondary-subtle">
    <div class="container text-white p-5 bg-quiz shadow-lg">
        {{ $slot }}
    </div>
</body>
</html>

