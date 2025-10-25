<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('log_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->comment('کاربر ');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('action')->comment('فعالیت مربوطه ');
            $table->string('ip_address')->nullable()->comment('ادرس ip کاربر ');
            $table->text('user_agent')->nullable()->comment('اطلاعات دستگاه کاربر ');
            $table->boolean('status')->default(true)->comment('وضعیت فعالیت true = success, false = failed ');
            $table->text('description')->nullable()->comment('توضیحات مربوط به فعالت ');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('log_users');
    }
};
