<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Hero;

class HomeController extends Controller
{
    // Get all heroes (public)
    public function heroes()
    {
        return response()->json(Hero::all(), 200);
    }

    public function faqs()
    {
        return response()->json(Faq::all(), 200);
    }

    public function projects()
    {
        return response()->json(\App\Models\Project::all(), 200);
    }

    // Get single hero (public)
    public function hero($id)
    {
        $hero = Hero::find($id);

        if (!$hero) {
            return response()->json(['message' => 'Hero not found'], 404);
        }

        return response()->json($hero, 200);
    }
}
