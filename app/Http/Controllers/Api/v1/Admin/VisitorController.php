<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\Blog;
use Carbon\Carbon;

class VisitorController extends Controller
{
    /**
     * Total visitor summary
     */
    public function summary()
    {
        return response()->json([
            'total_visitors'       => Visitor::count(),
            'landing_page_visitors'=> Visitor::where('type', 'landing_page')->count(),
            'blog_visitors'        => Visitor::where('type', 'blog')->count(),
        ]);
    }

    /**
     * Statistik visitor harian (7 hari terakhir)
     */
    public function daily()
    {
        $data = Visitor::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        return response()->json($data);
    }

    /**
     * Blog paling banyak dibaca
     */
    public function topBlogs()
    {
        $data = Visitor::where('type', 'blog')
            ->selectRaw('blog_id, COUNT(*) as total')
            ->groupBy('blog_id')
            ->orderByDesc('total')
            ->with('blog:id,title,slug')
            ->limit(5)
            ->get();

        return response()->json($data);
    }
}
