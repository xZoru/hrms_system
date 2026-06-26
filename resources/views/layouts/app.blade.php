<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --bg-table-stripe: #f1f5f9;
            --text-primary: #0f172a;
            --text-secondary: #334155;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow-color: rgba(0,0,0,0.05);
            --bg-hover: #f1f5f9;
            --glass-bg: rgba(255,255,255,0.7);
        }

        [data-theme="dark"] {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-table-stripe: #0f172a;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --shadow-color: rgba(0,0,0,0.4);
            --bg-hover: #334155;
            --glass-bg: rgba(0,0,0,0.5);
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
        }

        .bg-white { background-color: var(--bg-secondary) !important; }
        .bg-gray-100 { background-color: var(--bg-primary) !important; }
        .bg-gray-50 { background-color: var(--bg-table-stripe) !important; }

        .text-gray-800, .text-gray-900 { color: var(--text-primary) !important; }
        .text-gray-700, .text-gray-600 { color: var(--text-secondary) !important; }
        .text-gray-500, .text-gray-400 { color: var(--text-muted) !important; }

        .border-gray-100, .border-gray-200, .border-gray-300 {
            border-color: var(--border-color) !important;
        }
        .divide-gray-200 > * + * {
            border-color: var(--border-color) !important;
        }

        .shadow-sm, .shadow {
            box-shadow: 0 1px 3px 0 var(--shadow-color) !important;
        }

        .hover\:bg-gray-50:hover {
            background-color: var(--bg-hover) !important;
        }
        .hover\:bg-gray-100:hover {
            background-color: var(--bg-hover) !important;
        }
        .hover\:text-gray-700:hover {
            color: var(--text-secondary) !important;
        }
        .hover\:text-gray-900:hover {
            color: var(--text-primary) !important;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>

    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const defaultTheme = savedTheme || (systemDark ? 'dark' : 'light');

            document.documentElement.setAttribute('data-theme', defaultTheme);

            function updateThemeButtons() {
                const theme = document.documentElement.getAttribute('data-theme');
                const btn = document.getElementById('theme-toggle-btn');
                const mobileBtn = document.getElementById('mobile-theme-toggle');

                if (theme === 'dark') {
                    if (btn) btn.textContent = '☀️ Light';
                    if (mobileBtn) mobileBtn.textContent = '☀️ Light Mode';
                } else {
                    if (btn) btn.textContent = '🌙 Dark';
                    if (mobileBtn) mobileBtn.textContent = '🌙 Dark Mode';
                }
            }

            window.toggleTheme = function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);

                updateThemeButtons();
            };

            document.addEventListener('DOMContentLoaded', updateThemeButtons);
        })();
    </script>
</body>
</html>