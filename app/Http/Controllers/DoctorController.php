<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hariIni = Carbon::now()->dayOfWeek();

        $doctors = Doctor::whereHas('schedules', function ($query) use ($hariIni) {
            $query->where('hari', $hariIni);
        })->with([
                    'schedules' => function ($query) use ($hariIni) {
                        $query->where('hari', $hariIni);
                    }
                ])->get();

        $placeholderFotos = [
            'Miya' => 'https://placehold.co/120x120/EBF4FF/1E40AF?text=Miya',
            'Eudora' => 'https://placehold.co/120x120/FFF7E6/D97706?text=Eudora',
            'Tigreal' => 'https://placehold.co/120x120/F0F9FF/0284C7?text=Tigreal',
            'Rafaela' => 'https://placehold.co/120x120/F0FFF4/16A34A?text=Rafaela',
            'Zilong' => 'https://placehold.co/120x120/FEF2F2/DC2626?text=Zilong',
        ];
        $dokterList = $doctors->map(function ($doctor) use ($placeholderFotos) {

            $jadwalHariIni = $doctor->schedules->first();
            $status = 'Akan Mulai';
            if ($jadwalHariIni) {
                $sekarang = Carbon::now();
                $mulai = Carbon::parse($jadwalHariIni->jam_mulai);
                $selesai = Carbon::parse($jadwalHariIni->jam_selesai);

                if ($sekarang->between($mulai, $selesai)) {
                    $status = 'Sedang Praktek';
                }
            }
            $foto = $doctor->foto_url;
            if (!$foto) {
                $foto = $placeholderFotos[$doctor->nama] ?? 'https://placehold.co/120x120/E5E7EB/4B5563?text=Dokter';
            }



            return [
                'nama' => "Dr. " . $doctor->nama . ", " . $doctor->gelar,
                'spesialisasi' => $doctor->spesialisasi,
                'jam_praktek' => $jadwalHariIni ? Carbon::parse($jadwalHariIni->jam_mulai)->format('H:i') . ' - ' . Carbon::parse($jadwalHariIni->jam_selesai)->format('H:i') : 'N/A',
                'status' => $status,
                'foto_url' => $foto
            ];
        });

        return view('schedule', compact('dokterList'));
    }
}
