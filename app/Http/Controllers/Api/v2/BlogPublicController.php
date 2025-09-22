<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Cache;
use App\Jobs\LogVisitorJob;

class BlogPublicController extends Controller
{
    /**
     * List semua blog + log visitor landing page
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $cacheKey = "blogs_page_{$page}_perpage_{$perPage}";

        $blogs = Cache::remember($cacheKey, 60, function () use ($perPage) {
            return Blog::select('id', 'title', 'slug', 'category', 'headline_img', 'date', 'status')
                ->where('status', 'published')
                ->latest()
                ->paginate($perPage);
        });

        // Dispatch job untuk log visitor
        LogVisitorJob::dispatch([
            'type'       => 'landing_page',
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
            'blog_id'    => null,
        ]);

        return response()->json($blogs);
    }

    /**
     * Detail blog + log visitor reader
     */
    public function show(Request $request, $slug)
    {
        $cacheKey = "blog_detail_{$slug}";

        $blog = Cache::remember($cacheKey, 60, function () use ($slug) {
            return Blog::where('slug', $slug)
                ->where('status', 'published')
                ->firstOrFail();
        });

        // Dispatch job untuk log visitor
        LogVisitorJob::dispatch([
            'type'       => 'blog',
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
            'blog_id'    => $blog->id,
        ]);

        return response()->json($blog);
    }
}
