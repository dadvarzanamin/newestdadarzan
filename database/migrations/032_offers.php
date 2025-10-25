<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable()->comment('شناسه کاربری که این نقش را ایجاد کرده');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('user_offer')->nullable()->comment('کد مخصوص کاربر');
            $table->foreign('user_offer')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('product_id')->nullable()->comment('شناسه محصول');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->string('offercode')->nullable()->comment('کد تخفیف');
            $table->string('discount')->default(0)->comment('مبلغ تخفیف');
            $table->string('percentage')->default(0)->comment('درصد تخفیف');
            $table->tinyInteger('status')->default(1)->comment('وضعیت فعال / غیر فعال');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
