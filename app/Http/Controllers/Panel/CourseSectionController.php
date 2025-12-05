<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseSectionController extends Controller
{
    public function index(Request $request)
    {
        $courseId = (int) $request->get('course_id');
        $course = Course::findOrFail($courseId);

        $thispage = [
            'title'  => 'مدیریت سرفصل‌های دوره',
            'list'   => 'لیست سرفصل‌ها',
            'add'    => 'افزودن سرفصل',
            'edit'   => 'ویرایش سرفصل',
            'delete' => 'حذف سرفصل',
        ];

        if ($request->ajax()) {
            $data = CourseSection::query()
                ->where('course_id', $courseId)
                ->orderBy('priority');

            return DataTables::of($data)
                ->addColumn('status', function ($row) {
                    $map = [
                        0 => ['لغو', 'bg-label-danger'],
                        1 => ['غیرفعال', 'bg-label-secondary'],
                        2 => ['تکمیل ظرفیت', 'bg-label-warning'],
                        3 => ['پایان یافته', 'bg-label-info'],
                        4 => ['فعال', 'bg-label-success'],
                    ];
                    [$text, $cls] = $map[$row->status] ?? ['نامشخص', 'bg-label-secondary'];
                    return '<span class="badge '.$cls.'">'.$text.'</span>';
                })
                ->addColumn('action', function ($row) {
                    $base = 'btn btn-sm btn-icon rounded-pill waves-effect';

                    $btn  = '<a href="'.url('panel/course-lesson?section_id='.$row->id).'"
                        class="'.$base.' btn-outline-secondary mx-1"
                        title="آیتم‌های آموزشی">
                        <i class="mdi mdi-playlist-play"></i>
                    </a>';

                    $btn .=
                        '<button type="button"
                        class="'.$base.' btn-outline-primary mx-1 edit-btn"
                        data-url="'.url('panel/course-section/'.$row->id.'/edit').'">
                        <i class="mdi mdi-pencil-outline"></i>
                    </button>';

                    $btn .= '<button type="button"
                        class="'.$base.' btn-outline-danger mx-1 delete-btn"
                        data-id="'.$row->id.'">
                        <i class="mdi mdi-delete-outline"></i>
                    </button>';

                    return $btn;
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('panel.course_sections', compact('thispage', 'course'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'    => 'required|integer|exists:courses,id',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'priority'     => 'nullable|integer|min:1',
            'status'       => 'required|integer|min:0|max:4',
        ]);

        if (empty($validated['priority'])) {
            $max = CourseSection::where('course_id', $validated['course_id'])->max('priority') ?? 0;
            $validated['priority'] = $max + 1;
        }

        CourseSection::create($validated);

        return response()->json([
            'success' => true,
            'flag'    => 'success',
            'subject' => 'عملیات موفق',
            'message' => 'سرفصل با موفقیت افزوده شد.',
        ]);
    }

    public function edit($id)
    {
        $section = CourseSection::findOrFail($id);
        return view('panel.partials.edit-form-course-section', compact('section'));
    }

    public function update(Request $request, $id)
    {
        $section = CourseSection::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'priority'     => 'required|integer|min:1',
            'status'       => 'required|integer|min:0|max:4',
        ]);

        $section->update($validated);

        return response()->json([
            'success' => true,
            'flag'    => 'success',
            'subject' => 'عملیات موفق',
            'message' => 'سرفصل با موفقیت ویرایش شد.',
        ]);
    }

    public function destroy($id)
    {
        $section = CourseSection::findOrFail($id);
        $section->delete();

        return response()->json([
            'success' => true,
            'flag'    => 'success',
            'subject' => 'عملیات موفق',
            'message' => 'سرفصل با موفقیت حذف شد.',
        ]);
    }
}
