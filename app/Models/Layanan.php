<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subtitle',
        'price',
        'location',
        'description',
        'picture1',
        'picture2',
        'picture3',
        'picture4',
    ];
}
