<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id()->comment('شناسه یکتا پنل منو');
            $table->unsignedBigInteger('priority')->comment('شماره اولویت');
            $table->string('label')->comment('عنوان فارسی پنل منو');
            $table->string('title')->comment('عنوان پنل منو');
            $table->string('slug')->comment('آدرس منو یا شناسه منو');
            $table->string('icon')->nullable()->comment('آیکون پنل منو');
            $table->boolean('submenu')->default(0)->comment('آیا منو زیرمنو دارد؟');
            $table->string('class')->nullable()->comment('کلاس لاراول');
            $table->string('type')->nullable()->comment('نوع استفاده site/panel/profile');
            $table->text('level')->nullable()->comment('سطح نمایش');
            $table->string('controller')->nullable()->comment('کنترلر مرتبط با منو');
            $table->boolean('status')->default(0)->comment('وضعیت منو (فعال/غیرفعال)');
            $table->unsignedBigInteger('user_id')->comment('شناسه کاربری که این نقش را ایجاد کرده');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
