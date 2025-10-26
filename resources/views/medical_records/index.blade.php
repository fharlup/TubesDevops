@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Rekam Medis</h2>

    <a href="{{ route('medical_records.create') }}" class="btn btn-primary mb-3">+ Tambah Rekam Medis</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <form action="{{ route('medical_records.index') }}" method="GET" class="d-flex">
            <input type="text" name="nik" class="form-control me-2" placeholder="Cari berdasarkan NIK" value="{{ request('nik') }}">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('medical_records.index') }}" class="btn btn-secondary ms-2">Reset</a>
        </form>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal Kunjungan</th>
                <th>Keluhan</th>
                <th>Diagnosis</th>
                <th>Tindakan</th>
                <th>Resep Obat</th>
                <th>Dibuat</th>
                <th>Diperbarui</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
                <tr>
                    <td>{{ $record->user->name }}</td>
                    <td>{{ $record->doctor->nama ?? '-' }}</td>
                    <td>{{ $record->tanggal_kunjungan }}</td>
                    <td>{{ Str::limit($record->keluhan, 50) }}</td>
                    <td>{{ Str::limit($record->diagnosis, 50) ?? '-' }}</td>
                    <td>{{ Str::limit($record->tindakan, 50) ?? '-' }}</td>
                    <td>{{ Str::limit($record->resep_obat, 50) ?? '-' }}</td>
                    <td>{{ $record->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $record->updated_at->format('d-m-Y H:i') }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('medical_records.edit', $record->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('medical_records.destroy', $record->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Yakin mau hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">Tidak ada rekam medis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
