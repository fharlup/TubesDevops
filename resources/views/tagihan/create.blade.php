@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Tambah Tagihan Baru</h3>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Peringatan!</strong> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Harap lengkapi form!</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('tagihan.store') }}" method="POST" id="formTagihan">
        @csrf

        <div class="mb-3">
            <label for="no_tagihan" class="form-label">No Invoice <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text">INV-</span>
                <input type="text" name="no_tagihan" id="no_tagihan" class="form-control" 
                       placeholder="001" value="{{ old('no_tagihan') }}" required>
            </div>
            <small class="text-muted">Masukkan nomor unik untuk invoice</small>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Pasien <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" 
                   placeholder="Masukkan nama pasien" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="total_tagihan" class="form-label">Total Tagihan <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text">Rp.</span>
                <input type="text" name="total_tagihan" id="total_tagihan" class="form-control" 
                       placeholder="100.000" value="{{ old('total_tagihan') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="tanggal_tagihan" class="form-label">Tanggal Tagihan <span class="text-danger">*</span></label>
            <input type="date" name="tanggal_tagihan" id="tanggal_tagihan" class="form-control" 
                   value="{{ old('tanggal_tagihan') }}" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('tagihan.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
// Format input rupiah
document.getElementById('total_tagihan').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value) {
        e.target.value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
});

// Validasi form sebelum submit
document.getElementById('formTagihan').addEventListener('submit', function(e) {
    const noTagihan = document.getElementById('no_tagihan').value.trim();
    const name = document.getElementById('name').value.trim();
    const totalTagihan = document.getElementById('total_tagihan').value.trim();
    const tanggalTagihan = document.getElementById('tanggal_tagihan').value;

    let errors = [];

    if (!noTagihan) errors.push('No invoice harus diisi');
    if (!name) errors.push('Nama pasien harus diisi');
    if (!totalTagihan) errors.push('Total tagihan harus diisi');
    if (!tanggalTagihan) errors.push('Tanggal tagihan harus diisi');

    if (errors.length > 0) {
        e.preventDefault();
        alert('Harap lengkapi semua field yang wajib diisi:\n\n' + errors.join('\n'));
        return false;
    }
});
</script>
@endsection