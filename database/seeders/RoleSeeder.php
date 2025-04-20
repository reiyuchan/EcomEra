<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $roles = ['admin', 'mod', 'designer', 'user'];
        // foreach ($roles as $role) {
        //     Role::firstOrCreate(['name' => $role]);
        // }
        Role::insert([
            ['name' => 'admin'],
            ['name' => 'mod'],
            ['name' => 'designer'],
            ['name' => 'user'],
        ]);
    }
}
