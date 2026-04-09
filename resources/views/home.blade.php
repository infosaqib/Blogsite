@includeif('common.header', ['page' => 'Home'])
<h1 class="text-center text-red-500">HOME page</h1>
<h2>{{ $name }}</h2>
<h3>current:{{ URL::current() }}</h3>
<h3>previous:{{ URL::previous() }}</h3>
<p>{{ URL::full() }}</p>
<a href="{{ route('welcome') }}">Welcome</a>
<a href="{{ URL::to('about') }}">About Page</a>