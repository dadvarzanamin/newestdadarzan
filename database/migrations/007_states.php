<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('states', function (Blueprint $table) {
            $table->id()->comment('شناسه یکتا');
            $table->string('title')->comment('عنوان زیرمنو');
            $table->boolean('status')->default(0)->comment('وضعیت زیرمنو (فعال/غیرفعال)');
            $table->string('lat')->comment('طول جغرافیایی');
            $table->string('lng')->comment('عرض جغرافیایی');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
