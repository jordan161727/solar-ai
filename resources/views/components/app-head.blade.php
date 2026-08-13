@props(['title' => null])

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="theme-color" content="#ffffff" data-theme-color>

<title>{{ $title ? $title.' · Solar AI' : 'Solar AI' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

{{--
    Runs before first paint so the stored theme is applied without a flash of
    the wrong palette. Light is the default when nothing is stored.
--}}
<script>
    (function () {
        window.setTheme = function (theme) {
            var isDark = theme === 'dark';

            document.documentElement.classList.toggle('dark', isDark);

            try {
                localStorage.setItem('theme', theme);
            } catch (e) { /* private mode — fall back to per-session default */ }

            var meta = document.querySelector('[data-theme-color]');
            if (meta) {
                meta.setAttribute('content', isDark ? '#090c12' : '#ffffff');
            }
        };

        var stored;
        try {
            stored = localStorage.getItem('theme');
        } catch (e) { /* ignore */ }

        if (stored === 'dark' || stored === 'light') {
            window.setTheme(stored);
        } else {
            window.setTheme('light');
        }
    })();
</script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
