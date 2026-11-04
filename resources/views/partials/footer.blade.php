<footer class="mt-16 border-t border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[1.3fr_0.7fr_0.7fr]">
            <div>
                @include('partials.brand')
                <p lang="bn" class="mt-5 max-w-md text-sm leading-7 text-slate-600">
                    ফুলবাড়ীয়া উপজেলার নাগরিক সেবা, জরুরি সহায়তা ও স্থানীয় তথ্য এক জায়গায় পাওয়ার একটি স্বাধীন সিভিক-টেকনোলজি উদ্যোগ।
                </p>
                <p lang="en" class="mt-2 max-w-md text-sm leading-6 text-slate-500">
                    An independent civic-technology initiative to make local services, emergency support, and public information easier to find.
                </p>
            </div>

            <div>
                <h2 class="text-sm font-extrabold text-slate-950">প্রোটোটাইপ / Prototype</h2>
                <ul class="mt-4 space-y-3 text-sm text-slate-600">
                    <li><a href="{{ route('home') }}#services" class="hover:text-brand-700">সেবাসমূহ / Services</a></li>
                    <li><a href="{{ route('home') }}#portals" class="hover:text-brand-700">পোর্টাল / Portals</a></li>
                    <li><a href="{{ route('prototype.login') }}" class="hover:text-brand-700">সাইন ইন / Sign in</a></li>
                    <li><a href="{{ route('prototype.register') }}" class="hover:text-brand-700">নিবন্ধন / Register</a></li>
                </ul>
            </div>

            <div>
                <h2 class="text-sm font-extrabold text-slate-950">স্কোপ / Scope</h2>
                <ul class="mt-4 space-y-3 text-sm text-slate-600">
                    <li>{{ config('platform.upazila.bn') }} / {{ config('platform.upazila.en') }}</li>
                    <li>{{ config('platform.district.bn') }}, {{ config('platform.division.bn') }}</li>
                    <li>Milestone 1 — Foundation</li>
                    <li>ভাষা / Language: বাংলা + English</li>
                </ul>
            </div>
        </div>

        <div class="mt-10 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-amber-950">
            <p lang="bn" class="text-sm font-bold leading-7">
                এটি একটি স্বাধীন প্রোটোটাইপ। এটি বাংলাদেশ সরকার, ফুলবাড়ীয়া উপজেলা প্রশাসন, কোনো ইউনিয়ন পরিষদ বা কোনো সরকারি সংস্থার অফিসিয়াল ওয়েবসাইট নয়। কোনো সরকারি অনুমোদনের দাবি করা হয় না।
            </p>
            <p lang="en" class="mt-2 text-sm leading-6 text-amber-900">
                This is an independent prototype. It is not an official website of the Government of Bangladesh,
                Phulbaria Upazila Administration, any Union Parishad, or any public authority. No government
                authorization is claimed.
            </p>
            <p class="mt-3 text-xs font-semibold leading-5 text-amber-800">
                Prototype build — authentication, NID verification, OTP, and business workflows are not implemented.
                No real personal data is collected or stored.
            </p>
        </div>

        <div class="mt-8 flex flex-col gap-3 border-t border-slate-200 pt-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} {{ config('platform.short_name.en') }} prototype. Built for review and planning.</p>
            <p>Laravel 13 · PHP 8.3 · Tailwind CSS 4</p>
        </div>
    </div>
</footer>
