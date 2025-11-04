@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Data Tagihan Pasien</h1>
        <a href="{{ route('tagihan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Tagihan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>No Invoice</th>
                            <th>Nama Pasien</th>
                            <th>Total Tagihan</th>
                            <th>Status</th>
                            <th>Tanggal Tagihan</th>
                            <th>Tanggal Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tagihan as $index => $t)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $t->no_tagihan }}</strong></td>
                            <td>{{ $t->name }}</td>
                            <td>Rp {{ number_format($t->total_tagihan, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $t->status == 'lunas' ? 'success' : 'warning' }}">
                                    {{ $t->status == 'lunas' ? 'Lunas' : 'Belum Bayar' }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($t->tanggal_tagihan)->format('d/m/Y') }}</td>
                            <td>{{ $t->tanggal_bayar ? \Carbon\Carbon::parse($t->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tagihan.edit', $t->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('tagihan.destroy', $t->id) }}" method="POST" style="display:inline" 
                                          onsubmit="return confirm('Yakin hapus tagihan {{ $t->no_tagihan }} atas nama {{ $t->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">Belum ada data tagihan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tagihan->count() > 0)
            <div class="mt-3">
                <small class="text-muted">Total: {{ $tagihan->count() }} tagihan</small>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection