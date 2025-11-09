@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Obat</h2>

    <form action="/obat/{{ $obat->id }}" method="POST">
    @csrf
    @method('PUT')

        @include('obat.form', ['obat' => $obat])
        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('obat.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection
