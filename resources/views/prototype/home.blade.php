@extends('layouts.public')

@section('title', config('platform.name.en').' — Independent Prototype')

@section('content')
    <section class="relative overflow-hidden bg-brand-900 text-white">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-brand-500/20 blur-3xl"></div>
            <div class="absolute -bottom-32 left-1/4 h-96 w-96 rounded-full bg-emerald-400/10 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
            <div class="grid gap-12 lg:grid-cols-[1.15fr_0.85fr] lg:items-center">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-brand-300/40 bg-white/10 px-4 py-1.5 text-xs font-bold tracking-wide text-brand-50">
                        <span class="h-2 w-2 rounded-full bg-emerald-300" aria-hidden="true"></span>
                        স্বাধীন সিভিক প্রোটোটাইপ / Independent civic prototype
                    </span>

                    <h1 class="mt-6 max-w-3xl text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                        <span lang="bn" class="block">ফুলবাড়ীয়ার সেবা,</span>
                        <span lang="bn" class="block text-brand-200">এক জায়গায়।</span>
                        <span lang="en" class="mt-4 block text-xl font-semibold text-brand-100 sm:text-2xl">
                            Local services, made easier to find.
                        </span>
                    </h1>

                    <p lang="bn" class="mt-6 max-w-2xl text-base leading-8 text-brand-50/90 sm:text-lg">
                        নাগরিক নিবন্ধন, ওয়ার্ডভিত্তিক সেবা, রক্তদাতা সহায়তা, সুবিধা কর্মসূচি, সমস্যা রিপোর্ট এবং
                        স্থানীয় শিক্ষা, স্বাস্থ্য ও অবকাঠামো তথ্য—সব একসাথে ব্যবহারের পরিকল্পনা।
                    </p>
                    <p lang="en" class="mt-3 max-w-2xl text-sm leading-7 text-brand-100/80">
                        A planned ward-aware platform for citizen registration, blood support, benefit applications,
                        public problem reporting, and trusted local information.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="#services" class="btn-inverse">
                            সেবা দেখুন / Explore services
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                            </svg>
                        </a>
                        <a href="{{ route('prototype.register') }}" class="btn-inverse-outline">নিবন্ধন প্রোটোটাইপ / Registration prototype</a>
                    </div>

                    <p class="mt-4 text-xs leading-6 text-brand-100/70">
                        এই প্রোটোটাইপে কোনো অ্যাকাউন্ট তৈরি হয় না বা কোনো তথ্য সংরক্ষণ করা হয় না।
                        No account is created and no data is stored in this prototype.
                    </p>
                </div>

                <div class="rounded-3xl border border-white/15 bg-white/10 p-2 shadow-2xl backdrop-blur">
                    <div class="rounded-[1.25rem] bg-white p-5 text-slate-900 sm:p-6">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-700">Milestone 1</p>
                                <h2 class="mt-1 text-xl font-extrabold text-slate-950">এই প্রোটোটাইপে যা আছে</h2>
                                <p class="text-sm text-slate-500">What is included</p>
                            </div>
                            <span class="badge bg-amber-100 text-amber-900">ডেমো / Demo</span>
                        </div>

                        <ul class="mt-5 divide-y divide-slate-100">
                            @foreach ([
                                ['label' => 'পাবলিক ল্যান্ডিং / Public landing', 'route' => 'home', 'status' => 'সক্রিয় / Active'],
                                ['label' => 'লগইন প্লেসহোল্ডার / Login placeholder', 'route' => 'prototype.login', 'status' => 'নিষ্ক্রিয় / Disabled'],
                                ['label' => 'নিবন্ধন প্লেসহোল্ডার / Registration placeholder', 'route' => 'prototype.register', 'status' => 'নিষ্ক্রিয় / Disabled'],
                                ['label' => 'নাগরিক ড্যাশবোর্ড / Citizen dashboard', 'route' => 'prototype.citizen.dashboard', 'status' => 'প্লেসহোল্ডার / Placeholder'],
                                ['label' => 'অ্যাডমিন ড্যাশবোর্ড / Admin dashboard', 'route' => 'prototype.admin.dashboard', 'status' => 'প্লেসহোল্ডার / Placeholder'],
                            ] as $page)
                                <li>
                                    <a href="{{ route($page['route']) }}" class="flex items-center justify-between gap-4 py-3 text-sm hover:text-brand-800">
                                        <span class="font-bold text-slate-800">{{ $page['label'] }}</span>
                                        <span class="shrink-0 text-xs font-semibold text-slate-500">{{ $page['status'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-3">
                            <p class="text-xs font-bold leading-5 text-amber-950">
                                সব পৃষ্ঠা শুধু পড়ার জন্য। লগইন, নিবন্ধন ও কোনো ব্যবসায়িক কার্যক্রম এখনো চালু হয়নি।
                            </p>
                            <p class="mt-1 text-xs leading-5 text-amber-800">
                                All pages are read-only. Authentication and business workflows are not enabled.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-slate-200 bg-white" aria-label="Platform coverage">
        <div class="mx-auto grid max-w-7xl divide-y divide-slate-200 px-4 sm:grid-cols-2 sm:divide-x sm:divide-y-0 sm:px-6 lg:grid-cols-4 lg:px-8">
            <div class="py-6 sm:px-6 lg:px-8">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-700">এলাকা / Area</p>
                <p class="mt-2 text-base font-extrabold text-slate-950">ফুলবাড়ীয়া উপজেলা</p>
                <p class="text-sm text-slate-500">Phulbaria, Mymensingh</p>
            </div>
            <div class="py-6 sm:px-6 lg:px-8">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-700">প্রশাসন / Administration</p>
                <p class="mt-2 text-base font-extrabold text-slate-950">১৩টি ইউনিয়ন + পৌরসভা</p>
                <p class="text-sm text-slate-500">13 unions + 1 municipality</p>
            </div>
            <div class="py-6 sm:px-6 lg:px-8">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-700">প্রবেশাধিকার / Access</p>
                <p class="mt-2 text-base font-extrabold text-slate-950">ওয়ার্ডভিত্তিক স্কোপ</p>
                <p class="text-sm text-slate-500">Ward-scoped by design</p>
            </div>
            <div class="py-6 sm:px-6 lg:px-8">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-700">ভাষা / Language</p>
                <p class="mt-2 text-base font-extrabold text-slate-950">বাংলা + English</p>
                <p class="text-sm text-slate-500">Bilingual public service</p>
            </div>
        </div>
    </section>

    <section id="prototype-notice" class="mx-auto max-w-7xl scroll-mt-24 px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="rounded-3xl border border-amber-300 bg-amber-50 p-6 sm:p-8">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-3xl">
                    <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-800">গুরুত্বপূর্ণ ঘোষণা / Important notice</p>
                    <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-amber-950">এটি কোনো সরকারি ওয়েবসাইট নয়</h2>
                    <p lang="bn" class="mt-3 text-sm leading-7 text-amber-950">
                        এটি একটি স্বাধীন প্রোটোটাইপ। এটি বাংলাদেশ সরকার, ফুলবাড়ীয়া উপজেলা প্রশাসন, কোনো ইউনিয়ন পরিষদ বা
                        কোনো সরকারি সংস্থার অফিসিয়াল ওয়েবসাইট নয়। কোনো সরকারি অনুমোদন, অনুমোদন বা অংশীদারত্বের দাবি করা হয় না।
                    </p>
                    <p lang="en" class="mt-2 text-sm leading-6 text-amber-900">
                        This is an independent prototype. It is not an official website of the Government of Bangladesh,
                        Phulbaria Upazila Administration, any Union Parishad, or any public authority. No government
                        authorization, endorsement, or partnership is claimed.
                    </p>
                </div>
                <div class="shrink-0 rounded-2xl bg-white/70 p-4 text-sm text-amber-950 ring-1 ring-amber-200">
                    <p class="font-extrabold">বর্তমান মাইলফলক / Current milestone</p>
                    <p class="mt-1 text-2xl font-extrabold">Milestone 1</p>
                    <p class="mt-1 text-xs leading-5 text-amber-800">Foundation, documentation and static UI prototype.</p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl bg-white/70 p-4 ring-1 ring-amber-200">
                    <p class="text-sm font-extrabold text-amber-950">এখনো নেই / Not implemented yet</p>
                    <ul class="mt-3 space-y-2 text-sm leading-6 text-amber-900">
                        <li>প্রকৃত লগইন বা অ্যাকাউন্ট তৈরি / Real sign-in or account creation</li>
                        <li>এনআইডি যাচাই, ওটিপি বা এসএমএস / NID verification, OTP or SMS</li>
                        <li>আবেদন, রক্তের অনুরোধ বা অভিযোগ জমা / Applications, blood requests or reports</li>
                        <li>ডেটাবেস, অডিট লগ বা ভূমিকা-ভিত্তিক অনুমতি / Database, audit logs or RBAC</li>
                    </ul>
                </div>
                <div class="rounded-2xl bg-white/70 p-4 ring-1 ring-amber-200">
                    <p class="text-sm font-extrabold text-amber-950">নিরাপত্তা নীতি / Safety rules</p>
                    <ul class="mt-3 space-y-2 text-sm leading-6 text-amber-900">
                        <li>প্রোটোটাইপে প্রকৃত এনআইডি বা সংবেদনশীল তথ্য দেবেন না।</li>
                        <li>No real NID, health, family or financial data in this demo.</li>
                        <li>ভবিষ্যতে সব অনুমতি সার্ভারে যাচাই হবে / Future authorization will be server-enforced.</li>
                        <li>ভূমিকা ও ভৌগোলিক স্কোপ একসাথে যাচাই হবে / Role and geographic scope will be checked together.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="scroll-mt-24 bg-white py-14 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="section-eyebrow">পরিকল্পিত সেবা / Planned services</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950 sm:text-4xl">নাগরিক সেবার পূর্ণ পরিকল্পনা</h2>
                <p lang="bn" class="mt-3 text-base leading-7 text-slate-600">
                    নিচের সেবাগুলো ভবিষ্যৎ মাইলফলকে ধাপে ধাপে তৈরি হবে। প্রতিটি কার্ডে বর্তমান অবস্থা স্পষ্টভাবে লেখা আছে।
                </p>
                <p lang="en" class="mt-2 text-sm leading-6 text-slate-500">
                    These services are planned across future milestones. Each card shows its current status.
                </p>
            </div>

            <div class="mt-10 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                @php
                    $services = [
                        [
                            'number' => '01',
                            'title_bn' => 'নাগরিক নিবন্ধন ও ওয়ার্ড নির্বাচন',
                            'title_en' => 'Citizen registration & ward selection',
                            'description' => 'ইউনিয়ন ও ওয়ার্ড নির্বাচন করে নাগরিক অ্যাকাউন্টের ভিত্তি তৈরি।',
                            'status' => 'পরিকল্পিত / Planned',
                            'milestone' => 'M2–M3',
                        ],
                        [
                            'number' => '02',
                            'title_bn' => 'রক্তদাতা ডিরেক্টরি ও জরুরি অনুরোধ',
                            'title_en' => 'Blood donors & emergency requests',
                            'description' => 'স্বেচ্ছা-সম্মত রক্তদাতা তালিকা, জরুরি অনুরোধ ও নিরাপদ যোগাযোগ।',
                            'status' => 'পরিকল্পিত / Planned',
                            'milestone' => 'M4',
                            'id' => 'blood',
                        ],
                        [
                            'number' => '03',
                            'title_bn' => 'অ্যাক্টিভিস্ট ও স্বেচ্ছাসেবক',
                            'title_en' => 'Activists & volunteers',
                            'description' => 'স্বেচ্ছাসেবক নিবন্ধন, যাচাই, কাজের দায়িত্ব ও অগ্রগতি।',
                            'status' => 'পরিকল্পিত / Planned',
                            'milestone' => 'M4',
                        ],
                        [
                            'number' => '04',
                            'title_bn' => 'সুবিধা কর্মসূচির আবেদন',
                            'title_en' => 'Benefit programme applications',
                            'description' => 'কর্মসূচি, যোগ্যতা, প্রয়োজনীয় কাগজপত্র ও আবেদনের অবস্থা।',
                            'status' => 'পরিকল্পিত / Planned',
                            'milestone' => 'M5',
                        ],
                        [
                            'number' => '05',
                            'title_bn' => 'আর্থিক সহায়তার অনুরোধ',
                            'title_en' => 'Financial assistance requests',
                            'description' => 'আবেদন, মূল্যায়ন, পৃথক অনুমোদন ও বিতরণের রেকর্ড।',
                            'status' => 'পরিকল্পিত / Planned',
                            'milestone' => 'M5–M6',
                        ],
                        [
                            'number' => '06',
                            'title_bn' => 'জনসমস্যা রিপোর্ট',
                            'title_en' => 'Public problem reporting',
                            'description' => 'সড়ক, ড্রেন, নিরাপত্তা বা অবকাঠামো সমস্যা জানান ও অগ্রগতি দেখুন।',
                            'status' => 'পরিকল্পিত / Planned',
                            'milestone' => 'M6',
                        ],
                        [
                            'number' => '07',
                            'title_bn' => 'শিক্ষা ও স্বাস্থ্য তথ্যভান্ডার',
                            'title_en' => 'Education & health directory',
                            'description' => 'স্কুল, কলেজ, হাসপাতাল ও স্বাস্থ্যকেন্দ্রের যাচাইকৃত তথ্য।',
                            'status' => 'পরিকল্পিত / Planned',
                            'milestone' => 'M6',
                        ],
                        [
                            'number' => '08',
                            'title_bn' => 'সড়ক, অবকাঠামো ও জিআইএস',
                            'title_en' => 'Roads, infrastructure & GIS',
                            'description' => 'সড়ক ও অবকাঠামোর তথ্য, মানচিত্র স্তর এবং অবস্থানভিত্তিক অনুসন্ধান।',
                            'status' => 'পরিকল্পিত / Planned',
                            'milestone' => 'M6–M7',
                        ],
                    ];
                @endphp

                @foreach ($services as $service)
                    <article @isset($service['id']) id="{{ $service['id'] }}" @endisset class="card flex scroll-mt-24 flex-col p-5 transition hover:-translate-y-0.5 hover:border-brand-300 hover:shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-brand-50 text-sm font-extrabold text-brand-700">{{ $service['number'] }}</span>
                            <span class="badge bg-amber-100 text-amber-900">{{ $service['status'] }}</span>
                        </div>
                        <h3 lang="bn" class="mt-4 text-base font-extrabold leading-7 text-slate-950">{{ $service['title_bn'] }}</h3>
                        <p lang="en" class="mt-0.5 text-sm font-semibold leading-5 text-brand-800">{{ $service['title_en'] }}</p>
                        <p lang="bn" class="mt-3 flex-1 text-sm leading-6 text-slate-600">{{ $service['description'] }}</p>
                        <p class="mt-4 border-t border-slate-100 pt-3 text-xs font-bold text-slate-500">Milestone {{ $service['milestone'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="portals" class="scroll-mt-24 py-14 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="section-eyebrow">ভূমিকা ও স্কোপ / Roles and scope</p>
                    <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950 sm:text-4xl">প্রতিটি ব্যবহারকারীর জন্য নির্ধারিত পোর্টাল</h2>
                    <p class="mt-3 text-base leading-7 text-slate-600">
                        নাগরিক, চেয়ারম্যান, এমপি ও সুপার অ্যাডমিন—প্রত্যেকের দেখার পরিধি আলাদা। ভবিষ্যতে সার্ভার প্রতিটি অনুরোধে
                        ভূমিকা ও ভৌগোলিক স্কোপ যাচাই করবে।
                    </p>
                </div>
                <a href="{{ route('prototype.admin.dashboard') }}" class="btn-secondary shrink-0">অ্যাডমিন প্লেসহোল্ডার / Admin placeholder</a>
            </div>

            <div class="mt-10 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                <article class="card flex flex-col border-t-4 border-t-brand-600 p-5">
                    <span class="badge w-fit bg-brand-100 text-brand-800">প্লেসহোল্ডার / Placeholder</span>
                    <h3 class="mt-4 text-lg font-extrabold text-slate-950">নাগরিক ড্যাশবোর্ড</h3>
                    <p class="text-sm font-semibold text-brand-800">Citizen dashboard</p>
                    <p class="mt-3 flex-1 text-sm leading-6 text-slate-600">নিজের প্রোফাইল, আবেদন, রিপোর্ট ও ওয়ার্ডভিত্তিক সেবার অবস্থা।</p>
                    <a href="{{ route('prototype.citizen.dashboard') }}" class="mt-5 text-sm font-bold text-brand-800 hover:text-brand-950">প্রোটোটাইপ দেখুন / Open prototype →</a>
                </article>

                <article class="card flex flex-col border-t-4 border-t-brand-600 p-5">
                    <span class="badge w-fit bg-slate-100 text-slate-600">পরিকল্পিত / Planned · M7</span>
                    <h3 class="mt-4 text-lg font-extrabold text-slate-950">চেয়ারম্যান পোর্টাল</h3>
                    <p class="text-sm font-semibold text-brand-800">Chairman portal</p>
                    <p class="mt-3 flex-1 text-sm leading-6 text-slate-600">নিজের ইউনিয়নের সেবা সারি, রিপোর্ট ও স্বেচ্ছাসেবক ব্যবস্থাপনা—ইউনিয়ন স্কোপে সীমাবদ্ধ।</p>
                    <p class="mt-5 text-xs font-bold text-slate-500">Scope: own union only</p>
                </article>

                <article class="card flex flex-col border-t-4 border-t-brand-600 p-5">
                    <span class="badge w-fit bg-slate-100 text-slate-600">পরিকল্পিত / Planned · M7</span>
                    <h3 class="mt-4 text-lg font-extrabold text-slate-950">এমপি পোর্টাল</h3>
                    <p class="text-sm font-semibold text-brand-800">MP portal</p>
                    <p class="mt-3 flex-1 text-sm leading-6 text-slate-600">উপজেলা পর্যায়ের সামগ্রিক তথ্য ও প্রবণতা; ব্যক্তিগত তথ্য নয়, ছোট গ্রুপ লুকানো থাকবে।</p>
                    <p class="mt-5 text-xs font-bold text-slate-500">Scope: upazila aggregate</p>
                </article>

                <article class="card flex flex-col border-t-4 border-t-amber-500 p-5">
                    <span class="badge w-fit bg-amber-100 text-amber-900">প্লেসহোল্ডার / Placeholder</span>
                    <h3 class="mt-4 text-lg font-extrabold text-slate-950">সুপার অ্যাডমিন</h3>
                    <p class="text-sm font-semibold text-brand-800">Super Admin console</p>
                    <p class="mt-3 flex-1 text-sm leading-6 text-slate-600">ভূমিকা, অনুমতি, ভূগোল, অডিট ও প্ল্যাটফর্ম কনফিগারেশনের পরিকল্পনা।</p>
                    <a href="{{ route('prototype.admin.dashboard') }}" class="mt-5 text-sm font-bold text-brand-800 hover:text-brand-950">প্রোটোটাইপ দেখুন / Open prototype →</a>
                </article>
            </div>
        </div>
    </section>

    <section id="about" class="scroll-mt-24 bg-white py-14 lg:py-20">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <p class="section-eyebrow">পরিকল্পিত যাত্রা / Planned journey</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950 sm:text-4xl">নাগরিক অভিজ্ঞতা হবে সহজ ও স্বচ্ছ</h2>
                <p class="mt-3 text-base leading-7 text-slate-600">
                    নিবন্ধন থেকে ফলো-আপ পর্যন্ত প্রতিটি ধাপে স্পষ্ট নির্দেশনা, অবস্থা ও দায়িত্ব থাকবে।
                </p>

                <ol class="mt-8 space-y-5">
                    @foreach ([
                        ['step' => '১', 'bn' => 'নিবন্ধন ও ভৌগোলিক নির্বাচন', 'en' => 'Register and select your union/ward', 'text' => 'মোবাইল যাচাইয়ের পর ইউনিয়ন ও ওয়ার্ড নির্বাচন করুন।'],
                        ['step' => '২', 'bn' => 'প্রয়োজনীয় সেবা খুঁজুন', 'en' => 'Find the right service', 'text' => 'যোগ্যতা, প্রয়োজনীয় কাগজপত্র ও দায়িত্বপ্রাপ্ত কর্তৃপক্ষ জানুন।'],
                        ['step' => '৩', 'bn' => 'আবেদন বা অনুরোধ জমা দিন', 'en' => 'Submit an application or request', 'text' => 'সংশ্লিষ্ট স্কোপের মধ্যে নিরাপদে জমা দিন এবং ট্র্যাকিং নম্বর নিন।'],
                        ['step' => '৪', 'bn' => 'অগ্রগতি ও সিদ্ধান্ত দেখুন', 'en' => 'Track progress and decisions', 'text' => 'প্রতিটি ধাপের সময়, অবস্থা ও পরবর্তী কাজ দেখুন।'],
                    ] as $item)
                        <li class="flex gap-4">
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-brand-700 text-sm font-extrabold text-white">{{ $item['step'] }}</span>
                            <div>
                                <p lang="bn" class="font-extrabold text-slate-950">{{ $item['bn'] }}</p>
                                <p lang="en" class="text-sm font-semibold text-brand-800">{{ $item['en'] }}</p>
                                <p lang="bn" class="mt-1 text-sm leading-6 text-slate-600">{{ $item['text'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>

            <div class="space-y-5">
                <div class="card p-6">
                    <div class="flex items-center gap-3">
                        <span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-100 text-brand-800">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4 6v6c0 4.4 3.4 8.4 8 9 4.6-.6 8-4.6 8-9V6l-8-3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-950">নিরাপত্তা ও গোপনীয়তা</h3>
                            <p class="text-sm font-semibold text-brand-800">Security and privacy commitments</p>
                        </div>
                    </div>
                    <ul class="mt-5 space-y-3 text-sm leading-6 text-slate-700">
                        <li>ভূমিকা ও ভৌগোলিক স্কোপ সার্ভার-সাইডে যাচাই হবে; শুধু ইন্টারফেসে লুকানো হবে না।</li>
                        <li>ব্যবহারকারী নিজের ক্ষমতার বাইরে অনুমতি দিতে পারবে না।</li>
                        <li>এনআইডি, স্বাস্থ্য, পারিবারিক ও আর্থিক তথ্যের জন্য সর্বনিম্ন প্রয়োজনীয়তা ও কঠোর অ্যাক্সেস নিয়ন্ত্রণ।</li>
                        <li>অডিট লগ, সম্মতি এবং ডেটা সংরক্ষণের সময়সীমা পরিকল্পনায় অন্তর্ভুক্ত।</li>
                    </ul>
                </div>

                <div class="card border-brand-200 bg-brand-50 p-6">
                    <h3 class="text-lg font-extrabold text-brand-950">স্বচ্ছ অবস্থান</h3>
                    <p class="mt-2 text-sm leading-7 text-brand-900">
                        এই প্ল্যাটফর্ম কোনো সরকারি অনুমোদনের দাবি করে না। ভবিষ্যতে কোনো সরকারি সংস্থা পরিচালনার দায়িত্ব নিলে
                        লিখিত অনুমোদন, আইনি পর্যালোচনা ও আনুষ্ঠানিক হস্তান্তর প্রক্রিয়ার প্রয়োজন হবে।
                    </p>
                    <a href="{{ route('home') }}#prototype-notice" class="mt-4 inline-block text-sm font-bold text-brand-800 underline decoration-brand-300 underline-offset-4 hover:text-brand-950">
                        সম্পূর্ণ ঘোষণা পড়ুন / Read the full notice
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-14 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl bg-brand-900 px-6 py-10 text-white sm:px-10 lg:flex lg:items-center lg:justify-between lg:gap-10">
                <div class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-200">প্রোটোটাইপ পর্যালোচনা / Prototype review</p>
                    <h2 class="mt-2 text-3xl font-extrabold tracking-tight">পাঁচটি প্রোটোটাইপ পৃষ্ঠা দেখুন</h2>
                    <p class="mt-3 text-sm leading-7 text-brand-100">
                        ল্যান্ডিং, লগইন, নিবন্ধন, নাগরিক ড্যাশবোর্ড ও অ্যাডমিন ড্যাশবোর্ড—সবই স্থির ও শুধু পড়ার জন্য।
                        Milestone 2-এ প্রকৃত অনুমোদন ও ভূগোল-ভিত্তিক অ্যাক্সেস foundation তৈরি হবে।
                    </p>
                </div>
                <div class="mt-6 flex flex-col gap-3 sm:flex-row lg:mt-0">
                    <a href="{{ route('prototype.login') }}" class="btn-inverse">লগইন / Login</a>
                    <a href="{{ route('prototype.register') }}" class="btn-inverse-outline">নিবন্ধন / Register</a>
                </div>
            </div>
        </div>
    </section>
@endsection
