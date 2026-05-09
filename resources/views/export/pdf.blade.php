<!DOCTYPE html><html><head>
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h2 { color: #1B5E20; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #2D6A2D; color: white; padding: 6px; }
    td { border: 1px solid #ccc; padding: 5px; }
    tr:nth-child(even) { background: #f1f8e9; }
</style></head><body>
<h2>Laporan Infrastruktur Desa</h2>
<p>Tanggal: {{ now()->format('d F Y') }}</p>
<table>
    <tr><th>No</th><th>Nama</th><th>Kategori</th><th>Lokasi</th><th>Kondisi</th></tr>
    @foreach($data as $i => $d)
    <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $d->nama_infrastruktur }}</td>
        <td>{{ $d->kategori }}</td>
        <td>{{ $d->lokasi }}</td>
        <td>{{ $d->kondisi }}</td>
    </tr>
    @endforeach
</table>
</body></html>
