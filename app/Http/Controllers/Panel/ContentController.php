<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Menu;
use App\Models\Submenu;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ContentController extends Controller
{

    public function index(Request $request)
    {
        $thispage       = [
            'title'   => 'مدیریت محتوا',
            'list'    => 'لیست محتوا',
            'add'     => 'افزودن محتوا',
            'create'  => 'ایجاد محتوا',
            'enter'   => 'ورود محتوا',
            'edit'    => 'ویرایش محتوا',
            'delete'  => 'حذف محتوا',
        ];

        if ($request->ajax()) {
            $data = Content::leftJoin('menus', 'menus.id', '=', 'contents.menu_id')
                ->leftJoin('submenus', 'submenus.id', '=', 'contents.submenu_id')
                ->select('contents.*', 'menus.title as menu_title', 'submenus.title as submenu_title')
                ->orderByDesc('contents.id')
                ->get();

            return Datatables::of($data)
                ->addColumn('id', function ($data) {
                    return ($data->id);
                })
                ->addColumn('title', function ($data) {
                    return ($data->title);
                })
                ->addColumn('menu_title', function ($data) {
                    return ($data->menu_title);
                })
                ->addColumn('submenu_title', function ($data) {
                    return ($data->submenu_title);
                })
                ->addColumn('slide', function ($data) {
                    if (empty($data->slide)) {
                        return '-';
                    }
                    $fileUrl = asset('storage/' . ltrim($data->slide, '/'));
                    return '<img src="' . $fileUrl . '" alt="اسلاید" style="width: 80px; height: auto;">';
                })
                ->addColumn('cover', function ($data) {
                    if (empty($data->cover)) {
                        return '-';
                    }
                    $fileUrl = asset('storage/' . ltrim($data->cover, '/'));
                    return '<img src="' . $fileUrl . '" alt="کاور" style="width: 80px; height: auto;">';
                })
                ->addColumn('image', function ($data) {
                    if (empty($data->image)) {
                        return '-';
                    }
                    $fileUrl = asset('storage/' . ltrim($data->image, '/'));
                    return '<img src="' . $fileUrl . '" alt="تصویر محتوا" style="width: 80px; height: auto;">';
                })
                ->addColumn('video', function ($data) {
                    if (empty($data->video)) {
                        return '-';
                    }
                    $fileUrl = asset('storage/' . ltrim($data->video, '/'));
                    return '<video width="160" height="90" controls><source src="' . $fileUrl . '" type="video/mp4">مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.</video>';
                })
                ->addColumn('aparat', function ($data) {
                    if (empty($data->aparat)) {
                        return '-';
                    }

                    if (filter_var($data->aparat, FILTER_VALIDATE_URL)) {
                        return '<a href="' . $data->aparat . '" target="_blank">مشاهده لینک آپارات</a>';
                    }

                    $fileUrl = asset('storage/' . ltrim($data->aparat, '/'));
                    return '<video width="160" height="90" controls><source src="' . $fileUrl . '" type="video/mp4">مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.</video>';
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == "0") {
                        return "لغو ";
                    } elseif ($data->status == "1") {
                        return "غیر فعال";
                    } elseif ($data->status == "2") {
                        return "تکمیل ظرفیت";
                    } elseif ($data->status == "3") {
                        return "پایان یافته";
                    } elseif ($data->status == "4") {
                        return "فعال";
                    }
                })
                ->editColumn('action', function ($data) {
                    $base = 'btn btn-sm btn-icon rounded-pill waves-effect mx-1';

                    $actionBtn = '';
                    if (auth()->user()->can('can-access', ['content', 'edit'])) {
                        $actionBtn .= '<button type="button" class="'.$base.' btn btn-sm btn-outline-primary edit-btn" data-id="'.$data->id.'" data-url="'.route('content.edit', $data->id).'"><i class="mdi mdi-pencil-outline"></i></button>';
                    }
                    if (auth()->user()->can('can-access', ['content', 'delete'])) {
                        $actionBtn .= '<button type="button" class="'.$base.' btn btn-sm btn-icon btn-outline-danger mx-1 delete-btn" data-id="'.$data->id.'"><i class="mdi mdi-delete-outline"></i></button>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action', 'slide', 'cover', 'image', 'video', 'aparat'])
                ->make(true);
        }
        return view('panel.content')->with(compact(['thispage']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'slide' => 'nullable|string|max:255',
            'cover' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'video' => 'nullable|string',
            'aparat' => 'nullable|string|max:1000',
            'file' => 'nullable|string',
            'menupanel_id' => 'required|exists:menus,id',
            'submenupanel_id' => 'required|exists:submenus,id',
            'status' => 'nullable|in:0,1,2,3,4',
            'content_html' => 'nullable|string',
        ]);

        try {
            $content = new Content();
            $content->title = $validated['title'];
            $content->slug = $validated['slug'] ?? null;
            $content->description = $validated['description'] ?? null;
            $content->full_description = $validated['content_html'] ?? ($validated['full_description'] ?? null);
            $content->meta_title = $validated['meta_title'] ?? null;
            $content->meta_description = $validated['meta_description'] ?? null;
            $content->slide = $validated['slide'] ?? null;
            $content->cover = $validated['cover'] ?? null;
            $content->image = $validated['image'] ?? null;
            $content->video = $validated['video'] ?? null;
            $content->aparat = $validated['aparat'] ?? null;
            $content->file = $validated['file'] ?? null;
            $content->menu_id = (int) $validated['menupanel_id'];
            $content->submenu_id = (int) $validated['submenupanel_id'];
            $content->status = $validated['status'] ?? 4;
            $content->user_id = Auth::id();

            $result = $content->save();

            if ($result === true) {
                $success = true;
                $flag = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات با موفقیت ثبت شد';
            } else {
                $success = false;
                $flag = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات ثبت نشد، لطفا مجددا تلاش نمایید';
            }
        } catch (Exception $e) {
            $success = false;
            $flag = 'error';
            $subject = 'خطا در ارتباط با سرور';
            $message = 'اطلاعات ثبت نشد، لطفا بعدا مجدد تلاش نمایید';
        }

        return response()->json(['success' => $success, 'subject' => $subject, 'flag' => $flag, 'message' => $message]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $content = Content::findOrFail($id);
        $menus = Menu::where('type', 'site')->where('status', 4)->where('id', '!=', 11)->orderBy('label')->get();
        $submenus = Submenu::where('type', 'site')->where('status', 4)->orderBy('label')->get();

        return view('panel.partials.edit-form-content', compact('content', 'menus', 'submenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'slide' => 'nullable|string|max:255',
            'cover' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'video' => 'nullable|string',
            'aparat' => 'nullable|string|max:1000',
            'file' => 'nullable|string',
            'menupanel_id' => 'required|exists:menus,id',
            'submenupanel_id' => 'required|exists:submenus,id',
            'status' => 'nullable|in:0,1,2,3,4',
            'content_html' => 'nullable|string',
        ]);

        try {
            $content = Content::findOrFail($id);
            $content->title = $validated['title'];
            $content->slug = $validated['slug'] ?? $content->slug;
            $content->description = $validated['description'] ?? null;
            $content->full_description = $validated['content_html'] ?? ($validated['full_description'] ?? null);
            $content->meta_title = $validated['meta_title'] ?? null;
            $content->meta_description = $validated['meta_description'] ?? null;
            $content->slide = $validated['slide'] ?? null;
            $content->cover = $validated['cover'] ?? null;
            $content->image = $validated['image'] ?? null;
            $content->video = $validated['video'] ?? null;
            $content->aparat = $validated['aparat'] ?? null;
            $content->file = $validated['file'] ?? null;
            $content->menu_id = (int) $validated['menupanel_id'];
            $content->submenu_id = (int) $validated['submenupanel_id'];
            $content->status = $validated['status'] ?? $content->status;
            $content->user_id = Auth::id();

            $result = $content->save();

            if ($result === true) {
                $success = true;
                $flag = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات با موفقیت ذخیره شد';
            } else {
                $success = false;
                $flag = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات ثبت نشد، لطفا مجددا تلاش نمایید';
            }
        } catch (Exception $e) {
            $success = false;
            $flag = 'error';
            $subject = 'خطا در ارتباط با سرور';
            $message = 'اطلاعات ذخیره نشد، لطفا بعدا مجدد تلاش نمایید';
        }

        return response()->json(['success' => $success, 'subject' => $subject, 'flag' => $flag, 'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $content = Content::findOrFail($id);
            $result = $content->delete();

            if ($result === true) {
                $success = true;
                $flag = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات با موفقیت پاک شد';
            } else {
                $success = false;
                $flag = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات پاک نشد، لطفا مجددا تلاش نمایید';
            }
        } catch (Exception $e) {
            $success = false;
            $flag = 'error';
            $subject = 'خطا در ارتباط با سرور';
            $message = 'اطلاعات پاک نشد، لطفا بعدا مجدد تلاش نمایید';
        }

        return response()->json(['success' => $success, 'subject' => $subject, 'flag' => $flag, 'message' => $message]);
    }
}
