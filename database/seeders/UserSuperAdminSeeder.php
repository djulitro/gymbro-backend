<?php

namespace Database\Seeders;

use App\Constants\UserTypeConst;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();

        $user->organization_id = 1;
        $user->name = 'Super Admin';
        $user->last_name = 'Admin';
        $user->email = 'superadmin@admin.cl';
        $user->password = Hash::make('Admin2025.,');
        $user->phone = '12345678';
        $user->direction = 'Calle Falsa 123';
        $user->user_type_id = UserTypeConst::SUPER_ADMIN;

        $user->save();
    }
}
