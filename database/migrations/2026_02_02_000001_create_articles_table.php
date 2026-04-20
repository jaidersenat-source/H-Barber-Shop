<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->text('excerpt')->nullable(); // Resumen para SEO
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt', 200)->nullable(); // Alt para SEO
            
            // SEO fields
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->string('meta_keywords', 255)->nullable();
            
            // Author
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('usuario_id')->on('usuarios')->onDelete('cascade');
            
            // Status and visibility
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            
            // Stats
            $table->unsignedInteger('views')->default(0);
            
            // Category for organization
            $table->string('category', 100)->nullable();
            
            $table->timestamps();
            
            // Indexes for SEO and performance
            $table->index('status');
            $table->index('published_at');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
