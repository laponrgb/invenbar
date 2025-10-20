<div class="row mb-3">
    <div class="col-md-12">
        <x-form-input label="Kode Peminjaman" name="kode_peminjaman" 
            :value="$peminjaman->kode_peminjaman ?? 'Akan dibuat otomatis'" 
            :readonly="true" 
            :disabled="true" />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <x-form-input label="Nama Peminjam" name="nama_peminjam" :value="$peminjaman->nama_peminjam ?? ''" required />
        <small class="text-danger error-message" data-for="nama_peminjam"></small>
    </div>
    <div class="col-md-4">
        <x-form-input label="Nomor Telepon" name="telepon_peminjam" :value="$peminjaman->telepon_peminjam ?? ''" required />
        <small class="text-danger error-message" data-for="telepon_peminjam"></small>
    </div>
    <div class="col-md-4">
        <x-form-input label="Email (Opsional)" name="email_peminjam" :value="$peminjaman->email_peminjam ?? ''" />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input type="date" label="Tanggal Peminjaman" name="tanggal_pinjam"
            :value="$peminjaman->tanggal_pinjam ?? now()->format('Y-m-d')" required />
        <small class="text-danger error-message" data-for="tanggal_pinjam"></small>
    </div>
    <div class="col-md-6">
        <x-form-input type="date" label="Tanggal Pengembalian" name="tanggal_kembali"
            :value="$peminjaman->tanggal_kembali ?? now()->addDays(7)->format('Y-m-d')" />
        <small class="text-danger error-message" data-for="tanggal_kembali"></small>
    </div>
</div>

<hr>
<h6>Barang yang Dipinjam</h6>

@php
    $jsonBarangs = $barangs->map(fn($b) => ['id'=>$b->id,'nama'=>$b->nama_barang,'stok'=>$b->jumlah_baik]);
@endphp

<div id="barang-list">
    @forelse($peminjaman->details ?? [] as $detail)
    <div class="row mb-2 barang-row position-relative">
        <div class="col-md-6 position-relative">
            <label>Barang</label>
            <input type="text" name="barang_nama[]" class="form-control barang-input"
                value="{{ $detail->barang->nama_barang }}" placeholder="Ketik nama barang..." required autocomplete="off">
            <input type="hidden" name="barang_id[]" value="{{ $detail->barang_id }}">
            <div class="autocomplete-list"></div>
            <small class="text-danger error-message" data-for="barang_id[]"></small>
        </div>
        <div class="col-md-4">
            <label>Jumlah</label>
            <input type="number" name="jumlah[]" class="form-control jumlah-input"
                min="0" max="{{ $detail->barang->jumlah_baik ?? 1 }}" value="{{ $detail->jumlah }}" required>
            <small class="text-danger error-message" data-for="jumlah[]"></small>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger btn-hapus-row">−</button>
        </div>
    </div>
    @empty
    <div class="row mb-2 barang-row position-relative">
        <div class="col-md-6 position-relative">
            <label>Barang</label>
            <input type="text" name="barang_nama[]" class="form-control barang-input"
                placeholder="Ketik nama barang..." required autocomplete="off">
            <input type="hidden" name="barang_id[]">
            <div class="autocomplete-list"></div>
            <small class="text-danger error-message" data-for="barang_id[]"></small>
        </div>
        <div class="col-md-4">
            <label>Jumlah</label>
            <input type="number" name="jumlah[]" class="form-control jumlah-input" min="0" value="1" required>
            <small class="text-danger error-message" data-for="jumlah[]"></small>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger btn-hapus-row">−</button>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-3"><button type="button" class="btn btn-success w-100" id="btn-tambah-row">+ Tambah Barang</button></div>
<div class="mt-4">
    <x-primary-button id="btn-submit">{{ isset($update) ? 'Update' : 'Simpan' }}</x-primary-button>
    <x-tombol-kembali :href="route('peminjaman.index')" />
</div>

<script>
const barangs=@json($jsonBarangs);
const barangList=document.getElementById('barang-list');

function createRow(data={}) {
    const row=document.createElement('div'); row.className='row mb-2 barang-row position-relative';
    row.innerHTML=`
    <div class="col-md-6 position-relative">
        <label>Barang</label>
        <input type="text" name="barang_nama[]" class="form-control barang-input" placeholder="Ketik nama barang..." autocomplete="off" value="${data.nama??''}" required>
        <input type="hidden" name="barang_id[]" value="${data.id??''}">
        <div class="autocomplete-list"></div>
        <small class="text-danger error-message" data-for="barang_id[]"></small>
    </div>
    <div class="col-md-4">
        <label>Jumlah</label>
        <input type="number" name="jumlah[]" class="form-control jumlah-input" min="0" max="${data.stok??1}" value="${data.jumlah??1}" required>
        <small class="text-danger error-message" data-for="jumlah[]"></small>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <button type="button" class="btn btn-danger btn-hapus-row">−</button>
    </div>`;
    barangList.appendChild(row); setupAutocomplete(row.querySelector('.barang-input'));
}

function highlightError(input,msg){input.classList.add('is-invalid'); const err=input.closest('div').querySelector('.error-message'); if(err) err.textContent=msg;}
function clearError(input){input.classList.remove('is-invalid'); const err=input.closest('div').querySelector('.error-message'); if(err) err.textContent='';}

