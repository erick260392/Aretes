@props(['active' => false, 'vertical' => false])

@php
if ($vertical) {
    $classes = ($active ?? false)
                ? 'block w-full rounded-lg px-4 py-2 text-sm font-semibold bg-[color:rgba(201,168,76,0.18)] text-[color:var(--gold-light)] ring-1 ring-[color:rgba(201,168,76,0.28)]'
                : 'block w-full rounded-lg px-4 py-2 text-sm font-semibold text-[color:var(--sidebar-muted)] hover:bg-[color:rgba(255,253,249,0.06)] hover:text-[color:var(--white)] focus:outline-none focus:ring-1 focus:ring-[color:rgba(201,168,76,0.25)] transition';
} else {
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[color:var(--gold)] text-sm font-semibold leading-5 text-[color:var(--ink)] focus:outline-none focus:border-[color:var(--gold-dark)] transition duration-150 ease-in-out'
                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-semibold leading-5 text-[color:var(--ink-muted)] hover:text-[color:var(--ink)] hover:border-[color:var(--cream-dark)] focus:outline-none focus:text-[color:var(--ink)] focus:border-[color:var(--gold)] transition duration-150 ease-in-out';
}
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
