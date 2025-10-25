<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\Submenu;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MenusiteController extends Controller
{
    public function index(Request $request)
    {
        $thispage       = [
            'title'   => 'مدیریت منو سایت',
            'list'    => 'لیست منو سایت',
            'add'     => 'افزودن منو سایت',
            'create'  => 'ایجاد منو سایت',
            'enter'   => 'ورود منو سایت',
            'edit'    => 'ویرایش منو سایت',
            'delete'  => 'حذف منو سایت',
        ];

        if ($request->ajax()) {
            $data = Menu::select('id' ,'priority', 'title','label', 'slug', 'status' , 'class' , 'controller')->where('type' , 'site')->orderBy('priority')->get();

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
                    if (auth()->user()->can('can-access', ['menusite', 'edit'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-outline-primary edit-btn" data-id="'.$data->id.'" data-url="'.route('menusite.edit', $data->id).'"><i class="mdi mdi-pencil-outline"></i></button>';
                    }
                    if (auth()->user()->can('can-access', ['menusite', 'delete'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-icon btn-outline-danger mx-1 delete-btn" data-id="'.$data->id.'"><i class="mdi mdi-delete-outline"></i></button>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('panel.menusite')->with(compact(['thispage']));
    }

    public function store(Request $request)
    {
        try {
            $priority = Menu::max('priority');
            $menu_site = new Menu();
            $menu_site->title        = $request->input('title');
            $menu_site->label        = $request->input('label');
            $menu_site->type         = 'site';
            $menu_site->Submenu      = $request->input('Submenu');
            $menu_site->class        = $request->input('class');
            $menu_site->controller   = $request->input('controller');
            $menu_site->user_id      = 1;
            $menu_site->status       = $request->input('status');
            $menu_site->priority     = $priority + 1;

            $result1 = $menu_site->save();

            if ($result1 == true) {
                $success = true;
                $flag    = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات منو با موفقیت ثبت شد';
            }elseif($result1 != true) {
                $success = false;
                $flag    = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات منو ثبت نشد، لطفا مجددا تلاش نمایید';
            }
        } catch (Exception $e) {

            $success = false;
            $flag    = 'error';
            $subject = 'خطا در ارتباط با سرور';
            $message = 'اطلاعات منو ثبت نشد،لطفا بعدا مجدد تلاش نمایید ';
        }

        return response()->json(['success'=>$success , 'subject' => $subject, 'flag' => $flag, 'message' => $message]);

    }

    public function edit($id)
    {
        $menusite       = Menu::whereId($id)->first();
        $submenusites   = Submenu::all();

        return view('panel.partials.edit-form-menusite', compact('menusite', 'submenusites'));
    }

    public function update(Request $request , $id)
    {
        try{
            $menu_site = Menu::findOrfail($id);
            $menu_site->title        = $request->input('title');
            $menu_site->label        = $request->input('label');
            $menu_site->submenu      = $request->input('submenu');
            $menu_site->class        = $request->input('class');
            $menu_site->controller   = $request->input('controller');
            $menu_site->user_id      = Auth::user()->id;
            $menu_site->status       = $request->input('status');

            $result = $menu_site->update();

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
            $message = 'اطلاعات ثبت نشد،لطفا بعدا مجدد تلاش نمایید ';
        }

        return response()->json(['success'=>$success , 'subject' => $subject, 'flag' => $flag, 'message' => $message]);
    }

    public function destroy($id)
    {
        try {
            $menu = Menu::findOrfail($id);
            $result1 = $menu->delete();

            $permission = Permission::whereMenu_panel_id($id)->first();
            $result2 = $permission->delete();


            if ($result1 == true  && $result2 == true) {
                $success = true;
                $flag = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات با موفقیت پاک شد';
            }elseif($result1 == true  && $result2 != true) {
                $success = false;
                $flag    = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات دسترسی ثبت نشد، لطفا مجددا تلاش نمایید';
            }
            elseif($result1 != true  && $result2 != true) {
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
