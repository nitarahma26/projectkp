<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks'; // Pastikan nama tabel sesuai
    protected $fillable = [
        'nama_produk',
        'harga_beli',
        'harga_jual',
        'total_jual',
        'stok',
        'gambar',
        'kategori_id'
    ]; // Tambahkan kolom yang dapat diisi

    public function kategori()
    {
        return $this->belongsTo(Kategori::class); // Relasi ke kategori
    }
}
