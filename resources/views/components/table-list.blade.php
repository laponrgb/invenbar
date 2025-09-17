<div class="card-body p-0 table-responsive">
    <table class="table table-striped">
        @isset($header)
            <thead>
                {{ $header }}
            </thead>
        @endisset
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
