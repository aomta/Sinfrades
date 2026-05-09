@extends('layouts.app')
@section('content')
<h3 class='fw-bold mb-4'><i class='bi bi-speedometer2'></i> Dashboard</h3>

<!-- STAT CARDS -->
<div class='row g-3 mb-4'>
    <div class='col-md-2'><div class='card border-0 shadow-sm text-center p-3'>
        <i class='bi bi-building fs-2 text-success'></i>
        <h4>{{ $totalInfrastruktur }}</h4><small class='text-muted'>Total Infrastruktur</small>
    </div></div>
    <div class='col-md-2'><div class='card border-0 shadow-sm text-center p-3'>
        <i class='bi bi-check-circle fs-2 text-success'></i>
        <h4>{{ $fasilitasBaik }}</h4><small class='text-muted'>Kondisi Baik</small>
    </div></div>
    <div class='col-md-2'><div class='card border-0 shadow-sm text-center p-3'>
        <i class='bi bi-exclamation-circle fs-2 text-warning'></i>
        <h4>{{ $rusakRingan }}</h4><small class='text-muted'>Rusak Ringan</small>
    </div></div>
    <div class='col-md-2'><div class='card border-0 shadow-sm text-center p-3'>
        <i class='bi bi-x-circle fs-2 text-danger'></i>
        <h4>{{ $rusakBerat }}</h4><small class='text-muted'>Rusak Berat</small>
    </div></div>
    <div class='col-md-2'><div class='card border-0 shadow-sm text-center p-3'>
        <i class='bi bi-envelope fs-2 text-primary'></i>
        <h4>{{ $laporanMasuk }}</h4><small class='text-muted'>Laporan Masuk</small>
    </div></div>
    <div class='col-md-2'><div class='card border-0 shadow-sm text-center p-3'>
        <i class='bi bi-hammer fs-2 text-info'></i>
        <h4>{{ $proyekAktif }}</h4><small class='text-muted'>Proyek Aktif</small>
    </div></div>
</div>

<!-- GRAFIK KONDISI -->
<div class='row'>
    <div class='col-md-6'>
        <div class='card border-0 shadow-sm p-3'>
            <h6 class='fw-bold mb-3'>Grafik Kondisi Infrastruktur</h6>
            <canvas id='grafikKondisi'></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
<script>
const ctx = document.getElementById('grafikKondisi');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
        datasets: [{ data: [
            {{ $grafikKondisi['baik'] }},
            {{ $grafikKondisi['rusak_ringan'] }},
            {{ $grafikKondisi['rusak_berat'] }}
        ], backgroundColor: ['#2D6A2D','#FFC107','#DC3545'] }]
    }
});
</script>
@endpush
