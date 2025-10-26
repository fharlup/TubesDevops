@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Pengumuman</h2>

    <div class="card">
        <div class="card-header bg-{{ $announcement->badge_color }} text-white">
            <h4 class="mb-0">{{ $announcement->title }}</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px">Tipe</th>
                    <td>
                        <span class="badge bg-{{ $announcement->badge_color }}">
                            {{ $announcement->type_label }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge bg-{{ $announcement->status === 'active' ? 'success' : 'secondary' }}">
                            {{ $announcement->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td>{{ $announcement->start_date->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Berakhir</th>
                    <td>{{ $announcement->end_date ? $announcement->end_date->format('d F Y') : 'Tidak ada batas waktu' }}</td>
                </tr>
                <tr>
                    <th>Dibuat Oleh</th>
                    <td>{{ $announcement->creator->name }}</td>
                </tr>
                <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ $announcement->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            </table>

            <hr>

            <h5 class="mb-3">Isi Pengumuman:</h5>
            <div class="border rounded p-3 bg-light">
                {!! nl2br(e($announcement->content)) !!}
            </div>

            <hr>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('announcements.index') }}" class="btn btn-secondary">Kembali</a>
                
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('announcements.edit', $announcement) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin mau hapus?')" class="btn btn-danger">Hapus</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection