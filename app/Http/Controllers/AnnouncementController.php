<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Admin sees all, patients see only active
        if (Auth::user()->role === 'admin') {
            $announcements = Announcement::with('creator')->latest()->get();
        } else {
            $announcements = Announcement::with('creator')->active()->latest()->get();
        }

        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('announcements.index')->with('error', 'Unauthorized access.');
        }

        return view('announcements.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('announcements.index')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,warning,urgent,general',
            'status' => 'required|in:active,inactive',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $validated['created_by'] = Auth::id();
        Announcement::create($validated);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function show(Announcement $announcement)
    {
        if (Auth::user()->role !== 'admin' && !$announcement->isValid()) {
            return redirect()->route('announcements.index')->with('error', 'Pengumuman tidak ditemukan.');
        }

        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('announcements.index')->with('error', 'Unauthorized access.');
        }

        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('announcements.index')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,warning,urgent,general',
            'status' => 'required|in:active,inactive',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $announcement->update($validated);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy(Announcement $announcement)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('announcements.index')->with('error', 'Unauthorized access.');
        }

        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dihapus!');
    }
}