@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 md:p-8 max-w-7xl">

        <div class="flex justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold ">Jadwal Dokter Hari Ini</h1>
                <p class="text-gray-600 mt-1">Temukan dokter yang sedang praktek dan buat janji.</p>
            </div>

            <div>
                <a href="#"
                    class="mt-2 md:mt-0 mb-4 btn btn-primary text-white font-semibold py-2 px-5 rounded-lg  hover:bg-blue-700">
                    Buat Janji Pemeriksaan
                </a>
            </div>

        </div>
        <div class="grid grid-cols-2 md:grid-cols-2 gap-6">

            @forelse ($dokterList as $dokter)
                <div class="col mb-3">
                <div class="card h-100 shadow-sm border-1 rounded-3 overflow-hidden bg-light">
                    <div class="card-body p-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-12 col-sm-4 text-center">

                                <div class="bg-white rounded-3 d-flex align-items-center justify-content-center border" style="width: 100%; height: 120px;">
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

@endsection
