<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            ['id' => 1, 'priority' => 1, 'label' => 'داشبورد'        , 'title'  => 'dashboard'       , 'slug' => 'dashboard'        ,'icon' => 'mdi-view-dashboard'     , 'submenu' => 0, 'class'  => 'index', 'type'  => 'panel', 'controller' => 'IndexController'    , 'status'  => 4, 'user_id'  => 1,],
            ['id' => 2, 'priority' => 2, 'label' => 'مدیریت داشبورد' , 'title'  => 'dashboard manage', 'slug' => 'dashboard-manage' ,'icon' => 'mdi-monitor-dashboard'  , 'submenu' => 1, 'class'  => 'panel', 'type'  => 'panel', 'controller' => 'IndexController'    , 'status'  => 4, 'user_id'  => 1,],
            ['id' => 3, 'priority' => 3, 'label' => 'مدیریت کاربران' , 'title'  => 'user manage'     , 'slug' => 'user-manage'      ,'icon' => 'mdi-account-group'      , 'submenu' => 1, 'class'  => 'index', 'type'  => 'panel', 'controller' => 'UserController'     , 'status'  => 4, 'user_id'  => 1,],
            ['id' => 4, 'priority' => 4, 'label' => 'مدیریت سایت'    , 'title'  => 'site manage'     , 'slug' => 'site-manage'      ,'icon' => 'mdi-web-refresh'        , 'submenu' => 1, 'class'  => 'index', 'type'  => 'panel', 'controller' => 'SiteController'     , 'status'  => 4, 'user_id'  => 1,],
            ['id' => 5, 'priority' => 5, 'label' => 'مدیریت فایل‌ها'  , 'title'  => 'file manage'     , 'slug' => 'file-manage'      ,'icon' => 'mdi-file-chart'         , 'submenu' => 1, 'class'  => 'index', 'type'  => 'panel', 'controller' => 'FileController'     , 'status'  => 4, 'user_id'  => 1,],
            ['id' => 6, 'priority' => 6, 'label' => 'مدیریت تنظیمات' , 'title'  => 'config manage'   , 'slug' => 'config-manage'    ,'icon' => 'mdi-cog'                , 'submenu' => 0, 'class'  => 'index', 'type'  => 'panel', 'controller' => 'SettingController'  , 'status'  => 4, 'user_id'  => 1,],
            ['id' => 7, 'priority' => 7, 'label' => 'پروفایل کاربری' , 'title'  => 'profile'         , 'slug' => 'profile'          ,'icon' => 'mdi-account-circle'     , 'submenu' => 0, 'class'  => 'index', 'type'  => 'panel', 'controller' => 'ProfileController'  , 'status'  => 4, 'user_id'  => 1,],
        ];

        foreach ($menus as $menu) {
            $menuId = DB::table('menus')->insertGetId(array_merge($menu, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            $permission = Permission::create([
                'title'          => $menu['title'],
                'label'          => $menu['label'],
                'slug'           => $menu['slug'],
                'menu_panel_id'  => $menuId,
                'user_id'        => 1,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            DB::table('permission_role')->insert([
                'role_id'       => 1,
                'permission_id' => $permission->id,
                'can_view'      => 1,
                'can_insert'    => 1,
                'can_edit'      => 1,
                'can_delete'    => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
