<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Solar AI</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-slate-950">

<div class="flex h-screen">

    <x-sidebar />

    <main class="flex-1 overflow-auto">

        <x-navbar />

        <div class="p-8">

            {{ $slot }}

        </div>

    </main>

</div>

@stack('scripts')

</body>

</html>