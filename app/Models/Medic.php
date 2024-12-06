<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medic extends Model
{
    use HasFactory;
    protected $table = 'medics';
    protected $fillable = [
        'nomor_kunjungan',
        'tanggal_kunjungan',
        'nama_pasien',
        'anamnesa',
        'data_objektif',
        'input_genjala',
        'predicted_diagnosa',
        'hasil_diagnosa',
        'tindakan',
        'biaya_pembayaran'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'nama_pasien', 'nama');
    }


}
