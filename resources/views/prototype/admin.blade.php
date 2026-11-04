@extends('layouts.portal')

@section('title', 'অ্যাডমিন ওভারভিউ / Admin dashboard — Prototype')

@section('content')
    <div class="rounded-2xl border border-amber-300 bg-amber-50 p-5" role="note">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-sm font-extrabold text-amber-950">অ্যাডমিন প্লেসহোল্ডার / Admin placeholder</p>
                <p class="mt-1 text-sm leading-6 text-amber-900">
                    এই পৃষ্ঠায় কোনো প্রকৃত অ্যাকাউন্ট, অনুমতি, অডিট লগ বা নাগরিক তথ্য নেই। সব সংখ্যা নমুনা।
                    There are no real accounts, permissions, audit logs, or citizen records here. All numbers are samples.
                </p>
            </div>
            <span class="badge w-fit bg-white text-amber-900 ring-1 ring-amber-300">Authorization not active</span>
        </div>
    </div>

    <div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
        <div class="card p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">ভৌগোলিক ইউনিট / Geographic units</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-950">15</p>
            <p class="mt-1 text-xs text-slate-500">13 unions + 1 municipality + upazila (sample)</p>
        </div>
        <div class="card p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">ভূমিকা / Roles</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-950">9</p>
            <p class="mt-1 text-xs text-slate-500">Design baseline, not implemented</p>
        </div>
        <div class="card p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">মডিউল / Modules</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-950">14</p>
            <p class="mt-1 text-xs text-slate-500">Planned modular monolith boundaries</p>
        </div>
        <div class="card p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">অডিট ইভেন্ট / Audit events</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-950">0</p>
            <p class="mt-1 text-xs text-slate-500">Audit logging not implemented</p>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1.05fr_0.95fr]">
        <section class="card overflow-hidden" aria-labelledby="roles-heading">
            <div class="flex items-center justify-between gap-3 border-b border-slate-200 bg-slate-50 px-5 py-4">
                <div>
                    <h2 id="roles-heading" class="text-lg font-extrabold text-slate-950">ভূমিকা ও স্কোপ</h2>
                    <p class="text-xs font-semibold text-brand-800">Role and scope baseline</p>
                </div>
                <span class="badge bg-slate-200 text-slate-700">Design only</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <caption class="sr-only">Prototype role scope baseline. Not enforced yet.</caption>
                    <thead class="bg-white text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-bold">ভূমিকা / Role</th>
                            <th scope="col" class="px-5 py-3 font-bold">স্কোপ / Scope</th>
                            <th scope="col" class="px-5 py-3 font-bold">অবস্থা / Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach ([
                            ['role' => 'নাগরিক / Citizen', 'scope' => 'নিজের রেকর্ড / Self', 'status' => 'Planned · M2'],
                            ['role' => 'স্বেচ্ছাসেবক / Volunteer', 'scope' => 'নির্ধারিত কাজ / Assigned tasks', 'status' => 'Planned · M4'],
                            ['role' => 'চেয়ারম্যান / Chairman', 'scope' => 'নিজের ইউনিয়ন / Own union', 'status' => 'Planned · M7'],
                            ['role' => 'এমপি / MP', 'scope' => 'উপজেলা সামগ্রিক / Upazila aggregate', 'status' => 'Planned · M7'],
                            ['role' => 'সুপার অ্যাডমিন / Super Admin', 'scope' => 'গ্লোবাল / Global', 'status' => 'Planned · M2'],
                        ] as $role)
                            <tr>
                                <td class="px-5 py-3 font-semibold text-slate-900">{{ $role['role'] }}</td>
                                <td class="px-5 py-3">{{ $role['scope'] }}</td>
                                <td class="px-5 py-3"><span class="badge bg-slate-100 text-slate-600">{{ $role['status'] }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 p-5">
                <p class="text-xs leading-5 text-slate-500">
                    ডিজাইন ম্যাট্রিক্স: <span class="font-semibold text-slate-700">docs/role-permission-matrix.md</span>।
                    একজন ব্যবহারকারী নিজের ক্ষমতার বাইরে ভূমিকা বা অনুমতি দিতে পারবেন না।
                </p>
            </div>
        </section>

        <section class="card p-5" aria-labelledby="guardrails-heading">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 id="guardrails-heading" class="text-lg font-extrabold text-slate-950">নিরাপত্তা গার্ডরেল</h2>
                    <p class="text-xs font-semibold text-brand-800">Planned security guardrails</p>
                </div>
                <span class="badge bg-amber-100 text-amber-900">Not active</span>
            </div>

            <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-700">
                @foreach ([
                    'সার্ভার-সাইড ভূমিকা ও ভৌগোলিক স্কোপ যাচাই / Server-side role and scope checks',
                    'নিজের ক্ষমতার বাইরে অনুমতি প্রদান বন্ধ / No delegation beyond own authority',
                    'শেষ সুপার অ্যাডমিন সুরক্ষা / Last Super Admin protection',
                    'মেকার-চেকার আর্থিক অনুমোদন / Maker-checker financial approvals',
                    'সংবেদনশীল তথ্যে অ্যাক্সেস লগ / Data access logging for sensitive records',
                    'ছোট গ্রুপের সামগ্রিক তথ্য লুকানো / Small-cell suppression in aggregates',
                ] as $guardrail)
                    <li class="flex gap-3">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>{{ $guardrail }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="mt-5 rounded-xl border border-red-200 bg-red-50 p-4">
                <p class="text-sm font-extrabold text-red-900">প্রোটোটাইপ সীমাবদ্ধতা / Prototype limitation</p>
                <p class="mt-1 text-sm leading-6 text-red-800">
                    এই প্যানেলে কোনো প্রশাসনিক নিয়ন্ত্রণ কাজ করে না। Do not use this screen to manage real users or data.
                </p>
            </div>
        </section>
    </div>

    <section class="card mt-6 overflow-hidden" aria-labelledby="modules-heading">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 bg-slate-50 px-5 py-4">
            <div>
                <h2 id="modules-heading" class="text-lg font-extrabold text-slate-950">মডিউল প্রস্তুতি</h2>
                <p class="text-xs font-semibold text-brand-800">Module readiness</p>
            </div>
            <span class="badge bg-slate-200 text-slate-700">Milestone 1</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <caption class="sr-only">Planned module readiness by milestone</caption>
                <thead class="bg-white text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th scope="col" class="px-5 py-3 font-bold">মডিউল / Module</th>
                        <th scope="col" class="px-5 py-3 font-bold">পরিকল্পিত মাইলফলক / Planned milestone</th>
                        <th scope="col" class="px-5 py-3 font-bold">অবস্থা / Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach ([
                        ['module' => 'ভূগোল ও স্কোপ / Geography & scope', 'milestone' => 'M2'],
                        ['module' => 'ভূমিকা ও অনুমতি / Roles & permissions', 'milestone' => 'M2'],
                        ['module' => 'অডিট বেসলাইন / Audit baseline', 'milestone' => 'M2'],
                        ['module' => 'রক্তদাতা ও জরুরি অনুরোধ / Blood', 'milestone' => 'M4'],
                        ['module' => 'স্বেচ্ছাসেবক / Volunteers', 'milestone' => 'M4'],
                        ['module' => 'সুবিধা কর্মসূচি / Benefits', 'milestone' => 'M5'],
                        ['module' => 'আর্থিক সহায়তা / Financial assistance', 'milestone' => 'M5–M6'],
                        ['module' => 'জনসমস্যা রিপোর্ট / Public reports', 'milestone' => 'M6'],
                        ['module' => 'প্রতিষ্ঠান ও অবকাঠামো / Institutions & infrastructure', 'milestone' => 'M6'],
                        ['module' => 'জিআইএস ও মানচিত্র / GIS & maps', 'milestone' => 'M6–M7'],
                        ['module' => 'চেয়ারম্যান ও এমপি পোর্টাল / Portals', 'milestone' => 'M7'],
                    ] as $module)
                        <tr>
                            <td class="px-5 py-3 font-semibold text-slate-900">{{ $module['module'] }}</td>
                            <td class="px-5 py-3">{{ $module['milestone'] }}</td>
                            <td class="px-5 py-3"><span class="badge bg-slate-100 text-slate-600">শুরু হয়নি / Not started</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
