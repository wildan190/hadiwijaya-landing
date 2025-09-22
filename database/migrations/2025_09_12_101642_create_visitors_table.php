<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // landing_page atau blog
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->unsignedBigInteger('blog_id')->nullable(); // kalau type = blog
            $table->timestamps();

            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
