<?php

namespace App\Http\Controllers;

use App\Models\PengajuanPembangunan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    /**
     * Tampilkan daftar pengajuan pembangunan.
     * Warga hanya melihat miliknya sendiri.
     * Admin & Petugas melihat semua.
     */
    public function index(Request $request)
    {
        $query = PengajuanPembangunan::with('user');

        // Warga hanya bisa lihat pengajuan miliknya sendiri
        if (auth()->user()->role === 'warga') {
            $query->where('user_id', auth()->id());
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter prioritas
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        // Pencarian nama proyek / lokasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_proyek', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%')
                  ->orWhere('dusun', 'like', '%' . $search . '%');
            });
        }

        $data = $query->orderBy('id', 'desc')
                      ->paginate(10)
                      ->appends($request->query());

        return view('pengajuan.index', compact('data'));
    }

    /**
     * Tampilkan form pengajuan baru.
     */
    public function create()
    {
        return view('pengajuan.create');
    }

    /**
     * Simpan pengajuan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_proyek'    => 'required|string|max:200',
            'lokasi'         => 'required|string|max:255',
            'dusun'          => 'required|string|max:100',
            'alasan_usulan'  => 'required|string|min:20',
            'estimasi_biaya' => 'required|numeric|min:0',
            'prioritas'      => 'required|in:rendah,sedang,tinggi',
        ], [
            'nama_proyek.required'    => 'Nama proyek wajib diisi.',
            'lokasi.required'         => 'Lokasi wajib diisi.',
            'dusun.required'          => 'Dusun wajib diisi.',
            'alasan_usulan.required'  => 'Alasan pengajuan wajib diisi.',
            'alasan_usulan.min'       => 'Alasan pengajuan minimal 20 karakter.',
            'estimasi_biaya.required' => 'Estimasi biaya wajib diisi.',
            'estimasi_biaya.numeric'  => 'Estimasi biaya harus berupa angka.',
            'estimasi_biaya.min'      => 'Estimasi biaya tidak boleh negatif.',
            'prioritas.required'      => 'Prioritas wajib dipilih.',
            'prioritas.in'            => 'Prioritas tidak valid.',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status']  = 'diajukan';

        PengajuanPembangunan::create($validated);

        return redirect()->route('pengajuan.index')
                         ->with('success', 'Pengajuan pembangunan berhasil dikirim! Tunggu verifikasi dari admin.');
    }

    /**
     * Tampilkan detail pengajuan.
     */
    public function show($id)
    {
        $data = PengajuanPembangunan::with('user')->findOrFail($id);

        // Warga hanya bisa lihat miliknya
        if (auth()->user()->role === 'warga' && $data->user_id !== auth()->id()) {
            return redirect()->route('pengajuan.index')->with('error', 'Akses ditolak!');
        }

        return view('pengajuan.show', compact('data'));
    }

    /**
     * Tampilkan form edit pengajuan.
     */
    public function edit($id)
    {
        $data = PengajuanPembangunan::findOrFail($id);

        // Warga hanya bisa edit miliknya sendiri
        if (auth()->user()->role === 'warga' && $data->user_id !== auth()->id()) {
            return redirect()->route('pengajuan.index')->with('error', 'Akses ditolak!');
        }

        return view('pengajuan.edit', compact('data'));
    }

    /**
     * Perbarui data pengajuan.
     */
    public function update(Request $request, $id)
    {
        $item = PengajuanPembangunan::findOrFail($id);

        // Warga hanya bisa edit miliknya sendiri dan hanya saat status 'diajukan'
        if (auth()->user()->role === 'warga') {
            if ($item->user_id !== auth()->id()) {
                return redirect()->route('pengajuan.index')->with('error', 'Akses ditolak!');
            }
            if ($item->status !== 'diajukan') {
                return redirect()->route('pengajuan.index')
                                 ->with('error', 'Pengajuan yang sudah diproses tidak dapat diedit!');
            }
        }

        $validated = $request->validate([
            'nama_proyek'    => 'required|string|max:200',
            'lokasi'         => 'required|string|max:255',
            'dusun'          => 'required|string|max:100',
            'alasan_usulan'  => 'required|string|min:20',
            'estimasi_biaya' => 'required|numeric|min:0',
            'prioritas'      => 'required|in:rendah,sedang,tinggi',
        ], [
            'nama_proyek.required'    => 'Nama proyek wajib diisi.',
            'lokasi.required'         => 'Lokasi wajib diisi.',
            'dusun.required'          => 'Dusun wajib diisi.',
            'alasan_usulan.required'  => 'Alasan pengajuan wajib diisi.',
            'alasan_usulan.min'       => 'Alasan pengajuan minimal 20 karakter.',
            'estimasi_biaya.required' => 'Estimasi biaya wajib diisi.',
            'estimasi_biaya.numeric'  => 'Estimasi biaya harus berupa angka.',
            'prioritas.required'      => 'Prioritas wajib dipilih.',
        ]);

        // Admin & Petugas boleh update status juga lewat form edit
        if (in_array(auth()->user()->role, ['admin', 'petugas'])) {
            if ($request->filled('status')) {
                $request->validate(['status' => 'in:diajukan,disetujui,ditolak,selesai']);
                $validated['status'] = $request->status;
            }
            $validated['catatan_admin'] = $request->catatan_admin;
        }

        $item->update($validated);

        return redirect()->route('pengajuan.index')
                         ->with('success', 'Pengajuan berhasil diperbarui!');
    }

    /**
     * Hapus pengajuan.
     */
    public function destroy($id)
    {
        $item = PengajuanPembangunan::findOrFail($id);

        // Warga hanya bisa hapus miliknya sendiri dan hanya saat diajukan
        if (auth()->user()->role === 'warga') {
            if ($item->user_id !== auth()->id()) {
                return redirect()->route('pengajuan.index')->with('error', 'Akses ditolak!');
            }
            if ($item->status !== 'diajukan') {
                return redirect()->route('pengajuan.index')
                                 ->with('error', 'Pengajuan yang sudah diproses tidak dapat dihapus!');
            }
        }

        $item->delete();

        return redirect()->route('pengajuan.index')
                         ->with('success', 'Pengajuan berhasil dihapus.');
    }

    /**
     * Update status pengajuan (Admin & Petugas only).
     * Dipanggil dari modal/form di halaman index atau show.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'        => 'required|in:diajukan,disetujui,ditolak,selesai',
            'catatan_admin' => 'nullable|string|max:1000',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in'       => 'Status tidak valid.',
        ]);

        $item = PengajuanPembangunan::findOrFail($id);
        $item->update([
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->back()
                         ->with('success', 'Status pengajuan berhasil diperbarui menjadi "' . ucfirst($request->status) . '".');
    }
}
