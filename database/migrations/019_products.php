<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('priority')->nullable()->comment('شماره اولویت نمایش');
            $table->string('title')->comment('عنوان محصول');
            $table->string('en_title')->nullable()->comment('عنوان انگلیسی');
            $table->string('sub_title')->nullable()->comment('زیر عنوان');
            $table->string('slug')->unique()->comment('نام قابل استفاده');

            $table->string('item1')->nullable()->comment('اختیاری');
            $table->string('item2')->nullable()->comment('اختیاری');
            $table->string('item3')->nullable()->comment('اختیاری');
            $table->string('item4')->nullable()->comment('اختیاری');
            $table->string('item5')->nullable()->comment('اختیاری');

            $table->string('price')->default(0)->comment('مبلغ');
            $table->string('cover')->nullable()->comment('تصویر کاور');
            $table->string('file_path')->nullable()->comment('لینک فایل');

            $table->string('product_type')->nullable()->comment('نوع محصول');
            $table->string('product_use')->nullable()->comment('نوع استفاده');
            $table->string('product_time')->nullable()->comment('زمان');
            $table->string('level')->nullable()->comment('سطح قابل نمایش');

            $table->text('description')->nullable()->comment('توضیحات کلی');
            $table->longText('full_description')->nullable()->comment('توضیحات طولانی');

            $table->date('start_date')->nullable()->comment('تاریخ شروع');
            $table->date('end_date')->nullable()->comment('تاریخ پایان');
            $table->date('exp_date')->nullable()->comment('تاریخ انقضا');

            $table->boolean('certificate')->default(0)->comment('وجوع / عدم وجود گواهی نامه');
            $table->string('cover_certificate')->nullable()->comment('تصویر نمونه گواهی نامه');
            $table->string('type_certificate')->nullable()->comment('نوع گاهی نامه');
            $table->string('price_certificate')->nullable()->comment('هزینه گواهی نامه');

            $table->unsignedBigInteger('count_view')->default(0)->comment('تعداد بازدید');
            $table->unsignedBigInteger('count_click')->default(0)->comment('تعداد کلیک');
            $table->unsignedBigInteger('count_download')->default(0)->comment('تعداد دانلود');

            $table->tinyInteger('status')->default(1)->comment('وضعیت نمایش');
            $table->unsignedBigInteger('user_id')->nullable()->comment('شناسه کاربری که این نقش را ایجاد کرده');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
