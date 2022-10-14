<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="theme-dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Zinker</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        @include('script')

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            .cm-editor {
                height: 100%;
                font-size: 1rem;
                background-color: #1f2937;
            }
            .cm-gutter {
                background-color: #000000;
                color: #9ca3af;
                padding-right: 0.5rem;
            }
            .cm-editor .cm-line {
                padding-bottom: 0.5rem;
            }
            pre.sf-dump {
                margin: 1rem 0;
                line-height: 1.4rem;
            }
            pre.sf-dump, pre.sf-dump .sf-dump-default {
                background-color: #0f172a !important;
            }
            .sf-dump-default.sf-dump-ns {
                display: none;
            }
        </style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <livewire:styles />
    </head>
    <body class="antialiased">
        {{ $slot }}
        <livewire:scripts />

    </body>
</html>
