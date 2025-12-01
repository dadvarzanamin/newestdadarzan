<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\CourseLesson;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseLessonController extends Controller
{
    public function index(Request $request)
    {
        $sectionId = (int) $request->get('section_id');
        $section = CourseSection::with('course')->findOrFail($sectionId);

        $thispage = [
            'title'  => 'مدیریت آیتم‌های آموزشی',
            'list'   => 'لیست آیتم‌ها',
            'add'    => 'افزودن آیتم',
            'edit'   => 'ویرایش آیتم',
            'delete' => 'حذف آیتم',
        ];

        if ($request->ajax()) {
            $data = CourseLesson::query()
                ->where('course_section_id', $sectionId)
                ->orderBy('priority');

            return DataTables::of($data)
                ->addColumn('lesson_type', fn($row) => match ($row->lesson_type) {
                    'video' => 'ویدئو',
                    'file'  => 'جزوه/فایل',
                    'text'  => 'متن/مقاله',
                    'mixed' => 'ترکیبی (ویدئو + جزوه)',
                    default => $row->lesson_type,
                })
                ->addColumn('duration', function ($row) {
                    if (!$row->duration_seconds) return '-';
                    $m = intdiv($row->duration_seconds, 60);
                    $s = $row->duration_seconds % 60;
                    return sprintf('%02d:%02d', $m, $s);
                })
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
                    $base = 'btn btn-sm btn-icon rounded-pill waves-effect mx-1';

                    $btn  = '<button type="button"
                        class="'.$base.' btn-outline-primary edit-btn"
                        data-url="'.url('panel/course-lesson/'.$row->id.'/edit').'">
                        <i class="mdi mdi-pencil-outline fs-5"></i>
                    </button>';

                    $btn .= '<button type="button"
                        class="'.$base.' btn-outline-danger delete-btn"
                        data-id="'.$row->id.'">
                        <i class="mdi mdi-delete-outline fs-5"></i>
                    </button>';

                    return $btn;
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('panel.course_lessons', compact('thispage', 'section'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_section_id' => 'required|integer|exists:course_sections,id',
            'title'             => 'required|string|max:255',
            'lesson_type'       => 'required|string|in:video,file,text,mixed',

            // keep minutes in UI
            'duration_minutes'  => 'nullable|integer|min:0',

            'video_url'         => 'nullable|string|max:1000',
            'file_path'         => 'nullable|string|max:1000',
            'content'           => 'nullable|string',

            'priority'          => 'nullable|integer|min:1',
            'status'            => 'required|integer|min:0|max:4',
        ]);

        // conditional validation rules
        if (in_array($validated['lesson_type'], ['video', 'mixed'], true)) {
            $request->validate(['video_url' => 'required|string|max:1000']);
        }
        if (in_array($validated['lesson_type'], ['file', 'mixed'], true)) {
            $request->validate(['file_path' => 'required|string|max:1000']);
        }
        if ($validated['lesson_type'] === 'text') {
            $request->validate(['content' => 'required|string']);
        }

        // convert minutes -> seconds (store in duration_seconds)
        $validated['duration_seconds'] = isset($validated['duration_minutes'])
            ? ((int)$validated['duration_minutes'] * 60)
            : null;

        unset($validated['duration_minutes']);


        if (empty($validated['priority'])) {
            $max = CourseLesson::where('course_section_id', $validated['course_section_id'])->max('priority') ?? 0;
            $validated['priority'] = $max + 1;
        }

        CourseLesson::create($validated);

        return response()->json([
            'success' => true,
            'flag'    => 'success',
            'subject' => 'عملیات موفق',
            'message' => 'آیتم آموزشی با موفقیت افزوده شد.',
        ]);
    }

    public function edit($id)
    {
        $lesson = CourseLesson::findOrFail($id);
        return view('panel.partials.edit-form-course-lesson', compact('lesson'));
    }

    public function update(Request $request, $id)
    {
        $lesson = CourseLesson::findOrFail($id);

        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'lesson_type'       => 'required|string|in:video,file,text,mixed',

            'duration_minutes'  => 'nullable|integer|min:0',

            'video_url'         => 'nullable|string|max:1000',
            'file_path'         => 'nullable|string|max:1000',
            'content'           => 'nullable|string',

            'priority'          => 'required|integer|min:1',
            'status'            => 'required|integer|min:0|max:4',
        ]);

        if (in_array($validated['lesson_type'], ['video', 'mixed'], true)) {
            $request->validate(['video_url' => 'required|string|max:1000']);
        }
        if (in_array($validated['lesson_type'], ['file', 'mixed'], true)) {
            $request->validate(['file_path' => 'required|string|max:1000']);
        }
        if ($validated['lesson_type'] === 'text') {
            $request->validate(['content' => 'required|string']);
        }

        $validated['duration_seconds'] = isset($validated['duration_minutes'])
            ? ((int)$validated['duration_minutes'] * 60)
            : null;

        unset($validated['duration_minutes']);


        $lesson->update($validated);

        return response()->json([
            'success' => true,
            'flag'    => 'success',
            'subject' => 'عملیات موفق',
            'message' => 'آیتم آموزشی با موفقیت ویرایش شد.',
        ]);
    }

    public function destroy($id)
    {
        $lesson = CourseLesson::findOrFail($id);
        $lesson->delete();

        return response()->json([
            'success' => true,
            'flag'    => 'success',
            'subject' => 'عملیات موفق',
            'message' => 'آیتم آموزشی با موفقیت حذف شد.',
        ]);
    }
}
