@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-4">
    <i class="bi bi-file-text"></i> Detail Laporan
</h3>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h4>{{ $laporan->judul_laporan }}</h4>

        <p>
            <span class="badge bg-secondary">
                {{ $laporan->status }}
            </span>
        </p>

        <hr>

        <div class="mb-3">
            <strong>Lokasi:</strong><br>
            {{ $laporan->lokasi_kerusakan }}
        </div>

        <div class="mb-3">
            <strong>Deskripsi:</strong><br>
            {{ $laporan->deskripsi_kerusakan }}
        </div>

        <div class="mb-3">
            <strong>Infrastruktur:</strong><br>
            {{ $laporan->infrastruktur->nama_infrastruktur ?? '-' }}
        </div>

        @if($laporan->foto)
        <div class="mb-3">
            <strong>Foto:</strong><br>
            <img src="{{ asset('storage/' . $laporan->foto) }}"
                 class="img-fluid rounded"
                 style="max-width: 400px;">
        </div>
        @endif

        <a href="/laporan-kerusakan" class="btn btn-secondary">
            Kembali
        </a>

    </div>
</div>
@endsection