<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Offer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::select('id' , 'title')->get();
        $users    = User::select('id' , 'name')->get();
        $thispage       = [
            'title'   => 'مدیریت تخفیف',
            'list'    => 'لیست تخفیف',
            'add'     => 'افزودن تخفیف',
            'create'  => 'ایجاد تخفیف',
            'enter'   => 'ورود تخفیف',
            'edit'    => 'ویرایش تخفیف',
            'delete'  => 'حذف تخفیف',
        ];

        if ($request->ajax()) {
            $data = DB::table('offers')
                ->leftJoin('products' ,'offers.product_id' ,'=' , 'products.id')
                ->leftJoin('users' ,'offers.user_offer' ,'=' , 'users.id')
                ->select('products.title' , 'offers.id' , 'offers.discount' , 'offers.percentage' , 'offers.status' , 'offers.offercode' , 'users.name' , 'offers.user_offer')->get();

            return Datatables::of($data)

                ->addColumn('id', function ($data) {
                    return ($data->id);
                })
                ->addColumn('title', function ($data) {
                    return ($data->title);
                })
                ->addColumn('discount', function ($data) {
                    return (number_format((int)$data->discount) . ' تومان ');
                })
                ->addColumn('percentage', function ($data) {
                    return ((int)$data->percentage . ' % ');
                })
                ->addColumn('offercode', function ($data) {
                    return ($data->offercode);
                })
                ->addColumn('name', function ($data) {
                    if($data->user_offer == null){
                        return "همه کاربران";
                    }else {
                        return ($data->name);
                    }
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
                    if (auth()->user()->can('can-access', ['offer', 'edit'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-outline-primary edit-btn" data-id="'.$data->id.'" data-url="'.route('offer.edit', $data->id).'"><i class="mdi mdi-pencil-outline"></i></button>';
                    }
                    if (auth()->user()->can('can-access', ['offer', 'delete'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-icon btn-outline-danger mx-1 delete-btn" data-id="'.$data->id.'"><i class="mdi mdi-delete-outline"></i></button>';
                    }
                    return $actionBtn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('panel.offer')->with(compact(['thispage' , 'products' , 'users']));
    }

    public function store(Request $request)
    {

            $offers = new Offer();
            $offers->user_offer   = $request->input('user_offer');
            $offers->product_id   = $request->input('product_id');
            $offers->discount     = $request->input('discount');
            $offers->percentage   = $request->input('percentage');
            $offers->status       = $request->input('status');
            $offers->user_id      = Auth::user()->id;

            $characters = '0123456789abcdefghijklmnopqrstuvwxyz%';
            $randomCode = '';
            $length = 8;
            for ($i = 0; $i < $length; $i++) {
                $randomIndex = rand(0, strlen($characters) - 1);
                $randomCode .= $characters[$randomIndex];
            }

            $offers->offercode         = $randomCode;

            $result = $offers->save();

            if ($result == true) {
                $success = true;
                $flag    = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات با موفقیت ثبت شد';
            }
            else {
                $success = false;
                $flag    = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات ثبت نشد، لطفا مجددا تلاش نمایید';
            }
            try{
        } catch (Exception $e) {

            $success = false;
            $flag    = 'error';
            $subject = 'خطا در ارتباط با سرور';
            //$message = strchr($e);
            $message = 'اطلاعات ثبت نشد،لطفا بعدا مجدد تلاش نمایید ';
        }

        return response()->json(['success'=>$success , 'subject' => $subject, 'flag' => $flag, 'message' => $message]);
    }

    public function edit($id)
    {
        $offer   = Offer::whereId($id)->first();
        $products = Product::select('id' , 'title')->get();
        $users    = User::select('id' , 'name')->get();

        return view('panel.partials.edit-form-offer', compact('offer','products' , 'users'));

    }

    public function update(Request $request , $id)
    {
        try{
            $offers = Offer::whereId($id)->first();
            $offers->user_id        = Auth::user()->id;
            $offers->user_offer     = $request->input('user_offer');
            $offers->product_id     = $request->input('product_id');
            $offers->discount       = $request->input('discount');
            $offers->percentage     = $request->input('percentage');
            $offers->status         = $request->input('status');

            $result = $offers->save();

            if ($result == true) {
                $success = true;
                $flag = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات با موفقیت ذخیره شد';

            }else {
                $success = false;
                $flag    = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات ثبت نشد، لطفا مجددا تلاش نمایید';
            }

        } catch (Exception $e) {

            $success = false;
            $flag    = 'error';
            $subject = 'خطا در ارتباط با سرور';
            $message = 'اطلاعات ذخیره نشد،لطفا بعدا مجدد تلاش نمایید ';
        }

        return response()->json(['success'=>$success , 'subject' => $subject, 'flag' => $flag, 'message' => $message]);

    }

    public function destroy($id)
    {
        try {
            $offer = Offer::findOrfail($id);
            $result1 = $offer->delete();
            if ($result1 == true) {
                $success = true;
                $flag = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات با موفقیت پاک شد';

            }else {
                $success = false;
                $flag    = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات منو ثبت نشد، لطفا مجددا تلاش نمایید';
            }

        } catch (Exception $e) {

            $success = false;
            $flag    = 'error';
            $subject = 'خطا در ارتباط با سرور';
            $message = 'اطلاعات پاک نشد،لطفا بعدا مجدد تلاش نمایید ';
        }

        return response()->json(['success'=>$success , 'subject' => $subject, 'flag' => $flag, 'message' => $message]);
    }
}
