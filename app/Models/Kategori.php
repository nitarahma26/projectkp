<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris'; // sesuaikan dengan nama tabel
    protected $fillable = ['nama_kategori']; // field yang bisa diisi
}
