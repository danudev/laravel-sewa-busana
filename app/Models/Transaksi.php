<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi penamaan tabel
    protected $table = 'transaksis';

    // Tentukan field yang boleh diisi mass assignment
    protected $fillable = [
        'user_id',
        'busana_id',
        'durasi',
        'status',
        'total_harga',
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_pengembalian',
        'denda'
    ];

    // Relasi dengan Busana (satu transaksi berhubungan dengan satu busana)
    public function busana()
    {
        return $this->belongsTo(Busana::class);
    }

    // Relasi dengan User (satu transaksi berhubungan dengan satu pengguna)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
