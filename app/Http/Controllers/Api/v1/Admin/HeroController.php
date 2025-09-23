<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Hero;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HeroController extends Controller
{
    // Get all heroes
    public function index()
    {
        return response()->json(Hero::all(), 200);
    }

    // Create or Update hero (upsert)
    public function storeOrUpdate(Request $request, $id = null)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
        ]);

        $hero = Hero::updateOrCreate(
            ['id' => $id],
            $validated
        );

        return response()->json($hero, $id ? 200 : 201);
    }

    // Show single hero
    public function show($id)
    {
        $hero = Hero::find($id);

        if (!$hero) {
            return response()->json(['message' => 'Hero not found'], 404);
        }

        return response()->json($hero, 200);
    }

    // Delete hero
    public function destroy($id)
    {
        $hero = Hero::find($id);

        if (!$hero) {
            return response()->json(['message' => 'Hero not found'], 404);
        }

        $hero->delete();

        return response()->json(['message' => 'Hero deleted'], 200);
    }
}
