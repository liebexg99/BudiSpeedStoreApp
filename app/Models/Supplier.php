<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['nama', 'alamat', 'kode_pos'];

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }
}