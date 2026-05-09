<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Infrastruktur;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Maintenance::with('infrastruktur', 'petugas');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('infrastruktur', function ($q) use ($search) {
                $q->where('nama_infrastruktur', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('kondisi_setelah')) {
            $query->where('kondisi_setelah', $request->kondisi_setelah);
        }

        $data = $query->orderBy('id', 'desc')->paginate(10);

        return view('maintenance.index', compact('data'));
    }

    public function create()
    {
        $infrastruktur = Infrastruktur::orderBy('nama_infrastruktur')->get();
        $petugas = User::whereIn('role', ['petugas', 'admin'])->orderBy('name')->get();

        return view('maintenance.create', compact('infrastruktur', 'petugas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'infrastruktur_id'    => 'required|exists:infrastruktur,id',
            'petugas_id'          => 'required|exists:users,id',
            'tanggal_maintenance' => 'required|date',
            'hasil_pemeriksaan'   => 'required|string',
            'catatan'             => 'nullable|string',
            'kondisi_setelah'     => 'required|in:baik,rusak_ringan,rusak_berat',
        ]);

        Maintenance::create($validated);

        // Update kondisi infrastruktur berdasarkan hasil maintenance
        Infrastruktur::findOrFail($request->infrastruktur_id)
            ->update(['kondisi' => $request->kondisi_setelah]);

        return redirect()->route('maintenance.index')->with('success', 'Data maintenance berhasil disimpan!');
    }

    public function edit($id)
    {
        $data          = Maintenance::findOrFail($id);
        $infrastruktur = Infrastruktur::orderBy('nama_infrastruktur')->get();
        $petugas       = User::whereIn('role', ['petugas', 'admin'])->orderBy('name')->get();

        return view('maintenance.edit', compact('data', 'infrastruktur', 'petugas'));
    }

    public function update(Request $request, $id)
    {
        $item = Maintenance::findOrFail($id);

        $validated = $request->validate([
            'infrastruktur_id'    => 'required|exists:infrastruktur,id',
            'petugas_id'          => 'required|exists:users,id',
            'tanggal_maintenance' => 'required|date',
            'hasil_pemeriksaan'   => 'required|string',
            'catatan'             => 'nullable|string',
            'kondisi_setelah'     => 'required|in:baik,rusak_ringan,rusak_berat',
        ]);

        $item->update($validated);

        // Sync kondisi infrastruktur
        Infrastruktur::findOrFail($request->infrastruktur_id)
            ->update(['kondisi' => $request->kondisi_setelah]);

        return redirect()->route('maintenance.index')->with('success', 'Data maintenance berhasil diupdate!');
    }

    public function destroy($id)
    {
        Maintenance::findOrFail($id)->delete();

        return redirect()->route('maintenance.index')->with('success', 'Data maintenance berhasil dihapus!');
    }
}
