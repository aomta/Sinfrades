@extends('layouts.app')

@section('content')

{{-- ALERT --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0">
        <i class="bi bi-building"></i> Data Infrastruktur
    </h3>

    @auth
        @if(in_array(auth()->user()->role, ['admin','petugas']))
        <a href="{{ route('infrastruktur.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Data
        </a>
        @endif
    @endauth
</div>

{{-- FILTER --}}
<form method="GET" action="{{ route('infrastruktur.index') }}" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control form-control-sm"
            placeholder="Cari nama / lokasi / dusun..." value="{{ request('search') }}">
    </div>

    <div class="col-md-3">
        <select name="kategori" class="form-select form-select-sm">
            <option value="">Semua Kategori</option>
            @foreach(['jalan','jembatan','drainase','irigasi','lampu_jalan','gedung_desa','posyandu','sekolah','tempat_ibadah','sanitasi_umum','air_bersih'] as $kat)
            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                {{ ucfirst(str_replace('_', ' ', $kat)) }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <select name="kondisi" class="form-select form-select-sm">
            <option value="">Semua Kondisi</option>
            <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
            <option value="rusak_ringan" {{ request('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
            <option value="rusak_berat" {{ request('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-success btn-sm w-100">
            <i class="bi bi-search"></i> Cari
        </button>
    </div>

    <div class="col-md-1">
        <a href="{{ route('infrastruktur.index') }}" class="btn btn-secondary btn-sm w-100">
            Reset
        </a>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-success">
                <tr>
                    <th width="50">No</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Dusun</th>
                    <th>Kondisi</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($data as $d)
            <tr>
                <td>
                    {{ $data->firstItem() ? $data->firstItem() + $loop->index : $loop->iteration }}
                </td>
                <td>{{ $d->nama_infrastruktur }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $d->kategori)) }}</td>
                <td>{{ $d->lokasi }}</td>
                <td>{{ $d->dusun }}</td>

                <td>
                    @if($d->kondisi == 'baik')
                        <span class="badge bg-success">Baik</span>
                    @elseif($d->kondisi == 'rusak_ringan')
                        <span class="badge bg-warning text-dark">Rusak Ringan</span>
                    @else
                        <span class="badge bg-danger">Rusak Berat</span>
                    @endif
                </td>

                <td>
                    <a href="{{ route('infrastruktur.show', $d->id) }}" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i>
                    </a>

                    @auth
                    @if(in_array(auth()->user()->role, ['admin','petugas']))
                    <a href="{{ route('infrastruktur.edit', $d->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i>
                    </a>
                    @endif

                    @if(auth()->user()->role == 'admin')
                    <form action="{{ route('infrastruktur.destroy', $d->id) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endif
                    @endauth
                </td>
            </tr>

            @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                    Belum ada data infrastruktur
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Menampilkan {{ $data->firstItem() ?? 0 }}–{{ $data->lastItem() ?? 0 }}
                dari {{ $data->total() }} data
            </small>

            {{ $data->links() }}
        </div>
    </div>
</div>

@endsection