@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0"><i class="bi bi-tools"></i> Tambah Maintenance</h3>
    <a href="{{ route('maintenance.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('maintenance.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                {{-- Infrastruktur --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Infrastruktur <span class="text-danger">*</span></label>
                    <select name="infrastruktur_id" class="form-select @error('infrastruktur_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Infrastruktur --</option>
                        @foreach($infrastruktur as $infra)
                            <option value="{{ $infra->id }}" {{ old('infrastruktur_id') == $infra->id ? 'selected' : '' }}>
                                {{ $infra->nama_infrastruktur }} — {{ $infra->lokasi }}
                            </option>
                        @endforeach
                    </select>
                    @error('infrastruktur_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Petugas --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Petugas <span class="text-danger">*</span></label>
                    <select name="petugas_id" class="form-select @error('petugas_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Petugas --</option>
                        @foreach($petugas as $p)
                            <option value="{{ $p->id }}" {{ old('petugas_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} ({{ ucfirst($p->role) }})
                            </option>
                        @endforeach
                    </select>
                    @error('petugas_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Maintenance --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Maintenance <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_maintenance"
                        class="form-control @error('tanggal_maintenance') is-invalid @enderror"
                        value="{{ old('tanggal_maintenance', date('Y-m-d')) }}" required>
                    @error('tanggal_maintenance')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kondisi Setelah --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kondisi Setelah Maintenance <span class="text-danger">*</span></label>
                    <select name="kondisi_setelah" class="form-select @error('kondisi_setelah') is-invalid @enderror" required>
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="baik" {{ old('kondisi_setelah') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak_ringan" {{ old('kondisi_setelah') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak_berat" {{ old('kondisi_setelah') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                    @error('kondisi_setelah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Hasil Pemeriksaan --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Hasil Pemeriksaan <span class="text-danger">*</span></label>
                    <textarea name="hasil_pemeriksaan" rows="4"
                        class="form-control @error('hasil_pemeriksaan') is-invalid @enderror"
                        placeholder="Deskripsikan hasil pemeriksaan dan pekerjaan yang dilakukan..." required>{{ old('hasil_pemeriksaan') }}</textarea>
                    @error('hasil_pemeriksaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Catatan Tambahan</label>
                    <textarea name="catatan" rows="3"
                        class="form-control @error('catatan') is-invalid @enderror"
                        placeholder="Catatan tambahan (opsional)...">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
