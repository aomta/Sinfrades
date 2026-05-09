@extends('layouts.app')

@section('content')

{{-- PAGE HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">
            <i class="bi bi-file-earmark-plus text-success me-2"></i>Pengajuan Pembangunan
        </h4>
        <small class="text-muted">Kelola pengajuan pembangunan infrastruktur desa</small>
    </div>
    <a href="{{ route('pengajuan.create') }}" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Ajukan Pembangunan
    </a>
</div>

{{-- FILTER & SEARCH --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('pengajuan.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1">Cari Proyek / Lokasi</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0"
                        placeholder="Nama proyek atau lokasi..."
                        value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="diajukan"  {{ request('status')=='diajukan'  ? 'selected':'' }}>Diajukan</option>
                    <option value="disetujui" {{ request('status')=='disetujui' ? 'selected':'' }}>Disetujui</option>
                    <option value="ditolak"   {{ request('status')=='ditolak'   ? 'selected':'' }}>Ditolak</option>
                    <option value="selesai"   {{ request('status')=='selesai'   ? 'selected':'' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted mb-1">Prioritas</label>
                <select name="prioritas" class="form-select form-select-sm">
                    <option value="">Semua Prioritas</option>
                    <option value="rendah" {{ request('prioritas')=='rendah' ? 'selected':'' }}>Rendah</option>
                    <option value="sedang" {{ request('prioritas')=='sedang' ? 'selected':'' }}>Sedang</option>
                    <option value="tinggi" {{ request('prioritas')=='tinggi' ? 'selected':'' }}>Tinggi</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-success btn-sm flex-fill">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('pengajuan.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- SUMMARY BADGES --}}
<div class="row g-2 mb-3">
    <div class="col-auto">
        <span class="badge bg-secondary fs-6 px-3 py-2">
            <i class="bi bi-list-ul me-1"></i> Total: {{ $data->total() }}
        </span>
    </div>
    @if(request('search') || request('status') || request('prioritas'))
    <div class="col-auto">
        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
            <i class="bi bi-funnel-fill me-1"></i> Hasil difilter
        </span>
    </div>
    @endif
</div>

{{-- TABLE --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: linear-gradient(90deg, #1B5E20, #2D6A2D); color: white;">
                    <tr>
                        <th class="ps-3" style="width:45px;">No</th>
                        <th>Nama Proyek</th>
                        <th>Lokasi / Dusun</th>
                        <th>Estimasi Biaya</th>
                        <th style="width:100px;">Prioritas</th>
                        <th style="width:110px;">Status</th>
                        @if(in_array(auth()->user()->role, ['admin','petugas']))
                        <th>Pengaju</th>
                        @endif
                        <th style="width:160px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $d)
                    <tr>
                        <td class="ps-3 text-muted">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $d->nama_proyek }}</div>
                        </td>
                        <td>
                            <div class="small"><i class="bi bi-geo-alt text-muted me-1"></i>{{ $d->lokasi }}</div>
                            <div class="small text-muted">Dusun {{ $d->dusun }}</div>
                        </td>
                        <td>
                            <span class="fw-semibold text-success">
                                Rp {{ number_format($d->estimasi_biaya, 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            @php
                                $prioritasMap = [
                                    'rendah' => ['bg-info text-dark', 'bi-arrow-down-circle'],
                                    'sedang' => ['bg-warning text-dark', 'bi-dash-circle'],
                                    'tinggi' => ['bg-danger', 'bi-arrow-up-circle'],
                                ];
                                $pStyle = $prioritasMap[$d->prioritas] ?? ['bg-secondary','bi-circle'];
                            @endphp
                            <span class="badge {{ $pStyle[0] }} px-2 py-1">
                                <i class="bi {{ $pStyle[1] }} me-1"></i>{{ ucfirst($d->prioritas) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusMap = [
                                    'diajukan'  => ['bg-secondary', 'bi-hourglass-split', 'Diajukan'],
                                    'disetujui' => ['bg-success',   'bi-check-circle',    'Disetujui'],
                                    'ditolak'   => ['bg-danger',    'bi-x-circle',        'Ditolak'],
                                    'selesai'   => ['bg-primary',   'bi-flag-fill',       'Selesai'],
                                ];
                                $sStyle = $statusMap[$d->status] ?? ['bg-secondary','bi-circle', ucfirst($d->status)];
                            @endphp
                            <span class="badge {{ $sStyle[0] }} px-2 py-1">
                                <i class="bi {{ $sStyle[1] }} me-1"></i>{{ $sStyle[2] }}
                            </span>
                        </td>
                        @if(in_array(auth()->user()->role, ['admin','petugas']))
                        <td>
                            <div class="small fw-semibold">{{ $d->user->name ?? '-' }}</div>
                            <div class="small text-muted">{{ $d->created_at->format('d M Y') }}</div>
                        </td>
                        @endif
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                {{-- Detail --}}
                                <a href="{{ route('pengajuan.show', $d->id) }}"
                                   class="btn btn-info btn-sm px-2" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>

                                {{-- Edit: warga hanya bisa edit miliknya dan saat diajukan --}}
                                @if(
                                    in_array(auth()->user()->role, ['admin','petugas']) ||
                                    (auth()->id() == $d->user_id && $d->status == 'diajukan')
                                )
                                <a href="{{ route('pengajuan.edit', $d->id) }}"
                                   class="btn btn-warning btn-sm px-2" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif

                                {{-- Update Status: admin & petugas --}}
                                @if(in_array(auth()->user()->role, ['admin','petugas']))
                                <button type="button"
                                    class="btn btn-outline-success btn-sm px-2"
                                    title="Update Status"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalStatus"
                                    data-id="{{ $d->id }}"
                                    data-status="{{ $d->status }}"
                                    data-nama="{{ $d->nama_proyek }}">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                                @endif

                                {{-- Hapus --}}
                                @if(
                                    auth()->user()->role == 'admin' ||
                                    (auth()->id() == $d->user_id && $d->status == 'diajukan')
                                )
                                <form action="{{ route('pengajuan.destroy', $d->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm px-2" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox display-4 d-block mb-2 opacity-25"></i>
                            <div>Belum ada data pengajuan pembangunan</div>
                            <a href="{{ route('pengajuan.create') }}" class="btn btn-success btn-sm mt-2">
                                <i class="bi bi-plus-circle me-1"></i> Buat Pengajuan
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($data->hasPages())
        <div class="px-3 py-2 border-top d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Menampilkan {{ $data->firstItem() }}–{{ $data->lastItem() }} dari {{ $data->total() }} data
            </small>
            {{ $data->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- MODAL UPDATE STATUS --}}
@if(in_array(auth()->user()->role, ['admin','petugas']))
<div class="modal fade" id="modalStatus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background: linear-gradient(90deg, #1B5E20, #2D6A2D);">
                <h6 class="modal-title text-white fw-bold">
                    <i class="bi bi-arrow-repeat me-2"></i>Update Status Pengajuan
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formUpdateStatus" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p class="text-muted small mb-3">Proyek: <strong id="modalNamaProyek"></strong></p>

                    <div class="mb-3">
                        <label class="fw-semibold form-label">Status Baru <span class="text-danger">*</span></label>
                        <select name="status" id="modalSelectStatus" class="form-select" required>
                            <option value="diajukan">Diajukan</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="fw-semibold form-label">Catatan Admin</label>
                        <textarea name="catatan_admin" class="form-control" rows="3"
                            placeholder="Tulis catatan untuk pengaju (opsional)..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-check-circle me-1"></i> Simpan Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const modalStatus = document.getElementById('modalStatus');
    modalStatus.addEventListener('show.bs.modal', function (e) {
        const btn = e.relatedTarget;
        const id = btn.getAttribute('data-id');
        const status = btn.getAttribute('data-status');
        const nama = btn.getAttribute('data-nama');

        document.getElementById('modalNamaProyek').textContent = nama;
        document.getElementById('modalSelectStatus').value = status;
        document.getElementById('formUpdateStatus').action = '/pengajuan/' + id + '/status';
    });
</script>
@endpush
@endif

@endsection
