<div class="mb-3">
    <label for="nama_obat" class="form-label">Nama Obat</label>
    <input type="text" name="nama_obat" class="form-control" 
           value="{{ old('nama_obat', optional($obat)->nama_obat) }}" required>
</div>

<div class="mb-3">
    <label for="kategori" class="form-label">Kategori</label>
    <input type="text" name="kategori" class="form-control"
           value="{{ old('kategori', optional($obat)->kategori) }}">
</div>

<div class="mb-3">
    <label for="stok" class="form-label">Stok</label>
    <input type="number" name="stok" class="form-control" min="0"
           value="{{ old('stok', optional($obat)->stok) }}" required>
</div>

<div class="mb-3">
    <label for="satuan" class="form-label">Satuan</label>
    <input type="text" name="satuan" class="form-control"
           value="{{ old('satuan', optional($obat)->satuan) }}" required>
</div>

<div class="mb-3">
    <label for="harga" class="form-label">Harga</label>
    <input type="number" step="0.01" name="harga" class="form-control"
           value="{{ old('harga', optional($obat)->harga) }}" required>
</div>

<div class="mb-3">
    <label for="deskripsi" class="form-label">Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', optional($obat)->deskripsi) }}</textarea>
</div>
