@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Obat</h2>

    <form action="{{ route('obat.store') }}" method="POST">
        @csrf
        @include('obat.form', ['obat' => null])
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('obat.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection
