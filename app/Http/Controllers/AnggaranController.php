<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    public function index(Request $request)
{
    $query = Anggaran::query();

    if ($request->filled('jenis')) {
        $query->where('jenis', $request->jenis);
    }

    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal', $request->bulan);
    }

    if ($request->filled('tahun')) {
        $query->whereYear('tanggal', $request->tahun);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('sumber_dana', 'like', "%$search%")
              ->orWhere('keterangan', 'like', "%$search%");
        });
    }

    // 🔥 FIX
    $data = $query->orderBy('tanggal', 'desc')
                  ->paginate(10);

    $totalPemasukan = (clone $query)->where('jenis', 'pemasukan')->sum('nominal');
    $totalPengeluaran = (clone $query)->where('jenis', 'pengeluaran')->sum('nominal');

    $sisaAnggaran = $totalPemasukan - $totalPengeluaran;

    return view('anggaran.index', compact(
        'data',
        'totalPemasukan',
        'totalPengeluaran',
        'sisaAnggaran'
    ));
}

    public function create()
    {
        return view('anggaran.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'sumber_dana'      => 'required|max:200',
        'nominal'          => 'required|numeric|min:0',
        'tanggal'          => 'required|date',
        'jenis'            => 'required|in:pemasukan,pengeluaran',
        'jenis_pengeluaran'=> 'nullable|max:100',
        'keterangan'       => 'nullable|string',
    ]);

    // 🔥 kalau pemasukan, kosongkan jenis_pengeluaran
    if ($validated['jenis'] === 'pemasukan') {
        $validated['jenis_pengeluaran'] = null;
    }

    Anggaran::create($validated);

    return redirect()->route('anggaran.index')->with('success', 'Data anggaran berhasil ditambahkan!');
}

    // FIX: Method edit & update ditambahkan (tidak ada di dokumen asli)
    public function edit($id)
    {
        $data = Anggaran::findOrFail($id);
        return view('anggaran.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $item = Anggaran::findOrFail($id);

        $validated = $request->validate([
            'sumber_dana'      => 'required|max:200',
            'nominal'          => 'required|numeric|min:0',
            'tanggal'          => 'required|date',
            'jenis'            => 'required|in:pemasukan,pengeluaran',
            'jenis_pengeluaran'=> 'nullable|max:100',
            'keterangan'       => 'nullable|string',
        ]);

        $item->update($validated);

        return redirect()->route('anggaran.index')->with('success', 'Data anggaran berhasil diupdate!');
    }

    public function destroy($id)
    {
        Anggaran::findOrFail($id)->delete();

        return redirect()->route('anggaran.index')->with('success', 'Data anggaran berhasil dihapus!');
    }
}
