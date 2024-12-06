<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nik',
        'tanggal_lahir',
        'umur',
        'alamat',
        'jenis_kelamin',
        'nomor_hp',
    ];

    // Menentukan tabel database yang digunakan


    public function medis()
    {
        return $this->hasOne(Medic::class, 'nama_pasien', 'nama');
    }

    public function nonmedis()
    {
        return $this->hasOne(Nonmedics::class, 'nama_pasien', 'nama');
    }
}
