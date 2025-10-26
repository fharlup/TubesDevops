@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Rekam Medis</h2>

    <form action="{{ route('medical_records.update', $medicalRecord->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('medical_records.form', ['record' => $medicalRecord])
        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('medical_records.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection
