@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Obat</h2>

    <a href="{{ route('obat.create') }}" class="btn btn-primary mb-3">+ Tambah Obat</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <form action="{{ route('obat.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari berdasarkan nama obat..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('obat.index') }}" class="btn btn-secondary ms-2">Reset</a>
        </form>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nama Obat</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Dibuat</th>
                <th>Diperbarui</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($obats as $obat)
                <tr>
                    <td>{{ $obat->nama_obat }}</td>
                    <td>{{ $obat->kategori ?? '-' }}</td>
                    <td>{{ $obat->stok }}</td>
                    <td>{{ $obat->satuan }}</td>
                    <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                    <td>{{ Str::limit($obat->deskripsi, 50) ?? '-' }}</td>
                    <td>{{ $obat->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $obat->updated_at->format('d-m-Y H:i') }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('obat.delete', $obat->id) }}" method="GET" onsubmit="return confirm('Yakin mau hapus obat ini?')">
                            @csrf
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data obat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
