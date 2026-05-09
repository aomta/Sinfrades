@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-4">
    <i class="bi bi-pencil-square"></i> Edit Laporan Kerusakan
</h3>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <form action="{{ route('laporan.user.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <!-- Judul -->
                <div class="col-md-6">
                    <label class="fw-semibold">Judul Laporan *</label>
                    <input type="text" name="judul_laporan"
                        class="form-control @error('judul_laporan') is-invalid @enderror"
                        value="{{ old('judul_laporan', $data->judul_laporan) }}" required>
                    @error('judul_laporan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Infrastruktur -->
                <div class="col-md-6">
                    <label class="fw-semibold">Infrastruktur</label>
                    <select name="infrastruktur_id" class="form-select">
                        <option value="">-- Pilih (opsional) --</option>
                        @foreach($infrastruktur as $inf)
                        <option value="{{ $inf->id }}"
                            {{ $data->infrastruktur_id == $inf->id ? 'selected' : '' }}>
                            {{ $inf->nama_infrastruktur }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Lokasi -->
                <div class="col-md-6">
                    <label class="fw-semibold">Lokasi Kerusakan *</label>
                    <input type="text" name="lokasi_kerusakan"
                        class="form-control @error('lokasi_kerusakan') is-invalid @enderror"
                        value="{{ old('lokasi_kerusakan', $data->lokasi_kerusakan) }}" required>
                    @error('lokasi_kerusakan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Foto lama -->
                @if($data->foto)
                <div class="col-md-6">
                    <label class="fw-semibold">Foto Saat Ini</label><br>
                    <img src="{{ asset('storage/'.$data->foto) }}"
                        class="img-fluid rounded"
                        style="max-height:150px;">
                </div>
                @endif

                <!-- Upload foto baru -->
                <div class="col-md-6">
                    <label class="fw-semibold">Ganti Foto (opsional)</label>
                    <input type="file" name="foto"
                        class="form-control @error('foto') is-invalid @enderror"
                        accept="image/*">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="col-12">
                    <label class="fw-semibold">Deskripsi Kerusakan *</label>
                    <textarea name="deskripsi_kerusakan"
                        class="form-control @error('deskripsi_kerusakan') is-invalid @enderror"
                        rows="4" required>{{ old('deskripsi_kerusakan', $data->deskripsi_kerusakan) }}</textarea>
                    @error('deskripsi_kerusakan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status (readonly untuk user) -->
                <div class="col-md-6">
                    <label class="fw-semibold">Status</label>
                    <input type="text" class="form-control"
                        value="{{ ucfirst($data->status) }}" readonly>
                </div>

            </div>

            <div class="mt-4">
                <button class="btn btn-success">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('laporan.user.index') }}" class="btn btn-secondary">Batal</a>
            </div>

        </form>

    </div>
</div>
@endsection