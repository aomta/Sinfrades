@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-4">
    <i class="bi bi-building"></i> Detail Infrastruktur
</h3>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="row g-3">

            <!-- Nama -->
            <div class="col-md-6">
                <label class="fw-semibold">Nama Infrastruktur</label>
                <div class="form-control">{{ $data->nama_infrastruktur }}</div>
            </div>

            <!-- Kategori -->
            <div class="col-md-6">
                <label class="fw-semibold">Kategori</label>
                <div class="form-control">
                    {{ ucfirst(str_replace('_',' ',$data->kategori)) }}
                </div>
            </div>

            <!-- Lokasi -->
            <div class="col-md-6">
                <label class="fw-semibold">Lokasi</label>
                <div class="form-control">{{ $data->lokasi }}</div>
            </div>

            <!-- Dusun -->
            <div class="col-md-6">
                <label class="fw-semibold">Dusun</label>
                <div class="form-control">{{ $data->dusun }}</div>
            </div>

            <!-- Tahun -->
            <div class="col-md-6">
                <label class="fw-semibold">Tahun Pembangunan</label>
                <div class="form-control">{{ $data->tahun_pembangunan }}</div>
            </div>

            <!-- Kondisi -->
            <div class="col-md-6">
                <label class="fw-semibold">Kondisi</label>
                <div class="form-control">
                    @if($data->kondisi == 'baik')
                        <span class="badge bg-success">Baik</span>
                    @elseif($data->kondisi == 'rusak_ringan')
                        <span class="badge bg-warning text-dark">Rusak Ringan</span>
                    @else
                        <span class="badge bg-danger">Rusak Berat</span>
                    @endif
                </div>
            </div>

            <!-- Foto -->
            @if($data->foto)
            <div class="col-12">
                <label class="fw-semibold">Foto</label><br>
                <img src="{{ asset('storage/'.$data->foto) }}"
                     class="img-fluid rounded shadow"
                     style="max-height:300px;">
            </div>
            @endif

            <!-- Deskripsi -->
            @if($data->deskripsi)
            <div class="col-12">
                <label class="fw-semibold">Deskripsi</label>
                <div class="form-control" style="min-height:100px;">
                    {{ $data->deskripsi }}
                </div>
            </div>
            @endif

        </div>

        <div class="mt-4">
            <a href="{{ url('/infrastruktur') }}" class="btn btn-secondary">
                Kembali
            </a>

            @if(in_array(auth()->user()->role, ['admin','petugas']))
            <a href="{{ url('/infrastruktur/edit/'.$data->id) }}" class="btn btn-warning">
                Edit
            </a>
            @endif
        </div>

    </div>
</div>

{{-- ================= LAPORAN TERKAIT ================= --}}
@if($data->laporans->count())
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-danger text-white">
        <i class="bi bi-exclamation-triangle"></i> Laporan Kerusakan
    </div>
    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Pelapor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->laporans as $laporan)
                <tr>
                    <td>{{ $laporan->judul_laporan }}</td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ $laporan->status }}
                        </span>
                    </td>
                    <td>{{ $laporan->user->name ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endif

{{-- ================= MAINTENANCE ================= --}}
@if($data->maintenances->count())
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-info text-white">
        <i class="bi bi-tools"></i> Riwayat Maintenance
    </div>
    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Petugas</th>
                    <th>Kondisi Setelah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->maintenances as $m)
                <tr>
                    <td>{{ $m->tanggal_maintenance }}</td>
                    <td>{{ $m->petugas->name ?? '-' }}</td>
                    <td>
                        <span class="badge bg-success">
                            {{ $m->kondisi_setelah }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endif

@endsection