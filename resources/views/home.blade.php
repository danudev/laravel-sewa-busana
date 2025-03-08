<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('custom.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="{{ asset('gambar/logo.png') }}" alt="Logo" width="150"
                    height="20"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav d-flex justify-content-center flex-grow-1">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#list-busana">Sewa Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transaksi.index') }}">Riwayat</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @if (Auth::check())
                    <li class="nav-item">
                        <span class="nav-link">Hello, {{ Auth::user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                Logout
                            </button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item bg-danger">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    <li class="nav-item border border-danger">
                        <a class="nav-link text-danger" href="{{ route('login') }}">Login</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="p-5 mb-4 rounded-3 bg-jumbotron">
        <div class="container-fluid py-5">
            <p class="col-md-8 fs-4"> Gaun Yang Cantik</p>
            <h1 class="display-2 fw-bold">Gaun Pengantin Impian</h1>
            <h1 class="display-2 fw-bold">untuk bersinar di Hari </h1>
            <h1 class="display-2 fw-bold">Pernikahan anda</h1>
        </div>
    </div>

    <div class="container mt-5" id=list-busana>
        <div class="row">
            <div class="caption-sewa text-center mb-5">
                <h3>berikut ini adalah Penyewaan Gaun Pengantin</h3>
                <h4>cara termudah untuk menyewa gaun pengantin anda di antara 6 favorit teratas ini </h4>
                <!-- Menampilkan pesan sukses atau error -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<!-- Konten halaman lainnya -->
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            @foreach ($busanas as $busana)
            <div class="col-md-6 mb-4">
                <div class="card border-light shadow-sm rounded">
                    <div class="row no-gutters">
                        <!-- Gambar di kiri -->
                        <div class="col-md-4">
                            <img src="{{ asset('storage/'.$busana->gambar) }}" alt="Gaun Akad Nikah"
                                class="img-fluid" style="height: 400px; width: 100%; object-fit: cover;">
                        </div>
                        <!-- Teks di kanan -->
                        <div class="col-md-8">
                            <div class="card-body border">
                                <h3>{{ $busana->nama }}</h3>
                                <p>{{ $busana->deskripsi }}</p>
                                <p><strong>Rp {{ number_format($busana->harga_sewa, 0, ',', '.') }} / Hari</strong>
                                </p>
                                @if ($busana->stok > 0)
                                <p class="text-success">Tersedia</p>
                                @else
                                <p class="text-danger">Tidak Tersedia</p>
                                @endif

                                @if (Auth::check())
                                <a href="#" class="btn btn-danger col-6 col-xs-12 @if($busana->stok <= 0) disabled @endif"
                                    data-bs-toggle="modal" data-bs-target="#pesanModal" data-id="{{ $busana->id }}" data-name="{{ $busana->nama }}" data-price="{{ $busana->harga_sewa }}">Pesan
                                    Sekarang</a>
                                @else
                                <a href="{{ route('login') }}" class="btn btn-warning col-6 col-xs-12">Login
                                    untuk Memesan</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-body-secondary">&copy; 2024 Company, Inc</p>
    </footer>

    <!-- Modal untuk memilih hari sewa -->
    <div class="modal fade" id="pesanModal" tabindex="-1" aria-labelledby="pesanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pesanModalLabel">Pilih Durasi Sewa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="busana_name" class="form-label">Nama Busana</label>
                            <input type="text" class="form-control" id="busana_name" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="busana_price" class="form-label">Harga Sewa (per hari)</label>
                            <input type="text" class="form-control" id="busana_price" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="durasi" class="form-label">Durasi Sewa (Hari)</label>
                            <input type="number" class="form-control" id="durasi" name="durasi" required min="1">
                        </div>
                        <input type="hidden" id="busana_id" name="busana_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script untuk modal -->
    <script>
        var pesanButtons = document.querySelectorAll('.btn-danger[data-bs-toggle="modal"]');
        pesanButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                var busanaId = event.target.getAttribute('data-id');

                // Mengambil data nama dan harga busana
                var busanaName = event.target.getAttribute('data-name');
                var busanaPrice = event.target.getAttribute('data-price');

                // Menampilkan data nama dan harga di modal
                document.getElementById('busana_id').value = busanaId;
                document.getElementById('busana_name').value = busanaName;
                document.getElementById('busana_price').value = 'Rp ' + busanaPrice;
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
