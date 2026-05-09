@extends('layouts.app')
@section('content')
<h3 class='fw-bold mb-4'><i class='bi bi-exclamation-triangle'></i> Laporkan Kerusakan</h3>
<div class='card border-0 shadow-sm'>
    <div class='card-body'>
        <form action="{{ route('laporan.user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class='mb-3'>
                <label class='fw-semibold'>Judul Laporan *</label>
                <input type='text' name='judul_laporan' class='form-control' required>
            </div>
            <div class='mb-3'>
                <label class='fw-semibold'>Kategori Infrastruktur</label>
                <select id="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach(['jalan','jembatan','drainase','irigasi','lampu_jalan','gedung_desa','posyandu','sekolah','tempat_ibadah','sanitasi_umum','air_bersih'] as $kat)
                        <option value="{{ $kat }}">
                            {{ ucfirst(str_replace('_', ' ', $kat)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class='mb-3'>
                <label class='fw-semibold'>Infrastruktur Terkait</label>
                <select name='infrastruktur_id' id="infrastruktur" class='form-select'>
                    <option value=''>-- Pilih Infrastruktur --</option>

                    @foreach($infrastruktur as $inf)
                    <option value='{{ $inf->id }}' data-kategori="{{ $inf->kategori }}">
                        {{ $inf->nama_infrastruktur }} ({{ $inf->kategori }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class='mb-3'>
                <label>Lokasi Kerusakan *</label>
                <input type='text' name='lokasi_kerusakan' class='form-control' required>
            </div>
            <div class='mb-3'>
                <label>Deskripsi Kerusakan *</label>
                <textarea name='deskripsi_kerusakan' class='form-control' rows='4' required></textarea>
            </div>
            <div class='mb-3'>
                <label>Foto Kerusakan</label>
                <input type='file' name='foto' class='form-control' accept='image/*'>
            </div>
            <button class='btn btn-danger'><i class='bi bi-send'></i> Kirim Laporan</button>
            <a href='/laporan-kerusakan' class='btn btn-secondary'>Batal</a>
        </form>
    </div>
</div>
@endsection

<script>
document.getElementById('kategori').addEventListener('change', function() {
    let selected = this.value;
    let options = document.querySelectorAll('#infrastruktur option');

    options.forEach(option => {
        if (option.value === '') return;

        if (selected === '' || option.dataset.kategori === selected) {
            option.hidden = false;
        } else {
            option.hidden = true;
        }
    });
});
</script>
