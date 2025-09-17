@props(['name', 'show' => false, 'maxWidth' => 'lg'])

@php
    $maxWidth = [
        'sm' => 'modal-sm',
        'md' => 'modal-md',
        'lg' => 'modal-lg',
        'xl' => 'modal-xl',
    ][$maxWidth];
@endphp

<!-- Modal -->
<div class="modal fade" id="{{ $name }}" tabindex="-1" aria-labelledby="{{ $name }}Label" aria-hidden="true"
    data-modal="{{ $show }}">
    <div class="modal-dialog {{ $maxWidth }}">
        <div class="modal-content">
            <div class="modal-body p-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
