<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'en_title',
        'instructor',
        'price',
        'course_use',        // json: ["آنلاین","حضوری"]
        'status',
        'start_date',
        'end_date',
        'certificate',       // "دارد" / "ندارد" (فعلاً مثل product)
        'description',
        'full_description',
        'cover',             // optional (string path/url) - فازهای بعدی بهتر می‌کنیم
    ];

    protected $casts = [
        'course_use' => 'array',
    ];
}
