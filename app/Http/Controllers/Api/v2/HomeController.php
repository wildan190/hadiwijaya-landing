<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Hero;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    // Get all heroes (cached)
    public function heroes()
    {
        $heroes = Cache::remember('heroes_all', 3600, function () {
            return Hero::all();
        });

        return response()->json($heroes, 200);
    }

    public function faqs()
    {
        $faqs = Cache::remember('faqs_all', 3600, function () {
            return Faq::all();
        });

        return response()->json($faqs, 200);
    }

    public function projects()
    {
        $projects = Cache::remember('projects_all', 3600, function () {
            return \App\Models\Project::all();
        });

        return response()->json($projects, 200);
    }

    public function pricingTable()
    {
        $pricing = Cache::remember('pricing_table_all', 3600, function () {
            return \App\Models\PricingTable::all();
        });

        return response()->json($pricing, 200);
    }

    public function layanan()
    {
        $layanan = Cache::remember('layanan_all', 3600, function () {
            return \App\Models\Layanan::all();
        });

        return response()->json($layanan, 200);
    }

    // Get single hero (cached per ID)
    public function hero($id)
    {
        $hero = Cache::remember("hero_{$id}", 3600, function () use ($id) {
            return Hero::find($id);
        });

        if (!$hero) {
            return response()->json(['message' => 'Hero not found'], 404);
        }

        return response()->json($hero, 200);
    }
}
