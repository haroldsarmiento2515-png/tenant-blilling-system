<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@tenantbill.com',
            'password' => Hash::make('admin123'),
            'phone' => '09123456789',
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        Admin::create([
            'name' => 'Staff Admin',
            'email' => 'staff@tenantbill.com',
            'password' => Hash::make('staff123'),
            'phone' => '09987654321',
            'role' => 'staff',
            'is_active' => true,
        ]);
    }
}