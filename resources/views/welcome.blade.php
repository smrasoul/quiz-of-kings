

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
<body>
<nav class="navbar bg-indigo">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('favicon.ico') }}" alt="Logo" width="30" height="24" class="d-inline-block align-text-top
            ">
            <span class="text-white">Bootstrap</span>
        </a>
    </div>
</nav>

</body>
</html>


