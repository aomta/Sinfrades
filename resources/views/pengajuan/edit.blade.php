@extends('layouts.app')

@section('content')

<div class="mb-4">
    <a href="{{ route('pengajuan.index') }}" class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pengajuan
    </a>
    <h4 class="fw-bold mt-1 mb-0">
        <i class="bi bi-pencil-square text-warning me-2"></i>Edit Pengajuan Pembangunan
    </h4>
    <small class="text-muted">Perbarui data pengajuan pembangunan infrastruktur</small>
</div>

{{-- Status badge info --}}
<div class="d-flex align-items-center gap-2 mb-3">
    <span class="text-muted small">Status saat ini:</span>
    @php
        $statusMap = [
            'diajukan'  => ['bg-secondary', 'bi-hourglass-split', 'Diajukan'],
            'disetujui' => ['bg-success',   'bi-check-circle',    'Disetujui'],
            'ditolak'   => ['bg-danger',    'bi-x-circle',        'Ditolak'],
            'selesai'   => ['bg-primary',   'bi-flag-fill',       'Selesai'],
        ];
        $sStyle = $statusMap[$data->status] ?? ['bg-secondary','bi-circle', ucfirst($data->status)];
    @endphp
    <span class="badge {{ $sStyle[0] }} px-3 py-2 fs-6">
        <i class="bi {{ $sStyle[1] }} me-1"></i>{{ $sStyle[2] }}
    </span>

    @if(auth()->user()->role === 'warga' && $data->status !== 'diajukan')
    <span class="badge bg-warning text-dark ms-2">
        <i class="bi bi-lock-fill me-1"></i> Tidak dapat diedit
    </span>
    @endif
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header border-0 py-3"
         style="background: linear-gradient(90deg, #E65100, #F57C00);">
        <h6 class="text-white mb-0 fw-semibold">
            <i class="bi bi-pencil me-2"></i>Formulir Edit Pengajuan
        </h6>
    </div>

    <div class="card-body p-4">
        <form action="{{ route('pengajuan.update', $data->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- Nama Proyek --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold">
                        Nama Proyek <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama_proyek"
                        class="form-control @error('nama_proyek') is-invalid @enderror"
                        value="{{ old('nama_proyek', $data->nama_proyek) }}"
                        maxlength="200" required
                        @if(auth()->user()->role === 'warga' && $data->status !== 'diajukan') disabled @endif>
                    @error('nama_proyek')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Lokasi --}}
                <div class="col-md-8">
                    <label class="form-label fw-semibold">
                        Lokasi <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="lokasi"
                        class="form-control @error('lokasi') is-invalid @enderror"
                        value="{{ old('lokasi', $data->lokasi) }}"
                        maxlength="255" required
                        @if(auth()->user()->role === 'warga' && $data->status !== 'diajukan') disabled @endif>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dusun --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Dusun <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="dusun"
                        class="form-control @error('dusun') is-invalid @enderror"
                        value="{{ old('dusun', $data->dusun) }}"
                        maxlength="100" required
                        @if(auth()->user()->role === 'warga' && $data->status !== 'diajukan') disabled @endif>
                    @error('dusun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Estimasi Biaya --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Estimasi Biaya (Rp) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light fw-semibold text-success">Rp</span>
                        <input type="number" name="estimasi_biaya" id="estimasi_biaya"
                            class="form-control @error('estimasi_biaya') is-invalid @enderror"
                            value="{{ old('estimasi_biaya', $data->estimasi_biaya) }}"
                            min="0" step="1000" required
                            @if(auth()->user()->role === 'warga' && $data->status !== 'diajukan') disabled @endif>
                        @error('estimasi_biaya')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted" id="estimasiFmt">
                        = Rp {{ number_format($data->estimasi_biaya, 0, ',', '.') }}
                    </small>
                </div>

                {{-- Prioritas --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Tingkat Prioritas <span class="text-danger">*</span>
                    </label>
                    <select name="prioritas"
                        class="form-select @error('prioritas') is-invalid @enderror" required
                        @if(auth()->user()->role === 'warga' && $data->status !== 'diajukan') disabled @endif>
                        <option value="">-- Pilih Prioritas --</option>
                        <option value="rendah"
                            {{ old('prioritas', $data->prioritas) == 'rendah' ? 'selected':'' }}>
                            🟢 Rendah — Tidak mendesak
                        </option>
                        <option value="sedang"
                            {{ old('prioritas', $data->prioritas) == 'sedang' ? 'selected':'' }}>
                            🟡 Sedang — Perlu segera direncanakan
                        </option>
                        <option value="tinggi"
                            {{ old('prioritas', $data->prioritas) == 'tinggi' ? 'selected':'' }}>
                            🔴 Tinggi — Mendesak / darurat
                        </option>
                    </select>
                    @error('prioritas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status (admin & petugas only) --}}
                @if(in_array(auth()->user()->role, ['admin','petugas']))
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status Pengajuan</label>
                    <select name="status" class="form-select">
                        <option value="diajukan"  {{ old('status',$data->status) == 'diajukan'  ? 'selected':'' }}>Diajukan</option>
                        <option value="disetujui" {{ old('status',$data->status) == 'disetujui' ? 'selected':'' }}>Disetujui</option>
                        <option value="ditolak"   {{ old('status',$data->status) == 'ditolak'   ? 'selected':'' }}>Ditolak</option>
                        <option value="selesai"   {{ old('status',$data->status) == 'selesai'   ? 'selected':'' }}>Selesai</option>
                    </select>
                </div>

                {{-- Catatan Admin --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Catatan Admin</label>
                    <textarea name="catatan_admin" class="form-control" rows="2"
                        placeholder="Catatan untuk pengaju (opsional)...">{{ old('catatan_admin', $data->catatan_admin) }}</textarea>
                </div>
                @endif

                {{-- Alasan / Usulan --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">
                        Alasan / Usulan Pembangunan <span class="text-danger">*</span>
                    </label>
                    <textarea name="alasan_usulan" rows="5"
                        class="form-control @error('alasan_usulan') is-invalid @enderror"
                        required
                        @if(auth()->user()->role === 'warga' && $data->status !== 'diajukan') disabled @endif
                        >{{ old('alasan_usulan', $data->alasan_usulan) }}</textarea>
                    @error('alasan_usulan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Info untuk warga yang sudah diproses --}}
                @if(auth()->user()->role === 'warga' && $data->status !== 'diajukan')
                <div class="col-12">
                    <div class="alert alert-warning border-0 py-2 small mb-0">
                        <i class="bi bi-lock-fill me-1"></i>
                        Pengajuan ini sudah <strong>{{ $sStyle[2] }}</strong> dan tidak dapat diedit lagi.
                        Hubungi admin/petugas jika ada perubahan yang diperlukan.
                    </div>
                </div>
                @endif

            </div>{{-- end row --}}

            <hr class="mt-4 mb-3">

            <div class="d-flex gap-2">
                @if(
                    in_array(auth()->user()->role, ['admin','petugas']) ||
                    $data->status === 'diajukan'
                )
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                @endif
                <a href="{{ route('pengajuan.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('pengajuan.show', $data->id) }}" class="btn btn-outline-info px-4">
                    <i class="bi bi-eye me-1"></i> Lihat Detail
                </a>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
    const inputBiaya = document.getElementById('estimasi_biaya');
    const fmtLabel  = document.getElementById('estimasiFmt');

    function formatRupiah(val) {
        if (!val || isNaN(val)) { fmtLabel.textContent = ''; return; }
        fmtLabel.textContent = '= Rp ' + parseInt(val).toLocaleString('id-ID');
    }

    if (inputBiaya) {
        inputBiaya.addEventListener('input', () => formatRupiah(inputBiaya.value));
    }
</script>
@endpush

@endsection
