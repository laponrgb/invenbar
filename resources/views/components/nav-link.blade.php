@props(['active'])

@php
    $classes = $active ? 'active' : '';
@endphp

<a {{ $attributes->merge(['class' => 'nav-link ' . $classes]) }}>
    {{ $slot }}
</a>
