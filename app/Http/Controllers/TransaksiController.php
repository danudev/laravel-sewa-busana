<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Busana;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
    public function index()
    {
        // Mengambil transaksi yang dimiliki oleh pengguna yang sedang login
        $transaksis = Transaksi::where('user_id', auth()->id())
                              ->orderBy('created_at', 'desc')  // Menurut waktu terbaru
                              ->get();

        // Mengirim data transaksi ke view
        return view('transaksi.index', compact('transaksis'));
    }
public function store(Request $request)
{
    // Validasi data yang diterima
    $request->validate([
        'busana_id' => 'required|exists:busanas,id',  // Pastikan busana_id valid
        'durasi' => 'required|integer|min:1', // Durasi sewa minimal 1 hari
    ]);

    // Pastikan durasi adalah integer
    $durasi = (int) $request->input('durasi');

    // Mulai transaksi
    DB::beginTransaction();

    try {
        // Menyimpan transaksi baru
        $transaksi = new Transaksi();
        $transaksi->busana_id = $request->input('busana_id');
        $transaksi->user_id = auth()->id();  // ID pengguna yang login
        $transaksi->durasi = $durasi;
        $transaksi->status = 'dipinjam';

        // Mengambil harga sewa busana
        $busana = Busana::find($request->input('busana_id'));
        $total_harga = $busana->harga_sewa * $durasi; // Total harga = harga per hari * durasi

        $transaksi->total_harga = $total_harga;

        // Menambahkan tanggal mulai penyewaan (tanggal saat ini)
        $transaksi->tanggal_mulai = Carbon::now();

        // Menghitung tanggal selesai berdasarkan durasi
        $transaksi->tanggal_selesai = Carbon::now()->addDays($durasi); // Menambahkan durasi hari

        // Menyimpan transaksi
        $transaksi->save();

        // Mengurangi stok busana setelah transaksi dibuat
        if ($busana && $busana->stok > 0) {
            $busana->stok -= 1;  // Kurangi stok sebanyak 1
            $busana->save();
        } else {
            // Jika stok tidak cukup, batalkan transaksi
            throw new \Exception('Stok tidak cukup!');
        }

        // Jika semua proses berhasil, commit transaksi
        DB::commit();

        // Pesan sukses
        session()->flash('success', 'Transaksi berhasil dibuat!');

    } catch (\Exception $e) {
        // Jika terjadi error, rollback transaksi
        DB::rollBack();

        // Tampilkan pesan error
        session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }

    // Redirect ke halaman sebelumnya atau halaman lain
    return redirect()->back();
}



}
