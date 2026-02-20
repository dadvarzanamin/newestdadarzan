<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        {
            $thispage       = [
                'title'   => 'مدیریت محصولات',
                'list'    => 'لیست محصولات',
                'add'     => 'افزودن محصول',
                'create'  => 'ایجاد محصول',
                'enter'   => 'ورود محصول',
                'edit'    => 'ویرایش محصول',
                'delete'  => 'حذف محصول',
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'en_title' => 'nullable|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'item1' => 'nullable|string|max:255',
            'item2' => 'nullable|string|max:255',
            'item3' => 'nullable|string|max:255',
            'item4' => 'nullable|string|max:255',
            'item5' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'product_type' => 'required|in:workshop,estelam,contract',
            'product_use' => 'nullable|array',
            'product_use.*' => 'nullable|string|max:50',
            'product_time' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'exp_date' => 'nullable|date',
            'certificate' => 'nullable|in:دارد,ندارد',
            'price_certificate' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'status' => 'required|in:0,1,2,3,4',
        ]);

        try {
            $baseSlug = Str::slug((string) $validated['title']);
            if (empty($baseSlug)) {
                $baseSlug = 'product';
            }

            $slug = $baseSlug;
            $counter = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $product = new Product();
            $product->title = $validated['title'];
            $product->en_title = $validated['en_title'] ?? null;
            $product->sub_title = $validated['sub_title'] ?? null;
            $product->slug = $slug;

            $product->item1 = $validated['item1'] ?? null;
            $product->item2 = $validated['item2'] ?? null;
            $product->item3 = $validated['item3'] ?? null;
            $product->item4 = $validated['item4'] ?? null;
            $product->item5 = $validated['item5'] ?? null;

            $product->price = (string) ((int) ($validated['price'] ?? 0));
            $product->product_type = $validated['product_type'];
            $productUseInput = $request->input('product_use');
            if (is_string($productUseInput) && $productUseInput !== '') {
                $productUseInput = [$productUseInput];
            }
            $product->product_use = is_array($productUseInput) && !empty($productUseInput)
                ? implode('، ', $productUseInput)
                : null;
            $product->product_time = $validated['product_time'] ?? null;
            $product->start_date = $validated['start_date'] ?? null;
            $product->end_date = $validated['end_date'] ?? null;
            $product->exp_date = $validated['exp_date'] ?? null;
            $product->certificate = ($validated['certificate'] ?? 'ندارد') === 'دارد' ? 1 : 0;
            $product->price_certificate = isset($validated['price_certificate']) ? (string) ((int) $validated['price_certificate']) : null;
            $product->description = $validated['description'] ?? null;
            $product->full_description = $validated['full_description'] ?? null;
            $product->status = (int) $validated['status'];
            $product->user_id = Auth::id();

            $result = $product->save();

            if ($result === true) {
                $success = true;
                $flag = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات با موفقیت ثبت شد';
            } else {
                $success = false;
                $flag = 'error';
                $subject = 'عملیات ناموفق';
                $message = 'اطلاعات ثبت نشد، لطفا مجددا تلاش نمایید';
            }
        } catch (Exception $e) {
            $success = false;
            $flag = 'error';
            $subject = 'خطا در ارتباط با سرور';
            $message = 'اطلاعات ثبت نشد، لطفا بعدا مجدد تلاش نمایید';
        }

        return response()->json([
            'success' => $success,
            'subject' => $subject,
            'flag' => $flag,
            'message' => $message
        ]);
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
