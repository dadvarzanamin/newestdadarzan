<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $submenus = [
            ['id' => 1, 'priority' => 1, 'label' => 'مدیریت منو داشبورد'    , 'title'  => 'menupanel'    , 'slug' => 'menupanel'    , 'menu_id' => 2, 'class' => 'index' , 'type'  => 'panel' , 'controller' => 'SubmenupanelController' , 'status'  => 4, 'user_id'  => 1,],
            ['id' => 2, 'priority' => 2, 'label' => 'مدیریت زیرمنو داشبورد' , 'title'  => 'submenupanel' , 'slug' => 'submenupanel' , 'menu_id' => 2, 'class' => 'index' , 'type'  => 'panel' , 'controller' => 'SubmenupanelController' , 'status'  => 4, 'user_id'  => 1,],
            ['id' => 3, 'priority' => 3, 'label' => 'مدیریت نقش کاربران'    , 'title'  => 'roleuser'     , 'slug' => 'roleuser'     , 'menu_id' => 3, 'class' => 'index' , 'type'  => 'panel' , 'controller' => 'RoleuserController'     , 'status'  => 4, 'user_id'  => 1,],
        ];

        foreach ($submenus as $submenu) {
            $submenuId = DB::table('submenus')->insertGetId(array_merge($submenu, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            $permission = Permission::create([
                'title'             => $submenu['title'],
                'label'             => $submenu['label'],
                'slug'              => $submenu['slug'],
                'menu_panel_id'     => $submenu['menu_id'],
                'submenu_panel_id'  => $submenuId,
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
