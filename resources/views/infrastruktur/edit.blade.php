@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-4"><i class="bi bi-pencil-square"></i> Edit Infrastruktur</h3>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        {{-- FIX: Gunakan named route + @method('PUT') --}}
        <form action="{{ route('infrastruktur.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="fw-semibold">Nama Infrastruktur *</label>
                    <input type="text" name="nama_infrastruktur"
                        class="form-control @error('nama_infrastruktur') is-invalid @enderror"
                        value="{{ old('nama_infrastruktur', $data->nama_infrastruktur) }}" required>
                    @error('nama_infrastruktur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Kategori *</label>
                    <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(['jalan','jembatan','drainase','irigasi','lampu_jalan','gedung_desa','posyandu','sekolah','tempat_ibadah','sanitasi_umum','air_bersih'] as $kat)
                        <option value="{{ $kat }}" {{ old('kategori', $data->kategori) == $kat ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $kat)) }}
                        </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Lokasi *</label>
                    <input type="text" name="lokasi"
                        class="form-control @error('lokasi') is-invalid @enderror"
                        value="{{ old('lokasi', $data->lokasi) }}" required>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Dusun *</label>
                    <input type="text" name="dusun"
                        class="form-control @error('dusun') is-invalid @enderror"
                        value="{{ old('dusun', $data->dusun) }}" required>
                    @error('dusun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="fw-semibold">Tahun Pembangunan *</label>
                    <input type="number" name="tahun_pembangunan"
                        class="form-control @error('tahun_pembangunan') is-invalid @enderror"
                        value="{{ old('tahun_pembangunan', $data->tahun_pembangunan) }}"
                        min="1900" max="{{ date('Y') }}" required>
                    @error('tahun_pembangunan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="fw-semibold">Kondisi *</label>
                    <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                        <option value="baik" {{ old('kondisi', $data->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak_ringan" {{ old('kondisi', $data->kondisi) == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak_berat" {{ old('kondisi', $data->kondisi) == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                    @error('kondisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="fw-semibold">Foto</label>
                    @if($data->foto)
                        <div class="mb-1">
                            <img src="{{ asset('storage/' . $data->foto) }}"
                                style="max-height:80px;" class="img-thumbnail">
                        </div>
                    @endif
                    <input type="file" name="foto"
                        class="form-control @error('foto') is-invalid @enderror"
                        accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="fw-semibold">Latitude</label>
                    <input type="number" name="lat" class="form-control"
                        step="any" value="{{ old('lat', $data->lat) }}"
                        placeholder="-6.12345">
                </div>

                <div class="col-md-4">
                    <label class="fw-semibold">Longitude</label>
                    <input type="number" name="lng" class="form-control"
                        step="any" value="{{ old('lng', $data->lng) }}"
                        placeholder="106.12345">
                </div>

                <div class="col-12">
                    <label class="fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $data->deskripsi) }}</textarea>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Update Data
                </button>
                <a href="{{ route('infrastruktur.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
