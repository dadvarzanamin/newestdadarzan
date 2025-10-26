<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
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
            $data = Content::
              leftjoin('menus'      , 'menus.id'        , '='   , 'contents.menu_id')
            ->leftjoin('submenus'   , 'submenus.id'     , '='   , 'contents.submenu_id')
            ->select('contents.*'  , 'menus.title as menu_title' , 'submenus.title as submenu_title')
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
                    $fileUrl = asset('storage/' . $data->slide);
                    if ($data->type === 'image') {
                        return '<img src="' . $fileUrl . '" alt="تصویر" style="width: 80px; height: auto;">';
                    }
                })
                ->addColumn('cover', function ($data) {
                    $fileUrl = asset('storage/' . $data->cover);
                    if ($data->type === 'image') {
                        return '<img src="' . $fileUrl . '" alt="تصویر" style="width: 80px; height: auto;">';
                    }
                })
                ->addColumn('image', function ($data) {
                    $fileUrl = asset('storage/' . $data->image);
                    if ($data->type === 'image') {
                        return '<img src="' . $fileUrl . '" alt="تصویر" style="width: 80px; height: auto;">';
                    }
                })
                ->addColumn('video', function ($data) {
                    $fileUrl = asset('storage/' . $data->video);
                    if ($data->type === 'videos') {
                        return '<video width="160" height="90" controls><source src="' . $fileUrl . '" type="video/mp4">مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.</video>';
                    }
                })
                ->addColumn('aparat', function ($data) {
                    $fileUrl = asset('storage/' . $data->aparat);
                    return '<a href="' . $fileUrl . '">' . $data->original_name . '</a>';
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

                    $actionBtn = '';
                    if (auth()->user()->can('can-access', ['content', 'edit'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-outline-primary edit-btn" data-id="'.$data->id.'" data-url="'.route('content.edit', $data->id).'"><i class="mdi mdi-pencil-outline"></i></button>';
                    }
                    if (auth()->user()->can('can-access', ['content', 'delete'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-icon btn-outline-danger mx-1 delete-btn" data-id="'.$data->id.'"><i class="mdi mdi-delete-outline"></i></button>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
