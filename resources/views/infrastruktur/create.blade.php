@extends('layouts.app')
@section('content')
<h3 class='fw-bold mb-4'><i class='bi bi-plus-circle'></i> Tambah Infrastruktur</h3>
<div class='card border-0 shadow-sm'>
    <div class='card-body'>
        <form action="{{ route('infrastruktur.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class='row g-3'>
                <div class='col-md-6'>
                    <label class='fw-semibold'>Nama Infrastruktur *</label>
                    <input type='text' name='nama_infrastruktur' class='form-control
                        @error("nama_infrastruktur") is-invalid @enderror'
                        value='{{ old("nama_infrastruktur") }}' required>
                    @error('nama_infrastruktur')<div class='invalid-feedback'>{{ $message }}</div>@enderror
                </div>
                <div class='col-md-6'>
                    <label class='fw-semibold'>Kategori *</label>
                    <select name='kategori' class='form-select' required>
                        <option value=''>-- Pilih Kategori --</option>
                        @foreach(['jalan','jembatan','drainase','irigasi','lampu_jalan',
                            'gedung_desa','posyandu','sekolah','tempat_ibadah',
                            'sanitasi_umum','air_bersih'] as $kat)
                        <option value='{{ $kat }}' {{ old('kategori')==$kat?'selected':'' }}>
                            {{ ucfirst(str_replace('_',' ',$kat)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class='col-md-6'>
                    <label>Lokasi *</label>
                    <input type='text' name='lokasi' class='form-control' required>
                </div>
                <div class='col-md-6'>
                    <label>Dusun *</label>
                    <input type='text' name='dusun' class='form-control' required>
                </div>
                <div class='col-md-4'>
                    <label>Tahun Pembangunan *</label>
                    <input type='number' name='tahun_pembangunan' class='form-control'
                        min='1900' max='{{ date("Y") }}' required>
                </div>
                <div class='col-md-4'>
                    <label>Kondisi *</label>
                    <select name='kondisi' class='form-select' required>
                        <option value='baik'>Baik</option>
                        <option value='rusak_ringan'>Rusak Ringan</option>
                        <option value='rusak_berat'>Rusak Berat</option>
                    </select>
                </div>
                <div class='col-md-4'>
                    <label>Foto</label>
                    <input type='file' name='foto' class='form-control' accept='image/*'>
                </div>
                <div class='col-md-4'>
                    <label>Latitude</label>
                    <input type='number' name='lat' class='form-control' step='any'>
                </div>
                <div class='col-md-4'>
                    <label>Longitude</label>
                    <input type='number' name='lng' class='form-control' step='any'>
                </div>
                <div class='col-12'>
                    <label>Deskripsi</label>
                    <textarea name='deskripsi' class='form-control' rows='3'></textarea>
                </div>
            </div>
            <div class='mt-3'>
                <button class='btn btn-success'><i class='bi bi-save'></i> Simpan</button>
                <a href='/infrastruktur' class='btn btn-secondary'>Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
