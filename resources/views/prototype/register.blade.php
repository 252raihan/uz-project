@extends('layouts.public')

@section('title', 'নিবন্ধন / Registration — '.config('platform.short_name.en').' Prototype')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <nav class="text-sm text-slate-500" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="font-semibold text-brand-800 hover:text-brand-950">হোম / Home</a>
            <span class="mx-2 text-slate-300" aria-hidden="true">/</span>
            <span>নাগরিক নিবন্ধন / Citizen registration</span>
        </nav>

        <div class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,1fr)_22rem] lg:items-start">
            <div class="card overflow-hidden">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-5 sm:px-8">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="section-eyebrow">নাগরিক অ্যাকাউন্ট / Citizen account</p>
                            <h1 class="mt-1 text-2xl font-extrabold tracking-tight text-slate-950 sm:text-3xl">নিবন্ধন ফর্ম</h1>
                            <p class="text-sm font-semibold text-brand-800">Registration prototype</p>
                        </div>
                        <span class="badge bg-amber-100 text-amber-900">প্রোটোটাইপ / Prototype</span>
                    </div>
                </div>

                <div class="border-b border-amber-200 bg-amber-50 px-6 py-4 sm:px-8" role="note">
                    <p class="text-sm font-extrabold text-amber-950">কোনো তথ্য জমা হবে না / Nothing will be submitted</p>
                    <p class="mt-1 text-sm leading-6 text-amber-900">
                        এই ফর্মটি শুধু নকশা পর্যালোচনার জন্য। নিবন্ধন ও ভৌগোলিক নির্বাচন Milestone 2–3-এ তৈরি হবে।
                        Milestone 1 does not create accounts, write to a database, or send data anywhere.
                    </p>
                </div>

                {{--
                    Milestone 1: non-functional visual prototype. No action and no
                    method, so requester values can never be submitted (GET or POST).
                    Inputs that would carry personal data are disabled.
                --}}
                <form class="space-y-8 px-6 py-6 sm:px-8 sm:py-8" novalidate aria-describedby="register-disabled-note" aria-disabled="true" data-prototype="non-functional">
                    <section aria-labelledby="personal-heading">
                        <div class="flex items-center gap-3">
                            <span class="grid h-8 w-8 place-items-center rounded-full bg-brand-700 text-xs font-extrabold text-white">১</span>
                            <div>
                                <h2 id="personal-heading" class="text-lg font-extrabold text-slate-950">ব্যক্তিগত তথ্য</h2>
                                <p class="text-xs font-semibold uppercase tracking-wide text-brand-700">Personal information</p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-5 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="full-name" class="field-label">পূর্ণ নাম <span lang="en" class="font-semibold text-slate-500">Full name</span></label>
                                <input id="full-name" name="full_name" type="text" class="field-input" autocomplete="off" placeholder="স্বেচ্ছাসেবী নমুনা / Sample text only" disabled>
                            </div>
                            <div>
                                <label for="mobile" class="field-label">মোবাইল নম্বর <span lang="en" class="font-semibold text-slate-500">Mobile number</span></label>
                                <input id="mobile" name="mobile" type="tel" class="field-input" autocomplete="off" inputmode="tel" placeholder="01XXXXXXXXX (disabled)" aria-describedby="mobile-help" disabled>
                                <p id="mobile-help" class="field-help">ভবিষ্যতে ওটিপি যাচাইয়ের জন্য ব্যবহৃত হবে।</p>
                            </div>
                            <div>
                                <label for="email" class="field-label">ইমেইল <span class="font-semibold text-slate-500">(ঐচ্ছিক / optional)</span></label>
                                <input id="email" name="email" type="email" class="field-input" autocomplete="off" placeholder="name@example.com (disabled)" disabled>
                            </div>
                        </div>
                    </section>

                    <section class="border-t border-slate-200 pt-8" aria-labelledby="geography-heading">
                        <div class="flex items-center gap-3">
                            <span class="grid h-8 w-8 place-items-center rounded-full bg-brand-700 text-xs font-extrabold text-white">২</span>
                            <div>
                                <h2 id="geography-heading" class="text-lg font-extrabold text-slate-950">ভৌগোলিক নির্বাচন</h2>
                                <p class="text-xs font-semibold uppercase tracking-wide text-brand-700">Geographic selection</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            আপনার ইউনিয়ন/পৌরসভা ও ওয়ার্ড নির্বাচন করুন। ভবিষ্যতে এই স্কোপের ভিত্তিতেই সেবা ও ডেটা দেখা যাবে।
                        </p>

                        <div class="mt-5 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="division" class="field-label">বিভাগ <span lang="en" class="font-semibold text-slate-500">Division</span></label>
                                <input id="division" type="text" class="field-input" value="{{ config('platform.division.bn') }} / {{ config('platform.division.en') }}" disabled>
                            </div>
                            <div>
                                <label for="district" class="field-label">জেলা <span lang="en" class="font-semibold text-slate-500">District</span></label>
                                <input id="district" type="text" class="field-input" value="{{ config('platform.district.bn') }} / {{ config('platform.district.en') }}" disabled>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="upazila" class="field-label">উপজেলা <span lang="en" class="font-semibold text-slate-500">Upazila</span></label>
                                <input id="upazila" type="text" class="field-input" value="{{ config('platform.upazila.bn') }} / {{ config('platform.upazila.en') }}" disabled>
                                <p class="field-help">এই প্রোটোটাইপটি শুধু ফুলবাড়ীয়া উপজেলার জন্য। / This prototype is scoped to Phulbaria Upazila.</p>
                            </div>
                            <div>
                                <label for="union" class="field-label">ইউনিয়ন / পৌরসভা <span lang="en" class="font-semibold text-slate-500">Union / Municipality</span></label>
                                <select id="union" name="union" class="field-input" aria-describedby="union-help" disabled>
                                    <option value="">নির্বাচন করুন / Select</option>
                                    @foreach (config('platform.unions') as $index => $union)
                                        <option value="{{ $index + 1 }}">{{ $union['bn'] }} / {{ $union['en'] }}</option>
                                    @endforeach
                                </select>
                                <p id="union-help" class="field-help">ডেমো তালিকা: ১৩টি ইউনিয়ন ও ১টি পৌরসভা। / Demo list: 13 unions + 1 municipality.</p>
                            </div>
                            <div>
                                <label for="ward" class="field-label">ওয়ার্ড <span lang="en" class="font-semibold text-slate-500">Ward</span></label>
                                <select id="ward" name="ward" class="field-input" disabled>
                                    <option value="">নির্বাচন করুন / Select</option>
                                    @foreach (config('platform.wards') as $ward)
                                        <option value="{{ $ward }}">ওয়ার্ড {{ $ward }} / Ward {{ $ward }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 rounded-xl border border-brand-200 bg-brand-50 p-4 text-sm leading-6 text-brand-900">
                            <p class="font-bold">ভৌগোলিক স্কোপ নিয়ম / Geographic scope rule</p>
                            <p class="mt-1">ব্যবহারকারীর ভূমিকা ও নির্বাচিত এলাকা অনুযায়ীই তথ্য দেখা যাবে। কেউ অন্য ইউনিয়ন বা ওয়ার্ডের ব্যক্তিগত তথ্য দেখতে পারবে না।</p>
                        </div>
                    </section>

                    <section class="border-t border-slate-200 pt-8" aria-labelledby="security-heading">
                        <div class="flex items-center gap-3">
                            <span class="grid h-8 w-8 place-items-center rounded-full bg-brand-700 text-xs font-extrabold text-white">৩</span>
                            <div>
                                <h2 id="security-heading" class="text-lg font-extrabold text-slate-950">অ্যাকাউন্ট সুরক্ষা</h2>
                                <p class="text-xs font-semibold uppercase tracking-wide text-brand-700">Account security</p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="password" class="field-label">পাসওয়ার্ড <span lang="en" class="font-semibold text-slate-500">Password</span></label>
                                <input id="password" name="password" type="password" class="field-input" autocomplete="off" placeholder="••••••••" disabled>
                                <p class="field-help">কমপক্ষে ১২ অক্ষর ব্যবহারের পরিকল্পনা। / Minimum 12 characters planned.</p>
                            </div>
                            <div>
                                <label for="password-confirmation" class="field-label">পাসওয়ার্ড নিশ্চিত করুন <span lang="en" class="font-semibold text-slate-500">Confirm password</span></label>
                                <input id="password-confirmation" name="password_confirmation" type="password" class="field-input" autocomplete="off" placeholder="••••••••" disabled>
                            </div>
                        </div>

                        <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4">
                            <p class="text-sm font-extrabold text-amber-950">এনআইডি সম্পর্কে গুরুত্বপূর্ণ নোট</p>
                            <p class="mt-1 text-sm leading-6 text-amber-900">
                                এই প্রোটোটাইপে প্রকৃত এনআইডি নম্বর লিখবেন না। এনআইডি যাচাই শুধু আইনি ভিত্তি, অনুমোদিত ইন্টিগ্রেশন
                                ও লিখিত অনুমোদনের পর যুক্ত হবে। Do not enter a real NID number in this prototype.
                            </p>
                        </div>

                        <label class="mt-5 flex items-start gap-3 rounded-xl border border-slate-200 p-4 text-sm leading-6 text-slate-700">
                            <input type="checkbox" name="consent" class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-500" disabled>
                            <span>
                                আমি গোপনীয়তা নোটিশ ও পরিষেবার শর্তাবলি পড়েছি এবং সম্মতি দিচ্ছি।
                                <span lang="en" class="block text-slate-500">I have read the privacy notice and terms, and I consent. (A real consent record will be implemented later.)</span>
                            </span>
                        </label>
                    </section>

                    <div class="border-t border-slate-200 pt-6">
                        <button type="submit" class="btn-primary w-full" disabled aria-describedby="register-disabled-note">
                            নিবন্ধন জমা দিন / Submit registration (disabled)
                        </button>
                        <p id="register-disabled-note" class="mt-3 text-center text-xs leading-5 text-slate-500">
                            Milestone 2-এ প্রকৃত নিবন্ধন ও যাচাইয়ের foundation তৈরি হবে। Registration is disabled in this prototype.
                            Nothing typed here is sent to the server, by GET or by POST.
                        </p>
                        <p class="mt-4 text-center text-sm text-slate-600">
                            আগে থেকেই অ্যাকাউন্ট আছে? <a href="{{ route('prototype.login') }}" class="font-bold text-brand-800 hover:text-brand-950">সাইন ইন প্রোটোটাইপ / Sign-in prototype</a>
                        </p>
                    </div>
                </form>
            </div>

            <aside class="space-y-5">
                <div class="rounded-2xl border border-brand-200 bg-brand-50 p-6">
                    <p class="section-eyebrow">ধাপে ধাপে / Step by step</p>
                    <h2 class="mt-2 text-lg font-extrabold text-brand-950">নিবন্ধনের পরিকল্পিত ধাপ</h2>
                    <ol class="mt-4 space-y-4 text-sm leading-6 text-brand-900">
                        <li class="flex gap-3">
                            <span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-white text-xs font-extrabold text-brand-800 ring-1 ring-brand-200">১</span>
                            <span>মৌলিক তথ্য ও ভৌগোলিক এলাকা নির্বাচন।</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-white text-xs font-extrabold text-brand-800 ring-1 ring-brand-200">২</span>
                            <span>মোবাইল ওটিপি যাচাই (পরবর্তী মাইলফলক)।</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-white text-xs font-extrabold text-brand-800 ring-1 ring-brand-200">৩</span>
                            <span>গোপনীয়তা নোটিশের সংস্করণসহ সম্মতি রেকর্ড।</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-white text-xs font-extrabold text-brand-800 ring-1 ring-brand-200">৪</span>
                            <span>অ্যাকাউন্ট সক্রিয়করণ ও ওয়ার্ডভিত্তিক ড্যাশবোর্ড।</span>
                        </li>
                    </ol>
                </div>

                <div class="card p-6">
                    <h2 class="text-base font-extrabold text-slate-950">তথ্য সর্বনিম্ন রাখা হবে</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        শুধু সেবা দেওয়ার জন্য প্রয়োজনীয় তথ্যই চাওয়া হবে। স্বাস্থ্য, পারিবারিক বা আর্থিক তথ্য প্রয়োজন
                        না হলে সংগ্রহ করা হবে না। Data minimisation is a project principle.
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 text-sm text-slate-600">
                    <p class="font-bold text-slate-900">প্রোটোটাইপ নিরাপত্তা / Prototype safety</p>
                    <p class="mt-2 leading-6">
                        কোনো তথ্য জমা হবে না, কোনো ডেটাবেস লেখা হবে না, এবং কোনো প্রকৃত ব্যক্তিগত তথ্য ব্যবহার করা হবে না।
                        Nothing is submitted, stored, or sent.
                    </p>
                </div>
            </aside>
        </div>
    </div>
@endsection
