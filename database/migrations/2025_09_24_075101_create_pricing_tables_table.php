<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_tables', function (Blueprint $table) {
            $table->id();
            $table->string('size');
            $table->string('alat_berat_hydraulic')->nullable();
            $table->string('mini_crane')->nullable();
            $table->string('straus_pile')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_tables');
    }
};
