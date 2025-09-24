<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'size',
        'alat_berat_hydraulic',
        'mini_crane',
        'straus_pile',
    ];
}
