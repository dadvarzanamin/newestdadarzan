<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Menu_panel;
use App\Models\Dashboard\Submenu_panel;
use App\Models\Emploee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class EmploeeController extends Controller
{
    public function index(Request $request)
    {

        $thispage       = [
            'title'   => 'مدیریت  اعضا',
            'list'    => 'لیست  اعضا',
            'add'     => 'افزودن  اعضا',
            'create'  => 'ایجاد  اعضا',
            'enter'   => 'ورود  اعضا',
            'edit'    => 'ویرایش  اعضا',
            'delete'  => 'حذف  اعضا',
        ];

        if ($request->ajax()) {
            $data = Emploee::select('id' , 'fullname', 'image', 'side' , 'status', 'priority')->get();

            return Datatables::of($data)
                ->addColumn('fullname', function ($data) {
                    return ($data->fullname);
                })
                ->addColumn('side', function ($data) {
                    return ($data->side);
                })
                ->addColumn('priority', function ($data) {
                    return ($data->priority);
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
                ->addColumn('image', function ($data) {
                    return '<img src="' . asset('storage/' .$data->image) . '"  width="100" class="img-rounded" align="center" />';
                })
                ->editColumn('action', function ($data) {

                    $actionBtn = '';
                    if (auth()->user()->can('can-access', ['emploee', 'edit'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-outline-primary edit-btn" data-id="'.$data->id.'" data-url="'.route('emploee.edit', $data->id).'"><i class="mdi mdi-pencil-outline"></i></button>';
                    }
                    if (auth()->user()->can('can-access', ['emploee', 'delete'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-icon btn-outline-danger mx-1 delete-btn" data-id="'.$data->id.'"><i class="mdi mdi-delete-outline"></i></button>';
                    }
                    $actionBtn .= '<button class="btn btn-sm btn-icon btn-image mx-1 upload-btn" data-id="'.$data->id.'"><i class="mdi mdi-file-document-multiple-outline"></i></button>';

                    return $actionBtn;
                })
                ->rawColumns(['action' , 'image'])
                ->make(true);
        }
        return view('panel.emploee')->with(compact(['thispage']));

    }

    public function store(Request $request)
    {
        try{

            $priority = Emploee::max('id');

            $emploees = new Emploee();

            $emploees->fullname    = $request->input('fullname');
            $emploees->side        = $request->input('side');
            $emploees->phone       = $request->input('phone');
            $emploees->priority    = $priority + 1;
            $emploees->whatsapp    = $request->input('whatsapp');
            $emploees->instagram   = $request->input('instagram');
            $emploees->twitter     = $request->input('twitter');
            $emploees->status      = $request->input('status');
            $emploees->description = $request->input('description');
            if($request->input('positions')) {
                $emploees->positions = json_encode(explode("،", $request->input('positions')));
            }
            $result       = $emploees->save();

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
        $emploee = Emploee::find($id);

        return view('panel.partials.edit-form-emploee', compact('emploee'));

    }

    public function update(Request $request , $id)
    {
        try{
            $emploees = Emploee::find($id);
            $emploees->fullname    = $request->input('fullname');
            $emploees->side        = $request->input('side');
            $emploees->phone       = $request->input('phone');
            $emploees->priority    = $request->input('priority');
            $emploees->whatsapp    = $request->input('whatsapp');
            $emploees->instagram   = $request->input('instagram');
            $emploees->twitter     = $request->input('twitter');
            $emploees->status      = $request->input('status');
            $emploees->description = $request->input('description');
            if($request->input('positions')) {
                $emploees->positions = json_encode(explode("،", $request->input('positions')));
            }
            $result = $emploees->update();
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

            } catch (Exception $e) {

                $success = false;
                $flag    = 'error';
                $subject = 'خطا در ارتباط با سرور';
                //$message = strchr($e);
                $message = 'اطلاعات ثبت نشد،لطفا بعدا مجدد تلاش نمایید ';
            }

            return response()->json(['success'=>$success , 'subject' => $subject, 'flag' => $flag, 'message' => $message]);
    }

    public function destroy($id)
    {
        try{
            $emploees = Emploee::findorfail($id);
            $result = $emploees->delete();
            if ($result == true) {
                $success = true;
                $flag    = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات با موفقیت پاک شد';
            }else{
                $success = false;
                $flag    = 'error';
                $subject = 'عملیات ناموفق';
                $message = 'اطلاعات پاک نشد، لطفا مجددا تلاش نمایید';
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
