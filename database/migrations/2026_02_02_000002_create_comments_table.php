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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            
            // Puede ser usuario registrado o visitante
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('usuario_id')->on('usuarios')->onDelete('set null');
            
            // Para visitantes no registrados
            $table->string('guest_name', 100)->nullable();
            $table->string('guest_email', 150)->nullable();
            
            $table->text('content');
            
            // Moderación
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            // Respuestas a otros comentarios
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
            
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index(['article_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
