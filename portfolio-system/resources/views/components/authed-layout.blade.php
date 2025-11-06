<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Resume' }} - {{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body style="background-color: #f3f4f6;">

        <nav class="top-bar-style">
            <div>
                <span style="font-weight: 700; font-size: 1.1rem;">
                    Welcome, {{ Auth::user()->name }}!
                </span>
            </div>
            
            <div class="top-actions">
                
                {{-- 1. Conditional Button (Dashboard or Edit Resume) --}}
                @if(request()->routeIs('resume.edit'))
                    {{-- When on the Edit page, show the Dashboard button --}}
                    <a href="{{ route('dashboard') }}" class="action-btn">
                        Dashboard
                    </a>
                @else
                    {{-- When on any other page (like Dashboard), show the Edit Resume button --}}
                    <a href="{{ route('resume.edit') }}" class="action-btn">
                        Edit Resume
                    </a>
                @endif
                
                {{-- 2. Public View Button (Always shown, always needs the user ID) --}}
                <a href="{{ route('resume.public', Auth::user()->id) }}" class="action-btn" target="_blank">
                    Public View
                </a>
                
                {{-- 3. Logout Button --}}
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="action-btn-logout">
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>
    </body>
</html>