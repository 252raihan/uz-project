<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="@yield('meta_description', 'Independent prototype for a ward-aware public service platform in Phulbaria Upazila, Mymensingh. Not an official government website.')">
    <title>@yield('title', config('platform.name.en').' — Prototype')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-900 antialiased">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-brand-700 focus:px-4 focus:py-3 focus:text-white">
        মূল বিষয়বস্তুতে যান / Skip to main content
    </a>

    @include('partials.prototype-banner')

    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            @include('partials.brand')

            <nav class="hidden items-center gap-1 lg:flex" aria-label="Public navigation">
                <a href="{{ route('home') }}#services" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 hover:text-brand-800">সেবা / Services</a>
                <a href="{{ route('home') }}#blood" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 hover:text-brand-800">রক্ত সহায়তা / Blood</a>
                <a href="{{ route('home') }}#portals" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 hover:text-brand-800">পোর্টাল / Portals</a>
                <a href="{{ route('home') }}#prototype-notice" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 hover:text-brand-800">প্রোটোটাইপ / About</a>
                <span class="mx-1 h-6 w-px bg-slate-200" aria-hidden="true"></span>
                <a href="{{ route('prototype.login') }}" class="rounded-lg px-3 py-2 text-sm font-bold text-brand-800 hover:bg-brand-50" @if(request()->routeIs('prototype.login')) aria-current="page" @endif>সাইন ইন / Sign in</a>
                <a href="{{ route('prototype.register') }}" class="btn-primary ml-1" @if(request()->routeIs('prototype.register')) aria-current="page" @endif>নিবন্ধন / Register</a>
            </nav>

            <details class="relative lg:hidden">
                <summary class="flex h-11 w-11 cursor-pointer list-none items-center justify-center rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-brand-200" aria-label="Open navigation menu">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </summary>
                <div class="absolute right-0 mt-2 w-72 rounded-2xl border border-slate-200 bg-white p-3 shadow-xl">
                    <nav class="flex flex-col" aria-label="Mobile navigation">
                        <a href="{{ route('home') }}#services" class="rounded-lg px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">সেবা / Services</a>
                        <a href="{{ route('home') }}#blood" class="rounded-lg px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">রক্ত সহায়তা / Blood</a>
                        <a href="{{ route('home') }}#portals" class="rounded-lg px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">পোর্টাল / Portals</a>
                        <a href="{{ route('home') }}#prototype-notice" class="rounded-lg px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">প্রোটোটাইপ / About</a>
                        <a href="{{ route('prototype.login') }}" class="rounded-lg px-3 py-3 text-sm font-bold text-brand-800 hover:bg-brand-50">সাইন ইন / Sign in</a>
                        <a href="{{ route('prototype.register') }}" class="btn-primary mt-2">নিবন্ধন / Register</a>
                    </nav>
                </div>
            </details>
        </div>
    </header>

    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
