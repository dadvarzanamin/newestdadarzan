<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable()->comment('شناسه کاربری که این نقش را ایجاد کرده');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('product_id')->nullable()->comment('شناسه محصول');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->string('product_type')->nullable()->comment('نوع محصول');
            $table->string('product_price')->nullable()->comment('قیمت محصول');
            $table->string('type_use')->nullable()->comment('نحوه استفاده');
            $table->string('certificate')->nullable()->comment('گواهینامه میخواهد / نمیخواهد');
            $table->string('certificate_price')->nullable()->comment('مبلغ گواهی نامه');
            $table->string('license')->nullable()->comment('اعتبار');
            $table->string('license_time')->nullable()->comment('زمان اعتبار');
            $table->string('license_price')->nullable()->comment('مبلغ اعتبار');
            $table->string('offer_discount')->nullable()->comment('مبلغ تخفیف اعمالی');
            $table->string('offer_percentage')->nullable()->comment('درصد تخفیف اعمالی');
            $table->string('price')->nullable()->comment('مبلغ');
            $table->string('price_status')->nullable()->comment('وضعیت پرداخت');
            $table->text('transactionId')->nullable()->comment('کد پیگیری ارسال به درگاه');
            $table->string('referenceId')->nullable()->comment('کد پیگیری دریافتی از درگاه');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