function setupAutocomplete(input){
    const list=input.closest('.col-md-6').querySelector('.autocomplete-list');
    input.addEventListener('input',()=>{const val=input.value.toLowerCase().trim(); const row=input.closest('.barang-row'); const currentId=row.querySelector('input[name="barang_id[]"]').value; const selected=Array.from(document.querySelectorAll('input[name="barang_id[]"]')).map(i=>i.value).filter(v=>v && v!==currentId); list.innerHTML=''; if(!val)return list.style.display='none'; const filtered=barangs.filter(b=>b.nama.toLowerCase().includes(val) && !selected.includes(String(b.id))); if(!filtered.length)return list.style.display='none'; list.style.position='absolute'; list.style.top=`${input.offsetTop+input.offsetHeight}px`; list.style.left=`${input.offsetLeft}px`; list.style.width=`${input.offsetWidth}px`; list.style.display='block'; filtered.forEach(b=>{const item=document.createElement('div'); item.className='autocomplete-item'; item.textContent=`${b.nama} (Stok: ${b.stok})`; item.addEventListener('mousedown',()=>{input.value=b.nama; row.querySelector('input[name="barang_id[]"]').value=b.id; const j=row.querySelector('.jumlah-input'); j.max=b.stok; if(j.value>b.stok) j.value=b.stok; list.innerHTML=''; list.style.display='none';}); list.appendChild(item);});});
    input.addEventListener('blur',()=>setTimeout(()=>{list.innerHTML=''; list.style.display='none';},150));
}

document.addEventListener('DOMContentLoaded',()=>document.querySelectorAll('.barang-input').forEach(setupAutocomplete));

// Auto-update return date when borrowing date changes
document.addEventListener('DOMContentLoaded', () => {
    const tanggalPinjamInput = document.querySelector('input[name="tanggal_pinjam"]');
    const tanggalKembaliInput = document.querySelector('input[name="tanggal_kembali"]');
    
    if (tanggalPinjamInput && tanggalKembaliInput) {
        tanggalPinjamInput.addEventListener('change', () => {
            if (tanggalPinjamInput.value) {
                const pinjamDate = new Date(tanggalPinjamInput.value);
                const kembaliDate = new Date(pinjamDate);
                kembaliDate.setDate(kembaliDate.getDate() + 7);
                tanggalKembaliInput.value = kembaliDate.toISOString().split('T')[0];
            }
        });
    }
});

document.getElementById('btn-tambah-row').addEventListener('click',()=>createRow());
document.addEventListener('click',e=>{if(e.target.classList.contains('btn-hapus-row')){if(barangList.children.length>1)e.target.closest('.barang-row').remove();else highlightError(barangList.querySelector('.barang-input'),"Minimal satu barang harus dipinjam.");}});
document.addEventListener('input',e=>{if(e.target.classList.contains('jumlah-input')){const max=parseInt(e.target.max||1),min=parseInt(e.target.min||0),val=parseInt(e.target.value); if(val>max)e.target.value=max; if(val<min||isNaN(val))e.target.value=min;}});

document.getElementById('btn-submit').addEventListener('click',e=>{
    let valid=true; document.querySelectorAll('.form-control').forEach(clearError);
    [['nama_peminjam','Nama wajib diisi'],['telepon_peminjam','Nomor telepon wajib diisi'],['tanggal_pinjam','Tanggal wajib diisi']].forEach(([name,msg])=>{const el=document.querySelector(`input[name="${name}"]`); if(!el.value.trim()){highlightError(el,msg); valid=false;}});
    
    // Validasi tanggal pengembalian
    const tanggalPinjam = document.querySelector('input[name="tanggal_pinjam"]').value;
    const tanggalKembali = document.querySelector('input[name="tanggal_kembali"]').value;
    if(tanggalKembali && tanggalPinjam && tanggalKembali < tanggalPinjam) {
        highlightError(document.querySelector('input[name="tanggal_kembali"]'), 'Tanggal pengembalian tidak boleh lebih awal dari tanggal peminjaman');
        valid = false;
    }
    
    document.querySelectorAll('.barang-row').forEach(row=>{const nama=row.querySelector('.barang-input'),id=row.querySelector('input[name="barang_id[]"]'),jumlah=row.querySelector('.jumlah-input'),stok=parseInt(jumlah.max||1); if(!nama.value.trim()||!id.value.trim()){highlightError(nama,"Pilih barang dari daftar"); valid=false;} if(jumlah.value<0||jumlah.value>stok){highlightError(jumlah,`Jumlah antara 0 - ${stok}`); valid=false;}});
    if(!valid)e.preventDefault();
});
</script>

<style>
.is-invalid{border-color:#dc3545!important;background-color:#ffe8e8!important;}
.error-message{font-size:.85em;}
.btn-hapus-row{width:40px;height:40px;padding:0;font-size:1.4em;line-height:1;}
.autocomplete-list{background:#fff;border:1px solid #ddd;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,.1);z-index:2000;max-height:180px;overflow-y:auto;position:absolute;margin-top:2px;display:none;}
.autocomplete-item{padding:8px 10px;cursor:pointer;font-size:.95em;}
.autocomplete-item:hover{background-color:#f0f0f0;}
</style>
