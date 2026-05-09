@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0"><i class="bi bi-tools"></i> Data Maintenance</h3>
    <a href="{{ route('maintenance.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Tambah Maintenance
    </a>
</div>

{{-- FILTER FORM --}}
<form method="GET" action="{{ route('maintenance.index') }}" class="row g-2 mb-3">
    <div class="col-md-5">
        <input type="text" name="search" class="form-control form-control-sm"
            placeholder="Cari nama infrastruktur / lokasi..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="kondisi_setelah" class="form-select form-select-sm">
            <option value="">Semua Kondisi Setelah</option>
            <option value="baik" {{ request('kondisi_setelah') == 'baik' ? 'selected' : '' }}>Baik</option>
            <option value="rusak_ringan" {{ request('kondisi_setelah') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
            <option value="rusak_berat" {{ request('kondisi_setelah') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-success btn-sm w-100"><i class="bi bi-search"></i> Cari</button>
    </div>
    <div class="col-md-2">
        <a href="{{ route('maintenance.index') }}" class="btn btn-secondary btn-sm w-100">Reset</a>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-success">
                <tr>
                    <th width="40">No</th>
                    <th>Infrastruktur</th>
                    <th>Lokasi</th>
                    <th>Petugas</th>
                    <th>Tanggal</th>
                    <th>Kondisi Setelah</th>
                    <th width="130">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($data as $d)
            <tr>
                <td>{{ $data->firstItem() + $loop->index }}</td>
                <td>{{ $d->infrastruktur->nama_infrastruktur ?? '-' }}</td>
                <td>{{ $d->infrastruktur->lokasi ?? '-' }}</td>
                <td>{{ $d->petugas->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal_maintenance)->format('d/m/Y') }}</td>
                <td>
                    @if($d->kondisi_setelah == 'baik')
                        <span class="badge bg-success">Baik</span>
                    @elseif($d->kondisi_setelah == 'rusak_ringan')
                        <span class="badge bg-warning text-dark">Rusak Ringan</span>
                    @else
                        <span class="badge bg-danger">Rusak Berat</span>
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-info btn-sm"
                        data-bs-toggle="modal" data-bs-target="#modalDetail{{ $d->id }}">
                        <i class="bi bi-eye"></i>
                    </button>

                    <a href="{{ route('maintenance.edit', $d->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i>
                    </a>

                    @if(auth()->user()->role == 'admin')
                    <form action="{{ route('maintenance.destroy', $d->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Hapus data maintenance ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-4"></i><br>Belum ada data maintenance
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

{{-- ✅ MODAL DIPINDAH KE SINI --}}
@foreach($data as $d)
<div class="modal fade" id="modalDetail{{ $d->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Detail Maintenance</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-borderless">
                    <tr><th>Infrastruktur</th><td>{{ $d->infrastruktur->nama_infrastruktur ?? '-' }}</td></tr>
                    <tr><th>Lokasi</th><td>{{ $d->infrastruktur->lokasi ?? '-' }}</td></tr>
                    <tr><th>Petugas</th><td>{{ $d->petugas->name ?? '-' }}</td></tr>
                    <tr><th>Tanggal</th><td>{{ \Carbon\Carbon::parse($d->tanggal_maintenance)->format('d F Y') }}</td></tr>
                    <tr>
                        <th>Kondisi</th>
                        <td>
                            @if($d->kondisi_setelah == 'baik')
                                <span class="badge bg-success">Baik</span>
                            @elseif($d->kondisi_setelah == 'rusak_ringan')
                                <span class="badge bg-warning text-dark">Rusak Ringan</span>
                            @else
                                <span class="badge bg-danger">Rusak Berat</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Hasil</th><td>{{ $d->hasil_pemeriksaan }}</td></tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{!! $d->catatan ?? '<span class="text-muted">-</span>' !!}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection