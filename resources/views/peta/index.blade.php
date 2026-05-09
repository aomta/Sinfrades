@extends('layouts.app')
@section('content')
<h3 class='fw-bold mb-4'><i class='bi bi-map'></i> Peta Infrastruktur Desa</h3>

<!-- LEGENDA -->
<div class='mb-3 d-flex gap-3'>
    <span><span style='width:14px;height:14px;background:#2D6A2D;border-radius:50%;display:inline-block;'></span> Baik</span>
    <span><span style='width:14px;height:14px;background:#FFC107;border-radius:50%;display:inline-block;'></span> Rusak Ringan</span>
    <span><span style='width:14px;height:14px;background:#DC3545;border-radius:50%;display:inline-block;'></span> Rusak Berat</span>
</div>

<div id='map' style='height:500px;border-radius:12px;' class='shadow-sm'></div>
@endsection

@push('scripts')
<script>
const map = L.map('map').setView([-6.2088, 106.8456], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'OpenStreetMap'
}).addTo(map);

const colors = { baik: '#2D6A2D', rusak_ringan: '#FFC107', rusak_berat: '#DC3545' };

fetch('/peta/data')
    .then(r => r.json())
    .then(data => {
        data.forEach(item => {
            L.circleMarker([item.lat, item.lng], {
                color: colors[item.kondisi] || '#999',
                fillColor: colors[item.kondisi] || '#999',
                fillOpacity: 0.9, radius: 10
            }).addTo(map)
             .bindPopup(`<b>${item.nama_infrastruktur}</b><br>
                Kategori: ${item.kategori}<br>
                Lokasi: ${item.lokasi}<br>
                Kondisi: <b>${item.kondisi}</b>`);
        });
    });
</script>
@endpush
