<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Jobs\ProcessBlogJob;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $blogs = Blog::select('id', 'title', 'slug', 'category', 'headline_img', 'date', 'status')->latest()->paginate($perPage);

        return response()->json($blogs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'content' => 'required',
            'keywords' => 'nullable|string',
            'headline_img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'date' => 'nullable|date',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->except('headline_img');
        $data['slug'] = Str::slug($request->title);

        // Upload gambar jika ada
        if ($request->hasFile('headline_img')) {
            $path = $request->file('headline_img')->store('blogs', 'public');
            $data['headline_img'] = '/storage/' . $path;
        }

        // Dispatch ke queue
        ProcessBlogJob::dispatch($data);

        return response()->json(
            [
                'message' => 'Blog creation queued successfully!',
                'data' => $data,
            ],
            202,
        );
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'category' => 'sometimes|string',
            'content' => 'sometimes',
            'keywords' => 'nullable|string',
            'headline_img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'date' => 'nullable|date',
            'status' => 'sometimes|in:draft,published',
        ]);

        $data = $request->except('headline_img');

        if ($request->hasFile('headline_img')) {
            $path = $request->file('headline_img')->store('blogs', 'public');
            $data['headline_img'] = '/storage/' . $path;
        }

        $blog->update($data);

        return response()->json([
            'message' => 'Blog updated successfully',
            'data' => $blog,
        ]);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully']);
    }
}
