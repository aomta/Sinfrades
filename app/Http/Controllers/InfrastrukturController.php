<?php

namespace App\Http\Controllers;

use App\Models\Infrastruktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfrastrukturController extends Controller
{
    public function index(Request $request)
    {
        $query = Infrastruktur::query();

        // FIX: Search di-group dengan where() agar filter kategori & kondisi tidak ter-bypass oleh orWhere
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_infrastruktur', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%')
                  ->orWhere('dusun', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $data = $query->orderBy('id', 'desc')->paginate(10);

        return view('infrastruktur.index', compact('data'));
    }

    public function create()
    {
        return view('infrastruktur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_infrastruktur' => 'required|max:200',
            'kategori'           => 'required|in:jalan,jembatan,drainase,irigasi,lampu_jalan,gedung_desa,posyandu,sekolah,tempat_ibadah,sanitasi_umum,air_bersih',
            'lokasi'             => 'required|max:255',
            'dusun'              => 'required|max:100',
            'tahun_pembangunan'  => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'kondisi'            => 'required|in:baik,rusak_ringan,rusak_berat',
            'deskripsi'          => 'nullable|string',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'lat'                => 'nullable|numeric|between:-90,90',
            'lng'                => 'nullable|numeric|between:-180,180',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('infrastruktur', 'public');
        }

        Infrastruktur::create($validated);

        return redirect()->route('infrastruktur.index')->with('success', 'Data infrastruktur berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Infrastruktur::findOrFail($id);
        return view('infrastruktur.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $item = Infrastruktur::findOrFail($id);

        $validated = $request->validate([
            'nama_infrastruktur' => 'required|max:200',
            'kategori'           => 'required|in:jalan,jembatan,drainase,irigasi,lampu_jalan,gedung_desa,posyandu,sekolah,tempat_ibadah,sanitasi_umum,air_bersih',
            'lokasi'             => 'required|max:255',
            'dusun'              => 'required|max:100',
            'tahun_pembangunan'  => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'kondisi'            => 'required|in:baik,rusak_ringan,rusak_berat',
            'deskripsi'          => 'nullable|string',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'lat'                => 'nullable|numeric|between:-90,90',
            'lng'                => 'nullable|numeric|between:-180,180',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $validated['foto'] = $request->file('foto')->store('infrastruktur', 'public');
        }

        $item->update($validated);

        return redirect()->route('infrastruktur.index')->with('success', 'Data infrastruktur berhasil diupdate!');
    }

    public function destroy($id)
    {
        $item = Infrastruktur::findOrFail($id);

        // Hapus foto dari storage jika ada
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();

        return redirect()->route('infrastruktur.index')->with('success', 'Data infrastruktur berhasil dihapus!');
    }

    public function show($id)
    {
        $data = Infrastruktur::with(['laporans.user', 'maintenances.petugas'])->findOrFail($id);
        return view('infrastruktur.show', compact('data'));
    }
}
