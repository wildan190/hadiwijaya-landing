<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingTable;
use Illuminate\Http\Request;

class PricingTableController extends Controller
{
    // Get all pricing tables
    public function index()
    {
        return response()->json(PricingTable::all());
    }

    // Store new pricing table
    public function store(Request $request)
    {
        $validated = $request->validate([
            'size' => 'required|string',
            'alat_berat_hydraulic' => 'nullable|string',
            'mini_crane' => 'nullable|string',
            'straus_pile' => 'nullable|string',
        ]);

        $pricingTable = PricingTable::create($validated);

        return response()->json([
            'message' => 'Pricing table created successfully',
            'data' => $pricingTable
        ], 201);
    }

    // Show single pricing table
    public function show($id)
    {
        $pricingTable = PricingTable::find($id);

        if (!$pricingTable) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json($pricingTable);
    }

    // Update pricing table
    public function update(Request $request, $id)
    {
        $pricingTable = PricingTable::find($id);

        if (!$pricingTable) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $validated = $request->validate([
            'size' => 'required|string',
            'alat_berat_hydraulic' => 'nullable|string',
            'mini_crane' => 'nullable|string',
            'straus_pile' => 'nullable|string',
        ]);

        $pricingTable->update($validated);

        return response()->json([
            'message' => 'Pricing table updated successfully',
            'data' => $pricingTable
        ]);
    }

    // Delete pricing table
    public function destroy($id)
    {
        $pricingTable = PricingTable::find($id);

        if (!$pricingTable) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $pricingTable->delete();

        return response()->json(['message' => 'Pricing table deleted successfully']);
    }
}
