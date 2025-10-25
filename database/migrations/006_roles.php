<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id()->comment('شناسه یکتا نقش');
            $table->string('title_fa')->nullable()->comment('عنوان نقش مانند مدیر، کاربر، ناظر');
            $table->string('title')->nullable()->comment('نام انگلیسی یا کد یکتا نقش برای استفاده در سیستم');
            $table->boolean('status')->nullable()->comment('وضعیت فعال = 4 و غیر فعال = 0');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
