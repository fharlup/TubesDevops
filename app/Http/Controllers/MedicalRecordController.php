<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['user', 'doctor'])->latest();

        if ($request->filled('nik')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('nik', $request->nik);
            });
        }

        $records = $query->get();

        return view('medical_records.index', compact('records'));
    }

    public function create()
    {
        $users = User::all();
        $doctors = Doctor::all();
        return view('medical_records.create', compact('users', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'tanggal_kunjungan' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosis' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep_obat' => 'nullable|string',
        ]);

        MedicalRecord::create($validated);
        return redirect()->route('medical_records.index')->with('success', 'Rekam medis berhasil ditambahkan!');
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $users = User::all();
        $doctors = Doctor::all();
        return view('medical_records.edit', compact('medicalRecord', 'users', 'doctors'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'tanggal_kunjungan' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosis' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep_obat' => 'nullable|string',
        ]);

        $medicalRecord->update($validated);
        return redirect()->route('medical_records.index')->with('success', 'Rekam medis berhasil diperbarui!');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();
        return redirect()->route('medical_records.index')->with('success', 'Rekam medis berhasil dihapus!');
    }
}
