<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('priority')->default(1);
            $table->unsignedTinyInteger('status')->default(4); // 0..4 مثل بقیه
            $table->timestamps();

            $table->index(['course_id', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_sections');
    }
};
