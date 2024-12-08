<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBuku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'ISBN';
    protected $allowedFields = ['JudulBuku', 'Pengarang', 'Penerbit', 'TahunTerbit', 'JumlahHalaman', 'Quantity', 'gambar'];
}
