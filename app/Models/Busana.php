<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Busana extends Model
{
    protected $table = 'busanas';
    protected $fillable = ['nama', 'harga_sewa', 'deskripsi', 'gambar', 'stok'];

    public function getHargaAttribute($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    public function setHargaAttribute($value)
    {
        $this->attributes['harga_sewa'] = preg_replace('/[Rp. ]/', '', $value);
    }

    public function transaksis()
    {
        return $this->belongsToMany(Transaksi::class)->withPivot('jumlah', 'harga');
    }

}
