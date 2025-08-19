<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // id BIGINT AUTO_INCREMENT PRIMARY KEY
            $table->text('body'); // Текст поста
            $table->timestamp('pubtime')->nullable(); // Время публикации
            $table->json('images')->nullable(); // Массив изображений в формате JSON

            // Связь с таблицей users
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
