@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 md:p-8 max-w-7xl">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="flex justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold ">Jadwal Dokter Hari Ini</h1>
                <p class="text-gray-600 mt-1">Temukan dokter yang sedang praktek dan buat janji.</p>
            </div>

            <a href="#" class="mt-2 md:mt-0 mb-4 btn btn-success text-white font-semibold py-2 px-5 rounded-lg"
                data-bs-toggle="modal" data-bs-target="#ketersediaanModal">
                Atur Ketersediaan Dokter
            </a>

        </div>
        <div class="grid grid-cols-2 md:grid-cols-2 gap-6">

            @forelse ($dokterList as $dokter)
                <div class="col mb-3">
                    <div class="card h-100 shadow-sm rounded-3 overflow-hidden bg-light">
                        <div class="card-body p-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-12 col-sm-4 text-center">

                                    <div class="bg-white rounded-3 d-flex align-items-center justify-content-center border"
                                        style="width: 100%; height: 120px;">
                                        <span class="text-muted small">Foto</span>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-8">
                                    <div>
                                        <h4 class="fw-bold mb-1">{{ $dokter['nama'] }}</h4>
                                        <p class="text-muted mb-2">{{ $dokter['spesialisasi'] }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <p class="small text-muted mb-0">Jam Praktek</p>
                                        <p class="fw-semibold fs-5 mb-0">{{ $dokter['jam_praktek'] }}</p>
                                    </div>
                                    <div>
                                        @if ($dokter['status'] == 'Sedang Praktek')
                                            <span class="badge bg-success rounded-pill px-3 py-2 fs-6">
                                                {{ $dokter['status'] }}
                                            </span>
                                        @else
                                            <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">
                                                {{ $dokter['status'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="md:col-span-2 p-8 text-center text-gray-500 bg-white rounded-xl shadow-lg">
                    Tidak ada dokter yang praktek hari ini.
                </div>
            @endforelse

        </div>

    </div>

    <div class="modal fade" id="ketersediaanModal" tabindex="-1" aria-labelledby="ketersediaanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5 fw-bold" id="ketersediaanModalLabel">Form Atur Ketersediaan Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Form Ketersediaan --}}
                    <form id="form-ketersediaan" action="{{ route('doctor.schedule.store') }}" method="POST">
                        @csrf

                        {{-- Container untuk notifikasi error (Bootstrap) --}}
                        <div id="modal-errors" class="alert alert-danger d-none" role="alert">
                            <ul id="error-list" class="mb-0"></ul>
                        </div>

                        <div class="mb-3">
                            <label for="doctor_id" class="form-label fw-bold">Pilih Dokter:</label>
                            {{-- Loop dari $allDoctors yang kita kirim dari controller --}}
                            <select name="doctor_id" id="doctor_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Dokter --</option>
                                @foreach ($allDoctors as $doctor)
                                    <option value="{{ $doctor->id }}">
                                        {{ $doctor->nama }} ({{ $doctor->spesialisasi }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="hari" class="form-label fw-bold">Pilih Hari:</label>
                            <select name="hari" id="hari" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Hari --</option>
                                <option value="0">Minggu</option>
                                <option value="1">Senin</option>
                                <option value="2">Selasa</option>
                                <option value="3">Rabu</option>
                                <option value="4">Kamis</option>
                                <option value="5">Jumat</option>
                                <option value="6">Sabtu</option>
                            </select>
                        </div>

                        {{-- Jam Mulai & Selesai --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jam_mulai" class="form-label fw-bold">Jam Mulai:</label>
                                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jam_selesai" class="form-label fw-bold">Jam Selesai:</label>
                                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    {{-- Tombol ini akan men-submit form dengan id "form-ketersediaan" --}}
                    <button type="submit" id="btn-submit-ketersediaan" class="btn btn-primary" form="form-ketersediaan">
                        Simpan Jadwal
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
