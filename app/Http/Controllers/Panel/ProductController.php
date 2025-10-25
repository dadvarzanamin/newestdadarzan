<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        {
            $thispage       = [
                'title'   => 'مدیریت خدمات',
                'list'    => 'لیست خدمات',
                'add'     => 'افزودن خدمات',
                'create'  => 'ایجاد خدمات',
                'enter'   => 'ورود خدمات',
                'edit'    => 'ویرایش خدمات',
                'delete'  => 'حذف خدمات',
            ];

            if ($request->ajax()) {
                $data = Product::select('id', 'title','price', 'product_type', 'start_date' , 'status')->orderBy('id')->get();

                return Datatables::of($data)
                    ->addColumn('id', function ($data) {
                        return ($data->id);
                    })
                    ->addColumn('title', function ($data) {
                        return ($data->title);
                    })
                    ->addColumn('price', function ($data) {
                        return (number_format((int)$data->price));
                    })
                    ->addColumn('product_type', function ($data) {
                        if ($data->product_type == "workshop") {
                            return "کارگاه";
                        } elseif ($data->product_type == "estelam") {
                            return "استعلام";
                        } elseif ($data->product_type == "contract") {
                            return "قرارداد";
                        }
                    })
                    ->addColumn('start_date', function ($data) {
                        return ($data->start_date);
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
                        if (auth()->user()->can('can-access', ['product', 'edit'])) {
                            $actionBtn .= '<button type="button" class="btn btn-sm btn-outline-primary edit-btn" data-id="'.$data->id.'" data-url="'.route('product.edit', $data->id).'"><i class="mdi mdi-pencil-outline"></i></button>';
                        }
                        if (auth()->user()->can('can-access', ['product', 'delete'])) {
                            $actionBtn .= '<button type="button" class="btn btn-sm btn-icon btn-outline-danger mx-1 delete-btn" data-id="'.$data->id.'"><i class="mdi mdi-delete-outline"></i></button>';
                        }
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('panel.product')->with(compact(['thispage']));
        }
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
    public function edit($id)
    {
        $product       = Product::whereId($id)->first();

        return view('panel.partials.edit-form-product', compact('product'));
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
