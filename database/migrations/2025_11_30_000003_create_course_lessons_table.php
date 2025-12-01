<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_section_id')->constrained('course_sections')->cascadeOnDelete();

            $table->string('title');
            $table->string('lesson_type')->default('video'); // video | file | text
            $table->string('video_url')->nullable();
            $table->string('file_path')->nullable(); // فعلاً رشته (بعداً با dropzone واقعی می‌کنیم)
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->longText('content')->nullable();

            $table->unsignedInteger('priority')->default(1);
            $table->unsignedTinyInteger('status')->default(4);
            $table->timestamps();

            $table->index(['course_section_id', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_lessons');
    }
};
