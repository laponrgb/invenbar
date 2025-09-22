<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input label="Kode Barang" name="kode_barang" :value="$barang->kode_barang ?? ''" />
    </div>
    <div class="col-md-6">
        <x-form-input label="Nama Barang" name="nama_barang" :value="$barang->nama_barang ?? ''" />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <x-form-select 
            label="Kategori" 
            name="kategori_id" 
            :value="$barang->kategori_id ?? ''"
            :option-data="$kategori" 
            option-label="nama_kategori" 
            option-value="id" 
        />
    </div>
    <div class="col-md-6">
        <x-form-select 
            label="Lokasi" 
            name="lokasi_id" 
            :value="$barang->lokasi_id ?? ''"
            :option-data="$lokasi" 
            option-label="nama_lokasi" 
            option-value="id" 
        />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input 
            label="Jumlah" 
            name="jumlah" 
            type="number" 
            :value="$barang->jumlah ?? ''" 
        />
    </div>
    <div class="col-md-6">
        <x-form-input 
            label="Satuan" 
            name="satuan" 
            :value="$barang->satuan ?? ''" 
        />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        @php
            $kondisi = [
                ['kondisi' => 'Baik'],
                ['kondisi' => 'Rusak Ringan'],
                ['kondisi' => 'Rusak Berat'],
            ];
        @endphp
        <x-form-select 
            label="Kondisi" 
            name="kondisi" 
            :value="$barang->kondisi ?? ''"
            :option-data="$kondisi" 
            option-label="kondisi" 
            option-value="kondisi" 
        />
    </div>
    <div class="col-md-6">
        @php
            $tanggal = isset($barang->tanggal_pengadaan) 
                ? date('Y-m-d', strtotime($barang->tanggal_pengadaan)) 
                : null;
        @endphp
        <x-form-input 
            label="Tanggal Pengadaan" 
            name="tanggal_pengadaan" 
            type="date" 
            :value="$tanggal" 
        />
    </div>
</div>

<div class="mb-3">
    <x-form-input 
        label="Gambar Barang" 
        name="gambar" 
        type="file" 
    />
</div>

<div class="mt-4">
    <x-primary-button>
        {{ isset($update) ? 'Update' : 'Simpan' }}
    </x-primary-button>
    <x-tombol-kembali :href="route('barang.index')" />
</div>
