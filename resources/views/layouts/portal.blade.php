@php
    $portal = $portal ?? 'citizen';
    $isAdmin = $portal === 'admin';
    $navItems = $isAdmin
        ? [
            ['bn' => 'ওভারভিউ', 'en' => 'Overview', 'active' => true, 'milestone' => null],
            ['bn' => 'ভূগোল', 'en' => 'Geography', 'active' => false, 'milestone' => 'M2'],
            ['bn' => 'ব্যবহারকারী', 'en' => 'People', 'active' => false, 'milestone' => 'M2'],
            ['bn' => 'ভূমিকা ও অনুমতি', 'en' => 'Roles & permissions', 'active' => false, 'milestone' => 'M2'],
            ['bn' => 'অডিট লগ', 'en' => 'Audit log', 'active' => false, 'milestone' => 'M2'],
            ['bn' => 'প্রোগ্রাম', 'en' => 'Programmes', 'active' => false, 'milestone' => 'M5'],
            ['bn' => 'জিআইএস স্তর', 'en' => 'GIS layers', 'active' => false, 'milestone' => 'M6'],
        ]
        : [
            ['bn' => 'ওভারভিউ', 'en' => 'Overview', 'active' => true, 'milestone' => null],
            ['bn' => 'আমার প্রোফাইল', 'en' => 'My profile', 'active' => false, 'milestone' => 'M3'],
            ['bn' => 'আমার আবেদন', 'en' => 'My applications', 'active' => false, 'milestone' => 'M3'],
            ['bn' => 'রক্তের অনুরোধ', 'en' => 'Blood requests', 'active' => false, 'milestone' => 'M4'],
            ['bn' => 'সুবিধা কর্মসূচি', 'en' => 'Benefit programmes', 'active' => false, 'milestone' => 'M5'],
            ['bn' => 'সমস্যা রিপোর্ট', 'en' => 'Problem reports', 'active' => false, 'milestone' => 'M6'],
            ['bn' => 'গোপনীয়তা ও সম্মতি', 'en' => 'Privacy & consent', 'active' => false, 'milestone' => 'M3'],
        ];
@endphp

<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Prototype portal placeholder for the Phulbaria Upazila Service Platform. Not an official government website.">
    <title>@yield('title', ($isAdmin ? 'Admin' : 'Citizen').' placeholder — '.config('platform.name.en'))</title>
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

            <div class="flex items-center gap-3">
                <span class="hidden rounded-full border border-brand-200 bg-brand-50 px-3 py-1.5 text-xs font-bold text-brand-800 sm:inline-flex">
                    {{ $isAdmin ? 'অ্যাডমিন প্লেসহোল্ডার / Admin placeholder' : 'নাগরিক প্লেসহোল্ডার / Citizen placeholder' }}
                </span>
                <span class="badge bg-amber-100 text-amber-900">প্রোটোটাইপ / Prototype</span>
                <a href="{{ route('home') }}" class="hidden text-sm font-bold text-brand-800 hover:text-brand-950 sm:inline-block">পাবলিক সাইট / Public site</a>
            </div>
        </div>
    </header>

    <main id="main-content" class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        <div class="grid gap-8 lg:grid-cols-[16rem_minmax(0,1fr)]">
            <aside>
                <div class="card p-4">
                    <div class="flex items-center justify-between gap-3 border-b border-slate-200 pb-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">{{ $isAdmin ? 'Administration' : 'Citizen portal' }}</p>
                            <p class="mt-1 text-lg font-extrabold text-slate-950">{{ $isAdmin ? 'প্রশাসনিক প্যানেল' : 'নাগরিক প্যানেল' }}</p>
                        </div>
                        <span class="grid h-10 w-10 place-items-center rounded-full bg-brand-100 text-sm font-extrabold text-brand-800">
                            {{ $isAdmin ? 'A' : 'C' }}
                        </span>
                    </div>

                    <nav class="mt-4 grid grid-cols-2 gap-2 lg:grid-cols-1" aria-label="{{ $isAdmin ? 'Admin portal' : 'Citizen portal' }} navigation">
                        @foreach ($navItems as $item)
                            @if ($item['active'])
                                <span aria-current="page" class="col-span-2 flex items-center justify-between gap-2 rounded-xl bg-brand-700 px-3 py-2.5 text-sm font-bold text-white lg:col-span-1">
                                    <span>{{ $item['bn'] }} / {{ $item['en'] }}</span>
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
                                    </svg>
                                </span>
                            @else
                                <span class="flex items-center justify-between gap-2 rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-semibold text-slate-500">
                                    <span>{{ $item['bn'] }} / {{ $item['en'] }}</span>
                                    <span class="badge bg-slate-100 text-slate-600">{{ $item['milestone'] }}</span>
                                </span>
                            @endif
                        @endforeach
                    </nav>

                    <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-3">
                        <p class="text-xs font-extrabold text-amber-950">বর্তমান স্কোপ / Current scope</p>
                        <p class="mt-1 text-sm font-bold text-amber-900">
                            {{ $isAdmin ? 'প্ল্যাটফর্ম ডেমো / Platform demo' : config('platform.demo_scope.union.bn').' · '.config('platform.demo_scope.ward.bn') }}
                        </p>
                        <p class="mt-1 text-xs leading-5 text-amber-800">
                            {{ $isAdmin ? 'Global demo view. No real accounts or data.' : 'Demo citizen view. No login or personal data is used.' }}
                        </p>
                    </div>

                    <a href="{{ route('home') }}" class="mt-4 block text-center text-sm font-bold text-brand-800 hover:text-brand-950 lg:hidden">← পাবলিক সাইট / Public site</a>
                </div>
            </aside>

            <div class="min-w-0">
                @if ($isAdmin)
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="section-eyebrow">Administration · Prototype</p>
                            <h1 class="mt-1 text-2xl font-extrabold tracking-tight text-slate-950 sm:text-3xl">প্রশাসনিক ওভারভিউ <span class="text-slate-400">/</span> Admin overview</h1>
                        </div>
                        <a href="{{ route('prototype.citizen.dashboard') }}" class="btn-secondary">নাগরিক ভিউ দেখুন / Citizen view</a>
                    </div>
                @else
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="section-eyebrow">Citizen portal · Prototype</p>
                            <h1 class="mt-1 text-2xl font-extrabold tracking-tight text-slate-950 sm:text-3xl">স্বাগতম, ডেমো নাগরিক <span class="text-slate-400">/</span> Welcome, demo citizen</h1>
                        </div>
                        <a href="{{ route('prototype.admin.dashboard') }}" class="btn-secondary">অ্যাডমিন ভিউ দেখুন / Admin view</a>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
