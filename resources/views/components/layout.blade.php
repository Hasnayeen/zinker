<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="theme-dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('/site.webmanifest') }}">
        <link rel="mask-icon" href="{{ asset('/safari-pinned-tab.svg') }}" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

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
                background-color: #000000;
            }
            .cm-gutter {
                background-color: #000000;
                border-right-width: 1px;
                border-right-color: #6b7280;
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
