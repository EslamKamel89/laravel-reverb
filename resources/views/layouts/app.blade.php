<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ $title ?? "Reverb" }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=lato:400,700" rel="stylesheet" />

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset("images/apple-touch-icon.png") }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset("images/favicon-32x32.png") }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset("images/favicon-16x16.png") }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset("images/favicon.ico") }}" />

    @vite(["resources/css/app.css", "resources/js/app.js"])
    @stack("scripts")
</head>

<body class="w-screen h-screen antialiased">
    <div
        class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-tr from-fuchsia-600 from-10% to-fuchsia-900 p-1">
        @yield("content")
    </div>
</body>

</html>
