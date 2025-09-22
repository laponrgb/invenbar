@props([
    'name',
    'label' => null,
    'value' => null,
    'type' => 'text',
    'disabled' => false,
])

@if ($label)
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
    </label>
@endif

@php
    $inputValue = in_array($type, ['password', 'file'])
        ? null
        : old($name, $value ?? '');
@endphp

<input 
    type="{{ $type }}" 
    class="form-control @error($name) is-invalid @enderror" 
    id="{{ $name }}"
    name="{{ $name }}"
    value="{{ $inputValue }}"
    @disabled($disabled)
/>

@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
