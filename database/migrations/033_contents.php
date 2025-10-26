<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();

            $table->text('description')->nullable();
            $table->longText('full_description')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('slide')->nullable()->comment('تصویر اسلاید');
            $table->string('cover')->nullable()->comment('تصویر کاور');
            $table->text('image')->nullable()->comment('تصاویر محتوا');
            $table->text('video')->nullable()->comment('ویدئو محتوا');
            $table->string('aparat')->nullable()->comment('ویدئو اپارات');
            $table->text('file')->nullable()->comment('فایل ها');

            $table->unsignedBigInteger('menu_id')->comment('شناسه منو ');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');

            $table->unsignedBigInteger('submenu_id')->comment('شناسه زیرمنو ');
            $table->foreign('submenu_id')->references('id')->on('submenus')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable()->comment('شناسه کاربری که این نقش را ایجاد کرده');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->tinyInteger('status')->default(4)->comment('وضعیت فعال / غیر فعال');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
