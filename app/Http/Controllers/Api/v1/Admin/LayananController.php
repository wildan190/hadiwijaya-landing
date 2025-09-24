<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    // GET all layanan
    public function index()
    {
        return response()->json(Layanan::all());
    }

    // STORE new layanan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'subtitle' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string',
            'description' => 'required|string',
            'picture1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'picture2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'picture3' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'picture4' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload gambar jika ada
        foreach (['picture1', 'picture2', 'picture3', 'picture4'] as $pic) {
            if ($request->hasFile($pic)) {
                $validated[$pic] = $request->file($pic)->store('layanans', 'public');
            }
        }

        $layanan = Layanan::create($validated);

        return response()->json([
            'message' => 'Layanan created successfully',
            'data' => $layanan
        ], 201);
    }

    // SHOW single layanan
    public function show($id)
    {
        $layanan = Layanan::find($id);
        if (!$layanan) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json($layanan);
    }

    // UPDATE layanan
    public function update(Request $request, $id)
    {
        $layanan = Layanan::find($id);
        if (!$layanan) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'subtitle' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string',
            'description' => 'required|string',
            'picture1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'picture2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'picture3' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'picture4' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle replace gambar jika ada upload baru
        foreach (['picture1', 'picture2', 'picture3', 'picture4'] as $pic) {
            if ($request->hasFile($pic)) {
                // hapus gambar lama jika ada
                if ($layanan->$pic && Storage::disk('public')->exists($layanan->$pic)) {
                    Storage::disk('public')->delete($layanan->$pic);
                }
                // simpan gambar baru
                $validated[$pic] = $request->file($pic)->store('layanans', 'public');
            } else {
                // tetap gunakan gambar lama jika tidak diupload baru
                $validated[$pic] = $layanan->$pic;
            }
        }

        $layanan->update($validated);

        return response()->json([
            'message' => 'Layanan updated successfully',
            'data' => $layanan
        ]);
    }

    // DELETE layanan
    public function destroy($id)
    {
        $layanan = Layanan::find($id);
        if (!$layanan) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        // Hapus gambar dari storage jika ada
        foreach (['picture1', 'picture2', 'picture3', 'picture4'] as $pic) {
            if ($layanan->$pic && Storage::disk('public')->exists($layanan->$pic)) {
                Storage::disk('public')->delete($layanan->$pic);
            }
        }

        $layanan->delete();

        return response()->json(['message' => 'Layanan deleted successfully']);
    }
}
