{{-- <div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $transaksi->busana->nama }}</h5>
        <p>Harga Sewa: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
        <p>Tanggal Mulai: {{ $transaksi->tanggal_mulai }}</p>
        <p>Tanggal Selesai: {{ $transaksi->tanggal_selesai }}</p>

        @if($transaksi->tanggal_pengembalian)
            <p>Tanggal Pengembalian: {{ $transaksi->tanggal_pengembalian }}</p>
            @if($transaksi->denda > 0)
                <p class="text-danger">Denda Keterlambatan: Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</p>
            @else
                <p class="text-success">Tidak ada denda keterlambatan.</p>
            @endif
        @endif

        <p>Status: {{ ucfirst($transaksi->status) }}</p>
    </div>
</div> --}}
