@extends('layouts.app')

@section('content')

<div class="mb-4">
    <a href="{{ route('pengajuan.index') }}" class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pengajuan
    </a>
    <h4 class="fw-bold mt-1 mb-0">
        <i class="bi bi-eye text-info me-2"></i>Detail Pengajuan Pembangunan
    </h4>
    <small class="text-muted">Informasi lengkap pengajuan pembangunan infrastruktur desa</small>
</div>

<div class="row g-3">

    {{-- MAIN DETAIL CARD --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header border-0 py-3"
                 style="background: linear-gradient(90deg, #1B5E20, #2D6A2D);">
                <h6 class="text-white mb-0 fw-semibold">
                    <i class="bi bi-file-text me-2"></i>Informasi Pengajuan
                </h6>
            </div>

            <div class="card-body p-4">
                <div class="row g-3">

                    <div class="col-12">
                        <label class="text-muted small fw-semibold text-uppercase mb-1">Nama Proyek</label>
                        <div class="fs-5 fw-bold text-dark">{{ $data->nama_proyek }}</div>
                    </div>

                    <div class="col-md-8">
                        <label class="text-muted small fw-semibold text-uppercase mb-1">
                            <i class="bi bi-geo-alt me-1"></i>Lokasi
                        </label>
                        <div class="form-control bg-light border-0">{{ $data->lokasi }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="text-muted small fw-semibold text-uppercase mb-1">Dusun</label>
                        <div class="form-control bg-light border-0">{{ $data->dusun }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-semibold text-uppercase mb-1">
                            <i class="bi bi-cash-coin me-1"></i>Estimasi Biaya
                        </label>
                        <div class="form-control bg-light border-0 fw-bold text-success fs-5">
                            Rp {{ number_format($data->estimasi_biaya, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="text-muted small fw-semibold text-uppercase mb-1">Prioritas</label>
                        <div class="form-control bg-light border-0">
                            @php
                                $prioritasMap = [
                                    'rendah' => ['bg-info text-dark', 'bi-arrow-down-circle', 'Rendah'],
                                    'sedang' => ['bg-warning text-dark', 'bi-dash-circle', 'Sedang'],
                                    'tinggi' => ['bg-danger', 'bi-arrow-up-circle', 'Tinggi'],
                                ];
                                $pStyle = $prioritasMap[$data->prioritas] ?? ['bg-secondary','bi-circle', ucfirst($data->prioritas)];
                            @endphp
                            <span class="badge {{ $pStyle[0] }} px-3 py-2 fs-6">
                                <i class="bi {{ $pStyle[1] }} me-1"></i>{{ $pStyle[2] }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="text-muted small fw-semibold text-uppercase mb-1">Status</label>
                        <div class="form-control bg-light border-0">
                            @php
                                $statusMap = [
                                    'diajukan'  => ['bg-secondary', 'bi-hourglass-split', 'Diajukan'],
                                    'disetujui' => ['bg-success',   'bi-check-circle',    'Disetujui'],
                                    'ditolak'   => ['bg-danger',    'bi-x-circle',        'Ditolak'],
                                    'selesai'   => ['bg-primary',   'bi-flag-fill',       'Selesai'],
                                ];
                                $sStyle = $statusMap[$data->status] ?? ['bg-secondary','bi-circle',ucfirst($data->status)];
                            @endphp
                            <span class="badge {{ $sStyle[0] }} px-3 py-2 fs-6">
                                <i class="bi {{ $sStyle[1] }} me-1"></i>{{ $sStyle[2] }}
                            </span>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="text-muted small fw-semibold text-uppercase mb-1">
                            <i class="bi bi-chat-left-text me-1"></i>Alasan / Usulan Pembangunan
                        </label>
                        <div class="form-control bg-light border-0" style="min-height: 120px; white-space: pre-wrap;">{{ $data->alasan_usulan }}</div>
                    </div>

                    @if($data->catatan_admin)
                    <div class="col-12">
                        <label class="text-muted small fw-semibold text-uppercase mb-1">
                            <i class="bi bi-person-badge me-1"></i>Catatan Admin / Petugas
                        </label>
                        <div class="border border-success rounded p-3 bg-light" style="min-height: 80px; white-space: pre-wrap;">
                            {{ $data->catatan_admin }}
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- SIDEBAR: Meta Info + Admin Actions --}}
    <div class="col-lg-4">

        {{-- Meta Info --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-light border-0 py-2">
                <span class="fw-semibold small text-muted text-uppercase">
                    <i class="bi bi-info-circle me-1"></i>Informasi Pengaju
                </span>
            </div>
            <div class="card-body py-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                         style="width:42px; height:42px; font-size:18px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $data->user->name ?? '-' }}</div>
                        <div class="small text-muted">{{ ucfirst($data->user->role ?? '-') }}</div>
                    </div>
                </div>

                <hr class="my-2">

                <div class="small">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Tanggal Pengajuan</span>
                        <span class="fw-semibold">{{ $data->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Terakhir Diperbarui</span>
                        <span class="fw-semibold">{{ $data->updated_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">ID Pengajuan</span>
                        <span class="badge bg-light text-dark border">#{{ $data->id }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Admin Actions --}}
        @if(in_array(auth()->user()->role, ['admin','petugas']))
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header border-0 py-2" style="background:#e8f5e9;">
                <span class="fw-semibold small text-uppercase" style="color:#1B5E20;">
                    <i class="bi bi-gear-fill me-1"></i>Update Status
                </span>
            </div>
            <div class="card-body py-3">
                <form action="{{ route('pengajuan.updateStatus', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Status Baru</label>
                        <select name="status" class="form-select form-select-sm" required>
                            <option value="diajukan"  {{ $data->status=='diajukan'  ? 'selected':'' }}>Diajukan</option>
                            <option value="disetujui" {{ $data->status=='disetujui' ? 'selected':'' }}>Disetujui</option>
                            <option value="ditolak"   {{ $data->status=='ditolak'   ? 'selected':'' }}>Ditolak</option>
                            <option value="selesai"   {{ $data->status=='selesai'   ? 'selected':'' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Catatan Admin</label>
                        <textarea name="catatan_admin" class="form-control form-control-sm" rows="3"
                            placeholder="Catatan untuk pengaju (opsional)...">{{ $data->catatan_admin }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-sm w-100">
                        <i class="bi bi-check-circle me-1"></i>Simpan Status
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- Action Buttons --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3 d-flex flex-column gap-2">

                @if(
                    in_array(auth()->user()->role, ['admin','petugas']) ||
                    (auth()->id() == $data->user_id && $data->status == 'diajukan')
                )
                <a href="{{ route('pengajuan.edit', $data->id) }}"
                   class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil me-1"></i> Edit Pengajuan
                </a>
                @endif

                @if(
                    auth()->user()->role == 'admin' ||
                    (auth()->id() == $data->user_id && $data->status == 'diajukan')
                )
                <form action="{{ route('pengajuan.destroy', $data->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus pengajuan ini? Data tidak dapat dikembalikan.')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-trash me-1"></i> Hapus Pengajuan
                    </button>
                </form>
                @endif

                <a href="{{ route('pengajuan.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-list-ul me-1"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
