@php
    $message = session('success') ?? session('error');
    $type = session('success') ? 'success' : 'danger';
@endphp

@if ($message)
    <div 
        {{ $attributes->merge([
            'class' => 'form-control alert alert-dismissible fade show alert-' . $type,
            'role' => 'alert',
        ]) }}
    >
        {{ $message }}
    </div>
@endif
