<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Course;

class CourseBuilderController extends Controller
{
    public function index(Course $course)
    {
        $thispage = [
            'title' => 'ساختار دوره',
            'list'  => 'مدیریت سرفصل‌ها و درس‌ها',
        ];

        return view('panel.course_builder', compact('course', 'thispage'));
    }
}
