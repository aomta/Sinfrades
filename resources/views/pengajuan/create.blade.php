@extends('layouts.app')

@section('content')

<div class="mb-4">
    <a href="{{ route('pengajuan.index') }}" class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pengajuan
    </a>
    <h4 class="fw-bold mt-1 mb-0">
        <i class="bi bi-file-earmark-plus text-success me-2"></i>Ajukan Pembangunan Baru
    </h4>
    <small class="text-muted">Isi formulir berikut untuk mengajukan rencana pembangunan infrastruktur desa</small>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header border-0 py-3"
         style="background: linear-gradient(90deg, #1B5E20, #2D6A2D);">
        <h6 class="text-white mb-0 fw-semibold">
            <i class="bi bi-pencil-square me-2"></i>Formulir Pengajuan Pembangunan
        </h6>
    </div>

    <div class="card-body p-4">
        <form action="{{ route('pengajuan.store') }}" method="POST" novalidate>
            @csrf

            <div class="row g-3">

                {{-- Nama Proyek --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold">
                        Nama Proyek <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama_proyek"
                        class="form-control @error('nama_proyek') is-invalid @enderror"
                        value="{{ old('nama_proyek') }}"
                        placeholder="Contoh: Pembangunan Jembatan Dusun Mekar"
                        maxlength="200" required>
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
                        value="{{ old('lokasi') }}"
                        placeholder="Contoh: Jl. Raya Desa No. 12, RT 02 RW 05"
                        maxlength="255" required>
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
                        value="{{ old('dusun') }}"
                        placeholder="Contoh: Dusun Mekar"
                        maxlength="100" required>
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
                            value="{{ old('estimasi_biaya') }}"
                            placeholder="0"
                            min="0" step="1000" required>
                        @error('estimasi_biaya')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted" id="estimasiFmt"></small>
                </div>

                {{-- Prioritas --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Tingkat Prioritas <span class="text-danger">*</span>
                    </label>
                    <select name="prioritas"
                        class="form-select @error('prioritas') is-invalid @enderror" required>
                        <option value="">-- Pilih Prioritas --</option>
                        <option value="rendah"  {{ old('prioritas')=='rendah'  ? 'selected':'' }}>
                            🟢 Rendah — Tidak mendesak
                        </option>
                        <option value="sedang"  {{ old('prioritas')=='sedang'  ? 'selected':'' }}>
                            🟡 Sedang — Perlu segera direncanakan
                        </option>
                        <option value="tinggi"  {{ old('prioritas')=='tinggi'  ? 'selected':'' }}>
                            🔴 Tinggi — Mendesak / darurat
                        </option>
                    </select>
                    @error('prioritas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alasan / Usulan --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">
                        Alasan / Usulan Pembangunan <span class="text-danger">*</span>
                    </label>
                    <textarea name="alasan_usulan" rows="5"
                        class="form-control @error('alasan_usulan') is-invalid @enderror"
                        placeholder="Jelaskan latar belakang, urgensi, dan manfaat dari pembangunan yang diajukan..."
                        required>{{ old('alasan_usulan') }}</textarea>
                    @error('alasan_usulan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- INFO BOX --}}
                <div class="col-12">
                    <div class="alert alert-info border-0 py-2 small mb-0" role="alert">
                        <i class="bi bi-info-circle-fill me-1"></i>
                        Pengajuan yang telah dikirim akan diverifikasi oleh <strong>Admin/Petugas</strong>
                        dan statusnya dapat dipantau di halaman ini. Anda dapat mengedit pengajuan
                        selama statusnya masih <strong>Diajukan</strong>.
                    </div>
                </div>

            </div>{{-- end row --}}

            <hr class="mt-4 mb-3">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-send me-1"></i> Kirim Pengajuan
                </button>
                <a href="{{ route('pengajuan.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-x-circle me-1"></i> Batal
                </a>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
    // Format angka estimasi biaya
    const inputBiaya = document.getElementById('estimasi_biaya');
    const fmtLabel  = document.getElementById('estimasiFmt');

    function formatRupiah(val) {
        if (!val || isNaN(val)) { fmtLabel.textContent = ''; return; }
        fmtLabel.textContent = '= Rp ' + parseInt(val).toLocaleString('id-ID');
    }

    inputBiaya.addEventListener('input', () => formatRupiah(inputBiaya.value));
    formatRupiah(inputBiaya.value); // init on page load (old value)
</script>
@endpush

@endsection
