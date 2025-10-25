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

class SubmenupanelController extends Controller
{
    public function index(Request $request)
    {
        $thispage       = [
            'title'   => 'مدیریت زیرمنو داشبورد',
            'list'    => 'لیست زیرمنو داشبورد',
            'add'     => 'افزودن زیرمنو داشبورد',
            'create'  => 'ایجاد زیرمنو داشبورد',
            'enter'   => 'ورود زیرمنو داشبورد',
            'edit'    => 'ویرایش زیرمنو داشبورد',
            'delete'  => 'حذف زیرمنو داشبورد',
        ];

        if ($request->ajax()) {
            $data = Submenu::leftjoin('menus' , 'menus.id' , '=' , 'submenus.menu_id')
                ->select('menus.label as menu','submenus.id','submenus.title','submenus.label','submenus.slug','submenus.status','submenus.class','submenus.controller')
                ->where('submenus.type' , 'panel')
                ->get();
            return Datatables::of($data)
                ->addColumn('id', function ($data) {
                    return ($data->id);
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
                ->addColumn('menu', function ($data) {
                    return ($data->menu);
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
                    if (auth()->user()->can('can-access', ['submenupanel', 'edit'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-outline-primary edit-btn" data-id="'.$data->id.'" data-url="'.route('submenupanel.edit', $data->id).'"><i class="mdi mdi-pencil-outline"></i></button>';
                    }
                    if (auth()->user()->can('can-access', ['submenupanel', 'delete'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-icon btn-outline-danger mx-1 delete-btn" data-id="'.$data->id.'"><i class="mdi mdi-delete-outline"></i></button>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('panel.submenupanel')->with(compact(['thispage']));
    }

    public function store(Request $request)
    {
        try {
            $priority      = Submenu::max('priority');
            $submenu_panel = new Submenu();
            $submenu_panel->title        = $request->input('title');
            $submenu_panel->label        = $request->input('label');
            $submenu_panel->menu_id      = $request->input('menupanel_id');
            $submenu_panel->type         = 'panel';
            $submenu_panel->class        = $request->input('class');
            $submenu_panel->controller   = $request->input('controller');
            $submenu_panel->user_id      = Auth::user()->id;
            $submenu_panel->priority     = $priority + 1;
            $submenu_panel->status       = $request->input('status');
            $result1 = $submenu_panel->save();

            $permission = new Permission();
            $permission->title              = $request->input('title');
            $permission->label              = $request->input('label');
            $permission->submenu_panel_id   = $submenu_panel->id;
            $permission->menu_panel_id      = $request->input('menupanel_id');
            $permission->user_id            = Auth::user()->id;

            $result2 = $permission->save();

            if ($result1 == true  && $result2 == true) {
                $success = true;
                $flag    = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات زیرمنو با موفقیت ثبت شد';
            }
            elseif($result1 == true  && $result2 != true) {
                $success = false;
                $flag    = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات دسترسی ثبت نشد، لطفا مجددا تلاش نمایید';
            }
            elseif($result1 != true  && $result2 != true) {
                $success = false;
                $flag    = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات زیرمنو ثبت نشد، لطفا مجددا تلاش نمایید';
            }

        } catch (Exception $e) {

            $success = false;
            $flag    = 'error';
            $subject = 'خطا در ارتباط با سرور';
            //$message = strchr($e);
            $message = 'اطلاعات زیرمنو ثبت نشد،لطفا بعدا مجدد تلاش نمایید ';
        }


        return response()->json(['success'=>$success , 'subject' => $subject, 'flag' => $flag, 'message' => $message]);

//        return redirect(route('menudashboards.index'));

    }

    public function edit($id)
    {
        $menupanels    = Menu::all();
        $submenupanel  = Submenu::whereId($id)->first();

        return view('panel.partials.edit-form-submenupanel', compact('menupanels', 'submenupanel'));
    }

    public function update(Request $request , $id)
    {

        $submenu_panel = Submenu::findOrfail($id);
        $submenu_panel->title        = $request->input('title');
        $submenu_panel->label        = $request->input('label');
        $submenu_panel->menu_id      = $request->input('menupanel_id');
        $submenu_panel->class        = $request->input('class');
        $submenu_panel->controller   = $request->input('controller');
        $submenu_panel->user_id      = Auth::user()->id;
        $submenu_panel->status       = $request->input('status');

        $result = $submenu_panel->update();
        try{
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
        try {
            $submenu = Submenu::findOrfail($id);
            $result1 = $submenu->delete();

            $permission = Permission::whereSubmenu_panel_id($id)->first();
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
                $message = 'اطلاعات زیرمنو ثبت نشد، لطفا مجددا تلاش نمایید';
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
