<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    protected $fillable = [
        'course_section_id', 'title', 'type', 'priority', 'status',
        'video_url', 'file_path', 'content'
    ];

    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }
}
