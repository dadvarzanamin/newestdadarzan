<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{

    public function run(): void
    {

        $roles = [
            [1, 'ادمین'         , 'superadmin' , 4 ],
            [2, 'مدیر'          , 'manager'    , 4 ],
            [3, 'کارشناس ارشد'  , 'senior'     , 4 ],
            [4, 'کارشناس'       , 'expert'     , 4 ],
        ];

        DB::table('roles')->insert(
            array_map(fn($c) => [
                'id'         => $c[0],
                'title_fa'   => $c[1],
                'title'      => $c[2],
                'status'     => $c[3],
                'created_at' => now(),
                'updated_at' => now(),
            ], $roles));


    }
}
