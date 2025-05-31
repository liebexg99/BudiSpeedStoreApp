<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = ['pembeli_id', 'kasir_id', 'tanggal_pesan', 'total'];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}