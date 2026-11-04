@extends('layouts.public')

@section('title', 'সাইন ইন / Sign in — '.config('platform.short_name.en').' Prototype')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <nav class="text-sm text-slate-500" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="font-semibold text-brand-800 hover:text-brand-950">হোম / Home</a>
            <span class="mx-2 text-slate-300" aria-hidden="true">/</span>
            <span>সাইন ইন / Sign in</span>
        </nav>

        <div class="mt-6 grid gap-8 lg:grid-cols-[1fr_0.9fr] lg:items-start">
            <div class="card p-6 sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="section-eyebrow">নাগরিক প্রবেশ / Citizen access</p>
                        <h1 class="mt-1 text-2xl font-extrabold tracking-tight text-slate-950 sm:text-3xl">সাইন ইন করুন</h1>
                        <p class="text-sm font-semibold text-brand-800">Sign in to your account</p>
                    </div>
                    <span class="badge bg-amber-100 text-amber-900">প্রোটোটাইপ / Prototype</span>
                </div>

                <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4" role="note">
                    <p class="text-sm font-extrabold text-amber-950">এই ফর্মটি এখনো সংযুক্ত নয় / This form is not connected yet</p>
                    <p class="mt-1 text-sm leading-6 text-amber-900">
                        Milestone 1-এ প্রকৃত প্রমাণীকরণ তৈরি করা হয়নি। কোনো পাসওয়ার্ড সংরক্ষণ বা যাচাই করা হবে না।
                        Authentication is intentionally not implemented in Milestone 1. No credentials are stored or checked.
                    </p>
                </div>

                {{--
                    Milestone 1: this form is a non-functional visual prototype.
                    It deliberately has no action and no method, so it cannot submit
                    entered values anywhere. Fields keep name="" only for HTML
                    semantics; the submit button is disabled and the form is inert.
                --}}
                <form class="mt-6 space-y-5" novalidate aria-describedby="login-disabled-note" aria-disabled="true" data-prototype="non-functional">
                    <div>
                        <label for="login-identity" class="field-label">
                            মোবাইল নম্বর বা ইমেইল <span lang="en" class="font-semibold text-slate-500">Mobile number or email</span>
                        </label>
                        <input
                            id="login-identity"
                            name="identity"
                            type="text"
                            disabled
                            class="field-input"
                            autocomplete="off"
                            inputmode="text"
                            placeholder="01XXXXXXXXX / name@example.com"
                            aria-describedby="login-identity-help"
                        >
                        <p id="login-identity-help" class="field-help">পরবর্তী মাইলফলকে যাচাইকৃত মোবাইল নম্বর দিয়ে সাইন ইন করা যাবে।</p>
                    </div>

                    <div>
                        <div class="flex items-center justify-between gap-3">
                            <label for="login-password" class="field-label">
                                পাসওয়ার্ড <span lang="en" class="font-semibold text-slate-500">Password</span>
                            </label>
                            <span class="text-xs font-semibold text-slate-400" aria-disabled="true">পাসওয়ার্ড ভুলে গেছেন? / Forgot password?</span>
                        </div>
                        <input
                            id="login-password"
                            name="password"
                            type="password"
                            disabled
                            class="field-input"
                            autocomplete="off"
                            placeholder="••••••••"
                        >
                    </div>

                    <label class="flex items-start gap-3 text-sm leading-6 text-slate-700">
                        <input type="checkbox" name="remember" class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-500" disabled>
                        <span>আমাকে মনে রাখুন <span lang="en" class="text-slate-500">/ Remember me (disabled in prototype)</span></span>
                    </label>

                    <button type="submit" class="btn-primary w-full" disabled aria-describedby="login-disabled-note">
                        সাইন ইন / Sign in (disabled)
                    </button>
                    <p id="login-disabled-note" class="text-center text-xs leading-5 text-slate-500">
                        Milestone 1-এ সাইন-ইন বন্ধ আছে। Sign-in is disabled in this prototype.
                        Entered values are never sent to the server, by GET or by POST.
                    </p>
                </form>

                <div class="mt-6 border-t border-slate-200 pt-5 text-center text-sm text-slate-600">
                    নতুন ব্যবহারকারী? <span lang="en">New here?</span>
                    <a href="{{ route('prototype.register') }}" class="font-bold text-brand-800 hover:text-brand-950">নিবন্ধন প্রোটোটাইপ দেখুন / View registration prototype</a>
                </div>
            </div>

            <aside class="space-y-5">
                <div class="rounded-2xl border border-brand-200 bg-brand-50 p-6">
                    <h2 class="text-lg font-extrabold text-brand-950">ভবিষ্যতে কী থাকবে</h2>
                    <p class="text-sm font-semibold text-brand-800">What this will become</p>
                    <ul class="mt-4 space-y-3 text-sm leading-6 text-brand-900">
                        <li class="flex gap-3">
                            <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-700" aria-hidden="true"></span>
                            মোবাইল/ইমেইল ও পাসওয়ার্ড দিয়ে নিরাপদ সাইন ইন।
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-700" aria-hidden="true"></span>
                            ওয়ার্ডভিত্তিক নাগরিক ড্যাশবোর্ড ও সেবার অবস্থা।
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-700" aria-hidden="true"></span>
                            সংবেদনশীল তথ্যের জন্য সম্মতি, অডিট ও প্রবেশাধিকার নিয়ন্ত্রণ।
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-700" aria-hidden="true"></span>
                            প্রশাসনিক অ্যাকাউন্টের জন্য অতিরিক্ত সুরক্ষা ও MFA।
                        </li>
                    </ul>
                </div>

                <div class="card p-6">
                    <h2 class="text-base font-extrabold text-slate-950">কেন এখনই লগইন নেই?</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Milestone 1 শুধু ভিত্তি ও ইন্টারফেস পর্যালোচনার জন্য। প্রকৃত অ্যাকাউন্ট, ওটিপি, এনআইডি যাচাই বা
                        সংবেদনশীল তথ্য সংরক্ষণ পরবর্তী মাইলফলকে নির্ধারিত নিরাপত্তা নিয়ন্ত্রণসহ যুক্ত হবে।
                    </p>
                    <a href="{{ route('home') }}#prototype-notice" class="mt-4 inline-block text-sm font-bold text-brand-800 underline decoration-brand-300 underline-offset-4 hover:text-brand-950">
                        প্রোটোটাইপ ঘোষণা / Prototype notice
                    </a>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 text-sm text-slate-600">
                    <p class="font-bold text-slate-900">নিরাপত্তা নোট / Security note</p>
                    <p class="mt-2 leading-6">এখানে কোনো প্রকৃত পাসওয়ার্ড, এনআইডি বা ব্যক্তিগত তথ্য লিখবেন না। Do not enter real credentials or personal data.</p>
                </div>
            </aside>
        </div>
    </div>
@endsection
