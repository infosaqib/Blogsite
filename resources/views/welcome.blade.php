<h1 class="text-center text-red-500">{{ config('app.name') }}</h1>
<nav>
    <ul class="flex justify-center space-x-4">
        <li><a href="{{ route('home') }}" class="text-blue-500 hover:underline">Home</a></li>
        <li><a href="{{ route('about') }}" class="text-blue-500 hover:underline">About</a></li>
    </ul>
</nav>