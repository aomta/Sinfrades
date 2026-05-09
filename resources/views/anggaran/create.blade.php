@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0"><i class="bi bi-plus-circle"></i> Tambah Anggaran</h3>
    <a href="{{ route('anggaran.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white fw-semibold">
                <i class="bi bi-cash-stack me-2"></i> Form Tambah Data Anggaran
            </div>
            <div class="card-body p-4">
                <form action="{{ route('anggaran.store') }}" method="POST">
                    @csrf

                    {{-- Jenis --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Transaksi <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis" id="jenisPemasukan"
                                    value="pemasukan" {{ old('jenis', 'pemasukan') == 'pemasukan' ? 'checked' : '' }}
                                    onchange="toggleJenisPengeluaran(this.value)">
                                <label class="form-check-label text-success fw-semibold" for="jenisPemasukan">
                                    <i class="bi bi-arrow-down-circle"></i> Pemasukan
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis" id="jenisPengeluaran"
                                    value="pengeluaran" {{ old('jenis') == 'pengeluaran' ? 'checked' : '' }}
                                    onchange="toggleJenisPengeluaran(this.value)">
                                <label class="form-check-label text-danger fw-semibold" for="jenisPengeluaran">
                                    <i class="bi bi-arrow-up-circle"></i> Pengeluaran
                                </label>
                            </div>
                        </div>
                        @error('jenis')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    {{-- Sumber Dana --}}
                    <div class="mb-3">
                        <label for="sumber_dana" class="form-label fw-semibold">Sumber Dana <span class="text-danger">*</span></label>
                        <input type="text" name="sumber_dana" id="sumber_dana"
                            class="form-control @error('sumber_dana') is-invalid @enderror"
                            placeholder="Contoh: Dana Desa, APBDes, Swadaya Masyarakat..."
                            value="{{ old('sumber_dana') }}" maxlength="200">
                        @error('sumber_dana')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Nominal --}}
                    <div class="mb-3">
                        <label for="nominal" class="form-label fw-semibold">Nominal (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="nominal" id="nominal"
                                class="form-control @error('nominal') is-invalid @enderror"
                                placeholder="0" min="0" value="{{ old('nominal') }}">
                            @error('nominal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" id="tanggal"
                            class="form-control @error('tanggal') is-invalid @enderror"
                            value="{{ old('tanggal', date('Y-m-d')) }}">
                        @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Jenis Pengeluaran (kondisional) --}}
                    <div class="mb-3" id="jenisPengeluaranWrapper" style="{{ old('jenis') == 'pengeluaran' ? '' : 'display:none' }}">
                        <label for="jenis_pengeluaran" class="form-label fw-semibold">Jenis Pengeluaran</label>
                        <input type="text" name="jenis_pengeluaran" id="jenis_pengeluaran"
                            class="form-control @error('jenis_pengeluaran') is-invalid @enderror"
                            placeholder="Contoh: Pembangunan, Pemeliharaan, Operasional..."
                            value="{{ old('jenis_pengeluaran') }}" maxlength="100">
                        @error('jenis_pengeluaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="3"
                            class="form-control @error('keterangan') is-invalid @enderror"
                            placeholder="Tambahkan keterangan (opsional)...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('anggaran.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleJenisPengeluaran(val) {
    const wrapper = document.getElementById('jenisPengeluaranWrapper');
    wrapper.style.display = val === 'pengeluaran' ? '' : 'none';
    if (val !== 'pengeluaran') {
        document.getElementById('jenis_pengeluaran').value = '';
    }
}
// Init on load
document.addEventListener('DOMContentLoaded', function () {
    const checked = document.querySelector('input[name="jenis"]:checked');
    if (checked) toggleJenisPengeluaran(checked.value);
});
</script>
@endpush
