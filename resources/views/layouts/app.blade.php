<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barber Shop')</title>
     <link rel="icon" type="image/png" href="/img/1.png">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            min-height: 100vh;
        }
        .container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 2rem 2.5rem;
        }
        h2 {
            color: #6b1e3e;
            margin-bottom: 1rem;
        }
        a {
            color: #6b1e3e;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
    @yield('head')
</head>
<body>
    @yield('content')
</body>
</html>
