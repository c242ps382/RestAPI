<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;
class BeritaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        $berita = Berita::all();

        // Kembalikan data dalam bentuk JSON
        return response()->json([
            'message' => 'Data fetched successfully',
            'data' => $berita,
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'update' => 'required|string',
            'title' => 'required|string|max:255',
            'imageurl' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk file image
            'infotitle' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Proses upload file ke Google Cloud Storage
        if ($request->hasFile('imageurl')) {
            $file = $request->file('imageurl');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension(); // Buat nama unik untuk file
            $filePath = $file->storeAs('gambar_berita', $fileName, 'gcs'); // Simpan ke bucket GCS
            $validatedData['imageurl'] = Storage::disk('gcs')->url($filePath); // URL file yang bisa diakses publik
        }

        // Simpan data ke database
        $berita = Berita::create($validatedData);

        return response()->json([
            'message' => 'News successfully created',
            'data' => $berita,
        ], 201);
    }

}
