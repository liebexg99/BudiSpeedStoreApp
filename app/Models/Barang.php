<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = ['nama', 'gambar', 'kategori_id', 'stok', 'harga'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}