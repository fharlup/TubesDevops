@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Data Tagihan</h3>

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

    <form action="{{ route('tagihan.update', $tagihan->id) }}" method="POST" id="formEditTagihan">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">No Invoice</label>
            <input type="text" class="form-control" value="{{ $tagihan->no_tagihan }}" readonly style="background-color: #e9ecef;">
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Pasien</label>
            <input type="text" class="form-control" value="{{ $tagihan->name }}" readonly style="background-color: #e9ecef;">
            <small class="text-muted">Nama pasien tidak dapat diubah</small>
        </div>

        <div class="mb-3">
            <label for="total_tagihan" class="form-label">Total Tagihan <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text">Rp.</span>
                <input type="text" name="total_tagihan" id="total_tagihan" class="form-control" 
                       value="{{ number_format($tagihan->total_tagihan, 0, ',', '.') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Tagihan</label>
            <input type="date" class="form-control" value="{{ $tagihan->tanggal_tagihan }}" readonly style="background-color: #e9ecef;">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-select" required>
                <option value="belum_bayar" {{ $tagihan->status == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                <option value="lunas" {{ $tagihan->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>

        <div class="mb-3" id="tanggalBayarGroup" style="display: {{ $tagihan->status == 'lunas' ? 'block' : 'none' }}">
            <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
            <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control" 
                   value="{{ $tagihan->tanggal_bayar ?? date('Y-m-d') }}">
            <small class="text-muted">Akan otomatis terisi hari ini jika dibiarkan kosong</small>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ route('tagihan.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
// Format input rupiah
const totalTagihanInput = document.getElementById('total_tagihan');
totalTagihanInput.addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value) {
        e.target.value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
});

// Format saat load
totalTagihanInput.addEventListener('focus', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    e.target.value = value;
});

totalTagihanInput.addEventListener('blur', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value) {
        e.target.value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
});

// Toggle tanggal bayar berdasarkan status
document.getElementById('status').addEventListener('change', function() {
    const tanggalBayarGroup = document.getElementById('tanggalBayarGroup');
    if (this.value === 'lunas') {
        tanggalBayarGroup.style.display = 'block';
    } else {
        tanggalBayarGroup.style.display = 'none';
        document.getElementById('tanggal_bayar').value = '';
    }
});

// Validasi form sebelum submit
document.getElementById('formEditTagihan').addEventListener('submit', function(e) {
    const totalTagihan = document.getElementById('total_tagihan').value.trim();
    const status = document.getElementById('status').value;

    let errors = [];

    if (!totalTagihan) errors.push('Total tagihan harus diisi');
    if (!status) errors.push('Status harus dipilih');

    if (errors.length > 0) {
        e.preventDefault();
        alert('Harap lengkapi semua field yang wajib diisi:\n\n' + errors.join('\n'));
        return false;
    }

    // Convert format rupiah ke angka biasa sebelum submit
    const totalInput = document.getElementById('total_tagihan');
    totalInput.value = totalInput.value.replace(/\./g, '');
});
</script>
@endsection