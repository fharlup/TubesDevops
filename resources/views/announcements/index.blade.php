@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Pengumuman</h2>

    @if(Auth::user()->role === 'admin')
        <a href="{{ route('announcements.create') }}" class="btn btn-primary mb-3">+ Tambah Pengumuman</a>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th style="width: 25%">Judul</th>
                <th style="width: 35%">Isi Pengumuman</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Berakhir</th>
                <th>Dibuat Oleh</th>
                @if(Auth::user()->role === 'admin')
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($announcements as $announcement)
                <tr>
                    <td><strong>{{ $announcement->title }}</strong></td>
                    <td>{{ Str::limit($announcement->content, 100) }}</td>
                    <td>
                        <span class="badge bg-{{ $announcement->badge_color }}">
                            {{ $announcement->type_label }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $announcement->status === 'active' ? 'success' : 'secondary' }}">
                            {{ $announcement->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td>{{ $announcement->start_date->format('d-m-Y') }}</td>
                    <td>{{ $announcement->end_date ? $announcement->end_date->format('d-m-Y') : '-' }}</td>
                    <td>{{ $announcement->creator->name }}</td>
                    @if(Auth::user()->role === 'admin')
                        <td class="d-flex gap-1">
                            <a href="{{ route('announcements.show', $announcement) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('announcements.edit', $announcement) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('announcements.destroy', $announcement) }}" method="POST">
                                @csrf 
                                @method('DELETE')
                                <button onclick="return confirm('Yakin mau hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    @else
                        <td>
                            <a href="{{ route('announcements.show', $announcement) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ Auth::user()->role === 'admin' ? '8' : '7' }}" class="text-center">Tidak ada pengumuman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection