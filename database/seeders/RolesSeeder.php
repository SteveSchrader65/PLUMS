<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Seed the Roles for user access
     *
     * @return void
     */
    public function run(): void
    {
        $roles = [
            ['name'=>'admin',],
            ['name'=>'manager',],
            ['name'=>'user',],
            ['name'=>'guest',],
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
