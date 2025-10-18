<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ['create', 'edit', 'view', 'delete'];
        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }
    }
}
