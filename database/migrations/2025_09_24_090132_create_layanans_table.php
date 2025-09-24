<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subtitle');
            $table->decimal('price', 15, 2);
            $table->string('location');
            $table->longText('description');
            $table->string('picture1')->nullable();
            $table->string('picture2')->nullable();
            $table->string('picture3')->nullable();
            $table->string('picture4')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
