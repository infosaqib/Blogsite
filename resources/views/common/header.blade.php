<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page }}</title>
</head>

<body style="background-color: brown;">
    <header style="color:#fff; font-family:ui-sans-serif,system-ui;">
        <div
            style="max-width:1200px;margin:0 auto;display:flex;padding:20px;flex-direction:row;align-items:center;justify-content:center;background-color:limegreen">

            <a
                style="display:flex;font-weight:500;align-items:center;color:#111827;margin-bottom:16px;text-decoration:none;">
                <span style="font-size:20px;color:#fff">{{ config('app.name') }}</span>
            </a>

            <nav
                style="display:flex;flex-wrap:wrap;align-items:center;font-size:16px;justify-content:center;margin-left:auto;margin-right:auto;">
                <a href="{{ route('home') }}" style="margin-right:20px;color:#fff;text-decoration:none;">Home</a>
                <a href="{{ route('about') }}" style="margin-right:20px;color:#fff;text-decoration:none;">About</a>
                <a href="{{ route('contact') }}" style="margin-right:20px;color:#fff;text-decoration:none;">Contact</a>
                <a href="{{ route('login') }}" style="margin-right:20px;color:#fff;text-decoration:none;">Login</a>
                <a href="{{ route('register') }}" style="margin-right:20px;color:#fff;text-decoration:none;">Register</a>
                <a href="{{ route('product') }}" style="margin-right:20px;color:#fff;text-decoration:none;">Product</a>
                <a href="{{ route('library') }}" style="margin-right:20px;color:#fff;text-decoration:none;">Library</a>
                <a href="{{ route('posts') }}" style="margin-right:20px;color:#fff;text-decoration:none;">Posts</a>
            </nav

        </div>
    </header>
    <h1 style="text-align: center;">{{ $page }}</h1>
</body>

</html>