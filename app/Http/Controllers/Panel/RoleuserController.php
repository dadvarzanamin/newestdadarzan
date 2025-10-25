<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuPanel;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Submenu;
use App\Models\SubmenuPanel;
use App\Models\TypeUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class RoleuserController extends Controller
{
    public function index(Request $request)
    {
        $roles          = Role::all();
        $permissions    = Permission::all();
        $thispage       = [
            'title'   => 'مدیریت  نقش ',
            'list'    => 'لیست  نقش ',
            'add'     => 'افزودن  نقش ',
            'create'  => 'ایجاد  نقش ',
            'enter'   => 'ورود  نقش ',
            'edit'    => 'ویرایش  نقش ',
            'delete'  => 'حذف  نقش ',
        ];

        if ($request->ajax()) {
            $data = Role::all();

            return Datatables::of($data)
                ->addColumn('title_fa', function ($data) {
                    return ($data->title_fa);
                })
                ->addColumn('title', function ($data) {
                    return ($data->title);
                })
                ->editColumn('permission', function ($data) {
                    $permis = '';
                    foreach(Permission::latest()->get() as $permission)
                    {
                        if (in_array(trim($permission->id), $data->permissions->pluck('id')->toArray()) ? 'selected' : '')
                            $permis .= ' | '. $permission->slug ;
                    }
                    return $permis;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == "0") {
                        return "غیر فعال";
                    } elseif ($data->status == "4") {
                        return "فعال";
                    }
                })
                ->editColumn('action', function ($data) {
                    $actionBtn = '';
                    if (Gate::allows('can-access', ['roleuser', 'edit'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-outline-primary edit-btn" data-id="'.$data->id.'" data-url="'.route('roleuser.edit', $data->id).'"><i class="mdi mdi-pencil-outline"></i></button>';
                    }
                    if (Gate::allows('can-access', ['roleuser', 'delete'])) {
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-icon btn-outline-danger mx-1 delete-btn" data-id="'.$data->id.'"><i class="mdi mdi-delete-outline"></i></button>';
                    }
                        $actionBtn .= '<button type="button" class="btn btn-sm btn-outline-danger edit-btn" data-id="'.$data->id.'" data-url="'.route('roleuser.show', $data->id).'"><i class="mdi mdi-access-point"></i></button>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('panel.roleuser')->with(compact(['thispage' , 'roles' , 'permissions']));
    }

    public function store(Request $request)
    {
        try {

            $role = new Role();
            $role->title_fa     = $request->input('title_fa');
            $role->title        = $request->input('title');
            $role->status       = $request->input('status');
            $role->user_id      = Auth::user()->id;

            $result1 = $role->save();

            if ($result1 == true) {
                $success = true;
                $flag    = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات منو با موفقیت ثبت شد';
            }
            elseif($result1 == true) {
                $success = false;
                $flag    = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات دسترسی ثبت نشد، لطفا مجددا تلاش نمایید';
            }
            elseif($result1 != true) {
                $success = false;
                $flag    = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات منو ثبت نشد، لطفا مجددا تلاش نمایید';
            }

        } catch (Exception $e) {

            $success = false;
            $flag    = 'error';
            $subject = 'خطا در ارتباط با سرور';
            //$message = strchr($e);
            $message = 'اطلاعات منو ثبت نشد،لطفا بعدا مجدد تلاش نمایید ';
        }

        return response()->json(['success'=>$success , 'subject' => $subject, 'flag' => $flag, 'message' => $message]);

    }

    public function show($id)
    {
        $role    = Role::find($id);

        return view('panel.partials.edit-form-rolepermission', compact('role'));
    }

    public function edit($id)
    {
        $role    = Role::find($id);

        return view('panel.partials.edit-form-roleuser', compact('role'));
    }

    public function update(Request $request , $id)
    {
        if ($request->input('type') === 'permission_update') {
            // این درخواست مربوط به ویرایش دسترسی‌هاست
            $role = Role::findOrFail($request->input('role_id'));

            $permissions = $request->input('permissions', []);

            foreach ($permissions as $permissionId => $actions) {
                $role->permissions()->updateExistingPivot($permissionId, [
                    'can_view'   => isset($actions['can_view']),
                    'can_insert' => isset($actions['can_insert']),
                    'can_edit'   => isset($actions['can_edit']),
                    'can_delete' => isset($actions['can_delete']),
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'دسترسی‌ها با موفقیت به‌روزرسانی شدند.',
            ]);
        }

        $role = Role::findOrfail($id);
        $role->title_fa     = $request->input('title_fa');
        $role->title        = $request->input('title');
        $role->status       = $request->input('status');
        $result = $role->update();
        $role->permissions()->sync($request->input('permission_id'));

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
            $role = Role::findOrfail($id);
            $result1 = $role->delete();

            if ($result1 == true) {
                $success = true;
                $flag = 'success';
                $subject = 'عملیات موفق';
                $message = 'اطلاعات با موفقیت پاک شد';
            }elseif($result1 == true) {
                $success = false;
                $flag    = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'اطلاعات دسترسی ثبت نشد، لطفا مجددا تلاش نمایید';
            }
            elseif($result1 != true) {
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
