<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Transaksi Sewa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Daftar Transaksi Sewa</h1>

        @if($transaksis->isEmpty())
            <div class="alert alert-warning">
                Belum ada transaksi yang dilakukan.
            </div>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Busana</th>
                        <th>Durasi (Hari)</th>
                        <th>Total Harga</th>
                        <th>Denda</th>
                        <th>Status</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Total Harga + Denda</th> <!-- Kolom baru -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $transaksi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaksi->busana->nama }}</td>
                            <td>{{ $transaksi->durasi }}</td>

                            <!-- Menampilkan Total Harga -->
                            <td>Rp {{ number_format($transaksi->total_harga, 2, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaksi->denda, 2, ',', '.') }}</td>

                            <td>
                                <span class="
                                    @if($transaksi->status == 'dipinjam') text-danger
                                    @elseif($transaksi->status == 'selesai') text-success
                                    @endif">
                                    {{ ucfirst($transaksi->status) }}
                                </span>
                            </td>

                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_mulai)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_selesai)->format('d-m-Y') }}</td>
                            <td> @if($transaksi->tanggal_pengembalian)
                                {{ \Carbon\Carbon::parse($transaksi->tanggal_pengembalian)->format('d-m-Y') }}
                            @else
                                Belum Kembali
                            @endif</td>

                            <!-- Menambahkan kolom Total Harga + Denda -->
                            <td>
                                Rp {{ number_format($transaksi->total_harga + $transaksi->denda , 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Home</a>
    </div>
</body>
</html>
