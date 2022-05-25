<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Payment Status</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *, :after, :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        svg, video {
            display: block;
            vertical-align: middle
        }

        video {
            max-width: 100%;
            height: auto
        }

        .bg-white {
            --bg-opacity: 1;
            background-color: #fff;
            background-color: rgba(255, 255, 255, var(--bg-opacity))
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity))
        }

        .border-gray-200 {
            --border-opacity: 1;
            border-color: #edf2f7;
            border-color: rgba(237, 242, 247, var(--border-opacity))
        }

        .border-t {
            border-top-width: 1px
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .font-semibold {
            font-weight: 600
        }

        .h-5 {
            height: 1.25rem
        }

        .h-8 {
            height: 2rem
        }

        .h-16 {
            height: 4rem
        }

        .text-sm {
            font-size: .875rem
        }

        .text-lg {
            font-size: 1.125rem
        }

        .leading-7 {
            line-height: 1.75rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .ml-1 {
            margin-left: .25rem
        }

        .mt-2 {
            margin-top: .5rem
        }

        .mr-2 {
            margin-right: .5rem
        }

        .ml-2 {
            margin-left: .5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .ml-12 {
            margin-left: 3rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .max-w-6xl {
            max-width: 72rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .overflow-hidden {
            overflow: hidden
        }

        .p-6 {
            padding: 1.5rem
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .pt-8 {
            padding-top: 2rem
        }

        .fixed {
            position: fixed
        }

        .relative {
            position: relative
        }

        .top-0 {
            top: 0
        }

        .right-0 {
            right: 0
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)
        }

        .text-center {
            text-align: center
        }

        .text-gray-200 {
            --text-opacity: 1;
            color: #edf2f7;
            color: rgba(237, 242, 247, var(--text-opacity))
        }

        .text-gray-300 {
            --text-opacity: 1;
            color: #e2e8f0;
            color: rgba(226, 232, 240, var(--text-opacity))
        }

        .text-gray-400 {
            --text-opacity: 1;
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--text-opacity))
        }

        .text-gray-500 {
            --text-opacity: 1;
            color: #a0aec0;
            color: rgba(160, 174, 192, var(--text-opacity))
        }

        .text-gray-600 {
            --text-opacity: 1;
            color: #718096;
            color: rgba(113, 128, 150, var(--text-opacity))
        }

        .text-gray-700 {
            --text-opacity: 1;
            color: #4a5568;
            color: rgba(74, 85, 104, var(--text-opacity))
        }

        .text-gray-900 {
            --text-opacity: 1;
            color: #1a202c;
            color: rgba(26, 32, 44, var(--text-opacity))
        }

        .underline {
            text-decoration: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .w-5 {
            width: 1.25rem
        }

        .w-8 {
            width: 2rem
        }

        .w-auto {
            width: auto
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        @media (min-width: 640px) {
            .sm\:rounded-lg {
                border-radius: .5rem
            }

            .sm\:block {
                display: block
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:h-20 {
                height: 5rem
            }

            .sm\:ml-0 {
                margin-left: 0
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width: 768px) {
            .md\:border-t-0 {
                border-top-width: 0
            }

            .md\:border-l {
                border-left-width: 1px
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width: 1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme: dark) {
            .dark\:bg-gray-800 {
                --bg-opacity: 1;
                background-color: #2d3748;
                background-color: rgba(45, 55, 72, var(--bg-opacity))
            }

            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #1a202c;
                background-color: rgba(26, 32, 44, var(--bg-opacity))
            }

            .dark\:border-gray-700 {
                --border-opacity: 1;
                border-color: #4a5568;
                border-color: rgba(74, 85, 104, var(--border-opacity))
            }

            .dark\:text-white {
                --text-opacity: 1;
                color: #fff;
                color: rgba(255, 255, 255, var(--text-opacity))
            }

            .dark\:text-gray-400 {
                --text-opacity: 1;
                color: #cbd5e0;
                color: rgba(203, 213, 224, var(--text-opacity))
            }
        }
    </style>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<div
    class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-1">
                <div class="p-12">
                    <div class="flex items-center mt-2">
                        <div class="ml-2 mr-2">
                            <div style="text-align: center" class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                <img src="data:image/png;base64,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"/>
                                <br>
                                Payment Error: {{@$error}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
