<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::orderBy('no_tagihan', 'asc')->get();
        return view('tagihan.index', compact('tagihan'));
    }

    public function create()
    {
        return view('tagihan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_tagihan' => 'required',
            'name' => 'required|string|max:255',
            'total_tagihan' => 'required',
            'tanggal_tagihan' => 'required|date',
        ], [
            'no_tagihan.required' => 'No tagihan harus diisi',
            'name.required' => 'Nama pasien harus diisi',
            'total_tagihan.required' => 'Total tagihan harus diisi',
            'tanggal_tagihan.required' => 'Tanggal tagihan harus diisi',
        ]);

        $noTagihan = 'INV-' . ltrim($request->no_tagihan, 'INV-');

        // Cek duplikasi no tagihan
        if (Tagihan::where('no_tagihan', $noTagihan)->exists()) {
            return back()->withInput()->with('error', 'No tagihan sudah ada! Gunakan nomor lain.');
        }

        // Cek duplikasi tagihan untuk pasien yang sama di tanggal yang sama
        $existingTagihan = Tagihan::where('name', $request->name)
            ->where('tanggal_tagihan', $request->tanggal_tagihan)
            ->where('total_tagihan', str_replace('.', '', $request->total_tagihan))
            ->first();

        if ($existingTagihan) {
            return back()->withInput()->with('warning', 'Peringatan: Pasien "' . $request->name . '" sudah memiliki tagihan dengan jumlah yang sama di tanggal yang sama. No tagihan: ' . $existingTagihan->no_tagihan);
        }

        $data = [
            'pasien_id' => null,
            'no_tagihan' => $noTagihan,
            'name' => $request->name,
            'total_tagihan' => str_replace('.', '', $request->total_tagihan),
            'tanggal_tagihan' => $request->tanggal_tagihan,
            'status' => 'belum_bayar',
        ];

        Tagihan::create($data);

        return redirect()->route('tagihan.index')->with('success', 'Data tagihan berhasil ditambahkan.');
    }

    public function edit(Tagihan $tagihan)
    {
        return view('tagihan.edit', compact('tagihan'));
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $request->validate([
            'total_tagihan' => 'required|numeric',
            'status' => 'required|in:belum_bayar,lunas',
            'tanggal_bayar' => 'nullable|date',
        ], [
            'total_tagihan.required' => 'Total tagihan harus diisi',
            'status.required' => 'Status harus dipilih',
        ]);

        $data = [
            'total_tagihan' => $request->total_tagihan,
            'status' => $request->status,
            'tanggal_bayar' => $request->status === 'lunas' ? ($request->tanggal_bayar ?? now()->format('Y-m-d')) : null,
        ];

        $tagihan->update($data);

        return redirect()->route('tagihan.index')->with('success', 'Data tagihan berhasil diperbarui.');
    }

    public function destroy(Tagihan $tagihan)
    {
        $tagihan->delete();
        return redirect()->route('tagihan.index')->with('success', 'Data tagihan berhasil dihapus.');
    }
}