<?php

namespace App\Http\Controllers;

use App\Models\{LaporanKerusakan, Infrastruktur};
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = LaporanKerusakan::with('user', 'infrastruktur');

        if (auth()->user()->role == 'warga') {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->paginate(10);

        // FIX: sudah benar sesuai folder laporan/user
        return view('laporan.user.index', compact('data'));
    }

    public function create()
    {
        $infrastruktur = Infrastruktur::all();

        // FIX: kalau kamu pakai folder user
        return view('laporan.user.create', compact('infrastruktur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_laporan'       => 'required',
            'lokasi_kerusakan'    => 'required',
            'deskripsi_kerusakan' => 'required',
            'foto'                => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('laporan', 'public');
        }

        LaporanKerusakan::create($data);

        return redirect('/laporan-kerusakan')
            ->with('success', 'Laporan berhasil dikirim!');
    }

    public function verifikasi(LaporanKerusakan $laporan_kerusakan)
{
    $laporan_kerusakan->load('user','infrastruktur');

    return view('laporan.admin.verifikasi', [
        'data' => $laporan_kerusakan
    ]);
}


    public function updateStatus(Request $request, $id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);

        $laporan->update([
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
            'save'         => $request->save,
            ]);

        return redirect('/laporan-kerusakan')
            ->with('success', 'Status berhasil diupdate!');
    }

    public function show($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);

        // FIX: sebelumnya salah folder
        return view('laporan.user.show', compact('laporan'));
    }

    public function edit($id)
{
    $data = LaporanKerusakan::findOrFail($id);

    // user hanya boleh edit miliknya
    if (auth()->user()->role === 'warga' && $data->user_id !== auth()->id()) {
        return redirect()->route('laporan.user.index')->with('error', 'Akses ditolak!');
    }

    $infrastruktur = Infrastruktur::all();

    return view('laporan.user.edit', compact('data','infrastruktur'));
}

    public function destroy($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);

        // user hanya boleh hapus miliknya
        if (auth()->user()->role === 'warga' && $laporan->user_id !== auth()->id()) {
            return redirect()->route('laporan.user.index')->with('error', 'Akses ditolak!');
        }

        $laporan->delete();

        return redirect('/laporan-kerusakan')
            ->with('success', 'Laporan berhasil dihapus!');
    }

    public function update(Request $request, $id)
{
    $laporan = LaporanKerusakan::findOrFail($id);

    if (auth()->user()->role === 'warga' && $laporan->user_id !== auth()->id()) {
        return redirect()->route('laporan.user.index')->with('error', 'Akses ditolak!');
    }

    $validated = $request->validate([
        'judul_laporan' => 'required',
        'lokasi_kerusakan' => 'required',
        'deskripsi_kerusakan' => 'required',
        'foto' => 'nullable|image|max:2048'
    ]);

    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('laporan','public');
    }

    if ($laporan->status !== 'menunggu') {
    return redirect()->route('laporan.user.index')
        ->with('error','Laporan tidak bisa diedit!');
    }

    $laporan->update($validated);

    return redirect()->route('laporan.user.index')->with('success','Laporan berhasil diupdate!');
}
}