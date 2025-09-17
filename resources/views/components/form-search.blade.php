<form action="?" method="get">
    <div class="input-group">
        <input 
            {{ $attributes->merge([
                'class' => 'form-control',
                'type' => 'text',
                'name' => 'search',
                'value' => request('search')
            ]) }}
        >
        <button class="btn btn-primary" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </div>
</form>
