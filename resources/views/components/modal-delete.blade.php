<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="#">
            @csrf
            @method('delete')
            <div class="modal-header">
                <h1 class="modal-title fs-5">
                    <i class="bi bi-exclamation-diamond text-danger"></i> Konfirmasi Hapus
                </h1>
            </div>
            <div class="modal-body">
                {{ __('Apakah Anda yakin ingin menghapus data ini?') }}
            </div>
            <div class="modal-footer">
                <x-secondary-button data-bs-dismiss="modal">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-danger-button>
                    {{ __('Ya, Hapus!') }}
                </x-danger-button>
            </div>
        </form>
    </div>
</div>
