<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $thispage       = [
            'title'   => 'مدیریت منو داشبورد',
            'list'    => 'لیست منو داشبورد',
            'add'     => 'افزودن منو داشبورد',
            'create'  => 'ایجاد منو داشبورد',
            'enter'   => 'ورود منو داشبورد',
            'edit'    => 'ویرایش منو داشبورد',
            'delete'  => 'حذف منو داشبورد',
        ];

        if ($request->ajax()) {
            $data = Content::select('id' ,'priority', 'title','label', 'slug', 'status' , 'class' , 'controller')->where('type' , 'panel')->orderBy('priority')->get();

            return Datatables::of($data)
                ->addColumn('id', function ($data) {
                    return ($data->priority);
                })
                ->addColumn('title', function ($data) {
                    return ($data->title);
                })
                ->addColumn('label', function ($data) {
                    return ($data->label);
                })
                ->addColumn('slug', function ($data) {
                    return ($data->slug);
                })
                ->addColumn('class', function ($data) {
                    return ($data->class);
                })
                ->addColumn('controller', function ($data) {
                    return ($data->controller);
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
                    if (auth()->user()->can('can-access', ['menupanel', 'edit'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-outline-primary edit-btn" data-id="'.$data->id.'" data-url="'.route('menupanel.edit', $data->id).'"><i class="mdi mdi-pencil-outline"></i></button>';
                    }
                    if (auth()->user()->can('can-access', ['menupanel', 'delete'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-icon btn-outline-danger mx-1 delete-btn" data-id="'.$data->id.'"><i class="mdi mdi-delete-outline"></i></button>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('panel.menupanel')->with(compact(['thispage']));
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
