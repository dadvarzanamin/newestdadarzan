<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id()->comment('شناسه یکتا');
            $table->string('title')->comment('عنوان زیرمنو');
            $table->boolean('status')->default(0)->comment('وضعیت زیرمنو (فعال/غیرفعال)');
            $table->unsignedBigInteger('state_id')->comment('شناسه کاربری که این نقش را ایجاد کرده');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
