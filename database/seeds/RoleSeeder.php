<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role;
        $role->RoleName = 'Administrator';
        $role->RoleDescription = 'Super User';
        $role->save();

        $role = new Role;
        $role->RoleName = 'User';
        $role->RoleDescription = 'Add Expenses';
        $role->save();
    }
}
