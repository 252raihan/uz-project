@php($inverse = $inverse ?? false)

<a href="{{ route('home') }}" class="group inline-flex items-center gap-3" aria-label="{{ config('platform.short_name.en') }} — home">
    <span class="grid h-11 w-11 place-items-center rounded-2xl {{ $inverse ? 'bg-white text-brand-900' : 'bg-brand-700 text-white' }} text-lg font-bold shadow-sm transition group-hover:scale-105">
        ফ
    </span>
    <span class="leading-tight">
        <span lang="bn" class="block text-base font-extrabold {{ $inverse ? 'text-white' : 'text-slate-950' }}">
            {{ config('platform.short_name.bn') }}
        </span>
        <span lang="en" class="mt-0.5 block text-[10px] font-bold uppercase tracking-[0.2em] {{ $inverse ? 'text-brand-100' : 'text-brand-700' }}">
            {{ config('platform.short_name.en') }}
        </span>
    </span>
</a>
