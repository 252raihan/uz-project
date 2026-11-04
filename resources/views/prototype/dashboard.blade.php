@extends('layouts.portal')

@section('title', 'নাগরিক ড্যাশবোর্ড / Citizen dashboard — Prototype')

@section('content')
    <div class="rounded-2xl border border-amber-300 bg-amber-50 p-5" role="note">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-sm font-extrabold text-amber-950">প্লেসহোল্ডার ড্যাশবোর্ড / Placeholder dashboard</p>
                <p class="mt-1 text-sm leading-6 text-amber-900">
                    এটি একটি স্থির প্রোটোটাইপ পৃষ্ঠা। এখানে কোনো প্রকৃত লগইন, ব্যক্তিগত তথ্য বা সেবার ডেটা নেই।
                    This is a static prototype. There is no login, personal data, or service data on this page.
                </p>
            </div>
            <span class="badge w-fit bg-white text-amber-900 ring-1 ring-amber-300">No real data</span>
        </div>
    </div>

    <div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
        <div class="card p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">খোলা অনুরোধ / Open requests</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-950">0</p>
            <p class="mt-1 text-xs text-slate-500">Sample value</p>
        </div>
        <div class="card p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">সক্রিয় আবেদন / Active applications</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-950">2</p>
            <p class="mt-1 text-xs text-slate-500">Sample value</p>
        </div>
        <div class="card p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">সমস্যা রিপোর্ট / Problem reports</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-950">1</p>
            <p class="mt-1 text-xs text-slate-500">Sample value</p>
        </div>
        <div class="card p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">রক্তের অনুরোধ / Blood requests</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-950">0</p>
            <p class="mt-1 text-xs text-slate-500">Sample value</p>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
        <div class="space-y-6">
            <section class="card overflow-hidden" aria-labelledby="profile-heading">
                <div class="flex items-start justify-between gap-4 border-b border-slate-200 bg-slate-50 px-5 py-4">
                    <div>
                        <h2 id="profile-heading" class="text-lg font-extrabold text-slate-950">ডেমো নাগরিক প্রোফাইল</h2>
                        <p class="text-xs font-semibold text-brand-800">Demo citizen profile</p>
                    </div>
                    <span class="badge bg-slate-200 text-slate-700">ডেমো / Demo</span>
                </div>
                <div class="p-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        <span class="grid h-16 w-16 place-items-center rounded-full bg-brand-100 text-xl font-extrabold text-brand-800">ডেমো</span>
                        <div class="min-w-0">
                            <p class="text-xl font-extrabold text-slate-950">ডেমো নাগরিক / Demo Citizen</p>
                            <p class="mt-1 text-sm text-slate-600">{{ config('platform.demo_scope.union.bn') }} · {{ config('platform.demo_scope.ward.bn') }}</p>
                            <p class="mt-1 text-xs font-semibold text-amber-800">প্রোফাইল যাচাই হয়নি / Profile unverified · Prototype identity</p>
                        </div>
                    </div>

                    <dl class="mt-5 grid gap-4 rounded-xl border border-slate-200 p-4 text-sm sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">বিভাগ / Division</dt>
                            <dd class="mt-1 font-semibold text-slate-900">{{ config('platform.division.bn') }} / {{ config('platform.division.en') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">জেলা / District</dt>
                            <dd class="mt-1 font-semibold text-slate-900">{{ config('platform.district.bn') }} / {{ config('platform.district.en') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">উপজেলা / Upazila</dt>
                            <dd class="mt-1 font-semibold text-slate-900">{{ config('platform.upazila.bn') }} / {{ config('platform.upazila.en') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">ইউনিয়ন ও ওয়ার্ড / Union & ward</dt>
                            <dd class="mt-1 font-semibold text-slate-900">{{ config('platform.demo_scope.union.en') }} · {{ config('platform.demo_scope.ward.en') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-4 rounded-xl bg-brand-50 p-4 text-sm leading-6 text-brand-900">
                        <p class="font-bold">ওয়ার্ড স্কোপ / Ward scope</p>
                        <p class="mt-1">
                            ভবিষ্যতে আপনি শুধু নিজের ওয়ার্ড/ইউনিয়নের প্রাসঙ্গিক সেবা ও নিজের রেকর্ড দেখতে পাবেন।
                            আপনি অন্য ওয়ার্ডের ব্যক্তিগত রেকর্ড দেখতে পারবেন না।
                        </p>
                    </div>
                </div>
            </section>

            <section class="card p-5" aria-labelledby="actions-heading">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 id="actions-heading" class="text-lg font-extrabold text-slate-950">দ্রুত সেবা</h2>
                        <p class="text-xs font-semibold text-brand-800">Quick actions</p>
                    </div>
                    <span class="badge bg-slate-100 text-slate-600">পরিকল্পিত / Planned</span>
                </div>

                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    @foreach ([
                        ['bn' => 'রক্তের অনুরোধ করুন', 'en' => 'Request blood support', 'm' => 'M4'],
                        ['bn' => 'সুবিধার জন্য আবেদন', 'en' => 'Apply for a benefit', 'm' => 'M5'],
                        ['bn' => 'সমস্যা রিপোর্ট করুন', 'en' => 'Report a public problem', 'm' => 'M6'],
                        ['bn' => 'প্রোফাইল হালনাগাদ', 'en' => 'Update profile', 'm' => 'M3'],
                    ] as $action)
                        <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 p-4">
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $action['bn'] }}</p>
                                <p class="text-xs text-slate-500">{{ $action['en'] }}</p>
                            </div>
                            <span class="badge bg-slate-100 text-slate-600">{{ $action['m'] }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="mt-4 text-xs leading-5 text-slate-500">এই কাজগুলো এখন উপলব্ধ নয়; ভবিষ্যৎ মাইলফলকে চালু হবে। These actions are not available yet.</p>
            </section>
        </div>

        <div class="space-y-6">
            <section class="card p-5" aria-labelledby="activity-heading">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 id="activity-heading" class="text-lg font-extrabold text-slate-950">সাম্প্রতিক কার্যক্রম</h2>
                        <p class="text-xs font-semibold text-brand-800">Recent activity</p>
                    </div>
                    <span class="badge bg-amber-100 text-amber-900">ডেমো / Sample</span>
                </div>

                <ol class="mt-4 space-y-4">
                    @foreach ([
                        ['status' => 'পর্যালোচনায় / In review', 'title' => 'সুবিধা কর্মসূচির আবেদন', 'ref' => 'DEMO-APP-0003', 'date' => '২ নভেম্বর ২০২৬'],
                        ['status' => 'নিবন্ধিত / Logged', 'title' => 'ডেমো সমস্যা রিপোর্ট', 'ref' => 'DEMO-RPT-0011', 'date' => '১ নভেম্বর ২০২৬'],
                        ['status' => 'সক্রিয় / Active', 'title' => 'রক্তদাতা হিসেবে সম্মতি', 'ref' => 'DEMO-DONOR-0002', 'date' => '৩০ অক্টোবর ২০২৬'],
                    ] as $activity)
                        <li class="flex gap-3">
                            <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-brand-500" aria-hidden="true"></span>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-900">{{ $activity['title'] }}</p>
                                <p class="text-xs text-slate-500">{{ $activity['ref'] }} · {{ $activity['date'] }}</p>
                                <span class="badge mt-2 bg-slate-100 text-slate-600">{{ $activity['status'] }}</span>
                            </div>
                        </li>
                    @endforeach
                </ol>
                <p class="mt-4 rounded-lg bg-slate-50 p-3 text-xs leading-5 text-slate-500">
                    উপরের সব তথ্য কাল্পনিক ডেমো ডেটা। All values above are synthetic demo data.
                </p>
            </section>

            <section class="rounded-2xl border border-brand-200 bg-brand-50 p-5" aria-labelledby="privacy-heading">
                <h2 id="privacy-heading" class="text-lg font-extrabold text-brand-950">গোপনীয়তা ও নিরাপত্তা</h2>
                <p class="text-xs font-semibold text-brand-800">Privacy and security</p>
                <ul class="mt-3 space-y-2 text-sm leading-6 text-brand-900">
                    <li>প্রকৃত লগইন থাকলে সার্ভারই প্রতিটি স্কোপ যাচাই করবে।</li>
                    <li>এনআইডি ও আর্থিক তথ্য সর্বনিম্ন অ্যাক্সেসে থাকবে।</li>
                    <li>প্রোটোটাইপে প্রকৃত এনআইডি বা ব্যক্তিগত তথ্য দেবেন না।</li>
                    <li>সব সংবেদনশীল কার্যক্রম ভবিষ্যতে অডিট হবে।</li>
                </ul>
            </section>
        </div>
    </div>
@endsection
