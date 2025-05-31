<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $fillable = ['penjualan_id', 'barang_id', 'jumlah', 'total_harga'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}