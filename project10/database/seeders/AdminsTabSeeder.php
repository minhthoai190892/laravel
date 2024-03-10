<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Admin;
use Hash;

class AdminsTabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //tạo mật khẩu
        $password = Hash::make('123456');
        // tạo hồ sơ quản trị
        $adminRecords = [
            [
                'email' => 'admin@admin.com',
                'id' => 4,
                'image' => '',
                'mobile ' => 54545678,
                'name' => 'Admin',
                'password' => $password,
                'status' => 1,
                'type' => 'admin',
            ],

        ];
        // thêm vào admin vào bảng Admins -> qua
        Admin::insert($adminRecords);
    }
}
