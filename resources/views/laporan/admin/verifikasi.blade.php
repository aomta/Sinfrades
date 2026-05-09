@extends('layouts.app')
@section('content')
<h3 class='fw-bold mb-4'>Verifikasi Laporan</h3>
<div class='card border-0 shadow-sm mb-4'>
    <div class='card-body'>
        <p><strong>Judul:</strong> {{ $data->judul_laporan }}</p>
        <p><strong>Pelapor:</strong> {{ $data->user->name }}</p>
        <p><strong>Lokasi:</strong> {{ $data->lokasi_kerusakan }}</p>
        <p><strong>Deskripsi:</strong> {{ $data->deskripsi_kerusakan }}</p>
        @if($data->foto)
            <img src='{{ asset("storage/".$data->foto) }}'
                style='max-width:300px;' class='img-thumbnail mb-3'>
        @endif
    </div>
</div>
<div class='card border-0 shadow-sm'>
    <div class='card-header bg-success text-white'>Update Status</div>
    <div class='card-body'>
        <form action="{{ route('laporan.admin.updateStatus', $data->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class='mb-3'>
                <label>Status</label>
                <select name='status' class='form-select'>
                    <option value='menunggu'>Menunggu</option>
                    <option value='diproses'>Diproses</option>
                    <option value='selesai'>Selesai</option>
                </select>
            </div>
            <div class='mb-3'>
                <label>Catatan Admin</label>
                <textarea name='catatan_admin' class='form-control' rows='3'>{{ $data->catatan_admin }}</textarea>
            </div>
            <button class='btn btn-success'>Update Status</button>
        </form>
    </div>
</div>
@endsection
