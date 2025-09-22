<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['type', 'ip', 'user_agent', 'blog_id'];

    public function blog()
    {
        return $this->belongsTo(\App\Models\Blog::class);
    }
}
