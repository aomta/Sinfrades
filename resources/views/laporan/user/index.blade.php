@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-4">
    <i class="bi bi-list-ul"></i> Daftar Laporan Kerusakan
</h3>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <a href="{{ route('laporan.user.create') }}" class="btn btn-danger mb-3">
            <i class="bi bi-plus-circle"></i> Buat Laporan
        </a>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->judul_laporan }}</td>
                        <td>{{ $item->lokasi_kerusakan }}</td>

                        <!-- STATUS -->
                        <td>
                            @if($item->status == 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($item->status == 'diproses')
                                <span class="badge bg-info">Diproses</span>
                            @elseif($item->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">{{ $item->status }}</span>
                            @endif
                        </td>

                        <td>{{ $item->created_at->format('d-m-Y') }}</td>

                        <!-- AKSI -->
                        <td>
                            <a href="{{ route('laporan.user.show', $item->id) }}" class="btn btn-sm btn-primary">
                                Detail
                            </a>

                            {{-- EDIT (hanya pemilik & status menunggu) --}}
                            @if($item->user_id == auth()->id() && $item->status === 'menunggu')
                                <a href="{{ route('laporan.user.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                            @endif

                            {{-- HAPUS (hanya pemilik) --}}
                            @if($item->user_id == auth()->id())
                                <form action="{{ route('laporan.user.destroy', $item->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                              <a href="{{ route('laporan.admin.verifikasi', $item->id) }}"
                              class="btn btn-success btn-sm">
                              <i class="bi bi-check-circle"></i>
                              </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Belum ada laporan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-3">
            {{ $data->links() }}
        </div>

    </div>
</div>
@endsection
