@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Hero Section --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold text-success mb-3">Selamat Datang, {{ Auth::user()->name ?? 'User' }} 👋</h1>
        <p class="text-muted fs-5">Sakit?? Makanya Jangan Minum Es.</p>
        <a href="#fitur" class="btn btn-success px-4 py-2 rounded-pill mt-3 shadow-sm">
            Lihat Fitur
        </a>
    </div>

    {{-- Feature Section --}}
    <div id="fitur" class="row g-4 mt-4">
        {{-- Schedule --}}
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100 rounded-4 p-4 text-center">
                <div class="text-primary mb-3">
                    <i class="bi bi-calendar-event fs-1"></i>
                </div>
                <h5 class="fw-semibold mb-2">Schedule</h5>
                <p class="text-muted mb-3">Atur dan pantau jadwal kegiatanmu dengan mudah.</p>
                <a href="{{ route('schedule') }}" class="btn btn-outline-primary btn-sm px-3">Lihat Jadwal</a>
            </div>
        </div>

        {{-- Medical Records --}}
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100 rounded-4 p-4 text-center">
                <div class="text-danger mb-3">
                    <i class="bi bi-file-medical fs-1"></i>
                </div>
                <h5 class="fw-semibold mb-2">Medical Records</h5>
                <p class="text-muted mb-3">Akses dan kelola data rekam medis secara aman.</p>
                <a href="{{ route('medical_records.index') }}" class="btn btn-outline-danger btn-sm px-3">Buka</a>
            </div>
        </div>

        {{-- Announcements --}}
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100 rounded-4 p-4 text-center">
                <div class="text-warning mb-3">
                    <i class="bi bi-megaphone fs-1"></i>
                </div>
                <h5 class="fw-semibold mb-2">Announcements</h5>
                <p class="text-muted mb-3">Dapatkan informasi dan pengumuman penting di sini.</p>
                <a href="{{ route('announcements.index') }}" class="btn btn-outline-warning btn-sm px-3">Lihat Pengumuman</a>
            </div>
        </div>

        {{-- Invoice --}}
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100 rounded-4 p-4 text-center">
                <div class="text-info mb-3">
                    <i class="bi bi-receipt fs-1"></i>
                </div>
                <h5 class="fw-semibold mb-2">Invoice</h5>
                <p class="text-muted mb-3">Lihat tagihan dan riwayat pembayaranmu dengan cepat.</p>
                <a href="{{ route('tagihan.index') }}" class="btn btn-outline-info btn-sm px-3">Cek Tagihan</a>
            </div>
        </div>
    </div>

    {{-- CTA Section --}}
    <div class="mt-5 p-5 bg-success bg-opacity-10 rounded-4 text-center">
        <h3 class="fw-bold text-success mb-3">Siap menjelajahi semuanya?</h3>
        <p class="text-muted mb-4">Gunakan fitur-fitur di atas untuk mengelola aktivitasmu dengan mudah dan efisien.</p>
        <a href="{{ route('schedule') }}" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">Mulai Sekarang</a>
    </div>

    {{-- Footer --}}
    <div class="text-center mt-5 text-muted small">
        &copy; {{ date('Y') }} Aplikasi Belum Tentu Bermanfaat Ahh Moment
    </div>
</div>
@endsection
