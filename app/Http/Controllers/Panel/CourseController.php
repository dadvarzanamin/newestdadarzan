<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $thispage = [
            'title' => 'مدیریت دوره‌های آموزشی',
            'list' => 'لیست دوره‌ها',
            'add' => 'افزودن دوره',
            'create' => 'ایجاد دوره',
            'edit' => 'ویرایش دوره',
            'delete' => 'حذف دوره',
        ];

        if ($request->ajax()) {
            $data = Course::query()->latest();

            return DataTables::of($data)
                ->addColumn('course_use', function ($row) {
                    $uses = is_array($row->course_use) ? $row->course_use : [];
                    return empty($uses) ? '-' : implode('، ', $uses);
                })
                ->addColumn('status', function ($row) {
                    // ساده و هماهنگ با تم پنل (بدون رنگ صریح)
                    $map = [
                        0 => ['لغو', 'bg-label-danger'],
                        1 => ['غیرفعال', 'bg-label-secondary'],
                        2 => ['تکمیل ظرفیت', 'bg-label-warning'],
                        3 => ['پایان یافته', 'bg-label-info'],
                        4 => ['فعال', 'bg-label-success'],
                    ];
                    [$text, $cls] = $map[$row->status] ?? ['نامشخص', 'bg-label-secondary'];
                    return '<span class="badge ' . $cls . '">' . $text . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';

                    $btn .= '<a href="'.url('panel/course-section?course_id='.$row->id).'"
                        class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect"
                        title="سرفصل‌ها">
                        <i class="mdi mdi-format-list-bulleted"></i>
                    </a>';

                    if (auth()->user()->can('can-access', ['course', 'edit'])) {
                        $btn .= '<button type="button" class="btn btn-sm btn-outline-primary edit-btn"
                            data-id="' . $row->id . '"
                            data-url="' . route('course.edit', $row->id) . '"
                            data-bs-toggle="modal" data-bs-target="#editModal">
                            <i class="mdi mdi-pencil-outline"></i>
                        </button>';
                    }

                    if (auth()->user()->can('can-access', ['course', 'delete'])) {
                        $btn .= '<button type="button" class="btn btn-sm btn-icon btn-outline-danger mx-1 delete-btn"
                            data-id="'.$row->id.'"
                            data-route="'.route('course.destroy', $row->id).'">
                            <i class="mdi mdi-delete-outline"></i>
                        </button>';

                    }

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('panel.course')->with(compact('thispage'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'en_title' => 'nullable|string|max:255',
            'instructor' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'course_use' => 'nullable|array',
            'course_use.*' => 'nullable|string|max:50',
            'start_date' => 'nullable|string|max:50',
            'end_date' => 'nullable|string|max:50',
            'certificate' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'cover' => 'nullable|string|max:500',
            'status' => 'required|integer|min:0|max:4',
        ]);

        Course::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'flag'    => 'success',
                'subject' => 'عملیات موفق',
                'message' => 'اطلاعات با موفقیت ثبت شد',
            ]);
        }

        return redirect()->back();
    }

    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        return view('panel.partials.edit-form-course', compact('course'));
    }

    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'en_title' => 'nullable|string|max:255',
            'instructor' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'course_use' => 'nullable|array',
            'course_use.*' => 'nullable|string|max:50',
            'start_date' => 'nullable|string|max:50',
            'end_date' => 'nullable|string|max:50',
            'certificate' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'cover' => 'nullable|string|max:500',
            'status' => 'required|integer|min:0|max:4',
        ]);

        $course->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'flag'    => 'success',
                'subject' => 'عملیات موفق',
                'message' => 'اطلاعات با موفقیت ثبت شد',
            ]);
        }

        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json([
            'success' => true,
            'flag'    => 'success',
            'subject' => 'عملیات موفق',
            'message' => 'اطلاعات با موفقیت پاک شد',
        ]);    }
}
