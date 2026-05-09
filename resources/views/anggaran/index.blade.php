@extends('layouts.app')

@section('content')
{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0"><i class="bi bi-cash-stack"></i> Manajemen Anggaran</h3>
    <a href="{{ route('anggaran.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Tambah Anggaran
    </a>
</div>

{{-- SUMMARY CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-arrow-down-circle-fill text-success fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Pemasukan</div>
                    <div class="fw-bold fs-5 text-success">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #dc3545 !important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <i class="bi bi-arrow-up-circle-fill text-danger fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Pengeluaran</div>
                    <div class="fw-bold fs-5 text-danger">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid {{ $sisaAnggaran >= 0 ? '#0d6efd' : '#fd7e14' }} !important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle {{ $sisaAnggaran >= 0 ? 'bg-primary' : 'bg-warning' }} bg-opacity-10 p-3">
                    <i class="bi bi-wallet2 {{ $sisaAnggaran >= 0 ? 'text-primary' : 'text-warning' }} fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small">Sisa Anggaran</div>
                    <div class="fw-bold fs-5 {{ $sisaAnggaran >= 0 ? 'text-primary' : 'text-warning' }}">
                        Rp {{ number_format(abs($sisaAnggaran), 0, ',', '.') }}
                        @if($sisaAnggaran < 0)<span class="text-danger small">(Defisit)</span>@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FILTER --}}
<form method="GET" action="{{ route('anggaran.index') }}" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control form-control-sm"
            placeholder="Cari sumber dana / keterangan..." value="{{ request('search') }}">
    </div>
    <div class="col-md-2">
        <select name="jenis" class="form-select form-select-sm">
            <option value="">Semua Jenis</option>
            <option value="pemasukan"  {{ request('jenis') == 'pemasukan'   ? 'selected' : '' }}>Pemasukan</option>
            <option value="pengeluaran" {{ request('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
        </select>
    </div>
    <div class="col-md-2">
        <select name="bulan" class="form-select form-select-sm">
            <option value="">Semua Bulan</option>
            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bulan)
            <option value="{{ $i + 1 }}" {{ request('bulan') == $i + 1 ? 'selected' : '' }}>{{ $bulan }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="tahun" class="form-select form-select-sm">
            <option value="">Semua Tahun</option>
            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
    </div>
    <div class="col-md-1">
        <button class="btn btn-success btn-sm w-100"><i class="bi bi-search"></i></button>
    </div>
    <div class="col-md-1">
        <a href="{{ route('anggaran.index') }}" class="btn btn-secondary btn-sm w-100">Reset</a>
    </div>
</form>

{{-- TABLE --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-success">
                <tr>
                    <th width="40">No</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Sumber Dana</th>
                    <th>Jenis Pengeluaran</th>
                    <th class="text-end">Nominal</th>
                    <th>Keterangan</th>
                    <th width="120" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($data as $d)
            <tr>
                <td>{{ $data->firstItem() + $loop->index }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                <td>
                    @if($d->jenis == 'pemasukan')
                        <span class="badge bg-success"><i class="bi bi-arrow-down"></i> Pemasukan</span>
                    @else
                        <span class="badge bg-danger"><i class="bi bi-arrow-up"></i> Pengeluaran</span>
                    @endif
                </td>
                <td>{{ $d->sumber_dana }}</td>
                <td class="text-muted">{{ $d->jenis_pengeluaran ?? '-' }}</td>
                <td class="text-end fw-semibold {{ $d->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                    {{ $d->jenis == 'pengeluaran' ? '-' : '+' }}Rp {{ number_format($d->nominal, 0, ',', '.') }}
                </td>
                <td class="text-muted small">{{ Str::limit($d->keterangan, 50) ?? '-' }}</td>
                <td class="text-center">
                    <a href="{{ route('anggaran.edit', $d->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('anggaran.destroy', $d->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus data anggaran ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-2"></i><br>
                    Belum ada data anggaran
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
