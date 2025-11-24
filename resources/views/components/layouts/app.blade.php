<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        <link rel="shortcut icon" href="{{asset('logo.ico')}}" type="image/x-icon">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>{{ $pageTitle ?? 'Teamable' }}</title>
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
