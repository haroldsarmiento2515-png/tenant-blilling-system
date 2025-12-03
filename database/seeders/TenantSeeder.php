<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::create([
            'name' => 'ABC Company',
            'email' => 'abc@example.com',
            'phone' => '123-456-7890',
            'address' => '123 Main St, City, State 12345',
            'company_name' => 'ABC Company LLC',
        ]);
        
        Tenant::create([
            'name' => 'XYZ Corporation',
            'email' => 'xyz@example.com',
            'phone' => '098-765-4321',
            'address' => '456 Oak Ave, Town, State 67890',
            'company_name' => 'XYZ Corporation Inc',
        ]);
    }
}