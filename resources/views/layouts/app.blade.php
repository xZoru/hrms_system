<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        
        :root {
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --bg-table: #ffffff;
            --bg-table-stripe: #f1f5f9;
            --bg-nav: #ffffff;
            --bg-header: #ffffff;
            --bg-input: #ffffff;
            --bg-dropdown: #ffffff;
            --bg-hover: #f1f5f9;

            --text-primary: #0f172a;
            --text-secondary: #334155;
            --text-muted: #64748b;
            --text-white: #ffffff;
            --text-link: #dc2626;
            --text-link-hover: #b91c1c;

            --border-color: #e2e8f0;
            --border-light: #f1f5f9;

            --shadow-color: rgba(0,0,0,0.05);
            --shadow-heavy: rgba(0,0,0,0.1);

            --success-bg: #f0fdf4;
            --success-text: #16a34a;
            --success-border: #bbf7d0;

            --error-bg: #fef2f2;
            --error-text: #dc2626;
            --error-border: #fecaca;

            --glass-bg: rgba(255,255,255,0.7);
            --glass-border: rgba(255,255,255,0.2);
        }

        [data-theme="dark"] {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-card: #1e293b;
            --bg-table: #1e293b;
            --bg-table-stripe: #0f172a;
            --bg-nav: #1e293b;
            --bg-header: #1e293b;
            --bg-input: #334155;
            --bg-dropdown: #1e293b;
            --bg-hover: #334155;

            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --text-white: #ffffff;
            --text-link: #f87171;
            --text-link-hover: #fca5a5;

            --border-color: #334155;
            --border-light: #1e293b;

            --shadow-color: rgba(0,0,0,0.4);
            --shadow-heavy: rgba(0,0,0,0.6);

            --success-bg: #052e16;
            --success-text: #4ade80;
            --success-border: #166534;

            --error-bg: #450a0a;
            --error-text: #fca5a5;
            --error-border: #7f1d1d;

            --glass-bg: rgba(0,0,0,0.5);
            --glass-border: rgba(255,255,255,0.08);
        }

        
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
        }

        
        .bg-white {
            background-color: var(--bg-secondary) !important;
        }
        .bg-gray-100 {
            background-color: var(--bg-primary) !important;
        }
        .bg-gray-50 {
            background-color: var(--bg-table-stripe) !important;
        }
        .bg-gray-800 {
            background-color: var(--bg-nav) !important;
        }

        
        .text-gray-800, .text-gray-900, .text-dark {
            color: var(--text-primary) !important;
        }
        .text-gray-700, .text-gray-600 {
            color: var(--text-secondary) !important;
        }
        .text-gray-500, .text-gray-400 {
            color: var(--text-muted) !important;
        }
        .text-white {
            color: var(--text-white) !important;
        }

        
        .border-gray-100, .border-gray-200, .border-gray-300 {
            border-color: var(--border-color) !important;
        }
        .divide-gray-200 > * + * {
            border-color: var(--border-color) !important;
        }

        
        .shadow-sm, .shadow, .shadow-md, .shadow-lg {
            box-shadow: 0 1px 3px 0 var(--shadow-color), 0 1px 2px -1px var(--shadow-color) !important;
        }

        
        a:not(.no-theme) {
            color: var(--text-link) !important;
        }
        a:not(.no-theme):hover {
            color: var(--text-link-hover) !important;
        }

        /* ===== BUTTONS ===== */
        .btn-primary, .bg-red-600, .bg-red-500 {
            background-color: #dc2626 !important;
        }
        .btn-primary:hover, .bg-red-600:hover, .bg-red-500:hover {
            background-color: #b91c1c !important;
        }

        
        input, select, textarea {
            background-color: var(--bg-input) !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }
        input::placeholder, textarea::placeholder {
            color: var(--text-muted) !important;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 3px rgba(220,38,38,0.1) !important;
        }

        
        .bg-green-100 {
            background-color: var(--success-bg) !important;
            color: var(--success-text) !important;
            border-color: var(--success-border) !important;
        }
        .text-green-700 {
            color: var(--success-text) !important;
        }
        .bg-red-100 {
            background-color: var(--error-bg) !important;
            color: var(--error-text) !important;
            border-color: var(--error-border) !important;
        }
        .text-red-700, .text-red-600 {
            color: var(--error-text) !important;
        }

        
        table {
            background-color: var(--bg-table) !important;
        }
        thead.bg-gray-50 {
            background-color: var(--bg-table-stripe) !important;
        }
        thead.bg-gray-50 th {
            color: var(--text-muted) !important;
        }
        tbody.bg-white {
            background-color: var(--bg-table) !important;
        }
        tbody tr {
            border-color: var(--border-color) !important;
        }
        tbody tr td {
            color: var(--text-primary) !important;
        }
        tbody tr:hover {
            background-color: var(--bg-hover) !important;
        }

        
        .dropdown-content {
            background-color: var(--bg-dropdown) !important;
            border-color: var(--border-color) !important;
        }

        
        nav, .nav-bar {
            background-color: var(--bg-nav) !important;
            border-color: var(--border-color) !important;
        }

        
        header {
            background-color: var(--bg-header) !important;
            border-color: var(--border-color) !important;
        }
        header h2 {
            color: var(--text-primary) !important;
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

        
        .glass-card {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border: 1px solid var(--glass-border) !important;
        }

        
        @media (max-width: 480px) {
            .glass-container {
                padding: 28px 20px;
            }
            .glass-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        
        <main>
            {{ $slot }}
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
                    if (btn) btn.textContent = '☀️';
                    if (mobileBtn) mobileBtn.textContent = '☀️';
                } else {
                    if (btn) btn.textContent = '🌙 ';
                    if (mobileBtn) mobileBtn.textContent = '🌙 ';
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

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', updateThemeButtons);
            } else {
                updateThemeButtons();
            }
        })();
    </script>
</body>
</html>