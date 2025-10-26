@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Rekam Medis</h2>

    <form action="{{ route('medical_records.store') }}" method="POST">
        @csrf
        @include('medical_records.form', ['record' => null])
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('medical_records.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection
