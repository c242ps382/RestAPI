<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Medic;
use App\Models\Nonmedics;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function getAllKunjungan()
    {
        // Ambil data kunjungan medis beserta informasi pasien
        $medics = Medic::with('patient')->get()->map(function ($medic) {
            return [
                'username' => $medic->patient ? $medic->patient->nama : null,
                'alamat' => $medic->patient ? $medic->patient->alamat : null,
                'nomor_hp' => $medic->patient ? $medic->patient->nomor_hp : null,
                'tanggal_kunjungan' => $medic->tanggal_kunjungan,
                'nomor_kunjungan' => $medic->nomor_kunjungan,
                'hasil_diagnosa' => $medic->hasil_diagnosa,
                'tindakan' => $medic->tindakan,
                'type' => 'Medis',
            ];
        });

        // Ambil data non-medis beserta informasi pasien
        $nonmedics = Nonmedics::with('patient')->get()->map(function ($nonmedic) {
            return [
                'username' => $nonmedic->patient ? $nonmedic->patient->nama : null,
                'alamat' => $nonmedic->patient ? $nonmedic->patient->alamat : null,
                'nomor_hp' => $nonmedic->patient ? $nonmedic->patient->nomor_hp : null,
                'tanggal_kunjungan' => $nonmedic->tanggal_kunjungan,
                'nomor_kunjungan' => $nonmedic->nomor_kunjungan,
                'keluhan' => $nonmedic->keluhan,
                'tindakan' => $nonmedic->tindakan,
                'biaya_pembayaran' => $nonmedic->biaya_pembayaran,
                'type' => 'Non-Medis',
            ];
        });

        // Gabungkan data medis dan non-medis
        $allKunjungan = $medics->merge($nonmedics);

        return response()->json([
            'message' => 'Data kunjungan berhasil dimuat',
            'data' => $allKunjungan,
        ]);
    }
}
