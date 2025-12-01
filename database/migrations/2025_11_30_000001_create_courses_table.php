<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('en_title')->nullable();
            $table->string('instructor')->nullable();

            $table->unsignedBigInteger('price')->nullable();
            $table->json('course_use')->nullable();

            $table->string('start_date')->nullable(); // فعلاً string مثل پروژه شما (jalali)
            $table->string('end_date')->nullable();

            $table->string('certificate')->nullable(); // "دارد" / "ندارد"
            $table->text('description')->nullable();
            $table->longText('full_description')->nullable();

            $table->string('cover')->nullable();

            $table->tinyInteger('status')->default(1); // 0..4 مطابق پنل شما

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
