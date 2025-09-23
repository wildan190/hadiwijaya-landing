<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    // Get all FAQs
    public function index()
    {
        return response()->json(Faq::all(), 200);
    }

    // Store new FAQ
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);

        $faq = Faq::create($validated);

        return response()->json($faq, 201);
    }

    // Show single FAQ
    public function show($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json(['message' => 'FAQ not found'], 404);
        }

        return response()->json($faq, 200);
    }

    // Update FAQ
    public function update(Request $request, $id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json(['message' => 'FAQ not found'], 404);
        }

        $validated = $request->validate([
            'category' => 'sometimes|required|string|max:255',
            'question' => 'sometimes|required|string|max:255',
            'answer'   => 'sometimes|required|string',
        ]);

        $faq->update($validated);

        return response()->json($faq, 200);
    }

    // Delete FAQ
    public function destroy($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json(['message' => 'FAQ not found'], 404);
        }

        $faq->delete();

        return response()->json(['message' => 'FAQ deleted successfully'], 200);
    }
}
