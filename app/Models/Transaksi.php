<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = ['tanggal_transaksi', 'total_harga'];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id');
    }
}
